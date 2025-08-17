<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * L'instance du message de contact.
     *
     * @var \App\Models\ContactMessage
     */
    public $contactMessage;

    /**
     * L'URL du tableau de bord pour voir le message.
     *
     * @var string
     */
    public $dashboardUrl;

    /**
     * Créer une nouvelle instance de message.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return void
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
        $this->dashboardUrl = route('dashboard.contact-messages.show', $contactMessage);
    }

    /**
     * Construire le message.
     *
     * @return $this
     */
    public function build()
    {
        $appName = config('app.name');
        
        return $this->subject("Nouveau message de contact - {$appName}")
                    ->markdown('emails.contact.form')
                    ->with([
                        'contactMessage' => $this->contactMessage,
                        'dashboardUrl' => $this->dashboardUrl,
                    ]);
    }
}
