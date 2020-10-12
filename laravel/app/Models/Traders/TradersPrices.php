<?php

namespace App\Models\Traders;

use App\Models\Comp\CompItems;
use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $buyer_id;
 * @param string $name;
 * @param integer $cult_id;
 * @param integer $place_id;
 * @param integer $active;
 * @param integer $acttype;
 * @param float $costval;
 * @param float $costva_old;
 * @param \Datetime  $add_date;
 * @param \Datetime  $change_date;
 * @param \Datetime $dt;
 * @param string $comment;
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
    protected $appends=['name'];

    public function getNameAttribute()
    {
        if($this->product_lang){
            return $this->product_lang->name;
        }
        return '';
    }

    /* Relations */

    public function product_lang()
    {
         return $this->belongsTo(Traders_Products_Lang::class, 'item_id');
    }

    public function compItems()
    {

        //return $this->belongsTo(CompItems::class, 'id');

        return $this->hasMany(CompItems::class, 'author_id');

    }

    public function traders_places()
    {
        return $this->belongsTo(TradersPlaces::class, 'id');
    }

    public function traders_products()
    {
        return $this->belongsTo(TradersProducts::class, 'item_id');
    }

    public function traders_products2()
    {
        return $this->hasMany(TradersProducts::class, 'cult_id');
    }

    /*public function traders_products()
    {
        return $this->belongsTo(TradersProducts::class, 'id');
    }*/

}
