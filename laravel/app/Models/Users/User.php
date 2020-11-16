<?php

namespace App\Models\Users;

use App\Models\Comp\CompItems;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * Class User
 * @package App\Models
 * @property  integer id
 * @property  $name
 * @property  string last_name
 * @property  $email
 * @property  $email_verified_at
 * @property  $password
 * @property  $remember_token
 * @property  $created_at
 * @property  $updated_at
 * @property  $role
 * @property  $time_zone
 * @property  $phone
 * @property  $ylogin
 * @property  $ypassword
 * @property  $y_key_api
 * @property  $parent_id
 *
 * @property string avatar
 * @property string avatar_url
 * @property string full_name
 *
 * @property CompItems company
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'auth_users_laravel';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'login', 'passwd', 'new_password', 'isactive', 'isactive_web', 'isactive_ban', 'discount_level_id',
        'last_login', 'avail_adv_posts', 'max_adv_posts', 'max_fishka', 'name', 'name2', 'name3', 'city_id', 'obl_id',
        'ray_id', 'rate', 'postdone', 'orgname', 'city', 'address', 'phone', 'phone2',
        'phone3', 'newphone', 'email', 'icq', 'telegram', 'guid_deact', 'viber', 'last_visit_url',
        'guid_act', 'skype', 'comments', 'smschecked', 'deact_up_mails', 'subscr_adv_deact',
        'subscr_adv_up', 'subscr_tr_price', 'old_login', 'new_login', 'new_login_guid', 'last_ip', 'hash', 'add_date',
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


    public function company()
    {
        return $this->hasOne(CompItems::class, 'author_id', 'user_id');
    }
}
