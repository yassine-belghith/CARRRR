@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
<style>
    body, .welcome-page {
        font-family: 'Inter', sans-serif;
        background-color: #121212;
        color: #e0e0e0;
    }

    * {
        transition: all 0.3s ease-in-out;
    }

    .hero-main {
        position: relative;
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden;
        padding: 2rem 0;
    }

    .spline-background {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 900px;
        width: 100%;
        padding: 1rem;
        animation: fadeIn 1.5s ease;
    }

    .hero-content h1 {
        font-size: 4rem;
        font-weight: 900;
        line-height: 1.2;
        background: linear-gradient(90deg, #3d5afe, #00bcd4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
    }

    .hero-content p {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 2rem;
    }

    .contact-form-body {
        background-color: rgba(0, 0, 0, 0.4);
        padding: 2.5rem;
        border-radius: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .form-label {
        font-weight: 600;
        color: #fff;
    }

    .form-control,
    .form-select {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        border: 1px solid #444;
        background-color: #222;
        color: #fff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3d5afe;
        box-shadow: 0 0 0 0.2rem rgba(61, 90, 254, 0.25);
    }

    .btn-primary {
        background-color: #3d5afe;
        border: none;
        font-weight: 600;
        padding: 0.9rem;
        border-radius: 0.5rem;
        box-shadow: 0 10px 20px rgba(61, 90, 254, 0.3);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #2c49c9;
        transform: translateY(-2px);
    }

    .alert {
        text-align: left;
        border-radius: 0.5rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="welcome-page">
    <section class="hero-main">
        <div class="spline-background">
            <spline-viewer url="https://prod.spline.design/LM0LrWOAlS428xr8/scene.splinecode"></spline-viewer>
        </div>
        <div class="hero-content">
            <h1>Contactez-nous</h1>
            <p>Vous avez une question ou un commentaire ? Remplissez le formulaire ci-dessous.</p>
            <div class="contact-form-body">

                <div id="form-success" class="alert alert-success d-none"></div>
                <div id="form-errors" class="alert alert-danger d-none"><ul class="mb-0"></ul></div>

                <form id="contactForm" method="POST" action="{{ route('contact.send') }}" class="mt-3">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6 text-start">
                            <label for="name" class="form-label">Nom Complet <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name ?? '' }}" {{ auth()->check() ? 'readonly' : '' }} required>
                        </div>

                        <div class="col-md-6 text-start">
                            <label for="email" class="form-label">Adresse E-mail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email ?? '' }}" {{ auth()->check() ? 'readonly' : '' }} required>
                        </div>

                        <div class="col-12 text-start">
                            <label for="subject" class="form-label">Sujet <span class="text-danger">*</span></label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="" disabled selected>Choisissez un sujet</option>
                                <option value="bug">Bug</option>
                                <option value="entretien">Entretien</option>
                                <option value="probleme">Problème</option>
                                <option value="assistance">Assistance</option>
                            </select>
                        </div>

                        <div class="col-12 text-start">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                <span class="submit-text">Envoyer le Message</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script type="module" src="https://unpkg.com/@splinetool/viewer/build/spline-viewer.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('contactForm');
        if (!form) return;

        const successAlert = document.getElementById('form-success');
        const errorAlert = document.getElementById('form-errors');
        const errorList = errorAlert.querySelector('ul');
        const submitButton = form.querySelector('button[type="submit"]');
        const spinner = submitButton.querySelector('.spinner-border');
        const submitText = submitButton.querySelector('.submit-text');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            submitButton.disabled = true;
            spinner.classList.remove('d-none');
            submitText.textContent = 'Envoi en cours...';
            successAlert.classList.add('d-none');
            errorAlert.classList.add('d-none');
            errorList.innerHTML = '';

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    successAlert.textContent = data.message || 'Votre message a été envoyé avec succès !';
                    successAlert.classList.remove('d-none');
                    form.reset();
                     @auth
                        form.querySelector('#name').value = "{{ auth()->user()->name }}";
                        form.querySelector('#email').value = "{{ auth()->user()->email }}";
                    @endauth
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