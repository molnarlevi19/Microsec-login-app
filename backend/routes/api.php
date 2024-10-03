<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [RegistrationController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    
    Route::get('/current-user', [RegistrationController::class, 'retrieveData']);
    Route::patch('/update-profile', [RegistrationController::class, 'updateProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login'])->name('login');