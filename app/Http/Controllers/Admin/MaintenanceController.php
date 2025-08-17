<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Car;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Maintenance::class, 'maintenance');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Car $car)
    {
        $maintenances = $car->maintenances()->orderBy('maintenance_date', 'desc')->paginate(10);
        return view('admin.maintenances.index', compact('car', 'maintenances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Car $car)
    {
        return view('admin.maintenances.create', compact('car'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Car $car)
    {
        $validatedData = $request->validate([
            'maintenance_date' => 'required|date',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'service_provider' => 'nullable|string|max:255',
            'mileage' => 'nullable|integer|min:0',
        ]);

        $car->maintenances()->create($validatedData);

        return redirect()->route('dashboard.cars.maintenances.index', $car)
                         ->with('success', 'Entretien ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car, Maintenance $maintenance)
    {
        return view('admin.maintenances.edit', compact('car', 'maintenance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car, Maintenance $maintenance)
    {
        $validatedData = $request->validate([
            'maintenance_date' => 'required|date',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'service_provider' => 'nullable|string|max:255',
            'mileage' => 'nullable|integer|min:0',
        ]);

        $maintenance->update($validatedData);

        return redirect()->route('dashboard.cars.maintenances.index', $car)
                         ->with('success', 'Entretien mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car, Maintenance $maintenance)
    {
        $maintenance->delete();

        return redirect()->route('dashboard.cars.maintenances.index', $car)
                         ->with('success', 'Entretien supprimé avec succès.');
    }
}
