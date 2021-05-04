<?php

namespace App\Models\BlackNews;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class BlackNews
 * @package App\Models\BlackNews
 * @param integer $id;
 * @param integer $item_id;
 * @param integer $amount;
 * @param Carbon $dt;
 */
class BlackNewsRate extends Model
{
    protected $table = 'blacknews_rate';

    protected $fillable = [
        'id',
        'item_id',
        'amount'
    ];

    protected $dates = ['dt'];
}
