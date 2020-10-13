<?php

namespace App\Models\Traders;

use Illuminate\Database\Eloquent\Model;

class TraderFeed extends Model
{
    protected $table = 'traders_feed';

    const TYPE_SELL = 1;
    const TYPE_FORWARD = 0;
    const TYPES_TEXT = [
        self::TYPE_FORWARD => '_forward',
        self::TYPE_SELL => '_sell'
    ];
    
    
    protected $fillable = [
        'id',
        'rubric',
        'place',
        'change_price',
        'user',
        'change_date',
    ];


}
