@component('mail::message')
# Réponse du Chauffeur pour le Transfert #{{ $transfer->reference_number }}

Bonjour,

Le chauffeur **{{ $transfer->driver->name }}** a répondu à l'assignation pour le transfert #{{ $transfer->reference_number }}.

**Statut de la réponse :** {{ $transfer->driver_confirmation_status === 'confirmed' ? 'Confirmé' : 'Refusé' }}

## Détails du Transfert

- **Client :** {{ $transfer->customer_name }}
- **Date et Heure :** {{ $transfer->pickup_datetime ? $transfer->pickup_datetime->format('d/m/Y H:i') : 'Non spécifié' }}
- **Prise en charge :** {{ $transfer->pickup_location }}
- **Destination :** {{ $transfer->dropoff_location }}

@if($transfer->driver_confirmation_status === 'declined')
**Action requise :** Le transfert a été refusé. Vous devez assigner un autre chauffeur.
@endif

@component('mail::button', ['url' => route('admin.transfers.show', $transfer)])
Voir le Transfert
@endcomponent

Merci,
<br>
{{ config('app.name') }}
@endcomponent
