<?php


namespace App\Services;


class BreadcrumbService
{
    const PURCHASE_PRICE = [14 => '', 80 => '', 8 => ''];

    const FARMS = [10 => '', 11 => '', 12 => ''];

    const REGION_CULTURE = [
        2 => [
            8 => 'Цена пшеницы 2 класса в Виннице от трейдеров',
            26 => 'Цена сои на закупке у трейдеров Винницы',
            54 => 'Закупочные цены соевого масла в Виннице',
            17 => 'Стоимость сорго красного оптом у трейдеров Винницы'
        ],
        3 => [
          32 => 'Закупочные цены жмыха подсолнечного в Волыне',
          54 => 'Цены масла сои у трейдеров Волыни',
          35 => 'Цены от закупщиков шрота подсолнечного в Волыне'
        ],
        4 => [
          38 => 'Продажа овса по ценам трейдеров в Днепре',
          8 => 'Цена пшеницы 2 класса в Днепре от зернотрейдеров',
          57 => 'Актуальные цены на рожь в Днепре от трейдеров',
          13 => 'Цены трейдеров на яровой ячмень от Agrotender.com.ua',
          24 => 'Подсолнечник оптом - цена за тонну в Днепропетровской области',
          25 => 'Все закупочные цены на рапс оптом в Днепре',
          46 => 'Цена горчицы желтой от оптовых закупщиков Днепра',
          16 => 'Оптовые цены сорго белого у трейдеров Днепра'
        ],
        5 => [
          18 => 'Стоимость проса желтого оптом у трейдеров Донецка',
        ],
        6 => [
          27 => 'Все цены закупки желтого гороха в Житомире',
          39 => 'Оптовые цены льна у трейдеров Житомира'
        ],
        8 => [
          28 => 'Стоимость нута оптом у трейдеров закупающих в Запорожье',
          16 => 'Закупочная цена сорго белого от зернотрейдеров Запорожья'
        ],
        10 => [
          14 => 'Оптовые цены трейдеров на кукурузу в Киеве',
          38 => 'Продать овес оптом в Киеве по актуальным ценам трейдеров',
          8 => 'Цена пшеницы 2 класса в Киеве от трейдеров',
          57 => 'Закупка ржи в Киеве по цене трейдеров',
          13 => 'Закупка ячменя в Киеве по выгодной цене от зернотрейдеров',
          24 => 'Оптовая цена семечка подсолнечника на экспорт в Киеве',
          25 => 'Продать урожай рапса в Киеве по выгодной цене',
          48 => 'Все цены закупщиков зеленого гороха в Киеве',
          26 => 'Цена закупки сои от всех трейдеров Киева',
          55 => 'Цена отрубей пшеничных на закупке в Киеве',
          35 => 'Закупочные цены подсолнечного шрота в Киеве',
          45 => 'Стоимость продажи горчицы белой закупщикам Киевской области',
          46 => 'Стоимость продажи горчицы желтой в Киевской области',
          28 => 'Продажа нута в Киеве по закупочным ценам трейдеров'
        ],
        11 => [
            45 => 'Цена горчицы белой от оптовых закупщиков Кропивницкого'
        ],
        13 => [
            54 => 'Закупочные цены соевого масла от трейдеров Львова'
        ],
        14 => [
            14 => 'Продать кукурузу в Николаеве по выгодной цене',
            8 => 'Цена пшеницы 2 класса в Николаеве от зернотрейдеров',
            57 => 'Цена закупки ржи в Николаеве сегодня - предложения трейдеров',
            13 => 'Цена на ячмень в Николаеве - предложения трейдеров',
            25 => 'Актуальные цены на рапс у трейдеров в Николаеве',
            27 => 'Актуальные цены трейдеров на желтый горох в Николаеве',
            48 => 'Цена зеленого гороха в Николаеве от реальных трейдеров',
            55 => 'Рыночная цена отрубей пшеничных у трейдеров и переработчиков Николаева',
            35 => 'Цены шрота подсолнечного на экспорт в Николаеве',
            45 => 'Цена продажи горчицы белой трейдерам Николаева',
            22 => 'Закупочная цена гречихи от зернотрейдеров Николаева',
            28 => 'Закупочная цена нута от зернотрейдеров Николаева'
        ],
        15 => [
            14 => 'Цена кукурузы от зернотрейдеров Одессы',
            38 => 'Закупочные цены овса на опте от трейдеров в Одессе',
            8 => 'Цена пшеницы 2 класса в Одессе от зернотрейдеров',
            57 => 'Цена тонны ржи у трейдеров Одесской области на Agrotender.com.ua',
            13 => 'Цены на продажу зерна ячменя в Одессе',
            24 => 'Лучшие закупочные цены на подсолнечник в Одессе',
            25 => 'Закупка рапса оптом по ценам зернотрейдеров в Одессе',
            27 => 'Цена на желтый горох от экспортеров и трейдеров Одессы',
            48 => 'Экспортные цены на зеленый горох от трейдеров Одессы',
            26 => 'Экспортная цена сои от трейдеров Одессы',
            32 => 'Рыночная цена жмыха подсолнечного у закупщиков в Одессе',
            54 => 'Цены масла соевого на экспорт в Одессе',
            55 => 'Цена отрубей пшеничных на экспорт в Одессе',
            35 => 'Цены шрота подсолнуха у трейдеров и переработчиков Одессы',
            45 => 'Продажа горчицы белой в Одессе по ценам трейдеров',
            46 => 'Закупочная цена горчицы желтой от зернотрейдеров Одессы',
            22 => 'Продажа гречихи в Одессе по ценам трейдеров',
            18 => 'Закупочная цена проса желтого от зернотрейдеров Одессы',
            19 => 'Продажа проса красного в Одессе по рыночной цене',
            16 => 'Продажа сорго белого в Одессе по рыночной цене',
            17 => 'Оптовые цены сорго красного у трейдеров Одессы'
        ],
        16 => [
            8 => 'Цена пшеницы 2 класса в Полтаве от трейдеров',
            16 => 'Стоимость сорго белого оптом у трейдеров Полтавы'
        ],
        17 => [
            32 => 'Закупочные цены жмыха подсолнечного от трейдеров Ровно',
            54 => 'Цены от закупщиков масла соевого в Ровно',
            39 => 'Продажа льна в Ровно по ценам трейдеров',
        ],
        18 => [
            27 => 'Закупочные цены трейдеров на горох желтый в Сумах'
        ],
        19 => [
            48 => 'Закупочные цены на зеленый горх в Тернополе',
            22 => 'Оптовые цены гречихи у трейдеров Тернополя',
        ],
        20 => [
            14 => 'Цены на закупку кукурузы на элеваторах и с места в Харькове',
            38 => 'Где продать овес оптом в Харькове по выгодной цене',
            8 => 'Цена пшеницы 2 класса в Харькове от зернотрейдеров',
            13 => 'Закупочная цена ячменя по ценам агротрейдеров в Харькове',
            24 => 'Цена продажи подсолнечника зернотрейдерам в Харькове',
            25 => 'Купить рапс по цене трейдеров выгодно в Харькове',
            27 => 'Продать горох желтый по высокой цене трейдерам Харькова',
            48 => 'Цены зеленого гороха в Харькове от оптовых закупщиков',
            55 => 'Закупочные цены отрубей пшеничных в Харькове',
            46 => 'Оптовые цены горчицы желтой у трейдеров Харькова',
            39 => 'Цена льна от оптовых закупщиков Харькова',
            28 => 'Оптовые цены нута у трейдеров Харькова',
            18 => 'Цена проса желтого у закупщиков в Харькове',
            19 => 'Оптовые цены проса красного у трейдеров Харькова',
            17 => 'Закупочная цена сорго красного от зернотрейдеров Харькова',
        ],
        21 => [
            8 => 'Цена пшеницы 2 класса в Херсоне от трейдеров',
            32 => 'Цены жмыха подсолнечного на закупке в Херсоне',
            55 => 'Закупочные цены отруби пшеничные от трейдеров Херсона',
            35 => 'Закупочные цены шрота подсолнечного от трейдеров Херсона',
            46 => 'Продажа горчицы желтой в Херсоне по ценам трейдеров',
            22 => 'Цена гречихи от оптовых закупщиков Херсона',
            19 => 'Стоимость проса красного оптом у трейдеров Херсона',
            16 => 'Цена сорго белого у закупщиков Херсона',
            17 => 'Продажа сорго красного в Херсоне по рыночной цене',
        ],
        22 => [
            26 => 'Цена сои в Хмельницком от оптовых закупщиков'
        ],
        23 => [
            14 => 'Цена кукурузы от основных закупщиков Черкасс',
            8 => 'Цена пшеницы 2 класса в Черкассах от зернотрейдеров',
            18 => 'Оптовые цены проса желтого у трейдеров Черкасс',
            19 => 'Цена проса красного у закупщиков Черкасс',
            17 => 'Цена сорго красного у закупщиков Черкасс',
        ],
        24 => [
            26 => 'Цена продажи сои трейдерам Чернигова',
            45 => 'Оптовые цены горчицы белой у трейдеров Чернигова',
            18 => 'Продажа проса желтого в Чернигове по высокой рыночной цене',
            19 => 'Закупочная цена проса красного от зернотрейдеров Чернигова',
        ],
    ];

