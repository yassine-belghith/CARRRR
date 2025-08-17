<x-mail::message>
# Mise à jour de votre transfert

Cher/Chère {{ $transfer->user->name }},

Le statut de votre transfert **#{{ $transfer->reference_number }}** a été mis à jour.

**Nouveau statut : {{ $transfer->status_label }}**

@switch($transfer->status)
    @case('confirmed')
        Votre réservation est maintenant confirmée ! Le prix a été fixé et nous préparons votre véhicule.
        @break
    @case('assigned')
        Bonne nouvelle ! Un chauffeur et un véhicule ont été assignés à votre transfert.
        - **Chauffeur :** {{ $transfer->driver->user->name ?? 'Information non disponible' }}
        - **Véhicule :** {{ $transfer->car->brand ?? '' }} {{ $transfer->car->model ?? '' }}
        @break
    @case('on_the_way')
        Votre chauffeur est en route pour vous récupérer. Veuillez vous tenir prêt(e).
        @break
    @case('completed')
        Votre transfert est terminé. Nous espérons que vous avez fait bon voyage et nous nous réjouissons de vous servir à nouveau.
        @break
    @case('cancelled')
        Votre transfert a été annulé. Si vous n'êtes pas à l'origine de cette annulation, veuillez nous contacter immédiatement.
        @break
    @default
        Veuillez consulter votre espace client pour plus de détails sur cette mise à jour.
@endswitch

### Résumé de votre transfert :

- **Date et heure :** {{ $transfer->pickup_datetime ? $transfer->pickup_datetime->format('d/m/Y à H:i') : 'Non spécifiée' }}
- **De :** {{ $transfer->pickupLocation->name }}
- **À :** {{ $transfer->dropoffLocation->name }}
- **Prix :** {{ number_format($transfer->price, 2, ',', ' ') }} €

<x-mail::button :url="route('transfers.my')">
Voir mes transferts
</x-mail::button>

Cordialement,<br>
L'équipe de {{ config('app.name') }}
</x-mail::message>
