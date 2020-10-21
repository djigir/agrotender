<?php


namespace App\Services;


use App\Models\Comp\CompComment;
use App\Models\Comp\CompItems;
use App\Models\Comp\CompTgroups;
use App\Models\Comp\CompTopic;
use App\Models\Comp\CompTopicItem;
use App\Models\Regions\Regions;
use App\Models\Torg\TorgBuyer;
use App\Models\Traders\TradersPlaces;
use App\Models\Traders\TradersPorts;
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

        $rubrics = collect($rubrics)->groupBy('id')->toArray();

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

        foreach ($get_places as $index => $place) {
            if (!empty($place['traders_products']) and !empty($get_places[$index]['traders_products'][0]['traders_prices'])) {
                foreach ($get_places[$index]['traders_products'][0]['traders_prices'] as $index_pr => $prices){
                    if(!empty($prices['traders_places'])){
                        if(!empty($prices['traders_places'][0]['traders_ports'])){
                            array_push($places, array('portname' => $prices['traders_places'][0]['traders_ports'][0]['traders_ports_lang'][0]['portname'],
                                'place' => $prices['traders_places'][0]['place'],
                                'place_id' => $prices['traders_places'][0]['id']));
                        }else{
                            array_push($places, array('region' => $prices['traders_places'][0]['regions'][0]['name'],
                                'place' => $prices['traders_places'][0]['place'], 'place_id' => $prices['traders_places'][0]['id']));
                        }
                    }
                }
            }
        }


        $places = collect($places)->sortBy('place')->toArray();
        $places = array_values($places);
        $places = $this->baseService->new_unique($places, 'place');



        return $places;
    }


    public function getPriceRegionsPorts($id, $placeType)
    {
        $get_prices = $this->getTraderPricesRubrics($id, $placeType);
        $cultures = $this->getPortsRegionsCulture($id, $placeType);
        $assoc_array = [];

        foreach ($cultures as $index => $culture){
            $assoc_array[$culture['id']] = array('index' => $index, 'name' => $culture['name']);
        }

        $prices = $this->price_formation($get_prices);
        $prices = $this->sort_group($prices, $assoc_array);
        $prices['UAH'] = $this->parsing_array($prices, 'UAH');
        $prices['USD'] = $this->parsing_array($prices, 'USD');

        return $prices;
    }

    public function price_formation($sourceData)
    {
        $prices = [
            'UAH' => [],
            'USD' => []
        ];

        $currency = [
            0 => 'UAH',
            1 => 'USD',
        ];

        foreach ($sourceData as $index => $price) {
            if (!empty($price['traders_products']) and !empty($sourceData[$index]['traders_products'][0]['traders_prices'])) {
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
                            'culture' => $sourceData[$index]['traders_products'][0]['culture']['name'],
                            'culture_id' => $sourceData[$index]['traders_products'][0]['culture']['id']
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

        return $prices;
    }

    public function sort_group($prices, $assoc_array)
    {
        foreach ($prices as $index_currency => $currency){
            foreach ($currency as $index_place => $places){
                foreach ($places as $index => $price){
                    $prices[$index_currency][$index_place] = collect($prices[$index_currency][$index_place])->sortBy('culture')->toArray();
                    $prices[$index_currency][$index_place] = array_values($prices[$index_currency][$index_place]);
                }
                $prices[$index_currency][$index_place] = collect($prices[$index_currency][$index_place])->groupBy('culture_id')->toArray();
            }
        }

        foreach ($assoc_array as $index_assoc => $assoc){
            foreach ($prices as $index_cur => $currency){
                foreach ($currency as $index_place => $price){
                    $key = key(array_diff_key($assoc_array, $prices[$index_cur][$index_place]));
                    if(!isset($prices[$index_cur][$index_place][$key])) {
                        $prices[$index_cur][$index_place][$key] = [];
                        if(isset($assoc_array[$key])){
                            $prices[$index_cur][$index_place][$key] = array('culture' => $assoc_array[$key]['name']);
                        }
                    }
                }
            }
        }

        return $prices;
    }

    public function parsing_array($prices, $currency_type)
    {
        foreach ($prices[$currency_type] as $index_cur => $currency){
            foreach ($currency as $index => $price){
                if($index == '' or empty($prices[$currency_type][$index_cur][$index])){
                    unset($prices[$currency_type][$index_cur][$index]);
                }else{
                    if(isset($prices[$currency_type][$index_cur][$index][0]))
                        $prices[$currency_type][$index_cur][$index] = $prices[$currency_type][$index_cur][$index][0];
                }

            }
            $prices[$currency_type][$index_cur] = collect($prices[$currency_type][$index_cur])->sortBy('culture')->toArray();
            $prices[$currency_type][$index_cur] = array_values($prices[$currency_type][$index_cur]);
        }
        return $prices[$currency_type];
    }


    public function getTraderPricesRubrics($id, $placeType)
    {
        $type = 0;
        $company = CompItems::where('id', $id)->get()->first();
        $author_id = $company['author_id'];
        $pricesPorts = $this->getPlaces($author_id, 2, $type);
        $pricesRegions = $this->getPlaces($author_id, 0, $type);
        $prices = $this->getPrices($author_id, $type);

        $issetT1 = TradersPrices::select('id')->where([['buyer_id', $author_id], ['acttype', 0]])->count();
        $issetT2 = TradersPrices::select('id')->where([['buyer_id', $author_id], ['acttype', 1]])->count();

        if ($issetT2 > 0 && $company->trader_price_sell_avail == 1 && $company->trader_price_sell_visible == 1) {
            $type = 1;
        }

        if ($issetT1 > 0 && $company['trader_price_avail'] == 1 && $company['trader_price_visible'] == 1) {
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

    public function getReviews($id_company)
    {
        $reviews_with_comp = CompComment::where('item_id', $id_company)
            ->join('comp_items', 'comp_comment.author_id', '=', 'comp_items.author_id')
            ->select('comp_comment.id',
                'comp_comment.item_id',
                'comp_comment.author_id as comp_author_id',
                'comp_items.author_id',
                'comp_comment.author',
                'comp_items.title',
                'comp_comment.rate',
                'comp_items.logo_file',
                'comp_items.id as comp_id'
            )
            ->with('comp_comment_lang')
            ->orderBy('comp_comment.id', 'desc')
            ->get()
            ->toArray();

        if (empty($reviews_with_comp)) {
            $reviews_with_comp = CompComment::where('item_id', $id_company)
                ->with('comp_comment_lang')
                ->orderBy('comp_comment.id', 'desc')
                ->get()
                ->toArray();
        }
        return $reviews_with_comp;
    }


    public function getCompanies($region = null, $rubric = null, $search = null)
    {
        $obl_id = Regions::where('translit', $region)->value('id');

        $companies = CompItems::where([[function ($query) use($region, $obl_id){
            if($region != 'ukraine' and $region != null)
                $query->where('obl_id', '=', $obl_id);
        }]])->select('id', 'author_id', 'trader_premium', 'obl_id', 'logo_file',
            'short', 'add_date', 'visible', 'obl_id', 'title', 'trader_price_avail',
            'trader_price_visible', 'phone', 'phone2', 'phone3')
            ->orderBy('trader_premium', 'desc')
            ->orderBy('rate_formula', 'desc')
            ->paginate(self::PER_PAGE);

        if($region != null and $rubric != null){
            $companies =  CompItems::join('comp_item2topic', 'comp_items.id', '=', 'comp_item2topic.item_id')
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

        if($search != null){
            $companies = $this->searchCompanies($search);
        }

        return $companies;
    }
}
