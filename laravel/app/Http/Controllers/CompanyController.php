<?php

namespace App\Http\Controllers;

use App\Models\ADV\AdvTorgPost;
use App\Models\Comp\CompComment;
use App\Models\Comp\CompCommentLang;
use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;
use App\Models\Traders\TradersContactsRegions;
use App\Models\Traders\TradersPrices;
use App\Services\BaseServices;
use App\Models\Comp\CompItems;
use App\Models\Comp\CompItemsContact;
use App\Services\BreadcrumbService;
use App\Services\CompanyService;
use App\Services\SeoService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    const NAME_SECTION_RUBRIC = [
        0 => 'Все рубрики',
        1 => 'Выбрать продукцию',
    ];


    protected $companyService;
    protected $baseServices;
    protected $breadcrumbService;
    protected $seoService;
    protected $agent;
    protected $company;


    public function __construct(CompanyService $companyService, BaseServices $baseServices, SeoService $seoService, BreadcrumbService $breadcrumbService)
    {
        parent::__construct();
        $this->companyService = $companyService;
        $this->baseServices = $baseServices;
        $this->breadcrumbService = $breadcrumbService;
        $this->seoService = $seoService;
        $this->company = null;
        $this->agent = new \Jenssegers\Agent\Agent;
    }

    private function isMobileFilter(Request $request)
    {
        return !empty($request->get('query')) || !empty($request->get('region'));
    }

    private function IsDesktopFilter(Request $request)
    {
        return redirect()->route('company.filter', [$request->get('query')]);
    }

    private function regionName($region)
    {
        $name = Regions::where('translit', $region)->value('name'). ' область';

        if($region == 'crimea'){
            $name = 'АР Крым';
        }

        if($region == 'ukraine' || !$region){
            $name = 'Вся Украина';
        }

        return $name;
    }


    public function setDataForCompanies($data)
    {
        $regions = $this->companyService->setRegions($this->baseServices->getRegions()->slice(1, -1), $data->get('rubric_id'));
        $region_name = $this->regionName($data->get('region'));
        $rubric_id = $data->has('rubric_id') ? $data->get('rubric_id') : null;
        $region_id = null;
        $region = $data->get('region');
        $culture_name = $data->get('rubric_id') ? CompTopic::where('id', $rubric_id)->first() : null;
        $check_phone = $this->agent->isMobile() ? 1 : 0;
        $culture_name = $culture_name  ? $culture_name->title : self::NAME_SECTION_RUBRIC[$check_phone];

        if($data->get('region') != 'ukraine' && $data->get('region')) {
            $region = Regions::where('translit', $data->get('region'))->first();

            if(!$region) {
                return redirect()->route('company.region', 'ukraine');
            }

            $region_id = $region->id;
        }

        $companies = $this->companyService->getCompanies(['region' => $data->get('region'), 'rubric' => $rubric_id, 'query' => $data->get('query')]);
        $meta = $this->seoService->getCompaniesMeta(['rubric' => $rubric_id, 'region' => $region_id, 'page' => $companies->currentPage()]);
        $groups = $this->companyService->setRubricsGroup($region_id, $rubric_id);
        $breadcrumbs = $this->breadcrumbService->setBreadcrumbsCompanies(['region' => $region, 'culture_name' => $culture_name,'rubric_id' => $rubric_id]);

        return view('company.companies', [
            'companies' => $companies,
            'regions' => $regions,
            'rubricGroups' => $groups,
            'region_name' => $region_name,
            'region' => !$data->get('region') ? 'ukraine' : $data->get('region'),
            'obj_region' => $data->get('region') != 'ukraine' ? $region : [],
            'rubric_id' => $rubric_id,
            'culture_name' => $culture_name,
            'region_id' => $region_id,
            'query' => $data->get('query'),
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
    * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Http\RedirectResponse|View
    */
    public function companies(Request $request)
    {
        $data_companies =  collect(['region' => null, 'query' => null, 'page_type' => 'companies', 'rubric_id' => null]);

        if(!empty($request->get('query'))){
            $data_companies['query'] = $request->get('query');
            return $this->IsDesktopFilter($request);
        }

        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        return $this->setDataForCompanies($data_companies);
    }


    /**
     * Display a listing of the resource.
     * @param string $region
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function companiesRegion(string $region, Request $request)
    {
        $data_companies = collect(['region' => $region, 'query' => null, 'page_type' => 'companies', 'rubric_id' => null]);

        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        if(!empty($request->get('query'))){
            $data_companies['query'] = $request->get('query');
            return $this->IsDesktopFilter($request);
        }

        return $this->setDataForCompanies($data_companies);
    }


    /**
     * Display a listing of the resource.
     * @param string $region
     * @param $rubric_id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function companiesRegionRubric(string $region, $rubric_id, Request $request)
    {
        $data_companies = collect(['region' => $region, 'query' => null, 'page_type' => 'companies', 'rubric_id' => $rubric_id]);

        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        if(!empty($request->get('query'))){
            $data_companies['query'] = $request->get('query');
            return $this->IsDesktopFilter($request);
        }

        return $this->setDataForCompanies($data_companies);
    }


    /**
    * Display a listing of the resource.
    * @param  Request  $request
    * @param $query
    * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Http\RedirectResponse|View
    */
    public function companiesFilter(Request $request, $query = null)
    {
        $data_companies = collect(['region' => null, 'query' => $query, 'page_type' => 'companies', 'rubric_id' => null]);

        if(!empty($request->get('query'))){
            return $this->IsDesktopFilter($request);
        }

        if ($this->isMobileFilter($request) && $this->agent->isMobile()) {
            return $this->companyService->mobileFilter($request);
        }

        return $this->setDataForCompanies($data_companies);
    }

    public function setCompany($id)
    {
        $this->company = CompItems::find($id);

        if(empty($this->company)){
            App::abort(404);
        }
    }


    /**
    * Display a listing of the resource.
    * @param $id ;
    *
    * @return Factory|View
    */
    public function company($id)
    {
        $this->setCompany($id);

//        $updateDate = TradersPrices::where([['buyer_id', $this->company->author_id], ['acttype', 0]])
//            ->orderBy('dt')
//            ->limit(1)
//            ->value('change_date');
        $updateDate = TradersPrices::where([['buyer_id', $this->company->author_id], ['acttype', 0]])->get()->max('change_date');
        $updateDate = $updateDate != '' ? Carbon::parse($updateDate)->format('d.m.Y') : null;

        $data_port = $this->companyService->getTraderPricesRubrics($id, 2);
        $data_region = $this->companyService->getTraderPricesRubrics($id, 0);

        $port_culture = $data_port->get('cultures');
        $port_place = $data_port->get('places');
        $port_price = $data_port->get('prices');

        $region_culture = $data_region->get('cultures');
        $region_place = $data_region->get('places');
        $region_price = $data_region->get('prices');

        $statusCurtypePort = $data_port->get('statusCurtype');
        $statusCurtypeRegion = $data_region->get('statusCurtype');

        $meta = $this->seoService->getMetaForOneCompany($id);
        $checkForward = $this->companyService->checkForward($this->company->author_id, $id);
        $checkAdverts = $this->companyService->checkAdverts($this->company->author_id);
        $traders_contacts = TradersContactsRegions::where('traders_contacts_regions.comp_id', $id)->with('traders_contacts')->get();

        return view('company.company', [
            'company' => $this->company,
            'id' => $id,
            'port_culture' => $port_culture,
            'port_place' => $port_place,
            'port_price' => $port_price,
            'region_culture' => $region_culture,
            'region_place' => $region_place,
            'region_price' => $region_price,
            'statusCurtypePort' => $statusCurtypePort,
            'statusCurtypeRegion' => $statusCurtypeRegion,
            'meta' => $meta,
            'traders_contacts' => $traders_contacts,
            'updateDate' => $updateDate,
            'check_forwards' => $checkForward,
            'check_adverts' => $checkAdverts,
            'current_page' => 'main',
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0
        ]);
    }


    /**
    * Display a listing of the resource.
    * @param $id
    * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function companyForwards($id)
    {
        $this->setCompany($id);

        $forward_months = $this->baseServices->getForwardsMonths();
        $prices_port = $this->companyService->getPricesForwards($this->company->author_id, 3, reset($forward_months), 2);
        $prices_region = $this->companyService->getPricesForwards($this->company->author_id, 3, reset($forward_months), 0);
        $checkForward = $this->companyService->checkForward($this->company->author_id, $id);
        $checkAdverts = $this->companyService->checkAdverts($this->company->author_id);

        if(!$checkForward){
            return redirect()->route('company.index', $id);
        }

        $meta = $this->seoService->getMetaCompanyForward($id);
        $updateDate = TradersPrices::where([['buyer_id', $this->company->author_id], ['acttype', 3]])
            ->orderBy('change_date', 'desc')
            ->limit(1)
            ->value('change_date');

        $updateDate = $updateDate != '' ? Carbon::parse($updateDate)->format('d.m.Y') : null;

        foreach ($prices_port as $index => $price){
            if($price['traders_places']->count() == 0){
                unset($prices_port[$index]);
            }
        }

        foreach ($prices_region as $index => $price){
            if($price['traders_places']->count() == 0){
                unset($prices_region[$index]);
            }
        }

        $rubrics_port = $prices_port
            ->unique('cultures.0.name')
            ->sortBy('cultures.0.name')
            ->pluck('cultures.0.name', 'cult_id');

        $rubrics_region = $prices_region
            ->unique('cultures.0.name')
            ->sortBy('cultures.0.name')
            ->pluck('cultures.0.name', 'cult_id');

        return view('company.company_forwards', [
            'company' => $this->company,
            'prices_port' => $prices_port,
            'rubrics_port' => $rubrics_port,
            'prices_region' => $prices_region,
            'rubrics_region' => $rubrics_region,
            'id' => $id,
            'meta' => $meta,
            'updateDate' => $updateDate,
            'check_forwards' => $checkForward,
            'check_adverts' => $checkAdverts,
            'current_page' => 'forwards',
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0
        ]);
    }


    public function createReviews(Request $request, $id)
    {
        /** @var Validator $validator */
        $validator = Validator::make($request->all(), [
            'content_plus' => 'required',
            'content_minus' => 'required',
        ]);

        if ($validator->fails()){
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $author_comment = \auth()->user();

        $author = CompComment::create([
            'item_id' => $id,
            'visible' => 1,
            'rate' => $request->get('rate'),
            'add_date' => Carbon::now(),
            'author' => $author_comment->name,
            'author_email' => $author_comment->email,
            'ddchk_guid' => '',
            'reply_to_id' => 0,
            'author_id' => $author_comment->user_id,
            'like_yes' => 0,
            'like_no' => 0
        ]);
        $comment = CompCommentLang::create([
            'item_id' => $author['id'],
            'lang_id' => 1,
            'content' => $request->get('content'),
            'content_plus' => $request->get('content_plus'),
            'content_minus' => $request->get('content_minus')
        ]);

        return redirect()->route('company.reviews', ['id_company' => $id]);
    }


    /**
    * Display a listing of the resource.
    * @param int $id
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    * @throws \Illuminate\Validation\ValidationException
    */
    public function companyReviews(int $id)
    {
        $this->setCompany($id);
        $reviews_with_comp = $this->companyService->getReviews($id);
        $meta = $this->seoService->getMetaCompanyReviews($id);
        $checkForward = $this->companyService->checkForward($this->company->author_id, $id);
        $checkAdverts = $this->companyService->checkAdverts($this->company->author_id);

        return view('company.company_reviews', [
            'reviews_with_comp' => $reviews_with_comp,
            'company' => $this->company,
            'id' => $id,
            'meta' => $meta,
            'current_page' => 'reviews',
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0,
            'check_forwards' => $checkForward,
            'check_adverts' => $checkAdverts,
        ]);
    }


    /**
    * Display a listing of the resource.
    * @param $id
    * @return Factory|View
    */
    public function companyContact($id)
    {

        $this->setCompany($id);
        $company_contacts = CompItemsContact::with('compItems2')->where('comp_id', $id)->get();

        $departments_contacts = $this->companyService->departamentsContacts($id);

        $creator_departament_name = $this->companyService->getDepNameAndCreator($this->company->author_id, $departments_contacts);

        $traders_contacts = TradersContactsRegions::where('traders_contacts_regions.comp_id', $id)->with('traders_contacts')->get();

        $meta = $this->seoService->getMetaCompanyContacts($id);
        $checkForward = $this->companyService->checkForward($this->company->author_id, $id);
        $checkAdverts = $this->companyService->checkAdverts($this->company->author_id);

        return view('company.company_cont', [
            'company' => $this->company,
            'departments_contacts' => $departments_contacts,
            'creator' => $creator_departament_name['creators'],
            'company_contacts' => $company_contacts,
            'departament_name' => $creator_departament_name['departament_name'],
            'traders_contacts' => $traders_contacts,
            'id' => $id,
            'meta' => $meta,
            'current_page' => 'contact',
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0,
            'check_forwards' => $checkForward,
            'check_adverts' => $checkAdverts,
        ]);
    }


    public function companyAdverts($id, Request $request)
    {
        $this->setCompany($id);

        $checkForward = $this->companyService->checkForward($this->company->author_id, $id);
        $type = $request->get('type');
        $get_adverts_data = $this->companyService->getAdverts($this->company->author_id, $type);
        $checkAdverts = $this->companyService->checkAdverts($this->company->author_id);
        $meta = [
            'meta_title' => $this->company->title,
            'meta_keywords' => $this->company->title,
            'meta_description' => 'Сайт компании '.$this->company->title
        ];

        if(!$checkAdverts){
            return redirect()->route('company.index', $id);
        }

        return view('company.company_adverts', [
            'company' => $this->company,
            'id' => $id,
            'adverts' => $get_adverts_data->get('adverts'),
            'rubric_advert' => $get_adverts_data->get('rubric'),
            'image_advert' => $get_adverts_data->get('image'),
            'type' => $type,
            'meta' => $meta,
            'current_page' => 'adverts',
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0,
            'check_forwards' => $checkForward,
            'check_adverts' => $checkAdverts,
        ]);

    }
}
