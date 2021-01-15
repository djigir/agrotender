<?php

namespace App\Models\ADV;

use Illuminate\Database\Eloquent\Model;

class AdvTorgPostModerMsg extends Model
{
    public $table = 'adv_torg_post_modermsg';

    protected $fillable = ['post_id','msg','add_date'];

    protected $dates = ['add_date'];
    public $timestamps = false;
}
