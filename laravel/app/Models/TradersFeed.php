<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradersFeed extends Model
{
    protected $table = 'traders_feed';

    protected $fillable = [
        'id',
        'rubric',
        'place',
        'change_price',
        'user',
        'change_date',
    ];
}
