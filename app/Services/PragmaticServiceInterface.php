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
}
