<?php

namespace App\Models\BlackNews;

use Illuminate\Database\Eloquent\Model;


/**
 * Class BlackNews
 * @package App\Models\BlackNews
 * @param integer $id;
 * @param integer $news_id;
 * @param integer $lang_id;
 * @param string $title;
 * @param string $content;
 */
class BlackNewsLang extends Model
{
    protected $table = 'blacknews_lang';

    protected $fillable = [
        'id',
        'news_id',
        'lang_id',
        'title',
        'content'
    ];

    protected $dates = [];
}
