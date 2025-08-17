@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Mes Préférences</h4>
                    <div>
                        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Retour au profil
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row">
                        <!-- Colonne de gauche : Avatar -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <div class="text-center">
                                        <div class="position-relative d-inline-block">
                                            <div class="position-relative d-inline-block" style="margin: 0 auto;">
                                                @php
                                                    // Generate the avatar URL manually to ensure it's correct
                                                    $avatarUrl = $user->avatar ? asset('storage/' . ltrim($user->avatar, '/')) : '';
                                                    $hasAvatar = !empty($user->avatar);
                                                    $avatarStyle = '';
                                                    $initials = strtoupper(substr($user->name, 0, 1));
                                                    
                                                    if ($hasAvatar) {
                                                        $avatarStyle = "background-image: url('{$avatarUrl}?v=" . time() . "'); background-size: cover; background-position: center; background-repeat: no-repeat;";
                                                    } else {
                                                        $avatarStyle = 'background-color: #3490dc; color: white; display: flex; align-items: center; justify-content: center; font-size: 60px;';
                                                    }
                                                @endphp
                                                <div class="user-avatar position-relative" 
                                                     style="width: 150px; height: 150px; border-radius: 50%; 
                                                            border: 3px solid #f8f9fa; box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
                                                            {{ $avatarStyle }} 
                                                            transition: all 0.3s ease; cursor: pointer;"
                                                     id="avatar-container"
                                                     data-avatar-url="{{ $avatarUrl }}">
                                                    <div class="avatar-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border-radius: 50%; background-color: rgba(0,0,0,0.3); opacity: 0; display: flex; align-items: center; justify-content: center; transition: opacity 0.3s ease;">
                                                        <i class="fas fa-camera text-white" style="font-size: 2rem;"></i>
                                                    </div>
                                                    @if(!$hasAvatar)
                                                        <span style="font-weight: 600; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
                                                            {{ $initials }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <form id="avatar-form" action="{{ route('preferences.avatar') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                                                    @csrf
                                                    <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp" style="display: none;" onchange="handleAvatarUpload(event)">
                                                </form>
                                                <div class="position-absolute bottom-0 end-0 d-flex gap-1" onclick="event.stopPropagation();">
                                                    <button type="button" class="btn btn-primary rounded-circle" 
                                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; padding: 0; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.2); background-color: #4a6cf7; transition: all 0.3s ease;"
                                                            onclick="document.getElementById('avatar').click()"
                                                            title="Choisir une photo"
                                                            onmouseover="this.style.transform='scale(1.1)'; this.style.backgroundColor='#2c7be5';"
                                                            onmouseout="this.style.transform='scale(1)'; this.style.backgroundColor='#4a6cf7';">
                                                        <i class="fas fa-folder-open" style="font-size: 1rem; color: white;"></i>
                                                    </button>
                                                    @if($user->avatar)
                                                    <button type="button" class="btn btn-danger rounded-circle delete-avatar-btn" 
                                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; padding: 0; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;"
                                                            title="Supprimer la photo"
                                                            onmouseover="this.style.transform='scale(1.1)';"
                                                            onmouseout="this.style.transform='scale(1)';">
                                                        <i class="fas fa-trash-alt" style="font-size: 1rem;"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                                
                                                @if($user->avatar)
                                                <form id="remove-avatar-form" action="{{ route('preferences.avatar.remove') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="text-muted mt-2">Cliquez sur l'icône pour changer votre photo de profil</p>
                                        <div id="avatar-error" class="text-danger small mt-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Colonne de droite : Formulaire -->
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Paramètres du compte</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('preferences.update') }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-4">
                                            <h6 class="mb-3">Thème de l'application</h6>
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input theme-radio" type="radio" name="theme" id="theme-light" value="light" 
                                                           {{ (old('theme', $user->theme ?? 'light') === 'light') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="theme-light">
                                                        <i class="fas fa-sun me-1"></i> Clair
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input theme-radio" type="radio" name="theme" id="theme-dark" value="dark"
                                                           {{ (old('theme', $user->theme) === 'dark') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="theme-dark">
                                                        <i class="fas fa-moon me-1"></i> Sombre
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input theme-radio" type="radio" name="theme" id="theme-system" value="system"
                                                           {{ (old('theme', $user->theme) === 'system') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="theme-system">
                                                        <i class="fas fa-desktop me-1"></i> Système
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <h6 class="mb-3">Langue</h6>
                                            <select class="form-select" id="language" name="language" style="max-width: 200px;">
                                                <option value="fr" {{ (old('language', $user->language ?? 'fr') === 'fr') ? 'selected' : '' }}>Français</option>
                                                <option value="en" {{ (old('language', $user->language) === 'en') ? 'selected' : '' }}>English</option>
                                            </select>
                                        </div>

                                        <div class="mt-4 pt-3 border-top">
                                            <h6 class="mb-3">Changer de mot de passe</h6>
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle me-2"></i> Laissez ces champs vides si vous ne souhaitez pas modifier votre mot de passe.
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="current_password" class="form-label">Mot de passe actuel <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                                           id="current_password" name="current_password" autocomplete="current-password"
                                                           placeholder="Entrez votre mot de passe actuel"
                                                           aria-describedby="currentPasswordHelp">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @error('current_password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <small id="currentPasswordHelp" class="form-text text-muted">
                                                    Requis uniquement pour modifier votre mot de passe.
                                                </small>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="new_password" class="form-label">Nouveau mot de passe</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                                           id="new_password" name="new_password" autocomplete="new-password"
                                                           placeholder="Laissez vide pour ne pas changer"
                                                           aria-describedby="passwordHelp">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @error('new_password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <small id="passwordHelp" class="form-text text-muted">
                                                    Doit contenir au moins 8 caractères.
                                                </small>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                                           id="new_password_confirmation" name="new_password_confirmation"
                                                           placeholder="Confirmez votre nouveau mot de passe"
                                                           autocomplete="new-password">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password_confirmation">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="password-strength mt-2 mb-3">
                                                <div class="progress" style="height: 5px;">
                                                    <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
                                                </div>
                                                <small id="password-strength-text" class="form-text"></small>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-1"></i> Enregistrer les modifications
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Password Toggle Functionality ---
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    // --- Toast Notifications ---
    function showToast(message, type = 'success') {
        const toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            console.error('Toast container not found!');
            alert(message); // Fallback
            return;
        }
        const toastEl = toastContainer.querySelector('.toast');
        const toastBody = toastContainer.querySelector('.toast-body');
        if (!toastEl || !toastBody) return;

        toastBody.textContent = message;
        toastEl.className = 'toast align-items-center text-white border-0'; // Reset classes
        toastEl.classList.add(`bg-${type}`);
        const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
        toast.show();
    }

    // --- Avatar Management (AJAX) ---
    const avatarInput = document.getElementById('avatar-upload');
    const avatarContainer = document.getElementById('avatar-container');
    const avatarPreview = document.querySelector('.user-avatar-preview');
    const uploadBtn = document.querySelector('.upload-avatar-btn');
    const deleteBtn = document.querySelector('.delete-avatar-btn');
    const deleteForm = document.getElementById('delete-avatar-form');

    if (uploadBtn) {
        uploadBtn.addEventListener('click', (e) => { e.stopPropagation(); avatarInput.click(); });
    }
    if (avatarContainer) {
        avatarContainer.addEventListener('click', (e) => { if (!e.target.closest('.btn')) avatarInput.click(); });
    }

    if (avatarInput) {
        avatarInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) { return showToast('Format de fichier non supporté.', 'danger'); }
            if (file.size > 5 * 1024 * 1024) { return showToast('Le fichier est trop volumineux (max 5MB).', 'danger'); }

            const reader = new FileReader();
            reader.onload = (e) => { 
                avatarPreview.style.backgroundImage = `url('${e.target.result}')`;
                avatarPreview.innerHTML = '';
            };
            reader.readAsDataURL(file);

            const formData = new FormData();
            formData.append('avatar', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            uploadBtn.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div>';
            uploadBtn.disabled = true;

            fetch('{{ route("preferences.avatar") }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(res => res.json().then(data => ({ok: res.ok, data})))
            .then(({ok, data}) => {
                if (!ok) throw new Error(data.message || 'Erreur serveur');
                
                showToast('Avatar mis à jour avec succès!');
                const newUrl = `${data.avatar_url}?v=${new Date().getTime()}`;
                avatarPreview.style.backgroundImage = `url('${newUrl}')`;
                document.querySelectorAll('.navbar .user-avatar').forEach(el => {
                    el.style.backgroundImage = `url('${newUrl}')`;
                    el.innerHTML = '';
                });

                if (!deleteBtn) window.location.reload(); // Reload to show delete button if it wasn't there
            })
            .catch(error => {
                showToast(error.message, 'danger');
                if (avatarPreview.dataset.initialUrl) {
                    avatarPreview.style.backgroundImage = `url('${avatarPreview.dataset.initialUrl}')`;
                } else {
                    avatarPreview.style.backgroundImage = 'none';
                    avatarPreview.innerHTML = avatarPreview.dataset.initials;
                }
            })
            .finally(() => {
                uploadBtn.innerHTML = '<i class="fas fa-camera"></i>';
                uploadBtn.disabled = false;
                avatarInput.value = '';
            });
        });
    }

    if (deleteBtn) {
        deleteBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (!confirm('Êtes-vous sûr de vouloir supprimer votre photo de profil ?')) return;

            deleteBtn.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div>';
            deleteBtn.disabled = true;

            fetch(deleteForm.action, {
                method: 'POST',
                body: new FormData(deleteForm),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json().then(data => ({ok: res.ok, data})))
            .then(({ok, data}) => {
                if (!ok) throw new Error(data.message || 'Erreur serveur');

                showToast('Avatar supprimé avec succès!');
                const initials = avatarPreview.dataset.initials;
                [avatarPreview, ...document.querySelectorAll('.navbar .user-avatar')].forEach(el => {
                    el.style.backgroundImage = 'none';
                    el.style.backgroundColor = '#007bff';
                    el.innerHTML = initials;
                });
                deleteBtn.remove();
            })
            .catch(error => {
                showToast(error.message, 'danger');
                deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                deleteBtn.disabled = false;
            });
        });
    }

    // --- Theme Management (Form Submission) ---
    document.querySelectorAll('input[name="theme"]').forEach(radio => {
        radio.addEventListener('change', function () { this.closest('form').submit(); });
    });
});
</script>
@endpush

@endsection
