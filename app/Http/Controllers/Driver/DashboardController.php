<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DriverResponseNotification;

class DashboardController extends Controller
{
    public function index()
    {
        $driver = Auth::user();

        // Summary Stats
        $pendingTransfersCount = Transfer::where('driver_id', $driver->id)
            ->where('driver_confirmation_status', 'pending')
            ->count();

        $upcomingRentalsCount = Rental::where('driver_id', $driver->id)
            ->whereIn('status', ['approved', 'pending'])
            ->where('rental_date', '>=', today())
            ->count();

        // Fetch assigned transfers for the logged-in driver
        $transfers = Transfer::where('driver_id', $driver->id)
            ->with(['rental.car', 'rental.user'])
            ->latest()
            ->paginate(5, ['*'], 'transfers_page');

        // Fetch assigned rentals for the logged-in driver
        $rentals = Rental::where('driver_id', $driver->id)
            ->with(['car', 'user'])
            ->latest()
            ->paginate(5, ['*'], 'rentals_page');

        return view('driver.dashboard', compact(
            'transfers',
            'rentals',
            'pendingTransfersCount',
            'upcomingRentalsCount'
        ));
    }

    public function confirm(Request $request, Transfer $transfer)
    {
        // Logic to confirm a transfer
        $transfer->driver_confirmation_status = 'confirmed';
        $transfer->save();

        // Optionally, notify admin
        // Mail::to(User::find(1))->send(new DriverResponseNotification($transfer, 'confirmed'));

        return redirect()->route('driver.dashboard')->with('success', 'Transfert confirmé avec succès.');
    }

    public function decline(Request $request, Transfer $transfer)
    {
        // Logic to decline a transfer
        $transfer->driver_confirmation_status = 'declined';
        $transfer->save();

        // Notify admin about the decline
        // Mail::to(User::find(1))->send(new DriverResponseNotification($transfer, 'declined'));

        return redirect()->route('driver.dashboard')->with('success', 'Transfert refusé.');
    }

    public function show(Transfer $transfer)
    {
        return view('driver.transfers.show', compact('transfer'));
    }
}
