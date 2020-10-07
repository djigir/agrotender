<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $item_id;
 * @param integer $lang_id;
 * @param string $content;
 */

class TradersCommentLang extends Model
{
    protected $table = 'traders_comment_lang';

    protected $fillable = [
        'id',
        'item_id',
        'lang_id',
        'content',
    ];
}
