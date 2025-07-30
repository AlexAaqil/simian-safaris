<?php

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TourItinerary extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function (TourItinerary $tourItinerary) {
            $tourItinerary->uuid = $tourItinerary->uuid ?? (string) Str::uuid();
        });
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
