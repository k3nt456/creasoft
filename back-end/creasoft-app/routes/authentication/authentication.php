<?php

use App\Http\Controllers\Autentication\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('jwt')->group( function () {
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('jwt');
    Route::post('/refreshToken', [AuthController::class, 'refreshToken']);
    Route::post('/logOut', [AuthController::class, 'logOut']);
});

