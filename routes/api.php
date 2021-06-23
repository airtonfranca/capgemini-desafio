<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::apiResources(
    [
        'user' => 'API\UserController'
    ]
);

Route::get('transacoes/get/{id}', 'API\TransacoesController@get');
Route::post('transacoes/depositar', 'API\TransacoesController@depositar');
Route::post('transacoes/sacar', 'API\TransacoesController@sacar');
