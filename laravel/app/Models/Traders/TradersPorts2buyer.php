<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $buyer_id;
 * @param integer $cult_id;
 * @param integer $type_id;
 * @param integer $sort_ind;
 * @param integer $acttype;
 */


class Traders_Ports2buyer extends Model
{
    protected $table = 'traders_ports2buyer';

    protected $fillable = [
        'id',
        'buyer_id',
        'cult_id',
        'type_id',
        'sort_ind',
        'acttype',
    ];
}
