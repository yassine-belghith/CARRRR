<x-mail::message>
# Your Rental is Confirmed!

Hello {{ $rental->user->name }},

Great news! Your rental request has been approved.

Here are the details of your booking:
- **Car:** {{ $rental->car->brand }} {{ $rental->car->model }}
- **Rental Start Date:** {{ $rental->rental_date }}
- **Rental End Date:** {{ $rental->return_date }}
- **Total Price:** {{ $rental->total_price }} {{ $rental->currency }}

We look forward to seeing you soon.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
