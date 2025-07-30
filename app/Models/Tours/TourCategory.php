<?php

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TourCategory extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::saving(function ($category) {
            // Always keep slug in sync with title
            $category->slug = Str::slug($category->title);

            // Only generate uuid on create
            if(!$category->uuid) {
                $category->uuid = (string) Str::uuid();
            }
        });

        static::deleting(function ($category) {
            $image = $category->getRawOriginal('image');

            // Delete image from storage
            if ($image && Storage::disk('public')->exists("tour-categories/images/{$image}")) {
                Storage::disk('public')->delete("tour-categories/images/{$image}");
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class, 'tour_category_id');
    }

    public function getImageAttribute()
    {
        $image = $this->attributes['image'] ?? null;
        $default_path = asset('assets/images/default-image.jpg');

        if ($image && Storage::disk('public')->exists("tour-categories/images/{$image}")) {
            return Storage::url("tour-categories/images/{$image}");
        }

        return $default_path;
    }
}
