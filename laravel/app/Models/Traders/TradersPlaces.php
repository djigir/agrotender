<?php

namespace App\Models\Traders;

use App\Models\Comp\CompItems;
use App\Models\Regions\Regions;
use App\Models\Traders\TradersPrices;
use Illuminate\Database\Eloquent\Model;

/**
 * @property  integer $id;
 * @property  integer $buyer_id;
 * @property  integer $obl_id;
 * @property  integer $type_id;
 * @property  string $place;
 * @property  integer $acttype;
 * @property  integer $port_id;
 * @property  integer $is_port;
 */

class TradersPlaces extends Model
{
    protected $table = 'traders_places';

    protected $fillable = [
        'id',
        'buyer_id',
        'obl_id',
        'type_id',
        'place',
        'acttype',
        'port_id',
        'is_port',
    ];

//    protected $appends = ['region','port'];
//
//    public function getRegionAttribute()
//    {
//        return $this->regions->first();
//    }
//
//    public function getPortAttribute()
//    {
//        return $this->traders_ports->first();
//    }

    public function region()
    {
        return $this->regions();
    }

    public function port()
    {
        return $this->traders_ports();
    }

    public function traders_prices()
    {
        return $this->belongsTo(TradersPrices::class, 'id','place_id');
    }

    public function traders_ports()
    {
        return $this->hasMany(TradersPorts::class, 'id', 'port_id')->with('traders_ports_lang');
    }

    public function regions()
    {
        return $this->hasMany(Regions::class, 'id', 'obl_id');
    }


    public function scopePlace($query, $obl_id, $port_id, $type_place)
    {
        if($obl_id){
            return $query->where('obl_id', $obl_id);
        }

        if($port_id){
            return $query->where('port_id', $port_id)->where('type_id', 2);
        }

        if($type_place == 2){
            return $query->where('type_id', 2);
        }

        return $query;
    }

}
