<?php

use App\Http\Controllers\PragmaticWalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    phpinfo();
});

Route::prefix('pragmatic-wallet')->group(function () {
    Route::post('authenticate.html', [PragmaticWalletController::class, 'authenticate']);
    Route::post('balance.html', [PragmaticWalletController::class, 'balance']);
    Route::post('bet.html', [PragmaticWalletController::class, 'bet']);
    Route::post('result.html', [PragmaticWalletController::class, 'result']);
    Route::post('bonus-win.html', [PragmaticWalletController::class, 'bonusWin']);
    Route::post('jackpot-win.html', [PragmaticWalletController::class, 'jackpotWin']);
    Route::post('end-round.html', [PragmaticWalletController::class, 'endRound']);
    Route::post('refund.html', [PragmaticWalletController::class, 'refund']);
    Route::post('get-balance-per-game.html', [PragmaticWalletController::class, 'getBalancePerGame']);
    Route::post('promo-win.html', [PragmaticWalletController::class, 'promoWin']);
    Route::post('session-expired.html', [PragmaticWalletController::class, 'sessionExpired']);
    Route::post('adjustment.html', [PragmaticWalletController::class, 'adjustment']);
    Route::post('round-details.html', [PragmaticWalletController::class, 'roundDetails']);
});
