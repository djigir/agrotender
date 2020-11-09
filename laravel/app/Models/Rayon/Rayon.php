<?php

namespace App\Models\Rayon;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Rayon
 * @package App\Models\Comp
 * @property integer $id
 * @property integer $obl_id
 * @property string $ray_url
 */
class Rayon extends Model
{
    protected $table = 'torg_elevator';

    protected $fillable = ['id', 'obl_id', 'ray_url'];

}
