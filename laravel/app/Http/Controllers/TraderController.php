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

use App\Services\TraderService;
use Illuminate\Http\Request;

class TraderController extends Controller
{
    protected $traderService;

    /**
     * Remove the specified resource from storage.
     *
     * @param  TraderService  $traderService
     */
    public function __construct(TraderService $traderService)
    {
        $this->traderService = $traderService;
    }

    public function index(){
        return redirect('/traders/region_ukraine');
    }


    public function region(Request  $request, $region)
    {


        /*
         * $query = "
          SELECT tp_l.name as rubric, tpr.id, round(tpr.costval) as price, round(tpr.costval_old) as old_price, tpr.place_id, tpr.curtype as currency, tpr.change_date, $title
            FROM agt_traders_prices as tpr
            inner join agt_traders_products_lang  as tp_l on tp_l.id = tpr.cult_id
            inner join agt_traders_places         as tpl  on tpr.place_id = tpl.id $regionSql $portSql $onlyPortsSql
            left join agt_traders_ports_lang      as pl   on pl.port_id = tpl.port_id
            left join regions                     as r    on r.id = tpl.obl_id
          WHERE tpr.buyer_id = {$value['author_id']} && tpl.type_id != 1 && tpr.acttype = $typeInt $rubricSql $currencySql
          GROUP BY $groupBy
          ORDER BY tpr.change_date DESC
          LIMIT 2
        ";*/


        /*
         * select MAX(tpr.change_date) as ch_dt,ci.id, ci.title, ci.logo_file as logo, ci.author_id, ci.trader_premium{$type} as top, MAX(tpr.dt) as date, date_format(MAX(tpr.dt), '%e %M') as date2
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' $currencySql $rubricSql
        $placeSql
      where ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && ci.visible = 1
      group by ci.id
      order by ci.trader_premium{$type} desc,ch_dt desc,ci.trader_sort{$type}, ci.rate_formula desc, ci.title
      limit $start, $count";
    // get traders list
    $traders = $this->db->query("
    select MAX(tpr.change_date) as ch_dt,ci.id, ci.title, ci.logo_file as logo, ci.author_id, ci.trader_premium{$type} as top, MAX(tpr.dt) as date, date_format(MAX(tpr.dt), '%e %M') as date2
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' $currencySql $rubricSql
        $placeSql
      where ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && ci.visible = 1
      group by ci.id
      order by ci.trader_premium{$type} desc,ch_dt desc,ci.trader_sort{$type}, ci.rate_formula desc, ci.title*/



        $traders = CompItems::select('id', 'title', 'logo_file')->orderBy('id', 'desc')->paginate(10);
        $prices = TradersPricesArc::select('id', 'costval', 'add_date', 'dt')->with('traders_products_lang')->paginate(10)->toArray();
        $traders2 = CompItems::where('title', 'НОВААГРО')->first();
        //dd($traders2);

        //$this->traderService->DataForFilter();


        /*
        if($region){
            $traders = $traders->where('region', $region);
        }*/
        /*return view('traders.traders_regions'
//            ,            ['traders'=>$traders->paginate(15)]
        );*/


        $rubric = $this->traderService->DataForFilter();

        return view('traders.traders_regions'
            ,[
                'viewmod'=>$request->get('viewmod'),
                'section' => 'section',
                'traders'=> $traders, //Traders::paginate(20),
                'rubric' => $rubric,
                'prices' => $prices['data'],
                'onlyPorts' => 'onlyPorts',
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
        //$traders_products_lang = Traders_Products_Lang::first();
        /*$traders = Traders::first();
        $traders_price = Traders_Prices::first();
        $traders_filter = TradersFilters::first();*/
        //dd($traders_products_lang);
        /*$traders = Traders_Prices::query();
        if($region){
            $traders = $traders->where('region',$region);
        }*/

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $region
     * @param  string  $culture
     * @return \Illuminate\Http\Response
     */
    public function region_and_culture($region, $culture)
    {
        //dd($region, $culture);
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
