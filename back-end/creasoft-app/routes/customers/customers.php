<?php

use App\Http\Controllers\Customer\DataCustomer\DataCustomersController;
use Illuminate\Support\Facades\Route;

Route::middleware('jwt')->group(function () {

    # Ruta de nuevos posibles clientes
    Route::group(['prefix' => 'dataCustomer'], function () {
        Route::get('/', [DataCustomersController::class, 'index']);
        Route::post('/', [DataCustomersController::class, 'store'])->withoutMiddleware('jwt');
        Route::post('/exportData', [DataCustomersController::class, 'exportData']);
    });
});
