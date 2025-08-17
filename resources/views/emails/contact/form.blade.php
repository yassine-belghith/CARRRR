@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

# Nouveau message de contact

Vous avez reçu un nouveau message de contact depuis le site {{ config('app.name') }}.

## Informations de l'expéditeur

- **Nom:** {{ $contactMessage->name }}
- **Email:** [{{ $contactMessage->email }}](mailto:{{ $contactMessage->email }})
- **Date:** {{ $contactMessage->created_at->format('d/m/Y H:i') }}
- **IP:** {{ $contactMessage->ip_address }}

## Message

> {!! nl2br(e($contactMessage->message)) !!}

@component('mail::button', ['url' => $dashboardUrl])
Voir le message dans le tableau de bord
@endcomponent

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.\
\
@if(isset($contactMessage))
[Se désabonner]({{ route('unsubscribe.contact', ['email' => $contactMessage->email]) }})
@endif
@endcomponent
@endslot
@endcomponent
