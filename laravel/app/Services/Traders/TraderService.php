<?php

namespace App\Services\Traders;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersProductGroups;
use App\Models\Traders\TradersProductGroupLanguage;
use App\Models\Traders\TradersProducts;
use App\Services\CompanyService;


class TraderService
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }


    public function getCurrencies()
    {
        return [
            'uah' => [
                'id' => 0,
                'name' => 'Гривна',
                'code' => 'uah'
            ],
            'usd' => [
                'id' => 1,
                'name' => 'Доллар',
                'code' => 'usd'
            ]
        ];
    }

    public function getPorts()
    {
        $ports = TradersPorts::select('id', 'url')->with(['traders_ports_lang' => function($query){
            $query->select('portname', 'p_title', 'p_h1', 'p_descr', 'port_id');
        }])
            ->where('active', 1)
//            ->orderBy('traders_ports_lang.portname')
            ->get()
            ->toArray();

        foreach ($ports as $index => $port){
            $ports[$index] = array_merge($port, $port['traders_ports_lang'][0]);
            unset($ports[$index]["traders_ports_lang"]);
        }
        $ports = collect($ports)->sortBy('portname');
        return $ports;

    }


    public function getRubricsGroup()
    {
        $groups = TradersProductGroups::where("acttype", 0)->get();

        foreach ($groups as $index_group => $group){
            $groups[$index_group]['index_group'] = $index_group;
        }

        $groups = collect($groups)->groupBy("index_group")->toArray();

        $groups = $this->group_array($groups);

        return $groups;
    }


    public function group_array($groups)
    {
        foreach ($groups as $index => $group) {
            $groups[$index] = $groups[$index][0];
            $groups[$index]['products'] = $groups[$index]['groups']['traders_products'];
            $groups[$index]['products'] = collect($groups[$index]['products'])->sortBy('culture.name')->toArray();

            unset($groups[$index]['groups']['traders_products']);
        }

        return $groups;
    }
    public function getTradersPortCulture()
    {

    }

    public function getTradersRegionCulture()
    {

    }
    public function getTraders($type_premium)
    {
        $traders = CompItems::where([['trader_premium', $type_premium], ['trader_price_avail', 1], ['trader_price_visible', 1], ['visible', 1]])
            ->select('id', 'title', 'author_id', 'logo_file')
            ->groupBy('id')
            ->get()
            ->toArray();

        $traders = $this->add_data_traders($traders);

        return $traders;
    }

    public function add_data_traders($traders)
    {
        foreach ($traders as $index => $trader) {
            $traders[$index]['cultures'] = [];
            $traders[$index]['cultures'] = $this->companyService->getPortsRegionsCulture($trader['id'], 0);

            if (empty($traders[$index]['cultures'])){
                unset($traders[$index]);
            }
        }
        $traders = array_values($traders);

        return $traders;
    }
}
