<?php

namespace App\Modes\Popup;

use App\Models\Popup\PopupDlgs;
use Illuminate\Database\Eloquent\Model;

class PopupDlgsViews extends Model
{
    protected $table = 'popup_dlgs_views';
    protected $fillable = ['id', 'add_date', 'user_id', 'item_id'];
    public $timestamps = false;

    public function popupDlgs()
    {
        return $this->belongsTo(PopupDlgs::class, 'id', 'item_id');
    }
}
