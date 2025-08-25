@extends('layouts.app')

@push('styles')
<style>
    .item-grid { display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 14px; }
    @media (min-width: 768px) { .item-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (min-width: 1200px) { .item-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
    .item-card { background: #0f172a; border: 1px solid #1f2937; color: #e5e7eb; border-radius: .75rem; overflow: hidden; transition: transform .16s ease, box-shadow .16s ease; }
    .item-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.35); }
    .item-card .item-header { display:flex; justify-content:space-between; align-items:center; padding: .75rem 1rem; border-bottom: 1px solid #1f2937; background: linear-gradient(180deg, rgba(124,58,237,.08), rgba(17,24,39,0)); }
    .item-card .item-body { padding: .9rem 1rem; }
    .item-meta { display:flex; flex-wrap:wrap; gap:10px 16px; }
    .item-meta .meta { display:flex; align-items:center; gap:8px; color:#cbd5e1; }
    .muted-sm { color:#9ca3af; font-size:.85rem; }
    .btn-invoice { border-color:#64748b; color:#cbd5e1; }
    .btn-invoice:hover { background:#334155; color:#e5e7eb; }
    .price { font-weight:700; color:#f9fafb; }
</style>
@endpush

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
        <div class="card-header">Historique de vos demandes de transfert</div>
        <div class="card-body">
            @if($transfers->isEmpty())
                <div class="text-center">
                    <p>Vous n'avez aucune demande de transfert pour le moment.</p>
                    <a href="{{ route('transfers.book') }}" class="btn btn-primary">Faire ma première réservation</a>
                </div>
            @else
                <div class="item-grid">
                    @foreach($transfers as $transfer)
                        <div class="item-card">
                            <div class="item-header">
                                <div>
                                    <div class="muted-sm">Référence</div>
                                    <div class="fw-semibold">{{ $transfer->reference_number }}</div>
                                </div>
                                <div class="text-end">
                                    <div class="muted-sm">Date</div>
                                    <div class="fw-semibold">{{ $transfer->pickup_datetime->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                            <div class="item-body">
                                <div class="item-meta mb-3">
                                    <div class="meta"><i class="fas fa-map-marker-alt"></i><span>Départ:</span><span>{{ number_format($transfer->pickup_latitude, 5) }}, {{ number_format($transfer->pickup_longitude, 5) }}</span></div>
                                    <div class="meta"><i class="fas fa-flag-checkered"></i><span>Arrivée:</span><span>{{ number_format($transfer->dropoff_latitude, 5) }}, {{ number_format($transfer->dropoff_longitude, 5) }}</span></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge {{ $transfer->status_badge_class }}">{{ $transfer->status_label }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="price">{{ $transfer->price > 0 ? number_format($transfer->price, 2, ',', ' ') . ' €' : 'En attente' }}</div>
                                        <a href="{{ route('transfers.invoice', $transfer) }}" class="btn btn-sm btn-outline-secondary btn-invoice" title="Télécharger la facture">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $transfers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
