<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tours\TourCategory;
use Illuminate\Support\Str;

class TourCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'day trips',
            'kenya safaris',
            'tanzania safaris',
            'kenya tanzania safaris',
            'uganda safaris',
            'rwanda safaris',
        ];

        foreach($categories as $title) {
            TourCategory::updateOrCreate([
                'uuid' => Str::ulid(),
                'title' => $title,
                'slug' => Str::slug($title),
            ]);
        }
    }
}
