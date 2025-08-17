<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher de Transfert</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.6;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #000;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .details-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 15px;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name', 'Car Rental') }}</h1>
            <p>Voucher de Transfert</p>
            <p><strong>Référence :</strong> {{ $transfer->reference_number }}</p>
        </div>

        <div class="section-title">Détails de la Réservation</div>
        <table class="details-table">
            <tr>
                <th>Nom du Client</th>
                <td>{{ $transfer->customer_name }}</td>
            </tr>
            <tr>
                <th>Date et Heure de Prise en Charge</th>
                <td>{{ $transfer->pickup_datetime ? $transfer->pickup_datetime->format('d/m/Y à H:i') : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Lieu de Prise en Charge</th>
                <td>{{ $transfer->pickup_location }}</td>
            </tr>
            <tr>
                <th>Lieu de Destination</th>
                <td>{{ $transfer->dropoff_location }}</td>
            </tr>
            @if($transfer->flight_number)
            <tr>
                <th>Numéro de Vol</th>
                <td>{{ $transfer->airline }} {{ $transfer->flight_number }}</td>
            </tr>
            @endif
        </table>

        <div class="section-title">Informations sur le Véhicule</div>
        <table class="details-table">
            <tr>
                <th>Véhicule Assigné</th>
                <td>{{ $transfer->car ? $transfer->car->brand . ' ' . $transfer->car->model : 'Non spécifié' }}</td>
            </tr>
            <tr>
                <th>Passagers</th>
                <td>{{ $transfer->passenger_count }}</td>
            </tr>
            <tr>
                <th>Bagages</th>
                <td>{{ $transfer->luggage_count }}</td>
            </tr>
        </table>

        <div class="section-title">Informations sur le Paiement</div>
        <table class="details-table">
            <tr>
                <th>Prix Total</th>
                <td>{{ number_format($transfer->price, 2, ',', ' ') }} {{ $transfer->currency }}</td>
            </tr>
            <tr>
                <th>Statut du Paiement</th>
                <td>{{ ucfirst($transfer->payment_status) }}</td>
            </tr>
        </table>

        @if($transfer->special_instructions)
            <div class="section-title">Instructions Spéciales</div>
            <p>{{ $transfer->special_instructions }}</p>
        @endif

        <div class="footer">
            <p>Merci d'avoir choisi nos services. Nous vous souhaitons un excellent voyage !</p>
            <p>{{ config('app.name') }} - Contact : example@email.com</p>
        </div>
    </div>
</body>
</html>
