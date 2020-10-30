<?php


namespace App\Services;


use App\Http\Controllers\CompanyController;
use App\Models\Comp\CompComment;
use App\Models\Comp\CompCommentLang;
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
use Carbon\Carbon;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class CompanyService
{
    const PER_PAGE = 10;
    protected $baseService;
    protected $prices;
    protected $rubrics;
    protected $companies;

    public function __construct(BaseServices $baseService)
    {
        $this->baseService = $baseService;
        $this->prices = null;
        $this->companies = null;
        $this->rubrics = null;
    }

    public function mobileFilter(\Illuminate\Http\Request $request)
    {
        $route_name = null;
        $route_params = null;

        if (!empty($request->get('region'))) {
            $route_name = 'company.region';
            $route_params = ['region' => $request->get('region')];
        }

        if (!empty($request->get('region')) && !empty($request->get('rubric'))) {

            $route_name = 'company.region_culture';
            $route_params = [
                'region' => $request->get('region'),
                'rubric_number' => $request->get('rubric')
            ];
        }

        if (!empty($request->get('query'))) {
            $route_name = 'company.filter';
            $route_params = ['query' => $request->get('query')];
        }

        return redirect()->route($route_name, $route_params);

    }

    public function getContacts($author_id, $departments_type)
    {
        $departament_name = [];

        $arr = [
            1 => 'Отдел закупок',
            2 => 'Отдел продаж',
            3 => 'Отдел услуг',
        ];

        foreach ($departments_type as $index => $value) {
            $departament_name [] = $arr[$value['type_id']];
        }
        $departament_name = array_unique($departament_name);

        $creators = TorgBuyer::where('id', $author_id)->get()->toArray()[0];


        return ['creators' => $creators, 'departament_name' => $departament_name];
    }


    /** Упрощенный метод получения Place -> буду юзать в будующем
     * @param $author_id
     * @param $placeType
     * @param $type
     * @return
     */
    public function getPlaces($author_id, $placeType, $type)
    {
        return TradersPlaces::where([['acttype', $type], ['type_id', $placeType], ['buyer_id', $author_id]])
            ->orderBy('place', 'asc')
            ->orderBy('obl_id', 'asc')
            ->select('obl_id', 'place', 'type_id', 'acttype', 'buyer_id', 'place', 'id', 'port_id')
            ->get()
            ->toArray();
    }



    public function getPortsRegionsCulture($id, $placeType)
    {
        $get_culture = $this->getTraderPricesRubrics($id, $placeType);
        $culture = [];

        foreach ($get_culture as $index => $cult) {
            if (empty($cult['traders_products']) || empty($get_culture[$index]['traders_products'][0]['traders_prices'])) {
                continue;
            }

            array_push($culture, $get_culture[$index]['traders_products'][0]['culture']);
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
            if (empty($place['traders_products']) || empty($get_places[$index]['traders_products'][0]['traders_prices'])) {
                continue;
            }
            foreach ($get_places[$index]['traders_products'][0]['traders_prices'] as $index_pr => $prices) {
                if (empty($prices['traders_places'])) {
                    continue;
                }
                if (!empty($prices['traders_places'][0]['traders_ports'])) {
                    array_push($places, array(
                        'portname' => $prices['traders_places'][0]['traders_ports'][0]['traders_ports_lang'][0]['portname'],
                        'place' => $prices['traders_places'][0]['place'],
                        'place_id' => $prices['traders_places'][0]['id']
                    ));
                    continue;
                }
                array_push($places, array(
                    'region' => $prices['traders_places'][0]['regions'][0]['name'],
                    'place' => $prices['traders_places'][0]['place'],
                    'place_id' => $prices['traders_places'][0]['id']
                ));
            }
        }


        $places = collect($places)->sortBy($placeType == 0 ? 'place' : 'portname')->toArray();
        $places = array_values($places);
        $places = $this->baseService->new_unique($places, 'place');


        return $places;
    }


    public function getPriceRegionsPorts($id, $placeType)
    {
        $get_prices = $this->getTraderPricesRubrics($id, $placeType);
        $cultures = $this->getPortsRegionsCulture($id, $placeType);
        $assoc_array = [];

        foreach ($cultures as $index => $culture) {
            $assoc_array[$culture['id']] = ['index' => $index, 'name' => $culture];
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
            if (empty($price['traders_products']) &&  empty($sourceData[$index]['traders_products'][0]['traders_prices'])) {
                continue;
            }
            foreach ($price['traders_products'][0]['traders_prices'] as $index_price => $price_product) {
                if (empty($price_product['traders_places'])) {
                    continue;
                }
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


        if (!empty($prices['UAH'])) {
            $prices['UAH'] = collect($prices['UAH'])->groupBy('place_id')->toArray();
        }

        if (!empty($prices['USD'])) {
            $prices['USD'] = collect($prices['USD'])->groupBy('place_id')->toArray();
        }

        return $prices;
    }

    public function sort_group($prices, $assoc_array)
    {
        foreach ($prices as $index_currency => $currency) {
            foreach ($currency as $index_place => $places) {
                foreach ($places as $index => $price) {
                    $prices[$index_currency][$index_place] = collect($prices[$index_currency][$index_place])->sortBy('culture')->toArray();
                    $prices[$index_currency][$index_place] = array_values($prices[$index_currency][$index_place]);
                }
                $prices[$index_currency][$index_place] = collect($prices[$index_currency][$index_place])->groupBy('culture_id')->toArray();
            }
        }

        foreach ($assoc_array as $index_assoc => $assoc) {
            foreach ($prices as $index_cur => $currency) {
                foreach ($currency as $index_place => $price) {
                    $key = key(array_diff_key($assoc_array, $prices[$index_cur][$index_place]));
                    if (!isset($prices[$index_cur][$index_place][$key])) {
                        $prices[$index_cur][$index_place][$key] = [];
                        if (isset($assoc_array[$key])) {
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
        foreach ($prices[$currency_type] as $index_cur => $currency) {
            foreach ($currency as $index => $price) {
                if ($index == '' or empty($prices[$currency_type][$index_cur][$index])) {
                    unset($prices[$currency_type][$index_cur][$index]);
                    continue;
                }
                if (isset($prices[$currency_type][$index_cur][$index][0])) {
                    $prices[$currency_type][$index_cur][$index] = $prices[$currency_type][$index_cur][$index][0];
                }
            }
            $prices[$currency_type][$index_cur] = collect($prices[$currency_type][$index_cur])->sortBy('culture')->toArray();
            $prices[$currency_type][$index_cur] = array_values($prices[$currency_type][$index_cur]);
        }
        return $prices[$currency_type];
    }

    public function setDataPrices($id, $placeType)
    {
        $type = 0;
        $company = CompItems::where('id', $id)->get()->first();
        $author_id = $company['author_id'];
        $issetT2 = TradersPrices::select('id')->where([['buyer_id', $author_id], ['acttype', 1]])->count();

        if ($issetT2 > 0 && $company->trader_price_sell_avail == 1 && $company->trader_price_sell_visible == 1) {
            $type = 1;
        }

        $price = TradersPrices::where([['acttype', $type], ['buyer_id', $author_id]])->with([
            'traders_places' => function ($query) use ($type, $author_id, $placeType) {
                $query->where([['acttype', $type], ['type_id', $placeType], ['buyer_id', $author_id]]);
            }
        ])->get()->groupBy(['curtype', 'place_id'])->toArray();

        foreach ($price[0] as $index => $prices){
            $price[0][$index] = collect($price[0][$index])->sortBy('culture.name')->groupBy('cult_id')->toArray();
            foreach ($prices as $index_p => $place){
                if(empty($place['traders_places'])){
                    unset($price[0][$index][$index_p]);
                }
            }
            if(empty($price[0][$index])){
                unset($price[0][$index]);
            }
        }

        foreach ($price[1] as $index => $prices){
            $price[1][$index] = collect($price[1][$index])->sortBy('culture.name')->groupBy('cult_id')->toArray();
            foreach ($prices as $index_p => $place){
                if(empty($place['traders_places'])){
                    unset($price[1][$index][$index_p]);
                }
            }
            if(empty($price[1][$index])){
                unset($price[1][$index]);
            }
        }


        $price2 = TradersPrices::where([['acttype', $type], ['buyer_id', $author_id]])->with([
            'traders_places' => function ($query) use ($type, $author_id, $placeType) {
                $query->where([['acttype', $type], ['type_id', $placeType], ['buyer_id', $author_id]]);
            }
        ])
            ->get()
            ->groupBy(['place_id'])
            ->toArray();

        foreach ($price2 as $index => $prices){
            foreach ($prices as $index_p => $place){
                if(empty($place['traders_places'])){
                    unset($price2[$index][$index_p]);
                }
            }
            $price2[$index] = collect($price2[$index])->sortBy('culture.name')->groupBy('curtype')->toArray();
            $price2[$index] = array_values($price2[$index]);
            if(empty($price2[$index])){
                unset($price2[$index]);
            }

        }

        //dd($price2, $price);

        return $price;
    }


    public function getTraderPricesRubrics($id, $placeType)
    {
        $type = 0;
        $company = CompItems::where('id', $id)->get()->first();
        $author_id = $company['author_id'];

        $issetT1 = TradersPrices::select('id')->where([['buyer_id', $author_id], ['acttype', 0]])->count();
        $issetT2 = TradersPrices::select('id')->where([['buyer_id', $author_id], ['acttype', 1]])->count();

        if ($issetT2 > 0 && $company->trader_price_sell_avail == 1 && $company->trader_price_sell_visible == 1) {
            $type = 1;
        }

        if ($issetT1 > 0 && $company['trader_price_avail'] == 1 && $company['trader_price_visible'] == 1) {
            $type = 0;
        }

        //dd($this->setDataPrices($id, $placeType));
        //dd($this->getPlaces($author_id, $placeType, $type));

        return TradersProducts2buyer::where([['buyer_id', $author_id], ['acttype', $type], ['type_id', $placeType]])
            ->with([
                'traders_products' => function ($query) use ($type, $author_id, $placeType) {
                    $query->with([
                        'traders_prices' => function ($query) use ($type, $author_id, $placeType) {
                            $query->where([['buyer_id', $author_id], ['acttype', $type]])
                                ->with([
                                    'traders_places' => function ($query) use ($type, $placeType, $author_id) {
                                        $query->where([
                                            ['acttype', $type], ['type_id', $placeType], ['buyer_id', $author_id]
                                        ])
                                            ->with('traders_ports', 'regions')->with('traders_ports.traders_ports_lang');
                                    }
                                ]);
                        }
                    ]);
                }
            ])
            ->get()->toArray();
    }


    public function setCompanies()
    {
        $this->companies = CompItems::join('comp_item2topic', 'comp_items.id', '=', 'comp_item2topic.item_id');
    }


    public function searchCompanies($value)
    {

        return CompItems::where('title', 'like', '%'.trim($value).'%')->orWhere('content', 'like', '%'.trim($value).'%')
            ->select('id', 'author_id', 'trader_premium', 'obl_id', 'logo_file',
                'short', 'add_date', 'visible', 'title', 'trader_price_avail',
                'trader_price_visible', 'phone', 'phone2', 'phone3')
            ->orderBy('trader_premium', 'desc')
            ->orderBy('rate_formula', 'desc')
            ->paginate(self::PER_PAGE);
    }


    public function getReviews($id_company)
    {
        return CompComment::where('item_id', $id_company)
            ->orderBy('comp_comment.id', 'desc')
            ->get()
            ->toArray();
    }

    public function setRubricsGroup($company = [])
    {

        $rubrics = CompTgroups::with(['comp_topic' => function ($query) {
            $query->select('menu_group_id', 'title', 'id')->where('parent_id', 0);
        }
        ])->orderBy('sort_num')->orderBy('title')->get()->groupBy('id')->toArray();

        $topic_counts = CompTopicItem::select(['topic_id', \DB::raw('count(*) as cnt')])->groupBy('topic_id')->get()->keyBy('topic_id')->toArray();

        if(!empty($company))
        {
            $company = $company->groupBy('topic_id');
            foreach ($rubrics as $index_r => $rubric){
                $rubrics[$index_r] = $rubrics[$index_r][0];
                foreach ($rubrics[$index_r]['comp_topic'] as $index_t => $topic){
                    $rubrics[$index_r]['comp_topic'][$index_t]['cnt'] = 0;
                    if(isset($company[$topic['id']])){
                        $rubrics[$index_r]['comp_topic'][$index_t]['cnt'] = collect($company[$topic['id']])->count();
                    }
                }
            }

            $this->rubrics = $rubrics;

            return $rubrics;
        }

        foreach ($rubrics as $index => $rubric) {
            $rubric = reset($rubric);
            foreach ($rubric['comp_topic'] as &$topic) {
                if (!isset($topic_counts[$topic['id']])) {
                    continue;
                }
                $topic['cnt'] = $topic_counts[$topic['id']]['cnt'];
            }
            unset($topic);
            $rubrics[$index] = $rubric;
        }

        $this->rubrics = $rubrics;

        return $rubrics;
    }

    public function getRubricsGroup()
    {
        return $this->rubrics;
    }


    public function getCompanies($data)
    {
        if ($data['query']) {
            $this->setRubricsGroup();
            return $this->searchCompanies($data['query']);
        }

        $this->setCompanies();

        $obl_id = Regions::where('translit', $data['region'])->value('id');
        $rubric = $data['rubric'];

        $companies = $this->companies->where([['comp_items.visible', 1],
            [
                function ($check) use ($obl_id, $rubric)
                {
                    if ($obl_id == null && $rubric) {
                        $check->where('comp_item2topic.topic_id', (int) $rubric);
                    }

                    if ($obl_id != null) {
                        $check->where('comp_items.obl_id', $obl_id);
                    }

                    if ($obl_id != null && $rubric != null) {
                        $check->where([['comp_item2topic.topic_id', $rubric], ['comp_items.obl_id', $obl_id]]);
                    }
                }
            ]
        ])->select('comp_items.id', 'comp_items.author_id', 'comp_items.trader_premium',
            'comp_items.obl_id', 'comp_items.logo_file', 'comp_items.short', 'comp_items.add_date',
            'comp_items.visible', 'comp_items.obl_id', 'comp_items.title', 'comp_items.trader_price_avail',
            'comp_items.trader_price_visible', 'comp_items.phone', 'comp_items.phone2', 'comp_items.phone3', 'comp_item2topic.topic_id', 'comp_item2topic.item_id')
            ->orderBy('trader_premium', 'desc')
            ->orderBy('rate_formula', 'desc')
            ->distinct();

        $dataForRubric = $obl_id ? $companies->get() : [];

        $this->rubrics = $this->setRubricsGroup($dataForRubric);

        return $companies->paginate(self::PER_PAGE);
    }
}
