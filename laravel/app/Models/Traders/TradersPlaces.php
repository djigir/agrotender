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

    protected $appends = ['region', 'port'];

    public function getRegionAttribute()
    {
        $region = Regions::where('id', $this->obl_id)->select('id', 'name', 'parental')->get()->toArray();
        return !empty($region) ? $region[0] : [];
    }

    public function getPortAttribute()
    {
        $port = TradersPorts::where('id', $this->port_id)->get()->toArray();
        return !empty($port) ? $port[0] : [];
    }

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
