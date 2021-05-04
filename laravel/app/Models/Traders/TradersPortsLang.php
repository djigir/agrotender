<?php

namespace App\Models\Traders;

use Illuminate\Database\Eloquent\Model;


/**
 * @param  integer $id
 * @param  integer $port_id
 * @param  integer $lang_id
 * @param  string $portname
 * @param  string $p_title
 * @param  string $p_h1
 * @param  string $p_descr
 * @param  string $p_content
 */
class TradersPortsLang extends Model
{
    protected $table = 'traders_ports_lang';

    protected $fillable = [
        'id',
        'port_id',
        'lang_id',
        'portname',
        'p_title',
        'p_h1',
        'p_descr',
        'p_content',
    ];


    public function traders_ports()
    {
        return $this->belongsTo(TradersPorts::class, 'id', 'port_id');
    }
}
