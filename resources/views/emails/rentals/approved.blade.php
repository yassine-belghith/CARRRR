<x-mail::message>
# Your Rental Request is Approved!

Hello {{ $rental->user->name }},

We are pleased to inform you that your rental request for the **{{ $rental->car->brand }} {{ $rental->car->model }}** has been approved.

Here are the details of your rental:
- **Start Date:** {{ $rental->start_date->format('F d, Y') }}
- **End Date:** {{ $rental->end_date->format('F d, Y') }}
- **Total Price:** {{ number_format($rental->total_price, 2) }} {{ $rental->currency }}

You can view your rental details and manage your bookings by clicking the button below.

<x-mail::button :url="route('rentals.index')">
View My Rentals
</x-mail::button>

Thank you for choosing our service. We look forward to seeing you!

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
