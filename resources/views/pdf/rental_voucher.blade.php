<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Voucher de Location</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; font-size: 12px; line-height: 1.6; }
        .container { width: 100%; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { margin: 0; font-size: 28px; color: #000; }
        .header p { margin: 5px 0; font-size: 14px; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .details-table th, .details-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .details-table th { background-color: #f2f2f2; font-weight: bold; }
        .section-title { font-size: 18px; font-weight: bold; margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #eee; padding-bottom: 5px; }
        .footer { text-align: center; margin-top: 40px; font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name', 'Car Rental') }}</h1>
            <p>Voucher de Location de Véhicule</p>
            <p><strong>Référence :</strong> {{ $rental->reference_number }}</p>
        </div>

        <div class="section-title">Détails de la Location</div>
        <table class="details-table">
            <tr>
                <th>Client</th>
                <td>{{ $rental->user->name }}</td>
            </tr>
            <tr>
                <th>Date de Début</th>
                <td>{{ $rental->rental_date->format('d/m/Y à H:i') }}</td>
            </tr>
            <tr>
                <th>Date de Fin</th>
                <td>{{ $rental->return_date->format('d/m/Y à H:i') }}</td>
            </tr>
            <tr>
                <th>Lieu de Prise en Charge</th>
                <td>{{ $rental->pickup_location }}</td>
            </tr>
            <tr>
                <th>Lieu de Retour</th>
                <td>{{ $rental->dropoff_location }}</td>
            </tr>
        </table>

        <div class="section-title">Informations sur le Véhicule</div>
        <table class="details-table">
            <tr>
                <th>Véhicule</th>
                <td>{{ $rental->car->brand }} {{ $rental->car->model }}</td>
            </tr>
            <tr>
                <th>Immatriculation</th>
                <td>{{ $rental->car->license_plate }}</td>
            </tr>
        </table>

        <div class="section-title">Informations sur le Paiement</div>
        <table class="details-table">
            <tr>
                <th>Prix Total</th>
                <td>{{ number_format($rental->total_price, 2, ',', ' ') }} €</td>
            </tr>
            <tr>
                <th>Statut du Paiement</th>
                <td>{{ ucfirst($rental->payment_status) }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Merci de votre confiance. Nous vous souhaitons une excellente route !</p>
            <p>{{ config('app.name') }} - Contact : contact@example.com</p>
        </div>
    </div>
</body>
</html>
