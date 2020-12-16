<?php

namespace App\Models\Buyer;

use App\Models\Comp\CompItems;
use Illuminate\Database\Eloquent\Model;

class BuyerTarifPacks extends Model
{
    protected $table = 'buyer_tarif_packs';

    protected $fillable = [
        'id',
        'pack_type',
        'sort_num',
        'active',
        'adv_num',
        'fish_num',
        'targ_num',
        'fish_hours',
        'cost',
        'add_date',
        'title',
        'content',
        'period_type',
        'period',
    ];

    public $timestamps = false;

    /* Relations */

    public function compItems()
    {
        return $this->belongsTo(CompItems::class, 'site_pack_id');
    }
}
