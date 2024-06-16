<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* php artisan install:api
   api não é mais padrão a partir do Laravel 11
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/', function () {
    return ['Chegamos até aqui' => 'SIM'];
});