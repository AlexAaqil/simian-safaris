<?php

namespace App\Livewire\Pages\General;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.pages.general.home')->layout('layouts.guest');
    }
}
