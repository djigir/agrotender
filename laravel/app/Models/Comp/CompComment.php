<?php

namespace App\Models\Comp;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $item_id;
 * @param integer $visible;
 * @param integer $rate;
 * @param string  $author;
 * @param string  $author_email;
 * @param string  $ddchk_guid;
 * @param integer $reply_to_id;
 * @param integer $author_id;
 * @param integer $like_yes;
 * @param integer $like_no;
 *
 * @param \DateTime $add_date;
 */

class CompComment extends Model
{
    protected $table = 'comp_comment';

    protected $fillable = [
        'id',
        'item_id',
        'visible',
        'rate',
        'add_date',
        'author',
        'author_email',
        'ddchk_guid',
        'reply_to_id',
        'author_id',
        'like_yes',
        'like_no',
    ];
}
