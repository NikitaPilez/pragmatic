<?php

namespace App\Services;

use App\Player;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

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

    public function processedBet(Player $player, array $data): ?Transaction
    {
        $amount = $data['amount'];
        $idempotencyKey = $data['reference'];

        $transaction = Transaction::where('player_id', $player->id)->where('idempotency_key', $idempotencyKey)->first();

        if (! $transaction) {
            try {
                DB::beginTransaction();

                $transaction = new Transaction;
                $transaction->player_id = $player->id;
                $transaction->amount = -$amount;
                $transaction->idempotency_key = $idempotencyKey;
                $transaction->save();

                $player->balance -= $amount;
                $player->save();

                DB::commit();

                return $transaction;
            } catch (Throwable $e) {
                DB::rollBack();

                return null;
            }
        }

        return $transaction;
    }

    public function processedWinBet(Player $player, array $data): ?Transaction
    {
        $amount = $data['amount'];
        $idempotencyKey = $data['reference'];

        $transaction = Transaction::where('player_id', $player->id)->where('idempotency_key', $idempotencyKey)->first();

        if (! $transaction) {
            try {
                DB::beginTransaction();

                $transaction = new Transaction;
                $transaction->player_id = $player->id;
                $transaction->amount = $amount;
                $transaction->idempotency_key = $idempotencyKey;
                $transaction->save();

                $player->balance += $amount;
                $player->save();

                DB::commit();

                return $transaction;
            } catch (Throwable $e) {
                DB::rollBack();

                return null;
            }
        }

        return $transaction;
    }

    public function processedBonusWin(Player $player, array $data): ?Transaction
    {
        $amount = $data['amount'];
        $idempotencyKey = $data['reference'];

        $transaction = Transaction::where('player_id', $player->id)->where('idempotency_key', $idempotencyKey)->first();

        if (! $transaction) {
            try {
                DB::beginTransaction();

                $transaction = new Transaction;
                $transaction->player_id = $player->id;
                $transaction->amount = $amount;
                $transaction->idempotency_key = $idempotencyKey;
                $transaction->save();

                $player->balance += $amount;
                $player->save();

                DB::commit();

                return $transaction;
            } catch (Throwable $e) {
                DB::rollBack();

                return null;
            }
        }

        return $transaction;
    }

    public function processedJackpotWin(Player $player, array $data): ?Transaction
    {
        $amount = $data['amount'];
        $idempotencyKey = $data['reference'];

        $transaction = Transaction::where('player_id', $player->id)->where('idempotency_key', $idempotencyKey)->first();

        if (! $transaction) {
            try {
                DB::beginTransaction();

                $transaction = new Transaction;
                $transaction->player_id = $player->id;
                $transaction->amount = $amount;
                $transaction->idempotency_key = $idempotencyKey;
                $transaction->save();

                $player->balance += $amount;
                $player->save();

                DB::commit();

                return $transaction;
            } catch (Throwable $e) {
                DB::rollBack();

                return null;
            }
        }

        return $transaction;
    }

    public function endRound(Player $player, array $data): void
    {

    }

    public function refund(Player $player, array $data): ?Transaction
    {
        $amount = $data['amount'];
        $idempotencyKey = $data['reference'];

        $transaction = Transaction::where('player_id', $player->id)->where('idempotency_key', $idempotencyKey)->first();

        if (! $transaction) {
            try {
                DB::beginTransaction();

                $transaction = new Transaction;
                $transaction->player_id = $player->id;
                $transaction->amount = $amount;
                $transaction->idempotency_key = $idempotencyKey;
                $transaction->save();

                $player->balance += $amount;
                $player->save();

                DB::commit();

                return $transaction;
            } catch (Throwable $e) {
                DB::rollBack();

                return null;
            }
        }

        return $transaction;
    }

    public function promoWin(Player $player, array $data): ?Transaction
    {
        $amount = $data['amount'];
        $idempotencyKey = $data['reference'];

        $transaction = Transaction::where('player_id', $player->id)->where('idempotency_key', $idempotencyKey)->first();

        if (! $transaction) {
            try {
                DB::beginTransaction();

                $transaction = new Transaction;
                $transaction->player_id = $player->id;
                $transaction->amount = $amount;
                $transaction->idempotency_key = $idempotencyKey;
                $transaction->save();

                $player->balance += $amount;
                $player->save();

                DB::commit();

                return $transaction;
            } catch (Throwable $e) {
                DB::rollBack();

                return null;
            }
        }

        return $transaction;
    }

    public function sessionExpired(Player $player, array $data): void
    {

    }

    public function adjustment(Player $player, array $data): ?array
    {
        $amount = $data['amount'];
        $idempotencyKey = $data['reference'];

        $transaction = Transaction::where('player_id', $player->id)->where('idempotency_key', $idempotencyKey)->first();

        if ($player->balance - $amount < 0) {
            return [
                'negative_balance' => $amount,
            ];
        }

        if (! $transaction) {
            try {
                DB::beginTransaction();

                $transaction = new Transaction;
                $transaction->player_id = $player->id;
                $transaction->amount = $amount;
                $transaction->idempotency_key = $idempotencyKey;
                $transaction->save();

                $player->balance += $amount;
                $player->save();

                DB::commit();

                return [
                    'transaction' => $transaction,
                ];
            } catch (Throwable $e) {
                DB::rollBack();

                return null;
            }
        }

        return [
            'transaction' => $transaction,
        ];
    }

    public function roundDetails(Player $player, array $data): void
    {

    }
}
