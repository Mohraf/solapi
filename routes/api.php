<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/users', function () {
        return \App\Models\User::all();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
