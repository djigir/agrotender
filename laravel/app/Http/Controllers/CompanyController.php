<?php

namespace App\Http\Controllers;

use App\Models\Comp\CompComment;
use App\Models\Comp\CompCommentLang;
use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;
use App\Models\Traders\TradersContactsRegions;
use App\Models\Traders\TradersPrices;
use App\Services\BaseServices;
use App\Models\Comp\CompItems;
use App\Models\Comp\CompItemsContact;
use App\Models\Torg\TorgBuyer;
use App\Services\CompanyService;
use App\Services\SeoService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\This;

class CompanyController extends Controller
{

    protected $companyService;
    protected $baseServices;
    protected $seoService;
    protected $agent;

    public function __construct(CompanyService $companyService, BaseServices $baseServices, SeoService $seoService)
    {
        $this->companyService = $companyService;
        $this->baseServices = $baseServices;
        $this->seoService = $seoService;
        $this->agent = new \Jenssegers\Agent\Agent;
    }


    private function isMobileFilter(Request $request)
    {
        return !empty($request->get('query')) || !empty($request->get('region'));
    }

    private function IsDesktopFilter(Request $request)
    {
        return redirect()->route('company.company_filter', [$request->get('query')]);
    }

    private function checkName($translit = null)
    {
        return $translit == 'ukraine' or $translit == 'crimea';
    }

    private function regionName($region)
    {
        $name = 'Вся Украина';
        $obl_name = 'Вся Украина';
        $name = Regions::where('translit', $region)->value('name');
        $obl_name = Regions::where('translit', $region)->value('name'). ' область';

        if($region == 'crimea'){
            $name = 'АР Крым';
            $obl_name = 'АР Крым';
        }

        return ['name' => $name, 'obl_name' => $obl_name];
    }
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companies(Request $request)
    {
        if(!empty($request->get('query'))){
            return $this->IsDesktopFilter($request);
        }

        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        $groups = $this->companyService->getRubricsGroup();
        $companies = $this->companyService->getCompanies();
        $regions = $this->baseServices->getRegions();

        $data = ['rubric' => null, 'region' => null, 'page' => $companies->currentPage()];
        $meta = $this->seoService->getCompaniesMeta($data);
        $breadcrumbs = [0 => ['name' => 'Компании в Украине', 'url' => null]];

        return view('company.companies', [
                'companies' => $companies,
                'settings_for_page' => $companies,
                'regions' => $regions,
                'rubricGroups' => $groups,
                'meta' => $meta,
                'breadcrumbs' => $breadcrumbs,
                'isMobile' => $this->agent->isMobile(),
            ]
        );
    }


