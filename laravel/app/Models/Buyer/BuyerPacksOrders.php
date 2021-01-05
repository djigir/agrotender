<?php

namespace App\Models\Buyer;

use App\Models\ADV\AdvTorgPost;
use App\Models\Py\PyBill;
use Illuminate\Database\Eloquent\Model;

class BuyerPacksOrders extends Model
{
    protected $table = 'buyer_packs_orders';

    protected $fillable = [
        'id',
        'user_id',
        'post_id',
        'pack_id',
        'pack_type',
        'adv_avail',
        'notified',
        'notified0',
        'notify_dt',
        'notify0_dt',
        'stdt',
        'endt',
        'add_date',
        'comments',
    ];

    public $timestamps = false;

    /* Relations */

    public function tarif()
    {
        return $this->hasOne(BuyerTarifPacks::class, 'id', 'pack_id');
    }

    public function torgPost()
    {
        return $this->hasOne(AdvTorgPost::class, 'id', 'post_id');
    }

    public function pyBill()
    {
        return $this->hasOne(PyBill::class, 'buyer_id', 'user_id');
    }

    /* Scope */

    /**
     * @param     $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeTorgBuyerPackOreders($query, $type)
    {
        $user_id = $type['user_id'];

        return $query->where('user_id', $user_id);
    }
}
