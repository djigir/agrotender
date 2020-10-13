<?php

namespace App\Http\Controllers;


use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;
use App\Services\BaseServices;
use App\Models\Comp\CompItems;
use App\Models\Comp\CompItemsContact;
use App\Models\Torg\TorgBuyer;

use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $companyService;
    protected $baseServices;

    public function __construct(CompanyService $companyService, BaseServices $baseServices)
    {
        $this->companyService = $companyService;
        $this->baseServices = $baseServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companies(Request $request)
    {
        $search = null;

        $groups = $this->companyService->getRubricsGroup();
        $companies = $this->companyService->getCompanies(null, null, $search);
        $regions = $this->baseServices->getRegions();

        if(isset($request['search']))
        {
            $search = $request['search'];

            return redirect()->action('CompanyController@company_filter', [$search]);
        }

        return view('company.companies', [
            'companies' => $companies,
            'settings_for_page' => $companies,
            'regions' => $regions,
            'rubricGroups' => $groups,
            'search' => $search
            ]
        );
    }


    /**
     * Display a listing of the resource.
     * @param integer $id;
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company($id)
    {
        $company = CompItems::find($id);
        //$this->companyService->getTraderPricesRubrics($id);

        return view('company.company', ['company' => $company]);
    }


    /**
     * Display a listing of the resource.
     * @param  string  $region  ;
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company_and_region($region, Request $request)
    {
        $search = null;
        $unwanted_region = false;

        if(isset($request['search']))
        {
            $search = $request['search'];

            return redirect()->action('CompanyController@company_filter', [$search]);
        }

        if($region == 'ukraine' or $region == 'crimea'){
            $unwanted_region = true;
        }

        $groups = $this->companyService->getRubricsGroup();
        $companies = $this->companyService->getCompanies($region, null, $search);
        $regions = $this->baseServices->getRegions();
        $currently_obl = Regions::where('translit', $region)->value('name');

        return view('company.company_and_region', [
            'regions' => $regions,
            'rubricGroups' => $groups,
            'companies' => $companies,
            'settings_for_page' => $companies,
            'currently_obl' => $currently_obl,
            'unwanted_region' => $unwanted_region,
            'region' => $region,
            'search' => $search
        ]);
    }

    public function trader_contacts($id)
    {
        return view('company.company_trader_contacts');
    }

    /**
     * Display a listing of the resource.
     * @param  string  $region  ;
     *
     * @param $rubric_number
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company_region_rubric_number($region, $rubric_number, Request $request)
    {
        $search = null;
        $unwanted_region = false;

        if(isset($request['search']))
        {
            $search = $request['search'];

            return redirect()->action('CompanyController@company_filter', [$search]);
        }



        if($region == 'ukraine' or $region == 'crimea'){
            $unwanted_region = true;
        }

        $groups = $this->companyService->getRubricsGroup();
        $companies = $this->companyService->getCompanies($region, $rubric_number, $search);
        $regions = $this->baseServices->getRegions();
        $currently_obl = Regions::where('translit', $region)->value('name');
        $current_culture = CompTopic::where('id', $rubric_number)->value('title');

        return view('company.company_region_rubric_number', [
            'regions' => $regions,
            'rubricGroups' => $groups,
            'companies' => $companies,
            'settings_for_page' => $companies,
            'currently_obl' => $currently_obl,
            'unwanted_region' => $unwanted_region,
            'region' => $region,
            'rubric_number' => $rubric_number,
            'current_culture' => $current_culture,
            'search' => $search
        ]);
    }

    /**
     * Display a listing of the resource.
     * @param $search
     * @param $groups
     * @param $regions
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company_filter($search)
    {
        $groups = $this->companyService->getRubricsGroup();
        $regions = $this->baseServices->getRegions();
        $companies = $this->companyService->getCompanies(null, null, $search);

        return view('company.company_filter', [
            'search' => $search,
            'companies' => $companies,
            'rubricGroups' => $groups,
            'settings_for_page' => $companies,
            'regions' => $regions]
        );
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
        $company_contacts = CompItemsContact::with('compItems2')->where('comp_id', $id_company)->get()->toArray();
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
        $departament_name = array_unique($departament_name);

        $creators = TorgBuyer::where('id', $company->author_id)->get()->toArray();
        foreach ($creators as $item) {
            $creator = $item;
        }

        return view('company.company_cont', ['company' => $company, 'creator' => $creator, 'company_contacts' => $company_contacts, 'departament_name' => $departament_name]);
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
