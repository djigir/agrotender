<?php

namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Model;

class FaqLang extends Model
{
    protected $table = 'faq_lang';
    protected $fillable = ['id', 'item_id', 'lang_id', 'title', 'content'];
    public $timestamps = false;
}
