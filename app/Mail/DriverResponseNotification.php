<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Transfer;

class DriverResponseNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $transfer;

    /**
     * Create a new message instance.
     */
    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $status = $this->transfer->driver_confirmation_status === 'confirmed' ? 'Confirmé' : 'Refusé';
        $subject = "Réponse du Chauffeur pour le Transfert #{$this->transfer->reference_number} : {$status}";

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.transfers.driver_response',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
