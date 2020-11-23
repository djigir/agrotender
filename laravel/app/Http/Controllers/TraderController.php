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
use Illuminate\Support\Facades\App;

class TraderController extends Controller
{
    const TYPE_REGION = 0;
    const TYPE_PORT = 2;


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


    public function setDataForTraders($data)
    {
        $forward_months = $this->baseServices->getForwardsMonths();
        $regions = $this->baseServices->getRegions();
        $ports = $this->traderService->getPorts();
        $currencies = $this->traderService->getCurrencies();

        $culture_meta = null;
        $currency = isset($data->get('query')['currency']) ? $data->get('query')['currency'] : null;
        $region_all = $data->get('region');
        $port_all = $data->get('port');
        $culture_name = 'Выбрать продукцию';
        $type_place = $data->get('region') != null ? self::TYPE_REGION : self::TYPE_PORT;

        if($data->get('port') != 'all' && $data->get('port')) {
            $id_port = TradersPorts::where('url', $data->get('port'))->value('id');

            if(!$id_port) {
                App::abort(404);
            }

            $port_all = TradersPortsLang::where('port_id', $id_port)->first();
        }

        if($data->get('region') != 'ukraine' && $data->get('region')) {
            $id_region = Regions::where('translit', $data->get('region'))->value('id');

            if(!$id_region) {
                App::abort(404);
            }

            $region_all = Regions::where('id', $id_region)->first();
        }

        $region_port_name = !empty($data->get('region')) ? $this->getNamePortRegion($data->get('region'))['region']
            : $this->getNamePortRegion(null, $data->get('port'))['port'];

        $culture = TradersProducts::where('url', $data->get('culture'))->with('traders_product_lang')->first();

        $culture_id = !empty($culture) ? TradersProductGroupLanguage::where('id', $culture[0]['id'])->value('id') : null;

        if (!empty($culture))
        {
            $culture_meta = Traders_Products_Lang::where('item_id', $culture->id)->first();
            $culture_name = $culture_meta->name;
        }

        $meta = $this->seoService->getTradersMeta([
            'rubric' => $culture_meta, 'region' => $region_all,
            'port' => $port_all, 'type' => 0, 'page' => 1,
            'onlyPorts' => $this->getNamePortRegion(null, $data->get('port'))['onlyPorts']]);

        if ($data->get('type') == 'forward')
        {
            $meta = $this->seoService->getTradersMetaForward($region_all, $culture_meta, $port_all);
        }

        $data_breadcrumbs =  [
            'region_translit' => $data->get('region'),
            'port_translit' => $data->get('port'),
            'region' => $region_all,
            'port' => $port_all,
            'culture' => $data->get('culture'),
            'culture_id' => $culture_id,
            'culture_name' =>  !empty($culture)? $culture->traders_product_lang[0]->name : null
        ];

        $data_traders = $this->traderService->setTradersBreadcrumbs($data, $data_breadcrumbs);
        $rubrics = $this->traderService->getRubricsGroup();

        return view('traders.traders', [
            'regions' => $regions,
            'traders' => $data_traders['traders'],
            'topTraders' => $data_traders['top_traders']->count() > 0 ? $data_traders['top_traders'] : [],
            'onlyPorts' => $ports,
            'currencies' => $currencies,
            'region_port_name' => $region_port_name,
            'region' => $data->get('region'),
            'port' => $data->get('port'),
            'culture_translit' => $data->get('culture'),
            'culture_name' => $culture_name,
            'meta' => $meta,
            'forward_months' => $forward_months,
            'group_id' => !empty($culture) ? $culture[0]['group_id'] : '',
            'currency' => $currency,
            'culture_id' => $culture_id,
            'isMobile' => $this->agent->isMobile(),
            'rubricGroups' => $rubrics,
            'page_type' => 1,
            'type_place' => $type_place,
            'breadcrumbs' => $data_traders['breadcrumbs'],
            'type_traders' => $data_traders['type_traders'],
            'type_view' => $data['type_view'],
            'feed' =>  $data_traders['type_traders'] == 0 ? $this->traderFeedService->getFeed() : []
        ]);
    }


    /**
     * @param  Request  $request
     * @param $region
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request, $region)
    {
        $data_traders = collect(['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => null, 'type' => '', 'type_view' => 'card']);

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
        $data_traders = collect(['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => $culture, 'type' => '', 'type_view' => 'table']);

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
        $data_traders = collect(['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => null, 'type' => '', 'type_view' => 'card']);

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
        $data_traders = collect(['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => $culture, 'type' => '', 'type_view' => 'table']);

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }

    public function forwardsRegion(Request $request, $region)
    {
        $data_traders = collect(['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => null, 'type' => 'forward', 'forwards' => true, 'type_view' => 'card']);

        if(!empty($request->get('region')) || !empty($request->get('port')))
        {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }

    public function forwardsPort(Request $request, $port)
    {
        $data_traders = collect(['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => null, 'type' => 'forward', 'forwards' => true, 'type_view' => 'card']);

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
        $data_traders = collect(['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => $culture, 'forwards' => true, 'type' => 'forward', 'type_view' => 'table']);

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
        $data_traders = collect(['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => $culture, 'forwards' => true, 'type' => 'forward', 'type_view' => 'table']);

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
        $data_traders = collect(['region' => $region, 'query' => $request->all(), 'port' => null, 'culture' => null, 'sell' => true, 'type' => 'sell', 'type_view' => 'card']);


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
        $data_traders = collect(['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => null, 'sell' => true, 'type' => 'sell', 'type_view' => 'card']);


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
        $data_traders = collect(['region' => $region, 'query' => $request->all(),
            'port' => null, 'culture' => $culture, 'sell' => true, 'type' => 'sell', 'type_view' => 'card']);

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
        $data_traders = collect(['region' => null, 'query' => $request->all(), 'port' => $port, 'culture' => $culture, 'sell' => true, 'type' => 'sell', 'type_view' => 'card']);

        if (!empty($request->get('port')) || !empty($request->get('port'))) {
            return $this->traderService->mobileFilter($request);
        }

        return $this->setDataForTraders($data_traders);
    }

}
