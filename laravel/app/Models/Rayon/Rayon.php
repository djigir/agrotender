<?php

namespace App\Models\Rayon;

use App\Models\Elevators\TorgElevator;
use App\Models\Regions\Regions;
use Illuminate\Database\Eloquent\Model;

class Rayon extends Model
{
    protected $table = 'rayon';

    protected $fillable = [

        'id',
        'obl_id',
        'ray_url',
    ];

    public function rayonLang()
    {
        return $this->belongsTo(RayonLang::class, 'id');
    }

    public function regions()
    {
        return $this->belongsTo(Regions::class, 'id');
    }

    public function evetaorsRayons()
    {
        return $this->belongsTo(TorgElevator::class, 'ray_id');
    }
}
