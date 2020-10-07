<?php

namespace App\Http\Controllers;


use App\Models\Traders;
use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersPrices;
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


    public function region($region)
    {

        $this->traderService->DataForFilter();

        $traders_products_lang = Traders_Products_Lang::first();
        /*$traders = Traders::first();
        $traders_price = Traders_Prices::first();
        $traders_filter = TradersFilters::first();*/
        //dd($traders_products_lang);
        /*$traders = Traders_Prices::query();
        if($region){
            $traders = $traders->where('region',$region);
        }*/
        return view('traders.traders_regions'
//            ,            ['traders'=>$traders->paginate(15)]
        );



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
