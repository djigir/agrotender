<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;

class NewsLang extends Model
{
    protected $table = 'news_lang';

    protected $fillable = [
        'id',
        'news_id',
        'lang_id',
        'title',
        'content',
    ];


    public $timestamps = false;

    /* Relations */

    public function agtNews()
    {
        return $this->belongsTo(News::class, 'id');
    }
}