    const AGROCHEMISTRY  = [
        42 => '-',
        31 => 'Пивоварни и Лекеро-водочные заводы',
        26 => 'Хлебзаводы, Пекарни и Кондитерки',
        37 => 'Оборудование для пчеловодства',
        36 => 'Оборудование для животноводства',
        40 => 'Оборудование для переработки',
        35 => 'Оборудование для растениеводства',
        38 => 'Оборудование для рыбоводства',
        44 => '-',
        43 => '-',
        52 => '-',
    ];



    const SERVICES = [51 => '', 53 => ''];
    const CHANGE_NAME = [
        17 => 'Кролиководы',
        13 => 'Овощеводы',
        20 => 'Рыбоводовы',
        14 => 'Фрукты и Ягоды',
        19 => 'Пчеловоды',
        16 => 'Свинофермы',
        29 => 'Грануляторщики',
        33 => 'Фасовщики',
        4 => 'Производители удобрений',
        31 => 'Пивоварни и Лекеро-водочные заводы',
        26 => 'Хлебзаводы, Пекарни и Кондитерки',
        27 => 'Переработчики мяса',
        32 => 'Молокозаводы',
        42 => 'Производители средств защиты',
        50 => 'Морской Транспорт',
        52 => 'Посев и Уборка Урожая',
        54 => 'Ремонт С/Х Техники',
        55 => 'Юредические Услуги',
    ];

