<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobVacanciesController;
use App\Http\Controllers\JobApplicationsController;
use App\Http\Controllers\JobComments;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/stats', [\App\Http\Controllers\StatsController::class, 'index']);

// Public vacancies
Route::get('/vacancies', [JobVacanciesController::class, 'index']);
Route::get('/vacancies/{id}', [JobVacanciesController::class, 'show']); // single vacancy
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
     Route::post('/favorites/toggle/{vacancyId}', [FavoriteController::class, 'toggle']);
    Route::get('/favorites', [FavoriteController::class, 'index']);
    // Vacancy CRUD
    Route::post('/vacancies', [JobVacanciesController::class, 'store']);
    Route::delete('/vacancies/{id}', [JobVacanciesController::class, 'destroy']);
    Route::post('/vacancies/{id}/apply', [JobApplicationsController::class, 'apply']);
    Route::get('/applications', [JobApplicationsController::class, 'employerApplications']);
    Route::get('/applications/{id}/cv/view', [JobApplicationsController::class, 'viewCv']);
    Route::middleware('auth:sanctum')->get('/applications/{id}/cv-link', [JobApplicationsController::class, 'getCvLink']);
    Route::post('/comments', [JobComments::class, 'store']);
    Route::get('/vacancies/{id}/comments', [JobComments::class, 'index']);
    // File upload
    Route::post('/upload', [JobVacanciesController::class, 'upload']);
});
