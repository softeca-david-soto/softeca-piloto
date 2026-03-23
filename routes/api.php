<?php

use App\Http\Controllers\Api\ClienteApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'clientes', 'as' => 'apiclientes.', 'controller' => ClienteApiController::class], function (){

    Route::get('/', 'index')->name('index');
});
