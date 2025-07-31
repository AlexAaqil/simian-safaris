<?php

namespace App\Livewire\Pages\General\Tours\Tours;

use Livewire\Component;
use App\Models\Tours\TourCategory;

class Categorized extends Component
{
    public $category;

    public function mount(string $category)
    {
        $this->category = TourCategory::where('slug', $category)->with('tours')->firstOrFail();
    }

    public function render()
    {
        return view('livewire.pages.general.tours.tours.categorized')->layout('layouts.guest');
    }
}
