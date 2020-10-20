<?php

namespace App\Http\Controllers;


use App\Models\Comp\CompItems;
use App\Models\Regions\Regions;
use App\Models\Traders\Traders;
use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersLang;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersPortsLang;
use App\Models\Traders\TradersPrices;
use App\Models\Traders\TradersPricesArc;
use App\Models\Traders\TradersProducts;
use App\Models\TradersComment;
use App\Models\TradersFilters;

use App\Models\Comp\CompTopic;

use App\Services\BaseServices;
use App\Services\CompanyService;
use App\Services\SeoService;
use App\Services\Traders\TraderService;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\TestFixture\C;

class TraderController extends Controller
{
    protected $traderService;
    protected $companyService;
    protected $baseService;
    protected $seoService;

    /**
     * Remove the specified resource from storage.
     *
     * @param TraderService $traderService
     * @param CompanyService $companyService
     * @param BaseServices $baseService
     * @param SeoService $seoService
     */
    public function __construct(TraderService $traderService, CompanyService $companyService, BaseServices $baseService, SeoService $seoService)
    {
        $this->traderService = $traderService;
        $this->companyService = $companyService;
        $this->baseService = $baseService;
        $this->seoService = $seoService;
    }

    public function index_redirect(){
        return redirect('/traders/region_ukraine');
    }


    public function index(Request $request, $region)
    {
        $search = null;
        $unwanted_region = false;

        if($region == 'ukraine' or $region == 'crimea'){
            $unwanted_region = true;
        }

        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $top_traders = $this->traderService->getTradersRegionPortCulture(null, null,1, $region);
        $traders = $this->traderService->getTradersRegionPortCulture(null, null,0, $region);

        $currently_region = Regions::where('translit', $region)->value('name');

        return view('traders.traders_regions',
            [
                'viewmod'=> $request->get('viewmod'),
                'regions' => $regions,
                'top_traders' => $top_traders,
                'traders' => $traders,
                'rubric' => $rubrics,
                'onlyPorts' => $ports,
                'currently_region' => $currently_region,
                'unwanted_region' => $unwanted_region,
                'currencies'=> $currencies,
            ]
        );
    }

    public function port(Request $request, $port)
    {
        $search = null;
        $unwanted_region = false;

        if($port == 'all'){
            $unwanted_region = true;
        }

        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $top_traders = $this->traderService->getTradersRegionPortCulture($port, null, 1, null);
        $traders = $this->traderService->getTradersRegionPortCulture($port, null, 0, null);

        $currently_region = TradersPorts::where('url', $port)->value('id');
        $currently_region = TradersPortsLang::where('port_id', $currently_region)->value('portname');


        return view('traders.traders_port', [
            'viewmod'=> $request->get('viewmod'),
            'regions' => $regions,
            'top_traders' => $top_traders,
            'traders' => $traders,
            'rubric' => $rubrics,
            'onlyPorts' => $ports,
            'currencies'=> $currencies,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $region
     * @param  string  $culture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function region_and_culture(Request $request, $region, $culture)
    {
        $search = null;
        $unwanted_region = false;

        if($region == 'ukraine' or $region == 'crimea'){
            $unwanted_region = true;
        }

        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $top_traders = $this->traderService->getTradersRegionPortCulture(null, $culture, 1, $region);
        $traders = $this->traderService->getTradersRegionPortCulture(null, $culture, 0, $region);

        $currently_region = Regions::where('translit', $region)->value('name');
        $culture = TradersProducts::where('url', $culture)->value('id');

        return view('traders.traders_regions_culture', [
            'viewmod'=> $request->get('viewmod'),
            'regions' => $regions,
            'top_traders' => $top_traders,
            'traders' => $traders,
            'rubric' => $rubrics,
            'onlyPorts' => $ports,
            'currencies'=> $currencies,
        ]);

        //$this->seoService->getTradersMeta();
    }


    public function port_and_culture(Request $request, $port, $culture)
    {
        $search = null;
        $unwanted_region = false;

        if($port == 'all'){
            $unwanted_region = true;
        }

        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $top_traders = $this->traderService->getTradersRegionPortCulture($port, $culture, 1, null);
        $traders = $this->traderService->getTradersRegionPortCulture($port, $culture, 0, null);

        $currently_region = TradersPorts::where('url', $port)->value('id');
        $currently_region = TradersPortsLang::where('port_id', $currently_region)->value('portname');
        $culture = TradersProducts::where('url', $culture)->value('id');

        return view('traders.traders_port_culture', [
            'viewmod'=> $request->get('viewmod'),
            'regions' => $regions,
            'top_traders' => $top_traders,
            'traders' => $traders,
            'rubric' => $rubrics,
            'onlyPorts' => $ports,
            'currencies'=> $currencies,
        ]);

    }





    public function forwards() {
        dd('forwards');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
