<?php

namespace App\Models\Popup;

use App\Modes\Popup\PopupDlgsLang;
use App\Modes\Popup\PopupDlgsViews;
use Illuminate\Database\Eloquent\Model;

class PopupDlgs extends Model
{
    protected $table = 'popup_dlgs';

    protected $fillable = [
        'id', 'dtime', 'end_date',
        'first_page', 'urlgo',
    ];

    public $timestamps = false;

    public function popupDlgsLang()
    {
        return $this->hasOne(PopupDlgsLang::class, 'item_id', 'id');
    }

    public function popupDlgsViews()
    {
        return $this->hasMany(PopupDlgsViews::class, 'item_id', 'id');
    }
}
