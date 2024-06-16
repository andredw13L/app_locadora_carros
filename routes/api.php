/* php artisan install:api
   api não é mais padrão a partir do Laravel 11
*/


<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
