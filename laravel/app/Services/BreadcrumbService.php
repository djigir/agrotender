<?php


namespace App\Services;


class BreadcrumbService
{
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
        $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды", 'url' => null];

        if($data['port_translit'] != null && $data['port_translit'] == 'all'){
            $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды".'<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => null];
            $breadcrumbs_trad_forward[1] = ['name' => !$data['culture_name'] ? "Форвардная цена на аграрную продукцию в портах Украины"
                : "Форвардная цена на {$data['culture_name']} в портах Украины", 'url' => null];
        }

        if($data['region'] != null && $data['region_translit'] == 'ukraine'){
            $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды".'<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => null];
            $breadcrumbs_trad_forward[1] = ['name' => !$data['culture_name'] ? "Форвардная цена на аграрную продукцию" : "Форвардная цена на {$data['culture_name']} в Украине", 'url' => null];
        }

        if($data['region'] && $data['culture'] && $data['region_translit'] != 'ukraine')
        {
            $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды".'<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => null];
            if($data['culture_name']){
                $breadcrumbs_trad_forward[1] = ['name' => "Форварды {$data['culture_name']}".'<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>' , 'url' => route('traders_forward.region_culture',['ukraine', $data['culture']])];
                $breadcrumbs_trad_forward[2] = ['name' => "Форвардная цена на {$data['culture_name']} в {$data['region']['parental']} области" , 'url' => null];
            }else{
                $breadcrumbs_trad_forward[1] = ['name' => "Форвардная цена на аграрную продукцию в {$data['region']['parental']} области" , 'url' => null];
            }
        }

        if($data['port'] && $data['culture'] && $data['port_translit'] != 'all')
        {
            $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды".'<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => null];
            if($data['culture_name']){
//                $breadcrumbs_trad_forward[1] = ['name' => "Форварды {$data['culture_name']}".'<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>' , 'url' => route('traders_forward.port_culture',['all', $data['culture']])];
                $breadcrumbs_trad_forward[1] = ['name' => "Форвардная цена на {$data['culture_name']} в {$data['port']['portname']}" , 'url' => null];
            }else {
                $breadcrumbs_trad_forward[1] = ['name' => "Форвардная цена на аграрную продукцию в {$data['port']['portname']}", 'url' => null];
            }

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
        $breadcrumbs_comp[0] = ['name' => 'Компании в Украине', 'url' => null];

        if($data['region'] != 'ukraine' && $data['region']){
            $breadcrumbs_comp[0] = ['name' => "Компании в {$data['region']['parental']} области " , 'url' => null];
        }

        if($data['region'] == 'ukraine' && !empty($data['rubric_id'])) {
            $breadcrumbs_comp[0] = ['name' => "Компании в Украине" . '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => route('company.region', $data['region'])];
            $breadcrumbs_comp[1] = ['name' => "Каталог - {$data['culture_name']} хозяйства Украины", 'url' => null];
        }

        if ($data['region'] && $data['rubric_id'] && $data['region'] != 'ukraine'){
            $breadcrumbs_comp[0] = ['name' => "Компании в {$data['region']['parental']} области " . '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => route('company.region', $data['region']['translit'])];
            $breadcrumbs_comp[1] = ['name' => "Каталог - {$data['culture_name']} хозяйства {$data['region']['city_parental']} ", 'url' => null];
        }

        return $breadcrumbs_comp;
    }
}
