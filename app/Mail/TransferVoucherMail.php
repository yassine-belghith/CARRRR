<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Transfer;
use Illuminate\Mail\Mailables\Attachment;
use Barryvdh\DomPDF\Facade\Pdf;

class TransferVoucherMail extends Mailable
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
        return new Envelope(
            subject: 'Votre Voucher de Transfert - Réservation #' . $this->transfer->reference_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.transfers.voucher_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.transfer_voucher', ['transfer' => $this->transfer]);

        return [
            Attachment::fromData(fn () => $pdf->output(), 'Voucher-' . $this->transfer->reference_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
