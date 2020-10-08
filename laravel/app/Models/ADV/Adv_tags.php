<?php

namespace App\Models\ADV;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Adv_tags
 * @package App\Models\ADV
 * @property integer $id
 * @property string $tag
 * @property string $url
 * @property integer  $rate
 * @property integer  $visible
 * @property Carbon $add_date
 * @property string  $tag_words
 *
 *
 */
class Adv_tags extends Model
{
    protected $table = 'adv_tags';

    protected $fillable = [
        'id' ,
        'tag',
        'url',
        'rate',
        'visible',
        'add_date',
        'tag_words',
    ];
}
