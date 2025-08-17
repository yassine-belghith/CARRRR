<div class="dropdown">
    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        Actions
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li>
            <a class="dropdown-item" href="{{ route('dashboard.contact.messages.show', $message) }}">
                <i class="fas fa-eye me-2"></i> Voir
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="mailto:{{ $message->email }}?subject=RE: Votre message du {{ $message->created_at->format('d/m/Y') }}">
                <i class="fas fa-reply me-2"></i> Répondre
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form action="{{ route('dashboard.contact.messages.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item text-danger">
                    <i class="fas fa-trash me-2"></i> Supprimer
                </button>
            </form>
        </li>
    </ul>
</div>
