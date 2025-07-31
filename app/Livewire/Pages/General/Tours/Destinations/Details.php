<?php

namespace App\Livewire\Pages\General\Tours\Destinations;

use Livewire\Component;
use App\Models\Tours\Destination;

class Details extends Component
{
    public $destination;
    public $other_destinations;

    public function mount(string $destination)
    {
        $this->destination = Destination::where('slug', $destination)->firstOrFail();
        $this->other_destinations = Destination::select('id', 'title', 'slug', 'image')->where('slug', '!=', $this->destination->slug)->inRandomOrder()->take(6)->get();
    }

    public function render()
    {
        return view('livewire.pages.general.tours.destinations.details')->layout('layouts.guest');
    }
}
