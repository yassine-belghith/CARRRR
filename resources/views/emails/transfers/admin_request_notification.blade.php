<x-mail::message>
# Nouvelle Demande de Transfert Reçue

Une nouvelle demande de transfert a été soumise sur le site.

### Détails de la demande :

- **Référence :** {{ $transfer->reference_number }}
- **Client :** {{ $transfer->user->name }} ({{ $transfer->user->email }})
- **Date de prise en charge :** {{ $transfer->pickup_datetime ? $transfer->pickup_datetime->format('d/m/Y à H:i') : 'Non spécifiée' }}
- **De :** {{ $transfer->pickupLocation->name }}
- **À :** {{ $transfer->dropoffLocation->name }}
- **Passagers :** {{ $transfer->passenger_count }}
- **Bagages :** {{ $transfer->luggage_count }}

@if($transfer->flight_number)
- **Numéro de vol :** {{ $transfer->airline }} {{ $transfer->flight_number }}
@endif

@if($transfer->special_instructions)
**Instructions spéciales :**
{{ $transfer->special_instructions }}
@endif

<x-mail::button :url="route('dashboard.transfers.edit', $transfer)">
Voir et Gérer la Demande
</x-mail::button>

Merci,
<br>Le système de notification de {{ config('app.name') }}
</x-mail::message>
