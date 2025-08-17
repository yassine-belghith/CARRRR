@component('mail::message')
# Votre réservation de transfert est confirmée !

Bonjour {{ $transfer->customer_name }},

Nous avons le plaisir de vous confirmer votre réservation de transfert.

Vous trouverez en pièce jointe votre voucher PDF contenant tous les détails de votre voyage. Veuillez le conserver pour vos dossiers.

Nous vous remercions de votre confiance et nous nous réjouissons de vous accueillir.

Cordialement,
<br>
L'équipe de {{ config('app.name') }}
@endcomponent
