<?php

namespace App\Http\Controllers;

use App\Models\Elevators\TorgElevator;
use App\Models\Regions\Regions;
use App\Services\BaseServices;
use Illuminate\Http\Request;

class EvelatorController extends Controller
{
    protected $agent;
    protected $baseServices;

    public function __construct(BaseServices $baseServices)
    {
        $this->agent = new \Jenssegers\Agent\Agent;
        $this->baseServices = $baseServices;
    }

    private function regionName($region)
    {
        $name = Regions::where('translit', $region)->value('name'). ' область';

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
        $regions = $this->baseServices->getRegions()->slice(1, -1);
        $region_name = $this->regionName($data->get('region'));

        $elevators = TorgElevator::with('region', 'lang_rayon',  'lang_elevator');

        if($data->get('region') != null){
            $region = Regions::where('translit', $data->get('region'))->value('id');
            $elevators->where('obl_id', $region);
        }

        $elevators = $elevators->orderBy('torg_elevator.id', 'desc')->get();

        return view('elevators.elevators', [
            'elevators' => $elevators->chunk(2),
            'region_translit' => $data->get('region'),
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

        return view('elevators.elevator', [
            'elevator' => $elevator,
            'page_type' => 2,
            'isMobile' => $this->agent->isMobile()
        ]);
    }

}
