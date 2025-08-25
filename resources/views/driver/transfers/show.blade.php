@extends('layouts.app')

@section('title', 'Détails du Transfert #' . $transfer->reference_number)

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Détails du Transfert #{{ $transfer->reference_number }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>Informations sur le Client</h4>
                <p><strong>Nom :</strong> {{ optional($transfer->user)->name ?? 'N/A' }}</p>
                <p><strong>Email :</strong> {{ optional($transfer->user)->email ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <h4>Informations sur le Vol (si applicable)</h4>
                <p><strong>Compagnie Aérienne :</strong> {{ $transfer->airline ?? 'N/A' }}</p>
                <p><strong>Numéro de Vol :</strong> {{ $transfer->flight_number ?? 'N/A' }}</p>
            </div>
        </div>

        <hr>

        <h4>Détails du Trajet</h4>
        <p><strong>Date et Heure de Prise en Charge :</strong> {{ $transfer->pickup_datetime ? $transfer->pickup_datetime->format('d/m/Y H:i') : 'Non spécifié' }}</p>
        <p><strong>Lieu de Prise en Charge :</strong>
            @if(!is_null($transfer->pickup_latitude) && !is_null($transfer->pickup_longitude))
                <a href="https://www.google.com/maps/search/?api=1&query={{ $transfer->pickup_latitude }},{{ $transfer->pickup_longitude }}" target="_blank">
                    {{ $transfer->pickup_latitude }}, {{ $transfer->pickup_longitude }} <i class="fas fa-external-link-alt"></i>
                </a>
            @else
                N/A
            @endif
        </p>
        <p><strong>Lieu de Destination :</strong>
            @if(!is_null($transfer->dropoff_latitude) && !is_null($transfer->dropoff_longitude))
                 <a href="https://www.google.com/maps/search/?api=1&query={{ $transfer->dropoff_latitude }},{{ $transfer->dropoff_longitude }}" target="_blank">
                    {{ $transfer->dropoff_latitude }}, {{ $transfer->dropoff_longitude }} <i class="fas fa-external-link-alt"></i>
                </a>
            @else
                N/A
            @endif
        </p>
        <p><strong>Nombre de Passagers :</strong> {{ $transfer->passenger_count }}</p>
        <p><strong>Nombre de Bagages :</strong> {{ $transfer->luggage_count }}</p>

        <hr>

        <h4>Statut du Transfert</h4>
        <p>
            <strong>Statut Général :</strong> 
            <span class="badge @switch($transfer->status)
                @case('pending') bg-warning @break
                @case('confirmed') bg-success @break
                @case('cancelled') bg-danger @break
                @case('completed') bg-info @break
                @default bg-secondary @break
            @endswitch">{{ ucfirst($transfer->status) }}</span>
        </p>
        <p>
            <strong>Votre Confirmation :</strong> 
            <span class="badge @switch($transfer->driver_confirmation_status)
                @case('pending') bg-warning @break
                @case('confirmed') bg-success @break
                @case('declined') bg-danger @break
                @default bg-secondary @break
            @endswitch">{{ ucfirst($transfer->driver_confirmation_status) }}</span>
        </p>

        @if($transfer->special_instructions)
            <hr>
            <h4>Instructions Spéciales</h4>
            <p>{{ $transfer->special_instructions }}</p>
        @endif

        <div class="mt-4">
            <a href="{{ route('driver.dashboard') }}" class="btn btn-secondary">Retour au Tableau de Bord</a>
        </div>
    </div>
</div>
@endsection
