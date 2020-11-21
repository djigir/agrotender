<?php

namespace App\Services\Traders;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopic;
use App\Models\Comp\CompTopicItem;
use App\Models\Regions\Regions;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersPortsLang;
use App\Models\Traders\TradersPrices;
use App\Models\Traders\TradersProductGroups;
use App\Models\Traders\TradersProductGroupLanguage;
use App\Models\Traders\TradersProducts;
use App\Services\BaseServices;
use App\Services\BreadcrumbService;
use App\Services\CompanyService;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;


class TraderService
{
    const TYPE_TRADERS = 0;
    const TYPE_TRADERS_FORWARD = 1;
    const TYPE_TRADERS_SELL = 2;

    const ACTTYPE_TRADERS = 0;
    const ACTTYPE_TRADERS_FORWARD = 3;


    protected $companyService;
    protected $baseService;
    protected $breadcrumbService;
    protected $treders;
    protected $groups;


    public function __construct(CompanyService $companyService, BaseServices $baseService, BreadcrumbService $breadcrumbService)
    {
        $this->companyService = $companyService;
        $this->baseService = $baseService;
        $this->breadcrumbService = $breadcrumbService;
        $this->treders = null;
        $this->groups = null;
    }


    public function mobileFilter(Request $request)
    {
        $route_name = null;
        $route_params = null;
        $route_name = \Route::getCurrentRoute()->getName();
        $prefix = substr($route_name, 0, strpos($route_name, '.')).'.';

        if (!empty($request->get('region'))) {
            $route_name = 'region';
            $route_params = ['region' => $request->get('region'), 'currency' => $request->get('currency')];
        }

        if (!empty($request->get('port'))) {
            $route_name = 'port';
            $route_params = ['port' => $request->get('port'), 'currency' => $request->get('currency')];
        }

        if (!empty($request->get('region')) && !empty($request->get('rubric'))) {
            $route_name = 'region_culture';
            $route_params = [$request->get('region'), $request->get('rubric'), 'currency' => $request->get('currency')];
        }

        if (!empty($request->get('port')) && !empty($request->get('rubric'))) {
            $route_name = 'port_culture';
            $route_params = [
                'port' => $request->get('port'), 'culture' => $request->get('rubric'),
                'currency' => $request->get('currency')
            ];
        }

        return redirect()->route($prefix.$route_name, $route_params);
    }


    public function setTradersBreadcrumbs($data, $data_breadcrumbs)
    {
        $type_traders = self::TYPE_TRADERS;

        $this->InitQuery($data);

        $breadcrumbs = $this->breadcrumbService->setBreadcrumbsTraders($data_breadcrumbs);

        if (isset($data['forwards'])) {
            $breadcrumbs = $this->breadcrumbService->setBreadcrumbsTradersForward($data_breadcrumbs);
            $type_traders = self::TYPE_TRADERS_FORWARD;
        }

        if (isset($data['sell'])) {
            $breadcrumbs = $this->breadcrumbService->setBreadcrumbsTradersSell($data_breadcrumbs);
            $type_traders = self::TYPE_TRADERS_SELL;
        }

        $traders = $this->getTraders($data);

        return ['traders' => $traders->where('trader_premium', '!=', 2), 'breadcrumbs' => $breadcrumbs, 'type_traders' => $type_traders, 'top_traders' => $traders->where('trader_premium', '=', 2)];
    }


