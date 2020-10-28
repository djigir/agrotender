<?php

namespace App\Models\Comp;

use App\Models\ADV\AdvTorgPost;
use App\Models\Regions\Regions;
use App\Models\Torg\TorgBuyer;
use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersPlaces;
use App\Models\Traders\TradersPorts2buyer;
use App\Models\Traders\TradersPrices;
use App\Models\Traders\TradersPricesArc;
use App\Models\Traders\TradersContactsRegions;
use App\Models\Traders\TradersProducts2buyer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
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
    protected $table = 'comp_items';

    protected $appends = ['activities', 'purchases', 'sales', 'services', 'date'];

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

    /* Mutations */


    /* Accessor */
    public function getActivitiesAttribute()
    {
        $temp = [];
        $activities = CompTopicItem::where('item_id', $this->id)
            ->join('comp_topic', 'comp_item2topic.topic_id', '=', 'comp_topic.id')
            ->select('comp_topic.title')
            ->get();
        foreach ($activities as $index => $activity){
          array_push($temp, $activity->title);
        }

        $activities = implode(',', $temp);

        return $activities;
    }

    public function getPurchasesAttribute()
    {
        return AdvTorgPost::where([['active', 1], ['archive', 0], ['moderated', 1], ['type_id', 1], ['author_id', '=', $this->author_id]])
            ->get()
            ->count();
    }


    public function getSalesAttribute()
    {
        return AdvTorgPost::where([['active', 1], ['archive', 0], ['moderated', 1], ['type_id', 2], ['author_id', '=', $this->author_id]])
            ->get()
            ->count();
    }


    public function getServicesAttribute()
    {
        return AdvTorgPost::where([['active', 1], ['archive', 0], ['moderated', 1], ['type_id', 3], ['author_id', '=', $this->author_id]])
            ->get()
            ->count();
    }

    public function getDateAttribute()
    {

        if($this->add_date===null){
            return '';
        }
        return $this->add_date->endOfYear()->diffForHumans(Carbon::now(),true);
    }


    /* Relations */
    public function torg_buyer()
    {
        return $this->hasMany(TorgBuyer::class, 'author_id');
    }

    public function traders_culture()
    {
        return $this->hasMany(TradersPrices::class, 'buyer_id', 'author_id');
    }

    public function traders_places()
    {
        return $this->hasOne(TradersPlaces::class, 'id');
    }

    public function traders_prices()
    {
        return $this->hasMany(TradersPrices::class, 'buyer_id', 'author_id');
    }

    public function comp_items_rubrics()
    {
        return $this->hasMany(CompTopicItem::class, 'item_id', 'id');
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
