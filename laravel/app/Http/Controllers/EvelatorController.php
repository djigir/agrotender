<?php

namespace App\Http\Controllers;

use App\Models\Elevators\TorgElevator;
use App\Models\Regions\Regions;
use App\Services\BaseServices;
use App\Services\Breadcrumb\BreadcrumbElev;
use App\Services\BreadcrumbService;
use App\Services\SeoService;
use Illuminate\Http\Request;

class EvelatorController extends Controller
{
    protected $agent;
    protected $baseServices;
    protected $seoServices;
    protected $breadcrumbsServices;
    protected $breadcrumbsElev;

    public function __construct(BaseServices $baseServices, SeoService $seoServices, BreadcrumbService $breadcrumbService, BreadcrumbElev $breadcrumbsElev)
    {
        parent::__construct();
        $this->agent = new \Jenssegers\Agent\Agent;
        $this->baseServices = $baseServices;
        $this->seoServices = $seoServices;
        $this->breadcrumbsServices = $breadcrumbService;
        $this->breadcrumbsElev = $breadcrumbsElev;
    }

    private function regionName($region)
    {
        $name = Regions::where('translit', $region)->value('name');

        if($region == 'crimea'){
            $name = 'АР Крым';
        }

        if($region == 'ukraine' || !$region){
            $name = 'Украины';
        }

        return $name;
    }

    public function setElevators($data)
    {
        $regions = $this->baseServices->getRegions();
        $region_name = $this->regionName($data->get('region'));
        $region_name = $region_name != null ? $region_name : 'Выбрать область';
        $region = null;
        $elevators = TorgElevator::with('region', 'lang_rayon',  'lang_elevator');

        if($data->get('region') != null){
            $region = Regions::where('translit', $data->get('region'))->value('id');
            $elevators->where('obl_id', $region);
        }

        $elevators = $elevators->orderBy('torg_elevator.id', 'desc')->get();
        $breadcrumbs = $this->breadcrumbsElev->setBreadcrumbsElevators($region);
        $meta = $this->seoServices->getMetaElevators();


        return view('elevators.elevators', [
            'elevators' => $elevators->chunk(2),
            'region_translit' => $data->get('region'),
            'meta' => $meta,
            'breadcrumbs' => $breadcrumbs,
            'region_name' => $region_name,
            'regions' => $regions,
            'page_type' => 2,
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    public function elevators()
    {
        $data = collect(['region' => null]);

        return $this->setElevators($data);
    }


    public function elevatorsRegion($region)
    {
        $data = collect(['region' => $region]);

        return $this->setElevators($data);
    }

    public function elevator($url)
    {
        $elevator = TorgElevator::with('lang_elevator')->where('elev_url', $url)->first();

        $meta = $this->seoServices->getMetaElev($elevator);
        $breadcrumbs = $this->breadcrumbsElev->setBreadcrumbsElevator($elevator);

        return view('elevators.elevator', [
            'elevator' => $elevator,
            'page_type' => 2,
            'meta' => $meta,
            'breadcrumbs' => $breadcrumbs,
            'isMobile' => $this->agent->isMobile()
        ]);
    }

}
