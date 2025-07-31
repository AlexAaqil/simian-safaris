<?php

namespace App\Livewire\Pages\General\Tours\Destinations;

use Livewire\Component;
use App\Models\Tours\Destination;

class Index extends Component
{
    public function render()
    {
        $destinations = Destination::orderBy('title')->get();

        return view('livewire.pages.general.tours.destinations.index', compact('destinations'))->layout('layouts.guest');
    }
}
