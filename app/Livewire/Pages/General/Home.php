<?php

namespace App\Livewire\Pages\General;

use Livewire\Component;
use App\Models\Tours\Tour;
use App\Models\Tours\Destination;

class Home extends Component
{
    public function render()
    {
        $destinations = Destination::orderBy('title')->take(4)->get();
        $tours = Tour::where('is_featured', true)->where('is_published', true)->orderBy('title')->take(6)->get();

        return view('livewire.pages.general.home', compact('tours', 'destinations'))->layout('layouts.guest');
    }
}
