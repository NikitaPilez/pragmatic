<?php

use App\Http\Controllers\PragmaticWalletController;
use Illuminate\Support\Facades\Route;

Route::prefix('pragmatic-wallet')->group(function () {
    Route::post('authenticate.html', [PragmaticWalletController::class, 'authenticate']);
    Route::post('balance.html', [PragmaticWalletController::class, 'balance']);
    Route::post('bet.html', [PragmaticWalletController::class, 'bet']);
    Route::post('result.html', [PragmaticWalletController::class, 'result']);
    Route::post('bonusWin.html', [PragmaticWalletController::class, 'bonusWin']);
    Route::post('jackpotWin.html', [PragmaticWalletController::class, 'jackpotWin']);
    Route::post('endRound.html', [PragmaticWalletController::class, 'endRound']);
    Route::post('refund.html', [PragmaticWalletController::class, 'refund']);
    Route::post('getBalancePerGame.html', [PragmaticWalletController::class, 'getBalancePerGame']);
    Route::post('promoWin.html', [PragmaticWalletController::class, 'promoWin']);
    Route::post('sessionExpired.html', [PragmaticWalletController::class, 'sessionExpired']);
    Route::post('adjustment.html', [PragmaticWalletController::class, 'adjustment']);
    Route::post('roundDetails.html', [PragmaticWalletController::class, 'roundDetails']);
});

Route::get('casino-games', 'PragmaticController@casinoGames');
Route::get('lobby-games', 'PragmaticController@lobbyGames');
Route::get('close-session', 'PragmaticController@closeSession');
Route::get('cancel-round', 'PragmaticController@cancelRound');
Route::get('health-check', 'PragmaticController@healthCheck');
Route::get('replay-link', 'PragmaticController@replayLink');
Route::get('game-url', 'PragmaticController@gameUrl');
