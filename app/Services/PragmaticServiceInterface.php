<?php

namespace App\Services;

use App\Player;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;

interface PragmaticServiceInterface
{
    public function checkValidHash(array $data): bool;
    public function getPlayerByToken(string $token): ?Model;
    public function getPlayerByUserId(string $userId): ?Model;

    public function processedBet(Player $player, array $data): ?Transaction;
    public function processedWinBet(Player $player, array $data): ?Transaction;
    public function processedBonusWin(Player $player, array $data): ?Transaction;
    public function processedJackpotWin(Player $player, array $data): ?Transaction;
    public function endRound(Player $player, array $data): void;
    public function refund(Player $player, array $data): ?Transaction;
    public function promoWin(Player $player, array $data): ?Transaction;
    public function sessionExpired(Player $player, array $data): void;
    public function adjustment(Player $player, array $data): ?array;
    public function roundDetails(Player $player, array $data): void;
}
