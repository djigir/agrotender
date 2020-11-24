<?php


namespace App\Services;


class BreadcrumbService
{
    const PURCHASE_PRICE = [14 => '', 80 => '', 8 => ''];

    const OTHER_TEXT = [38 => 'Цены овса на закупке у агротрейдеров Украины сегодня',
        73 => 'Цена, стоимость, экспорт, Овес голозерный, Украина',
        57 => 'Цены на рожь от агротрейдеров в Украине',
        13 => 'Цены трейдеров на закупку тонны ячменя в Украине',
        24 => 'Закупочная цена подсолнуха в Украине на сегодня',
        27 => 'Цена желтого гороха в Украине от зернотрейдеров на сегодня',
        48 => 'Актуальная цена закупки зеленого гороха в Украине',
        55 => 'Цены трейдеров на отруби пшеничные оптом в Украине',
        35 => 'Цены трейдеров на шрот подсолнечный высокопротеиновый оптом в Украине',
        45 => 'Цена горчицы белой оптом от трейдеров Украины',
        18 => 'Цены проса желтого оптом от трейдеров Украины',
        46 => 'Цены на горчицу жетую оптом от трейдеров Украины',
        19 => 'Цена на красное просо оптом от трейдеров Украины',
        50 => 'Цены на горчицу черную оптом от трейдеров Украины',
        22 => 'Цены на гречиху оптом от трейдеров Украины',
        16 => 'Цены сорго белого оптом у трейдеров Украины',
        49 => 'Цены на кориандр оптом от трейдеров Украины',
        17 => 'Цены на сорго красное оптом у трейдеров Украины',
        39 => 'Цены на лён оптом от трейдеров Украины',
        28 => 'Цены нута оптом от трейдеров Украины',
        25 => 'Закупочные цены рапса зернотрейдорами на Agrotender.com.ua',
        26 => 'Закупочная цена сои в Украине сегодня от трейдеров',
        54 => 'Закупочная цена соевого масла оптом в Украине от трейдеров',
    ];


    public function setBreadcrumbsTraders($data)
    {
        $breadcrumbs_trad[0] = ['name' => !empty($data['region_translit']) ? 'Цены трейдеров в Украине' : 'Цена на Аграрную продукцию в портах Украины', 'url' => null];
        $arrow = '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>';

        if($data['region_translit'] != 'ukraine' && !empty($data['region'])){
            $breadcrumbs_trad[0] = ['name' => 'Цены трейдеров'.$arrow , 'url' => route('traders.region', 'ukraine')];
            $breadcrumbs_trad[1] = ['name' => "Цена Аграрной продукции в {$data['region']['parental']} области", 'url' => null];
        }

        if($data['port_translit'] != 'all' && !empty($data['port'])){
            $breadcrumbs_trad[0] = ['name' => 'Цены трейдеров'.$arrow, 'url' => route('traders.region', 'ukraine')];
            $breadcrumbs_trad[1] = ['name' => "Цена на Аграрную продукцию в {$data['port']['portname']}", 'url' => null];
        }

        if($data['region_translit'] == 'ukraine' && !empty($data['culture_name'])){
            $breadcrumbs_trad[0] = ['name' => 'Цены трейдеров'.$arrow, 'url' => route('traders.region', $data['region_translit'])];

            $name_1 = "Цена {$data['culture_name']} в Украине";

            if(isset(self::PURCHASE_PRICE[$data['culture_id']])){
                $name_1 = "Закупочная цена {$data['culture_name']} на сегодня в Украине";
            }

            if(isset(self::OTHER_TEXT[$data['culture_id']])){
                $name_1 = self::OTHER_TEXT[$data['culture_id']];
            }

            $breadcrumbs_trad[1] = ['name' => $name_1, 'url' => null];
        }

        if($data['port_translit'] == 'all' && !empty($data['culture_name'])){
            $breadcrumbs_trad[0] = ['name' => 'Цены трейдеров'.$arrow, 'url' => route('traders.port', $data['port_translit'])];
            $breadcrumbs_trad[1] = ['name' => "Цена на {$data['culture_name']} в портах Украины", 'url' => null];
        }

//        if(($data['region_translit'] == 'ukraine' || $data['port_translit'] == 'all') && !empty($data['culture_name']))
//        {
//            $breadcrumbs_trad[0] = ['name' => 'Цены трейдеров'.$arrow,
//                'url' => !empty($data['region_translit']) ? route('traders.region', $data['region_translit']) :
//                    route('traders.port', $data['port_translit'])];
//            $breadcrumbs_trad[1] = ['name' => !empty($data['region_translit']) ?
//                "Закупочная цена {$data['culture_name']} на сегодня в Украине" : "Цена на {$data['culture_name']} в портах Украины", 'url' => null];
//        }

        if($data['region'] && $data['culture_name'] && $data['region_translit'] != 'ukraine'){
            $breadcrumbs_trad[0] = ['name' => "Цены трейдеров" .$arrow, 'url' => route('traders.region', 'ukraine')];
            $breadcrumbs_trad[1] = ['name' => "Цена {$data['culture_name']}".$arrow, 'url' => route('traders.region_culture', ['ukraine', $data['culture']])];
            $breadcrumbs_trad[2] = ['name' => "Цена {$data['culture_name']} в {$data['region']['parental']} области", 'url' => null];
        }

        if($data['port'] && $data['culture_name'] && $data['port_translit'] != 'all'){
            $breadcrumbs_trad[0] = ['name' => "Цены трейдеров" .$arrow, 'url' => route('traders.port', 'all')];
            $breadcrumbs_trad[1] = ['name' => "Цена {$data['culture_name']}".$arrow, 'url' => route('traders.port_culture', ['all', $data['culture']])];
            $breadcrumbs_trad[2] = ['name' => "Цена на {$data['culture_name']} в {$data['port']['portname']}", 'url' => null];
        }
//        if (($data['region'] || $data['port']) && $data['culture_name'] && $data['region_translit'] != 'ukraine' && $data['port_translit'] != 'all'){
//            $breadcrumbs_trad[0] = ['name' => "Цены трейдеров" . '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' =>
//                !empty($data['region_translit']) ? route('traders.region', 'ukraine') :
//                    route('traders.port', 'all')];
//
//            $breadcrumbs_trad[1] = ['name' => "Цена {$data['culture_name']}". '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' =>
//                !empty($data['region_translit']) ? route('traders.region_culture', ['ukraine', $data['culture']]) :
//                    route('traders.port_culture', ['all', $data['culture']])];
////            !empty($data['region_translit']) ? "Цена {$data['culture_name']} в {$data['region']['parental']} области" :
//
//            $breadcrumbs_trad[2] = ['name' =>
//                !empty($data['region_translit']) ? "Оптовые цены трейдеров на {$data['culture_name']} в {$data['region']['city_adverb']}" :
//                    "Цена на {$data['culture_name']} в {$data['port']['portname']}", 'url' => null];
//
//        }

        return $breadcrumbs_trad;
    }


