<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'auth_users_laravel';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'login', 'passwd', 'new_password', 'isactive', 'isactive_web', 'isactive_ban', 'discount_level_id',
        'last_login', 'avail_adv_posts', 'max_adv_posts', 'max_fishka', 'name', 'name2', 'name3', 'city_id', 'obl_id',
        'ray_id', 'rate', 'postdone', 'orgname', 'city', 'address', 'phone', 'phone2',
        'phone3', 'newphone', 'email', 'icq', 'telegram', 'guid_deact', 'viber', 'last_visit_url',
        'guid_act', 'skype', 'comments', 'smschecked', 'deact_up_mails', 'subscr_adv_deact',
        'subscr_adv_up', 'subscr_tr_price', 'old_login', 'new_login', 'new_login_guid', 'last_ip', 'hash',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
