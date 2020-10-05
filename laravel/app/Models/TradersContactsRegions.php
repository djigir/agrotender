<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $comp_id;
 * @param integer $buyer_id;
 * @param integer $sort_num;
 * @param string $name;
 */

class TradersContactsRegions extends Model
{
    protected $table = 'traders_contacts_regions';

    protected $fillable = [
        'id',
        'comp_id',
        'buyer_id',
        'sort_num',
        'name',
    ];
}
