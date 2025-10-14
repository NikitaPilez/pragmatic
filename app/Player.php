<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property string $user_id
 * @property float $balance
 * @property float $bonus
 * @property string $currency
 * @property string $token
 * @property bool $is_banned
 */
class Player extends Model
{
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
