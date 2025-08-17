<x-mail::message>
# Confirmation de votre demande de transfert

Cher/Chère {{ $transfer->user->name }},

Nous avons bien reçu votre demande de transfert et nous vous remercions de votre confiance.

Un membre de notre équipe examinera votre demande sous peu pour la confirmer et vous communiquer le tarif final. Vous recevrez une nouvelle notification une fois que votre réservation sera confirmée.

### Résumé de votre demande :

- **Numéro de référence :** {{ $transfer->reference_number }}
- **Date et heure :** {{ $transfer->pickup_datetime ? $transfer->pickup_datetime->format('d/m/Y à H:i') : 'Non spécifiée' }}
- **Lieu de prise en charge (Lat, Lng) :** {{ $transfer->pickup_latitude }}, {{ $transfer->pickup_longitude }}
- **Lieu de dépose (Lat, Lng) :** {{ $transfer->dropoff_latitude }}, {{ $transfer->dropoff_longitude }}
- **Nombre de passagers :** {{ $transfer->passenger_count }}

Si vous avez des questions, n'hésitez pas à nous contacter.

Cordialement,<br>
L'équipe de {{ config('app.name') }}
</x-mail::message>
