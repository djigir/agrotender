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
            ->get()
            ->toArray();

        foreach ($ports as $index => $port){
            $ports[$index] = array_merge($port, $port['traders_ports_lang'][0]);
            unset($ports[$index]["traders_ports_lang"]);
        }

        $ports = collect($ports)->sortBy('portname')->toArray();
        $ports = array_values($ports);

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


    public function getTradersRegionPortCulture($port = null, $culture = null, $type_premium, $region = null)
    {
        $obl_id = null;
        $traders = [];
        if($port != null and $port!= 'all'){
            $obl_id = TradersPorts::where('url', $port)->value('obl_id');
        }

        if($region != null and  $region != 'ukraine'){
            $obl_id = Regions::where('translit', $region)->value('id');
        }

        if($culture != null){
            $culture = TradersProducts::where('url', $culture)->value('id');
        }

        $traders = CompItems::
            where([
                ['trader_premium', $type_premium],
                ['trader_price_avail', 1],
                ['trader_price_visible', 1],
                ['visible', 1],
                [function ($query) use($obl_id){
                    if($obl_id != null)
                    $query->where('obl_id', $obl_id);
                }],
            ])
            ->select('id', 'title', 'author_id', 'logo_file')
            ->orderBy('trader_sort')
            ->orderBy('rate_formula' , 'desc')
            ->orderBy('title')
            ->groupBy('id')
            ->get()
            ->toArray();

            if($obl_id != null and $culture != null){
                $traders = CompItems::join('comp_item2topic', 'comp_items.id', '=', 'comp_item2topic.item_id')
                    ->where([['comp_items.trader_premium', $type_premium],
                        ['comp_item2topic.topic_id', $culture], [function ($query) use($region, $obl_id){
                        if($obl_id != null){
                            $query->where('comp_items.obl_id', $obl_id);
                        }
                    }]])
                    ->select('comp_items.id', 'comp_items.author_id', 'comp_items.trader_premium',
                        'comp_items.obl_id', 'comp_items.logo_file',
                        'comp_items.short', 'comp_items.add_date', 'comp_items.visible', 'comp_items.obl_id', 'comp_items.title', 'comp_items.trader_price_avail',
                        'comp_items.trader_price_visible', 'comp_items.phone', 'comp_items.phone2', 'comp_items.phone3'
                    )
                    ->orderBy('comp_items.trader_premium', 'desc')
                    ->orderBy('comp_items.rate_formula', 'desc')
                    ->get()
                    ->toArray();
            }

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
