<?php

namespace App\Http\Controllers\Tours;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tours\Destination;
use App\Http\Requests\Tours\DestinationRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DestinationController extends Controller
{
    public function create()
    {
        return view('pages.tours.destinations.create');
    }

    public function store(DestinationRequest $request)
    {
        $validated_data = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $slug = Str::slug($validated_data['title']);
            $date = now()->format('dmyHis');
            $random = Str::random(5);
            $extension = $image->getClientOriginalExtension();

            $image_name = "{$slug}-{$date}-{$random}-{$extension}";
            $image->storeAs('tour-destinations/images', $image_name, 'public');
            $validated_data['image'] = $image_name;
        }

        Destination::create($validated_data);

        return redirect()->route('tour-destinations.index')->with('success', 'Destination created successfully');
    }

    public function edit(Destination $destination)
    {
        return view('pages.tours.destinations.edit', compact('destination'));
    }

    public function update(DestinationRequest $request, Destination $destination)
    {
        $validated_data = $request->validated();

        $old_slug = Str::slug($destination->title);
        $new_slug = Str::slug($validated_data['title']);
        $date = now()->format('dmyHis');
        $random = Str::random(5);

        // Check if image is being replaced
        if ($request->hasFile('image')) {
            // Delete old image
            if ($destination->image && Storage::disk('public')->exists('tour-destinations/images/' . $destination->getRawOriginal('image'))) {
                Storage::disk('public')->delete('tour-destinations/images/' . $destination->getRawOriginal('image'));
            }

            // Generate new image name with updated slug
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $image_name = "{$new_slug}-{$date}-{$random}.{$extension}";
            $image->storeAs('tour-destinations/images', $image_name, 'public');
            $validated_data['image'] = $image_name;
        } elseif ($old_slug !== $new_slug && $destination->image) {
            // If title changed and no new image was uploaded, rename existing image
            $old_image_name = $destination->getRawOriginal('image');
            $extension = pathinfo($old_image_name, PATHINFO_EXTENSION);
            $new_image_name = "{$new_slug}-{$date}-{$random}.{$extension}";

            $old_path = "tour-destinations/images/{$old_image_name}";
            $new_path = "tour-destinations/images/{$new_image_name}";

            if (!Storage::disk('public')->exists($old_path)) {
                Log::channel('tours')->info("Image file does not exist at $old_path. Rename skipped.");
            } else {
                Storage::disk('public')->move($old_path, $new_path);
                $validated_data['image'] = $new_image_name;
            }
        }

        $destination->update($validated_data);

        return redirect()->route('tour-destinations.index')->with('success', 'Destination updated successfully.');
    }
}
