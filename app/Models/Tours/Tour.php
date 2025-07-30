<?php

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Tour extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function ($tour) {
            // Always keep slug in sync with title
            $tour->slug = Str::slug($tour->title);

            // Only generate uuid on create
            if(!$tour->uuid) {
                $tour->uuid = (string) Str::uuid();
            }
        });

        static::deleting(function ($tour) {
            foreach($tour->images as $image) {
                $image_path = "tours/images/{$image->image}";
                if (Storage::disk('public')->exists($image_path)) {
                    Storage::disk('public')->delete($image_path);
                }
            }

            $tour->images()->delete();
            $tour->itineraries()->delete();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TourCategory::class, 'tour_category_id');
    }

    public function itineraries(): HasMany
    {
        return $this->hasMany(TourItinerary::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(TourImage::class)->orderBy('sort_order');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getImageAttribute()
    {
        $image = $this->images->first();
        return $image?->url ?? asset('assets/images/default-image.jpg');
    }
}
