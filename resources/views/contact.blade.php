@extends('layouts.app')

@push('styles')
<style>
    .contact-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 85vh;
        padding: 3rem 1rem;
        background-color: #f5f5f7;
    }
    .contact-card {
        width: 100%;
        max-width: 650px;
        background: #ffffff;
        padding: 3rem;
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .contact-card h1 {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #1c1c1e;
    }
    .contact-card p.subtitle {
        color: #8a8a8e;
        margin-bottom: 2.5rem;
    }
    .form-control {
        background-color: #f5f5f7;
        border: 1px solid #e5e5e7;
        border-radius: 0.8rem;
        padding: 0.9rem 1rem;
        font-size: 1rem;
        transition: all 0.2s ease-in-out;
    }
    .form-control:focus {
        background-color: #ffffff;
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
    }
    .btn-contact {
        width: 100%;
        padding: 0.9rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 0.8rem;
        background-color: #007bff;
        border: none;
        color: white;
        transition: background-color 0.2s ease;
    }
    .btn-contact:hover {
        background-color: #0056b3;
    }
    .contact-info {
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e5e7;
    }
    .contact-info p {
        color: #8a8a8e;
        margin-bottom: 1.5rem;
    }
    .contact-info a {
        color: #3a3a3c;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
        margin: 0 1rem;
    }
    .contact-info a:hover {
        color: #007bff;
    }
    .alert-danger {
        border-radius: 0.8rem;
        text-align: left;
    }
</style>
@endpush

@section('content')
<div class="contact-container">
    <div class="contact-card">
        <h1 class="page-title">Contactez-nous</h1>
        <p class="subtitle">Vous avez une question ou un commentaire ? Remplissez le formulaire ci-dessous.</p>

        <!-- Form Success Message -->
        <div id="form-success" class="alert alert-success d-none">
            Votre message a été envoyé avec succès !
        </div>

        <!-- Form Errors -->
        <div id="form-errors" class="alert alert-danger d-none">
            <ul class="mb-0"></ul>
        </div>

        <form id="contactForm" method="POST" action="{{ route('contact.send') }}">
            @csrf
            <div class="mb-3 text-start">
                <label for="name" class="form-label">Nom Complet <span class="text-danger">*</span></label>
                @auth
                                    <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" readonly required>
                                @else
                                    <input type="text" class="form-control" id="name" name="name" required>
                                @endauth
            </div>

            <div class="mb-3 text-start">
                <label for="email" class="form-label">Adresse E-mail <span class="text-danger">*</span></label>
                @auth
                                    <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" readonly required>
                                @else
                                    <input type="email" class="form-control" id="email" name="email" required>
                                @endauth
            </div>

            <div class="mb-3 text-start">
                <label for="subject" class="form-label">Sujet <span class="text-danger">*</span></label>
                <select class="form-select" id="subject" name="subject" required>
                    <option value="" disabled selected>Choisissez un sujet</option>
                    <option value="bug">Bug</option>
                    <option value="entretien">Entretien</option>
                    <option value="probleme">Problème</option>
                    <option value="assistance">Assistance</option>
                </select>
            </div>
            
            
            
            <div class="mb-4 text-start">
                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-contact">
                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                    <span class="submit-text">Envoyer le Message</span>
                </button>
            </div>
        </form>

        
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('contactForm');
        const successAlert = document.getElementById('form-success');
        const errorAlert = document.getElementById('form-errors');
        const errorList = errorAlert.querySelector('ul');
        const submitButton = form.querySelector('button[type="submit"]');
        const spinner = submitButton.querySelector('.spinner-border');
        const submitText = submitButton.querySelector('.submit-text');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Reset states
            submitButton.disabled = true;
            spinner.classList.remove('d-none');
            submitText.textContent = 'Envoi en cours...';
            successAlert.classList.add('d-none');
            errorAlert.classList.add('d-none');
            errorList.innerHTML = '';

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    successAlert.classList.remove('d-none');
                    form.reset();
                } else if (data.errors) {
                    Object.values(data.errors).forEach(errors => {
                        errors.forEach(error => {
                            const li = document.createElement('li');
                            li.textContent = error;
                            errorList.appendChild(li);
                        });
                    });
                    errorAlert.classList.remove('d-none');
                } else {
                    const li = document.createElement('li');
                    li.textContent = data.message || 'Une erreur inattendue est survenue.';
                    errorList.appendChild(li);
                    errorAlert.classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const li = document.createElement('li');
                li.textContent = 'Une erreur de connexion est survenue. Veuillez réessayer.';
                errorList.appendChild(li);
                errorAlert.classList.remove('d-none');
            })
            .finally(() => {
                submitButton.disabled = false;
                spinner.classList.add('d-none');
                submitText.textContent = 'Envoyer le Message';
            });
        });
    });
</script>
@endpush