<?php

namespace App\Services;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersProductGroups;
use App\Models\Traders\TradersProductGroupLanguage;
use App\Models\Traders\TradersProducts;


class TraderService
{
    protected $rubric = [];
    protected $region = [];

    public function getCurrencies()
    {
        $currencies = [
            'uah' => [
                'id' => 0,
                'name' => 'Гривна',
                'code' => 'uah'
            ],
            'usd' => [
                'id' => 1,
                'name' => 'Доллар',
                'code' => 'usd'
            ]
        ];
        return $currencies;
    }

    public function getRegions($rubric = null, $sitemap = null)
    {
        $regions = Regions::get();
        dd($regions);
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

    public function getPorts()
    {
        $ports = TradersPorts::select('id', 'url')->with(['traders_ports_lang' => function($query){
            $query->select('portname', 'p_title', 'p_h1', 'p_descr', 'port_id');
        }])
            ->where('active', 1)
//            ->orderBy('traders_ports_lang.portname')
            ->get()
            ->toArray();

        foreach ($ports as $index => $port){
            $ports[$index] = array_merge($port, $port['traders_ports_lang'][0]);
            unset($ports[$index]["traders_ports_lang"]);
        }
        $ports = collect($ports)->sortBy('portname');
        return $ports;

    }


    public function getForwardRubrics(
        $type,
        $priceType,
        $region = null,
        $port = null,
        $onlyPorts = null,
        $currency = null
    ) {
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

    public function getRubrics()
    {
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
            ->with([
                'traders_product_groups_lang' => function ($query) {
                    $query->select('item_id', 'name');
                }
            ])
            ->where([['acttype', 0]])
            ->orderBy('group_id')
//          ->groupBy('group_id')
            ->get()
            ->toArray();

        $rubrics = collect($rubrics)->groupBy('traders_product_groups_lang.name')->toArray();
        dd($rubrics);
        //dd(\DB::getQueryLog());

        return $rubrics;
    }



    public function getRubricsGroup()
    {
        $groups = TradersProductGroups::where("acttype", 0)->get();
        $groups = collect($groups)->groupBy("groups.name")->toArray();
        $groups = $this->transform_array($groups);

        return $groups;
    }


    public function transform_array($groups)
    {
        foreach ($groups as $index => $group) {
            $groups[$index] = $groups[$index][0];
            foreach ($groups[$index]["groups"]["traders_products"] as $id => $item) {
                $groups[$index]["groups"]["traders_products"][$id] = array_merge($groups[$index]["groups"]["traders_products"][$id],
                    $groups[$index]["groups"]["traders_products"][$id]["culture"]);
                unset($groups[$index]["groups"]["traders_products"][$id]["culture"]);
                $groups[$index]['group_culture'] = $groups[$index]["groups"]["traders_products"];
            }
            unset($groups[$index]["groups"]["traders_products"]);

        }

        return $groups;
    }


    public function new_unique($array, $key)
    {
        $temp_array = [];

        foreach ($array as $v) {
            if (!isset($temp_array[$v[$key]])) {
                $temp_array[$v[$key]] = $v;
            }
        }

        $array = array_values($temp_array);

        return $array;

    }
}
