<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;

class NewsCommentLang extends Model
{
    protected $table = 'news_comment_lang';

    protected $fillable = [
        'id',
        'item_id',
        'lang_id',
        'content',
    ];


    public $timestamps = false;

    /* Relations */

    public function newsComment()
    {
        return $this->belongsTo(NewsComment::class, 'id');
    }
}
