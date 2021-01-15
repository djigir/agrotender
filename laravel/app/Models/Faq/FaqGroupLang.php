<?php

namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Model;

class FaqGroupLang extends Model
{
    protected $table = 'faq_group_lang';
    protected $fillable = ['id', 'group_id', 'lang_id', 'type_name', 'descr'];
    public $timestamps = false;

    public function FaqGroup()
    {
        return $this->belongsTo(FaqGroup::class, 'id', 'group_id');
    }
}