    const NAME = [
        44 => 'Торговля Продукцией Животноводства в Украине',
        43 => 'Торговля Сельхозпродукцией в Украине',
        45 => 'Торговля Сельхозтехникой и Оборудованием в Украине',
        51 => 'Услуги по Хранению Урожая в Украине',
        52 => 'Посев и Уборка Урожая в Украине',
        53 => 'Услуги по Строительству в Украине',
        54 => 'Каталог – Ремонт С/Х Техники в Украине',
        55 => 'Каталог – Юредические Услуги в Украине',
    ];

    const NAME_REGION = [
        44 => 'Торговля Продукцией Животноводства в ',
        43 => 'Торговля Сельхозпродукцией в ',
        45 => 'Торговля Сельхозтехникой и Оборудованием в ',
        51 => 'Услуги по Хранению Урожая в ',
        52 => 'Посев и Уборка Урожая в ',
        53 => 'Услуги по Строительству в ',
        54 => 'Каталог – Ремонт С/Х Техники в ',
        55 => 'Каталог – Юредические Услуги в ',
    ];

    const OTHER_TEXT =
        [
        38 => 'Цены овса на закупке у агротрейдеров Украины сегодня',
        8 => 'Закупочная цена пшеницы 2 класса на сегодня в Украине',
        14 => 'Закупочная цена кукурузы на сегодня в Украине',
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


        if($data['region'] && $data['culture_name'] && $data['region_translit'] != 'ukraine'){
            $breadcrumbs_trad[0] = ['name' => "Цены трейдеров" .$arrow, 'url' => route('traders.region', 'ukraine')];
            $breadcrumbs_trad[1] = ['name' => "Цена {$data['culture_name']}".$arrow, 'url' => route('traders.region_culture', ['ukraine', $data['culture']])];
            $breadcrumbs_trad[2] = ['name' => "Цена {$data['culture_name']} в {$data['region']['parental']} области", 'url' => null];

            if(isset(self::REGION_CULTURE[$data['id_region']]) && isset(self::REGION_CULTURE[$data['id_region']][$data['culture_id']])){
                $breadcrumbs_trad[2]['name'] = self::REGION_CULTURE[$data['id_region']][$data['culture_id']];
            }
        }

        if($data['port'] && $data['culture_name'] && $data['port_translit'] != 'all'){
            $breadcrumbs_trad[0] = ['name' => "Цены трейдеров" .$arrow, 'url' => route('traders.port', 'all')];
            $breadcrumbs_trad[1] = ['name' => "Цена {$data['culture_name']}".$arrow, 'url' => route('traders.port_culture', ['all', $data['culture']])];
            $breadcrumbs_trad[2] = ['name' => "Цена на {$data['culture_name']} в {$data['port']['portname']}", 'url' => null];
        }


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
            $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды".$arrow, 'url' => route('traders_forward.port', 'all')];
            $breadcrumbs_trad_forward[1] = ['name' => "Форвардная цена на аграрную продукцию в {$data['port']['portname']}", 'url' => null];
        }

