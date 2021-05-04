<?php

namespace App\Models\ADV;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Adv_tags_rate
 * @package App\Models\ADV
 * @property integer $id
 * @property integer $item_id
 * @property Carbon $dt
 * @property integer $amount
 */

class AdvTagsRate extends Model
{
    protected $table = 'adv_tags_rate';

    protected $fillable = [
        'id',
        'item_id',
        'dt',
        'amount',
    ];
}
