<?php

namespace App\Models\Traders;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $obl_id;
 * @param integer $active;
 * @param \DateTime $add_date;
 * @param string $url;
 */

class TradersPorts extends Model
{
    protected $table = 'traders_ports';

    protected $fillable = [
        'id',
        'obl_id',
        'active',
        'add_date',
        'url',
    ];
}
