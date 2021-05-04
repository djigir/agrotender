<?php

namespace App\Models\BlackNews;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class BlackNews
 * @package App\Models\BlackNews
 * @param integer $id;
 * @param integer $id;
 * @param integer $item_id;
 * @param integer $visible;
 * @param integer $rate;
 * @param string $author;
 * @param string $author_email;
 *
 * @param Carbon $add_date;
 */
class BlackNewsComment extends Model
{
    protected $table = 'blacknews_comment';

    protected $fillable = [
        'id',
        'item_id',
        'visible',
        'rate',
        'author',
        'author_email'
    ];

    protected $dates = ['add_date'];
}
