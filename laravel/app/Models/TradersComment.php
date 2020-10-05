<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $item_id;
 * @param integer $visible;
 * @param integer $rate;
 * @param \DateTime $add_date;
 * @param string $author;
 * @param string $author_email;
 * @param string $ddchk_quid;
 */

class TradersComment extends Model
{
    protected $table = 'traders_comment';

    protected $fillable = [
        'id',
        'item_id',
        'visible',
        'rate',
        'add_date',
        'author',
        'author_email',
        'ddchk_quid',
    ];
}
