<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\TaskRemarkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

