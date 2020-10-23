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




    public function index(Request $request, $region)
    {
        $data_region = $this->traderService->getNamePortRegion($region);

        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();


        $traders = $this->traderService->getTradersRegionPortCulture(['port' => null, 'culture' => null, 'region' => $region, 'query' => $request->all()]);

        $groups = $this->companyService->getRubricsGroup();


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
                'rubricGroups' => $groups,
                'group_culture_id' => null
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
            'group_culture_id' => $group_culture_id
        ]);

    }

    public function port(Request $request, $port)
    {

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
            'current_port' => $port,
        ]);
    }


    public function portCulture(Request $request, $port, $culture)
    {
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
            'meta' => $meta
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
