<?php

namespace App\Http\Controllers;


use App\Models\Regions\Regions;
use App\Models\Traders\TraderFeed;
use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersPortsLang;
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

    public function index(Request $request, $region)
    {
        $search = null;
        $data_region = $this->getNamePortRegion($region);
        $current_region = $region;

        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $traders = $this->traderService->getTradersRegionPortCulture(null, null, 0, $region);
        $top_traders = $this->traderService->getTradersRegionPortCulture(null, null, 1, $region);
        $groups = $this->companyService->getRubricsGroup();

        //$data_traders = ['region' => $data_region['region'], 'page_type' => 1];
        //$bread = $this->baseService->breadcrumbs($data_traders);

        $data = ['rubric' => null, 'region' => $region, 'port' => null, 'type' => 0, 'page' => 1, 'onlyPorts' => null];

        $meta = $this->seoService->getTradersMeta($data);

        return view('traders.traders_regions',
            [
                'viewmod' => $request->get('viewmod'),
                'regions' => $regions,
                'top_traders' => $top_traders,
                'traders' => $traders,
                'rubric' => $rubrics,
                'onlyPorts' => $ports,
                'currencies' => $currencies,
                'meta' => $meta,
                'region_name' => $data_region['region'],
                'current_region' => $current_region,
                'rubricGroups' => $groups,
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
        $search = null;

        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $top_traders = $this->traderService->getTradersRegionPortCulture(null, $culture, 1, $region);
        $traders = $this->traderService->getTradersRegionPortCulture(null, $culture, 0, $region);

        $region_name = $this->getNamePortRegion($region);

        $culture_name = TradersProducts::where('url', $culture)->value('id');
        $culture_name = Traders_Products_Lang::where('item_id', $culture_name)->value('name');

        $data = [
            'rubric' => $culture_name, 'region' => $region, 'port' => null, 'type' => 0, 'page' => 1,
            'onlyPorts' => null
        ];
        //$data_traders = ['region' => $region, 'rubric' => $culture, 'page_type' => 1];
        //$bread = $this->baseService->breadcrumbs($data_traders);
        $meta = $this->seoService->getTradersMeta($data);


        return view('traders.traders_regions_culture', [
            'viewmod' => $request->get('viewmod'),
            'regions' => $regions,
            'top_traders' => $top_traders,
            'traders' => $traders,
            'rubric' => $rubrics,
            'onlyPorts' => $ports,
            'currencies' => $currencies,
            'region_name' => $region_name['region'],
            'current_region' => $region,
            'current_culture' => $culture,
            'culture_name' => $culture_name,
            'meta' => $meta
        ]);

    }

    public function port(Request $request, $port)
    {
        $search = null;
        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $top_traders = $this->traderService->getTradersRegionPortCulture($port, null, 1, null);
        $traders = $this->traderService->getTradersRegionPortCulture($port, null, 0, null);

        $data_port = $this->getNamePortRegion(null, $port);

        $data = [
            'rubric' => null, 'region' => null, 'port' => $data_port['port'], 'type' => 0, 'page' => 1,
            'onlyPorts' => $data_port['onlyPorts']
        ];

        //$data_traders = ['port' => $port, 'page_type' => 1];
        //$bread = $this->baseService->breadcrumbs($data_traders);

        $meta = $this->seoService->getTradersMeta($data);

        return view('traders.traders_port', [
            'viewmod' => $request->get('viewmod'),
            'regions' => $regions,
            'top_traders' => $top_traders,
            'traders' => $traders,
            'rubric' => $rubrics,
            'onlyPorts' => $ports,
            'currencies' => $currencies,
            'meta' => $meta,
            'port_name' => $data_port['port'],
            'current_port' => $port,
        ]);
    }


    public function portCulture(Request $request, $port, $culture)
    {
        $search = null;
        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $top_traders = $this->traderService->getTradersRegionPortCulture($port, $culture, 1, null);
        $traders = $this->traderService->getTradersRegionPortCulture($port, $culture, 0, null);

        $data_port = $this->getNamePortRegion(null, $port);


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
            'top_traders' => $top_traders,
            'traders' => $traders,
            'rubric' => $rubrics,
            'onlyPorts' => $ports,
            'currencies' => $currencies,
            'port_name' => $data_port['port'],
            'current_port' => $port,
            'current_culture' => $culture,
            'culture_name' => $culture_name,
            'meta' => $meta
        ]);

    }

    public function forwards()
    {
        return view('traders.trader_forwards');
    }

    public function sell_region()
    {
        return view('traders.sell.sell_region');
    }

    public function sell_culture()
    {
        return view('traders.sell.sell_culture');
    }

}
