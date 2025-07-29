<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\General\Home as HomePage;

Route::get('/', HomePage::class)->name('home-page');
