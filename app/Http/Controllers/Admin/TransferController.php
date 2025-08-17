<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use App\Models\User;
use App\Mail\TransferStatusUpdated;
use App\Mail\TransferVoucherMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Driver;
use App\Models\Car;
use App\Models\Destination;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    // public function __construct()
    // {
    //     $this->authorizeResource(Transfer::class, 'transfer');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transfers = Transfer::with(['user', 'driver', 'car'])
                                 ->latest()
                                 ->paginate(10);

        return view('admin.transfers.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $drivers = User::where('is_driver', true)->get();
        $cars = Car::where('availability', true)->get();
        $destinations = Destination::where('is_active', true)->get();

        return view('admin.transfers.create', compact('users', 'drivers', 'cars', 'destinations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'driver_id' => 'nullable|exists:users,id',
            'car_id' => 'nullable|exists:cars,id',
            'pickup_location_id' => 'required|exists:destinations,id',
            'dropoff_location_id' => 'required|exists:destinations,id|different:pickup_location_id',
            'pickup_datetime' => 'required|date',
            'airline' => 'nullable|string|max:255',
            'flight_number' => 'nullable|string|max:255',
            'passenger_count' => 'required|integer|min:1',
            'luggage_count' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'special_instructions' => 'nullable|string',
        ]);

        // Generate a unique reference number
        $validatedData['reference_number'] = 'TRN-' . strtoupper(uniqid());

        // Set status based on driver assignment
        $validatedData['status'] = $request->filled('driver_id') ? 'assigned' : 'confirmed';
        $validatedData['payment_status'] = 'pending'; // Default payment status

        $transfer = Transfer::create($validatedData);
        $transfer->load('user');

        return redirect()->route('dashboard.transfers.index')
                         ->with('success', 'Transfert créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        $transfer->load('user');
        return view('invoices.transfer', compact('transfer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transfer)
    {
        $users = User::all();
        $drivers = User::where('is_driver', true)->get(); // Get all drivers for re-assignment
        $cars = Car::all();
        $destinations = Destination::where('is_active', true)->get();

        return view('admin.transfers.edit', compact('transfer', 'users', 'drivers', 'cars', 'destinations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transfer $transfer)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'driver_id' => 'nullable|exists:users,id',
            'car_id' => 'nullable|exists:cars,id',
            'pickup_location_id' => 'required|exists:destinations,id',
            'dropoff_location_id' => 'required|exists:destinations,id|different:pickup_location_id',
            'pickup_datetime' => 'required|date',
            'airline' => 'nullable|string|max:255',
            'flight_number' => 'nullable|string|max:255',
            'passenger_count' => 'required|integer|min:1',
            'luggage_count' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,assigned,on_the_way,completed,cancelled,no_show',
            'special_instructions' => 'nullable|string',
        ]);

        // Check if the status is being changed to 'confirmed'
        $isConfirmed = $request->input('status') === 'confirmed' && $transfer->status !== 'confirmed';

        $transfer->update($validatedData);

        // If the status is newly confirmed, send the voucher email to the customer
        if ($isConfirmed && $transfer->customer_email) {
            Mail::to($transfer->customer_email)->send(new TransferVoucherMail($transfer));
        } else if ($transfer->isDirty('status') && $transfer->user) {
            // For other status changes, send a simple notification to the user who booked
            Mail::to($transfer->user)->send(new TransferStatusUpdated($transfer));
        }

        return redirect()->route('dashboard.transfers.index')
                         ->with('success', 'Transfert mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        $transfer->delete();

        return redirect()->route('dashboard.transfers.index')
                         ->with('success', 'Transfert supprimé avec succès.');
    }
}
