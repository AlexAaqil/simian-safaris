@component('mail::message')
# Booking Confirmation

Hello {{ $booking->first_name }},

Thank you for booking with us. Here are your booking details:

<p><strong>Booking Code:</strong> {{ $booking->booking_code }}</p>
<p><strong>Tour Name:</strong> {{ $booking->tour->title }}</p>
<p><strong>Travel Date:</strong> {{ $booking->date_of_travel->format('jS M Y') ?? 'Not specified' }}</p>
<p><strong>Adults:</strong> {{ $booking->number_of_adults }}</p>
<p><strong>Children:</strong> {{ $booking->number_of_children }}</p>

<p><strong>Additional Notes:</strong> {{ $booking->additional_information ?? 'Not Specified' }}</p>

@component('mail::button', ['url' => route('book-tour-success', $booking->uuid)])
View Your Booking
@endcomponent

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
