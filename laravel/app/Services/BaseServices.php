<?php


namespace App\Services;


use App\Models\Regions\Regions;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersPortsLang;
use Carbon\Carbon;

class BaseServices
{
    public function getRegions()
    {
        return \Cache::get('REGIONS', function () {
            return Regions::get();
        })->push(['name' => 'Вся Украина', 'translit' => 'ukraine']);
    }

    public function removeEmpty($array, $key)
    {

    }

    public function new_unique($array, $key)
    {
        $temp_array = [];

        foreach ($array as $v) {
            if (!isset($temp_array[$v[$key]]))
                $temp_array[$v[$key]] = $v;
        }

        $array = array_values($temp_array);

        return $array;

    }

    public function getForwardsMonths()
    {
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


}
