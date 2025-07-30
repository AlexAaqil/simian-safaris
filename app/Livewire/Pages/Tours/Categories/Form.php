<?php

namespace App\Livewire\Pages\Tours\Categories;

use Livewire\Component;
use App\Models\Tours\TourCategory;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;

class Form extends Component
{
    use WithFileUploads;

    public $tour_category_id;
    public $existing_image;

    public $title, $image;
    public ?string $description = '';

    public function rules(): Array
    {
        $rules = [
            'title' => ['required', 'string', 'max:120'],
            'image' => ['nullable','image','max:2048'],
            'description' => ['nullable','string','max:255'],
        ];

        if ($this->tour_category_id) {
            $tour_category = TourCategory::where('uuid', $this->tour_category_id)->firstOrFail();

            if($tour_category) {
                $rules['title'][] = 'unique:tour_categories,title,' . $tour_category->id;
            }
        } else {
            $rules['title'][] = 'unique:tour_categories,title';
        }

        return $rules;
    }

    protected $messages = [
        'title.required' => 'Title is required.',
        'title.max' => 'Title must not exceed 120 characters.',
        'title.unique' => 'Title already exists.',
    ];

    public function mount($uuid = null)
    {
        $this->tour_category_id = $uuid;

        if ($uuid) {
            $tour_category = TourCategory::where('uuid', $uuid)->firstOrFail();

            $this->title = $tour_category->title;
            $this->existing_image = $tour_category->image;
            $this->description = $tour_category->description;
        }
    }

    public function saveTourCategory()
    {
        $validated_data = $this->validate();
        $validated_data['slug'] = Str::slug($validated_data['title']);

        if ($this->image instanceof TemporaryUploadedFile) {
            $extension = $this->image->getClientOriginalExtension();
            $image_name = $validated_data['slug'] . '-' . Str::random(6) . '.' . $extension;

            $this->image->storeAs('tour-categories/images', $image_name, 'public');
            $validated_data['image'] = $image_name;
        } elseif ($this->tour_category_id && $this->existing_image) {
            // keep existing image if no new one uploaded
            $validated_data['image'] = $this->existing_image;
        }

        if ($this->tour_category_id) {
            $tour_category = TourCategory::where('uuid', $this->tour_category_id)->firstOrFail();

            if ($this->image && $tour_category->image && Storage::disk('public')->exists('tour-categories/images/' . $tour_category->image)) {
                Storage::disk('public')->delete('tour-categories/images/' . $tour_category->image);
            }

            $tour_category->update($validated_data);

            $message = 'Tour Category has been updated';
        } else {
            $validated_data['uuid'] = (string) Str::ulid();

            $tour_category = TourCategory::create($validated_data);

            $this->tour_category_id = $tour_category->uuid;

            $message = 'Tour Category has been created';
        }

        session()->flash('notify', [
            'message' => $message,
           'type' => 'success',
        ]);

        return redirect()->route('tour-categories.index');
    }

    public function render()
    {
        return view('livewire.pages.tours.categories.form');
    }
}
