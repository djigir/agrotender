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
    protected $baseService;

    public function __construct(BaseServices $baseService)
    {
        $this->baseService = $baseService;
    }

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

    public function getPortsRegionsCulture($id, $placeType)
    {
        $get_culture = $this->getTraderPricesRubrics($id, $placeType);
        $culture = [];

        foreach ($get_culture as $index => $cult) {
            if (!empty($cult['traders_products']) and !empty($get_culture[$index]['traders_products'][0]['traders_prices'])) {
                array_push($culture, $get_culture[$index]['traders_products'][0]['culture']);
            }
        }

        $culture = collect($culture)->sortBy('name')->toArray();
        $culture = array_values($culture);

        return $culture;
    }


    public function getPlacePortsRegions($id, $placeType)
    {
        $get_places = $this->getTraderPricesRubrics($id, $placeType);
        $places = [];
        $culture = $this->getPortsRegionsCulture($id, $placeType);

        foreach ($get_places as $index => $place) {
            if (!empty($place['traders_products']) and !empty($get_places[$index]['traders_products'][0]['traders_prices'])) {
                foreach ($get_places[$index]['traders_products'][0]['traders_prices'] as $index_pr => $prices){
                    if(!empty($prices['traders_places'])){
                        if(!empty($prices['traders_places'][0]['traders_ports'])){
                            array_push($places, array('portname' => $prices['traders_places'][0]['traders_ports'][0]['traders_ports_lang'][0]['portname'],
                                'place' => $prices['traders_places'][0]['place'], 'place_id' => $prices['traders_places'][0]['id'],
                                'culture' => $culture));
                        }else{
                            array_push($places, array('region' => $prices['traders_places'][0]['regions'][0]['name'],
                                'place' => $prices['traders_places'][0]['place'], 'place_id' => $prices['traders_places'][0]['id'],
                                'culture' => $culture));
                        }
                    }
                }
            }
        }


        $places = collect($places)->sortBy('place')->toArray();
        $places = array_values($places);
        $places = $this->baseService->new_unique($places, 'place');
        //dd($places);
        return $places;
    }


    public function getPriceRegionsPorts($id, $placeType)
    {
        $get_prices = $this->getTraderPricesRubrics($id, $placeType);
        $currency = [
            0 => 'UAH',
            1 => 'USD',
        ];

        $prices = [
            'UAH' => [],
            'USD' => []
        ];

        foreach ($get_prices as $index => $price) {
            if (!empty($price['traders_products']) and !empty($get_prices[$index]['traders_products'][0]['traders_prices'])) {
                foreach ($price['traders_products'][0]['traders_prices'] as $index_price => $price_product) {
                    if (!empty($price_product['traders_places'])) {
                        array_push($prices[$currency[$price_product['curtype']]], array(
                            'place_id' => $price_product['place_id'],
                            'costval' => $price_product['costval'],
                            'costval_old' => $price_product['costval_old'],
                            'add_date' => $price_product['add_date'],
                            'comment' => $price_product['comment'],
                            'traders_places' => $price_product['traders_places'],
                            'curtype' => $price_product['curtype'],
                            'culture' => $get_prices[$index]['traders_products'][0]['culture']['name'],
                            'culture_id' => $get_prices[$index]['traders_products'][0]['culture']['id']
                        ));
                    }
                }
            }
        }


        if (!empty($prices['UAH'])){
            $prices['UAH'] = collect($prices['UAH'])->groupBy('place_id')->toArray();
        }

        if (!empty($prices['USD'])){
            $prices['USD'] = collect($prices['USD'])->groupBy('place_id')->toArray();
        }


        foreach ($prices as $index_currency => $currency){
            foreach ($currency as $index_prices => $prices_pr){
                foreach ($prices_pr as $index_price => $price){
                    if(empty($price['traders_places'])){
                        unset($prices[$index_currency][$index_prices][$index_price]);
                        $prices[$index_currency][$index_prices] = array_values($prices[$index_currency][$index_prices]);
                    }else{
                        $prices[$index_currency][$index_prices] = collect($prices[$index_currency][$index_prices])->sortBy('culture')->toArray();
                        $prices[$index_currency][$index_prices] = array_values($prices[$index_currency][$index_prices]);
                    }
                }
//                $prices[$index_currency][$index_prices] = collect($prices[$index_currency][$index_prices])
//                    ->groupBy('culture')
//                    ->toArray();

                if(empty($prices[$index_currency][$index_prices])){
                    unset($prices[$index_currency][$index_prices]);
                }
            }
        }

//        foreach ($prices['UAH'] as $index => $price){
//            foreach($price as $index_pr => $pr){
//                $prices['UAH'][$index][$index_pr] = $prices['UAH'][$index][$index_pr][0];
//            }
//        }
//
//        foreach ($prices['USD'] as $index => $price){
//            foreach($price as $index_pr => $pr){
//                $prices['USD'][$index][$index_pr] = $prices['USD'][$index][$index_pr][0];
//            }
//        }
        //dd($prices);
        return $prices;
    }

    public function getTraderRegionsPricesRubrics($id, $placeType)
    {
        $trader_regions = $this->getTraderPricesRubrics($id, $placeType);
        $region_place = [];

        foreach ($trader_regions as $index => $port){
            if(!empty($port['traders_products'])){
                $trader_regions[$index]['traders_products'] = $trader_regions[$index]['traders_products'][0];
                $trader_regions[$index]['culture'] = $trader_regions[$index]['traders_products']['culture'];
                unset( $trader_regions[$index]['traders_products']['culture']);

                if(!empty($trader_regions[$index]['traders_products']['traders_prices'])){
                    foreach ($trader_regions[$index]['traders_products']['traders_prices'] as $index_pr => $prices){
                        if(empty($prices['traders_places'])){
                            unset($trader_regions[$index]['traders_products']['traders_prices'][$index_pr]);
                        }else{
                            $trader_regions[$index]['traders_products']['traders_prices'][$index_pr]['traders_places'] = $trader_regions[$index]['traders_products']['traders_prices'][$index_pr]['traders_places'][0];
                            $trader_regions[$index]['traders_products']['traders_prices'][$index_pr]['traders_places']['regions'] = $trader_regions[$index]['traders_products']['traders_prices'][$index_pr]['traders_places']['regions'][0];
                            array_push($region_place, $trader_regions[$index]['traders_products']['traders_prices'][$index_pr]);
                        }
                    }
                }else{
                    unset($trader_regions[$index]);
                }

            }else{
                unset($trader_regions[$index]);
            }

        }

        $trader_regions = collect($trader_regions)->sortBy('culture.name')->toArray();
        $region_place = collect($region_place)->sortBy('traders_places.regions.name')->toArray();
        $trader_regions = array_values($trader_regions);

        $region_place = $this->baseService->new_unique($region_place, 'place_id');

        foreach ($region_place as $index => $rp){
            $region_place[$index]['place'] = $region_place[$index]['traders_places']['place'];
            $region_place[$index]['region'] = $region_place[$index]['traders_places']['regions']['name'];
            unset($region_place[$index]['traders_places']);
        }

        $region_place = array_values($region_place);


        return ['trader_regions' => $trader_regions, 'region_place' => $region_place];
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
                        }else{
                            $trader_ports[$index]['traders_products']['traders_prices'][$index_pr]['traders_places'] = $trader_ports[$index]['traders_products']['traders_prices'][$index_pr]['traders_places'][0];
                            $trader_ports[$index]['traders_products']['traders_prices'][$index_pr]['traders_places']['traders_ports'] = $trader_ports[$index]['traders_products']['traders_prices'][$index_pr]['traders_places']['traders_ports'][0];
                            $trader_ports[$index]['traders_products']['traders_prices'][$index_pr]['traders_places']['traders_ports']['traders_ports_lang'] = $trader_ports[$index]['traders_products']['traders_prices'][$index_pr]['traders_places']['traders_ports']['traders_ports_lang'][0];

                            $trader_ports[$index]['traders_products']['traders_prices'][$index_pr]['traders_places']['traders_ports_lang'] = $trader_ports[$index]['traders_products']['traders_prices'][$index_pr]['traders_places']['traders_ports']['traders_ports_lang'];
                            unset($trader_ports[$index]['traders_products']['traders_prices'][$index_pr]['traders_places']['traders_ports']['traders_ports_lang']);

                            $trader_ports[$index]['traders_products']['traders_prices'][$index_pr]['traders_places']['regions'] = $trader_ports[$index]['traders_products']['traders_prices'][$index_pr]['traders_places']['regions'][0];
                        }
                    }
                    $trader_ports[$index]['traders_prices'] = $trader_ports[$index]['traders_products']['traders_prices'];
                    unset($trader_ports[$index]['traders_products']['traders_prices']);
                }else{
                    unset($trader_ports[$index]);
                }

            }else{
                unset($trader_ports[$index]);
            }

        }

        $trader_ports = collect($trader_ports)->sortBy('culture.name')->toArray();
        $trader_ports = array_values($trader_ports);

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
