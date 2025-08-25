<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Location;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RentalVoucherMail;
use App\Mail\RentalApproved;
use App\Mail\LocationApproved;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['user', 'car', 'driver'])->latest()->paginate(10);
        return view('dashboard.rentals.index', compact('rentals'));
    }

    /**
     * Return available drivers for a given period.
     * GET params: rental_date (Y-m-d), return_date (Y-m-d), rental_id (optional)
     */
    public function availableDrivers(Request $request)
    {
        $validated = $request->validate([
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rental_date',
            'location_id' => 'nullable|exists:locations,id',
            'rental_id' => 'nullable|integer',
        ]);

        $start = Carbon::parse($validated['rental_date'])->startOfDay();
        $end = Carbon::parse($validated['return_date'])->endOfDay();
        Log::info('availableDrivers request', [
            'rental_date' => $start->toDateTimeString(),
            'return_date' => $end->toDateTimeString(),
            'rental_id' => $request->input('rental_id')
        ]);
        $excludeRentalId = $validated['rental_id'] ?? null;
        $locationId = $validated['location_id'] ?? null;

        // Get IDs of drivers busy in overlapping rentals (approved or ongoing)
        $busyDriverIds = Rental::query()
            ->when($excludeRentalId, fn($q) => $q->where('id', '!=', $excludeRentalId))
            ->whereNotNull('driver_id')
            ->whereIn('status', ['approved', 'ongoing'])
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('rental_date', [$start, $end])
                  ->orWhereBetween('return_date', [$start, $end])
                  ->orWhere(function ($qq) use ($start, $end) {
                      $qq->where('rental_date', '<=', $start)
                         ->where('return_date', '>=', $end);
                  });
            })
            ->pluck('driver_id')
            ->unique()
            ->toArray();
        Log::info('availableDrivers busy drivers', ['count' => count($busyDriverIds), 'ids' => $busyDriverIds]);

        // Resolve candidate drivers
        if ($locationId) {
            // Drivers linked to the specific location
            $location = Location::findOrFail($locationId);
            $drivers = $location->drivers()
                ->whereNotIn('users.id', $busyDriverIds)
                ->select('users.id', 'name', 'email')
                ->orderBy('name')
                ->get();
        } else {
            // Fallback: all users flagged as drivers
            $drivers = User::query()
                ->where('is_driver', 1)
                ->whereNotIn('id', $busyDriverIds)
                ->select('id', 'name', 'email')
                ->orderBy('name')
                ->get();
        }
        Log::info('availableDrivers result', ['count' => $drivers->count()]);

        return response()->json(['data' => $drivers]);
    }

    public function create()
    {
        $cars = Car::where('availability', 1)->get();
        $users = User::where('role', 'user')->get();
        $locations = Location::orderBy('name')->get();
        $drivers = User::where('is_driver', 1)->orderBy('name')->get();
        $rental = new Rental();
        return view('dashboard.rentals.create', compact('cars', 'users', 'rental', 'locations', 'drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'location_id' => 'required|exists:locations,id',
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
        $locations = Location::all();
        $drivers = User::where('is_driver', 1)->orderBy('name')->get();
        return view('dashboard.rentals.edit', compact('rental', 'cars', 'users', 'locations', 'drivers'));
    }

    public function update(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'location_id' => 'required|exists:locations,id',
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
        if ($car) {
            if (in_array($validated['status'], ['approved', 'ongoing'])) {
                $car->update(['availability' => 0]);
            } elseif (in_array($validated['status'], ['completed', 'cancelled'])) {
                // Only mark available if no other approved/ongoing rentals exist for this car
                $hasActive = Rental::where('car_id', $car->id)
                    ->whereIn('status', ['approved', 'ongoing'])
                    ->where('id', '!=', $rental->id)
                    ->exists();
                if (!$hasActive) {
                    $car->update(['availability' => 1]);
                }
            }
        }

        return redirect()->route('dashboard.rentals.index')->with('success', 'Location mise à jour avec succès!');
    }

    public function userStore(Request $request, Car $car)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'needs_driver' => 'nullable|boolean',
            'driver_license' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'location_id' => 'required|exists:locations,id',
        ]);

        $available = $this->checkCarAvailability($car->id, $validated['start_date'], $validated['end_date']);
        Log::info('Rental availability check', [
            'car_id' => $car->id,
            'user_id' => Auth::id(),
            'location_id' => $validated['location_id'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'available' => $available,
        ]);

        if (!$available) {
            return back()->with('error', 'Désolé, cette voiture n\'est pas disponible pour les dates que vous avez sélectionnées. Veuillez choisir une autre période.')
                         ->withInput();
        }

        $rentalDate = Carbon::parse($validated['start_date']);
        $returnDate = Carbon::parse($validated['end_date']);
        // Enforce minimum 1-day billing
        $days = max(1, $returnDate->diffInDays($rentalDate));
        $totalPrice = $days * $car->price_per_day;

        // Determine driver preference and optional license upload
        $needsDriver = (bool)($validated['needs_driver'] ?? false);
        $licensePath = null;
        if (!$needsDriver) {
            // If client does NOT need a driver, they must provide a license file
            if (!$request->hasFile('driver_license')) {
                return back()->with('error', 'Veuillez importer une photo de votre permis de conduire si vous ne demandez pas de chauffeur.')
                             ->withInput();
            }
            $licensePath = $request->file('driver_license')->store('licenses', 'public');
        }

        try {
            $rental = Rental::create([
                'user_id' => Auth::id(),
                'car_id' => $car->id,
                'location_id' => $validated['location_id'] ?? null,
                'rental_date' => $validated['start_date'],
                'return_date' => $validated['end_date'],
                'total_price' => $totalPrice,
                'status' => 'pending',
                'needs_driver' => $needsDriver,
                'driver_license_path' => $licensePath,
            ]);
            Log::info('Rental created successfully', ['rental_id' => $rental->id]);
        } catch (\Throwable $e) {
            Log::error('Failed to create rental', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => [
                    'user_id' => Auth::id(),
                    'car_id' => $car->id,
                    'rental_date' => $validated['start_date'],
                    'return_date' => $validated['end_date'],
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                ],
            ]);
            return back()->with('error', "Une erreur est survenue lors de l'enregistrement de votre location. Veuillez réessayer.")
                         ->withInput();
        }

        return redirect()->route('cars.detail', ['car' => $car])
                         ->with('success', 'Votre demande de réservation a été envoyée avec succès! Nous vous contacterons bientôt pour la confirmation.');
    }

    public function updateStatus(Request $request, Rental $rental, $status)
    {
        $validatedStatus = in_array($status, ['approved', 'cancelled', 'completed']) ? $status : 'pending';

        $rental->status = $validatedStatus;
        $rental->save();

        if ($validatedStatus === 'approved') {
            try {
                Mail::to($rental->user->email)->send(new LocationApproved($rental));
            } catch (\Exception $e) {
                Log::error('Failed to send rental approval email.', ['rental_id' => $rental->id, 'error' => $e->getMessage()]);
            }
        }

        // Toggle car availability based on status
        $car = $rental->car;
        if ($car) {
            if (in_array($validatedStatus, ['approved', 'ongoing'])) {
                $car->update(['availability' => 0]);
            } elseif (in_array($validatedStatus, ['completed', 'cancelled'])) {
                // Only set available if no other approved/ongoing rentals exist for this car
                $hasActive = Rental::where('car_id', $car->id)
                    ->whereIn('status', ['approved', 'ongoing'])
                    ->where('id', '!=', $rental->id)
                    ->exists();
                if (!$hasActive) {
                    $car->update(['availability' => 1]);
                }
            }
        }

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
            ->whereIn('status', ['approved', 'ongoing'])
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
