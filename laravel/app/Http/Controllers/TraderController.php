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

use App\Services\CompanyService;
use App\Services\TraderService;
use Illuminate\Http\Request;

class TraderController extends Controller
{
    protected $traderService;
    protected $companyService;

    /**
     * Remove the specified resource from storage.
     *
     * @param  TraderService  $traderService
     */
    public function __construct(TraderService $traderService, CompanyService $companyService)
    {
        $this->traderService = $traderService;
        $this->companyService = $companyService;
    }

    public function index(){
        return redirect('/traders/region_ukraine');
    }


    public function region(Request  $request, $region)
    {


        /*$query = "
          SELECT tp_l.name as rubric, tpr.id, round(tpr.costval) as price, round(tpr.costval_old) as old_price, tpr.place_id, tpr.curtype as currency, tpr.change_date, $title
            FROM agt_traders_prices as tpr
            inner join agt_traders_products_lang  as tp_l on tp_l.id = tpr.cult_id
            inner join agt_traders_places         as tpl  on tpr.place_id = tpl.id $regionSql $portSql $onlyPortsSql
          WHERE tpr.buyer_id = {$value['author_id']} && tpl.type_id != 1 && tpr.acttype = $typeInt $rubricSql $currencySql
          GROUP BY $groupBy
          ORDER BY tpr.change_date DESC
          LIMIT 2
        ";*/

        // СВЯЗКА ТОВАРА С ЦЕНОЙ БЕЗ УСЛОВИЯ !
        $a = Traders_Products_Lang::with(['traders_prices' => function($query) {
            $query->where('costval', 6200);
        }])->find(14);
        //dd($a);

        //\DB::enableQueryLog();
        $traders2 = CompItems::select('id', 'title', 'logo_file', 'author_id', 'trader_premium')
            ->where('trader_price_avail', 1)
            ->where('trader_price_visible', 1)
            ->where('visible', 1)
            ->with('traders_prices')
            ->groupBy('id')
            ->orderBy('trader_premium', 'desc')
            ->orderBy('trader_sort', 'desc')
            ->orderBy('rate_formula', 'desc')
            ->orderBy('title', 'desc')
            ->first();
            //->get()->toArray();
        //dd(\DB::getQueryLog());
        $change_date_and_dt = TradersPrices::select('change_date', 'dt')->first();

        /*$a = Traders_Products_Lang::select('name')->with(['traders_prices' => function($query) {
            $query->select('id', 'costval', 'costval_old', 'place_id', 'curtype', 'change_date')->where('buyer_id', 62746);
        }])->paginate(20)->toArray()['data'];*/



        $traders = CompItems::select('id', 'title', 'logo_file')->orderBy('id', 'desc')->paginate(10);
        $prices = TradersPricesArc::select('id', 'costval', 'add_date', 'dt')->with('traders_products_lang')->paginate(10)->toArray();
        //$traders2 = CompItems::where('title', 'Escador')->first();
        //$this->traderService->DataForFilter();


        /*
        if($region){
            $traders = $traders->where('region', $region);
        }*/
        /*return view('traders.traders_regions'
//            ,            ['traders'=>$traders->paginate(15)]
        );*/

        $traders = CompItems::select('id', 'title', 'logo_file')->orderBy('id', 'desc')->paginate(10);
        $prices = TradersPricesArc::select('id', 'costval', 'add_date', 'dt')->with('traders_products_lang')->paginate(10)->toArray();


        $rubrics = $this->traderService->getRubricsGroup();
//        $regions = $this->traderService->getRegions();
        $ports = $this->traderService->getPorts();

        return view('traders.traders_regions'
            ,[
                'viewmod'=>$request->get('viewmod'),
                'section' => 'section',
                'traders'=> $traders, //Traders::paginate(20),
                'rubric' => $rubrics,
                'onlyPorts' => $ports,
                'prices' => $prices['data'],
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $region
     * @param  string  $culture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function region_and_culture($region, $culture)
    {
        return view('traders.traders_regions_culture');
    }


    public function port($port_name)
    {
        return view('traders.traders_regions_culture');
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
