<?php


namespace App\Services;


use App\Http\Controllers\CompanyController;
use App\Models\ADV\AdvTorgPost;
use App\Models\ADV\AdvTorgPostPics;
use App\Models\ADV\AdvTorgTopic;
use App\Models\Comp\CompComment;
use App\Models\Comp\CompCommentLang;
use App\Models\Comp\CompItems;
use App\Models\Comp\CompItemsContact;
use App\Models\Comp\CompTgroups;
use App\Models\Comp\CompTopic;
use App\Models\Comp\CompTopicItem;
use App\Models\Regions\Regions;
use App\Models\Torg\TorgBuyer;
use App\Models\Traders\Traders_Products_Lang;
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
    const SORT_BY = [
        0 => 'regions.0.name',
        2 => 'traders_ports.0.lang.portname'
    ];

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


    public function checkForward($author_id, $id)
    {
        $check_forwards = CompItems::where([
            'id' => $id,
            'trader_price_forward_avail' => 1,
            'trader_price_forward_visible' => 1,
            'visible' => 1
        ])->count();

        $forward_months = $this->baseService->getForwardsMonths();

        $prices_port = $this->getPricesForwards($author_id, 3, reset($forward_months), 2);
        $prices_region = $this->getPricesForwards($author_id, 3, reset($forward_months), 0);

        if($check_forwards > 0 && (!$prices_port->isEmpty() || !$prices_region->isEmpty())){
            return true;
        }

        return false;
    }


    public function getAdverts($author_id, $type = null)
    {
        $criteria_type = [];

        if($type){
            $criteria_type[] = ['adv_torg_post.type_id', $type];
        }

        $adverts = AdvTorgPost::select(
            'adv_torg_post.title as title_post', 'adv_torg_post.type_id',
            'adv_torg_post.id', 'adv_torg_post.city', 'adv_torg_post.add_date',
            'adv_torg_post.up_dt', 'adv_torg_post.amount', 'adv_torg_post.izm',
            'adv_torg_post.cost', 'adv_torg_post.cost_cur', 'adv_torg_post.cost_dog',
            'adv_torg_post.colored', 'adv_torg_post.viewnum', 'regions.name as region',
            'adv_torg_topic.parent_id',
            'adv_torg_topic.title as title_topic',
            'torg_buyer.name as name_author', \DB::raw('case agt_adv_torg_post.company_id when 0 then agt_torg_buyer.name else agt_comp_items.title end author')
            )
            ->join('adv_torg_topic', 'adv_torg_topic.id', '=', 'adv_torg_post.topic_id')
            ->leftJoin('torg_buyer', 'adv_torg_post.author_id', '=', 'torg_buyer.id')
            ->leftJoin('comp_items', 'adv_torg_post.company_id', '=', 'comp_items.id')
            ->leftJoin('regions', 'adv_torg_post.obl_id', '=', 'regions.id')
            ->where('torg_buyer.id', '=', $author_id)
            ->where('adv_torg_post.active', '=', 1)
            ->where('adv_torg_post.moderated', '=', 1)
            ->where('adv_torg_post.archive', '=', 0)
            ->where($criteria_type)
            ->orderBy('adv_torg_post.up_dt', 'desc')->distinct()->get();

        $rubric = AdvTorgTopic::whereIn('id', $adverts->pluck('parent_id'))->select('id', 'title')->get();

        $image = AdvTorgPostPics::whereIn('item_id', $adverts->pluck('id'))
            ->select('item_id', 'filename_ico')
            ->orderBy('sort_num')
            ->get();

        return collect(['adverts' => $adverts, 'rubric' => $rubric, 'image' => $image]);
    }


    public function checkAdverts($author_id)
    {
        $count_adverts = AdvTorgPost::join('adv_torg_topic', 'adv_torg_topic.id', '=', 'adv_torg_post.topic_id')
            ->leftJoin('torg_buyer', 'adv_torg_post.author_id', '=', 'torg_buyer.id')
            ->leftJoin('comp_items', 'adv_torg_post.company_id', '=', 'comp_items.id')
            ->leftJoin('regions', 'adv_torg_post.obl_id', '=', 'regions.id')
            ->where('torg_buyer.id', '=', $author_id)
            ->where('adv_torg_post.active', '=', 1)
            ->where('adv_torg_post.moderated', '=', 1)
            ->where('adv_torg_post.archive', '=', 0)->count();

        if($count_adverts > 0){
            return true;
        }

        return false;
    }


    public function getPricesForwards($author_id, $type, $dtStart, $placeType)
    {
        $prices = TradersPrices::where([['buyer_id', $author_id], ['acttype', $type], ['dt', '>=', $dtStart]])
            ->with(['traders_places' => function ($query) use ($placeType) {
                $query->where('type_id', $placeType)->with('traders_ports', 'regions');
            }])->get();

        return $prices->sortBy('cultures.0.name');
    }


    public function mobileFilter(Request $request)
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


    public function getDepNameAndCreator($author_id, $departments_type)
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

        $creators = TorgBuyer::where('id', $author_id)->get()->first();

        return ['creators' => $creators, 'departament_name' => $departament_name];
    }

    public function departamentsContacts($id)
    {
        $departaments_contacts = CompItemsContact::select('id', 'comp_id', 'type_id', 'visible', 'sort_num', 'add_date',
        'region', 'dolg', 'fio', 'phone', 'fax', 'email', 'pic_src', 'pic_ico', 'buyer_id')
        ->selectRaw("CASE WHEN type_id = 1 THEN 'Отдел закупок' WHEN type_id = 2
            THEN 'Отдел продаж' WHEN type_id = 3 THEN 'Отдел услуг' end as dep_name")->where('comp_id', $id)->get();

        return $departaments_contacts;
    }


    /** Упрощенный метод получения Place -> буду юзать в будующем
     * @param $author_id
     * @param $placeType
     * @param $type
     * @return
     */
    public function getPlaces($author_id, $type, $placeType)
    {
        return TradersPlaces::where([['acttype', $type], ['type_id', $placeType], ['buyer_id', $author_id]])
            ->orderBy('place', 'asc')
            ->orderBy('obl_id', 'asc')
            ->select('obl_id', 'place', 'type_id', 'acttype', 'buyer_id', 'place', 'id', 'port_id')
            ->get()
            ->toArray();
    }

    /** Упрощенный метод получения Place -> буду юзать в будующем
     * @param $author_id
     * @param $type
     * @param $placeType
     * @return
     */
    public function getPrices($author_id, $type, $placeType)
    {
        $statusCurtype = '';
        $check_curtype = [];
        $place_id = [];
        $sortBy = self::SORT_BY[$placeType];

        $prices = TradersPrices::where([
            'acttype' => $type,
            'buyer_id' => $author_id
        ])->with([
            'traders_places' => function ($query) use ($type, $author_id, $placeType) {
                $query->where([
                    'acttype' => $type,
                    'type_id' => $placeType,
                    'buyer_id' => $author_id
                ]);
            }
        ])->get()->groupBy(['place_id']);


        foreach ($prices as $index => $price)
        {
            foreach ($prices[$index] as $index_place => $place){
                if(!$place['traders_places']){
                    unset($prices[$index][$index_place]);
                }
            }

            $prices[$index] = collect($prices[$index])->groupBy(['curtype', 'cult_id'])->toArray();

            if(empty($price)){
                unset($prices[$index]);
            }

            if(empty($prices[$index])){
                unset($prices[$index]);
            }
        }


        foreach ($prices as $index => $price){
            $place_id[] = $index;
        }

        $places = TradersPlaces::where('type_id', $placeType)->whereIn('id', $place_id);

        if($placeType == 0){
            $places->with('regions');
        }

        if($placeType == 2){
            $places->with('traders_ports');
        }

        $places = $places->select('id', 'type_id', 'place', 'port_id', 'obl_id')->get();

        $id_place = $places->pluck('id');

        foreach ($id_place as $index => $id)
        {
            if(isset($prices[$id]))
            {
                $check_curtype = array_merge($check_curtype, array_keys($prices[$id]));
            }
        }

        if(in_array(0, $check_curtype)){
            $statusCurtype = 'UAH';
        }

        if(in_array(1, $check_curtype)){
            $statusCurtype = 'USD';
        }

        if(in_array(0, $check_curtype) && in_array(1, $check_curtype)){
            $statusCurtype = 'UAH_USD';
        }

        $places = $places->sortBy('obl_id')->sortBy($sortBy);

        return collect(['prices' => $prices, 'places'=> $places, 'statusCurtype' => $statusCurtype]);
    }


    public function getCultures($author_id, $type, $placeType)
    {
        $cultures = TradersProducts2buyer::where([
            'buyer_id' => $author_id,
            'acttype' => $type,
            'type_id' => $placeType
        ])->with(['traders_prices' => function ($query) use ($type, $author_id, $placeType) {
                $query->where([
                    'buyer_id' => $author_id,
                    'acttype' => $type
                ])->with([
                    'traders_places' => function ($query) use ($type, $author_id, $placeType) {
                        $query->where([
                            'acttype' => $type,
                            'type_id' => $placeType,
                            'buyer_id' => $author_id
                        ]);
                    }
                ]);
            }]
        )->get();


        foreach ($cultures as $index => $culture)
        {
            foreach ($culture->traders_prices as $index_prices => $prices) {
                foreach ($culture->traders_prices as $index_cult => $cult){
                    if($cult['cultures']->isEmpty()){
                        $culture->traders_prices->forget($index_prices);
                    }
                }

                if ($prices->traders_places->isEmpty()) {
                    $culture->traders_prices->forget($index_prices);
                }
            }

            if(!$culture->traders_prices->isEmpty() && isset($culture->traders_prices->first()->cultures[0])){
                $cultures[$index]['culture'] = $culture->traders_prices->first()->cultures[0]->name;
            }

            if($culture->traders_prices->isEmpty()){
                $cultures->forget($index);
            }
        }

        $cultures = $cultures->sortBy('culture');

        return $cultures;
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

        if ($issetT1 > 0 && $company->trader_price_avail == 1 && $company->trader_price_visible == 1) {
            $type = 0;
        }

        $cultures = $this->getCultures($author_id, $type, $placeType);
        $prices_places_curtype = $this->getPrices($author_id, $type, $placeType);

        return collect([
            'cultures' => $cultures,
            'prices' => $prices_places_curtype->get('prices'),
            'places' => $prices_places_curtype->get('places'),
            'statusCurtype' => $prices_places_curtype->get('statusCurtype')
        ]);
    }


    public function setCompanies()
    {
        $this->companies = CompItems::
            join('comp_item2topic', 'comp_items.id', '=', 'comp_item2topic.item_id')->with('activities')
            ->where('comp_items.visible', 1);
    }


    public function searchCompanies($value)
    {
        return CompItems::where('title', 'like', '%'.trim($value).'%')->orWhere('content', 'like', '%'.trim($value).'%')
            ->with('activities', 'purchases', 'sales', 'services')
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
            ->get();
    }

    public function setRegions($regions, $rubric = null)
    {
        $this->setCompanies();

        $region_counts = CompItems::select(['obl_id', \DB::raw('count(*) as obl')]);

        if($rubric){
            $region_counts = $this->companies
                ->where('comp_item2topic.topic_id', $rubric)
                ->select(['comp_items.obl_id', \DB::raw('count(*) as obl')]);
        }

        $region_counts = $region_counts
            ->groupBy('obl_id')
            ->get()
            ->keyBy('obl_id')
            ->toArray();

        foreach ($regions as $index => $region) {
            $regions[$index]['count_items'] = 0;
            if (isset($region_counts[$region['id']])) {
                $regions[$index]['count_items'] = $region_counts[$region['id']]['obl'];
            }

            if($regions[$index]['count_items'] == 0){
                unset($regions[$index]);
            }
        }

        return $regions;
    }


    public function setRubricsGroup($region_id = null, $rubric_id = null)
    {
        $this->setCompanies();

        $rubrics = CompTgroups::with(['comp_topic' => function ($query) {
            $query->select('menu_group_id', 'title', 'id')->where('parent_id', 0);
        }])->orderBy('sort_num')->orderBy('title')->get()->groupBy('id')->toArray();

        $topic_counts = CompTopicItem::select(['topic_id', \DB::raw('count(*) as cnt')])->groupBy('topic_id')->get()->keyBy('topic_id')->toArray();

        if(!$region_id){
            foreach ($rubrics as $index => $rubric) {
                $rubric = reset($rubric);
                foreach ($rubric['comp_topic'] as $index2 => &$topic) {
                    if (!isset($topic_counts[$topic['id']])) {
//                        continue;
                        unset($rubrics[$index][0]['comp_topic'][$index2]);
                    }
                    $topic['cnt'] = $topic_counts[$topic['id']]['cnt'];
                }
                unset($topic);

                if(!empty($rubric['comp_topic'])){
                    $rubrics[$index] = $rubric;
                }
            }

            $this->rubrics = $rubrics;
        }

        if($region_id) {
            $company = $this->companies
                ->where('comp_items.obl_id', $region_id)
                ->select('comp_items.id', 'comp_items.author_id','comp_item2topic.topic_id')
                ->get()->groupBy('topic_id');

            foreach ($rubrics as $index_r => $rubric){
                $rubrics[$index_r] = $rubrics[$index_r][0];
                foreach ($rubrics[$index_r]['comp_topic'] as $index_t => $topic){
                    $rubrics[$index_r]['comp_topic'][$index_t]['cnt'] = 0;
                    if(isset($company[$topic['id']])){
                        $rubrics[$index_r]['comp_topic'][$index_t]['cnt'] = collect($company[$topic['id']])->count();
                    }else{
                        unset($rubrics[$index_r]['comp_topic'][$index_t]);
                    }
                }

                if(empty($rubrics[$index_r]['comp_topic'])){
                    unset($rubrics[$index_r]);
                }
            }

            $this->rubrics = $rubrics;
        }

        return $this->rubrics;
    }


    public function getCompanies($data)
    {
        if ($data['query']) {
            $this->setRubricsGroup();

            return $this->searchCompanies($data['query']);
        }

        $obl_id = Regions::where('translit', $data['region'])->value('id');
        $rubric = $data['rubric'];
        $company_criteria = [];
        $topic_criteria = [];

        $companies = CompItems::leftJoin('torg_buyer', 'comp_items.author_id', '=', 'torg_buyer.id')
            ->with('activities', 'purchases', 'sales', 'services')->where('comp_items.visible', 1);

        if($obl_id == null && $rubric){
            $topic_criteria[] = ['comp_item2topic.topic_id', (int) $rubric];
        }

        if($obl_id != null){
            $company_criteria[] = ['comp_items.obl_id', $obl_id];
        }

        if($obl_id != null && $rubric != null){
            $topic_criteria[] = ['comp_item2topic.topic_id', $rubric];
            $company_criteria[] = ['comp_items.obl_id', $obl_id];
        }

        if(!empty($company_criteria)){
            $companies = $companies->where($company_criteria);
        }

        if(!empty($topic_criteria)) {
            $companies->leftJoin('comp_item2topic', 'comp_items.id', '=', 'comp_item2topic.item_id')->where($topic_criteria);
        }

        $companies = $companies->orderBy('comp_items.trader_premium', 'desc')
            ->orderBy('comp_items.rate_formula', 'desc')
            ->select('comp_items.id', 'comp_items.author_id',
                'comp_items.trader_premium', 'comp_items.obl_id', 'comp_items.logo_file',
                'comp_items.short', 'comp_items.add_date', 'comp_items.visible', 'comp_items.obl_id',
                'comp_items.title', 'comp_items.trader_price_avail', 'comp_items.trader_price_visible',
                'comp_items.phone', 'comp_items.phone2', 'comp_items.phone3');

        return $companies->paginate(self::PER_PAGE);
    }
}
