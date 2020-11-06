<?php

namespace App\Http\Controllers;

use App\Models\Comp\CompComment;
use App\Models\Comp\CompCommentLang;
use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;
use App\Models\Traders\TradersContactsRegions;
use App\Models\Traders\TradersPorts2buyer;
use App\Models\Traders\TradersPrices;
use App\Models\Traders\TradersProducts2buyer;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Validator;

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
        $regions = $this->companyService->setRegions(array_slice($this->baseServices->getRegions(), 1, -1), $data['rubric_id']);
        $region_name = $this->regionName($data['region']);
        $rubric_id = isset($data['rubric_id']) ? $data['rubric_id'] : null;
        $region_id = null;
        $region = $data['region'];
        $culture_name = $data['rubric_id'] ? CompTopic::where('id', $rubric_id)->get()->toArray() : null;
        $culture_name = !empty($culture_name) ? $culture_name[0]['title'] : 'Все рубрики';

        if($data['region'] != 'ukraine' && $data['region']) {
            $region = Regions::where('translit', $data['region'])->get()->toArray()[0];
            $region_id = $region['id'];
        }

        $companies = $this->companyService->getCompanies(['region' => $data['region'], 'rubric' => $rubric_id, 'query' => $data['query']]);
        $meta = $this->seoService->getCompaniesMeta(['rubric' => $rubric_id, 'region' => $region_id, 'page' => $companies->currentPage()]);
        $groups = $this->companyService->setRubricsGroup($region_id);
        $breadcrumbs = $this->baseServices->setBreadcrumbsCompanies(['region' => $region, 'culture_name' => $culture_name,'rubric_id' => $rubric_id]);

        return view('company.companies', [
            'companies' => $companies, 'regions' => $regions,
            'rubricGroups' => $groups,
            'region_name' => $region_name,
            'region' => empty($data['region']) ? 'ukraine' : $data['region'],
            'obj_region' => $data['region'] != 'ukraine' ? $region : [],
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
        $data_companies = ['region' => null, 'query' => null, 'page_type' => 'companies', 'rubric_id' => null];

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
        $data_companies = ['region' => $region, 'query' => null, 'page_type' => 'companies', 'rubric_id' => null];

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
        $data_companies = ['region' => $region, 'query' => null, 'page_type' => 'companies', 'rubric_id' => $rubric_id];

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

        $data_companies = ['region' => null, 'query' => $query, 'page_type' => 'companies', 'rubric_id' => null];

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

        $data_port = $this->companyService->getTraderPricesRubrics($id, 2);
        $data_region = $this->companyService->getTraderPricesRubrics($id, 0);

        $port_culture = $data_port['cultures'];
//        $this->companyService->getPortsRegionsCulture($id, 2);
        $port_place =   $data_port['places'];
//        $this->companyService->getPlacePortsRegions($id, 2);
        $port_price =   $data_port['prices'];
//        $this->companyService->getPriceRegionsPorts($id, 2);

        $region_culture = $data_region['cultures'];
//        $this->companyService->getPortsRegionsCulture($id, 0);
        $region_place =   $data_region['places'];
//        $this->companyService->getPlacePortsRegions($id, 0);
        $region_price =   $data_region['prices'];
//        $this->companyService->getPriceRegionsPorts($id, 0);


        //dd($region_culture, $region_place, $region_price);
        $meta = $this->seoService->getMetaForOneCompany($id);
       //dd($port_culture, $port_place, $port_price);
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

    public function getForwardsMonths() {
        $data = [
            'start' =>[],
            'end' =>[],
        ];

        for ($i = 0; $i <= 6; $i++){
            $dt_start = Carbon::now();
            $dt_end = Carbon::now();
            array_push($data['start'], $dt_start->addMonths($i)->startOfMonth()->format('Y-m-d'));
            array_push($data['end'],  $dt_end->addMonths($i)->endOfMonth()->format('Y-m-d'));
        }

        return $data;
    }

    public function getPricesForwards($author_id, $type, $dtStart, $placeType) {
        return TradersPrices::where([['buyer_id', $author_id], ['acttype', $type], ['dt', '>=', $dtStart]])
            ->with(['traders_places' => function($query) use($placeType){$query->where('type_id', $placeType);}])
            ->get()
            ->toArray();
    }

    public function getTraderPricesRubrics($user, $placeType, $type) {
        $rubrics = TradersProducts2buyer::where([['buyer_id', $user], ['acttype', $type], ['type_id', $placeType]])
            ->with(['traders_products' => function($query)use($user, $placeType, $type){
                $query->with(['traders_prices' => function($query)use($user, $placeType, $type){
                    $query->where([['acttype', $type], ['buyer_id', $user]])
                        ->with(['traders_places' => function($query)use($user, $placeType, $type){
                            $query->where([['buyer_id', $user], ['type_id', $placeType]]);
                    }]);
                }]);
        }])->get()->toArray();

        foreach ($rubrics as $index_rubric => $rubric){
            $rubrics[$index_rubric]['traders_products'] = $rubrics[$index_rubric]['traders_products'][0];
        }

        $rubrics = collect($rubrics)->sortBy('traders_products.culture.name')->toArray();

        return $rubrics;
    }
    /**
     * Display a listing of the resource.
     * @param $id
     * @return Factory|View
     */
    public function companyForwards($id)
    {
        $company = CompItems::find($id);

        $forward_months = $this->getForwardsMonths();

        $rubrics_port = $this->getTraderPricesRubrics($company['author_id'], 2, 3);
        $prices_port = $this->getPricesForwards($company['author_id'], 3, reset($forward_months), 2);

        $rubrics_region = $this->getTraderPricesRubrics($company['author_id'], 0, 3);
        $prices_region = $this->getPricesForwards($company['author_id'], 3, reset($forward_months), 0);


        foreach ($rubrics_port as $index => $rubric){
            if(empty($rubric['traders_products']['traders_prices'])){
                unset($rubrics_port[$index]);
            }
        }

        foreach ($rubrics_region as $index => $rubric){
            if(empty($rubric['traders_products']['traders_prices'])){
                unset($rubrics_region[$index]);
            }
        }

        foreach ($prices_port as $index => $price){
            if(empty($price['traders_places'])){
                unset($prices_port[$index]);
            }
        }

        foreach ($prices_region as $index => $price){
            if(empty($price['traders_places'])){
                unset($prices_region[$index]);
            }
        }

        return view('company.company_forwards', [
            'company' => $company,
            'prices_port' => $prices_port,
            'rubrics_port' => $rubrics_port,
            'prices_region' => $prices_region,
            'rubrics_region' => $rubrics_region,
            'id' => $id,
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
            'author_id' => $author_comment->id,
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
