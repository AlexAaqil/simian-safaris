<?php

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Destination extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::saving(function ($destination) {
            // Always keep slug in sync with title
            $destination->slug = Str::slug($destination->title);

            // Only generate uuid on create
            if(!$destination->uuid) {
                $destination->uuid = (string) Str::uuid();
            }
        });

        static::deleting(function ($destination) {
            $image = $destination->getRawOriginal('image');

            // Delete image from storage
            if ($image && Storage::disk('public')->exists("tour-destinations/images/{$image}")) {
                Storage::disk('public')->delete("tour-destinations/images/{$image}");
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function getImageAttribute()
    {
        $image = $this->attributes['image'] ?? null;
        $default_path = asset('assets/images/default-image.jpg');

        if ($image && Storage::disk('public')->exists("tour-destinations/images/{$image}")) {
            return Storage::url("tour-destinations/images/{$image}");
        }

        return $default_path;
    }
}
