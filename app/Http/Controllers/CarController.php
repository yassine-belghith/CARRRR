<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CarController extends Controller
{


    

    public function create()
    {
        return view('dashboard.createCars');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'availability' => 'required|in:0,1',
            'registration_number' => 'required|string|max:20|unique:cars,registration_number',
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
        ]);

        // Handle file uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('cars', 'public');
                $imagePaths[] = $path;
            }
        }

        // Create the car with the first image path (or empty string if no images)
        $car = Car::create([
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'images' => !empty($imagePaths) ? json_encode($imagePaths) : '',
            'availability' => $validated['availability'],
            'registration_number' => $validated['registration_number'],
            'description' => $validated['description'] ?? null,
            'price_per_day' => $validated['price_per_day'],
        ]);

        return redirect()->route('dashboard.cars.index')->with('success', 'Voiture ajoutée avec succès!');
    }

    public function getReservations($id)
    {
        $car = Car::find($id);
        $rentals = $car->rentals()->where('status', '!=', 3)->get();

        $events = [];
        foreach ($rentals as $rental) {
            // FullCalendar's end date is exclusive, so add a day to make the range inclusive
            $endDate = \Carbon\Carbon::parse($rental->end_date)->addDay();

            $events[] = [
                'title' => 'Réservé',
                'start' => $rental->start_date,
                'end' => $endDate->toDateString(),
                'color' => 'red',
                'allDay' => true
            ];
        }

        return response()->json($events);
    }

    public function edit($id)
    {
        $car = Car::find($id);

        return view('dashboard.editCar', compact('car'));
    }

    public function update(Request $request, $id)
    {
        $car = Car::find($id);

        $car->update($request->all());

        return redirect()->route('dashboard.cars.index')->with('success', 'Voiture mise à jour avec succès!');
    }

    public function destroy($id)
    {
        $car = Car::find($id);
        $car->delete();

        return redirect()->route('dashboard.cars.index')->with('success', 'Voiture supprimée avec succès!');
    }

    public function acceuil()
    {
        $cars = Car::take(4)->get();
        $destinations = Destination::where('is_active', true)->orderBy('type')->orderBy('name')->get()->groupBy('type');

        return view('welcome', ['cars' => $cars, 'destinations' => $destinations]);
    }

    public function cars()
    {
        $cars = Car::paginate(9);
        $brands = Car::select('brand')->distinct()->orderBy('brand')->pluck('brand');
        
        return view('cars', compact('cars', 'brands'));
        // Remove types filter as the column doesn't exist in the cars table
        
        return view('cars', [
            'cars' => $cars,
            'brands' => $brands
        ]);
    }

    public function search(Request $request)
    {
        $query = Car::query();

        // Handle general text search (from homepage or other forms)
        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where(function ($q) use ($location) {
                $q->where('brand', 'like', "%{$location}%")
                  ->orWhere('model', 'like', "%{$location}%");
            });
        }

        // Handle brand filter from search page
        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->input('brand') . '%');
        }

        // Handle price filter from search page
        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->input('max_price'));
        }

        // Handle date availability filter
        if ($request->filled('start-date') && $request->filled('end-date')) {
            $startDate = Carbon::createFromFormat('d/m/Y', $request->input('start-date'))->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', $request->input('end-date'))->endOfDay();

            $query->whereDoesntHave('rentals', function ($q) use ($startDate, $endDate) {
                $q->where(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '<=', $endDate)
                          ->where('end_date', '>=', $startDate);
                });
            });
        }

        $cars = $query->paginate(9)->withQueryString();

        return view('cars.index', ['cars' => $cars]);
    }

    public function getAvailableDrivers(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $validated['start_date'];
        $endDate = $validated['end_date'];

        Log::info('Fetching available drivers for dates:', ['start' => $startDate, 'end' => $endDate]);

        $query = User::where('is_driver', true)
            ->whereDoesntHave('assignedRentals', function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('rental_date', '<', $endDate)
                      ->where('return_date', '>', $startDate);
                });
            });
        
        Log::info('Driver Availability Query:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);

        $availableDrivers = $query->get();

        Log::info('Found ' . $availableDrivers->count() . ' available drivers.');

        return response()->json($availableDrivers);
    }

    public function index()
    {
        $cars = Car::with(['rentals'])->latest()->paginate(10);
        return view('dashboard.cars.index', compact('cars'));
    }

    public function publicShow(Car $car)
    {
        $rentals = $car->rentals()->where('status', '!=', 3)->get();
        $drivers = User::where('role', 'driver')->get();

        return view('cars.show', compact('car', 'rentals', 'drivers'));
    }

    public function show(Car $car)
    {
        return view('dashboard.cars.show', [
            'car' => $car->load(['rentals'])
        ]);
    }
}
