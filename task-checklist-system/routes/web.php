<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TaskListController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Redirect dashboard based on user role
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('employee.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('lists', TaskListController::class);
    Route::resource('lists.tasks', TaskController::class)->shallow();
    Route::resource('users', UserController::class);
    
    // Additional admin routes
    Route::post('/lists/{list}/assign', [TaskListController::class, 'assign'])->name('lists.assign');
    Route::get('/submissions', [TaskListController::class, 'submissions'])->name('submissions.index');
    Route::get('/submissions/{submission}', [TaskListController::class, 'showSubmission'])->name('submissions.show');
    Route::post('/submissions/{submission}/review', [TaskListController::class, 'reviewSubmission'])->name('submissions.review');
});

// Employee Routes
Route::middleware(['auth', 'verified', 'employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
    Route::get('/lists', [SubmissionController::class, 'index'])->name('lists.index');
    Route::get('/lists/{list}', [SubmissionController::class, 'show'])->name('lists.show');
    Route::post('/lists/{list}/start', [SubmissionController::class, 'start'])->name('submissions.start');
    Route::get('/submissions/{submission}', [SubmissionController::class, 'edit'])->name('submissions.edit');
    Route::put('/submissions/{submission}', [SubmissionController::class, 'update'])->name('submissions.update');
    Route::post('/submissions/{submission}/complete', [SubmissionController::class, 'complete'])->name('submissions.complete');
    Route::post('/submissions/{submission}/tasks/{task}', [SubmissionController::class, 'completeTask'])->name('submissions.tasks.complete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
