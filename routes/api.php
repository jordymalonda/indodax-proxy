<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$router->group(['prefix' => 'exchange'], function () use ($router) {
    $router->post('buy', 'CoinController@orderBuy');
    $router->post('sell', 'CoinController@orderSell');
    $router->post('cancel', 'CoinController@cancelOrder');
    $router->post('open', 'CoinController@openOrder');
    $router->post('detail', 'CoinController@getOrder');
});
