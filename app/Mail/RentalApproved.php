<?php

namespace App\Mail;

use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RentalApproved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The rental instance.
     *
     * @var \App\Models\Rental
     */
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
            subject: 'Your Rental Request has been Approved',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.rentals.approved',
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
        return [];
    }
}