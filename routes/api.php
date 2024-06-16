<?php

use App\Http\Controllers\CarroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\MarcaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* php artisan install:api
   api não é mais padrão a partir do Laravel 11
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('cliente', ClienteController::class);
Route::apiResource('carro', CarroController::class);
Route::apiResource('locacao', LocacaoController::class);
Route::apiResource('marca', MarcaController::class);
Route::apiResource('modelo', ClienteController::class);
