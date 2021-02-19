<?php

namespace App\Models\Elevators;

use Illuminate\Database\Eloquent\Model;


/**
 * Class TorgElevator
 * @package App\Models\Comp
 * @property integer $id
 * @property integer $item_id
 * @property string $lang_id
 * @property string $name
 * @property string $addr
 * @property string $orgname
 * @property string $orgaddr
 * @property string $holdcond
 * @property string $descr_podr
 * @property string $descr_qual
 * @property string $director
 */
class TorgElevatorLang extends Model
{
    protected $table = 'torg_elevator_lang';

    protected $fillable = [
            'id', 'item_id', 'lang_id', 'name',
            'addr', 'orgname', 'orgaddr', 'holdcond',
            'descr_podr', 'descr_qual', 'director'
        ];

    public $timestamps = false;

    public function elevator()
    {
        return $this->belongsTo(TorgElevator::class, 'id', 'item_id');
    }

    public function getNameAttribute($value)
    {
        if(strpos(\Request::url(), 'admin_dev') != false){
            return htmlspecialchars_decode($value);
        }

        return $value;
    }
}

