<?php

namespace App\Models\Traders;

use App\Models\Regions\Regions;
use App\Models\Traders\TradersPrices;
use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $buyer_id;
 * @param integer $obl_id;
 * @param integer $type_id;
 * @param string $place;
 * @param integer $acttype;
 * @param integer $port_id;
 * @param integer $is_port;
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


    public function traders_prices()
    {
        return $this->belongsTo(TradersPrices::class, 'place_id', 'id');
    }


    public function traders_ports()
    {
        return $this->hasMany(TradersPorts::class, 'id', 'port_id');
    }

    public function regions()
    {
        return $this->hasMany(Regions::class, 'id', 'obl_id');
    }
}
