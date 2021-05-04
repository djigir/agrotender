<?php

namespace App\Models\ADV;

use Illuminate\Database\Eloquent\Model;

class AdvTorgTopic extends Model
{
    protected $table = 'adv_torg_topic';

    protected $fillable = [
        'id', 'parent_id', 'sort_num', 'sort_incol', 'visible',
        'add_date', 'title', 'descr', 'menu_group_id', 'page_h1',
        'page_title', 'page_keywords', 'page_descr', 'seo_title_buy',
        'seo_keyw_buy', 'seo_descr_buy', 'seo_h1_buy', 'seo_text_buy',
        'seo_title_sell', 'seo_keyw_sell', 'seo_descr_sell', 'seo_h1_sell',
        'seo_text_sell'
    ];
}
