<?php

namespace App\Models\Traders;
use App\Models\Seo\SeoTitles;
use App\Models\Traders\TradersProducts;
use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $port_id;
 * @param integer $lang_id;
 * @param string $portname;
 * @param string $p_title;
 * @param string $p_h1;
 * @param string $p_descr;
 * @param string $p_content;
 */

class Traders_Products_Lang extends Model
{
    protected $table = 'traders_products_lang';

    protected $fillable = ['id', 'item_id', 'lang_id', 'name', 'descr'];

    public $timestamps = false;

    public function traders_prices_arc()
    {
        return $this->belongsTo(TradersPricesArc::class, 'id');
    }

    public function traders_products()
    {
        return $this->hasMany(TradersProducts::class, 'id', 'item_id');
    }

    public function traders_prices()
    {
        return $this->hasMany(TradersPrices::class, 'cult_id', 'item_id');
    }

    public function traders_feed()
    {
        return $this->hasMany(TraderFeed::class, 'rubric');
    }

    public function seoTitles()
    {
        return $this->belongsTo(SeoTitles::class, 'cult_id', 'item_id');
    }
}


