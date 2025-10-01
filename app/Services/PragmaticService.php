<?php

namespace App\Services;

use App\Http\Player;
use Illuminate\Database\Eloquent\Model;

class PragmaticService implements PragmaticServiceInterface
{
    public function checkValidHash(array $data): bool
    {
        if (! isset($data['hash'])) {
            return false;
        }

        $hash = $data['hash'];

        unset($data['hash']);

        ksort($data);

        $queryString = urldecode(http_build_query($data));

        $calculateHash = md5($queryString . config('services.pragmatic.secret_key'));

        return hash_equals($hash, $calculateHash);
    }

    public function getPlayerByToken(string $token): ?Model
    {
        return Player::query()->where('token', $token)->first();
    }

    public function getPlayerByUserId(string $userId): ?Model
    {
        return Player::query()->where('user_id', $userId)->first();
    }

    public function processedBet(Player $player, float $amount): Player
    {
        $player->balance -= $amount;
        $player->save();

        return $player;
    }

    public function processedWinBet(Player $player, float $amount): Player
    {
        $player->balance += $amount;
        $player->save();

        return $player;
    }
}
