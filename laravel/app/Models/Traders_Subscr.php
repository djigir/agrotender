<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $buyer_id;
 * @param integer $cult_id;
 * @param integer $is_active;
 * @param integer $period;
 * @param \DateTime $add_date;
 * @param \DateTime $until_date;
 */

class Traders_Subscr extends Model
{
    protected $table = 'traders_subscr';

    protected $fillable = [
        'id',
        'buyer_id',
        'cult_id',
        'is_active',
        'period',
        'add_date',
        'until_date',
    ];
}
