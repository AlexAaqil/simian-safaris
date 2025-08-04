<?php

namespace App\Livewire\Pages\General\Contact;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.pages.general.contact.index')->layout('layouts.guest');
    }
}
