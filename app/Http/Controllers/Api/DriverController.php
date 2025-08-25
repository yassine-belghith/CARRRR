<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DriverController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!$user->is_driver) {
            throw ValidationException::withMessages([
                'email' => ['This account is not authorized as a driver.'],
            ]);
        }

        $token = $user->createToken('driver-app')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function dashboard(Request $request)
    {
        $driver = $request->user();
        
        $pendingTransfersCount = Transfer::where('driver_id', $driver->id)
            ->where('driver_confirmation_status', 'pending')
            ->count();

        $upcomingRentalsCount = Rental::where('driver_id', $driver->id)
            ->whereIn('status', ['approved', 'pending'])
            ->where('rental_date', '>=', today())
            ->count();

        $transfers = Transfer::where('driver_id', $driver->id)
            ->with(['user', 'car', 'pickupDestination', 'dropoffDestination'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($transfer) {
                // Add fallback location names if destinations are null
                if (!$transfer->pickupDestination && !$transfer->pickup_location) {
                    $transfer->pickup_location = 'Pickup Location';
                }
                if (!$transfer->dropoffDestination && !$transfer->dropoff_location) {
                    $transfer->dropoff_location = 'Dropoff Location';
                }
                return $transfer;
            });

        $rentals = Rental::where('driver_id', $driver->id)
            ->with(['car', 'user', 'location'])
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'driver' => $driver,
            'stats' => [
                'pending_transfers' => $pendingTransfersCount,
                'upcoming_rentals' => $upcomingRentalsCount,
            ],
            'transfers' => $transfers,
            'rentals' => $rentals,
        ]);
    }

    public function transfers(Request $request)
    {
        $driver = $request->user();
        
        $transfers = Transfer::where('driver_id', $driver->id)
            ->with(['user', 'car', 'pickupDestination', 'dropoffDestination'])
            ->latest()
            ->paginate(15);

        return response()->json($transfers);
    }

    public function rentals(Request $request)
    {
        $driver = $request->user();
        
        $rentals = Rental::where('driver_id', $driver->id)
            ->with(['car', 'user', 'location'])
            ->latest()
            ->paginate(15);

        return response()->json($rentals);
    }

    public function transferDetail(Request $request, Transfer $transfer)
    {
        $driver = $request->user();
        
        if ($transfer->driver_id !== $driver->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $transfer->load(['user', 'car', 'pickupDestination', 'dropoffDestination']);
        
        return response()->json($transfer);
    }

    public function rentalDetail(Request $request, Rental $rental)
    {
        $driver = $request->user();
        
        if ($rental->driver_id !== $driver->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $rental->load(['car', 'user', 'location']);
        
        return response()->json($rental);
    }

    public function confirmTransfer(Request $request, Transfer $transfer)
    {
        $driver = $request->user();
        
        if ($transfer->driver_id !== $driver->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $transfer->driver_confirmation_status = 'confirmed';
        $transfer->save();

        return response()->json([
            'message' => 'Transfer confirmed successfully',
            'transfer' => $transfer
        ]);
    }

    public function declineTransfer(Request $request, Transfer $transfer)
    {
        $driver = $request->user();
        
        if ($transfer->driver_id !== $driver->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $transfer->driver_confirmation_status = 'declined';
        $transfer->save();

        return response()->json([
            'message' => 'Transfer declined successfully',
            'transfer' => $transfer
        ]);
    }

    public function startJob(Request $request, Transfer $transfer)
    {
        $driver = $request->user();
        
        if ($transfer->driver_id !== $driver->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($transfer->driver_confirmation_status !== 'confirmed') {
            return response()->json(['error' => 'Transfer must be confirmed first'], 400);
        }

        $transfer->job_status = 'started';
        $transfer->job_started_at = now();
        $transfer->save();

        return response()->json([
            'message' => 'Job started successfully',
            'transfer' => $transfer
        ]);
    }

    public function endJob(Request $request, Transfer $transfer)
    {
        $driver = $request->user();
        
        if ($transfer->driver_id !== $driver->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($transfer->job_status !== 'started') {
            return response()->json(['error' => 'Job must be started first'], 400);
        }

        $transfer->job_status = 'completed';
        $transfer->job_completed_at = now();
        $transfer->save();

        return response()->json([
            'message' => 'Job completed successfully',
            'transfer' => $transfer
        ]);
    }

    public function profile(Request $request)
    {
        $driver = $request->user();
        return response()->json($driver);
    }

    public function updateProfile(Request $request)
    {
        $driver = $request->user();
        
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $driver->id,
        ]);

        $driver->update($request->only(['name', 'email']));
        
        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $driver
        ]);
    }
}
