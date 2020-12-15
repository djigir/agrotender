<?php

namespace App\Models\Users;

use App\Models\City\CityLang;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'small_photo_file',
        'photo_file',
        'description',
        'intro', 'web_url', 'email3',
        'email2',
        'email1',
        'cell_phone',
        'office_phone',
        'telephone',
        'zip_code',
        'country',
        'state',
        'city_id',
        'address',
        'name',
        'isactive',
        'activation_code',
        'group_id',
        'passwd',
        'login',
        'id',
    ];

    public $timestamps = false;

    protected $dates = ['regdate'];

    public function city()
    {
        return $this->hasOne(CityLang::class, 'city_id');
    }

    public function userGroups()
    {
        return $this->hasOne(UserGroups::class, 'id');
    }
}
