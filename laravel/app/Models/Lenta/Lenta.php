<?php

namespace App\Models\Lenta;

use App\Models\Comp\CompItems;
use Illuminate\Database\Eloquent\Model;

class Lenta extends Model
{
    protected $table = 'lenta';

    protected $fillable = [
        'id',
        'type_id',
        'lenta',
        'post_id',
        'other_id',
        'topic_id',
        'author_id',
        'comp_id',
        'only_same_comp',
        'trader',
        'title',
        'author',
        'sesguid',
    ];

    protected $dates = ['add_date', 'up_dt', 'post_dt',];

    public $timestamps = false;

    /* Relation */

}
