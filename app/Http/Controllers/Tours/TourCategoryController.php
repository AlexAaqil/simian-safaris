<?php

namespace App\Http\Controllers\Tours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tours\TourCategory;
use App\Http\Requests\Tours\TourCategoryRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TourCategoryController extends Controller
{
    public function create()
    {
        return view('pages.tours.categories.create');
    }

    public function store(TourCategoryRequest $request)
    {
        $validated_data = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $slug = Str::slug($validated_data['title']);
            $date = now()->format('dmy');
            $random = Str::random(5);
            $extension = $image->getClientOriginalExtension();

            $image_name = "{$slug}-{$date}-{$random}.{$extension}";
            $image->storeAs('tour-categories/images', $image_name, 'public');
            $validated_data['image'] = $image_name;
        }

        TourCategory::create($validated_data);

        return redirect()->route('tour-categories.index')->with('success', 'Tour category created successfully.');
    }

    public function edit(TourCategory $tour_category)
    {
        return view('pages.tours.categories.edit', compact('tour_category'));
    }

    public function update(TourCategoryRequest $request, TourCategory $tour_category)
    {
        $validated_data = $request->validated();

        $old_slug = Str::slug($tour_category->title);
        $new_slug = Str::slug($validated_data['title']);
        $date = now()->format('dmy');
        $random = Str::random(5);

        // Check if image is being replaced
        if ($request->hasFile('image')) {
            // Delete old image
            if ($tour_category->image && Storage::disk('public')->exists('tour-categories/images/'.$tour_category->getRawOriginal('image'))) {
                Storage::disk('public')->delete('tour-categories/images/'.$tour_category->getRawOriginal('image'));
            }

            // Generate new image name with updated slug
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $image_name = "{$new_slug}-{$date}-{$random}.{$extension}";
            $image->storeAs('tour-categories/images', $image_name, 'public');
            $validated_data['image'] = $image_name;
        } elseif ($old_slug !== $new_slug && $tour_category->image) {
            // If title changed and no new image was uploaded, rename existing image
            $old_image_name = $tour_category->getRawOriginal('image');
            $extension = pathinfo($old_image_name, PATHINFO_EXTENSION);
            $new_image_name = "{$new_slug}-{$date}-{$random}.{$extension}";

            $old_path = "tour-categories/images/{$old_image_name}";
            $new_path = "tour-categories/images/{$new_image_name}";

            if (Storage::disk('public')->exists($old_path)) {
                Storage::disk('public')->move($old_path, $new_path);
                $validated_data['image'] = $new_image_name;
            }
        }

        $tour_category->update($validated_data);

        return redirect()->route('tour-categories.index')->with('success', 'Tour category updated successfully.');
    }
}
