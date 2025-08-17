@extends('dashboard.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4 text-black text-center">Préférences du profil</h3>
                    
                    <!-- Success/Error Messages -->
                    <div id="alert-container">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Avatar Section -->
                    <div class="mb-4 text-center">
                        <div class="position-relative d-inline-block">
                            <div id="avatar-preview" class="user-avatar-large mb-3" 
                                 style="background-image: url('{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/default-avatar.png') }}');">
                                @if(!Auth::user()->avatar)
                                    <i id="avatar-icon" class="fas fa-user fa-3x text-white"></i>
                                @endif
                            </div>
                            <div class="mt-2">
                                <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*">
                                <button type="button" id="change-avatar-btn" class="btn btn-sm btn-outline-dark mb-0 me-2">
                                    <i class="fas fa-camera me-1"></i> Changer la photo
                                </button>
                                @if(Auth::user()->avatar)
                                    <button type="button" id="remove-avatar-btn" class="btn btn-sm btn-outline-danger mb-0">
                                        <i class="fas fa-trash me-1"></i> Supprimer
                                    </button>
                                @endif
                                <div id="avatar-loading" class="spinner-border spinner-border-sm d-none" role="status">
                                    <span class="visually-hidden">Chargement...</span>
                                </div>
                            </div>
                            <div id="avatar-error" class="invalid-feedback d-block"></div>
                        </div>
                    </div>
                    
                    <!-- Profile Form -->
                    <form id="profile-form" action="{{ route('preferences.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom complet</label>
                            <input type="text" class="form-control form-control-lg" name="name" id="name" 
                                   value="{{ old('name', Auth::user()->name) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control form-control-lg" name="email" id="email" 
                                   value="{{ old('email', Auth::user()->email) }}" required>
                        </div>
                        
                        <!-- Theme Selection -->
                        <div class="mb-4">
                            <label class="form-label">Thème</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="theme" id="theme-light" 
                                           value="light" {{ Auth::user()->theme === 'light' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="theme-light">
                                        <i class="fas fa-sun me-1"></i> Clair
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="theme" id="theme-dark" 
                                           value="dark" {{ Auth::user()->theme === 'dark' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="theme-dark">
                                        <i class="fas fa-moon me-1"></i> Sombre
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="theme" id="theme-system" 
                                           value="system" {{ Auth::user()->theme === 'system' || !Auth::user()->theme ? 'checked' : '' }}>
                                    <label class="form-check-label" for="theme-system">
                                        <i class="fas fa-desktop me-1"></i> Système
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Language Selection -->
                        <div class="mb-4">
                            <label for="language" class="form-label">Langue</label>
                            <select class="form-select form-select-lg" name="language" id="language">
                                <option value="fr" {{ Auth::user()->language === 'fr' ? 'selected' : '' }}>Français</option>
                                <option value="en" {{ Auth::user()->language === 'en' ? 'selected' : '' }}>English</option>
                            </select>
                        </div>
                        
                        <!-- Password Change Section -->
                        <div class="card border-0 bg-light p-3 mb-4">
                            <h6 class="mb-3">Changer le mot de passe</h6>
                            <p class="text-muted small mb-3">Laissez ces champs vides si vous ne souhaitez pas changer de mot de passe.</p>
                            
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mot de passe actuel</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="current_password" id="current_password"
                                           placeholder="Entrez votre mot de passe actuel">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Nouveau mot de passe</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="new_password" id="new_password"
                                           placeholder="Laissez vide pour ne pas changer">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text">Le mot de passe doit contenir au moins 8 caractères.</div>
                            </div>
                            
                            <div class="mb-0">
                                <label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation"
                                           placeholder="Confirmez le nouveau mot de passe">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password_confirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-lg" id="save-changes-btn">
                                <span class="spinner-border spinner-border-sm d-none me-2" id="save-spinner" role="status" aria-hidden="true"></span>
                                <i class="fas fa-save me-2"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // CSRF Token for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Toggle password visibility
    $('.toggle-password').click(function() {
        const targetId = $(this).data('target');
        const input = $('#' + targetId);
        const icon = $(this).find('i');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Handle avatar change
    $('#change-avatar-btn').click(function() {
        $('#avatar').click();
    });

    // Preview avatar on file select
    $('#avatar').change(function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            showAlert('Type de fichier non pris en charge. Veuillez sélectionner une image (JPEG, PNG, GIF, WebP).', 'danger');
            return;
        }
        
        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            showAlert('La taille du fichier ne doit pas dépasser 5 Mo.', 'danger');
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#avatar-preview').css('background-image', `url('${e.target.result}')`);
            $('#avatar-icon').hide();
        }
        reader.readAsDataURL(file);
        
        // Upload the file
        uploadAvatar(file);
    });
    
    // Handle avatar removal
    $('#remove-avatar-btn').click(function() {
        if (confirm('Êtes-vous sûr de vouloir supprimer votre photo de profil ?')) {
            removeAvatar();
        }
    });
    
    // Handle form submission
    $('#profile-form').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submitBtn = $('#save-changes-btn');
        const $spinner = $('#save-spinner');
        
        $submitBtn.prop('disabled', true);
        $spinner.removeClass('d-none');
        
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                showAlert(response.message || 'Préférences mises à jour avec succès', 'success');
                // Update theme if changed
                if (response.theme) {
                    document.documentElement.setAttribute('data-bs-theme', response.theme);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Une erreur est survenue lors de la mise à jour des préférences.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showAlert(errorMessage, 'danger');
            },
            complete: function() {
                $submitBtn.prop('disabled', false);
                $spinner.addClass('d-none');
            }
        });
    });
    
    // Function to upload avatar
    function uploadAvatar(file) {
        const formData = new FormData();
        formData.append('avatar', file);
        
        const $loading = $('#avatar-loading');
        const $error = $('#avatar-error');
        const $changeBtn = $('#change-avatar-btn');
        const $removeBtn = $('#remove-avatar-btn');
        
        $loading.removeClass('d-none');
        $error.text('').hide();
        $changeBtn.prop('disabled', true);
        if ($removeBtn.length) $removeBtn.prop('disabled', true);
        
        $.ajax({
            url: '{{ route("preferences.avatar") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                showAlert('Photo de profil mise à jour avec succès', 'success');
                // Show remove button if it wasn't there
                if ($removeBtn.length === 0) {
                    $('<button type="button" id="remove-avatar-btn" class="btn btn-sm btn-outline-danger mb-0 ms-2">' +
                      '<i class="fas fa-trash me-1"></i> Supprimer</button>')
                      .insertAfter($changeBtn)
                      .click(function() {
                          if (confirm('Êtes-vous sûr de vouloir supprimer votre photo de profil ?')) {
                              removeAvatar();
                          }
                      });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Une erreur est survenue lors du téléchargement de l\'image.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showAlert(errorMessage, 'danger');
                // Reset file input
                $('#avatar').val('');
            },
            complete: function() {
                $loading.addClass('d-none');
                $changeBtn.prop('disabled', false);
                if ($removeBtn.length) $removeBtn.prop('disabled', false);
            }
        });
    }
    
    // Function to remove avatar
    function removeAvatar() {
        const $avatarPreview = $('#avatar-preview');
        const $avatarIcon = $('#avatar-icon');
        const $removeBtn = $('#remove-avatar-btn');
        
        $removeBtn.prop('disabled', true);
        
        $.ajax({
            url: '{{ route("preferences.avatar.remove") }}',
            method: 'DELETE',
            success: function() {
                showAlert('Photo de profil supprimée avec succès', 'success');
                $avatarPreview.css('background-image', 'none');
                $avatarIcon.show();
                $removeBtn.remove();
                // Reset file input
                $('#avatar').val('');
            },
            error: function(xhr) {
                let errorMessage = 'Une erreur est survenue lors de la suppression de la photo de profil.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showAlert(errorMessage, 'danger');
                $removeBtn.prop('disabled', false);
            }
        });
    }
    
    // Helper function to show alerts
    function showAlert(message, type) {
        const $alert = $(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
        
        $('#alert-container').html($alert);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            $alert.alert('close');
        }, 5000);
    }
});
</script>
@endpush

<style>
.user-avatar-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    background-color: #f0f0f0;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #fff;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.cursor-pointer {
    cursor: pointer;
}

.toggle-password {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

#avatar-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.btn-outline-dark:hover {
    color: #fff;
}

.btn-outline-danger:hover {
    color: #fff;
}
</style>
@endsection
