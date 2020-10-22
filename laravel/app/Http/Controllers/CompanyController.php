<?php

namespace App\Http\Controllers;

use App\Models\Comp\CompComment;
use App\Models\Comp\CompCommentLang;

use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;

use App\Models\Traders\TradersContactsRegions;
use App\Services\BaseServices;
use App\Models\Comp\CompItems;
use App\Models\Comp\CompItemsContact;
use App\Models\Torg\TorgBuyer;

use App\Services\CompanyService;
use App\Services\SeoService;
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

    private function IsDesktopFilter($query)
    {
        return redirect()->action('CompanyController@companyFilter', ['query' => $query]);
    }

    private function checkName($translit = null)
    {
        return $translit == 'ukraine' or $translit == 'crimea';
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companies(Request $request)
    {
        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        if(!empty($request->get('query'))){
            return $this->IsDesktopFilter($request->get('query'));
        }


        $groups = $this->companyService->getRubricsGroup();
        $companies = $this->companyService->getCompanies();
        $regions = $this->baseServices->getRegions();

        //$meta = $this->seoService->getCompaniesMeta(null, null, $companies->currentPage());

        return view('company.companies', [
                'companies' => $companies,
                'settings_for_page' => $companies,
                'regions' => $regions,
                'rubricGroups' => $groups,
                'meta' => [],
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

        $port_culture = $this->companyService->getPortsRegionsCulture($id, 2);
        $port_place = $this->companyService->getPlacePortsRegions($id, 2);
        $port_price = $this->companyService->getPriceRegionsPorts($id, 2);

        $region_culture = $this->companyService->getPortsRegionsCulture($id, 0);
        $region_place = $this->companyService->getPlacePortsRegions($id, 0);
        $region_price = $this->companyService->getPriceRegionsPorts($id, 0);

        $title = $company['title'].": цены, контакты, отзывы";

        if ($company['trader_price_avail'] == 1 && $company['trader_price_visible'] == 1) {
            $title = "Закупочные цены {$company['title']} на сегодня: контакты, отзывы";
        }

        $keywords = $company['title'];
        $description = mb_substr(strip_tags($company['content']), 0, 200);

        //$meta = ['title' => $title, 'keywords' => $keywords, 'description' => $description];

        return view('company.company', [
                'company' => $company,
                'id' => $id,
                'port_culture' => $port_culture,
                'port_place' => $port_place,
                'port_price' => $port_price,
                'region_culture' => $region_culture,
                'region_place' => $region_place,
                'region_price' => $region_price,
                'meta' => [],
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
            return $this->IsDesktopFilter($request->get('query'));
        }

        $unwanted_region = $this->checkName($region);

        $groups = $this->companyService->getRubricsGroup();
        $companies = $this->companyService->getCompanies($region, null);
        $regions = $this->baseServices->getRegions();
        $currently_obl = Regions::where('translit', $region)->value('name');
        $get_region = Regions::where('translit', $region)->value('id');
        $meta = $this->seoService->getCompaniesMeta(null, $get_region, $companies->currentPage());

        return view('company.company_and_region', [
            'regions' => $regions,
            'rubricGroups' => $groups,
            'companies' => $companies,
            'settings_for_page' => $companies,
            'currently_obl' => $currently_obl,
            'unwanted_region' => $unwanted_region,
            'region' => $region,
            'meta' => [],
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
            return $this->IsDesktopFilter($request->get('query'));
        }

        $unwanted_region = $this->checkName($region);

        $groups = $this->companyService->getRubricsGroup();
        $companies = $this->companyService->getCompanies($region, $rubric_number);
        $regions = $this->baseServices->getRegions();
        $currently_obl = Regions::where('translit', $region)->value('name');
        $current_culture = CompTopic::where('id', $rubric_number)->value('title');
        $get_region = Regions::where('translit', $region)->value('id');

        //$meta =  $this->seoService->getCompaniesMeta($rubric_number, $get_region, $companies->currentPage());

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
            'meta' => [],
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
        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        $groups = $this->companyService->getRubricsGroup();
        $regions = $this->baseServices->getRegions();
        $companies = $this->companyService->getCompanies(null, null, $query);

        return view('company.company_filter', [
                'companies' => $companies,
                'rubricGroups' => $groups,
                'settings_for_page' => $companies,
                'regions' => $regions,
                'isMobile' => $this->agent->isMobile(),
                'query' => $request->get('query'),
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
        $company_name = CompItems::find($id_company)->value('title');
        $company = CompItems::find($id_company);
        $reviews_with_comp = $this->companyService->getReviews($id_company);

//        $meta = [
//            'title' => "Отзывы о {$company->title} на сайте Agrotender",
//            'keywords' => $company->title,
//            'description' => "Свежие и актуальные отзывы о компании {$company->title}. Почитать или оставить отзыв о компании {$company->title}"
//        ];

        return view('company.company_reviews', [
            'reviews_with_comp' => $reviews_with_comp,
            'company' => $company,
            'id' => $id_company,
            'company_name' => $company_name,
            'meta' => [],
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
        $company = CompItems::find($id_company);
        $company_contacts = CompItemsContact::with('compItems2')->where('comp_id', $id_company)->get()->toArray();
        $departments_type = CompItemsContact::where('comp_id', $id_company)->get()->toArray();
        $creator_departament_name = $this->companyService->getContacts($company->author_id, $departments_type);

        $traders_contacts = TradersContactsRegions::where('traders_contacts_regions.comp_id', $id_company)
            ->with('traders_contacts')
            ->get()
            ->toArray();

//        $meta = [
//            'title' => $company->title, 'keywords' => $company->title, 'description' => 'Сайт компании '.$company->title
//        ];

        return view('company.company_cont', [
            'company' => $company,
            'creator' => $creator_departament_name["creators"],
            'company_contacts' => $company_contacts,
            'departament_name' => $creator_departament_name['departament_name'],
            'traders_contacts' => $traders_contacts,
            'id' => $id_company,
            'meta' => [],
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
