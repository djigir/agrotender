<?php

namespace App\Models\Rayon;

use App\Models\Elevators\TorgElevator;
use Illuminate\Database\Eloquent\Model;


/**
 * Class TorgElevator
 * @package App\Models\Comp
 * @property integer $id
 * @property integer $lang_id
 * @property integer $ray_id
 * @property string $name
 *
 */
class RayonLang extends Model
{
    protected $table = 'rayon_lang';

    protected $fillable = ['id', 'lang_id', 'ray_id', 'name'];



    /*public function torg_elevator()
    {
        return $this->belongsTo(TorgElevator::class, 'ray_id', 'ray_id');
    }*/

    public function torgElevator()
    {
        return $this->belongsTo(TorgElevator::class, 'ray_id', 'ray_id');
    }

    public function rayon()
    {
        return $this->hasMany(Rayon::class, 'obl_id');
    }

    public function torg_elevator()
    {
        return $this->belongsTo(TorgElevator::class, 'ray_id', 'ray_id');

    }
}
