<?php

namespace App\Models\Users;


use App\Models\Comp\CompItems;
use App\Notifications\CustomChangeLoginNotification;
use Carbon\Carbon;
use Core\Request;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * Class User
 * @package App\Models\User
 * @property integer $discount_level_id
 * @property integer $max_adv_posts
 * @property string $passwd
 * @property integer $obl_id
 * @property string $name3
 * @property integer $max_fishka
 * @property integer $rate
 * @property integer $user_id
 * @property integer $avail_adv_posts
 * @property integer $isactive_web
 * @property string $last_login
 * @property string $name
 * @property string $isactive
 * @property string $new_password
 * @property string $login
 * @property integer $city_id
 * @property string $name2
 * @property string $isactive_ban
 * @property integer $ray_id
 * @property string $orgname
 * @property string $postdone
 * @property string $city
 * @property string $address
 * @property string $phone2
 * @property string $newphone
 * @property string $icq
 * @property string $viber
 * @property string $comments
 * @property string $deact_up_mails
 * @property string $subscr_adv_deact
 * @property string $skype
 * @property string $last_visit_url
 * @property string $guid_deact
 * @property string $email
 * @property string $phone3
 * @property string $phone
 * @property string $telegram
 * @property string $guid_act
 * @property integer $smschecked
 * @property string $subscr_adv_up
 * @property string $old_login
 * @property string $new_login
 * @property string $subscr_tr_price
 * @property string $new_login_guid
 * @property integer $last_ip
 * @property string $hash
 * @property Carbon $add_date
 * @property integer $id
 *
 *
 * @property CompItems company
 */
class User extends Authenticatable
{
    use Notifiable;
    use CanResetPassword;

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

    public function getEmailForPasswordReset()
    {
        $this->email = auth()->user()->login;
    }

    public function sendPasswordResetNotification($token)
    {
        $email = \request()->get('login');

        $this->notify(new CustomChangeLoginNotification($token, $email));
    }

    public function company()
    {
        return $this->hasOne(CompItems::class, 'author_id', 'user_id');
    }
}
