<?php

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

Route::get('casino-games', 'PragmaticController@casinoGames');
Route::get('lobby-games', 'PragmaticController@lobbyGames');
Route::get('close-session', 'PragmaticController@closeSession');
Route::get('cancel-round', 'PragmaticController@cancelRound');
Route::get('health-check', 'PragmaticController@healthCheck');
Route::get('replay-link', 'PragmaticController@replayLink');
Route::get('game-url', 'PragmaticController@gameUrl');
