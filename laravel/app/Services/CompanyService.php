<?php


namespace App\Services;


use App\Models\Comp\CompItems;
use App\Models\Comp\CompTgroups;
use App\Models\Comp\CompTopic;
use App\Models\Comp\CompTopicItem;
use App\Models\Regions\Regions;
use App\Models\Torg\TorgBuyer;
use App\Models\Traders\TradersPlaces;
use App\Models\Traders\TradersPrices;
use App\Models\Traders\TradersProducts2buyer;
use Symfony\Component\HttpFoundation\Request;

class CompanyService
{
    const PER_PAGE = 10;


    public function getContacts($author_id, $departments_type)
    {
        $departament_name = [];
        $creator = [];

        $arr = [
            1 => 'Отдел закупок',
            2 => 'Отдел продаж',
            3 => 'Отдел услуг',
        ];

        foreach ($departments_type as $index => $value) {
            $departament_name [] = $arr[$value['type_id']];
        }
        $departament_name = array_unique($departament_name);

        $creators = TorgBuyer::where('id', $author_id)->get()->toArray();


        return ['creators' => $creators[0], 'departament_name' => $departament_name];
    }

    public function getRubricsGroup() {
        $rubrics = CompTgroups::with(['comp_topic' => function ($query) {
            $query->select('menu_group_id', 'title', 'id')->where('parent_id', 0);
        }])
            ->orderBy('sort_num')
            ->orderBy('title')
            ->get();

        $rubrics = collect($rubrics)->groupBy('title')->toArray();

        foreach ($rubrics as $index => $rubric){
            $rubrics[$index] = $rubric[0];
        }

        return $rubrics;
    }

    public function getCompanyTraderPrices($user, $places, $rubrics, $type) {
        $pricesArr = $places;
//        $date_expired_diff = date('Y-m-d', strtotime($this->countDaysExpiredDiff));
//        $prices = $this->getPrices($user, $type);
//        foreach ($places as $pKey => $place) {
//            $is_avail = false;
//            $tmp_rubrics = $rubrics;
//            foreach ($rubrics as $rKey => $rubric) {
//                $tmp_prices = $prices[$place['id']][$rubric['id']] ?? [];
//                foreach ($tmp_prices as $price) {
//                    $is_avail = true;
//                    // diff отображать не позже 7 дней после сохранения цен
//                    $diff = $date_expired_diff <= $price['change_date'] ? round($price['costval'] - $price['costval_old']) : 0;
//                    $tmp_rubrics[$rKey]['price'][$price['curtype']] = [
//                        'cost'         => ($price['costval'] != null) ? round($price['costval']) : null,
//                        'comment'      => $price['comment'],
//                        'price_diff'   => $diff,
//                        'change_price' => !$price['costval_old'] || !$diff ? '' : ($diff < 0 ? 'down' : 'up'),
//                        'currency'     => $price['curtype']
//                    ];
//                }
//            }
//            if ( $is_avail ) {
//                $pricesArr[$pKey]['rubrics'] = $tmp_rubrics;
//            }
//        }
        return $pricesArr;
    }
    public function getPlaces($author_id, $placeType, $type) {
        //\DB::enableQueryLog();
        $places = TradersPlaces::where([['acttype', $type], ['type_id', $placeType], ['buyer_id', $author_id]])
            ->with('traders_ports', 'regions')
            ->with('traders_ports.traders_ports_lang')
            ->orderBy('place', 'asc')
            ->orderBy('obl_id', 'asc')
            ->get();
        //$places = collect($places)->sortBy('traders_ports.traders_ports_lang.portname');
        //dd(\DB::getQueryLog());
//        $places = $this->db->query("
//      select tp.*, tpl.portname, r.name as region, r.id as region_id
//        from agt_traders_places tp
//        left join agt_traders_ports tpo
//          on tpo.id = tp.port_id
//        left join agt_traders_ports_lang tpl
//          on tpl.port_id = tpo.id
//        left join regions r
//          on r.id = tp.obl_id
//      where tp.buyer_id = $user and tp.acttype = $type and tp.type_id = $placeType
//      order by tp.obl_id asc, tpl.portname asc");

        return $places;
    }

