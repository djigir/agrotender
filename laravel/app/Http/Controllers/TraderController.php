<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TraderController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $region
     * @return \Illuminate\Http\Response
     */
    public function region($region)
    {
        //dd($region);
        return view('traders.traders_regions');
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
