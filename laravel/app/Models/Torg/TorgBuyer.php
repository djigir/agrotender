<?php

namespace App\Models\Torg;

use App\Models\ADV\AdvTorgPost;
use App\Models\Buyer\BuyerPacksOrders;
use App\Models\Buyer\BuyerTarifPacks;
use App\Models\Comp\CompItems;
use App\Models\Py\PyBalance;
use App\Models\Regions\Regions;
use App\Models\Py\PyBill;
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


    /* return route for adverts filter */

    public function TorgBuyerAdverts()
    {
        $model_name = 'adv_torg_posts';

        return route('admin.model', $model_name);
    }

    public function TorgBuyerAdvertsCount()
    {
        $model_name = 'torg_buyer';

        return route('admin.model', $model_name);
    }

    public function TorgBuyerBanRoute()
    {
        $model_name = 'torg_buyer_bans';

        return route('admin.model', $model_name);
    }

    public function TorgBuyerPackOreders()
    {
        $model_name = 'buyer_packs_orders';

        return route('admin.model', $model_name);
    }

    public function getBalance()
    {
        return PyBalance::select(\DB::raw('round(coalesce(sum(amount), 0)) as balance'))
            ->where('buyer_id', $this->id)->get()[0]['balance'];
    }


    /* Relations */

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

    public function pyBill()
    {
        return $this->belongsTo(PyBill::class,'buyer_id', 'id');
    }

    public function advTorgPost()
    {
        return $this->hasMany(AdvTorgPost::class, 'author_id', 'id');
    }


    public function torgBuyerBan()
    {
        return $this->hasOne(TorgBuyerBan::class, 'user_id', 'id');
    }

    public function buyerPacksOrders()
    {
        return $this->hasMany(BuyerPacksOrders::class, 'user_id', 'id');
    }

    public function pyBalance()
    {
        return $this->belongsTo(PyBalance::class, 'buyer_id', 'id');
    }
}
