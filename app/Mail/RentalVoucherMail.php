<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Rental;
use Illuminate\Mail\Mailables\Attachment;
use Barryvdh\DomPDF\Facade\Pdf;

class RentalVoucherMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rental;

    /**
     * Create a new message instance.
     */
    public function __construct(Rental $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre Voucher de Location - Réservation #' . $this->rental->reference_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.rentals.voucher_notification',
            with: [
                'rental' => $this->rental,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.rental_voucher', ['rental' => $this->rental]);

        return [
            Attachment::fromData(fn () => $pdf->output(), 'Voucher-Location-' . $this->rental->reference_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
