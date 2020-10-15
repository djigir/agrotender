<?php

namespace App\Models\Traders;

use App\Models\Comp\CompItems;
use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $comp_id;
 * @param integer $buyer_id;
 * @param integer $sort_num;
 * @param string $name;
 */

class TradersContactsRegions extends Model
{
    protected $table = 'traders_contacts_regions';

    protected $fillable = [
        'id',
        'comp_id',
        'buyer_id',
        'sort_num',
        'name',
    ];

    public function comp_items()
    {
        return $this->belongsTo(CompItems::class, 'id');
    }
}
