<?php

namespace App\Livewire\Pages\Tours\Tours;

use App\Models\Tours\Tour;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    public $confirm_tour_deletion = false;
    public $tour_to_delete = null;
    public ?int $delete_tour_id = null;

    protected $listeners = [
        'confirm-tour-deletion' => 'confirmTourDeletion',
    ];

    public function toggleIsFeatured($tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        $tour->is_featured = !$tour->is_featured;
        $tour->save();

        $this->dispatch('notify', type: 'success', message: 'tour has been updated');
    }

    public function toggleIsPublished($tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        $tour->is_published = !$tour->is_published;
        $tour->save();

        $this->dispatch('notify', type: 'success', message: 'tour has been updated');
    }

    public function confirmTourDeletion($data)
    {
        $this->delete_tour_id = $data['tour_id'];
        $this->dispatch('open-modal', 'confirm-tour-deletion');
    }

    public function deleteTour()
    {
        if($this->delete_tour_id) {
            $tour = Tour::with('images')->findOrFail($this->delete_tour_id);
            if($tour) {
                foreach($tour->images as $image) {
                    Storage::disk('public')->delete('tours/images/' . $image->image);
                }

                $tour->delete();

                $this->delete_tour_id = null;
                $this->dispatch('close-modal', 'confirm-tour-deletion');
                $this->dispatch('notify', type: 'success', message: 'Tour has been deleted');
            }
        }
    }

    public function render()
    {
        $tours = Tour::orderBy('title')->get();
        $count_tours = Tour::count();
        $count_published = Tour::where('is_published', true)->count();
        $count_featured = Tour::where('is_featured', true)->count();

        return view('livewire.pages.tours.tours.index', compact('tours', 'count_tours', 'count_published', 'count_featured'));
    }
}
