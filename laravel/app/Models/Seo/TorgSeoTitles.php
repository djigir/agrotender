<?php

namespace App\Models\Seo;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TorgSeoTitles
 * @param  integer $id
 * @param  integer $obl_id
 * @param  integer $cult_id
 * @param  integer $trade
 * @param  integer $lang_id
 * @param  integer $sortmode_id
 * @param  string $page_title
 * @param  string $page_keywords
 * @param  string $page_descr
 * @param  string $content_text
 * @param  string $content_words
 * @param  string $tpl_items_title
 * @param  string $tpl_items_keywords
 * @param  string $tpl_items_descr
 * @param  string $tpl_items_text
 * @param  string $tpl_items_words
 *
 * @property Carbon add_date
 * @property Carbon modify_date
 */
class TorgSeoTitles extends Model
{
    protected $table = 'torg_seo_titles';

    protected $fillable = [
        'id', 'obl_id', 'cult_id', 'trade',
        'lang_id', 'sortmode_id', 'add_date', 'modify_date',
        'page_title',
        'page_keywords',
        'page_descr',
        'content_text',
        'content_words',
        'tpl_items_title',
        'tpl_items_keywords',
        'tpl_items_descr',
        'tpl_items_text',
        'tpl_items_words'
    ];
}
