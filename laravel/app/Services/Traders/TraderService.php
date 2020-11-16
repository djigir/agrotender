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
        $type_traders = 0;

        $this->InitQuery($data);

        $breadcrumbs = $this->breadcrumbService->setBreadcrumbsTraders($data_breadcrumbs);

        if (isset($data['forwards'])) {
            $breadcrumbs = $this->breadcrumbService->setBreadcrumbsTradersForward($data_breadcrumbs);
            $type_traders = 1;
        }

        if (isset($data['sell'])) {
            $breadcrumbs = $this->breadcrumbService->setBreadcrumbsTradersSell($data_breadcrumbs);
            $type_traders = 2;
        }

        $traders = $this->getTradersRegionPortCulture($data);

        return ['traders' => $traders, 'breadcrumbs' => $breadcrumbs, 'type_traders' => $type_traders];
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


    public function getNamePortRegion($region = null, $port = null)
    {
        $onlyPorts = null;
        $id_port = TradersPorts::where('url', $port)->value('id');
        $port_name = ($port != 'all') ? TradersPortsLang::where('port_id', $id_port)->value('portname') : [
            'Все порты', $onlyPorts = 'yes'
        ][0];
        $name_region = ($region != null) ? Regions::where('translit', $region)->value('name').' область' : null;

        if ($region == 'crimea') {
            $name_region = 'АР Крым';
        }

        if ($region == 'ukraine') {
            $name_region = 'Вся Украина';
        }

        return ['region' => $name_region, 'port' => $port_name, 'onlyPorts' => $onlyPorts];
    }

    public function getPorts()
    {
        $ports = TradersPorts::select('id', 'url')
            ->with('traders_ports_lang')
            ->where('active', 1)
            ->get();
        $ports = array_values($ports->sortBy('lang.portname')->push([
            'lang' => ['portname' => 'Все порты'], 'url' => 'all'
        ])->toArray());

        return $ports;
    }

    public function setRubrics($criteria_places, $acttype)
    {
        $groups = TradersProductGroups::where("acttype", 0)->get()->toArray();

        $group_items = \DB::table('traders_prices')
            ->select(['traders_prices.cult_id',\DB::raw('count(distinct agt_traders_prices.buyer_id) as count_item')])
            ->leftJoin('traders_places', 'traders_places.id', '=', 'traders_prices.place_id')
            ->leftJoin('comp_items', 'comp_items.author_id', '=', 'traders_prices.buyer_id')
            ->where($criteria_places)
            ->where([
                'traders_prices.acttype' => $acttype,
                'active' => 1,
                'comp_items.trader_price_avail' => 1,
                'comp_items.trader_price_visible' => 1,
                'comp_items.visible' => 1
            ])
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


    public function InitQuery($data)
    {
        $type = $data['type'] != '' ? '_'.$data['type'] : '';
        $this->treders = CompItems::with('activities')->where([
            ["trader_price{$type}_avail", 1], ["trader_price{$type}_visible", 1], ["visible", 1]
        ]);
    }

    private function checkNameRelationship($currency)
    {
        $name = 'traders_prices_traders';

        if($currency == 0)
        {
            $name = 'traders_prices_traders_uah';
        }

        if($currency == 1)
        {
            $name = 'traders_prices_traders_usd';
        }

        return $name;
    }

    public function getTradersRegionPortCulture($data)
    {
        /** @var Builder $traders */
        $traders = $this->treders;

        $obl_id = null;
        $culture = null;
        $port_id = null;
        $currency = 2;
        $acttype = $data['type'] != 'forward' ? 0 : 3;
        $type_place = $data['region'] != null ? 0 : 2;

        $criteria_places = [];
        $criteria_prices = [['traders_prices.acttype', 0]];

        if($data['type'] == 'forward'){
            $criteria_prices[0] = ['traders_prices.acttype', 3];
            $criteria_prices[] = ['active', 1];
        }

        if ($data['port'] && $data['port'] != 'all') {
            $port_id = TradersPorts::where('url',
                $data['port'])->value('id');
            $criteria_places[] = ['traders_places.port_id', $port_id];
            $criteria_places[] = ['traders_places.port_id', '!=', 0];
        }

        if ($data['region'] && $data['region'] != 'ukraine') {
            $obl_id = Regions::where('translit', $data['region'])->value('id');
            $criteria_places[] = ['traders_places.obl_id', $obl_id];
        }

        if ($data['culture']) {
            $culture = TradersProducts::where('url', $data['culture'])->value('id');
            $criteria_prices[] = ['traders_prices.cult_id', $culture];
        }

        if ($data['query'] && isset($data['query']['currency'])) {
            $currency = (int) $data['query']['currency'];
        }

        if ($currency != 2) {
            $criteria_prices[] = ['traders_prices.curtype', $currency];
        }

        $author_ids = TradersPrices::query()
                ->select('traders_prices.buyer_id')
                ->leftJoin('traders_places', 'traders_places.id', '=', 'traders_prices.place_id')
                ->where($criteria_prices)
                ->where($criteria_places)
                ->pluck('buyer_id')
            ->toArray();

        $name_relationship = $this->checkNameRelationship($currency);

        $traders = $traders->with($name_relationship)->with(['traders_places' => function($query) use($obl_id, $port_id, $type_place, $currency){
            $query->place($obl_id, $port_id, $type_place);
            if($currency != 2){
                $query->wherePivot('curtype', $currency);
            }
        }])->select('title', 'author_id', 'id', 'logo_file', 'trader_premium', 'trader_sort', 'rate_formula',
                'trader_price_visible', 'visible', 'trader_price_avail', 'obl_id', 'add_date')
            ->whereIn('author_id', $author_ids)
            ->orderBy('trader_premium', 'desc')
//            ->orderBy('trader_sort')
//            ->orderBy('rate_formula', 'desc')
//            ->orderBy('title')
            ->get();

        $this->groups = $this->setRubrics($criteria_places, $acttype);

        return $traders;
    }
}
