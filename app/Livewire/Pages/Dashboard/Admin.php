<?php

namespace App\Livewire\Pages\Dashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\Tours\Tour;
use App\Models\Tours\Destination;
use App\Models\Tours\Booking;
use App\Models\ContactMessage;
use App\Enums\USER_ROLES;
use App\Enums\BOOKING_STATUSES;
use App\Enums\PAYMENT_STATUSES;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Admin extends Component
{
    public function render()
    {
        $count_super_admins = User::where('role', USER_ROLES::SUPER_ADMIN)->count();
        $count_admins = User::where('role', USER_ROLES::ADMIN)->count();
        $count_users = User::whereNotIn('role', [USER_ROLES::SUPER_ADMIN])->count();

        $count_tours = Tour::count();
        $count_destinations = Destination::count();
        $count_bookings = Booking::count();

        $count_messages = ContactMessage::count();
        $count_unread_messages = ContactMessage::where('is_read', false)->count();

        $allBookings = Booking::where('payment_status', PAYMENT_STATUSES::PAID)
            ->where('status', BOOKING_STATUSES::COMPLETED)
            ->whereYear('date_of_travel', now()->year)
            ->get(['total_amount', 'amount_paid', 'date_of_travel']);

        $gross_sales = round($allBookings->sum('total_amount'), 2); // Expected revenue (quoted)
        $net_sales = round($allBookings->sum('amount_paid'), 2);    // Actual revenue (received)
        $revenue_delta = round($net_sales - $gross_sales, 2);       // Negotiation difference

        $salesByMonth = $allBookings->groupBy(function ($booking) {
            return Carbon::parse($booking->date_of_travel)->format('n');
        })->map->sum('amount_paid');

        $sales_data = collect(range(1, 12))
            ->map(fn($month) => round($salesByMonth->get($month, 0), 2))
            ->all();

        $bookingsPerCategory = Booking::with('tour.category')
            ->where('payment_status', PAYMENT_STATUSES::PAID)
            ->where('status', BOOKING_STATUSES::COMPLETED)
            ->get()
            ->groupBy(function ($b) {
                return optional($b->tour->category)->title ?? 'Uncategorized';
            })->map->count();

        $booking_labels = $bookingsPerCategory->keys()->all();
        $booking_orders = $bookingsPerCategory->values()->all();

        return view('livewire.pages.dashboard.admin', compact(
            'count_super_admins',
            'count_admins',
            'count_users',

            'count_tours',
            'count_destinations',
            'count_bookings',

            'count_messages',
            'count_unread_messages',

            'gross_sales',
            'net_sales',
            'revenue_delta',


            'sales_data',
            'booking_labels',
            'booking_orders',
        ));
    }
}
