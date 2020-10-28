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
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Jenssegers\Date\Date;
use \Illuminate\Validation\Validator;

class CompanyController extends Controller
{

    protected $companyService;
    protected $baseServices;
    protected $seoService;
    protected $agent;
    protected $company;

    public function __construct(CompanyService $companyService, BaseServices $baseServices, SeoService $seoService)
    {
        parent::__construct();
        $this->companyService = $companyService;
        $this->baseServices = $baseServices;
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

    private function checkName($translit = null)
    {
        return $translit == 'ukraine' or $translit == 'crimea';
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
     * @return Factory|View
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

        return $this->setDataForCompanies($data_companies);
    }


    /**
     * Display a listing of the resource.
     * @param string $region
     * @param Request $request
     * @return Factory|View
     */
    public function companiesRegion(string $region, Request $request)
    {
        $data_companies = ['region' => $region, 'query' => null, 'page_type' => 'companies'];

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
     * @return Factory|View
     */
    public function companiesRegionRubric(string $region, $rubric_id, Request $request)
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

        return $this->setDataForCompanies($data_companies);
    }


    /**
     * Display a listing of the resource.
     * @param  Request  $request
     * @param $query
     * @return Factory|View
     */
    public function companiesFilter(Request $request, $query = null)
    {
        $data_companies = ['region' => null, 'query' => $query, 'page_type' => 'companies'];

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
     * @param  integer  $id;
     *
     * @return Factory|View
     */
    public function company($id)
    {
        $this->setCompany($id);

        $updateDate = TradersPrices::where([['buyer_id', $this->company->author_id], ['acttype', 0]])->limit(1)->value('change_date');
        $updateDate = !empty($updateDate) ? Carbon::parse($updateDate)->format('d.m.y') : null;

        $port_culture = $this->companyService->getPortsRegionsCulture($id, 2);
        $port_place = $this->companyService->getPlacePortsRegions($id, 2);
        $port_price = $this->companyService->getPriceRegionsPorts($id, 2);

        $region_culture = $this->companyService->getPortsRegionsCulture($id, 0);
        $region_place = $this->companyService->getPlacePortsRegions($id, 0);
        $region_price = $this->companyService->getPriceRegionsPorts($id, 0);

        $meta = $this->seoService->getMetaForOneCompany($id);

        return view('company.company', [
            'company' => $this->company,
            'id' => $id,
            'port_culture' => $port_culture,
            'port_place' => $port_place,
            'port_price' => $port_price,
            'region_culture' => $region_culture,
            'region_place' => $region_place,
            'region_price' => $region_price,
            'meta' => $meta,
            'updateDate' => $updateDate,
            'current_page' => 'main',
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0
            ]
        );
    }

    /**
     * Display a listing of the resource.
     * @param $id
     * @return Factory|View
     */
    public function companyForwards($id)
    {

        $company = CompItems::where([
            ['id', $id], ['trader_price_forward_avail', 1], ['trader_price_forward_visible', 1], ['visible', 1]
        ])
            ->with([
                'traders_prices' => function ($query) {
                    $query->where('acttype', 3)->with(['traders_places' => function($query){
                        $query->where('type_id', 0)->with('traders_ports.traders_ports_lang');
                    }], 'traders_products');
                }
            ])
            ->select('id', 'author_id', 'trader_premium', 'obl_id', 'logo_file',
                'short', 'add_date', 'visible', 'title', 'trader_price_avail',
                'trader_price_visible')
            ->get()
            ->toArray()[0];

        foreach ($company['traders_prices'] as $index => $comp){
            if(empty($comp['traders_places'])){
                unset($company['traders_prices'][$index]);
            }
        }
        $company['traders_prices'] = array_values($company['traders_prices']);

        dd($company);

        return view('company.company_forwards', [
            'company' => !empty($company) ? $company[0] : [],
            'id' => $id,
            'current_page' => 'forwards',
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0
        ]);
    }

 public function createReviews(Request $request, $id)
    {
        $author = CompComment::create([
            'item_id' => $id,
            'visible' => 1,
            'rate' => $request->get('rate'),
            'add_date' => Carbon::now(),
            'author' => 'TEST',
            'author_email' => 'test@gmail.com',
            'ddchk_guid' => '',
            'reply_to_id' => 0,
            'author_id' => 9999,
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
        if ($comment['content'] != null) {
            return redirect()
                ->route('company.company_reviews', ['id_company' => $id]);
        }

//        $comment_text =CompCommentLang::create($request->only(['content', 'content_plus', 'content_minus']) + ['item_id', 1224]);
//        $comment_text =CompCommentLang::create(['item_id', 1224, 'content', 'content_plus', 'content_minus']);

//        CompCommentLang::update();
//        $comp_comment = CompComment::find(906);
//        $comp_comment->update(['rate' => 5]);

        /*$data_comment = ['id_company' => $id_company,
            'user' => $user,
            'good' => $request->get('good'),
            'bad' => $request->get('bad'),
            'comment' => $request->get('comment')];*/


        //$reviews = $this->companyService->addReviews($data_comment);
    }

    public function updateReviews(){}

    public function deleteReviews(){}

    /**
     * Display a listing of the resource.
     * @param integer $id_company
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function companyReviews(int $id)
    {
        $this->setCompany($id);
        $reviews_with_comp = $this->companyService->getReviews($id);
        $meta = $this->seoService->getMetaCompanyReviews($id);
        /*$data_comment = ['id_company' => $id,
            'user' => $user,
            'good' => $request->get('good'),
            'bad' => $request->get('bad'),
            'comment' => $request->get('comment')];*/


        $meta = $this->seoService->getMetaCompanyReviews($id);

        return view('company.company_reviews', [
            'reviews_with_comp' => $reviews_with_comp,
            'company' => $this->company,
            'id' => $id,
            'meta' => $meta,
            'current_page' => 'reviews',
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0
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
        $company_contacts = CompItemsContact::with('compItems2')->where('comp_id', $id)->get()->toArray();
        $departments_type = CompItemsContact::where('comp_id', $id)->get()->toArray();
        $creator_departament_name = $this->companyService->getContacts($this->company->author_id, $departments_type);

        $traders_contacts = TradersContactsRegions::where('traders_contacts_regions.comp_id', $id)
            ->with('traders_contacts')
            ->get()
            ->toArray();

        $meta = $this->seoService->getMetaCompanyContacts($id);

        return view('company.company_cont', [
            'company' => $this->company,
            'creator' => $creator_departament_name["creators"],
            'company_contacts' => $company_contacts,
            'departament_name' => $creator_departament_name['departament_name'],
            'traders_contacts' => $traders_contacts,
            'id' => $id,
            'meta' => $meta,
            'current_page' => 'contact',
            'isMobile' => $this->agent->isMobile(),
            'page_type' => 0
        ]);
    }
}
