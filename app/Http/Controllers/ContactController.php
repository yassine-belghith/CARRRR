<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewContactMessage;

class ContactController extends Controller
{
    public function showContactForm()
    {
        return view('contact');
    }

    public function sendEmail(Request $request)
    {
        \Log::info('Début de la méthode sendEmail');
        \Log::info('Données reçues:', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10|max:2000',
        ], [
            'name.required' => 'Le champ nom est obligatoire.',
            'email.required' => 'Le champ email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'message.required' => 'Le champ message est obligatoire.',
            'message.min' => 'Le message doit contenir au moins :min caractères.',
            'message.max' => 'Le message ne doit pas dépasser :max caractères.'
        ]);

        if ($validator->fails()) {
            \Log::error('Validation échouée:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Veuillez corriger les erreurs du formulaire.'
            ], 422);
        }

        try {
            \Log::info('Tentative d\'enregistrement du message en base de données');
            // Enregistrer le message dans la base de données
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            \Log::info('Message enregistré avec l\'ID: ' . $contactMessage->id);
            \Log::info('Tentative d\'envoi d\'email à: ' . config('mail.admin_email', 'admin@example.com'));

            // Envoyer l'email à l'administrateur
            Mail::to(config('mail.admin_email', 'admin@example.com'))
                ->send(new ContactFormMail($contactMessage));
            
            \Log::info('Email envoyé avec succès');

            return response()->json([
                'success' => true,
                'message' => 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'envoi du formulaire de contact: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    /**
     * Gère la désinscription des emails de contact
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe(Request $request)
    {
        $email = $request->query('email');
        
        if ($email) {
            // Ici, vous pouvez ajouter la logique pour marquer l'email comme désabonné
            // Par exemple, mettre à jour un champ 'is_subscribed' à false dans la table des utilisateurs
            // ou dans une table de préférences d'emails
            
            return response()->view('emails.unsubscribe', [
                'email' => $email,
                'success' => true,
                'message' => "L'adresse email $email a été désabonnée avec succès des emails de contact."
            ]);
        }
        
        return response()->view('emails.unsubscribe', [
            'success' => false,
            'message' => 'Aucune adresse email fournie pour la désinscription.'
        ]);
    }
}
