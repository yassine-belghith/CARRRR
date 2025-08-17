@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

# Nouveau message de contact

**Nom:** {{ $details['name'] }}

**Email:** {{ $details['email'] }}

**Message:**
{{ $details['message'] }}

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
@endcomponent
@endslot
@endcomponent
