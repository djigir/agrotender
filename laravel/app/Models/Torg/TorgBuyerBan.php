<?php

namespace App\Models\Torg;

use App\Models\Regions\Regions;
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

    /* Relations */

    public function torgBuyer()
    {
        return $this->belongsTo(TorgBuyer::class, 'user_id', 'id');
    }

    public function regions()
    {
        return $this->hasOneThrough(Regions::class, TorgBuyer::class, 'obl_id', 'id', 'user_id');
    }

    /**
     * @param     $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetBanedUser($query, $type)
    {
        $user_id = $type['user_id'];

        return $query->where('user_id', $user_id);
    }
}
