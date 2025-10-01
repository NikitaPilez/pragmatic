<?php

namespace App\Services;

use App\Http\Player;
use Illuminate\Database\Eloquent\Model;

interface PragmaticServiceInterface
{
    public function checkValidHash(array $data): bool;
    public function getPlayerByToken(string $token): ?Model;
    public function getPlayerByUserId(string $userId): ?Model;

    public function processedBet(Player $player, float $amount): Player;
    public function processedWinBet(Player $player, float $amount): Player;
}
