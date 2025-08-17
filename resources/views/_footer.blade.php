@php($year = date('Y'))
<footer class="footer bg-dark text-white pt-5 pb-4">
    <div class="container">
        <div class="row g-4">
            <!-- About Section -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="fw-bold mb-3">Car Rental Management</h5>
                <p class="text-white-50">Votre partenaire de confiance pour la location de voitures haut de gamme. Service professionnel et véhicules de qualité.</p>
                <div class="social-links mt-3">
                    <a href="#" class="social-icon me-2" target="_blank" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon me-2" target="_blank" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon me-2" target="_blank" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon me-2" target="_blank" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="fw-bold mb-3">Liens rapides</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('car.acceuil') }}" class="text-white-50 text-decoration-none">Accueil</a></li>
                    <li class="mb-2"><a href="{{ route('car.cars') }}" class="text-white-50 text-decoration-none">Nos véhicules</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Tarifs</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">À propos</a></li>
                    <li><a href="{{ route('contact.form') }}" class="text-white-50 text-decoration-none">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="fw-bold mb-3">Contactez-nous</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i> 123 Rue de la Location, Paris
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone me-2"></i> +33 1 23 45 67 89
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2"></i> contact@carrental.com
                    </li>
                    <li>
                        <i class="fas fa-clock me-2"></i> Lun-Sam: 8h-20h
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="fw-bold mb-3">Newsletter</h5>
                <p class="text-white-50">Inscrivez-vous pour recevoir nos offres spéciales</p>
                <form class="newsletter-form">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Votre email" aria-label="Votre email" required>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="mt-0 mb-4">
        
        <!-- Copyright -->
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-0 text-white-50">&copy; {{ $year }} Car Rental Management. Tous droits réservés.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0 fw-medium">Fait avec <i class="fas fa-heart text-danger"></i> par Anis & Yassine</p>
            </div>
        </div>
    </div>
</footer>

@include('components.chatbot')

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
</body>