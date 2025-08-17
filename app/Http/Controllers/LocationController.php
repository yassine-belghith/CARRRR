<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Destination;

class LocationController extends Controller
{
        public function search(Request $request)
    {
        $query = $request->get('query');
        $destinations = Destination::where('name', 'LIKE', "%{$query}%")
                                   ->orWhere('city', 'LIKE', "%{$query}%")
                                   ->orWhere('country', 'LIKE', "%{$query}%")
                                   ->pluck('name');
        return response()->json($destinations);
    }
    public function index()
    {
        $locations = Location::all();
        return view('dashboard.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('dashboard.locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'opening_hours_weekdays' => 'required|date_format:H:i',
            'closing_hours_weekdays' => 'required|date_format:H:i|after:opening_hours_weekdays',
            'opening_hours_weekends' => 'nullable|date_format:H:i',
            'closing_hours_weekends' => 'nullable|date_format:H:i|after:opening_hours_weekends',
        ]);

        Location::create($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Location created successfully.');
    }

    public function show(Location $location)
    {
        return view('dashboard.locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        return view('dashboard.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'opening_hours_weekdays' => 'required|date_format:H:i',
            'closing_hours_weekdays' => 'required|date_format:H:i|after:opening_hours_weekdays',
            'opening_hours_weekends' => 'nullable|date_format:H:i',
            'closing_hours_weekends' => 'nullable|date_format:H:i|after:opening_hours_weekends',
        ]);

        $location->update($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Location updated successfully');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('locations.index')
            ->with('success', 'Location deleted successfully');
    }
}
