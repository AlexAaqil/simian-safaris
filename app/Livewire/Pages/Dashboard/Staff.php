<?php

namespace App\Livewire\Pages\Dashboard;

use Livewire\Component;
use App\Models\Tours\Tour;
use App\Models\Tours\Destination;
use App\Models\Tours\Booking;
use App\Enums\BOOKING_STATUSES;
use App\Enums\PAYMENT_STATUSES;
use App\Models\ContactMessage;

class Staff extends Component
{
    public function render()
    {
        $count_tours = Tour::count();
        $count_destinations = Destination::count();
        $count_bookings = Booking::count();

        $count_messages = ContactMessage::count();
        $count_unread_messages = ContactMessage::where('is_read', false)->count();

        $bookingsPerCategory = Booking::with('tour.category')
            ->where('payment_status', PAYMENT_STATUSES::PAID)
            ->where('status', BOOKING_STATUSES::COMPLETED)
            ->get()
            ->groupBy(function ($b) {
                return optional($b->tour->category)->title ?? 'Uncategorized';
            })->map->count();

        $booking_labels = $bookingsPerCategory->keys()->all();
        $booking_orders = $bookingsPerCategory->values()->all();

        return view('livewire.pages.dashboard.staff', compact(
            'count_tours',
            'count_destinations',
            'count_bookings',

            'count_messages',
            'count_unread_messages',

            'booking_labels',
            'booking_orders',
        ));
    }
}
