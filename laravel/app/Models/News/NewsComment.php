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

    /* scope */

    /**
     * @param     $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNewsComment($query, $type)
    {
        $news_id = $type['item_id'];

        return $query->where('item_id', $news_id);
    }

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
