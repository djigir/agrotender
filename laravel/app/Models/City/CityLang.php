<?php

namespace App\Models\City;

use App\Models\Users\Users;
use Illuminate\Database\Eloquent\Model;

class CityLang extends Model
{
    protected $table = 'city_lang';

    protected $fillable = [
        'id',
        'city_id',
        'lang_id',
        'name',
    ];

    public function users()
    {
        return $this->belongsTo(Users::class, 'city_id');
    }
}
