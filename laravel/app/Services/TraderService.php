<?php

namespace App\Services;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopic;
use App\Models\Traders\TradersProductGroups;
use App\Models\Traders\TradersProductGroupLanguage;
use App\Models\Traders\TradersProducts;



class TraderService
{

//$group_ids = array_unique(array_column($rubrics, 'group_id'));
// $rubrics = $traders->getForwardRubrics
//$price_type  = $forwardPriceType = 3;
//$typeInt = 0
//$region = $regions
//[array_keys(array_combine(array_keys($regions), array_column($regions, 'translit')),
// $this->data['region'] ?? null)[0] ?? null] ?? null;
//$regions = $traders->getRegions();
// ($typeInt, $price_type, $region['id'], $port['id'], $onlyPorts, $currency['id']);
//$onlyPorts = $this->data['port'] ?? null;
//$onlyPorts = ($onlyPorts == null) ? null : ($onlyPorts == 'all') ? 'yes' : $onlyPorts;
//$ports = $traders->getPorts();
// current port
// $port = $ports[
//array_keys(array_combine(array_keys($ports), array_column($ports, 'translit')),
// $this->data['port'] ?? null)[0] ?? null] ?? null;
//$ports = $traders->getPorts();
// $currencies = $traders->getCurrencies();
//$currency = $currencies[$this->request->get['currency'] ?? null] ?? null;
    public function getCurrencies() {
        $currencies  = [
            'uah' => [
                'id'   => 0,
                'name' => 'Гривна',
                'code' => 'uah'
            ],
            'usd' => [
                'id'   => 1,
                'name' => 'Доллар',
                'code' => 'usd'
            ]
        ];
        return $currencies;
    }

    public function getRegions($rubric = null, $sitemap = null) {
        $regions = [];
//        $regions = $this->db->query("
//      select *
//        from regions
//      group by id");
//        if ($sitemap != null) {
//            $total = 0;
//            foreach ($regions as $key => $value) {
//                $totalTraders = $this->getCountByRubric($rubric, 0, $value['id']);
//                $total = ($total + $totalTraders);
//                $regions[$key]['count'] = $totalTraders;
//            }
//            array_unshift($regions, ['id' => 0, 'name' => 'Украина', 'translit' => 'ukraine', 'count' => $total]);
//        }
        return $regions;
    }
    public function getPorts() {
        $ports = [];
//        $ports = $this->db->query("
//      select tp.id, tp.url as translit, tpl.portname as name, tpl.p_title as title, tpl.p_h1 as h1, tpl.p_descr
//        from agt_traders_ports tp
//        inner join agt_traders_ports_lang tpl
//          on tp.id = tpl.port_id
//      where tp.active = 1
//      order by tpl.portname asc");
        return $ports;
    }


