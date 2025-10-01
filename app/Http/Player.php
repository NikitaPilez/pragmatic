<?php

namespace App\Http;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $user_id
 * @property float $balance
 * @property float $bonus
 * @property string $currency
 * @property bool $is_banned
 */
class Player extends Model
{

}
