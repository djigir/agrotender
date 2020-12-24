<?php

namespace App\Models\ADV;

use App\Models\Torg\TorgBuyer;
use Illuminate\Database\Eloquent\Model;

class AdvTorgPostComplains extends Model
{
    protected $table = 'adv_torg_post_complains';

    protected $fillable = [
        'id',
        'author_id',
        'item_id',
        'viewed',
        'status',
        'ip',
        'ddchk_guid',
        'adv_url',
        'msg ',
    ];

    public $timestamps = false;

    protected $dates = ['add_date'];

    /* Relations */

    public function torgBuyer()
    {
        return $this->hasOne(TorgBuyer::class, 'id', 'author_id');
    }

    public function advTorgPost()
    {
        return $this->hasOne(AdvTorgPost::class, 'id', 'item_id');
    }
}
