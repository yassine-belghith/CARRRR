@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Détails du message</h6>
                    <div>
                                                <a href="{{ route('dashboard.contact-messages.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Retour
                        </a>
                        <button type="button" class="btn btn-sm {{ $contactMessage->is_read ? 'btn-warning' : 'btn-info' }}" 
                                id="toggle-read" data-id="{{ $contactMessage->id }}">
                            <i class="fas fa-{{ $contactMessage->is_read ? 'envelope' : 'envelope-open' }} me-1"></i>
                            {{ $contactMessage->is_read ? 'Marquer comme non lu' : 'Marquer comme lu' }}
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal">
                            <i class="fas fa-trash me-1"></i> Supprimer
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Nom :</strong> {{ $contactMessage->name }}</p>
                            <p><strong>Email :</strong> <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p><strong>Date :</strong> {{ $contactMessage->created_at->format('d/m/Y H:i') }}</p>
                            <p>
                                <strong>Statut :</strong> 
                                @if($contactMessage->is_read)
                                    <span class="badge bg-success">Lu le {{ $contactMessage->read_at->format('d/m/Y H:i') }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">Non lu</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="m-0 font-weight-bold">Message</h6>
                        </div>
                        <div class="card-body">
                            {!! nl2br(e($contactMessage->message)) !!}
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="m-0 font-weight-bold">Informations techniques</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>IP :</strong> {{ $contactMessage->ip_address }}</p>
                                    <p><strong>Navigateur :</strong> {{ $contactMessage->user_agent ?: 'Inconnu' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>ID du message :</strong> {{ $contactMessage->id }}</p>
                                    <p><strong>Créé le :</strong> {{ $contactMessage->created_at->format('d/m/Y H:i') }}</p>
                                    <p><strong>Mis à jour le :</strong> {{ $contactMessage->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="mailto:{{ $contactMessage->email }}?subject=RE: Votre message du {{ $contactMessage->created_at->format('d/m/Y') }}" 
                       class="btn btn-primary">
                        <i class="fas fa-reply me-1"></i> Répondre
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce message ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <form action="{{ route('dashboard.contact-messages.destroy', $contactMessage) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Basculer l'état de lecture
    $('#toggle-read').on('click', function() {
        const button = $(this);
        const messageId = button.data('id');
        
        $.ajax({
            url: '{{ route("dashboard.contact-messages.toggle-read", ['contactMessage' => $contactMessage->id]) }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Mettre à jour le bouton et le badge
                    if (response.is_read) {
                        button.removeClass('btn-info').addClass('btn-warning')
                            .find('i').removeClass('fa-envelope').addClass('fa-envelope-open');
                        button.text(' Marquer comme non lu');
                        
                        // Mettre à jour le badge de statut
                        $('.badge').removeClass('bg-warning text-dark').addClass('bg-success')
                            .text('Lu à ' + new Date().toLocaleTimeString());
                    } else {
                        button.removeClass('btn-warning').addClass('btn-info')
                            .find('i').removeClass('fa-envelope-open').addClass('fa-envelope');
                        button.text(' Marquer comme lu');
                        
                        // Mettre à jour le badge de statut
                        $('.badge').removeClass('bg-success').addClass('bg-warning text-dark')
                            .text('Non lu');
                    }
                    
                    toastr.success(response.message);
                }
            },
            error: function() {
                toastr.error('Une erreur est survenue lors de la mise à jour du statut.');
            }
        });
    });
});
</script>
@endpush