    public function setBreadcrumbsTradersForward($data)
    {
        $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды", 'url' => null];
        $arrow = '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>';

        if($data['port_translit'] != null && $data['port_translit'] == 'all'){
            $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды".$arrow, 'url' => null];
            $breadcrumbs_trad_forward[1] = ['name' => !$data['culture_name'] ? "Форвардная цена на аграрную продукцию в портах Украины"
                : "Форвардная цена на {$data['culture_name']} в портах Украины", 'url' => null];
        }

        if($data['port_translit'] != null && $data['port_translit'] != 'all'){
            $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды".$arrow, 'url' => null];
            $breadcrumbs_trad_forward[1] = ['name' => "Форвардная цена на аграрную продукцию в {$data['port']['portname']}", 'url' => null];
        }

        if($data['region'] != null && $data['region_translit'] == 'ukraine'){
            $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды".$arrow, 'url' => route('traders_forward.region', 'ukraine')];
            $breadcrumbs_trad_forward[1] = ['name' => !$data['culture_name'] ? "Форвардная цена на аграрную продукцию" : "Форвардная цена на {$data['culture_name']} в Украине", 'url' => null];
        }

        if($data['region'] != null && $data['region_translit'] != 'ukraine'){
            $breadcrumbs_trad_forward[0] = ['name' => "Форварды".$arrow, 'url' => null];
            $breadcrumbs_trad_forward[1] = ['name' => "Форвардная цена на аграрную продукцию в {$data['region']['name']} области", 'url' => null];
        }

        if($data['region'] && $data['culture'] && $data['region_translit'] != 'ukraine')
        {
            $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды".$arrow, 'url' => null];

            if($data['culture_name']){
                $breadcrumbs_trad_forward[1] = ['name' => "Форварды {$data['culture_name']}".$arrow , 'url' => route('traders_forward.region_culture',['ukraine', $data['culture']])];
                $breadcrumbs_trad_forward[2] = ['name' => "Форвардная цена на {$data['culture_name']} в {$data['region']['name']} области" , 'url' => null];
            }else{
                $breadcrumbs_trad_forward[1] = ['name' => "Форвардная цена на аграрную продукцию в {$data['region']['parental']} области" , 'url' => null];
            }
        }

        if($data['port'] && $data['culture'] && $data['port_translit'] != 'all')
        {
            $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды".$arrow, 'url' => null];
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
