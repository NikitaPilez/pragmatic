<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    phpinfo();
});

Route::get('casino-games', 'PragmaticController@casinoGames');
Route::get('lobby-games', 'PragmaticController@lobbyGames');
Route::get('close-session', 'PragmaticController@closeSession');
Route::get('cancel-round', 'PragmaticController@cancelRound');
Route::get('health-check', 'PragmaticController@healthCheck');
Route::get('replay-link', 'PragmaticController@replayLink');
Route::get('game-url', 'PragmaticController@gameUrl');
