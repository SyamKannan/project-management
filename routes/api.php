<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\ProjectReportController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\TaskRemarkController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('user-details', [AuthController::class, 'userDetails']);
    Route::post('logout', [AuthController::class, 'logout']);

   
    Route::get('projects', [ProjectController::class, 'index']);
    Route::post('projects', [ProjectController::class, 'store']);
    Route::get('projects/{id}', [ProjectController::class, 'show']);
    Route::post('project-update/{id}', [ProjectController::class, 'update']);
    Route::delete('projects/{id}', [ProjectController::class, 'destroy']);


    Route::get('project/tasks/{id}', [TaskController::class, 'index']);
    Route::post('projects/tasks', [TaskController::class, 'store']);
    Route::post('task-update/{id}', [TaskController::class, 'update']);
    Route::delete('tasks/{id}', [TaskController::class, 'destroy']);

    Route::get('tasks/{task}/remarks', [TaskRemarkController::class, 'index']);
    Route::post('tasks/{task}/remarks', [TaskRemarkController::class, 'store']);

    Route::get('projects/{project}/report', [ProjectReportController::class, 'show']);
});
