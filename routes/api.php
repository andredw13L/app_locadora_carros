<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LocacaoController;

/* php artisan install:api
   api não é mais padrão a partir do Laravel 11
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('cliente', ClienteController::class)->middleware('auth:api');
Route::apiResource('carro', CarroController::class)->middleware('auth:api');
Route::apiResource('locacao', LocacaoController::class)->middleware('auth:api');
Route::apiResource('marca', MarcaController::class)->middleware('auth:api');
Route::apiResource('modelo', ModeloController::class)->middleware('auth:api');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout',  [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::post('/me', [AuthController::class, 'me']);
