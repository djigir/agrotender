<?php

namespace App\Http\Controllers;

use App\Models\Comp\CompComment;
use App\Models\Comp\CompCommentLang;
use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;
use App\Models\Traders\TradersContactsRegions;
use App\Models\Traders\TradersPrices;
use App\models\User;
use App\Models\Users\Users;
use App\Services\BaseServices;
use App\Models\Comp\CompItems;
use App\Models\Comp\CompItemsContact;
use App\Models\Torg\TorgBuyer;
use App\Services\CompanyService;
use App\Services\SeoService;
use Carbon\Carbon;
use  App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Jenssegers\Date\Date;

class CompanyController extends Controller
{

    protected $companyService;
    protected $baseServices;
    protected $seoService;
    protected $agent;

    public function __construct(CompanyService $companyService, BaseServices $baseServices, SeoService $seoService)
    {
        parent::__construct();
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
        $name = Regions::where('translit', $region)->value('name'). ' область';
//        $obl_name = Regions::where('translit', $region)->value('name'). ' область';

        if($region == 'crimea'){
            $name = 'АР Крым';
//            $obl_name = 'АР Крым';
        }

        if($region == 'ukraine' || !$region){
            $name = 'Вся Украина';
//            $obl_name = 'Вся Украина';
        }

        return $name;
    }

    public function setDataForCompanies($data)
    {
        $groups = $this->companyService->getRubricsGroup();
        $regions = $this->baseServices->getRegions();
        $region_name = $this->regionName($data['region']);
        $rubric_id = isset($data['rubric_id']) ? $data['rubric_id'] : null;
        $region_id = null;
        $region = $data['region'];
        $culture_name = isset($data['rubric_id']) ? CompTopic::where('id', $rubric_id)->get()->toArray() : null;
        $culture_name = !empty($culture_name) ? $culture_name[0]['title'] : 'Все рубрики';

        if($data['region'] != 'ukraine' && $data['region']) {
            $region = Regions::where('translit', $data['region'])->get()->toArray()[0];
            $region_id = $region['id'];
        }

        $companies = $this->companyService->getCompanies($data['region'], $rubric_id, $data['query']);

        $meta = $this->seoService->getCompaniesMeta(['rubric' => $rubric_id, 'region' => $region_id, 'page' => $companies->currentPage()]);

        $breadcrumbs = $this->baseServices->setBreadcrumbsCompanies(['region' => $region, 'culture_name' => $culture_name,'rubric_id' => $rubric_id]);


        return view('company.companies', [
            'companies' => $companies, 'regions' => $regions,
            'rubricGroups' => $groups, 'settings_for_page' => $companies,
            'region_name' => $region_name,
            'region' => $data['region'],
            'rubric_id' => $rubric_id,
            'culture_name' => $culture_name,
            'region_id' => $region_id,
            'query' => $data['query'],
            'meta' => $meta,
            'isMobile' => $this->agent->isMobile(),
            'breadcrumbs' => $breadcrumbs,
            'page_type' => 0,
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function companies(Request $request)
    {
        $data_companies = ['region' => null, 'query' => null, 'page_type' => 'companies'];

        if(!empty($request->get('query'))){
            $data_companies['query'] = $request->get('query');
            return $this->IsDesktopFilter($request);
        }

        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        $necessaryData = $this->setDataForCompanies($data_companies);

        if($necessaryData){
            return $necessaryData;
        }
    }


    /**
     * Display a listing of the resource.
     * @param string $region
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companyRegion(string $region, Request $request)
    {
        $data_companies = ['region' => $region, 'query' => null, 'page_type' => 'companies'];

        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        if(!empty($request->get('query'))){
            $data_companies['query'] = $request->get('query');
            return $this->IsDesktopFilter($request);
        }

        $necessaryData = $this->setDataForCompanies($data_companies);
        if($necessaryData){
            return $necessaryData;
        }
    }


    /**
     * Display a listing of the resource.
     * @param string $region
     * @param $rubric_id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companyRegionRubric(string $region, $rubric_id, Request $request)
    {
        $data_companies = ['region' => $region, 'query' => null, 'page_type' => 'companies',
            'rubric_id' => $rubric_id];

        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        if(!empty($request->get('query'))){
            $data_companies['query'] = $request->get('query');
            return $this->IsDesktopFilter($request);
        }

        $necessaryData = $this->setDataForCompanies($data_companies);
        if($necessaryData){
            return $necessaryData;
        }
    }


    /**
     * Display a listing of the resource.
     * @param  Request  $request
     * @param $query
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companyFilter(Request $request, $query = null)
    {
        $data_companies = ['region' => null, 'query' => $query, 'page_type' => 'companies'];

        if(!empty($request->get('query'))){
            return $this->IsDesktopFilter($request);
        }

        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        $necessaryData = $this->setDataForCompanies($data_companies);

        if($necessaryData){
            return $necessaryData;
        }
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
        $data_companies = ['region' => null, 'rubric' => null, 'query' => null, 'id_company' => $id, 'page' => $current_page, 'page_type' => 'companies'];

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
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0
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
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0
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
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0
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
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0
        ]);
    }

    public function traderContacts($id)
    {
        return view('company.company_trader_contacts');
    }

}
