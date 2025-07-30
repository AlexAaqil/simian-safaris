<?php

namespace App\Livewire\Pages\Tours\Tours;

use Livewire\Component;
use App\Models\Tours\Tour;
use App\Models\Tours\TourCategory;
use App\Models\Tours\TourImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $tour_id;

    public $title, $slug, $summary, $description, $duration_days, $duration_nights, $currency, $price, $price_ranges_to,    $tour_category_id;
    public $is_featured = false;
    public $is_published = true;

    public $itineraries = [];
    public $images = [];
    public $existing_images = [];

    public function mount($uuid = null)
    {
        $this->tour_id = $uuid;

        if ($uuid) {
            $tour = Tour::where('uuid', $uuid)->with(['itineraries', 'images'])->firstOrFail();

            $this->title = $tour->title;
            $this->slug = $tour->slug;
            $this->is_featured = $tour->is_featured;
            $this->is_published = $tour->is_published;
            $this->summary = $tour->summary;
            $this->description = $tour->description;
            $this->duration_days = $tour->duration_days;
            $this->duration_nights = $tour->duration_nights;
            $this->currency = $tour->currency;
            $this->price = $tour->price;
            $this->price_ranges_to = $tour->price_ranges_to;
            $this->tour_category_id = $tour->tour_category_id;

            $this->itineraries = $tour->itineraries->map(function($item) {
                return [
                    'title' => $item->title,
                    'description' => $item->description,
                    'day_number' => $item->day_number,
                ];
            })->toArray();
            $this->existing_images = $tour->images->pluck('image', 'id')->toArray();
        } else {
            $this->itineraries[] = ['title' => '', 'description' => '', 'day_number' => 1];
        }
    }

    protected function rules(): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:120'],
            'is_featured' => ['boolean'],
            'is_published' => ['boolean'],
            'summary' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'duration_days' => ['nullable','integer'],
            'duration_nights' => ['nullable','integer'],
            'currency' => ['required','string','max:3'],
            'price' => ['nullable','numeric'],
            'price_ranges_to' => ['nullable','numeric'],
            'tour_category_id' => ['required','exists:tour_categories,id'],
            'itineraries.*.title' => 'required|string|max:255',
            'itineraries.*.description' => 'required|string',
            'itineraries.*.day_number' => 'nullable|integer',
            'images.*' => 'nullable|image|max:2048'
        ];

        if ($this->tour_id) {
            $tour = Tour::where('uuid', $this->tour_id)->first();
            if ($tour) {
                $rules['title'][] = 'unique:tours,title,' . $tour->id;
            }
        } else {
            $rules['title'][] = 'unique:tours,title';
        }

        return $rules;
    }

    protected $messages = [
        'title.required' => 'Title is required.',
        'title.max' => 'Title must not exceed 120 characters.',
    ];

    public function saveTour()
    {
        $validated_data = $this->validate();
        $validated_data['slug'] = Str::slug($validated_data['title']);

        if ($this->tour_id) {
            $tour = Tour::where('uuid', $this->tour_id)->firstOrFail();
            $tour->update($validated_data);
            $message = 'Tour has been updated';
        } else {
            $validated_data['uuid'] = (string) Str::ulid();
            $tour = Tour::create($validated_data);
            $this->tour_id = $tour->uuid;
            $message = 'Tour has been created';
        }

        $this->saveItineraries($tour);
        $this->saveImages($tour);

        session()->flash('notify', [
            'message' => $message,
            'type' => 'success',
        ]);

        return redirect()->route('tours.index');
    }

    public function saveItineraries(Tour $tour)
    {
        $tour->itineraries()->delete(); // simple reset
        foreach ($this->itineraries as $item) {
            if(!empty($item['title'])){
                $tour->itineraries()->create([
                    'uuid' => Str::ulid(),
                    'tour_id' => $tour->id,
                    'title' => $item['title'],
                    'description' => $item['description'] ?? '',
                    'day_number' => $item['day_number'] ?? 1,
                ]);
            }
        }
    }

    public function saveImages(Tour $tour)
    {
        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                $extension = $image->getClientOriginalExtension();
                $image_name = $tour->slug . '-' . Str::random(6) . '.' . $extension;
                $image->storeAs('tours/images', $image_name, 'public');

                $tour->images()->create([
                    'uuid' => Str::ulid(),
                    'tour_id' => $tour->id,
                    'image' => $image_name
                ]);
            }
        }
    }

    public function removeExistingImage($image_id)
    {
        $image = TourImage::findOrFail($image_id);
        if ($image) {
            Storage::disk('public')->delete('/tours/images/' . $image->image);
            $image->delete();
            unset($this->existing_images[$image_id]);
        }
    }

    public function addItineraryRow()
    {
        $this->itineraries[] = ['title' => '', 'description' => '', 'day_number' => count($this->itineraries) + 1];
    }

    public function removeItineraryRow($index)
    {
        unset($this->itineraries[$index]);
        $this->itineraries = array_values($this->itineraries);
    }

    public function render()
    {
        $tour_categories = TourCategory::all();

        return view('livewire.pages.tours.tours.form', compact('tour_categories'));
    }
}
