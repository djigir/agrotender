<?php


namespace App\Services;


use App\Models\Regions\Regions;

class BaseServices
{
    public function getRegions()
    {
        return Regions::get()->push(['name' => 'Вся Украина', 'translit' => 'ukraine'])->toArray();
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

    public function setBreadcrumbsTraders($data)
    {
        $breadcrumbs_trad[0] = ['name' => !empty($data['region_translit']) ? 'Цены трейдеров в Украине' : 'Цена на Аграрную продукцию в портах Украины', 'url' => null];

        if($data['region_translit'] != 'ukraine' && !empty($data['region'])){
            $breadcrumbs_trad[0] = ['name' => 'Цены трейдеров'. '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => route('traders.region', 'ukraine')];
            $breadcrumbs_trad[1] = ['name' => "Цена Аграрной продукции в {$data['region']['parental']} области", 'url' => null];
        }

        if(($data['region_translit'] == 'ukraine' || $data['port_translit'] == 'all') && !empty($data['culture_name']))
        {
            $breadcrumbs_trad[0] = ['name' => 'Цены трейдеров'. '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>',
                'url' => !empty($data['region_translit']) ? route('traders.region', $data['region_translit']) :
                route('traders.port', $data['port_translit'])];
            $breadcrumbs_trad[1] = ['name' => !empty($data['region_translit']) ?
                "Закупочная цена {$data['culture_name']} на сегодня в Украине" : "Цена на {$data['culture_name']} в портах Украины", 'url' => null];
        }

        if (($data['region'] || $data['port']) && $data['culture_id'] && $data['region_translit'] != 'ukraine' && $data['port_translit'] != 'all'){
            $breadcrumbs_trad[0] = ['name' => "Цены трейдеров" . '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' =>
                !empty($data['region_translit']) ? route('traders.region', 'ukraine') :
                    route('traders.port', 'all')];

            $breadcrumbs_trad[1] = ['name' => "Цена {$data['culture_name']}". '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' =>
                !empty($data['region_translit']) ? route('traders.region_culture', ['ukraine', $data['culture']]) :
                route('traders.port_culture', ['all', $data['culture']])];

            $breadcrumbs_trad[2] = ['name' =>
                !empty($data['region_translit']) ? "Оптовые цены трейдеров на {$data['culture_name']} в {$data['region']['city_adverb']}" :
                "Цена на {$data['culture_name']} в {$data['port']['portname']}", 'url' => null];
        }

        return $breadcrumbs_trad;
    }


    public function setBreadcrumbsTradersForward($data)
    {
        $breadcrumbs_trad_forward[0] =
            !$data['culture_name'] ?
            ['name' =>  "Форварды", 'url' => null] : ['name' =>  "Форварды". '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => null];

        $breadcrumbs_trad_forward[1] = $data['port_translit'] != 'all' ? ['name' => "Форвардная цена на {$data['culture_name']} в {$data['port']['portname']}", 'url' => null] : ['name' => "Форвардная цена на {$data['culture_name']} в портах Украины", 'url' => null];

        if($data['region'] && $data['culture_id'] && $data['region_translit'] != 'ukraine')
        {
            $breadcrumbs_trad_forward[1] = ['name' => "Форварды {$data['culture_name']}". '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>' , 'url' => route('traders_forward.region_culture',['ukraine', $data['culture']])];
            $breadcrumbs_trad_forward[2] = ['name' => "Форвардная цена на {$data['culture_name']} в {$data['region']['parental']} области" , 'url' => null];
        }

        return $breadcrumbs_trad_forward;
    }


    public function setBreadcrumbsTradersSell($data)
    {
        $breadcrumbs_trad_sell[0] = ['name' => "Продажи трейдеров", 'url' => null];

        if($data['region_translit'] != 'ukraine' && $data['region']){
            $breadcrumbs_trad_sell[0] = ['name' => "Продажи трейдеров". '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => route('traders_sell.region', 'ukraine')];
            $breadcrumbs_trad_sell[1] = ['name' => "Аграрная продукция: предложения от трейдеров и переработчиков в {$data['region']['parental']} области", 'url' => null];
        }

        if($data['region_translit'] != 'ukraine' && $data['region'] && $data['culture_id'])
        {
            $breadcrumbs_trad_sell[0] = ['name' => "Продажи трейдеров". '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => route('traders_sell.region', 'ukraine')];
            $breadcrumbs_trad_sell[1] = ['name' => "{$data['culture_name']}: предложения от трейдеров и переработчиков в {$data['region']['parental']} области", 'url' => ''];
        }

        return $breadcrumbs_trad_sell;
    }

    public function setBreadcrumbsCompanies($data)
    {
        $breadcrumbs_comp[0] = ['name' => 'Комании в Украине', 'url' => null];

        if($data['region'] != 'ukraine' && $data['region']){
            $breadcrumbs_comp[0] = ['name' => "Комании в {$data['region']['parental']} области " , 'url' => null];
        }

        if($data['region'] == 'ukraine' && !empty($data['rubric_id'])) {
            $breadcrumbs_comp[0] = ['name' => "Комании в Украине" . '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => route('company.region', $data['region'])];
            $breadcrumbs_comp[1] = ['name' => "Каталог - {$data['culture_name']} хозяйства Украины", 'url' => null];
        }

        if ($data['region'] && $data['rubric_id'] && $data['region'] != 'ukraine'){
            $breadcrumbs_comp[0] = ['name' => "Комании в {$data['region']['parental']} области " . '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => route('company.region', $data['region']['translit'])];
            $breadcrumbs_comp[1] = ['name' => "Каталог - {$data['culture_name']} хозяйства {$data['region']['city_parental']} ", 'url' => null];
        }

        return $breadcrumbs_comp;
    }
}
