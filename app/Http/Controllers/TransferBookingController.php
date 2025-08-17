<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Destination;
use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\TransferRequestReceived;
use App\Mail\AdminTransferRequestNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TransferBookingController extends Controller
{
    /**
     * Store a newly created transfer booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Transfer::class);
        $validatedData = $request->validate([
            'pickup_datetime' => 'required|date',
            'pickup_latitude' => 'required|numeric',
            'pickup_longitude' => 'required|numeric',
            'dropoff_latitude' => 'required|numeric',
            'dropoff_longitude' => 'required|numeric',
            'passenger_count' => 'required|integer|min:1',
            'car_id' => 'required|exists:cars,id',
        ]);

        $validatedData['user_id'] = auth()->id();
        $validatedData['reference_number'] = 'TRN-' . strtoupper(Str::random(8));
        $validatedData['status'] = 'pending';
        $validatedData['price'] = 0; // Admin will set the price later

        $transfer = Transfer::create($validatedData);

        // Send emails
        try {
            Mail::to($request->user())->send(new TransferRequestReceived($transfer));
            $adminEmail = env('ADMIN_EMAIL');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new AdminTransferRequestNotification($transfer));
            }
        } catch (\Exception $e) {
            // Log the error and continue without crashing
            Log::error('Mail sending failed: ' . $e->getMessage());
        }

        return redirect()->route('transfers.my')->with('success', 'Votre demande de transfert a été envoyée avec succès.');   }
    /**
     * Display a listing of the user's transfer bookings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('viewAny', Transfer::class);
        $transfers = Transfer::where('user_id', Auth::id())
                             ->with(['driver', 'car'])
                             ->latest()
                             ->paginate(10);

        return view('transfers.my-transfers', compact('transfers'));
    }

    /**
     * Show the form for creating a new transfer booking.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $destinations = Destination::where('is_active', true)->orderBy('name')->get();
        $cars = Car::where('availability', true)->orderBy('brand')->orderBy('model')->get();
        return view('transfers.book', compact('destinations', 'cars'));
    }

    /**
     * Download the invoice for a specific transfer.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function downloadInvoice(Transfer $transfer)
    {
        $this->authorize('view', $transfer);

        $data = ['transfer' => $transfer->load('user', 'car')];

        $data['transfer']->load('user');
        $pdf = PDF::loadView('invoices.transfer', $data);

        return $pdf->download('facture-' . $transfer->reference_number . '.pdf');
    }
}
