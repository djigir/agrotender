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
    protected $query;

    public function __construct(CompanyService $companyService, BaseServices $baseService)
    {
        $this->companyService = $companyService;
        $this->baseService = $baseService;
        $this->query = null;
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

    public function setQuery()
    {
        $this->query = CompItems::join('traders_prices', 'comp_items.author_id',  '=', 'traders_prices.buyer_id');
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


    public function getTradersForward($region, $culture)
    {
        $this->setQuery();

        $traders = CompItems::where([['trader_price_forward_avail', 1], ['trader_price_forward_visible', 1],
            ['visible', 1]])->with(['traders_prices' => function($query) use($culture){
            $query->where([['acttype', 3], ['active', 1], ['cult_id', TradersProducts::where('url', $culture)->value('id')]]);
        }])->select('title', 'author_id', 'id', 'logo_file', 'trader_premium', 'trader_sort', 'rate_formula')
            ->orderBy('trader_premium', 'desc')
            ->orderBy('trader_sort')
            ->orderBy('rate_formula' , 'desc')
            ->orderBy('title')
            ->get()
            ->toArray();

        foreach ($traders as $index_trader => $trader)
        {
            if(empty($trader['traders_prices'])){
                unset($traders[$index_trader]);
            }else{
                foreach ($trader['traders_prices'] as $index_price => $price)
                {
                    $traders[$index_trader]['traders_prices'][$index_price]['region'] = $price['places']['region'];
                    $traders[$index_trader]['traders_prices'][$index_price]['place_name'] = $price['places']['place'];
                    unset($traders[$index_trader]['traders_prices'][$index_price]['places']);
                }
            }
            if(isset($traders[$index_trader]))
            $traders[$index_trader]['traders_prices'] = collect($traders[$index_trader]['traders_prices'])->sortByDesc('place_name')->toArray();

        }

        $traders = array_values($traders);

        return $traders;
    }

    public function getTradersSell($region, $culture)
    {

    }


    public function getTradersRegionPortCulture($data)
    {
        $obl_id = null;
        $culture = null;

        if($data['port'] != null and $data['port'] != 'all'){
            $obl_id = TradersPorts::where('url', $data['port'])->value('obl_id');
        }

        if($data['region'] != null and $data['region'] != 'ukraine'){
            $obl_id = Regions::where('translit', $data['region'])->value('id');
        }

        if($data['culture'] != null){
            $culture = TradersProducts::where('url', $data['culture'])->value('id');
        }

        $this->setQuery();

        $traders = $this->query->where([
            ['comp_items.trader_price_avail', 1],
            ['comp_items.trader_price_visible', 1],
            ['comp_items.visible', 1],
            [function ($query) use($obl_id){
                if($obl_id != null)
                    $query->where('obl_id', $obl_id);
            }],
            [function ($query) use($data){
                if (!empty($data['query']) && isset($data['query']['currency'])) {
                    $query->where('traders_prices.curtype', $data['query']['currency']);
                }
            }]])
            ->select('comp_items.id', 'comp_items.title', 'comp_items.author_id', 'comp_items.logo_file', 'comp_items.trader_premium')
            ->orderBy('comp_items.trader_premium', 'desc')
            ->orderBy('comp_items.trader_sort')
            ->orderBy('comp_items.rate_formula' , 'desc')
            ->orderBy('comp_items.title')
            ->groupBy('id')
            ->get()
            ->toArray();

        if($obl_id != null and $data['culture'] != null){
            $traders = $this->query->join('comp_item2topic', 'comp_items.id', '=', 'comp_item2topic.item_id')
                ->where([
                    ['comp_item2topic.topic_id', $culture],
                    ['trader_price_avail', 1],
                    ['trader_price_visible', 1],
                    ['visible', 1],
                    [function ($query) use($obl_id){
                        if($obl_id != null){
                            $query->where('comp_items.obl_id', $obl_id);
                        }
                    }],
                    [function ($query) use($data){
                        if (!empty($data['query']) && isset($data['query']['currency'])) {
                            $query->where('traders_prices.curtype', $data['query']['currency']);
                        }
                    }]])
                ->select('comp_items.id', 'comp_items.author_id', 'comp_items.trader_premium',
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
                ->groupBy('id')
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
