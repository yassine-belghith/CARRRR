@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mes Transferts</h1>
        <a href="{{ route('transfers.book') }}" class="btn btn-primary">Réserver un nouveau transfert</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            Historique de vos demandes de transfert
        </div>
        <div class="card-body">
            @if($transfers->isEmpty())
                <div class="text-center">
                    <p>Vous n'avez aucune demande de transfert pour le moment.</p>
                    <a href="{{ route('transfers.book') }}" class="btn btn-primary">Faire ma première réservation</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Référence</th>
                                <th>Date</th>
                                <th>Départ (Lat, Lng)</th>
                                <th>Arrivée (Lat, Lng)</th>
                                <th>Statut</th>
                                <th>Prix</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transfers as $transfer)
                                <tr>
                                    <td><strong>{{ $transfer->reference_number }}</strong></td>
                                    <td>{{ $transfer->pickup_datetime->format('d/m/Y H:i') }}</td>
                                    <td>{{ number_format($transfer->pickup_latitude, 5) }}, {{ number_format($transfer->pickup_longitude, 5) }}</td>
                                    <td>{{ number_format($transfer->dropoff_latitude, 5) }}, {{ number_format($transfer->dropoff_longitude, 5) }}</td>
                                    <td>
                                        <span class="badge {{ $transfer->status_badge_class }}">{{ $transfer->status_label }}</span>
                                    </td>
                                    <td>{{ $transfer->price > 0 ? number_format($transfer->price, 2, ',', ' ') . ' €' : 'En attente' }}</td>
                                    <td>
                                        <a href="{{ route('transfers.invoice', $transfer) }}" class="btn btn-sm btn-outline-secondary" title="Télécharger la facture">
                                            <i class="fas fa-file-invoice"></i> Facture
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $transfers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