    public function getPrices($author_id, $type) {
        $prices = TradersPrices::where([['buyer_id', $author_id], ['acttype', $type]])->get();
        $prices = collect($prices)->groupBy('place_id');

        foreach ($prices as $index => $price){
            $prices[$index] = $prices[$index]->groupBy('cult_id');
            foreach ($prices[$index] as $index_cult => $cult){
                $prices[$index][$index_cult] = $prices[$index][$index_cult][0];
            }
        }

        return $prices;
    }
    public function getTraderPricesRubrics($id, $placeType)
    {
        $type= 0;
        $placeType = 0;
        $company = CompItems::where('id', $id)->get()->first();
        $author_id = $company->author_id;
        $pricesPorts = $this->getPlaces($author_id, 2, $type);
        $pricesRegions = $this->getPlaces($author_id, 0, $type);

        $pricesPorts = $this->TransformArray($pricesPorts);
        $pricesRegions = $this->TransformArray($pricesRegions);


        $prices = $this->getPrices($author_id, $type);

        $issetT1 = TradersPrices::select('id')->where([['buyer_id', $author_id], ['acttype', 0]])->count();
        $issetT2 = TradersPrices::select('id')->where([['buyer_id', $author_id], ['acttype', 1]])->count();

        if ($issetT2 > 0 && $company->trader_price_sell_avail == 1 && $company->trader_price_sell_visible == 1) {
            $type = 1;
            $trader = 1;
        }

        if ($issetT1 > 0 && $company->trader_price_avail == 1 && $company->trader_price_visible == 1) {
            $type = 0;
            $trader = 1;
        }

        $rubrics = TradersProducts2buyer::where([['buyer_id', $author_id], ['acttype', 0], ['type_id', $placeType]])
            ->with(['traders_products' => function($query) use($type, $author_id){
                $query->with(['traders_prices' => function($query) use($type, $author_id)
                {
                    $query->where([['buyer_id', $author_id], ['acttype', $type]])->with('traders_places');
                }]);
            }])
            ->get()->toArray();
        //dd('$rubrics', $rubrics->toArray(), '$pricesPorts', $pricesPorts->toArray(), '$pricesRegions',$pricesRegions->toArray());
//        $rubrics = $this->db->query("
//      select distinct c2b.sort_ind, c2b.id as b2id, tp.*, tpl.name
//        from agt_traders_products2buyer c2b
//        inner join agt_traders_products tp on c2b.cult_id=tp.id
//        inner join agt_traders_products_lang tpl on tp.id=tpl.item_id
//        inner join agt_traders_prices atp on atp.cult_id = tp.id && atp.acttype = $type && atp.buyer_id = $user
//        inner join agt_traders_places pl on pl.id = atp.place_id && pl.buyer_id = c2b.buyer_id && pl.type_id = c2b.type_id
//      where c2b.buyer_id = $user and c2b.acttype = $type and c2b.type_id = $placeType
//      order by tpl.name asc");

        foreach ($rubrics as $index => $rubric){
            if(isset($rubrics[$index]['traders_products'][0])){
                $rubrics[$index]['traders_products'] = $rubrics[$index]['traders_products'][0];
            }

            if(empty($rubrics[$index]['traders_products']['traders_prices'])){
                unset($rubrics[$index]);
            }
        }

        $rubrics = collect($rubrics)->sortBy('traders_products.culture.name');

        return ['rubrics' => $rubrics, 'pricesPorts' => $pricesPorts, 'pricesRegions' => $pricesRegions];
    }
    public function TransformArray($array)
    {
        $array = $array->toArray();

        foreach($array as $index => $new_array){
            if(isset($array[$index]['traders_ports']) and isset($array[$index]['traders_ports'][0])){
                $array[$index]['traders_ports'] = $array[$index]['traders_ports'][0];
                $array[$index]['traders_ports']["traders_ports_lang"] = $array[$index]['traders_ports']["traders_ports_lang"][0];
            }

            $array[$index]['regions'] = $array[$index]['regions'][0];

        }
       $array = collect($array)->sortBy('regions.name');
        return $array;
    }


    public function searchCompanies($value){
        return CompItems::where('title', 'like', '%'.$value.'%')->orWhere('content', 'like', '%'.$value.'%')
            ->select('id', 'author_id', 'trader_premium', 'obl_id', 'logo_file',
                'short', 'add_date', 'visible', 'obl_id', 'title', 'trader_price_avail',
                'trader_price_visible', 'phone', 'phone2', 'phone3')
            ->paginate(self::PER_PAGE);

    }


    public function getCompanies($region = null, $rubric = null, $search = null)
    {
        $obl_id = Regions::where('translit', $region)->value('id');

        $companies = CompItems::
        where([[function ($query) use($region, $obl_id){
            if($region != 'ukraine' and $region != null)
                $query->where('obl_id', '=', $obl_id);
        }]])->select('id', 'author_id', 'trader_premium', 'obl_id', 'logo_file',
            'short', 'add_date', 'visible', 'obl_id', 'title', 'trader_price_avail',
            'trader_price_visible', 'phone', 'phone2', 'phone3')
            ->orderBy('trader_premium', 'desc')
            ->orderBy('rate_formula', 'desc')
            ->paginate(self::PER_PAGE);

        if($region != null and $rubric != null){
            $companies =  CompItems::
            join('comp_item2topic', 'comp_items.id', '=', 'comp_item2topic.item_id')
                ->where([['comp_item2topic.topic_id', $rubric], [function ($query) use($region, $obl_id){
                    if($region != 'ukraine' and $region != null)
                        $query->where('comp_items.obl_id', '=', $obl_id);
                }]])
                ->select('comp_items.id', 'comp_items.author_id', 'comp_items.trader_premium',
                    'comp_items.obl_id', 'comp_items.logo_file',
                    'comp_items.short', 'comp_items.add_date', 'comp_items.visible', 'comp_items.obl_id', 'comp_items.title', 'comp_items.trader_price_avail',
                    'comp_items.trader_price_visible', 'comp_items.phone', 'comp_items.phone2', 'comp_items.phone3'
                )
                ->orderBy('comp_items.trader_premium', 'desc')
                ->orderBy('comp_items.rate_formula', 'desc')
                ->paginate(self::PER_PAGE);
        }

        //dd($companies->toArray());

        if($search != null){
            $companies = $this->searchCompanies($search);
        }

        return $companies;
    }
}
