<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\VendedorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check())
    {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::group(['prefix' => 'provincias', 'as' => 'provincias.', 'controller' => ProvinciaController::class], function (){
        Route::get('/', 'index')->name('index')->middleware('role:admin');
    });

    Route::group(['prefix' => 'vendedores', 'as' => 'vendedores.', 'controller' => VendedorController::class], function (){

        Route::get('/', 'index')->name('index')->middleware('permission:VER_VENDEDORES');
        Route::get('/create', 'create')->name('create')->middleware('permission:CREAR_VENDEDORES');
        Route::post('/store', 'store')->name('store')->middleware('permission:CREAR_VENDEDORES');
        Route::get('/{vendedor}', 'show')->name('show')->middleware('permission:VER_VENDEDORES');
        Route::get('/{vendedor}/edit', 'edit')->name('edit')->middleware('permission:EDITAR_VENDEDORES');
        Route::put('/{vendedor}/edit', 'update')->name('update')->middleware('permission:EDITAR_VENDEDORES');
        Route::delete('/{vendedor}/destroy', 'destroy' )->name('destroy')->middleware('permission:ELIMINAR_VENDEDORES');

    });

    Route::group(['prefix' => 'clientes', 'as' => 'clientes.', 'controller' => ClienteController::class], function(){
        // CAMBIADO 13/03/2026: Route::get('/listado_global', 'index')->name('index')->middleware('permission:VER_TODOS_CLIENTES');

        Route::middleware('role:comercial|admin')->group(function (){
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{cliente}/edit', 'edit')->name('edit');
            Route::put('/{cliente}/edit', 'update')->name('update');
            Route::delete('/{cliente}/destroy', 'destroy' )->name('destroy');
            Route::get('/{cliente}', 'show')->name('show');
        });
    });

    Route::group(['prefix' => 'productos', 'as' => 'productos.', 'controller' => ProductoController::class], function () {
        Route::middleware('permission:CREAR_PRODUCTOS')->group(function () {
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
        });

        Route::middleware('permission:VER_PRODUCTOS')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/set-prices', 'setprices')->name('setprice')->middleware('permission:FIJAR_PRECIOS');
        });

        Route::middleware('permission:VER_PRODUCTOS')->group(function () {
            Route::get('/{producto}', 'show')->name('show');
        });

        Route::middleware('permission:CREAR_PRODUCTOS')->group(function () {
            Route::get('/{producto}/edit', 'edit')->name('edit');
            Route::put('/{producto}/edit', 'update')->name('update');
            Route::delete('/{producto}/destroy', 'destroy')->name('destroy');
        });
    });
});


require __DIR__.'/settings.php';
