<?php

namespace App\Http\Controllers;


use App\Models\Regions\Regions;
use App\Models\Traders\TraderFeed;
use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersPortsLang;
use App\Models\Traders\TradersProductGroupLanguage;
use App\Models\Traders\TradersPrices;
use App\Models\Traders\TradersProducts;
use App\Services\BaseServices;
use App\Services\CompanyService;
use App\Services\SeoService;
use App\Services\Traders\TraderFeedService;
use App\Services\Traders\TraderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TraderController extends Controller
{
    protected $traderService;
    protected $companyService;
    protected $baseServices;
    protected $seoService;
    protected $traderFeedService;
    protected $agent;

    /**
     * Remove the specified resource from storage.
     *
     * @param  TraderService  $traderService
     * @param  CompanyService  $companyService
     * @param  BaseServices  $baseServices
     * @param  SeoService  $seoService
     * @param  TraderFeedService  $traderFeedService
     */
    public function __construct(
        TraderService $traderService,
        CompanyService $companyService,
        BaseServices $baseServices,
        SeoService $seoService,
        TraderFeedService $traderFeedService
    ) {
        parent::__construct();
        $this->traderService = $traderService;
        $this->companyService = $companyService;
        $this->baseServices = $baseServices;
        $this->seoService = $seoService;
        $this->traderFeedService = $traderFeedService;
        $this->agent = new \Jenssegers\Agent\Agent;
    }


    public function mobileFilter(Request $request)
    {
        $route_name = null;
        $route_params = null;

        if(!empty($request->get('region'))){
            $route_name = 'traders.traders_regions';
            $route_params = ['region' => $request->get('region')];
        }

        if(!empty($request->get('port'))){
            $route_name = 'traders.traders_port';
            $route_params = ['port' => $request->get('port')];
        }

        if(!empty($request->get('region')) && !empty($request->get('rubric'))){
            $route_name = 'traders.traders_regions_culture';
            $route_params = [$request->get('region'), $request->get('rubric')];
        }

        if(!empty($request->get('port')) && !empty($request->get('rubric'))){
            $route_name = 'traders.traders_port_culture';
            $route_params = ['port' => $request->get('port'), 'culture' => $request->get('rubric')];
        }

       return redirect()->route($route_name, $route_params);
    }


    public function setDataForTraders($data)
    {
        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseServices->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $traders = $this->traderService->getTradersRegionPortCulture(['port' => $data['port'],
            'culture' => $data['culture'], 'region' => $data['region'], 'query' => $data['query']]);


        $region_all = $data['region'];
        $port_all = $data['port'];

        if($data['region'] != 'ukraine' && $data['region']) {
            $region_all = Regions::where('translit', $data['region'])->get()->toArray()[0];
        }

        if($data['port'] != 'all' && $data['port']) {
            $id_port = TradersPorts::where('url', $data['port'])->value('id');
            $port_all = TradersPortsLang::where('port_id', $id_port)->get()->toArray()[0];
        }

        $region_port_name = !empty($data['region']) ? $this->traderService->getNamePortRegion($data['region'])['region']
        : $this->traderService->getNamePortRegion(null, $data['port'])['port'];

        $culture = TradersProducts::where('url', $data['culture'])->get()->toArray();

        $culture_id = !empty($culture) ? TradersProductGroupLanguage::where('id', $culture[0]['id'])->value('id') : null;

        $culture_name = !empty($culture) ? Traders_Products_Lang::where('item_id', $culture[0]['id'])->value('name') :
            'Выбрать продукцию';
        $meta = $this->seoService->getTradersMeta(['rubric' => !empty($culture) ? $culture : null, 'region' => $region_all,
            'port' => $port_all, 'type' => 0, 'page' => 1, 'onlyPorts' => $this->traderService->getNamePortRegion(null, $data['port'])['onlyPorts']]);

        $breadcrumbs = $this->baseServices->setBreadcrumbsTraders([
            'region_translit' => $data['region'],
            'port_translit' => $data['port'],
            'region' => $region_all,
            'port' => $port_all,
            'culture' => $data['culture'],
            'culture_id' => $culture_id,
            'culture_name' =>  !empty($culture) ? $culture[0]['culture']['name'] : null]);

        return view('traders.traders_regions', [
//            'viewmod' => $request->get('viewmod'),
            'regions' => $regions,
            'traders' => $traders,
            'onlyPorts' => $ports,
            'currencies' => $currencies,
            'region_port_name' => $region_port_name,
            'region' => $data['region'],
            'port' => $data['port'],
            'culture_translit' => $data['culture'],
            'culture_name' => $culture_name,
            'meta' => $meta,
            'culture_id' => $culture_id,
            'isMobile' => $this->agent->isMobile(),
            'rubricGroups' => $rubrics,
            'page_type' => 1,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }


    public function index(Request $request, $region)
    {
        $data_region = $this->traderService->getNamePortRegion($region);

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
           return $this->mobileFilter($request);
        }

        $data_traders = ['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => null];
        $necessaryData = $this->setDataForTraders($data_traders);

        if($necessaryData){
            return $necessaryData;
        }

        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseServices->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();

        $traders = $this->traderService->getTradersRegionPortCulture(['port' => null, 'culture' => null, 'region' => $region, 'query' => $request->all()]);
        $groups = $this->companyService->getRubricsGroup();

        //$this->baseService->setBreadcrumbs(['region' => $data_region['region'], 'page_type' => 1]);


        $data = ['rubric' => null, 'region' => $region, 'port' => null, 'type' => 0, 'page' => 1, 'onlyPorts' => null];

        $meta = $this->seoService->getTradersMeta($data);

        return view('traders.traders_regions',
            [
                'viewmod' => $request->get('viewmod'),
                'regions' => $regions,
                'traders' => $traders,
                'rubric' => $rubrics,
                'onlyPorts' => $ports,
                'currencies' => $currencies,
                'meta' => $meta,
                'region_name' => $data_region['region'],
                'current_region' => $region,
                'rubricGroups' => $rubrics,
                'group_culture_id' => null,
                'isMobile' => $this->agent->isMobile(),
                'page_type' => 1,
                'breadcrumbs' => $meta['h1']
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  string  $region
     * @param  string  $culture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function regionCulture(Request $request, $region, $culture)
    {
        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->mobileFilter($request);
        }

        $data_traders = ['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => $culture];
        $necessaryData = $this->setDataForTraders($data_traders);

        if($necessaryData){
            return $necessaryData;
        }


        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseServices->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $traders = $this->traderService->getTradersRegionPortCulture(['port' => null, 'culture' => $culture, 'region' => $region, 'query' => $request->all()]);

        $region_name = $this->traderService->getNamePortRegion($region);

        $culture_name = TradersProducts::where('url', $culture)->value('id');
        $culture_name = Traders_Products_Lang::where('item_id', $culture_name)->get()->toArray()[0];


        $group_culture_id = TradersProducts::where('id', $culture_name['item_id'])->value('group_id');
        $group_culture_id = TradersProductGroupLanguage::where('id', $group_culture_id)->value('id');

        $data = [
            'rubric' => $culture_name['name'], 'region' => $region, 'port' => null, 'type' => 0, 'page' => 1,
            'onlyPorts' => null
        ];

        //$bread = $this->baseService->setBreadcrumbs(['region' => $region, 'rubric' => $culture, 'page_type' => 1]);

        $meta = $this->seoService->getTradersMeta($data);


        return view('traders.traders_regions_culture', [
            'viewmod' => $request->get('viewmod'),
            'regions' => $regions,
            'traders' => $traders,
            'rubric' => $rubrics,
            'onlyPorts' => $ports,
            'currencies' => $currencies,
            'region_name' => $region_name['region'],
            'current_region' => $region,
            'current_culture' => $culture,
            'culture_name' => $culture_name['name'],
            'meta' => $meta,
            'group_culture_id' => $group_culture_id,
            'isMobile' => $this->agent->isMobile(),
            'rubricGroups' => $rubrics,
            'page_type' => 1
        ]);

    }

    public function port(Request $request, $port)
    {
        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->mobileFilter($request);
        }

        $data_traders = ['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => null];
        $necessaryData = $this->setDataForTraders($data_traders);

        if($necessaryData){
            return $necessaryData;
        }

        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseServices->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $traders = $this->traderService->getTradersRegionPortCulture(['port' => $port, 'culture' => null, 'region' => null, 'query' => $request->all()]);

        $data_port = $this->traderService->getNamePortRegion(null, $port);

        $data = [
            'rubric' => null, 'region' => null, 'port' => $data_port['port'], 'type' => 0, 'page' => 1,
            'onlyPorts' => $data_port['onlyPorts']
        ];

        //$bread = $this->baseService->setBreadcrumbs(['port' => $port, 'page_type' => 1]);

        $meta = $this->seoService->getTradersMeta($data);

        return view('traders.traders_port', [
            'viewmod' => $request->get('viewmod'),
            'regions' => $regions,
            'traders' => $traders,
            'rubric' => $rubrics,
            'onlyPorts' => $ports,
            'currencies' => $currencies,
            'meta' => $meta,
            'port_name' => $data_port['port'],
            'isMobile' => $this->agent->isMobile(),
            'current_port' => $port,
            'rubricGroups' => $rubrics,
            'page_type' => 1
        ]);
    }


    public function portCulture(Request $request, $port, $culture)
    {
        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->mobileFilter($request);
        }

        $data_traders = ['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => $culture];
        $necessaryData = $this->setDataForTraders($data_traders);

        if($necessaryData){
            return $necessaryData;
        }

        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseServices->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $traders = $this->traderService->getTradersRegionPortCulture(['port' => $port, 'culture' => $culture, 'region' => null, 'query' => $request->all()]);

        $data_port = $this->traderService->getNamePortRegion(null, $port);


        $culture_name = TradersProducts::where('url', $culture)->value('id');
        $culture_name = Traders_Products_Lang::where('item_id', $culture_name)->value('name');

        $data = [
            'rubric' => $culture_name, 'region' => null, 'port' => $data_port['port'], 'type' => 0, 'page' => 1,
            'onlyPorts' => $data_port['onlyPorts']
        ];

        $meta = $this->seoService->getTradersMeta($data);

        //$data_traders = ['rubric' => $culture, 'port' => $port, 'page_type' => 1];
        //$bread = $this->baseService->breadcrumbs($data_traders);

        return view('traders.traders_port_culture', [
            'viewmod' => $request->get('viewmod'),
            'regions' => $regions,
            'traders' => $traders,
            'rubric' => $rubrics,
            'onlyPorts' => $ports,
            'currencies' => $currencies,
            'port_name' => $data_port['port'],
            'current_port' => $port,
            'current_culture' => $culture,
            'culture_name' => $culture_name,
            'isMobile' => $this->agent->isMobile(),
            'meta' => $meta,
            'rubricGroups' => $rubrics,
            'page_type' => 1
        ]);

    }

    public function forwards()
    {
        return view('traders.trader_forwards');
    }

    public function forwardsCulture()
    {
        return view('traders.trader_forwards_culture');
    }

    public function sellRegion()
    {
        return view('traders.sell.sell_region');
    }

    public function sellCulture()
    {
        return view('traders.sell.sell_culture');
    }

}