    public function getCurrencies()
    {
        return [
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
    }


    public function getPorts()
    {
        $ports = TradersPorts::select('id', 'url')
            ->with('traders_ports_lang')
            ->where('active', 1)
            ->get();

        $ports = array_values($ports->sortBy('lang.portname')->push(['lang' => ['portname' => 'Все порты'], 'url' => 'all'])->toArray());

        return $ports;
    }


    public function setRubrics($criteria_places, $acttype)
    {
        $forward_months = $this->baseService->getForwardsMonths();

        $type = $acttype == 0  ? '' : '_forward';
        $criteria_prices = [];

        if($acttype == 3)
        {
            $criteria_prices[] = ['traders_prices.dt', '>=', $forward_months];
        }

        $groups = TradersProductGroups::where("acttype", 0)->get()->toArray();

        $group_items = \DB::table('traders_prices')
            ->select(['traders_prices.cult_id', \DB::raw('count(distinct agt_traders_prices.buyer_id) as count_item')])
            ->leftJoin('traders_places', 'traders_prices.place_id', '=', 'traders_places.id')
            ->leftJoin('comp_items', 'comp_items.author_id', '=', 'traders_prices.buyer_id')
            ->where($criteria_places)
            ->where([
                'traders_prices.acttype' => $acttype,
                'traders_prices.active' => 1,
                "comp_items.trader_price{$type}_avail" => 1,
                "comp_items.trader_price{$type}_visible" => 1,
                'comp_items.visible' => 1
            ])
            ->where($criteria_prices)
            ->groupBy('cult_id')
            ->get()
            ->keyBy('cult_id')
            ->toArray();


        foreach ($groups as $index_g => $group) {
            $groups[$index_g]['index_group'] = $index_g+1;
            foreach ($group["groups"]['products'] as $index_c => $culture) {
                $groups[$index_g]["groups"]['products'][$index_c]['count_item'] = 0;
                if(isset($group_items[$culture['id']])){
                    $groups[$index_g]["groups"]['products'][$index_c]['count_item'] = $group_items[$culture['id']]->count_item;
                }
            }
            $groups[$index_g]["groups"]['products'] = collect($groups[$index_g]["groups"]['products'])->sortBy('traders_product_lang.0.name')->toArray();
        }

        return $groups;
    }


    public function getRubricsGroup()
    {
        return $this->groups;
    }


    /**
     * @param $data
    */
    public function InitQuery($data)
    {
        $type = $data['type'] != '' ? '_'.$data['type'] : '';

        $this->treders = CompItems::with('activities')->where([
            "trader_price{$type}_avail" => 1,
            "trader_price{$type}_visible" => 1,
            "visible" => 1
        ]);
    }


    /**
    * @param $author_ids
    * @param $criteria_prices
    * @param $criteria_places
    * @return Builder
    */
    public function getTradersTable($author_ids, $criteria_prices, $criteria_places)
    {
        return $this->treders->whereIn('author_id', $author_ids)
            ->leftJoin('traders_prices', 'comp_items.author_id', '=', 'traders_prices.buyer_id')
            ->leftJoin('traders_places', 'traders_prices.place_id', '=', 'traders_places.id')
            ->leftJoin('traders_ports_lang', 'traders_places.port_id', '=', 'traders_ports_lang.port_id')
            ->leftJoin('regions', 'traders_places.obl_id', '=', 'regions.id')
            ->where($criteria_prices)
            ->where($criteria_places)
            ->where('traders_places.type_id', '!=', 1)
            ->orderBy('comp_items.trader_premium', 'desc')
            ->orderBy('traders_prices.change_date', 'desc')
            ->orderBy('traders_prices.costval', 'desc')
            ->orderBy('comp_items.rate_formula', 'desc')
            ->orderBy('comp_items.trader_sort')
            ->orderBy('comp_items.title')
            ->orderBy('traders_prices.dt')
            ->select('comp_items.id', 'comp_items.title',
                'comp_items.logo_file', 'comp_items.author_id',
                'comp_items.trader_premium', 'traders_prices.cult_id',
                'traders_prices.place_id', 'traders_prices.costval',
                'traders_prices.costval_old', 'traders_prices.comment',
                'traders_prices.curtype', 'traders_prices.dt',
                'traders_prices.change_date', 'traders_places.port_id',
                'traders_places.place','traders_places.type_id', 'traders_ports_lang.portname',
                'regions.name as region')
            ->get();
    }


    /**
    * @param $type
    * @param $author_ids
    * @param $criteria_prices
    * @param $criteria_places
    * @return \Illuminate\Support\Collection
     */
    public function getTradersCard($type, $author_ids, $criteria_prices, $criteria_places)
    {
        $forward_months = $this->baseService->getForwardsMonths();

        if($type == 'forward')
        {
            $criteria_prices[] = ['traders_prices.dt', '>=', reset($forward_months)];
        }

        $traders = $this->treders->whereIn('author_id', $author_ids)
            ->leftJoin('traders_prices', 'comp_items.author_id', '=', 'traders_prices.buyer_id')
            ->leftJoin('traders_places', 'traders_prices.place_id', '=', 'traders_places.id')
            ->leftJoin('traders_products_lang', 'traders_prices.cult_id', '=', 'traders_products_lang.id')
            ->where($criteria_prices)
            ->where($criteria_places)
            ->orderBy('comp_items.trader_premium', 'desc')
            ->orderBy('traders_prices.change_date', 'desc')
            ->orderBy('comp_items.trader_sort')
            ->orderBy('comp_items.rate_formula', 'desc')
            ->orderBy('comp_items.title')
            ->select('comp_items.title', 'comp_items.author_id',
                'comp_items.logo_file', 'comp_items.id',
                'comp_items.trader_premium', 'comp_items.trader_sort',
                'comp_items.rate_formula', 'traders_prices.cult_id',
                'traders_prices.place_id', 'traders_prices.change_date',
                'traders_prices.dt', 'traders_products_lang.name as culture'
            )
            ->groupBy('comp_items.id')
            ->get();

        $prices = TradersPrices::whereIn('traders_prices.buyer_id', $traders->pluck('author_id'))
            ->leftJoin('traders_places', 'traders_prices.place_id', '=', 'traders_places.id')
            ->leftJoin('traders_products_lang', 'traders_prices.cult_id', '=', 'traders_products_lang.id')
            ->where($criteria_prices)
            ->where($criteria_places)
            ->where('traders_places.type_id', '!=', 1)
            ->orderBy('traders_prices.change_date', 'desc')
            ->select('traders_prices.buyer_id', 'traders_prices.cult_id', 'traders_prices.curtype',
                'traders_prices.change_date', 'traders_prices.dt','traders_prices.costval',
                'traders_prices.costval_old', 'traders_prices.curtype',
                'traders_products_lang.name', 'traders_places.obl_id',
                'traders_places.port_id')
            ->get();

        foreach ($traders as $index => $trader) {
            if($prices->where('buyer_id', $trader['author_id'])->count() > 0) {
                $traders[$index]['prices'] = $prices->where('buyer_id', $trader['author_id'])->unique('cult_id')->take(3);

                if($type == 'forward'){
                    $traders[$index]['min_date'] =  $prices->where('buyer_id', $trader['author_id'])->min('dt');
                    $traders[$index]['max_date'] = $prices->where('buyer_id', $trader['author_id'])->max('dt');
                    $traders[$index]['prices'] = $prices->where('buyer_id', $trader['author_id'])->unique('costval')->take(3);
                }
            }
        }

        return $traders;
    }


    /**
    * @param $author_ids
    * @param $criteria_prices
    * @param $criteria_places
    * @return Builder
    */
    public function getTradersForward($author_ids, $criteria_prices, $criteria_places)
    {
        $forward_months = $this->baseService->getForwardsMonths();

        return $this->treders->whereIn('author_id', $author_ids)
            ->leftJoin('traders_prices', 'comp_items.author_id', '=', 'traders_prices.buyer_id')
            ->leftJoin('traders_places', 'traders_prices.place_id', '=', 'traders_places.id')
            ->leftJoin('regions', 'traders_places.obl_id', '=', 'regions.id')
            ->leftJoin('traders_products2buyer', function ($join)
                {
                    $join->on('comp_items.author_id', '=', 'traders_products2buyer.buyer_id');
                    $join->on('traders_products2buyer.acttype', '=', 'traders_prices.acttype');
                    $join->on('traders_products2buyer.type_id', '=', 'traders_places.type_id');
                    $join->on('traders_products2buyer.cult_id', '=', 'traders_prices.cult_id');
                })
            ->where($criteria_prices)
            ->where($criteria_places)
            ->whereDate('traders_prices.dt', '>=', $forward_months)
            ->where('traders_places.type_id', '!=', 1)
            ->where('traders_places.port_id', '!=', 0)
            ->orderBy('comp_items.trader_premium_forward', 'desc')
            ->orderBy('comp_items.rate_formula', 'desc')
            ->orderBy('comp_items.trader_sort_forward')
            ->orderBy('comp_items.title')
            ->orderBy('traders_prices.dt')
            ->select('comp_items.id', 'comp_items.title',
                'comp_items.logo_file', 'comp_items.author_id',
                'comp_items.trader_premium_forward as trader_premium', 'traders_prices.cult_id',
                'traders_prices.place_id', 'traders_prices.costval',
                'traders_prices.costval_old', 'traders_prices.comment',
                'traders_prices.curtype', 'traders_prices.dt',
                'traders_places.port_id', 'traders_places.place',
                'traders_places.type_id', 'traders_places.port_id',
                'regions.name as region')->get();
    }


    public function setCriteriaTraders($data)
    {
        $obl_id = null;
        $culture = null;
        $port_id = null;
        $currency = 2;
        $acttype = $data->get('type') != 'forward' ? self::ACTTYPE_TRADERS : self::ACTTYPE_TRADERS_FORWARD;

        $criteria_places = [];
        $criteria_prices = [['traders_prices.acttype', 0]];

        if ($data->get('port')) {
            $criteria_places[] = ['traders_places.type_id', 2];
        }

        if ($data->get('type') == 'forward') {
            $criteria_prices[0] = ['traders_prices.acttype', 3];
            $criteria_prices[] = ['active', 1];
        }

        if ($data->get('port') && $data->get('port') != 'all') {
            $port_id = TradersPorts::where('url', $data->get('port'))->value('id');
            $criteria_places[] = ['traders_places.port_id', $port_id];
            $criteria_places[] = ['traders_places.port_id', '!=', 0];
        }

        if ($data->get('region') && $data->get('region') != 'ukraine') {
            $obl_id = Regions::where('translit', $data->get('region'))->value('id');
            $criteria_places[] = ['traders_places.obl_id', $obl_id];
        }

        if ($data->get('culture')) {
            $culture = TradersProducts::where('url', $data->get('culture'))->value('id');
            $criteria_prices[] = ['traders_prices.cult_id', $culture];
        }

        if ($data->get('query') && isset($data->get('query')['currency'])) {
            $currency = (int)$data['query']['currency'];
        }

        if ($currency != 2) {
            $criteria_prices[] = ['traders_prices.curtype', $currency];
        }

        return collect([
            'criteria_places' => $criteria_places,
            'criteria_prices' => $criteria_prices,
            'acttype' => $acttype,
            'currency' => $currency,
            'port_id' => $port_id,
            'obl_id' => $obl_id,
        ]);
    }


    public function getTraders($data)
    {
        $criteria_traders = $this->setCriteriaTraders($data);

        $author_ids = TradersPrices::query()
                ->select('traders_prices.buyer_id')
                ->leftJoin('traders_places', 'traders_places.id', '=', 'traders_prices.place_id')
                ->where($criteria_traders->get('criteria_prices'))
                ->where($criteria_traders->get('criteria_places'))
                ->pluck('buyer_id')
            ->toArray();

        $this->groups = $this->setRubrics($criteria_traders->get('criteria_places'), $criteria_traders->get('acttype'));

        if($data->get('type_view') == 'table' && $data->get('type') != 'forward')
        {
            return $this->getTradersTable($author_ids, $criteria_traders->get('criteria_prices'), $criteria_traders->get('criteria_places'));
        }

        if($data->get('type_view') == 'card')
        {
            return $this->getTradersCard($data->get('type'), $author_ids, $criteria_traders->get('criteria_prices'), $criteria_traders->get('criteria_places'));
        }

        if($data->get('type') == 'forward')
        {
            return $this->getTradersForward($author_ids, $criteria_traders->get('criteria_prices'), $criteria_traders->get('criteria_places'));
        }

        return [];
    }
}
