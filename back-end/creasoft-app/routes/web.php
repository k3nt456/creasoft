<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

#Si se intenta acceder en rutas no existentes saldrá el siguiente mensaje
Route::fallback(function () {
    return [
        'timestamp' => Carbon::now()->toDateTimeString(),
        'code'      => 404,
        'status'    => false,
        'data'      => ['message' => 'Acceso restringido.']
    ];
});
