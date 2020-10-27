<?php

namespace App\Services\Traders;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopic;
use App\Models\Comp\CompTopicItem;
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

        $topic_counts = CompTopicItem::select(['item_id', \DB::raw('count(*) as cnt')])
            ->groupBy('item_id')
            ->get()
            ->keyBy('item_id')
            ->toArray();


        foreach ($groups as $index_group => $group){
            $groups[$index_group]['index_group'] = $index_group;
        }

        $groups = collect($groups)->groupBy("index_group")->toArray();

        $groups = $this->group_array($groups);

        foreach ($groups as $index => $rubric) {
            foreach ($rubric['products'] as $index2 =>  &$topic) {
                if (!isset($topic_counts[$topic['id']])) {
                    continue;
                }
                $groups[$index]['products'][$index2]['cnt'] = $topic_counts[$topic['id']]['cnt'];
            }
            $rubrics[$index] = $rubric;
        }

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
        $obl_id = null;

        if($region && $region != 'ukraine'){
            $obl_id = Regions::where('translit', $region)->value('id');
        }
        $traders = CompItems::where([['trader_price_forward_avail', 1], ['trader_price_forward_visible', 1], ['visible', 1]])
            ->with(['traders_prices' => function($prices) use($culture, $obl_id)
                {
                    $prices->where([['acttype', 3], ['active', 1], ['cult_id', TradersProducts::where('url', $culture)->value('id')]])
                    ->with(['traders_places' => function($places)use($culture, $obl_id){$places->where(function ($check) use($culture, $obl_id){
                        if ($obl_id) {$check->where('obl_id', $obl_id);}
                    });}]);
                }
            ])
            ->select('title', 'author_id', 'id', 'logo_file', 'trader_premium', 'trader_sort', 'rate_formula')
            ->orderBy('trader_premium', 'desc')
            ->orderBy('trader_sort')
            ->orderBy('rate_formula', 'desc')
            ->orderBy('title')
            ->get()
            ->toArray();

        foreach ($traders as $index_trader => $trader)
        {
            foreach ($trader['traders_prices'] as $index => $prices){
                if(isset($prices['traders_places'][0])){
                    $traders[$index_trader]['traders_prices'][$index]['place'] = $prices['traders_places'][0]['place'];
                    $traders[$index_trader]['traders_prices'][$index]['region'] = $prices['traders_places'][0]['region'];
                    unset($traders[$index_trader]['traders_prices'][$index]['traders_places']);
                }

                if(empty($prices['traders_places'])){
                    unset($traders[$index_trader]['traders_prices'][$index]);
                }
            }

            $traders[$index_trader]['traders_prices'] = collect($traders[$index_trader]['traders_prices'])->sortByDesc('place')->toArray();
            $traders[$index_trader]['traders_prices'] = array_values($traders[$index_trader]['traders_prices']);

            if(empty($traders[$index_trader]['traders_prices'])){
                unset($traders[$index_trader]);
            }
        }

        $traders = array_values($traders);

        return $traders;
    }

    public function getTradersSell($region, $culture)
    {

    }

    public function setQuery()
    {
        $this->query = CompItems::join('traders_prices', 'comp_items.author_id',  '=', 'traders_prices.buyer_id');
    }

    public function getTradersRegionPortCulture($data)
    {
        $obl_id = null;
        $culture = null;

        if($data['port']&& $data['port'] != 'all'){
            $obl_id = TradersPorts::where('url', $data['port'])->value('obl_id');
        }

        if($data['region'] && $data['region'] != 'ukraine'){
            $obl_id = Regions::where('translit', $data['region'])->value('id');
        }

        if($data['culture']){
            $culture = TradersProducts::where('url', $data['culture'])->value('id');
        }

        $this->setQuery();

        $traders = $this->query->where([
            ['comp_items.trader_price_avail', 1],
            ['comp_items.trader_price_visible', 1],
            ['comp_items.visible', 1],
            [function ($query) use($culture){
                if($culture)
                    $query->where('traders_prices.cult_id', $culture);
            }],
            [function ($query) use($obl_id){
                if($obl_id)
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
