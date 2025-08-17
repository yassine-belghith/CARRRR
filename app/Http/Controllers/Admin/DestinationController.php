<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = Destination::latest()->paginate(10);
        return view('admin.destinations.index', compact('destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.destinations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validatedData['is_active'] = $request->has('is_active');

        Destination::create($validatedData);

        return redirect()->route('dashboard.destinations.index')
                         ->with('success', 'Destination créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Destination $destination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validatedData['is_active'] = $request->has('is_active');

        $destination->update($validatedData);

        return redirect()->route('dashboard.destinations.index')
                         ->with('success', 'Destination mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        $destination->delete();

        return redirect()->route('dashboard.destinations.index')
                         ->with('success', 'Destination supprimée avec succès.');
    }
}
