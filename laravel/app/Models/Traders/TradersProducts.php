<?php

namespace App\Models\Traders;

use App\Models\Traders\Traders_Products_Lang;
use Illuminate\Database\Eloquent\Model;

/**
 * @property  integer $id;
 * @property  string $icon_filename;
 * @property  string $url;
 * @property  integer $group_id;
 * @property  integer $acttype;
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
        return Traders_Products_Lang::where('item_id', $this->id)->select('name', 'id')->get()->toArray()[0];
    }

    public function traders_prices()
    {
        return $this->hasMany(TradersPrices::class, 'cult_id');
    }

    public function traders_product_groups_lang()
    {
        return $this->hasMany(TradersProductGroupLanguage::class, 'item_id');
    }

    public function traders_products2buyer()
    {
        return $this->belongsTo(TradersProducts2buyer::class,'cult_id', 'id');
    }

    public function products_price()
    {
        return $this->belongsTo(TradersPrices::class, 'cult_id', 'id');
    }
}
