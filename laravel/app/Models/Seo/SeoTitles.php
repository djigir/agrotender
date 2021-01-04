<?php

namespace App\Models\Seo;

use App\Models\Regions\Regions;
use App\Models\Traders\Traders_Products_Lang;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class SeoTitles
 * @package App\Models\Seo
 *
 * @param integer $id;
 * @param integer $pagetype;
 * @param integer $csect_id;
 * @param integer $sect_id;
 * @param integer $cult_id;
 * @param integer $lang_id;
 * @param integer $obl_id;
 * @param integer $type_id;
 * @param integer $sortmode_id;
 * @param integer $filter_id;
 * @param integer $filter_val;
 * @param string $page_h1;
 * @param string $page_keywords;
 * @param string $page_title;
 * @param string $page_descr;
 * @param string $content_text;
 * @param string $content_words;
 * @param string $tpl_items_title;
 * @param string $tpl_items_keywords;
 * @param string $tpl_items_descr;
 * @param string $tpl_items_text;
 * @param string $tpl_items_words;
 *
 * @property Carbon $add_date;
 * @property Carbon $modify_date;
 */
class SeoTitles extends Model
{
    protected $table = 'seo_titles';

    protected $fillable = [
        'id', 'pagetype', 'csect_id', 'sect_id', 'cult_id',
        'lang_id', 'obl_id', 'type_id', 'sortmode_id', 'filter_id',
        'filter_val', 'add_date', 'modify_date', 'page_h1', 'page_keywords',
        'page_title', 'page_descr', 'content_text', 'content_words', 'tpl_items_title',
        'tpl_items_keywords', 'tpl_items_descr', 'tpl_items_text', 'tpl_items_words',
    ];

    /* Relations */

    public function tradersProductsLang()
    {
        return $this->hasOne(Traders_Products_Lang::class, 'item_id', 'cult_id');
    }

    public function regions()
    {
        return $this->hasOne(Regions::class, 'id', 'obl_id');
    }
}
