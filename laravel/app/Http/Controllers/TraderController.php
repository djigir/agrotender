<?php

namespace App\Http\Controllers;


use App\Models\Traders;
use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersPrices;
use App\Models\TradersComment;
use App\Models\TradersFilters;

use App\Models\Comp\CompTopic;

use Illuminate\Http\Request;

class TraderController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $region
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function index(){
        return redirect('/traders/region_ukraine');
    }
//$rubrics   = $this->db->query("
//      select t.menu_group_id as group_id, t.title, count(i2t.id) as count, i2t.topic_id
//        from agt_comp_topic as t
//        left join agt_comp_item2topic i2t
//          on i2t.topic_id = t.id
//        ".($region != null ? "left join agt_comp_items i on i.id = i2t.item_id" : "")."
//      ".($region != null ? "where i.obl_id = $region" : "")."
//        group by t.id
//        order by t.menu_group_id, t.sort_num, t.title");
//return $rubrics;

    public function region($region)
    {


        $traders_products_lang = Traders_Products_Lang::first();
        /*$traders = Traders::first();
        $traders_price = Traders_Prices::first();
        $traders_filter = TradersFilters::first();*/
        //dd($traders_products_lang);
        /*$traders = Traders_Prices::query();
        if($region){
            $traders = $traders->where('region',$region);
        }*/

////        \DB::enableQueryLog();
//        $temp = CompTopic::with('comp_topic_item')
//            ->select(
//                'id',
//                'menu_group_id',
//                'title',
//                'sort_num',
//                \DB::raw('count(*) as count, id')
//            )
//            ->groupBy('id')
//            ->get();
////        dd(\DB::getQueryLog());
//        dd($temp->toArray());
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
