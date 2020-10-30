<?php

namespace App\Services\Traders;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopic;
use App\Models\Comp\CompTopicItem;
use App\Models\Regions\Regions;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersPortsLang;
use App\Models\Traders\TradersProductGroups;
use App\Models\Traders\TradersProductGroupLanguage;
use App\Models\Traders\TradersProducts;
use App\Services\BaseServices;
use App\Services\CompanyService;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TraderService
{
    protected $companyService;
    protected $baseService;
    protected $treders;

    public function __construct(CompanyService $companyService, BaseServices $baseService)
    {
        $this->companyService = $companyService;
        $this->baseService = $baseService;
        $this->treders = null;
    }

    public function mobileFilter(Request $request)
    {
        $route_name = null;
        $route_params = null;
        $route_name = \Route::getCurrentRoute()->getName();
        $prefix = substr($route_name, 0, strpos($route_name, '.')).'.';

        if(!empty($request->get('region')) && $prefix != 'traders_forwards.'){
            $route_name = $prefix.'region';
            $route_params = ['region' => $request->get('region'), 'currency' => $request->get('currency')];
        }

        if(!empty($request->get('port')) && $prefix != 'traders_forwards.'){
            $route_name = $prefix.'port';
            $route_params = ['port' => $request->get('port'), 'currency' => $request->get('currency')];
        }

        if(!empty($request->get('region')) && !empty($request->get('rubric'))){
            $route_name = $prefix.'region_culture';
            $route_params = [$request->get('region'), $request->get('rubric'), 'currency' => $request->get('currency')];
        }

        if(!empty($request->get('port')) && !empty($request->get('rubric'))){
            $route_name = $prefix.'port_culture';
            $route_params = ['port' => $request->get('port'), 'culture' => $request->get('rubric'), 'currency' => $request->get('currency')];
        }

        return redirect()->route($route_name, $route_params);
    }


    public function setTradersBreadcrumbs($data, $data_breadcrumbs)
    {
        $type_traders = 0;

        $this->setInitQuery($data);

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
        $port_name = ($port != 'all') ? TradersPortsLang::where('port_id', $id_port)->value('portname') : ['Все порты', $onlyPorts = 'yes'][0];
        $name_region = ($region != null) ? Regions::where('translit', $region)->value('name').' область' : null;

        if($region == 'crimea'){
            $name_region = 'АР Крым';
        }

        if($region == 'ukraine'){
            $name_region = 'Вся Украина';
        }

        return ['region' => $name_region, 'port' => $port_name, 'onlyPorts' => $onlyPorts];

    }

    public function getPorts()
    {
        $ports = TradersPorts::select('id', 'url')->with(['traders_ports_lang' => function($query){
            $query->select('portname', 'p_title', 'p_h1', 'p_descr', 'port_id');
        }])
            ->where('active', 1)
            ->get()
            ->toArray();

        foreach ($ports as $index => $port){
            $ports[$index] = array_merge($port, $port['traders_ports_lang'][0]);
            unset($ports[$index]["traders_ports_lang"]);
        }

        $ports = collect($ports)->sortBy('portname')->toArray();
        $ports = array_values($ports);
        array_push($ports, ['portname' => 'Все порты', 'url' => 'all']);

        return $ports;

    }


    public function getRubricsGroup()
    {
        $groups = TradersProductGroups::where("acttype", 0)->get();

        $topic_counts = CompTopicItem::select(['item_id', \DB::raw('count(*) as cnt')])
            ->groupBy('item_id')
            ->get()
            ->keyBy('item_id')
            ->toArray();


        foreach ($groups as $index_group => $group){
            $groups[$index_group]['index_group'] = $index_group;
        }

        $groups = collect($groups)->groupBy("index_group")->toArray();

        foreach ($groups as $index => $group) {
            $groups[$index] = $groups[$index][0];
            $groups[$index]['products'] = $groups[$index]['groups']['traders_products'];
            $groups[$index]['products'] = collect($groups[$index]['products'])->sortBy('culture.name')->toArray();

            unset($groups[$index]['groups']['traders_products']);
        }

        foreach ($groups as $index => $rubric) {
            foreach ($rubric['products'] as $index2 =>  &$topic) {
                if (!isset($topic_counts[$topic['id']])) {
                    continue;
                }
                $groups[$index]['products'][$index2]['cnt'] = $topic_counts[$topic['id']]['cnt'];
            }
            $rubrics[$index] = $rubric;
        }


        return $groups;
    }

    public function setInitQuery($data)
    {
        $type = $data['type'] != '' ? '_'.$data['type'] : '';

        $this->treders = CompItems::where([["trader_price{$type}_avail", 1], ["trader_price{$type}_visible", 1], ["visible", 1]]);
    }



    public function getTradersForward($data)
    {
        $port_id = ($data['port'] && $data['port'] != 'all') ? TradersPorts::where('url', $data['port'])->value('id') : null;
        $obl_id = ($data['region'] && $data['region'] != 'ukraine') ? Regions::where('translit', $data['region'])->value('id') : null;
        $culture = TradersProducts::where('url', $data['culture'])->value('id');

        $traders =  $this->treders->with([
                'traders_prices' => function ($prices) use ($culture, $obl_id, $port_id) {
                    $prices->where([
                        ['acttype', 3], ['active', 1], ['cult_id', $culture]
                    ])
                        ->with(['traders_places' => function ($places) use($culture, $obl_id, $port_id){
                            $places->where([
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
                        }]);
                }
            ])
            ->select('title', 'author_id', 'id', 'logo_file', 'trader_premium', 'trader_sort', 'rate_formula')
            ->orderBy('trader_premium', 'desc')
            ->orderBy('trader_sort')
            ->orderBy('rate_formula', 'desc')
            ->orderBy('title')
            ->get()
            ->toArray();

        foreach ($traders as $index_trader => $trader)
        {
            foreach ($trader['traders_prices'] as $index => $prices){
                if(isset($prices['traders_places'][0])){
                    $traders[$index_trader]['traders_prices'][$index]['place'] = $prices['traders_places'][0]['place'];
                    $traders[$index_trader]['traders_prices'][$index]['region'] = $prices['traders_places'][0]['region'];
                    unset($traders[$index_trader]['traders_prices'][$index]['traders_places']);
                }

                if(empty($prices['traders_places'])){
                    unset($traders[$index_trader]['traders_prices'][$index]);
                }
            }

            $traders[$index_trader]['traders_prices'] = collect($traders[$index_trader]['traders_prices'])->sortByDesc('place')->toArray();
            $traders[$index_trader]['traders_prices'] = array_values($traders[$index_trader]['traders_prices']);

            if(empty($traders[$index_trader]['traders_prices'])){
                unset($traders[$index_trader]);
            }
        }

        $traders = array_values($traders);

        return $traders;
    }

    public function getTradersRegionPortCulture($data)
    {
        $port_id=($data['port'] && $data['port'] != 'all') ? TradersPorts::where('url', $data['port'])->value('id') : null;
        $obl_id = ($data['region'] && $data['region'] != 'ukraine') ? Regions::where('translit', $data['region'])->value('id') : null;

        $culture = $data['culture'] ? TradersProducts::where('url', $data['culture'])->value('id') : null;

        $currency = ($data['query'] && isset($data['query']['currency'])) ? (int)$data['query']['currency'] : 2;

        $traders = $this->treders->with([
                'traders_prices' => function ($query) use ($culture, $obl_id, $port_id, $currency) {
                    $query->where([['acttype', 0],
                        [
                            function ($check) use ($currency) {
                                if($currency != 2){
                                    $check->where('curtype', $currency);
                                }
                            }
                        ],
                        [
                            function ($check) use ($culture, $obl_id, $port_id) {
                                if ($culture) {
                                    $check->where('cult_id', $culture);
                                }
                            }
                        ]
                    ])->with(['traders_places' => function ($check) use ($obl_id, $port_id) {
                            if($obl_id != null || $port_id != null){
                                $check->where([
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
                        }
                    ])->select('id', 'buyer_id', 'cult_id', 'place_id', 'curtype', 'acttype', 'costval', 'costval_old', 'add_date', 'dt', 'comment');
                }
            ])
            ->select('title', 'author_id', 'id', 'logo_file', 'trader_premium', 'trader_sort', 'rate_formula',
                'trader_price_visible', 'visible', 'trader_price_avail', 'obl_id', 'add_date')
            ->orderBy('trader_premium', 'desc')
            ->orderBy('trader_sort')
            ->orderBy('rate_formula', 'desc')
            ->orderBy('title')
            ->get()
            ->toArray();


        foreach ($traders as $index => $trader){
            foreach ($trader['traders_prices'] as $index_place => $place){
                $traders[$index]['traders_prices'] = collect($traders[$index]['traders_prices'])->sortBy('culture.name')->toArray();
                if(empty($place['traders_places'])){
                    unset($traders[$index]['traders_prices'][$index_place]);
                }
                elseif($data['port'] == 'all' && $data['port'] && empty($place['traders_places'][0]['port'])){
                    unset($traders[$index]['traders_prices'][$index_place]);
                }
                else{
                    $traders[$index]['traders_prices'][$index_place]['traders_places'] = $traders[$index]['traders_prices'][$index_place]['traders_places'][0];
                    $traders[$index]['traders_prices'][$index_place]['region'] = $traders[$index]['traders_prices'][$index_place]['traders_places']['region'];
                    $traders[$index]['traders_prices'][$index_place]['port'] = $traders[$index]['traders_prices'][$index_place]['traders_places']['port'];

                    unset($traders[$index]['traders_prices'][$index_place]['traders_places']['region']);
                    unset($traders[$index]['traders_prices'][$index_place]['traders_places']['port']);
                }
            }
            $traders[$index]['traders_prices'] = array_values($traders[$index]['traders_prices']);
            if(empty($traders[$index]['traders_prices'])){
                unset($traders[$index]);
            }

        }

        $traders = array_values($traders);


        return $traders;
    }

//    public function add_data_traders($traders)
//    {
//        foreach ($traders as $index => $trader) {
//            $traders[$index]['cultures'] = [];
//            $traders[$index]['cultures'] = $this->companyService->getPortsRegionsCulture($trader['id'], 0);
//
//            if (empty($traders[$index]['cultures'])){
//                unset($traders[$index]);
//            }
//        }
//
//        $traders = array_values($traders);
//
//        return $traders;
//    }
}
