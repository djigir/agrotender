<?php

namespace App\Models\Traders;

use App\Models\Comp\CompItems;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

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

    protected $appends = ['date','culture'];


    public function getCultureAttribute()
    {
        $this->cultures->first();
    }

    public function getDateAttribute()
    {
        return Date::parse($this->dt);
    }
    /* Relations */

    public function cultures()
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


    public function traders_products_buyer()
    {
        return $this->belongsTo(TradersProducts2buyer::class, 'id', 'cult_id');
    }
}
