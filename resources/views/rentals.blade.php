@include('_header')

<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background: #f9f9fb;
    }

    .rentals {
        padding: 2rem 1rem;
    }

    h3 {
        font-weight: 600;
        color: #1c1c1e;
    }

    /* Search bar styling */
    .search-container {
        backdrop-filter: blur(12px);
        background: rgba(255, 255, 255, 0.7);
        border-radius: 14px;
        padding: 0.5rem;
        display: flex;
        gap: 0.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        width: 100%;
        max-width: 700px;
        margin: 0 auto;
    }

    .search-container input {
        border: none;
        flex: 1;
        padding: 0.6rem 1rem;
        border-radius: 10px;
        background: rgba(255,255,255,0.6);
        outline: none;
        font-size: 1rem;
    }

    .search-container button {
        background-color: #007aff;
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-weight: 500;
        transition: 0.3s;
    }

    .search-container button:hover {
        background-color: #0062cc;
    }

    /* Rental card styling */
    .rental-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 30px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: row;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-bottom: 1.5rem;
    }

    .rental-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .rental-card img {
        object-fit: cover;
        width: 200px;
        height: 100%;
    }

    .rental-info {
        padding: 1rem;
        flex: 1;
    }

    .status-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.8rem;
    }

    .status-waiting { background: rgba(255, 204, 0, 0.2); color: #b38f00; }
    .status-approved { background: rgba(52, 199, 89, 0.2); color: #34c759; }
    .status-expired { background: rgba(255, 59, 48, 0.2); color: #ff3b30; }

    .rental-info p {
        margin-bottom: 0.4rem;
        font-size: 1rem;
        color: #3a3a3c;
    }

    .rental-info b {
        color: #1c1c1e;
    }
</style>

<section class="rentals">
    <div class="container">
        <h3 class="text-center mb-4">Mes Locations</h3>

        <!-- Search -->
        <div class="search-container mb-4">
            <input type="text" id="search" placeholder="Rechercher..." onkeyup="filterRentals()">
            <button onclick="filterRentals();return false;">Rechercher</button>
        </div>

        <!-- Rentals list -->
        <div id="rentalsContainer">
            @foreach ($rentals as $rental)
                <div class="rental-card">
                    <img src="{{ asset($rental->car->images) }}" alt="voiture">
                    <div class="rental-info">
                        @if ($rental->status == '1')
                            <span class="status-badge status-waiting">En attente d'approbation</span>
                        @elseif ($rental->status == '2')
                            <span class="status-badge status-approved">Réservation approuvée</span>
                        @elseif ($rental->status == '3')
                            <span class="status-badge status-expired">Réservation expirée</span>
                        @endif

                        <p><b>Désignation:</b> {{ $rental->car->brand }}</p>
                        <p><b>Modèle:</b> {{ $rental->car->model }}</p>
                        <p><b>Début de location:</b> {{ Str::substr($rental->rental_date, 0, 10) }}</p>
                        <p><b>Fin de location:</b> {{ Str::substr($rental->return_date, 0, 10) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
function filterRentals(){
    const query = document.getElementById('search').value.toLowerCase();
    const cards = document.querySelectorAll('#rentalsContainer .rental-card');
    cards.forEach(card => {
        const txt = card.textContent.toLowerCase();
        card.style.display = txt.includes(query) ? '' : 'none';
    });
}
</script>

@include('_footer')
