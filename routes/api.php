<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClasseController;
use App\Http\Controllers\Api\EleveController;
use App\Http\Controllers\Api\MatiereController;
use App\Http\Controllers\Api\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Routes pour l'authentification
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::get('/token/validate', [AuthController::class, 'validateToken']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/eleves', [EleveController::class, 'index']); // Liste des éleves
    Route::get('/eleves/{id}', [EleveController::class, 'show']); // Détails d'un élève
    Route::get('/eleves/{id}/generate', [EleveController::class, 'generateApi']); // Génération d'un élève

    Route::get('/matieres', [MatiereController::class, 'index']); // Liste des matières
    //Route::get('/enseigants', [EnseignantController::class, 'index']); // Liste des enseignant
    Route::prefix('/classes')->group(function () {
        Route::post('/matieres', [MatiereController::class, 'getClassesMatieres']);
    });
    Route::get('/classes', [ClasseController::class, 'index']); // Liste des classes
    Route::prefix('/notes')->group(function () {
        Route::get('/', [NoteController::class, 'index']);
        Route::get('/eleve', [NoteController::class, 'getNoteByEleveMatiere']);
        Route::post('/store', [NoteController::class, 'saveEleveNoteInMatiere']);
    });
});
