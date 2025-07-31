<?php

namespace App\Livewire\Pages\General\Tours\Tours;

use Livewire\Component;
use App\Models\Tours\Tour;

class Details extends Component
{
    public $tour;
    public $other_tours;

    public function mount(string $tour)
    {
        $this->tour = Tour::with('images', 'category', 'itineraries')->where('slug', $tour)->firstOrFail();
        $this->other_tours = Tour::with('images')->select('id', 'title', 'slug', 'price', 'price_ranges_to', 'currency')->where('slug', '!=', $this->tour->slug)->inRandomOrder()->take(6)->get();
    }

    public function render()
    {
        return view('livewire.pages.general.tours.tours.details')->layout('layouts.guest');
    }
}
