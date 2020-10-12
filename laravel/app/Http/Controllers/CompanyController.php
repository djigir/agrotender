<?php

namespace App\Http\Controllers;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompItemsContact;
use App\Models\Torg\TorgBuyer;
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
    public function companies()
    {
        $group = $this->companyService->getRubricsGroup();
        $companies = $this->companyService->getCompanies();

        return view('company.companies', ['companies' => $companies, 'settings_for_page' => $companies]);
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

    public function trader_contacts($id)
    {
        return view('company.company_trader_contacts');
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
     * @param integer $id;
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company($id)
    {
        return view('company.company');
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
        $company = CompItems::find($id_company);
        $creators = TorgBuyer::where('id', $company->author_id)->get();
        $company_contacts = CompItemsContact::with('compItems2')->find($id_company)->toArray();
        $departments_type = CompItemsContact::where('comp_id', $id_company)->get()->toArray();
        $departament_name = [];
        $arr = [
            1 => 'Отдел закупок',
            2 => 'Отдел продаж',
            3 => 'Отдел услуг',
        ];
        foreach ($departments_type as $index => $value) {
            $departament_name [] = $arr[$value['type_id']];
        }

        return view('company.company_cont', ['company' => $company, 'creators' => $creators, 'company_contacts' => $company_contacts, 'departament_name' => $departament_name]);
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
