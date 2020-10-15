<?php

namespace App\Models\Traders;

use App\Models\Traders\Traders_Products_Lang;
use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param string $icon_filename;
 * @param string $url;
 * @param integer $group_id;
 * @param integer $acttype;
 */

class TradersProducts extends Model
{
    protected $table = 'traders_products';

    protected $fillable = [
        'id',
        'icon_filename',
        'url',
        'group_id',
        'acttype',
    ];

    protected $appends = ['culture'];


    public function getCultureAttribute()
    {
        return $this->traders_products_lang()
            ->get()
            ->toArray()[0];
    }

    public function traders_prices2()
    {
        return $this->belongsTo(TradersPrices::class, 'id');
    }

    public function traders_product_groups_lang()
    {
        return $this->hasMany(TradersProductGroupLanguage::class, 'item_id');
    }

    public function traders_products_lang()
    {
        return $this->hasMany(Traders_Products_Lang::class, 'item_id', 'id');
    }

    public function traders_prices()
    {
        return $this->hasMany(TradersPrices::class, 'cult_id');
    }


    public function traders_products2buyer()
    {
        return $this->belongsTo(TradersProducts2buyer::class,'cult_id', 'id');
    }
}
