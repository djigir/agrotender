<?php

namespace App\Models\Regions;

use App\Models\Comp\CompItems;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Regions
 * @package App\Models\Regions
 * @property integer $id
 * @property string $name
 * @property string $parental
 * @property string $city
 * @property string $city_adverb
 * @property string $city_parental
 * @property string $translit
 */
class Regions extends Model
{
    protected $connection = 'mysql2';
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
}
