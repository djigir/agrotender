<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PagesLang
 * @param  integer $lang_id
 * @param  integer $page_mean
 * @param  string $item_id
 * @param  string $page_title
 * @param  string $id
 * @param  string $page_keywords
 * @param  string  $page_descr
 * @param  string  $title
 * @param  string  $header
 * @param  string  $content
 */

class PagesLang extends Model
{
    protected $table = 'pages_lang';

    protected $fillable = [
        'lang_id',
        'page_mean',
        'item_id',
        'page_title',
        'id',
        'page_keywords',
        'page_descr',
        'title',
        'header',
        'content',
    ];
}
