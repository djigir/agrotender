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
        dd($traders2 ,$change_date_and_dt);

        $traders = CompItems::select('id', 'title', 'logo_file')->orderBy('id', 'desc')->paginate(10);
        $prices = TradersPricesArc::select('id', 'costval', 'add_date', 'dt')->with('traders_products_lang')->paginate(10)->toArray();
        //$traders2 = CompItems::where('title', 'Escador')->first();
        dd($traders2);
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
