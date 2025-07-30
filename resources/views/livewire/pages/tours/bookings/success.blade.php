<div class="max-w-xl mx-auto my-10 p-6 bg-green-50 shadow rounded space-y-2">
    <h2 class="text-xl font-bold mb-4">🎉 Booking Confirmed!</h2>
    <p>Thank you <strong>{{ $booking->first_name }}</strong> for booking <strong>{{ $booking->tour->title }}</strong>.</p>
    <p>Your Booking Code: <code class="bg-green-100 text-green-900 font-bold p-1 rounded">{{ $booking->booking_code }}</code></p>
    <p>Use this code (which you can also find in your email) for any follow-up or check-in.</p>

    <div class="buttons_group">
        <a href="{{ Route::has('tours-page') ? route('tours-page') : route('home-page') }}" class="btn btn_link">Explore more tours</a>
    </div>
</div>
