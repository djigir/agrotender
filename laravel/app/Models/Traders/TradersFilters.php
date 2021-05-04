<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $buyer_id;
 * @param string $obl_ids;
 * @param string $type_ids;
 * @param string $cult_ids;
 * @param integer $is_port;
 * @param \DateTime $add_date;
 * @param string $final_url;
 * @param string $title;
 */

class TradersFilters extends Model
{
    protected $table = 'traders_filters';

    protected $fillable = [
        'id',
        'buyer_id',
        'obl_ids',
        'type_ids',
        'cult_ids',
        'is_port',
        'add_date',
        'final_url',
        'title',
    ];
}
