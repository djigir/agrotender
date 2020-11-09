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
        $region = $data['region'];
        $region_name = $this->regionName($data['region']);

        $elevators = TorgElevator::join('torg_elevator_lang', 'torg_elevator_lang.item_id', '=', 'torg_elevator.id')
            ->join('rayon_lang', 'rayon_lang.ray_id', '=', 'torg_elevator.ray_id')
            ->with('region');

        if($region != null){
            $region = Regions::where('translit', $data['region'])->value('id');
            $elevators->where('torg_elevator.obl_id', $region);
        }

        $elevators = $elevators->orderBy('torg_elevator.id', 'desc')->get();
        $regions = array_slice($this->baseServices->getRegions(), 1, -1);


        return view('elevators.elevators', [
            'elevators' => $elevators,
            'region_translit' => $data['region'],
            'region_name' => $region_name,
            'regions' => $regions,
            'isMobile' => $this->agent->isMobile(),
        ]);
    }


    public function elevators()
    {
        $data = ['region' => null];

        return $this->setElevators($data);
    }


    public function elevatorsRegion($region)
    {
        $data = ['region' => $region];

        return $this->setElevators($data);
    }

    public function elevator($url)
    {
        $elevator = TorgElevator::join('torg_elevator_lang', 'torg_elevator_lang.item_id', '=', 'torg_elevator.id')
            ->where('torg_elevator.elev_url', $url)
            ->first();

        return view('elevators.elevator', [
            'elevator' => $elevator,
            'isMobile' => $this->agent->isMobile()
        ]);
    }

}
