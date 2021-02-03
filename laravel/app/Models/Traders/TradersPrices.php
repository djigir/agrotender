<?php

namespace App\Models\Traders;

use App\Models\Comp\CompItems;
use Carbon\Carbon;
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
 * @property  float $costval_old;
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
        'costval_old',
        'add_date',
        'change_date',
        'dt',
        'comment',
    ];

    protected $appends = ['date', 'change_price', 'change_price_type'];

    public function calculatingPriceChange()
    {
        /** TODO делаю временно больше 7 дней */
        $date_expired_diff = Carbon::now()->subDays(30)->format('Y-m-d');

        return $date_expired_diff <= $this->change_date ? round($this->costval - $this->costval_old) : 0;
    }


    public function getChangePriceAttribute()
    {
        return $this->calculatingPriceChange();
    }


    public function getChangePriceTypeAttribute()
    {
        if(!$this->change_date || !$this->calculatingPriceChange()){
            return '';
        }

        if($this->calculatingPriceChange() > 0)
        {
            return 'up';
        }

        return 'down';
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
