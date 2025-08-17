<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use App\Models\Rental;
use App\Models\Transfer;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCars = Car::count();
        $totalRentals = Rental::count();
        $totalTransfers = Transfer::count();
        $pendingRentals = Rental::where('status', 'pending')->count();
        $confirmedRentals = Rental::where('status', 'confirmed')->count();
        $pendingTransfers = Transfer::where('status', 'pending')->count();
        $confirmedTransfers = Transfer::where('status', 'confirmed')->count();

        return view('dashboard.index', compact(
            'totalUsers',
            'totalCars',
            'totalRentals',
            'totalTransfers',
            'pendingRentals',
            'confirmedRentals',
            'pendingTransfers',
            'confirmedTransfers'
        ));
    }

    public function cars()
    {
        $cars = Car::paginate(10); // Show 10 cars per page

        return view('dashboard.cars', ['cars' => $cars]);
    }

    public function users()
    {
        $users = User::withCount('rentals')
                    ->with('rentals')
                    ->paginate(10); // Show 10 users per page

        return view('dashboard.users', [
            'users' => $users,
            'totalUsers' => User::count(),
            'adminCount' => User::where('role', 'admin')->count(),
            'activeUsers' => User::whereHas('rentals', function($query) {
                $query->where('status', '!=', 'completed');
            })->count()
        ]);
    }

    public function rentals()
    {
        $rentals = Rental::with('user', 'car')->get();

        return view('dashboard.rentals', ['rentals' => $rentals]);
    }
}
