<?php

namespace App\Models\Regions;

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
}
