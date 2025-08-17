@component('mail::message')
# Votre réservation de location est confirmée !

Bonjour {{ $rental->user->name }},

Nous avons le plaisir de vous confirmer votre réservation de location de véhicule.

Vous trouverez en pièce jointe votre voucher PDF contenant tous les détails de votre location. Veuillez le conserver pour vos dossiers.

Nous vous remercions de votre confiance et vous souhaitons un excellent voyage.

Cordialement,
<br>
L'équipe de {{ config('app.name') }}
@endcomponent
