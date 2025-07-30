<?php

namespace App\Livewire\Pages\Tours\Destinations;

use Livewire\Component;
use App\Models\Tours\Destination;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    public $confirm_tour_destination_deletion = false;
    public $tour_destination_to_delete = null;
    public ?string $delete_tour_destination_id = null;

    protected $listeners = [
        'confirm-tour-destination-deletion' => 'confirmTourDestinationDeletion',
    ];

    public function confirmTourDestinationDeletion($data)
    {
        $this->delete_tour_destination_id = $data['destination_id'];
        $this->dispatch('open-modal', 'confirm-tour-destination-deletion');
    }

    public function deleteTourDestination()
    {
        if($this->delete_tour_destination_id) {
            $tour_destination = Destination::where('uuid', $this->delete_tour_destination_id)->firstOrFail();

            $tour_destination->delete();

            $this->delete_tour_destination_id = null;
            $this->dispatch('close-modal', 'confirm-tour-destination-deletion');
            $this->dispatch('notify', type: 'success', message: 'Destination deleted successfully');
        }
    }

    public function render()
    {
        $tour_destinations = Destination::orderBy('title')->get();
        $count_tour_destinations = Destination::count();

        return view('livewire.pages.tours.destinations.index', compact('tour_destinations', 'count_tour_destinations'));
    }
}
