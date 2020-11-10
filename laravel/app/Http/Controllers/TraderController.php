<?php

namespace App\Http\Controllers;


use App\Models\Regions\Regions;
use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersPortsLang;
use App\Models\Traders\TradersProductGroupLanguage;
use App\Models\Traders\TradersProducts;
use App\Services\BaseServices;
use App\Services\BreadcrumbService;
use App\Services\CompanyService;
use App\Services\SeoService;
use App\Services\Traders\TraderFeedService;
use App\Services\Traders\TraderService;
use Illuminate\Http\Request;

class TraderController extends Controller
{
    protected $traderService;
    protected $companyService;
    protected $baseServices;
    protected $breadcrumbService;
    protected $seoService;
    protected $traderFeedService;
    protected $agent;

    /**
     * Remove the specified resource from storage.
     *
     * @param TraderService $traderService
     * @param CompanyService $companyService
     * @param BaseServices $baseServices
     * @param BreadcrumbService $breadcrumbService
     * @param SeoService $seoService
     * @param TraderFeedService $traderFeedService
     */
    public function __construct(
        TraderService $traderService,
        CompanyService $companyService,
        BaseServices $baseServices,
        BreadcrumbService $breadcrumbService,
        SeoService $seoService,
        TraderFeedService $traderFeedService
    ) {
        parent::__construct();
        $this->traderService = $traderService;
        $this->companyService = $companyService;
        $this->baseServices = $baseServices;
        $this->breadcrumbService = $breadcrumbService;
        $this->seoService = $seoService;
        $this->traderFeedService = $traderFeedService;
        $this->agent = new \Jenssegers\Agent\Agent;
    }


    public function setDataForTraders($data)
    {
        $regions = $this->baseServices->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();
        $culture_meta = null;
        $currency = isset($data['query']['currency']) ? $data['query']['currency'] : null;
        $region_all = ($data['region'] != 'ukraine' && $data['region']) ? Regions::where('translit', $data['region'])->get()->toArray()[0] : $data['region'];
        $port_all = $data['port'];
        $culture_name = 'Выбрать продукцию';

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
        }

        $meta = $this->seoService->getTradersMeta([
            'rubric' => $culture_meta, 'region' => $region_all,
            'port' => $port_all, 'type' => 0, 'page' => 1,
            'onlyPorts' => $this->traderService->getNamePortRegion(null, $data['port'])['onlyPorts']]);
        if ($data['type'] == 'forward') {
            $meta = $this->seoService->getTradersMetaForward($region_all, $culture_meta, $port_all);
        }elseif ($data['type'] == 'sell') {
            // изменить текстовку
            $meta = $this->seoService->getTradersMeta([
                'rubric' => $culture_meta, 'region' => $region_all,
                'port' => $port_all, 'type' => 0, 'page' => 1,
                'onlyPorts' => $this->traderService->getNamePortRegion(null, $data['port'])['onlyPorts']]);
        }

        $data_breadcrumbs =  [
            'region_translit' => $data['region'],
            'port_translit' => $data['port'],
            'region' => $region_all,
            'port' => $port_all,
            'culture' => $data['culture'],
            'culture_id' => $culture_id,
            'culture_name' =>  !empty($culture) ? $culture[0]['culture']['name'] : null];

        $data_traders = $this->traderService->setTradersBreadcrumbs($data, $data_breadcrumbs);
        $rubrics = $this->traderService->getRubricsGroup();
        
        return view('traders.traders', [
            'regions' => $regions,
            'traders' => $data_traders['traders'],
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
            'breadcrumbs' => $data_traders['breadcrumbs'],
            'type_traders' => $data_traders['type_traders'],
            'type_view' => isset($data['type_view']) ? $data['type_view'] : 'card',
//            'feed' => $data_traders['type_traders'] == 0 ? $this->traderFeedService->getFeed() : []
            'feed' =>  []
        ]);
    }


    /**
     * @param  Request  $request
     * @param $region
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request, $region)
    {

        $data_traders = ['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => null, 'type' => ''];

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
           return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }


    /**
     * @param  Request  $request
     * @param $region
     * @param $culture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function regionCulture(Request $request, $region, $culture)
    {
        $data_traders = ['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => $culture, 'type' => '', 'type_view' => 'table'];

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }


    /**
     * @param  Request  $request
     * @param $port
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function port(Request $request, $port)
    {
        $data_traders = ['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => null, 'type' => ''];

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }


    /**
     * @param  Request  $request
     * @param $port
     * @param $culture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */

    public function portCulture(Request $request, $port, $culture)
    {
        $data_traders = ['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => $culture, 'type' => '', 'type_view' => 'table'];

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }

    public function forwardsRegion(Request $request, $region)
    {
        $data_traders = ['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => null, 'type' => 'forward', 'forwards' => true];

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }

    public function forwardsPort(Request $request, $port)
    {
        $data_traders = ['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => null, 'type' => 'forward', 'forwards' => true];

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);

    }
    /**
     * @param  Request  $request
     * @param $region
     * @param $culture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function forwardsRegionCulture(Request $request, $region, $culture)
    {
        $data_traders = ['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => $culture, 'forwards' => true, 'type' => 'forward', 'type_view' => 'table'];

        if(!empty($request->get('region')) && !empty($request->get('rubric')))
        {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }


    /**
     * @param  Request  $request
     * @param $port
     * @param $culture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function forwardsPortCulture(Request $request, $port, $culture)
    {
        $data_traders = ['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => $culture, 'forwards' => true, 'type' => 'forward', 'type_view' => 'table'];

        if(!empty($request->get('region')) && !empty($request->get('rubric')))
        {
            return $this->traderService->mobileFilter($request);
        }


        return $this->setDataForTraders($data_traders);
    }


    /**
     * @param  Request  $request
     * @param $region
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function sellRegion(Request $request, $region)
    {
        $data_traders = ['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => null, 'sell' => true, 'type' => 'sell'];


        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }


    /**
     * @param  Request  $request
     * @param $port
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function sellPort(Request $request, $port)
    {
        $data_traders = ['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => null, 'sell' => true, 'type' => 'sell'];


        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }


    /**
     * @param  Request  $request
     * @param $region
     * @param $culture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function sellRegionCulture(Request $request, $region, $culture)
    {
        $data_traders = ['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => $culture, 'sell' => true, 'type' => 'sell'];

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }


    /**
     * @param  Request  $request
     * @param $port
     * @param $culture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function sellPortCulture(Request $request, $port, $culture)
    {
        $data_traders = ['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => $culture, 'sell' => true, 'type' => 'sell'];

        if (!empty($request->get('port')) || !empty($request->get('port'))) {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }

}
