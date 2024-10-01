<?php

use App\Livewire\Eleve;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function() {
    Route::view('dashboard', 'dashboard')
        ->middleware('verified')
        ->name('dashboard');
    //Route::get('eleves', Eleve::class);
    Volt::route('eleves', 'eleves')->name('eleves');
});
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
