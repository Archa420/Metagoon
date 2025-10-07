<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobVacanciesController;

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public vacancies
Route::get('/vacancies', [JobVacanciesController::class, 'index']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/vacancies/{id}', [JobVacanciesController::class, 'destroy']);
    Route::post('/upload', [JobVacanciesController::class, 'upload']); // file upload
    Route::post('/vacancies', [JobVacanciesController::class, 'store']);
});
