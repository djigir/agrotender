<?php

namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';
    protected $fillable = ['id', 'group_id', 'sort_num',
        'view_num', 'filename', 'add_date', 'url'
    ];
    public $timestamps = false;
}