        if($data['port'] && $data['culture'] && $data['port_translit'] != 'all')
        {
            $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды".$arrow, 'url' => route('traders_forward.port', 'all')];
            if($data['culture_name']){
//                $breadcrumbs_trad_forward[1] = ['name' => "Форварды {$data['culture_name']}".'<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>' , 'url' => route('traders_forward.port_culture',['all', $data['culture']])];
                $breadcrumbs_trad_forward[1] = ['name' => "Форвардная цена на {$data['culture_name']} в {$data['port']['portname']}" , 'url' => null];
            }else {
                $breadcrumbs_trad_forward[1] = ['name' => "Форвардная цена на аграрную продукцию в {$data['port']['portname']}", 'url' => null];
            }

        }

        if($data['region'] != null && $data['region_translit'] == 'ukraine'){
            $breadcrumbs_trad_forward[0] = ['name' =>  '', 'url' => ''];
            $breadcrumbs_trad_forward[1] = ['name' => !$data['culture_name'] ? "Форвардная цена на аграрную продукцию" : "Форвардная цена на {$data['culture_name']} в Украине", 'url' => null];
        }

        if($data['region'] != null && $data['region_translit'] != 'ukraine'){
            $breadcrumbs_trad_forward[0] = ['name' => "Форварды".$arrow, 'url' => route('traders_forward.region', 'ukraine')];
            $breadcrumbs_trad_forward[1] = ['name' => "Форвардная цена на аграрную продукцию в {$data['region']['name']} области", 'url' => null];
        }

        if($data['region'] != null && $data['region_translit'] == 'ukraine' && $data['culture']){
            $breadcrumbs_trad_forward[0] = ['name' => "Форварды".$arrow, 'url' => route('traders_forward.region', 'ukraine')];
            $breadcrumbs_trad_forward[1] = ['name' => "Форвардная цена на {$data['culture_name']} в Украине", 'url' => null];
        }

