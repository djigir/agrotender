<?php

namespace App\Models\Torg;

use App\Models\Comp\CompItems;
use App\Models\Regions\Regions;
use Illuminate\Database\Eloquent\Model;

class TorgBuyer extends Model
{
    protected $table = 'torg_buyer';

    protected $fillable = [
        'id', 'login', 'passwd', 'new_password', 'isactive', 'isactive_web', 'isactive_ban', 'discount_level_id', 'add_date',
        'last_login', 'avail_adv_posts', 'max_adv_posts', 'max_fishka', 'name', 'name2', 'name3', 'city_id', 'obl_id',
        'ray_id', 'rate', 'postdone', 'orgname', 'city', 'address', 'phone', 'phone2',
        'phone3', 'newphone', 'email', 'icq', 'telegram', 'guid_deact', 'viber', 'last_visit_url',
        'guid_act', 'skype', 'comments', 'smschecked', 'deact_up_mails', 'subscr_adv_deact',
        'subscr_adv_up', 'subscr_tr_price', 'old_login', 'new_login', 'new_login_guid', 'last_ip', 'hash',
    ];

    protected $dates = ['add_date'];

    public $timestamps = false;

    public function comp_item()
    {
        return $this->belongsTo(CompItems::class, 'id');
    }

    public function compItems()
    {
        return $this->belongsTo(CompItems::class, 'author_id');
    }

    public function companyForBuyer()
    {
        return $this->hasOne(CompItems::class, 'author_id');
    }

    public function regions()
    {
        return $this->hasOne(Regions::class, 'id', 'obl_id');
    }
}
