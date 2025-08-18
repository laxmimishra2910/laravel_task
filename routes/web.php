<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomName\EmployeeController;
use App\Http\Controllers\CustomName\ProjectController;
use App\Http\Controllers\CustomName\FeedbackController;
use App\Http\Controllers\CustomName\DashoardController;
use App\Http\Controllers\TaskAssignmentController;
use App\Http\Controllers\ProjectMassUpdateController;
use App\Jobs\UpdateProfileStatus;

// Test job dispatch route
Route::get('/test-job', function () {
    UpdateProfileStatus::dispatch([1, 2, 3], 'verified');
    return 'Job dispatched';
});

// Public route
Route::get('/', fn () => view('welcome'));

// Dashboard route with auth and verified middleware
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashoardController::class, 'index'])->name('dashboard');
});

// Authenticated user profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Shared admin + HR access routes
Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::get('/projects/data', [ProjectController::class, 'data'])->name('projects.data');

    // Mass update projects route
     Route::post('/projects/mass-update', [ProjectController::class, 'massUpdate'])->name('projects.mass-update');

    Route::resource('projects', ProjectController::class);

    Route::resource('feedback', FeedbackController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('feedback-report', [FeedbackController::class, 'report'])->name('feedback.report');

   Route::post('/employees/mass-update', [EmployeeController::class, 'massUpdate'])
    ->name('employees.massUpdate');


    Route::get('/employees/trashed', [EmployeeController::class, 'trashed'])->name('employees.trashed');
    Route::post('/employees/restore/{id}', [EmployeeController::class, 'restore'])->name('employees.restore');
    Route::delete('/employees/force-delete/{id}', [EmployeeController::class, 'forceDelete'])->name('employees.forceDelete');
    Route::resource('employees', EmployeeController::class);
});

// Admin-only extra routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('feedback', FeedbackController::class)->only(['index', 'store', 'destroy']);

    Route::get('/assign-task', [TaskAssignmentController::class, 'create'])->name('assign.task.create');
    Route::post('/assign-task', [TaskAssignmentController::class, 'store'])->name('assign.task.store');
});

require __DIR__ . '/auth.php';
