<?php

namespace App\Models\Regions;

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
    protected $table = 'regions';

//    public function __construct()
//    {
//        parent::__construct();
//        $this->table = 'regions';
//    }

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
