<?php

namespace App\Models\ADV;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $parent_id
 * @property integer $sort_num
 * @property integer $sort_incol
 * @property integer $visible
 * @property string $descr
 * @property string $title
 * @property integer $menu_group_id
 * @property string $page_h1
 * @property string $page_title
 * @property string $page_keywords
 * @property string $page_descr
 * @property string $seo_title_buy
 * @property string $seo_keyw_buy
 * @property string $seo_descr_buy
 * @property string $seo_h1_buy
 * @property string $seo_text_buy
 * @property string $seo_keyw_sell
 * @property string $seo_descr_sell
 * @property string $seo_title_sell
 * @property string $seo_h1_sell
 * @property string $seo_text_sell
 *
 * @property Carbon $add_date
*/
class AdvTorgTopic extends Model
{
    protected $table = 'adv_torg_topic';

    protected $fillable = [
        'id', 'parent_id', 'sort_num', 'sort_incol', 'visible',
        'add_date', 'descr', 'title', 'menu_group_id', 'page_h1',
        'page_title', 'page_keywords', 'page_descr', 'seo_title_buy',
        'seo_keyw_buy', 'seo_descr_buy', 'seo_h1_buy', 'seo_text_buy',
        'seo_keyw_sell', 'seo_descr_sell', 'seo_title_sell', 'seo_h1_sell',
        'seo_text_sell'
    ];

    /* Relations */

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }


    public function word_topic()
    {
        return $this->belongsTo(AdvWordTopic::class, 'id', 'topic_id');
    }
}
