<?php

namespace App\Models\Traders;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $buyer_id;
 * @param integer $cult_id;
 * @param integer $place_id;
 * @param integer $active;
 * @param integer $curtype;
 * @param float $costval;
 * @param \Datetime  $add_date;
 * @param \Datetime $dt;
 * @param integer $acttype;
 */

class TradersPricesArc extends Model
{
    protected $table = 'traders_prices_arc';

    protected $fillable = [
        'id',
        'buyer_id',
        'cult_id',
        'place_id',
        'active',
        'curtype',
        'costval',
        'add_date',
        'dt',
        'acttype',
    ];


}
