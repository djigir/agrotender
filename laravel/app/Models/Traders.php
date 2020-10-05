<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param string $logo_filename;
 * @param string $url;
 * @param integer $sort_num;
 * @param \DateTime $add_date;
 * @param integer $rate;
 * @param integer $visible;
 * @param integer $till_dt;
 */

class Traders extends Model
{
    protected $table = 'traders';

    protected $fillable = [
        'id',
        'logo_filename',
        'url',
        'sort_num',
        'add_date',
        'rate',
        'visible',
        'till_dt',
    ];
}