    /**TODO временно**/
    //$rubrics   = $this->db->query("
//      select t.menu_group_id as group_id, t.title, count(i2t.id) as count, i2t.topic_id
//        from agt_comp_topic as t
//        left join agt_comp_item2topic i2t
//          on i2t.topic_id = t.id
//        ".($region != null ? "left join agt_comp_items i on i.id = i2t.item_id" : "")."
//      ".($region != null ? "where i.obl_id = $region" : "")."
//        group by t.id
//        order by t.menu_group_id, t.sort_num, t.title");
//return $rubrics;
    public function getForwardRubrics($type, $priceType, $region = null, $port = null, $onlyPorts = null, $currency = null) {
        $rubrics = [];

        //        $rubrics = $this->db->query("
//      select tp.id, tp.url as translit, tp.group_id, tpl.name, tpr.id as tprid
//        from agt_traders_products tp
//        inner join agt_traders_products_lang tpl
//          on tpl.item_id = tp.id
//        inner join agt_traders_prices tpr
//          on tpr.cult_id = tp.id
//        inner join agt_traders_places plc
//          on plc.id = tpr.place_id
//        inner join agt_comp_items ci
//          on ci.author_id = tpr.buyer_id
//        where tp.acttype = $type && plc.type_id != 1 &&
//          ci.trader_price_forward_visible = 1 && ci.trader_price_forward_avail = 1 && ci.visible = 1 &&
//          tpr.active = 1 && tpr.acttype = $priceType
//        group by tp.id
//        order by tpl.name asc");
//        // get traders count from rubric list
//        $counts = $this->getCountsForwardByRubric(array_column($rubrics, 'id'), $region, $port, $onlyPorts, $currency);
//        foreach ($rubrics as &$v) {
//            $v['count'] = $counts[$v['id']] ?? 0;
//        }
        return $rubrics;
    }
    public function getRubrics() {
        $type = 0;
        //\DB::enableQueryLog();
        $rubrics = TradersProducts::
            select('id', 'group_id')
//            ->with([
//                'traders_products_lang' => function($query)
//                {
//                    $query->select('id', 'item_id', 'name');
//                }
////                ,'traders_prices' => function($query)
////                {
////                    $query->where('active', 1)->with(['traders_places', 'compItems']);
////                },
//                ])
            ->with(['traders_product_groups_lang' => function($query){
                $query->select('item_id', 'name');
            }])
            ->where([['acttype', 0]])
            ->orderBy('group_id')
//          ->groupBy('group_id')
            ->get()
            ->toArray();

        $rubrics = collect($rubrics)->groupBy('traders_product_groups_lang.name')->toArray();
        dd($rubrics);
        //dd(\DB::getQueryLog());
/**
        from agt_traders_products tp
//        inner join agt_traders_products_lang tpl  on tpl.item_id = tp.id
//        inner join agt_traders_prices tpr         on tpr.cult_id = tp.id && tpr.active = 1
        inner join agt_traders_places plc         on plc.id = tpr.place_id
        inner join agt_comp_items ci              on ci.author_id = tpr.buyer_id

 **/
//        $sell = ($type == 0) ? '' : '_sell';
//        $rubrics = $this->db->query("
//      select tp.id, tp.url as translit, tp.group_id, tpl.name, tpr.id as tprid
//        from agt_traders_products tp
//        inner join agt_traders_products_lang tpl
//          on tpl.item_id = tp.id
//        inner join agt_traders_prices tpr
//          on tpr.cult_id = tp.id && tpr.active = 1
//        inner join agt_traders_places plc
//          on plc.id = tpr.place_id
//        inner join agt_comp_items ci
//          on ci.author_id = tpr.buyer_id
//        where tp.acttype = $type && plc.type_id != 1 && ci.trader_price{$sell}_visible = 1 && ci.trader_price{$sell}_avail = 1 && ci.visible = 1
//        group by tp.id
//        order by tpl.name asc");
//        /* foreach ($rubrics as $key => $rubric) {
//          $rubrics[$key]['count'] = $this->getCountByRubric($rubric['id'], $type, $region, $port, $onlyPorts, $currency);
//        } */
        return $rubrics;
    }

    public function getTradersByRubric() {
//       \DB::enableQueryLog();
        $traders_rubric = CompItems::
            join('traders_prices', 'traders_prices.buyer_id', '=', 'comp_items.author_id')
            ->join('traders_places', 'traders_places.id', '=', 'traders_prices.place_id')
            ->where([
                ['traders_prices.acttype', '=', 0],
//                ['traders_prices.cult_id', '=', 'traders_places.cult_id'],
                ['comp_items.trader_price_visible', '=', '1'],
                ['comp_items.trader_price_avail', '=', '1'],
                ['comp_items.visible', '=', '1'],

            ])
//            ->with(['traders_prices' => function($query) {
//                $query->with('traders_places');
//            }])
//            ->where([['trader_price_visible', 1], ['trader_price_avail', 1], ['visible', 1]])
            ->paginate(20)->toArray();
//        dd(\DB::getQueryLog());
//        $list = $this->db->query("
//      select distinct ci.id, ci.title
//        from agt_comp_items ci
//        inner join agt_traders_prices tp
//          on tp.buyer_id = ci.author_id && tp.acttype = '0'
//        inner join agt_traders_places tpl
//          on tpl.id = tp.place_id
//      where tp.cult_id = $rubric && ci.trader_price_visible = 1 && ci.trader_price_avail = 1 && ci.visible = 1");
//        $this->response->json(['code' => 1, 'list' => $list]);
        return $traders_rubric;
    }
    public function getRubricsGroup() {
        $groups = TradersProductGroups::where("acttype", 0)->get();
        $groups = collect($groups)->groupBy("groups.name")->toArray();

        foreach ($groups as $index => $group){
            $groups[$index] = $groups[$index][0];
           foreach ($groups[$index]["groups"]["traders_products"] as $id => $item){
              $groups[$index]["groups"]["traders_products"][$id] = array_merge($groups[$index]["groups"]["traders_products"][$id],
                  $groups[$index]["groups"]["traders_products"][$id]["culture" ]);
           }
        }

        return $groups;
    }

    public function new_unique($array, $key)
    {
        $temp_array = [];

        foreach ($array as $v) {
            if (!isset($temp_array[$v[$key]]))
                $temp_array[$v[$key]] = $v;
        }

        $array = array_values($temp_array);

        return $array;

    }

    public function DataForFilter()
    {
        return $this->getRubricsGroup();
    }
}
