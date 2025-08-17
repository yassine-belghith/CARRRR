<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RentalVoucherMail;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['user', 'car', 'driver'])->latest()->paginate(10);
        return view('dashboard.rentals.index', compact('rentals'));
    }

    public function create()
    {
        $cars = Car::where('availability', 1)->get();
        $users = User::where('role', 'user')->get();
        $drivers = User::where('role', 'driver')->get();
        $rental = new Rental();
        return view('dashboard.rentals.create', compact('cars', 'users', 'rental', 'drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'driver_id' => 'nullable|exists:users,id',
            'rental_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:rental_date',
            'status' => 'required|in:pending,approved,completed,cancelled',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        if (!$this->checkCarAvailability($validated['car_id'], $validated['rental_date'], $validated['return_date'])) {
            return back()->with('error', 'La voiture n\'est pas disponible pour les dates sélectionnées.')->withInput();
        }

        $rental = Rental::create($validated);

        if ($validated['status'] === 'approved') {
            $car = Car::findOrFail($validated['car_id']);
            $car->update(['availability' => 0]);
        }

        return redirect()->route('dashboard.rentals.index')
            ->with('success', 'Location créée avec succès!');
    }

    public function show(Rental $rental)
    {
        return view('dashboard.rentals.show', compact('rental'));
    }

    public function edit(Rental $rental)
    {
        $cars = Car::where('availability', 1)->orWhere('id', $rental->car_id)->get();
        $users = User::where('role', 'user')->get();
        $drivers = User::where('role', 'driver')->get();
        return view('dashboard.rentals.edit', compact('rental', 'cars', 'users', 'drivers'));
    }

    public function update(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'driver_id' => 'nullable|exists:users,id',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after:rental_date',
            'status' => 'required|in:pending,approved,completed,cancelled',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $datesChanged = $rental->rental_date != $validated['rental_date'] || $rental->return_date != $validated['return_date'];
        $carChanged = $rental->car_id != $validated['car_id'];

        if (($datesChanged || $carChanged) && !$this->checkCarAvailability($validated['car_id'], $validated['rental_date'], $validated['return_date'], $rental->id)) {
            return back()->with('error', 'La voiture n\'est pas disponible pour les dates sélectionnées.')->withInput();
        }

        $rental->update($validated);

        $car = $rental->car;
        if ($validated['status'] === 'approved' || $validated['status'] === 'ongoing') {
            $car->update(['availability' => 0]);
        } elseif (in_array($validated['status'], ['completed', 'cancelled'])) {
            $car->update(['availability' => 1]);
        }

        return redirect()->route('dashboard.rentals.index')->with('success', 'Location mise à jour avec succès!');
    }

    public function userStore(Request $request, Car $car)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        if (!$this->checkCarAvailability($car->id, $validated['start_date'], $validated['end_date'])) {
            return back()->with('error', 'Désolé, cette voiture n\'est pas disponible pour les dates que vous avez sélectionnées. Veuillez choisir une autre période.')
                         ->withInput();
        }

        $rentalDate = Carbon::parse($validated['start_date']);
        $returnDate = Carbon::parse($validated['end_date']);
        $days = $returnDate->diffInDays($rentalDate);
        $totalPrice = $days * $car->price_per_day;

        $rental = Rental::create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'rental_date' => $validated['start_date'],
            'return_date' => $validated['end_date'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('cars.detail', ['car' => $car])
                         ->with('success', 'Votre demande de réservation a été envoyée avec succès! Nous vous contacterons bientôt pour la confirmation.');
    }

    public function updateStatus(Request $request, Rental $rental, $status)
    {
        $validatedStatus = in_array($status, ['approved', 'cancelled', 'completed']) ? $status : 'pending';

        $rental->status = $validatedStatus;
        $rental->save();

        return redirect()->route('dashboard.rentals.index')->with('success', 'Le statut de la location a été mis à jour.');
    }

    public function destroy(Rental $rental)
    {
        $car = $rental->car;
        if ($car) {
            $car->update(['availability' => 1]);
        }
        $rental->delete();
        return redirect()->route('dashboard.rentals.index')
            ->with('success', 'Location supprimée avec succès!');
    }

    private function checkCarAvailability($carId, $startDate, $endDate, $exceptRentalId = null)
    {
        $query = Rental::where('car_id', $carId)
            ->where('status', '!=', 'cancelled')
            ->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('rental_date', [$startDate, $endDate])
                  ->orWhereBetween('return_date', [$startDate, $endDate])
                  ->orWhere(function($q) use ($startDate, $endDate) {
                      $q->where('rental_date', '<=', $startDate)
                        ->where('return_date', '>=', $endDate);
                  });
            });

        if ($exceptRentalId) {
            $query->where('id', '!=', $exceptRentalId);
        }

        return $query->doesntExist();
    }
}
