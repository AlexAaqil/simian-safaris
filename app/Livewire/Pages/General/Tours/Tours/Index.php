<?php

namespace App\Livewire\Pages\General\Tours\Tours;

use Livewire\Component;
use App\Models\Tours\Tour;

class Index extends Component
{
    public function render()
    {
        $tours = Tour::orderBy('title')->get();

        return view('livewire.pages.general.tours.tours.index', compact('tours'))->layout('layouts.guest');
    }
}
