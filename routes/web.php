<?php

use App\Http\Controllers\Api\EleveController;
use App\Livewire\Eleve;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function() {
    Route::view('dashboard', 'dashboard')
        ->middleware('verified')
        ->name('dashboard');
    Volt::route('eleves', 'eleves')->name('eleves');
    Route::get('export-students', [EleveController::class, 'exportStudentToPdf'])->name('export-students');
});
Route::get('eleve/{id}/pdf', [EleveController::class, 'generateBul'])->name('generate-bulettin');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
