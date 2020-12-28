<?php

namespace App\Models\Torg;

use Illuminate\Database\Eloquent\Model;

class TorgBuyerBan extends Model
{
    protected $table = 'torg_buyer_ban';

    protected $fillable = [
        'id',
        'item_id',
        'user_id',
        'period_days',
        'is_disabled',
        'is_notify',
        'ban_ip',
        'ban_ses',
        'ban_phone',
        'ban_email',
        'ban_name',
        'comment',
    ];

    protected $dates = ['add_date', 'end_date'];

    public $timestamps = false;
}
