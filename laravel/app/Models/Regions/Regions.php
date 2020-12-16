<?php

namespace App\Models\Regions;

use App\Models\Comp\CompItems;
use App\Models\Elevators\TorgElevator;
use App\Models\Rayon\Rayon;
use App\Models\Traders\TradersPlaces;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Regions
 * @package App\Models\Regions
 * @param integer $id
 * @param string $name
 * @param string $parental
 * @param string $city
 * @param string $city_adverb
 * @param string $city_parental
 * @param string $translit
 */
class Regions extends Model
{
    protected $table = 'regions';


    protected $fillable = [
        'id',
        'name',
        'parental',
        'city',
        'city_adverb',
        'city_parental',
        'translit',
    ];

    public function traders_places()
    {
        return $this->belongsTo(TradersPlaces::class, 'obl_id', 'id');
    }


    public function rayons()
    {
        return $this->hasMany(Rayon::class, 'obl_id');
    }

    public function elevators()
    {
        return $this->hasMany(TorgElevator::class, 'obl_id');
    }

    public function compItems()
    {
        return $this->belongsTo(CompItems::class, 'obl_id');
    }
}
