<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture - {{ $transfer->reference_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
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
            font-size: 24px;
            color: #000;
        }
        .invoice-details, .client-details, .transfer-details {
            margin-bottom: 30px;
        }
        .invoice-details table, .client-details table, .transfer-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details th, .client-details th, .transfer-details th {
            text-align: left;
            padding: 8px;
            background-color: #f2f2f2;
            border-bottom: 1px solid #ddd;
        }
        .invoice-details td, .client-details td, .transfer-details td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-section h3 {
            font-size: 16px;
            color: #000;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>FACTURE</h1>
        </div>

        <div class="invoice-details">
            <table>
                <tr>
                    <th>Numéro de Référence</th>
                    <td>{{ $transfer->reference_number }}</td>
                </tr>
                <tr>
                    <th>Date de la Facture</th>
                    <td>{{ now()->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Statut</th>
                    <td>{{ $transfer->status_label }}</td>
                </tr>
            </table>
        </div>

        <div class="client-details">
            <h3>Client</h3>
            <table>
                <tr>
                    <th>Nom</th>
                    <td>{{ $transfer->user?->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $transfer->user?->email ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <div class="transfer-details">
            <h3>Détails du Transfert</h3>
            <table>
                <tr>
                    <th>Date et Heure de Prise en Charge</th>
                    <td>{{ $transfer->pickup_datetime?->format('d/m/Y \à H:i') ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Lieu de Prise en Charge</th>
                    <td>
                        @if(isset($transfer->pickup_latitude, $transfer->pickup_longitude))
                            Lat: {{ number_format($transfer->pickup_latitude, 5) }}, Lng: {{ number_format($transfer->pickup_longitude, 5) }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Lieu de Dépose</th>
                    <td>
                        @if(isset($transfer->dropoff_latitude, $transfer->dropoff_longitude))
                            Lat: {{ number_format($transfer->dropoff_latitude, 5) }}, Lng: {{ number_format($transfer->dropoff_longitude, 5) }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Véhicule</th>
                    <td>{{ $transfer->car?->name ?? 'Non assigné' }} ({{ $transfer->car?->type ?? '' }})</td>
                </tr>
                <tr>
                    <th>Passagers</th>
                    <td>{{ $transfer->passenger_count }}</td>
                </tr>
            </table>
        </div>

        <div class="total-section">
            <h3>Total à Payer : {{ number_format($transfer->price, 2, ',', ' ') }} €</h3>
            <p>(Le prix final sera confirmé par un administrateur)</p>
        </div>

        <div class="footer">
            <p>Merci d'avoir choisi nos services.</p>
            <p>Votre Agence de Location</p>
        </div>
    </div>
</body>
</html>
