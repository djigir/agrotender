<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $item_id;
 * @param integer $dt;
 * @param string $amount;
 */

class Traders_Rate extends Model
{
    protected $table = 'traders_rate';

    protected $fillable = [
        'id',
        'item_id',
        'dt',
        'amount',
    ];
}
