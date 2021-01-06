<?php

namespace App\Modes\Popup;

use App\Models\Popup\PopupDlgs;
use Illuminate\Database\Eloquent\Model;

class PopupDlgsLang extends Model
{
    protected $table = 'popup_dlgs_lang';

    protected $fillable = [
        'id', 'item_id', 'lang_id',
        'btntext', 'title', 'content',
    ];

    public $timestamps = false;

    public function popupDlgs()
    {
        return $this->belongsTo(PopupDlgs::class, 'id', 'item_id');
    }
}
