<?php

namespace App\Services\Traders;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;
use App\Models\Traders\TradersPorts;
use App\Models\Traders\TradersPortsLang;
use App\Models\Traders\TradersProductGroups;
use App\Models\Traders\TradersProductGroupLanguage;
use App\Models\Traders\TradersProducts;
use App\Services\BaseServices;
use App\Services\CompanyService;


class TraderService
{
    protected $companyService;
    protected $baseService;

    public function __construct(CompanyService $companyService, BaseServices $baseService)
    {
        $this->companyService = $companyService;
        $this->baseService = $baseService;
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

    public function getNamePortRegion($region = null, $port = null)
    {
        $onlyPorts = null;
        $id_port = TradersPorts::where('url', $port)->value('id');
        $port_name = ($port != 'all') ? TradersPortsLang::where('port_id', $id_port)->value('portname') : ['Все порты', $onlyPorts = 'yes'][0];
        $name_region = ($region != null) ? Regions::where('translit', $region)->value('name').' область' : null;

        if($region == 'crimea'){
            $name_region = 'АР Крым';
        }

        if($region == 'ukraine'){
            $name_region = 'Вся Украина';
        }

        return ['region' => $name_region, 'port' => $port_name, 'onlyPorts' => $onlyPorts];

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
        array_push($ports, ['portname' => 'Все порты', 'url' => 'all']);

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

    public function searchTraders($query, $obl_id){
        $traders = CompItems::join('traders_prices', 'comp_items.author_id',  '=', 'traders_prices.buyer_id')
            ->where([
                ['comp_items.trader_price_avail', 1],
                ['comp_items.trader_price_visible', 1],
                ['comp_items.visible', 1],
                ['traders_prices.curtype', $query],
                [function ($query) use($obl_id){
                    if($obl_id != null)
                        $query->where('obl_id', $obl_id);
                }],])

            ->select('comp_items.id', 'comp_items.title', 'comp_items.author_id',
                'comp_items.logo_file', 'traders_prices.curtype',
                'comp_items.trader_premium', 'comp_items.trader_price_avail',
                'comp_items.trader_price_visible', 'comp_items.visible')

            ->orderBy('comp_items.trader_premium', 'desc')
            ->orderBy('comp_items.trader_sort')
            ->orderBy('comp_items.rate_formula' , 'desc')
            ->orderBy('comp_items.title')
            ->get()
            ->toArray();


        $traders =  $this->baseService->new_unique($traders, 'title');
        $traders = $this->add_data_traders($traders);

        return $traders;
    }

    public function getTradersRegionPortCulture($data)
    {
        $obl_id = null;

        if($data['port'] != null and $data['port'] != 'all'){
            $obl_id = TradersPorts::where('url', $data['port'])->value('obl_id');
        }

        if($data['region'] != null and $data['region'] != 'ukraine'){
            $obl_id = Regions::where('translit', $data['region'])->value('id');
        }

        if($data['culture'] != null){
            $culture = TradersProducts::where('url', $data['culture'])->value('id');
        }

        if (!empty($data['query'])) {
            return $this->searchTraders($data['query']['currency'], $obl_id);
        }

        $traders = CompItems::where([
            ['trader_price_avail', 1],
            ['trader_price_visible', 1],
            ['visible', 1],
            [function ($query) use($obl_id){
                if($obl_id != null)
                    $query->where('obl_id', $obl_id);
            }],
        ])->select('id', 'title', 'author_id', 'logo_file', 'trader_premium')
            ->orderBy('trader_premium', 'desc')
            ->orderBy('trader_sort')
            ->orderBy('rate_formula' , 'desc')
            ->orderBy('title')
            ->groupBy('id')
            ->get()
            ->toArray();

        if($obl_id != null and $data['culture'] != null){
            $traders = CompItems::join('comp_item2topic', 'comp_items.id', '=', 'comp_item2topic.item_id')
                ->where([
                    ['comp_item2topic.topic_id', $data['culture']],
                    ['trader_price_avail', 1],
                    ['trader_price_visible', 1],
                    ['visible', 1],
                    [function ($query) use($obl_id){
                        if($obl_id != null){
                            $query->where('comp_items.obl_id', $obl_id);
                        }
                    }]])->select('comp_items.id', 'comp_items.author_id', 'comp_items.trader_premium',
                    'comp_items.obl_id', 'comp_items.trader_premium', 'comp_items.logo_file',
                    'comp_items.short', 'comp_items.add_date',
                    'comp_items.visible', 'comp_items.obl_id',
                    'comp_items.title', 'comp_items.trader_price_avail',
                    'comp_items.trader_price_visible',
                    'comp_items.phone', 'comp_items.phone2', 'comp_items.phone3')

                ->orderBy('comp_items.trader_premium', 'desc')
                ->orderBy('comp_items.trader_sort')
                ->orderBy('comp_items.rate_formula' , 'desc')
                ->orderBy('comp_items.title')
                ->get()
                ->toArray();
        }

        $traders = $this->add_data_traders($traders);

        //dd($traders);

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
