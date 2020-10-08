<?php

namespace App\Models\Comp;

use App\Models\Torg\TorgBuyer;
use App\Models\Traders\TradersPrices;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class CompItems
 * @package App\Models\Comp
 * @property Carbon add_date
 */
class CompItems extends Model
{
    protected $table = 'comp_items';

    protected $fillable = [
        'id', 'topic_id', 'obl_id', 'ray_id', 'type_id', 'author_id', 'rate', 'logo_file_w',
        'logo_file_h', 'visible', 'author', 'city', 'addr', 'zipcode', 'phone', 'phone2', 'phone3',
        'email', 'www', 'title', 'logo_file', 'head_file', 'head_file_src', 'content', 'short',
        'contacts', 'title_full', 'trader_premium', 'trader_price_avail', 'trader_price_transpon', 'trader_old_url',
        'trader_sort', 'trader_price_dtupdt', 'rate_admin1', 'rate_admin2',
        'rate_formula', 'trader_pricecmp_transpon', 'msngr_mail_notify', 'site_pack_id',
        'trader_price_sell_visible', 'trader_price_sell_transpon', 'trader_price_sell_dtupdt',
        'trader_price_sell_avail', 'trader_sort_sell', 'trader_premium_sell',
        'trader_price_forward_visible', 'trader_price_forward_avail', 'trader_sort_forward', 'trader_premium_forward'
    ];

    protected $dates = ['add_date'];
    protected $dateFormat = 'Y-m-d';

    /* Mutations */



    /* Relations */
    public function torg_buyer()
    {
        return $this->hasMany(TorgBuyer::class, 'author_id');
    }

    public function traders_prices()
    {
        return $this->hasOne(TradersPrices::class, '');
    }
}
