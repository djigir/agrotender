<?php

namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Model;

class FaqAssign extends Model
{
    protected $table = 'faq_assign';
    protected $fillable = ['id', 'item_id', 'faq_id'];
    public $timestamps = false;
}
