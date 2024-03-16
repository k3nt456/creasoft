<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

# Rutas de autenticación
Route::group(['prefix' => 'auth'], function () {
    require __DIR__ . '/authentication/authentication.php';
});

# Ruta de usuarios tipo cliente
Route::group(['prefix' => 'customers'], function () {
    require __DIR__ . '/customers/customers.php';
});

#Si se intenta acceder en rutas no existentes saldrá el siguiente mensaje
Route::fallback(function () {
    return [
        'timestamp' => Carbon::now()->toDateTimeString(),
        'code'      => 404,
        'status'    => false,
        'data'      => ['message' => 'Acceso restringido.']
    ];
});

