<?php

namespace App\Models\Buyer;

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


}
