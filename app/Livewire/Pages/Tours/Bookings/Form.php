<?php

namespace App\Livewire\Pages\Tours\Bookings;

use Livewire\Component;
use App\Models\Tours\Tour;
use App\Models\Tours\Booking;
use Illuminate\Support\Str;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class Form extends Component
{
    public $tour;

    public $name, $email, $phone_number, $date_of_travel, $additional_information;
    public $number_of_adults = 1;
    public $number_of_children = 0;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone_number' => 'required|string|max:20',
        'number_of_adults' => 'required|integer|min:1',
        'number_of_children' => 'nullable|integer|min:0',
        'date_of_travel' => 'nullable|date|after:today',
        'additional_information' => 'nullable|string|max:1000',
    ];

    public function mount($tour)
    {
        $this->tour = Tour::where('slug', $tour)->firstOrFail();
    }

    protected function generateBookingCode()
    {
        do {
            $date = now()->format('dmy');
            $random = strtoupper(Str::random(5));

            $code = "{$random}-{$date}";
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }

    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $booking = Booking::create([
                'booking_code' => $this->generateBookingCode(),
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'number_of_adults' => $this->number_of_adults,
                'number_of_children' => $this->number_of_children,
                'date_of_travel' => $this->date_of_travel,
                'additional_information' => $this->additional_information,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'tour_id' => $this->tour->id,
            ]);

            Mail::to($booking->email)->send(new BookingConfirmationMail($booking));

            DB::commit();

            return redirect()->route('book-tour-success', $booking->uuid);
        } catch (Throwable $e) {
            DB::rollback();

            Log::channel('tours')->error('Booking failed: ', [
                'error' => $e->getMessage(),
                'user_input' => [
                    'email' => $this->email,
                    'tour' => $this->tour->id ?? null,
                ],
            ]);

            $this->addError('submit_error', 'Something went wrong. Please try again.');

            return;
        }

    }

    public function render()
    {
        return view('livewire.pages.tours.bookings.form')->layout('layouts.guest');
    }
}
