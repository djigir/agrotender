<?php

namespace App\Services\Traders;


use App\Models\Traders\TraderFeed;
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
     * @param  int  $type
     * @return mixed
     */
    public function getFeed($type = self::TYPE_FORWARD)
    {
        return \Cache::remember('FEED', 1200, function () use ($type) {
            $type_text = self::TYPES_TEXT[$type];

            $price_field = 'trader_price'.$type_text;

            $feed = TraderFeed::join('traders_products_lang', 'traders_products_lang.id', '=',
                'traders_feed.rubric')
                ->join('traders_places', 'traders_places.id', '=', 'traders_feed.place')
                ->join('comp_items', 'comp_items.author_id', '=', 'traders_feed.user')
                ->where('traders_places.acttype', $type)
                ->whereDate('traders_feed.change_date', '=', Carbon::now())
                ->where('comp_items.'.$price_field.'_avail', 1)
                ->where('comp_items.'.$price_field.'_visible', 1)
                ->where('traders_places.type_id', '!=', 1)
                ->where('comp_items.visible', 1)
                ->select('traders_products_lang.id as tpl_id',
                    'traders_products_lang.item_id as tpl_item_id',
                    'traders_feed.id as tf_id',
                    'traders_feed.rubric as tf_rubric',
                    'traders_feed.place as tf_place',
                    'traders_feed.change_price as tf_change_price',
                    'traders_feed.user as tf_user',
                    \DB::raw('DATE_FORMAT(agt_traders_feed.change_date, "%H:%i") as tf_change_date'),
                    'comp_items.id as comp_id',
                    'comp_items.topic_id as comp_topic_id',
                    'comp_items.type_id as comp_type_id',
                    'comp_items.author_id as comp_author_id',
                    'comp_items.visible as comp_visible',
                    'comp_items.add_date as comp_add_date',
                    'comp_items.title as comp_title'
                )
                ->selectRaw('GROUP_CONCAT(DISTINCT agt_traders_products_lang.name SEPARATOR ",") as tpl_name')
                ->groupBy('traders_feed.user')
                ->orderBy('tf_change_date', 'desc')
                ->get()->toArray();

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

                    $all_culture = explode(',', $feed[$key]['tpl_name']);

                    $culture = array_slice($all_culture, 0, 2);
                    $feed[$key]['tpl_name'] = $culture;

                    $feed[$key]['r'][$explode[0]]['change'][] = $explode[0];
                }
            }
            return $feed;
        });
    }
}
