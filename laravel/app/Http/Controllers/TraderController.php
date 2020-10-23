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
    protected $baseService;
    protected $seoService;
    protected $traderFeedService;
    protected $agent;

    /**
     * Remove the specified resource from storage.
     *
     * @param  TraderService  $traderService
     * @param  CompanyService  $companyService
     * @param  BaseServices  $baseService
     * @param  SeoService  $seoService
     * @param  TraderFeedService  $traderFeedService
     */
    public function __construct(
        TraderService $traderService,
        CompanyService $companyService,
        BaseServices $baseService,
        SeoService $seoService,
        TraderFeedService $traderFeedService
    ) {
        parent::__construct();
        $this->traderService = $traderService;
        $this->companyService = $companyService;
        $this->baseService = $baseService;
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

    public function index(Request $request, $region)
    {
        $data_region = $this->traderService->getNamePortRegion($region);

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
           return $this->mobileFilter($request);
        }


        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $traders = $this->traderService->getTradersRegionPortCulture(['port' => null, 'culture' => null, 'region' => $region, 'query' => $request->all()]);

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
                'page_type' => 1
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
        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
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
        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $traders = $this->traderService->getTradersRegionPortCulture(['port' => $port, 'culture' => null, 'region' => null, 'query' => $request->all()]);

        $data_port = $this->traderService->getNamePortRegion(null, $port);

        $data = [
            'rubric' => null, 'region' => null, 'port' => $data_port['port'], 'type' => 0, 'page' => 1,
            'onlyPorts' => $data_port['onlyPorts']
        ];

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
        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
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
        dd('forwards');
    }

    public function sell_region()
    {
        dd('sell');
    }

}