        if($data['region'] && $data['culture'] && $data['region_translit'] != 'ukraine')
        {
            $breadcrumbs_trad_forward[0] = ['name' =>  "Форварды".$arrow, 'url' => route('traders_forward.region', 'ukraine')];

            if($data['culture_name']){
                $breadcrumbs_trad_forward[1] = ['name' => "Форварды {$data['culture_name']}".$arrow , 'url' => route('traders_forward.region_culture',['ukraine', $data['culture']])];
                $breadcrumbs_trad_forward[2] = ['name' => "Форвардная цена на {$data['culture_name']} в {$data['region']['name']} области" , 'url' => null];
            }else{
                $breadcrumbs_trad_forward[1] = ['name' => "Форвардная цена на аграрную продукцию в {$data['region']['parental']} области" , 'url' => null];
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

    public function setCatalogFarms($data)
    {
        $farms = '';
        $catalog = 'Каталог - ';

        if(isset(self::FARMS[$data['rubric_id']])){
            $farms = 'хозяйства';
        }

        if(isset(self::SERVICES[$data['rubric_id']])){
            $catalog = 'Услуги по';
        }

        if(isset(self::AGROCHEMISTRY[$data['rubric_id']])){
            $catalog = 'Производители';
            if(self::AGROCHEMISTRY[$data['rubric_id']] != ''){
                $catalog = '';
            }
        }

        return ['farms' => $farms, 'catalog' => $catalog];
    }

    public function setBreadcrumbsCompanies($data)
    {

        $breadcrumbs_comp[0] = ['name' => 'Компании в Украине', 'url' => null];

        if($data['region'] != 'ukraine' && $data['region']){
            $breadcrumbs_comp[0] = ['name' => "Компании в {$data['region']['parental']} области " , 'url' => null];
        }

        if($data['region'] == 'ukraine' && !empty($data['rubric_id'])) {
            $breadcrumbs_comp[0] = ['name' => "Компании в Украине" . '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => route('company.region', $data['region'])];

            $catalog_farm = $this->setCatalogFarms($data);

            if(isset(self::CHANGE_NAME[$data['rubric_id']])){
                $data['culture_name'] = self::CHANGE_NAME[$data['rubric_id']];
            }

            $breadcrumbs_comp[1] = ['name' => "{$catalog_farm['catalog']} {$data['culture_name']} {$catalog_farm['farms']} Украины", 'url' => null];

            if(isset(self::NAME[$data['rubric_id']])){
                $breadcrumbs_comp[1]['name'] = self::NAME[$data['rubric_id']];
            }
        }

        if ($data['region'] && $data['rubric_id'] && $data['region'] != 'ukraine'){
            $breadcrumbs_comp[0] = ['name' => "Компании в {$data['region']['parental']} области " . '<i style="margin-left: .5rem" class="fas fa-chevron-right extra-small"></i>', 'url' => route('company.region', $data['region']['translit'])];

            $catalog_farm = $this->setCatalogFarms($data);

            if(isset(self::CHANGE_NAME[$data['rubric_id']])){
                $data['culture_name'] = self::CHANGE_NAME[$data['rubric_id']];
            }

            $breadcrumbs_comp[1] = ['name' => "{$catalog_farm['catalog']} {$data['culture_name']} {$catalog_farm['farms']}  {$data['region']['city_parental']} ", 'url' => null];

//            if(isset(self::NAME[$data['rubric_id']])){
//                $breadcrumbs_comp[1]['name'] = self::NAME[$data['rubric_id']];
//            }

            if(isset(self::NAME_REGION[$data['rubric_id']])){
                $breadcrumbs_comp[1]['name'] = self::NAME_REGION[$data['rubric_id']]."{$data['region']['city_adverb']}";
            }
        }

        return $breadcrumbs_comp;
    }
}