    /**
     * Display a listing of the resource.
     * @param  integer  $id;
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company($id)
    {
        $company = CompItems::find($id);

        if(empty($company)){
            App::abort(404);
        }

        $updateDate = TradersPrices::where([['buyer_id', $company->author_id], ['acttype', 0]])->limit(1)->value('change_date');
        $updateDate = !empty($updateDate) ? Carbon::parse($updateDate)->format('d.m.y') : null;

        $port_culture = $this->companyService->getPortsRegionsCulture($id, 2);
        $port_place = $this->companyService->getPlacePortsRegions($id, 2);
        $port_price = $this->companyService->getPriceRegionsPorts($id, 2);

        $region_culture = $this->companyService->getPortsRegionsCulture($id, 0);
        $region_place = $this->companyService->getPlacePortsRegions($id, 0);
        $region_price = $this->companyService->getPriceRegionsPorts($id, 0);

        $meta = $this->seoService->getMetaForOneCompany($id);
        $current_page = 'main';


        return view('company.company', [
                'company' => $company,
                'id' => $id,
                'port_culture' => $port_culture,
                'port_place' => $port_place,
                'port_price' => $port_price,
                'region_culture' => $region_culture,
                'region_place' => $region_place,
                'region_price' => $region_price,
                'meta' => $meta,
                'updateDate' => $updateDate,
                'current_page' => $current_page,
                'isMobile' => $this->agent->isMobile()
            ]
        );
    }

    /**
     * Display a listing of the resource.
     * @param  string  $region
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companyRegion($region, Request $request)
    {
        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        if(!empty($request->get('query'))){
            return $this->IsDesktopFilter($request);
        }

        $unwanted_region = $this->checkName($region);
        $groups = $this->companyService->getRubricsGroup();
        $companies = $this->companyService->getCompanies($region, null);
        $regions = $this->baseServices->getRegions();
        $currently_obl = $this->regionName($region);
        $get_region = Regions::where('translit', $region)->value('id');
        $breadcrumbs = [0 => ['name' => 'Компании в '.$currently_obl['name'].' области', 'url' => null]];
        $data = ['rubric' => null, 'region' => $get_region, 'page' => $companies->currentPage()];
        $meta = $this->seoService->getCompaniesMeta($data);


        return view('company.company_and_region', [
            'regions' => $regions,
            'rubricGroups' => $groups,
            'companies' => $companies,
            'settings_for_page' => $companies,
            'currently_obl' => $currently_obl['obl_name'],
            'unwanted_region' => $unwanted_region,
            'region' => $region,
            'meta' => $meta,
            'breadcrumbs' => $breadcrumbs,
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    public function traderContacts($id)
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
    public function companyRegionRubric($region, $rubric_number, Request $request)
    {
        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        if(!empty($request->get('query'))){
            return $this->IsDesktopFilter($request);
        }

        $unwanted_region = $this->checkName($region);
        $groups = $this->companyService->getRubricsGroup();
        $companies = $this->companyService->getCompanies($region, $rubric_number);
        $regions = $this->baseServices->getRegions();
        $current_culture = CompTopic::where('id', $rubric_number)->value('title');
        $region_id = Regions::where('translit', $region)->value('id');

        $data = ['rubric' => $rubric_number, 'region' => $region_id, 'page' => $companies->currentPage()];
        $meta =  $this->seoService->getCompaniesMeta($data);

        $currently_obl = Regions::where('translit', $region)->get()->toArray();
        $currently_obl = !empty($currently_obl) ? $currently_obl[0] : 'ukraine';
        $breadcrumbs = [0 => ['name' => 'Компании в Украине ', 'url' => null]];

        if(is_array($currently_obl)){
            $breadcrumbs = [
                0 => ['name' => 'Компании в '.$currently_obl['parental'].' области '.'<i class="fas fa-chevron-right extra-small"></i>', 'url' => route('company.company_and_region', $region)],
                1 => ['name' => 'Каталог - '.$current_culture.' хозяйства '.$currently_obl['city_parental'], 'url' => null]
            ];
        }

        return view('company.company_region_rubric_number', [
            'regions' => $regions,
            'rubricGroups' => $groups,
            'companies' => $companies,
            'settings_for_page' => $companies,
            'currently_obl' => $this->regionName($region)['obl_name'],
            'unwanted_region' => $unwanted_region,
            'region' => $region,
            'rubric_number' => $rubric_number,
            'current_culture' => $current_culture,
            'meta' => $meta,
            'breadcrumbs' => $breadcrumbs,
            'isMobile' => $this->agent->isMobile(),
        ]);
    }

    /**
     * Display a listing of the resource.
     * @param  Request  $request
     * @param $query
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companyFilter(Request $request, $query = null)
    {
        if(!empty($request->get('query'))){
            return $this->IsDesktopFilter($request);
        }

        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        $groups = $this->companyService->getRubricsGroup();
        $regions = $this->baseServices->getRegions();
        $companies = $this->companyService->getCompanies(null, null, $query);
        $data = ['rubric' => null, 'region' => null, 'page' => $companies->currentPage()];
        $meta = $this->seoService->getCompaniesMeta($data);
        $breadcrumbs = [0 => ['name' => 'Компании в Украине ', 'url' => null]];

        return view('company.company_filter', [
                'companies' => $companies,
                'rubricGroups' => $groups,
                'settings_for_page' => $companies,
                'regions' => $regions,
                'meta' => $meta,
                'breadcrumbs' => $breadcrumbs,
                'isMobile' => $this->agent->isMobile(),
                'query' => $query,
            ]
        );
    }

    /**
     * Display a listing of the resource.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companyPrices($id)
    {
        $company_name = CompItems::find($id)->value('title');

        return view('company.company_prices', [
            'id' => $id,
            'company_name' => $company_name,
            'isMobile' => $this->agent->isMobile()
        ]);
    }

    /**
     * Display a listing of the resource.
     * @param  integer  $id_company  ;
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companyReviews($id_company)
    {
        $current_page = 'reviews';
        $company = CompItems::find($id_company);
        $reviews_with_comp = $this->companyService->getReviews($id_company);
        $meta = $this->seoService->getMetaCompanyReviews($id_company);

        return view('company.company_reviews', [
            'reviews_with_comp' => $reviews_with_comp,
            'company' => $company,
            'id' => $id_company,
            'meta' => $meta,
            'current_page' => $current_page,
            'isMobile' => $this->agent->isMobile()
        ]);
    }

    /**
     * Display a listing of the resource.
     * @param  integer  $id_company  ;
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companyContact($id_company)
    {
        $current_page = 'contact';
        $company = CompItems::find($id_company);
        $company_contacts = CompItemsContact::with('compItems2')->where('comp_id', $id_company)->get()->toArray();
        $departments_type = CompItemsContact::where('comp_id', $id_company)->get()->toArray();
        $creator_departament_name = $this->companyService->getContacts($company->author_id, $departments_type);

        $traders_contacts = TradersContactsRegions::where('traders_contacts_regions.comp_id', $id_company)
            ->with('traders_contacts')
            ->get()
            ->toArray();

        $meta = $this->seoService->getMetaCompanyContacts($id_company);

        return view('company.company_cont', [
            'company' => $company,
            'creator' => $creator_departament_name["creators"],
            'company_contacts' => $company_contacts,
            'departament_name' => $creator_departament_name['departament_name'],
            'traders_contacts' => $traders_contacts,
            'id' => $id_company,
            'meta' => $meta,
            'current_page' => $current_page,
            'isMobile' => $this->agent->isMobile()
        ]);
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
