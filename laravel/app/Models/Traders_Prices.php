<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $buyer_id;
 * @param integer $cult_id;
 * @param integer $place_id;
 * @param integer $active;
 * @param integer $acttype;
 * @param float $costval;
 * @param float $costva_old;
 * @param \Datetime  $add_date;
 * @param \Datetime  $change_date;
 * @param \Datetime $dt;
 * @param string $comment;
 */


class Traders_Prices extends Model
{
    protected $table = 'traders_prices';

    protected $fillable = [
        'id',
        'buyer_id',
        'cult_id',
        'place_id',
        'active',
        'acttype',
        'costval',
        'costva_old',
        'add_date',
        'change_date',
        'dt',
        'comment',
    ];
}
