<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $companyService;


    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function all_company(Request $request)
    {
        $group = $this->companyService->getRubricsGroup();
        $companies = $this->companyService->getCompanies($request);

        return view('company.all_company', ['companies' => $companies, 'settings_for_page' => $companies]);
    }

    /**
     * Display a listing of the resource.
     * @param string $region;
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company_and_region($region)
    {
        return view('company.company_and_region');
    }

    /**
     * Display a listing of the resource.
     * @param string $region;
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company_region_rubric_number($region, $rubric_number)
    {
        return view('company.company_region_rubric_number');
    }

    /**
     * Display a listing of the resource.
     * @param string $query;
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company_filter($query)
    {
        return view('company.company_filter', ['query' => $query]);
    }

    /**
     * Display a listing of the resource.
     * @param integer $id_company;
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company_id($id_company)
    {
        return view('company.company_id');
    }

    /**
     * Display a listing of the resource.
     * @param integer $id_company;
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company_prices($id_company)
    {
        return view('company.company_prices');
    }

    /**
     * Display a listing of the resource.
     * @param integer $id_company;
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company_reviews($id_company)
    {
        return view('company.company_reviews');
    }

    /**
     * Display a listing of the resource.
     * @param integer $id_company;
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company_cont($id_company)
    {
        return view('company.company_cont');
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
