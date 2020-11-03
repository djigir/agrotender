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
        if ($this->relationLoaded('traders_ports_lang')) {
            return $this->traders_ports_lang->first();
        }
        $lang = TradersPortsLang::where('port_id', $this->id)->select('id', 'port_id', 'portname')->get()->toArray();
        return !empty($lang) ? $lang[0] : [];
    }

    public function traders_ports_lang()
    {
        return $this->hasMany(TradersPortsLang::class, 'port_id');
    }

    public function traders_places()
    {
        return $this->belongsTo(TradersPortsLang::class, 'port_id', 'id');
    }

}
