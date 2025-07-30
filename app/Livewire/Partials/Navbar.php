<?php

namespace App\Livewire\Partials;

use Livewire\Component;
use App\Livewire\Actions\Auth\Logout;
use App\Models\Tours\TourCategory;

class Navbar extends Component
{
    public $tour_categories;

    public function mount()
    {
        $this->tour_categories = TourCategory::take(10)->get();
    }

    public function logout(Logout $logout)
    {
        $logout();
        $this->redirect('/', navigate:true);
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
