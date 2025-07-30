<?php

namespace App\Livewire\Pages\Tours\Categories;

use Livewire\Component;
use App\Models\Tours\TourCategory;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    public $confirm_tour_category_deletion = false;
    public $tour_category_to_delete = null;
    public ?string $delete_tour_category_id = null;

    protected $listeners = [
        'confirm-tour-category-deletion' => 'confirmTourCategoryDeletion',
    ];

    public function confirmTourCategoryDeletion($data)
    {
        $this->delete_tour_category_id = $data['tour_id'];
        $this->dispatch('open-modal', 'confirm-tour-category-deletion');
    }

    public function deleteTourCategory()
    {
        if($this->delete_tour_category_id) {
            $tour_category = TourCategory::where('uuid', $this->delete_tour_category_id)->firstOrFail();

            $tour_category->delete();

            $this->delete_tour_category_id = null;
            $this->dispatch('close-modal', 'confirm-tour-category-deletion');
            $this->dispatch('notify', type: 'success', message: 'Tour Category has been deleted');
        }
    }

    public function render()
    {
        $tour_categories = TourCategory::withCount('tours')->orderBy('title')->get();
        $count_tour_categories = TourCategory::count();

        return view('livewire.pages.tours.categories.index', compact('tour_categories', 'count_tour_categories'));
    }
}
