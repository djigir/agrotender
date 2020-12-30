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

    /* Relations */

    public function torgBuyer()
    {
        return $this->hasOne(TorgBuyer::class, 'id', 'author_id');
    }

}
