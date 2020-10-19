<?php

namespace App\Http\Controllers;


use App\Models\Comp\CompItems;
use App\Models\Traders\Traders;
use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersLang;
use App\Models\Traders\TradersPrices;
use App\Models\Traders\TradersPricesArc;
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
     * @param  TraderService  $traderService
     * @param  CompanyService  $companyService
     * @param  BaseServices  $baseService
     */
    public function __construct(TraderService $traderService, CompanyService $companyService, BaseServices $baseService, SeoService $seoService)
    {
        $this->traderService = $traderService;
        $this->companyService = $companyService;
        $this->baseService = $baseService;
        $this->seoService = $seoService;
    }

    public function index(){
        return redirect('/traders/region_ukraine');
    }


    public function region(Request $request, $region)
    {
        $rubrics = $this->traderService->getRubricsGroup();
        $regions = $this->baseService->getRegions();
        $ports = $this->traderService->getPorts();

        /** Вынести лишнее в сервис */
        $top_traders = CompItems::
            where([['trader_price_avail', 1], ['trader_price_visible', 1], ['visible', 1], ['trader_premium', 1]])
            ->groupBy('id')
            ->select('id', 'title', 'author_id', 'logo_file')
            ->get()
            ->toArray();
        /** Обернуть в метод */
        foreach ($top_traders as $index => $top_trader) {
            $top_traders[$index]['cultures'] = [];
            $top_traders[$index]['cultures'] = $this->companyService->getPortsRegionsCulture($top_trader['id'], 0);
            if (empty($top_traders[$index]['cultures'] = $this->companyService->getPortsRegionsCulture($top_trader['id'], 0))){
                unset($top_traders[$index]);
            }
        }

        $traders = CompItems::
            where([['trader_price_avail', 1], ['trader_price_visible', 1], ['visible', 1], ['trader_premium', 0]])
            ->select('id', 'title', 'author_id', 'logo_file')
            ->groupBy('id')
            ->get()
            ->toArray();;

        foreach ($traders as $index => $trader) {
            $traders[$index]['cultures'] = [];
            $traders[$index]['cultures'] = $this->companyService->getPortsRegionsCulture($trader['id'], 0);
            if (empty($traders[$index]['cultures'] = $this->companyService->getPortsRegionsCulture($trader['id'], 0))){
                unset($traders[$index]);
            }

        }

        $top_traders = array_values($top_traders);
        $traders = array_values($traders);

//        dd($traders);

        $this->seoService->getTradersMeta();


        return view('traders.traders_regions',
            [
                'viewmod'=>$request->get('viewmod'),
                'section' => 'section',
                'regions' => $regions,
                'top_traders' => $top_traders,
                'traders' => $traders,
                'rubric' => $rubrics,
                'onlyPorts' => $ports,

                'currencies'=>[
                    'uah' => [
                        'id'   => 0,
                        'name' => 'Гривна',
                        'code' => 'uah'
                    ],
                    'usd' => [
                        'id'   => 1,
                        'name' => 'Доллар',
                        'code' => 'usd'
                    ]
                ],
            ]
        );
    }

    public function port_and_culture($port, $culture)
    {
        //$this->seoService->getTradersMeta(null, null, );
        dd($port, $culture);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $region
     * @param  string  $culture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function region_and_culture($region, $culture)
    {
        dd($region, $culture);

        $this->seoService->getTradersMeta();

        return view('traders.traders_regions_culture');
    }


    public function port($port_name)
    {
        return view('traders.traders_regions_culture');
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
