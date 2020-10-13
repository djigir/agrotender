<?php

namespace App\Models\Comp;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CompItems
 *
 * @param integer $id;
 * @param integer $item_id;
 * @param integer $lang_id;
 * @param string $content;
 * @param string $content_plus;
 * @param string $content_minus;
 *
 */

class CompCommentLang extends Model
{
    protected $table = 'comp_comment_lang';

    protected $fillable = [
        'id',
        'item_id',
        'lang_id',
        'content',
        'content_plus',
        'content_minus',
    ];

    /* Relations */

    public function comp_comment()
    {
        return $this->belongsTo(CompComment::class, 'id');
    }
}
