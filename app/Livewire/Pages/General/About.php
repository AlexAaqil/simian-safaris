<?php

namespace App\Livewire\Pages\General;

use Livewire\Component;

class About extends Component
{
    public function render()
    {
        return view('livewire.pages.general.about')->layout('layouts.guest');
    }
}
