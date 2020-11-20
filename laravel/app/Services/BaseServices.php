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
        return \Cache::rememberForever('REGIONS', function () {
            $regions = Regions::get()
                ->push(['name' => 'Вся Украина', 'translit' => 'ukraine']);
            return $regions;
        });
    }


    public function new_unique($array, $key)
    {
        $temp_array = [];

        foreach ($array as $v) {
            if (!isset($temp_array[$v[$key]])) {
                $temp_array[$v[$key]] = $v;
            }
        }

        $array = array_values($temp_array);

        return $array;

    }

    public function getForwardsMonths()
    {
        $data = [
            'start' => [],
            'end' => [],
        ];

        for ($i = 0; $i <= 6; $i++) {
            $dt_start = Carbon::now();
            $dt_end = Carbon::now();
            array_push($data['start'], $dt_start->addMonths($i)->startOfMonth()->format('Y-m-d'));
            array_push($data['end'], $dt_end->addMonths($i)->endOfMonth()->format('Y-m-d'));
        }

        return $data;
    }

    public function getNamePortRegion($region = null, $port = null)
    {
        $onlyPorts = null;
        $id_port = TradersPorts::where('url', $port)->value('id');
        $port_name = ($port != 'all') ? TradersPortsLang::where('port_id', $id_port)->value('portname') : [
            'Все порты', $onlyPorts = 'yes'
        ][0];

        $name_region = ($region != null) ? Regions::where('translit', $region)->value('name').' область' : null;

        if ($region == 'crimea') {
            $name_region = 'АР Крым';
        }

        if ($region == 'ukraine') {
            $name_region = 'Вся Украина';
        }

        return ['region' => $name_region, 'port' => $port_name, 'onlyPorts' => $onlyPorts];
    }
}
