<?php

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TourImage extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function (TourImage $tourImage) {
            $tourImage->uuid = $tourImage->uuid ?? (string) Str::uuid();
        });
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function getUrlAttribute(): string
    {
        if (Storage::disk('public')->exists("tours/images/{$this->image}")) {
            return Storage::url("tours/images/{$this->image}");
        }

        return asset('assets/images/default-image.jpg');
    }
}
