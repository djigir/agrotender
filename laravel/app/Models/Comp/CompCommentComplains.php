<?php

namespace App\Models\Comp;

use App\Models\Torg\TorgBuyer;
use Illuminate\Database\Eloquent\Model;

class CompCommentComplains extends Model
{
    protected $table = 'comp_comment_complains';

    protected $fillable = [
        'id',
        'comment_id',
        'sreply_to_id',
        'author_id',
        'viewed',
        'status',
        'ip',
        'ddchk_guid',
        'msg',
    ];

    protected $dates = ['add_date'];

    public $timestamps = false;



     /**
     * @param  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUsersComplains($query, $type)
    {
        $comment_id = $type['comment_id'];

        return $query->where('comment_id', $comment_id);
    }


    /* Relations */

    public function torgBuyer()
    {
        return $this->hasOne(TorgBuyer::class, 'id', 'author_id');
    }

}
