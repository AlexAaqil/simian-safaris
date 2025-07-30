<?php

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\BOOKING_STATUSES;
use App\Enums\PAYMENT_METHODS;
use App\Enums\PAYMENT_STATUSES;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Booking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date_of_travel' => 'date',
        'status' => BOOKING_STATUSES::class,
        'payment_status' => PAYMENT_STATUSES::class,
        'payment_method' => PAYMENT_METHODS::class,
    ];

    protected static function booted()
    {
        static::creating(function ($booking) {
            $booking->uuid = (string) Str::uuid();
        });
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function getDaysToTravelAttribute(): string
    {
        if (!$this->date_of_travel) {
            return 'N/A';
        }

        $now = Carbon::today();
        $travelDate = Carbon::parse($this->date_of_travel)->startOfDay();

        $diffInDays = $now->diffInDays($travelDate, false);

        return match (true) {
            $diffInDays === 0 => 'Today',
            $diffInDays === 1 => 'Tomorrow',
            $diffInDays === -1 => 'Yesterday',
            $diffInDays > 1 => "In {$diffInDays} days",
            $diffInDays < -1 => abs($diffInDays) . ' days ago',
            default => 'N/A',
        };
    }
}
