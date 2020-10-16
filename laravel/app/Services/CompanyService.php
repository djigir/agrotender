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
        $places = TradersPlaces::where([['acttype', $type], ['type_id', $placeType], ['buyer_id', $author_id]])
            ->with('traders_ports', 'regions')
            ->with('traders_ports.traders_ports_lang')
            ->orderBy('place', 'asc')
            ->orderBy('obl_id', 'asc')
            ->get();

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


    public function getTraderRegionsPricesRubrics($id, $placeType)
    {
        $trader_regions = $this->getTraderPricesRubrics($id, $placeType);

        foreach ($trader_regions as $index => $port){
            if(!empty($port['traders_products'])){
                $trader_regions[$index]['traders_products'] = $trader_regions[$index]['traders_products'][0];
                $trader_regions[$index]['culture'] = $trader_regions[$index]['traders_products']['culture'];
                unset( $trader_regions[$index]['traders_products']['culture']);

                if(!empty($trader_regions[$index]['traders_products']['traders_prices'])){
                    foreach ($trader_regions[$index]['traders_products']['traders_prices'] as $index_pr => $prices){
                        if(empty($prices['traders_places'])){
                            unset($trader_regions[$index]['traders_products']['traders_prices'][$index_pr]);
                        }
                    }
                }else{
                    unset($trader_regions[$index]);
                }

            }else{
                unset($trader_regions[$index]);
            }

        }
        $trader_regions = collect($trader_regions)->sortBy('culture.name');

        return $trader_regions;
    }


    public function getTraderPortsPricesRubrics($id, $placeType)
    {
        $trader_ports = $this->getTraderPricesRubrics($id, $placeType);

        foreach ($trader_ports as $index => $port){
            if(!empty($port['traders_products'])){
                $trader_ports[$index]['traders_products'] = $trader_ports[$index]['traders_products'][0];
                $trader_ports[$index]['culture'] = $trader_ports[$index]['traders_products']['culture'];
                unset( $trader_ports[$index]['traders_products']['culture']);

                if(!empty($trader_ports[$index]['traders_products']['traders_prices'])){
                    foreach ($trader_ports[$index]['traders_products']['traders_prices'] as $index_pr => $prices){
                        if(empty($prices['traders_places'])){
                            unset($trader_ports[$index]['traders_products']['traders_prices'][$index_pr]);
                        }
                    }
                }else{
                    unset($trader_ports[$index]);
                }

            }else{
                unset($trader_ports[$index]);
            }

        }
        $trader_ports = collect($trader_ports)->sortBy('culture.name');

        //dd($trader_ports->toArray());

        return $trader_ports;
    }


    public function getTraderPricesRubrics($id, $placeType)
    {
        $type = 0;
        $company = CompItems::where('id', $id)->get()->first();
        $author_id = $company->author_id;
        $pricesPorts = $this->getPlaces($author_id, 2, $type);
        $pricesRegions = $this->getPlaces($author_id, 0, $type);
        $prices = $this->getPrices($author_id, $type);

        $issetT1 = TradersPrices::select('id')->where([['buyer_id', $author_id], ['acttype', 0]])->count();
        $issetT2 = TradersPrices::select('id')->where([['buyer_id', $author_id], ['acttype', 1]])->count();

        if ($issetT2 > 0 && $company->trader_price_sell_avail == 1 && $company->trader_price_sell_visible == 1) {
            $type = 1;
        }

        if ($issetT1 > 0 && $company->trader_price_avail == 1 && $company->trader_price_visible == 1) {
            $type = 0;
        }

        $rubrics = TradersProducts2buyer::where([['buyer_id', $author_id], ['acttype', $type], ['type_id', $placeType]])
            ->with(['traders_products' => function($query) use($type, $author_id, $placeType){
                $query->with(['traders_prices' => function($query) use($type, $author_id, $placeType) {
                    $query->where([['buyer_id', $author_id], ['acttype', $type]])
                        ->with(['traders_places' => function($query) use($type, $placeType, $author_id){
                                $query->where([['acttype', $type], ['type_id', $placeType], ['buyer_id', $author_id]])
                                    ->with('traders_ports', 'regions')->with('traders_ports.traders_ports_lang');
                    }]);
                }]);
            }])
            ->get()->toArray();

        //$rubrics = $this->change_array($rubrics);


        return $rubrics;
    }
    public function change_array($rubrics)
    {
        foreach ($rubrics as $index => $rubric){

            if(!empty($rubrics[$index]['traders_products'])){
                $rubrics[$index]['traders_products'] = $rubrics[$index]['traders_products'][0];
                $rubrics[$index]['culture'] = $rubrics[$index]['traders_products']['culture'];
                $rubrics[$index]['traders_prices'] = $rubrics[$index]['traders_products']['traders_prices'];
            }

            unset($rubrics[$index]['traders_products']['culture']);
            unset($rubrics[$index]['traders_products']['traders_prices']);

            if(isset($rubrics[$index]["traders_prices"])){
                foreach ($rubrics[$index]["traders_prices"] as $inxex_r => $rubric_price){
                    if(!empty($rubric_price['traders_places'])){
                        foreach ($rubric_price['traders_places'] as $index_p => $places){
                            $rubrics[$index]['traders_places'] = array_unique($rubrics[$index]["traders_prices"][$inxex_r]['traders_places']);
                            $rubrics[$index]['traders_places'][$index_p]['regions'] = $rubrics[$index]['traders_places'][$index_p]['regions'][0];
    //                        $rubrics[$index]["traders_prices"][$inxex_r]['traders_places'][$index_p]['regions'] = $rubrics[$index]["traders_prices"][$inxex_r]['traders_places'][$index_p]['regions'][0];
                        }
                    }else{
                        unset($rubrics[$index]["traders_prices"][$inxex_r]);
                    }
                }
            }
        }

        $rubrics = collect($rubrics)->sortBy('culture.name');

        return $rubrics;
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
