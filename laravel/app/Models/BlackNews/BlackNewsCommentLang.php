<?php

namespace App\Models\BlackNews;

use Illuminate\Database\Eloquent\Model;


/**
 * Class BlackNews
 * @package App\Models\BlackNews
 * @param integer $id;
 * @param integer $id;
 * @param integer $item_id;
 * @param integer $lang_id;
 * @param string $content;
 */
class BlackNewsCommentLang extends Model
{
    protected $table = 'blacknews_comment_lang';

    protected $fillable = [
        'id',
        'item_id',
        'lang_id',
        'content'
    ];

    protected $dates = [];
}
