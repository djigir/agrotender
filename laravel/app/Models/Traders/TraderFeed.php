<?php

namespace App\Models\Traders;

use App\Models\Comp\CompItems;
use Illuminate\Database\Eloquent\Model;

class TraderFeed extends Model
{
    protected $table = 'traders_feed';

    const TYPE_SELL = 1;
    const TYPE_FORWARD = 0;
    const TYPES_TEXT = [
        self::TYPE_FORWARD => '_forward',
        self::TYPE_SELL => '_sell'
    ];


    protected $fillable = [
        'id',
        'rubric',
        'place',
        'change_price',
        'user',
        'change_date',
    ];

    /** INNER JOIN agt_traders_products_lang tpl
     * ON tpl.id = f.rubric*/
    public function langs()
    {
        return $this->belongsTo(Traders_Products_Lang::class, 'rubric');
    }

    /** INNER JOIN agt_traders_places tp
     * ON tp.id = f.place */
    public function places()
    {
        return $this->belongsTo(TradersPlaces::class, 'place');
    }

    /** INNER JOIN agt_comp_items ci
     * ON ci.author_id = f.user */
    public function items()
    {
        return $this->belongsTo(CompItems::class, 'author_id');
    }


}
