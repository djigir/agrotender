<?php

namespace App\Models\Comp;

use App\Models\ADV\AdvTorgPost;
use App\Models\Regions\Regions;
use App\Models\Torg\TorgBuyer;
use App\Models\Traders\TraderFeed;
use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersPlaces;
use App\Models\Traders\TradersPorts2buyer;
use App\Models\Traders\TradersPrices;
use App\Models\Traders\TradersPricesArc;
use App\Models\Traders\TradersContactsRegions;
use App\Models\Traders\TradersProducts2buyer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Jenssegers\Date\Date;


/**
 * Class CompItems
 * @package App\Models\Comp
 * @property integer $id;
 * @property integer $topic_id;
 * @property integer $obl_id;
 * @property integer $ray_id;
 * @property integer $type_id;
 * @property integer $author_id;
 * @property integer $rate;
 * @property integer $logo_file_w;
 * @property integer $logo_file_h;
 * @property integer $visible;
 * @property string $author;
 * @property string $city;
 * @property string addr;
 * @property string $zipcode;
 * @property string $phone;
 * @property string $phone2;
 * @property string $phone3;
 * @property string $email;
 * @property string $www;
 * @property string $title;
 * @property string $logo_file;
 * @property string $head_file;
 * @property string $head_file_src;
 * @property string $content;
 * @property string $short;
 * @property string $contacts;
 * @property string $title_full;
 * @property integer $trader_premium;
 * @property integer $trader_price_avail;
 * @property integer $trader_price_transpon;
 * @property string $trader_old_url;
 * @property integer $trader_sort;
 * @property integer $trader_pricecmp_transpon;
 * @property integer $msngr_mail_notify;
 * @property integer $site_pack_id;
 * @property integer $trader_price_sell_visible;
 * @property integer $trader_price_sell_transpon;
 * @property integer $trader_price_sell_avail;
 * @property integer $trader_sort_sell;
 * @property integer $trader_premium_sell;
 * @property integer $trader_price_forward_visible;
 * @property integer $trader_price_forward_avail;
 * @property integer $trader_sort_forward;
 * @property integer $trader_premium_forward;
 * @property Collection $traders_prices_traders;
 *
 * @property Carbon $trader_price_dtupdt;
 * @property Carbon $trader_price_sell_dtupdt;
 * @property Carbon $rate_admin1;
 * @property Carbon $rate_admin2;
 * @property Carbon $rate_formula;
 * @property Carbon $add_date;
 *
 */
class CompItems extends Model
{
    const PURCHASES_TYPE_ID = 1;
    const SALES_TYPE_ID = 2;
    const SERVICES_TYPE_ID = 3;


    protected $table = 'comp_items';

    protected $appends = ['date', 'date_price', 'activities_text', 'culture_prices','places'];

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

    protected $dates = ['add_date','culture_prices'];

    public function activities()
    {
        return $this->belongsToMany(CompTopic::class, 'comp_item2topic',
            'item_id', 'topic_id', 'id');
    }

    /* Accessor */
    public function getCulturePricesAttribute()
    {
        if (!$this->relationLoaded('traders_prices_traders')) {
            return [];
        }

        return $this->traders_prices_traders->unique('cult_id');
    }
    public function getPlacesAttribute()
    {
        if (!$this->relationLoaded('traders_places')) {
            return [];
        }


        return $this->traders_places->unique('id');
    }

    public function getActivitiesTextAttribute()
    {
        $activities = $this->activities->pluck('title');

        return trim(implode(',', $activities->toArray()));
    }


    public function purchases()
    {
        return $this->hasMany(AdvTorgPost::class, 'author_id', 'author_id')
            ->where([
                    'active' => 1,
                    'archive' => 0,
                    'moderated' => 1,
                    'type_id' => self::PURCHASES_TYPE_ID
                ]
            );
    }

    public function sales()
    {
        return $this->hasMany(AdvTorgPost::class, 'author_id', 'author_id')
            ->where([
                    'active' => 1,
                    'archive' => 0,
                    'moderated' => 1,
                    'type_id' => self::SALES_TYPE_ID
                ]
            );
    }

    public function services()
    {
        return $this->hasMany(AdvTorgPost::class, 'author_id', 'author_id')
            ->where([
                    'active' => 1,
                    'archive' => 0,
                    'moderated' => 1,
                    'type_id' => self::SERVICES_TYPE_ID
                ]
            );
    }


    public function getDateAttribute()
    {
        if ($this->add_date === null) {
            return '';
        }

        return $this->add_date->endOfYear()->diffForHumans(Carbon::now(), true);
    }

    public function getDatePriceAttribute()
    {
        return Date::parse($this->add_date);
    }

    /* Relations */
    public function torg_buyer()
    {
        return $this->hasMany(TorgBuyer::class, 'author_id');
    }

    public function traders_prices()
    {
        return $this->hasMany(TradersPrices::class, 'buyer_id', 'author_id')
            ->with('cultures');
    }


    public function traders_places()
    {
        return $this->belongsToMany(
            TradersPlaces::class, 'traders_prices',
            'buyer_id', 'place_id',
            'author_id', 'id')
            ->with('traders_ports')
            ->groupBy('place_id');
    }


    public function traders_prices_traders()
    {
        return $this->traders_prices()
            ->where('acttype', 0)
            ->groupBy('place_id');
    }


    public function comp_items_contact()
    {
        return $this->hasMany(CompItemsContact::class, 'comp_id');
    }

    public function comp_comment()
    {
        return $this->belongsTo(CompComment::class, 'author_id', 'author_id');
    }

    public function traders_contacts_regions()
    {
        return $this->hasMany(TradersContactsRegions::class, 'comp_id');
    }

    public function traders_products2_buyer()
    {
        return $this->hasMany(TradersProducts2buyer::class, 'buyer_id', 'author_id');
    }
}
