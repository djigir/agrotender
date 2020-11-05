<?php

namespace App\Models\Traders;

use Illuminate\Database\Eloquent\Model;

/**
 * @property  integer $id;
 * @property  integer $obl_id;
 * @property  integer $active;
 * @property  \DateTime $add_date;
 * @property  string $url;
 */
class TradersPorts extends Model
{
    protected $table = 'traders_ports';

    protected $fillable = [
        'id',
        'obl_id',
        'active',
        'add_date',
        'url',
    ];

    protected $appends = ['lang'];


    public function getLangAttribute()
    {
        //return TradersPortsLang::where('port_id', $this->id)->select('id', 'port_id', 'portname')->get()->toArray()[0];
//        if ($this->relationLoaded('traders_ports_lang')) {
//
//        }

        return \Cache::get('PORTS_LANG', function (){
            return TradersPortsLang::where('port_id', $this->id)->select('id', 'port_id', 'portname')->get()->toArray()[0];
        });

    }

    public function traders_ports_lang()
    {
        return $this->hasMany(TradersPortsLang::class, 'port_id', 'id');
    }

    public function traders_places()
    {
        return $this->belongsTo(TradersPortsLang::class, 'port_id', 'id');
    }

}
