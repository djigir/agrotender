<?php

namespace App\Models\Elevators;

use App\Models\Rayon\Rayon;
use App\Models\Rayon\RayonLang;
use App\Models\Regions\Regions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class TorgElevator
 * @package App\Models\Comp
 * @property integer $id
 * @property integer $obl_id
 * @property integer $ray_id
 * @property integer $rate
 * @property string $phone
 * @property string $elev_url
 * @property string $email
 * @property string $filename
 *
 */
class TorgElevator extends Model
{
    protected $table = 'torg_elevator';

    protected $fillable = ['id', 'obl_id', 'ray_id',
        'rate', 'phone', 'elev_url', 'email', 'filename'
    ];

    public $timestamps = false;

//    public function lang_elevator()
//    {
//        return $this->hasMany(TorgElevatorLang::class,'item_id', 'id');
//    }

    public function region()
    {
        return $this->hasOne(Regions::class,'id', 'obl_id');
    }

//    public function lang_rayon()
//    {
//        return $this->hasMany(RayonLang::class, 'ray_id', 'ray_id');
//    }

    public function langElevator()
    {
        return $this->hasOne(TorgElevatorLang::class,'item_id', 'id');
    }


    public function rayon()
    {
        return $this->hasMany(Rayon::class, 'id', 'obl_id');
    }

    public function langRayon()
    {
        return $this->hasMany(RayonLang::class, 'ray_id', 'ray_id');
    }
}
