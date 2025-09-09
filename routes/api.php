<?php

use App\Http\Controllers\Api\TaskListController;
use App\Http\Controllers\Api\SubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes for Mobile App
Route::middleware('auth:sanctum')->group(function () {
    // Task Lists
    Route::get('/lists', [TaskListController::class, 'index']);
    Route::get('/lists/{list}', [TaskListController::class, 'show']);
    
    // Submissions
    Route::get('/submissions', [SubmissionController::class, 'index']);
    Route::post('/submissions', [SubmissionController::class, 'store']);
    Route::get('/submissions/{submission}', [SubmissionController::class, 'show']);
    Route::put('/submissions/{submission}', [SubmissionController::class, 'update']);
    Route::post('/submissions/{submission}/complete', [SubmissionController::class, 'complete']);
    Route::post('/submissions/{submission}/tasks/{task}', [SubmissionController::class, 'completeTask']);
});