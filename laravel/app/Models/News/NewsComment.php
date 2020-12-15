<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;

class NewsComment extends Model
{
    protected $table = 'news_comment';

    protected $fillable = [
        'id',
        'item_id',
        'visible',
        'rate',
        'author',
        'author_email',
        'ddchk_guid',
    ];

    protected $dates = ['add_date'];

    public $timestamps = false;

    /* Relation */

    public function agtNews()
    {
        return $this->belongsTo(News::class, 'id');
    }

    public function newsLang()
    {
        return $this->hasOne(NewsCommentLang::class, 'item_id');
    }
}
