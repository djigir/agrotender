<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'id',
        'first_page',
        'intop',
        'ngroup',
        'view_num',
        'filename_src',
        'url',
        'filename_ico',
    ];

    protected $dates = ['dtime'];

    public $timestamps = false;


    /* Relations */

    public function NewsLang()
    {
        return $this->hasOne(NewsLang::class, 'news_id');
    }

    public function NewsComment()
    {
        return $this->hasMany(NewsComment::class, 'item_id');
    }
}
