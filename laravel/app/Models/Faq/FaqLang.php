<?php

namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Model;

class FaqLang extends Model
{
    protected $table = 'faq_lang';
    protected $fillable = ['id', 'item_id', 'lang_id', 'title', 'content'];
    public $timestamps = false;

    public function FaqLang()
    {
        return $this->belongsTo(FaqLang::class, 'id', 'item_id');
    }

    public function Faq()
    {
        return $this->belongsTo(Faq::class, 'id', 'item_id');
    }
}
