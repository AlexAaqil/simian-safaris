<?php

namespace App\Livewire\Pages\Tours\Bookings;

use Livewire\Component;
use App\Models\Tours\Booking;
use Illuminate\Support\Carbon;

class Edit extends Component
{
    public $booking;

    public string $status = '';
    public string $payment_status = '';
    public string $date_of_travel = '';
    public float $total_amount = 0;
    public float $amount_paid = 0;
    public string $comments = '';

    public function mount($booking)
    {
        $this->booking = Booking::where('uuid', $booking)->firstOrFail();

        // Init fields from model
        $this->status = $this->booking->status->value ?? '';
        $this->payment_status = $this->booking->payment_status->value ?? '';
        $this->date_of_travel = $this->booking->date_of_travel?->format('Y-m-d') ?? '';
        $this->total_amount = floatval($this->booking->total_amount ?? 0);
        $this->amount_paid = floatval($this->booking->amount_paid ?? 0);
        $this->comments = $this->booking->comments ?? '';
    }

    public function updateBooking()
    {
        $this->validate([
            'status' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'date_of_travel' => 'nullable|date',
            'total_amount' => 'nullable|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'comments' => 'nullable|string',
        ]);

        $this->booking->update([
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'date_of_travel' => Carbon::parse($this->date_of_travel),
            'total_amount' => $this->total_amount,
            'amount_paid' => $this->amount_paid,
            'comments' => $this->comments,
        ]);

        session()->flash('notify', [
            'message' => 'Booking updated successfully',
           'type' => 'success',
        ]);

        return redirect()->route('bookings.index');
    }

    public function render()
    {
        return view('livewire.pages.tours.bookings.edit');
    }
}
