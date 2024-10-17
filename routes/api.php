<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EleveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Routes pour l'authentification
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/eleves', [EleveController::class, 'index']); // Liste des éleves
    Route::get('/eleves/{id}', [EleveController::class, 'show']); // Détails d'un élève
    Route::get('/eleves/{id}/generate', [EleveController::class, 'generateApi']); // Génération d'un élève
});
