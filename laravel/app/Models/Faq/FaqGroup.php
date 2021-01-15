<?php

namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Model;

class FaqGroup extends Model
{
    protected $table = 'faq_group';
    protected $fillable = ['id', 'sort_num', 'icon_filename', 'url'];
    public $timestamps = false;

    public function FaqGroupLang()
    {
        return $this->hasOne(FaqGroupLang::class, 'group_id', 'id');
    }
}
