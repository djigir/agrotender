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
use App\Services\CompanyService;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;


class TraderService
{
    protected $companyService;
    protected $baseService;
    protected $treders;
    protected $groups;

    public function __construct(CompanyService $companyService, BaseServices $baseService)
    {
        $this->companyService = $companyService;
        $this->baseService = $baseService;
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

        if (isset($data['forwards'])) {
            $traders = $this->getTradersForward($data);
            $breadcrumbs = $this->baseService->setBreadcrumbsTradersForward($data_breadcrumbs);
            $type_traders = 1;


        } elseif (isset($data['sell'])) {
            $traders = $this->getTradersRegionPortCulture($data);
            $breadcrumbs = $this->baseService->setBreadcrumbsTradersSell($data_breadcrumbs);
            $type_traders = 2;

        } else {
            $traders = $this->getTradersRegionPortCulture($data);
            $breadcrumbs = $this->baseService->setBreadcrumbsTraders($data_breadcrumbs);
        }

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

    public function setRubrics($traders)
    {
        $groups = TradersProductGroups::where("acttype", 0)->get()->toArray();

        foreach ($groups as $index => $group) {
            $groups[$index]['index_group'] = $index + 1;
            $groups[$index]['products'] = collect($groups[$index]['groups']['products'])->sortBy('culture.name')->toArray();
            unset($groups[$index]['groups']['products']);
        }

        foreach ($traders as $index => &$cnt) {
            $traders[$index]['traders_prices_traders'] = collect($traders[$index]['traders_prices_traders'])->groupBy('cult_id');
        }

        foreach ($groups as $index_g => $group) {
            foreach ($group['products'] as $index_c => $culture) {
                $groups[$index_g]['products'][$index_c]['count'] = 0;
                foreach ($traders as $index => &$item) {
                    if (isset($item['traders_prices_traders'][$culture['id']])) {
                        $groups[$index_g]['products'][$index_c]['count']++;
                    }
                }
//                if($groups[$index_g]['products'][$index_c]['count'] == 0){
//                    unset($groups[$index_g]['products'][$index_c]);
//                }
            }
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


    public function getTradersForward($data)
    {
        $port_id = ($data['port'] && $data['port'] != 'all') ? TradersPorts::where('url',
            $data['port'])->value('id') : null;

        $obl_id = ($data['region'] && $data['region'] != 'ukraine') ? Regions::where('translit',
            $data['region'])->value('id') : null;

        $culture = TradersProducts::where('url', $data['culture'])->value('id');

        $traders = $this->treders->with([
            'traders_prices' => function ($prices) use ($culture, $obl_id, $port_id) {
                $prices->where([
                    ['acttype', 3], ['active', 1], [
                        function ($check) use ($culture) {
                            if ($culture) {
                                $check->where('cult_id', $culture);
                            }
                        }
                    ]
                ])->with([
                    'traders_places' => function ($places) use ($culture, $obl_id, $port_id) {
                        $places->where([
                            ['type_id', '!=', 1],
                            [
                                function ($check) use ($obl_id) {
                                    if ($obl_id) {
                                        $check->where('obl_id', $obl_id);
                                    }
                                }
                            ],
                            [
                                function ($check) use ($port_id) {
                                    if ($port_id) {
                                        $check->where('port_id', $port_id);
                                    }
                                }
                            ]
                        ]);
                    }
                ]);
            }
        ])
            ->select('title', 'author_id', 'id', 'logo_file', 'trader_premium', 'trader_sort', 'rate_formula',
                'trader_premium_forward', 'trader_sort_forward')
            ->orderBy('trader_premium', 'desc')
            ->orderBy('trader_sort_forward')
            ->orderBy('rate_formula', 'desc')
            ->orderBy('title')
            ->get()
            ->toArray();

        foreach ($traders as $index_trader => $trader) {
            foreach ($trader['traders_prices'] as $index => $prices) {
                if (isset($prices['traders_places'][0])) {
                    $traders[$index_trader]['traders_prices'][$index]['place'] = $prices['traders_places'][0]['place'];
                    $traders[$index_trader]['traders_prices'][$index]['region'] = $prices['traders_places'][0]['region'];
                    unset($traders[$index_trader]['traders_prices'][$index]['traders_places']);
                }

                if (empty($prices['traders_places'])) {
                    unset($traders[$index_trader]['traders_prices'][$index]);
                }
            }

            $traders[$index_trader]['traders_prices'] = collect($traders[$index_trader]['traders_prices'])->sortBy('dt')->toArray();
            $traders[$index_trader]['traders_prices'] = array_values($traders[$index_trader]['traders_prices']);

            if (empty($traders[$index_trader]['traders_prices'])) {
                unset($traders[$index_trader]);
            }
        }

        $traders = array_values($traders);

        $this->groups = $this->setRubrics($traders);

        return $traders;
    }


    public function getTradersRegionPortCulture($data)
    {
        \DB::enableQueryLog();
        /** @var Builder $traders */
        $traders = $this->treders;

        $obl_id = null;
        $culture = null;
        $port_id = null;
        $currency = 2;
        $criteria_places = [];
        $criteria_prices = [];


        if ($data['port'] && $data['port'] != 'all') {
            $port_id = TradersPorts::where('url',
                $data['port'])->value('id');
            $criteria_places[] = ['port_id', $port_id];
            $criteria_places[] = ['port_id', '!=', 0];
        }

        if ($data['region'] && $data['region'] != 'ukraine') {
            $obl_id = Regions::where('translit', $data['region'])->value('id');
            $criteria_places[] = ['obl_id', $obl_id];
        }

        if ($data['culture']) {
            $culture = TradersProducts::where('url', $data['culture'])->value('id');
            $criteria_prices[] = ['cult_id', $culture];
        }

        if ($data['query'] && isset($data['query']['currency'])) {
            $currency = (int) $data['query']['currency'];
        }

        if ($currency != 2) {
            $criteria_prices[] = ['curtype', $currency];
        }

        $author_ids = TradersPrices::query()
                ->select('traders_prices.buyer_id')
                ->leftJoin('traders_places', 'traders_places.id', '=', 'traders_prices.place_id')
                ->where($criteria_prices)
                ->where($criteria_places)
                ->pluck('buyer_id')->toArray();


        $traders = $traders
            ->with('traders_prices_traders.cultures', 'traders_places')
            ->select('title', 'author_id', 'id', 'logo_file', 'trader_premium', 'trader_sort', 'rate_formula',
                'trader_price_visible', 'visible', 'trader_price_avail', 'obl_id', 'add_date')
            ->whereIn('author_id', $author_ids)
            ->orderBy('trader_premium', 'desc')
            ->orderBy('trader_sort')
            ->orderBy('rate_formula', 'desc')
            ->orderBy('title')
            ->get();
//        $this->groups = $this->setRubrics($traders);
        $this->groups = [];
        //dd(\DB::getQueryLog());

       // dd($traders->toArray()[2], $traders->toArray()[3], $traders->toArray()[5]);


        return $traders;
    }
}
