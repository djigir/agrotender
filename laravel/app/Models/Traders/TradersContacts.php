<?php

namespace App\Models\Traders;

use App\Models\Traders\TradersContactsRegions;
use Illuminate\Database\Eloquent\Model;

/**
 * @param integer $id;
 * @param integer $region_id;
 * @param integer $buyer_id;
 * @param integer $sort_num;
 * @param string $dolg;
 * @param string $fio;
 * @param string $phone;
 * @param string $fax;
 * @param string $email;
 */

class TradersContacts extends Model
{
    protected $table = 'traders_contacts';

    protected $fillable = [
        'id',
        'region_id',
        'buyer_id',
        'sort_num',
        'dolg',
        'fio',
        'phone',
        'fax',
        'email',
    ];

    public function traders_contacts_regions()
    {
        return $this->belongsTo(TradersContactsRegions::class, 'id');
    }
}
