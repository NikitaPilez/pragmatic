<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property int $player_id
 * @property float $amount
 * @property string $idempotency_key
 */
class Transaction extends Model
{
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
