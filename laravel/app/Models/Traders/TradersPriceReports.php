<?php

namespace App\Models\Traders;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $author_id;
 * @param integer $cult_id;
 * @param integer $obl_id;
 * @param \DateTime $add_date;
 */

class TradersPriceReports extends Model
{
    protected $table = 'traders_price_reports';

    protected $fillable = [
        'id',
        'author_id',
        'cult_id',
        'obl_id',
        'add_date',
    ];
}
