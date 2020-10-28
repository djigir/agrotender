<?php

namespace App\Models\Traders;

use App\Models\Comp\CompItems;
use Illuminate\Database\Eloquent\Model;

/**
 * @property  integer $id;
 * @property  integer $buyer_id;
 * @property  string $name;
 * @property  integer $cult_id;
 * @property  integer $place_id;
 * @property  integer $active;
 * @property  integer $acttype;
 * @property  float $costval;
 * @property  float $costva_old;
 * @property  \Datetime  $add_date;
 * @property  \Datetime  $change_date;
 * @property  \Datetime $dt;
 * @property  string $comment;
 */


class TradersPrices extends Model
{
    protected $table = 'traders_prices';

    protected $fillable = [
        'id',
        'buyer_id',
        'cult_id',
        'place_id',
        'active',
        'acttype',
        'costval',
        'costva_old',
        'add_date',
        'change_date',
        'dt',
        'comment',
    ];

    /* Mutations */
//    protected $appends = ['places'];
//
//
//    public function getPlacesAttribute()
//    {
//        $place = TradersPlaces::where([['id', $this->place_id], ['type_id', '!=', 1]])->get()->toArray();
//        return !empty($place) ? $place[0] : null;
//    }

    /* Relations */

    public function product_lang()
    {
        return $this->hasMany(Traders_Products_Lang::class, 'item_id', 'cult_id');
    }

    public function compItems()
    {
        return $this->belongsTo(CompItems::class, 'author_id', 'buyer_id');
    }

    public function traders_places()
    {
        return $this->hasMany(TradersPlaces::class, 'id', 'place_id');
    }

    public function traders_products()
    {
        return $this->hasMany(TradersProducts::class, 'id', 'cult_id');
    }


    public function price_products()
    {
        return $this->hasMany(TradersProducts::class, 'id', 'cult_id');
    }
}
