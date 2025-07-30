<?php

namespace App\Livewire\Partials;

use Livewire\Component;
use App\Models\Tours\TourCategory;

class Footer extends Component
{
    public function render()
    {
        $categories = TourCategory::take(6)->get();

        return view('livewire.partials.footer', compact('categories'));
    }
}
