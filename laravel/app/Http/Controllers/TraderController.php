<?php

namespace App\Http\Controllers;



use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersPortsLang;
use App\Models\Traders\TradersProducts;

use App\Services\BaseServices;
use App\Services\CompanyService;
use App\Services\SeoService;
use App\Services\Traders\TraderService;
use Illuminate\Http\Request;

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
        parent::__construct();
        $this->traderService = $traderService;
        $this->companyService = $companyService;
        $this->baseService = $baseService;
        $this->seoService = $seoService;
    }

    public function indexRedirect(){
        return redirect('/traders/region_ukraine');
    }

    public function checkName($region = null, $port = null)
    {
        $name = null;
        $onlyPorts = null;

        if($region != null){
            if($region == 'ukraine'){
                $name = 'Вся Украина';
            }elseif ($region == 'crimea'){
                $name = 'АР Крым';
            }
        }else{
            $port_name = TradersPorts::where('url', $port)->value('id');
            if($port == 'all'){
                $name = 'Все порты';
                $onlyPorts = 'yes';
            }else{
                $name = TradersPortsLang::where('port_id', $port_name)->value('portname');
            }
        }

        return ['name' => $name, 'onlyPorts' => $onlyPorts];

    }
    public function index(Request $request, $region)
    {
//        $banners = [];
//        $top = BannerRotate::/*where('dt_start', Carbon::now())
//                        ->where('dt_end', Carbon::now())*/
//                        where('archive', 0)
//                        ->where('inrotate', 1)
//                        ->where('place_id', 43)
//                        ->limit(3)
//                        ->get()
//                        ->toArray();
//        $bottom = BannerRotate::/*where('dt_start', Carbon::now())
//                        ->where('dt_end', Carbon::now())*/
//                        where('archive', 0)
//                        ->where('inrotate', 1)
//                        ->where('place_id', 10)
//                        ->limit(1)
//                        ->get()
//                        ->toArray();
//        $body = BannerRotate::/*where('dt_start', Carbon::now())
//                        ->where('dt_end', Carbon::now())*/
//                        where('archive', 0)
//                        ->where('inrotate', 1)
//                        ->where('place_id', 44)
//                        ->limit(1)
//                        ->get()
//                        ->toArray();
//        $header = BannerRotate::/*where('dt_start', Carbon::now())
//                        ->where('dt_end', Carbon::now())*/
//                        where('archive', 0)
//                        ->where('inrotate', 1)
//                        ->where('place_id', 45)
//                        ->limit(1)
//                        ->get()
//                        ->toArray();
//        $traders = BannerRotate::/*where('dt_start', Carbon::now())
//                        ->where('dt_end', Carbon::now())*/
//                        where('archive', 0)
//                        ->where('inrotate', 1)
//                        ->where('place_id', 46)
//                        ->limit(1)
//                        ->get()
//                        ->toArray();
        $search = null;
        $region_name = $this->checkName($region)['name'];
        $current_region = $region;

        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $traders = $this->traderService->getTradersRegionPortCulture(null, null,0, $region);
        $top_traders = $this->traderService->getTradersRegionPortCulture(null, null,1, $region);
        $groups = $this->companyService->getRubricsGroup();
        $data = ['rubric' => null, 'region' => $region, 'port' => null, 'type' => 0, 'page' => 1, 'onlyPorts' => null];
        $meta = $this->seoService->getTradersMeta($data);

        return view('traders.traders_regions',
            [
                'viewmod'=> $request->get('viewmod'),
                'regions' => $regions,
                'top_traders' => $top_traders,
                'traders' => $traders,
                'rubric' => $rubrics,
                'onlyPorts' => $ports,
                'currencies'=> $currencies,
                'meta' => $meta,
                'region_name' => $region_name,
                'current_region' => $current_region,
                'rubricGroups' => $groups
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
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

        $region_name = $this->checkName($region)['name'];
        $current_region = $region;
        $culture_name = TradersProducts::where('url', $culture)->value('id');
        $culture_name = Traders_Products_Lang::where('item_id', $culture_name)->value('name');
        $data = ['rubric' => $culture_name, 'region' => $region, 'port' => null, 'type' => 0, 'page' => 1, 'onlyPorts' => null];
        $meta = $this->seoService->getTradersMeta($data);

        return view('traders.traders_regions_culture', [
            'viewmod'=> $request->get('viewmod'),
            'regions' => $regions,
            'top_traders' => $top_traders,
            'traders' => $traders,
            'rubric' => $rubrics,
            'onlyPorts' => $ports,
            'currencies'=> $currencies,
            'region_name' => $region_name,
            'current_region' => $current_region,
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

        $port_name = $this->checkName(null, $port)['name'];
        $onlyPorts = $this->checkName(null, $port)['onlyPorts'];
        $current_port = $port;
        $data = ['rubric' => null, 'region' => null, 'port' => $port_name, 'type' => 0, 'page' => 1, 'onlyPorts' => $onlyPorts];
        $meta = $this->seoService->getTradersMeta($data);

        return view('traders.traders_port', [
            'viewmod'=> $request->get('viewmod'),
            'regions' => $regions,
            'top_traders' => $top_traders,
            'traders' => $traders,
            'rubric' => $rubrics,
            'onlyPorts' => $ports,
            'currencies'=> $currencies,
            'meta' => $meta,
            'port_name' => $port_name,
            'current_port' => $current_port,
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

        $port_name = $this->checkName(null, $port)['name'];
        $onlyPorts = $this->checkName(null, $port)['onlyPorts'];
        $current_port = $port;
        $culture_name = TradersProducts::where('url', $culture)->value('id');
        $culture_name = Traders_Products_Lang::where('item_id', $culture_name)->value('name');

        $data = ['rubric' => $culture_name, 'region' => null, 'port' => $port_name, 'type' => 0, 'page' => 1, 'onlyPorts' => $onlyPorts];
        $meta = $this->seoService->getTradersMeta($data);

        return view('traders.traders_port_culture', [
            'viewmod'=> $request->get('viewmod'),
            'regions' => $regions,
            'top_traders' => $top_traders,
            'traders' => $traders,
            'rubric' => $rubrics,
            'onlyPorts' => $ports,
            'currencies'=> $currencies,
            'port_name' => $port_name,
            'current_port' => $current_port,
            'current_culture' => $culture,
            'culture_name' => $culture_name,
            'meta' => $meta
        ]);

    }


    public function forwards() {
        dd('forwards');
    }


}
