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
            $route_params = ['region' => $request->get('region'), 'currency' => $request->get('currency')];
        }

        if(!empty($request->get('port'))){
            $route_name = 'traders.traders_port';
            $route_params = ['port' => $request->get('port'), 'currency' => $request->get('currency')];
        }

        if(!empty($request->get('region')) && !empty($request->get('rubric'))){
            $route_name = 'traders.traders_regions_culture';
            $route_params = [$request->get('region'), $request->get('rubric'), 'currency' => $request->get('currency')];
        }

        if(!empty($request->get('port')) && !empty($request->get('rubric'))){
            $route_name = 'traders.traders_port_culture';
            $route_params = ['port' => $request->get('port'), 'culture' => $request->get('rubric'), 'currency' => $request->get('currency')];
        }

       return redirect()->route($route_name, $route_params);
    }


    public function setDataForTraders($data)
    {
        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseServices->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();

        $traders = isset($data['forwards']) ? $this->traderService->getTradersForward($data['region'], $data['culture']) :
            $this->traderService->getTradersRegionPortCulture(['port' => $data['port'],
                'culture' => $data['culture'], 'region' => $data['region'], 'query' => $data['query']]);


        $currency = isset($data['query']['currency']) ? $data['query']['currency'] : null;
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

        if (!empty($culture)) {
            $culture_meta = Traders_Products_Lang::where('item_id', $culture[0]['id'])->get()->toArray()[0];
            $culture_name = $culture_meta['name'];
        }else {
            $culture_name = 'Выбрать продукцию';
        }

        $meta = $this->seoService->getTradersMeta(['rubric' => $culture_meta, 'region' => $region_all,
            'port' => $port_all, 'type' => 0, 'page' => 1, 'onlyPorts' => $this->traderService->getNamePortRegion(null, $data['port'])['onlyPorts']]);

        $breadcrumbs = $this->baseServices->setBreadcrumbsTraders([
            'region_translit' => $data['region'],
            'port_translit' => $data['port'],
            'region' => $region_all,
            'port' => $port_all,
            'culture' => $data['culture'],
            'culture_id' => $culture_id,
            'culture_name' =>  !empty($culture) ? $culture[0]['culture']['name'] : null]);

        return view('traders.traders', [
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
            'group_id' => !empty($culture) ? $culture[0]['group_id'] : '',
            'currency' => $currency,
            'culture_id' => $culture_id,
            'isMobile' => $this->agent->isMobile(),
            'rubricGroups' => $rubrics,
            'page_type' => 1,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }


    public function index(Request $request, $region)
    {
        $data_traders = ['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => null];
        $necessaryData = $this->setDataForTraders($data_traders);

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
           return $this->mobileFilter($request);
        }

        if($necessaryData){
            return $necessaryData;
        }

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
        $data_traders = ['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => $culture];
        $necessaryData = $this->setDataForTraders($data_traders);

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->mobileFilter($request);
        }

        if($necessaryData){
            return $necessaryData;
        }
    }

    public function port(Request $request, $port)
    {
        $data_traders = ['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => null];
        $necessaryData = $this->setDataForTraders($data_traders);

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->mobileFilter($request);
        }

        if($necessaryData){
            return $necessaryData;
        }

    }


    public function portCulture(Request $request, $port, $culture)
    {
        $data_traders = ['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => $culture];
        $necessaryData = $this->setDataForTraders($data_traders);

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->mobileFilter($request);
        }

        if($necessaryData){
            return $necessaryData;
        }
    }

    public function forwards($region)
    {
        $region_name = $this->traderService->getNamePortRegion($region,null)['region'];
        $traders = $this->traderService->getTradersForward($region, null);

        return view('traders.trader_forwards', [
            'region_name' => $region_name,
            'region' => $region,
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 1,
        ]);
    }

    public function forwardsCulture($region, $culture)
    {
        $data_traders = ['region' => $region, 'query' => null, 'port' => null, 'culture' => $culture, 'forwards' => true];
        $necessaryData = $this->setDataForTraders($data_traders);

        if($necessaryData){
            return $necessaryData;
        }

    }

    public function sellRegion($region)
    {
        return view('traders.sell.sell_region', [
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 1,
        ]);
    }

    public function sellCulture($region, $culture)
    {
        return view('traders.sell.sell_culture', [
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 1,
        ]);
    }

}
