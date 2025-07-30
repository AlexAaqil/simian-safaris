<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\General\Home as HomePage;
use App\Livewire\Pages\General\About as AboutPage;

Route::get('/', HomePage::class)->name('home-page');
Route::get('/about', AboutPage::class)->name('about-page');
