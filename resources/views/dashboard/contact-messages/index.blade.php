@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Messages de contact</h6>
                    <div class="d-flex">
                                                <a href="{{ route('dashboard.contact-messages.export') }}" class="btn btn-sm btn-success me-2">
                            <i class="fas fa-file-export me-1"></i> Exporter
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($messages as $message)
                                    <tr>
                                        <td>{{ $message->name }}</td>
                                        <td>
                                            <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                        </td>
                                        <td>{{ Str::limit($message->message, 50) }}</td>
                                        <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($message->is_read)
                                                <span class="badge bg-success">Lu</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Non lu</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('dashboard.contact-messages.show', $message) }}" 
                                               class="btn btn-sm btn-info"
                                               title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <form action="{{ route('dashboard.contact-messages.destroy', $message) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('dashboard.contact-messages.toggle-read', $message) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Voulez-vous vraiment {{ $message->is_read ? 'marquer comme non lu' : 'marquer comme lu' }} ce message ?')">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm {{ $message->is_read ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                                        title="{{ $message->is_read ? 'Marquer comme non lu' : 'Marquer comme lu' }}">
                                                    <i class="fas {{ $message->is_read ? 'fa-envelope' : 'fa-envelope-open' }}"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Aucun message trouvé</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $messages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
