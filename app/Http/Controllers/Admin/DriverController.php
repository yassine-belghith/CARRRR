<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::with('user')->latest()->paginate(10);
        return view('admin.drivers.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer les utilisateurs qui ne sont pas déjà des chauffeurs
        $users = User::whereDoesntHave('driver')->get();
        return view('admin.drivers.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id|unique:drivers,user_id',
            'license_number' => 'required|string|max:255|unique:drivers,license_number',
            'license_issue_date' => 'required|date',
            'license_expiry_date' => 'required|date|after:license_issue_date',
            'phone' => 'nullable|string|max:20',
        ]);

        Driver::create($validatedData);

        return redirect()->route('dashboard.drivers.index')
                         ->with('success', 'Chauffeur ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        return view('admin.drivers.edit', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        $validatedData = $request->validate([
            'license_number' => 'required|string|max:255|unique:drivers,license_number,' . $driver->id,
            'license_issue_date' => 'required|date',
            'license_expiry_date' => 'required|date|after:license_issue_date',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:available,on_mission,unavailable',
        ]);

        $driver->update($validatedData);

        return redirect()->route('dashboard.drivers.index')
                         ->with('success', 'Chauffeur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()->route('dashboard.drivers.index')
                         ->with('success', 'Chauffeur supprimé avec succès.');
    }
}
