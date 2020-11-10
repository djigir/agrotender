<?php

namespace App\Services\Traders;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;
use App\Models\Traders\TraderFeed;
use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersProductGroups;
use App\Models\Traders\TradersProductGroupLanguage;
use App\Models\Traders\TradersProducts;
use Illuminate\Support\Carbon;

class TraderFeedService
{

    const TYPE_SELL = 1;
    const TYPE_FORWARD = 0;
    const TYPES_TEXT = [
        self::TYPE_FORWARD => '_forward',
        self::TYPE_SELL => '_sell'
    ];

    /**
     * @param int $type
     * @return mixed
     */
    public function getFeed($type = self::TYPE_FORWARD)
    {

        $type_text = self::TYPES_TEXT[$type];
//        $feed = $this->db->query("
//      select ci.title as company, ci.id as company_id, group_concat(distinct concat(tpl.name, ':', ifnull(f.change_price, 3)) order by f.change_price separator ', ') as rubrics, group_concat(distinct ifnull(f.change_price, 3) separator ', ') as change_price, date_format(f.change_date, '%H:%i') as change_time
//        from traders_feed f
//        inner join agt_traders_products_lang tpl
//          on tpl.id = f.rubric
//        inner join agt_traders_places tp
//          on tp.id = f.place
//        inner join agt_comp_items ci
//          on ci.author_id = f.user
//      where tp.acttype = $type && date(f.change_date) = curdate() && ci.trader_price{$sell}_avail = 1 && ci.trader_price{$sell}_visible = 1 && tp.type_id != 1 && ci.visible = 1
//      group by f.user
//      order by f.change_date desc");
        $price_field = 'trader_price'.$type_text;
        $traders = TraderFeed::join('agt_traders_products_lang','agt_traders_products_lang.id', '=', 'traders_feed.rubric')
            ->join('agt_traders_places','agt_traders_places.id', '=', 'traders_feed.place')
            ->join('agt_comp_items','agt_comp_items.author_id', '=', 'traders_feed.user')

            ->where('agt_traders_places.acttype', $type)
//            ->whereDate('traders_feed.change_date', Carbon::now())
            ->where('agt_comp_items.'.$price_field.'_avail', 1)
            ->where('agt_comp_items.'.$price_field.'_visible', 1)
            ->where('agt_traders_places.type_id','!=', 1)
            ->where('agt_comp_items.visible', 1)
            ->select('agt_traders_products_lang.id as tpl_id',
                'agt_traders_products_lang.item_id as tpl_item_id',
//                'agt_traders_products_lang.name as tpl_name',
                'traders_feed.id as tf_id',
                'traders_feed.rubric as tf_rubric',
                'traders_feed.place as tf_place',
                'traders_feed.change_price as tf_change_price',
                'traders_feed.user as tf_user',
                'traders_feed.change_date as tf_change_date',
                'agt_comp_items.id as comp_id',
                'agt_comp_items.topic_id as comp_topic_id',
                'agt_comp_items.type_id as comp_type_id',
                'agt_comp_items.author_id as comp_author_id',
                'agt_comp_items.visible as comp_visible',
                'agt_comp_items.add_date as comp_add_date',
                'agt_comp_items.title as comp_title'
            )
//            ->selectRaw('GROUP_CONCAT(DISTINCT traders_feed.change_price SEPARATOR ",") as tf_change_price')
            ->selectRaw('GROUP_CONCAT(DISTINCT agt_traders_products_lang.name SEPARATOR ",") as tpl_name')
            ->groupBy('traders_feed.user')
            ->orderBy('tf_change_date','DESC')
            ->get()
            ->toArray();

        $feed = $traders;
        foreach ($feed as $key => $value) {
            $feed[$key]['onchange'] = 'Подтвердил цены';
            $feed[$key]['onchange_class'] = 'confirmed';
            foreach (explode(', ', $value['tf_change_price']) as $key2 => $value2) {
                $explode = explode(':', $value2);
                if ($explode[0] == '2') {
                    $explode[0] = 4;
                }

                if ($explode[0] != '4') {
                    $feed[$key]['onchange'] = 'Изменил цены';
                    $feed[$key]['onchange_class'] = 'changed';

                }

                if (!isset($feed[$key]['r'][$explode[0]]['change'])) {
                    $feed[$key]['r'][$explode[0]]['change'] = [];
                }
//                dump($feed[$key]['tpl_name']);
                $all_culture = explode(',', $feed[$key]['tpl_name']);

                // беру только две культуры
                $culture = array_slice($all_culture, 0, 2);
                $feed[$key]['tpl_name'] = $culture;
                // array_push($feed[$key]['r'][$explode[0]]['change'], $explode[1]);
                $feed[$key]['r'][$explode[0]]['change'][] = $explode[0];
            }
        }
//        dd($feed);

        return $feed;
    }
}
