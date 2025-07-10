<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomName\EmployeeController;
use App\Http\Controllers\CustomName\ProjectController;
use App\Http\Controllers\CustomName\FeedbackController;

// Public
Route::get('/', fn () => view('welcome'));

Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated user profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('projects', ProjectController::class); // Full access
    Route::resource('feedback', FeedbackController::class);
    Route::get('feedback-report', [FeedbackController::class, 'report'])->name('feedback.report');

});

// HR-only or Admin (shared) routes
Route::middleware(['auth', 'role:hr,admin'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index'); // HR only view
});

// Employee-only routes
Route::middleware(['auth', 'role:employee'])->group(function () {
    // View projects (limited access)
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');

    // View personal feedback
    Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback.index');
});

// Soft delete management (admin or hr)
Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::get('/employees/trashed', [EmployeeController::class, 'show'])->name('employees.trashed');
    Route::post('/employees/restore/{id}', [EmployeeController::class, 'restore'])->name('employees.restore');
    Route::delete('/employees/force-delete/{id}', [EmployeeController::class, 'forceDelete'])->name('employees.forceDelete');
});

require __DIR__.'/auth.php';
