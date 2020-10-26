@extends('layout.layout')

@section('content')
    <div class="d-none d-sm-block container mt-3">
        <ol class="breadcrumbs small p-0">
            <li>
                <a href="/">
                    <span>Главная</span>
                </a>
            </li>
            <i class="fas fa-chevron-right extra-small"></i>
            @if($region != 'ukraine')
                <li>
                    <a href="/traders_forwards">
                        <span>Форварды</span>
                    </a>
                </li>
                <i class="fas fa-chevron-right extra-small"></i>
                <li>
                    <h1>
                        Форвардная цена на аграрную продукцию в {{$region_name}}
                    </h1>
                </li>
            @else
                <li>
                    <a href="#">
                        <span>Форвардная цена на аграрную продукцию</span>
                    </a>
                </li>
            @endif
        </ol>
    </div>
    <div class="d-none d-sm-block container mt-5">
        <div class="content-block mt-3 py-3 px-3">
            <div class="btn-group position-relative w-100 ">
                <div class="col pl-1">
                    <button class="btn typeInput text-center drop-btn">Форварды <i class="ml-2 small far fa-chevron-down"></i></button>
                </div>
                <div class="dropdown-wrapper position-absolute typeDrop">
                    <div class="dropdown">
                        <div class="section text-left">
                            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                            <div class="row">
                                <div class="col">
                                    <a class="inline-link" href="/traders/region_ukraine">
                                        <span>Закупки</span>
                                        <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                    </a>
                                    <a class="inline-link" href="/traders_sell">
                                        <span>Продажи</span>
                                        <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                    </a>
                                    <a class="inline-link" href="/traders_analitic/region_ukraine">
                                        <span>Аналитика закупок</span>
                                        <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                    </a>
                                    <a class="inline-link" href="/traders_analitic_sell">
                                        <span>Аналитика продаж</span>
                                        <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-1 mx-1">
                    <button class="btn rubricInput text-center drop-btn blue-shadow">Выбрать продукцию <i class="ml-2 small far fa-chevron-down"></i></button>
                </div>
                <div class="dropdown-wrapper position-absolute rubricDrop">
                    <div class="dropdown">
                        <div class="section text-left">
                            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                            <div class="row">
                                <div class="col-auto">
                                    <a class="rubricLink getRubricGroup" href="#" group="1">
                    <span>
                      Зерновые</span>
                                        <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                    </a>
                                </div>
                                <div class="col-auto rubricGroup pr-0 mr-3 group-1">
                                    <a rid="14" class="rubricLink" href="/traders_forwards/region_kyiv/kukuruza">
                                        <span>Кукуруза (0)</span>
                                    </a>
                                    <a rid="8" class="rubricLink" href="/traders_forwards/region_kyiv/pshenica_2_kl">
                                        <span>Пшеница 2 кл. (0)</span>
                                    </a>
                                </div>
                                <div class="col-auto rubricGroup pr-0 mr-3 group-1">
                                    <a rid="9" class="rubricLink" href="/traders_forwards/region_kyiv/pshenica_3_kl">
                                        <span>Пшеница 3 кл. (0)</span>
                                    </a>
                                    <a rid="10" class="rubricLink" href="/traders_forwards/region_kyiv/pshenica_4_kl">
                                        <span>Пшеница 4 кл. (0)</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 mx-1">
                    <button class="btn regionInput text-center drop-btn align-self-center">
                        Киевская область
                        <i class="ml-2 small far fa-chevron-down"></i>
                    </button>
                </div>
                <div class="dropdown-wrapper position-absolute regionDrop">
                    <div class="dropdown">
          <span class="d-block">
            <a class="regionLink d-inline-block" href="/traders_forwards/region_ukraine">
            <span>Вся Украина</span>
          </a>
          <a class="regionLink d-inline-block" href="/traders_forwards/region_crimea">
            <span>АР Крым</span>
          </a>
          </span>
                        <hr class="mt-1 mb-2">
                        <div class="section text-left">
                            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                            <div class="row">
                                <div class="col">
                                    <a class="regionLink" href="/traders_forwards/region_vinnica">
                                        <span>Винницкая область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_volin">
                                        <span>Волынская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_dnepr">
                                        <span>Днепропетровская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_donetsk">
                                        <span>Донецкая область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_zhitomir">
                                        <span>Житомирская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_zakorpat">
                                        <span>Закарпатская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_zaporizh">
                                        <span>Запорожская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_ivanofrank">
                                        <span>Ивано-Франковская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="regionLink active" href="/traders_forwards/region_kyiv">
                                        <span>Киевская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_kirovograd">
                                        <span>Кировоградская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_lugansk">
                                        <span>Луганская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_lviv">
                                        <span>Львовская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_nikolaev">
                                        <span>Николаевская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_odessa">
                                        <span>Одесская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_poltava">
                                        <span>Полтавская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_rovno">
                                        <span>Ровенская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="regionLink" href="/traders_forwards/region_sumy">
                                        <span>Сумская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_ternopil">
                                        <span>Тернопольская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_kharkov">
                                        <span>Харьковская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_kherson">
                                        <span>Херсонская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_khmelnitsk">
                                        <span>Хмельницкая область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_cherkassi">
                                        <span>Черкасская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_chernigov">
                                        <span>Черниговская область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/region_chernovci">
                                        <span>Черновицкая область</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <span class="d-block">
            <a class="regionLink d-inline-block" href="/traders_forwards/tport_all">
            <span>Все порты</span>
          </a>
          </span>
                        <hr class="mt-1 mb-2">
                        <div class="section text-left">
                            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                            <div class="row">
                                <div class="col">
                                    <a class="regionLink" href="/traders_forwards/tport_berdjansk">
                                        <span>Бердянский МП</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/tport_mariupolskij">
                                        <span>Мариупольский МП</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/tport_navallogistik">
                                        <span>Наваль Логистик</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/tport_nikatera">
                                        <span>Ника-Тера</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/tport_nikolaevskij">
                                        <span>Николаевский МП</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="regionLink" href="/traders_forwards/tport_nikolaevskijrp">
                                        <span>Николаевский РечПорт</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/tport_odesskij">
                                        <span>Одесский МП</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/tport_olvia">
                                        <span>Ольвия МП</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/tport_hersonskij">
                                        <span>Херсонский МП</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/tport_hersonskijrp">
                                        <span>Херсонский РечПорт</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="regionLink" href="/traders_forwards/tport_chernomorskij">
                                        <span>Черноморский МП</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/tport_ochakov">
                                        <span>Ю-Порт Очаков</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                    <a class="regionLink" href="/traders_forwards/tport_juzhnyj">
                                        <span>Южный МП</span>
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col px-2 mx-1">
                    <button class="btn typeInput text-center drop-btn">Валюта <i class="ml-2 small far fa-chevron-down"></i></button>
                </div>
                <div class="dropdown-wrapper position-absolute currencyDrop">
                    <div class="dropdown">
                        <div class="section text-left">
                            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                            <div class="row">
                                <div class="col">
                                    <a class="inline-link" href="?currency=uah">
                                        <span>Гривна</span>
                                    </a>
                                    <a class="inline-link" href="?currency=usd">
                                        <span>Доллар</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a class="text-center filter-icon mr-3" rel="nofollow" href="?viewmod=nontbl"><i class="fas fa-th-large"></i></a>
                    <a class="text-center filter-icon active" rel="nofollow" href="?"><i class="fas fa-bars lh-1-1"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-0 mt-sm-3">
        <div class="row pt-sm-3">
            <div class="position-relative w-100">
                <div class="col-12 col-md-9 float-md-right text-center text-md-right">
                    <a style="background: linear-gradient(180deg, #8A78E7 0%, #7E65FF 100%); border: none; height: 35px" href="viber://pa?chatURI=agrotender_bot&amp;text=Начать" class="top-btn btn btn-primary align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">
                        <img src="/app/assets/img/company/viber4.svg" style="width: 18px">
                        <span class="pl-1 pr-1">Продать в Viber</span>
                    </a>
                    <a style="background: linear-gradient(180deg, #5CA9F1 0%, #44A4FF 100%); border: none; height: 35px" href="https://t.me/AGROTENDER_bot" class="top-btn btn btn-primary align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">
                        <img src="/app/assets/img/company/telegram-white.svg" style="width: 18px">
                        <span class="pl-1 pr-1">Продать в Telegram</span>
                    </a>
                    <a href="/add_buy_trader" class="top-btn btn btn-warning align-items-end">
                        <i class="far fa-plus mr-2"></i>
                        <span class="pl-1 pr-1">Разместить компанию</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container empty my-5">
        <div class="content-block p-5 position-relative text-center">
            <img class="get-rubric-img" src="/app/assets/img/get-rubric.png" style="transform: translateX(-50px);">
            <span class="get-rubric">Для сравнения цен выберите продукцию в рубрикаторе</span>
        </div>
    </div>
    <div class="container pb-5 pb-sm-4 pt-4 mb-4 scroll-x">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><table class="sortTable sortable dTable dataTable no-footer" cellspacing="0" id="DataTables_Table_0" role="grid">
                <thead>
                <tr role="row"><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Компании: activate to sort column ascending" style="width: 247px;">Компании</th><th class="sth sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="UAH : activate to sort column descending" style="width: 76px;">UAH <i class="fas fa-sort" style="font-size: 12px;"></i></th><th class="sth sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="USD : activate to sort column descending" style="width: 82px;">USD <i class="fas fa-sort" style="font-size: 12px;"></i></th><th class="sth sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Дата : activate to sort column descending" style="width: 100px;">Дата <i class="sort-date-icon fas fa-sort" style="font-size: 12px;"></i></th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Место закупки: activate to sort column ascending" style="width: 193px;">Место закупки</th></tr>
                </thead>
                <tbody>
                <tr role="row" class="odd">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-4964-forwards">
                            <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                            <span class="title">GrainCorp Ukraine</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">186</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201001"><span data-date="20201001">Окт 2020</span></td>
                    <td>
                        <span class="location">Одесская обл.</span>
                        <br>
                        <span class="place">Бориваж</span>
                    </td>
                </tr><tr role="row" class="even">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-4964-forwards">
                            <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                            <span class="title">GrainCorp Ukraine</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">186</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201001"><span data-date="20201001">Окт 2020</span></td>
                    <td>
                        <span class="location">Николаевская обл.</span>
                    </td>
                </tr><tr role="row" class="odd">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-4964-forwards">
                            <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                            <span class="title">GrainCorp Ukraine</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">184</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201101"><span data-date="20201101">Ноя 2020</span></td>
                    <td>
                        <span class="location">Николаевская обл.</span>
                    </td>
                </tr><tr role="row" class="even">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-4964-forwards">
                            <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                            <span class="title">GrainCorp Ukraine</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">186</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201101"><span data-date="20201101">Ноя 2020</span></td>
                    <td>
                        <span class="location">Одесская обл.</span>
                        <br>
                        <span class="place">Бориваж</span>
                    </td>
                </tr><tr class="t-sub odd" cspan="1" role="row">
                    <td colspan="5">
                        <div class="row align-items-center justify-content-center">
                            <a href="/buyerreg" class="subscribe-table d-flex align-items-center">
                                <img src="/app/assets/img/envelope.png" class="ml-3 mr-3">
                                <span class="ml-3">Подписаться на изменения цен: Кукуруза</span>
                            </a>
                        </div>
                    </td>
                    <td style="display: none;"><div class="d-flex align-items-center justify-content-center"> <span class="price">0</span> </div></td>
                    <td style="display: none;"><div class="d-flex align-items-center justify-content-center"> <span class="price">0</span> </div></td>
                    <td style="display: none;"><span data-date="20170802"></span></td>
                    <td style="display: none;"></td>
                </tr><tr role="row" class="even">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-4964-forwards">
                            <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                            <span class="title">GrainCorp Ukraine</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">184</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201201"><span data-date="20201201">Дек 2020</span></td>
                    <td>
                        <span class="location">Николаевская обл.</span>
                    </td>
                </tr><tr role="row" class="odd">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-4964-forwards">
                            <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                            <span class="title">GrainCorp Ukraine</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">187</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201201"><span data-date="20201201">Дек 2020</span></td>
                    <td>
                        <span class="location">Одесская обл.</span>
                        <br>
                        <span class="place">Бориваж</span>
                    </td>
                </tr><tr role="row" class="even">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-4964-forwards">
                            <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                            <span class="title">GrainCorp Ukraine</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">188</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20210101"><span data-date="20210101">Янв 2021</span></td>
                    <td>
                        <span class="location">Одесская обл.</span>
                        <br>
                        <span class="place">Бориваж</span>
                    </td>
                </tr><tr role="row" class="odd">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-4964-forwards">
                            <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                            <span class="title">GrainCorp Ukraine</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">185</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20210101"><span data-date="20210101">Янв 2021</span></td>
                    <td>
                        <span class="location">Николаевская обл.</span>
                    </td>
                </tr><tr role="row" class="even">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-4964-forwards">
                            <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                            <span class="title">GrainCorp Ukraine</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">185</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20210201"><span data-date="20210201">Фев 2021</span></td>
                    <td>
                        <span class="location">Николаевская обл.</span>
                    </td>
                </tr><tr role="row" class="odd">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-4964-forwards">
                            <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                            <span class="title">GrainCorp Ukraine</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">188</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20210201"><span data-date="20210201">Фев 2021</span></td>
                    <td>
                        <span class="location">Одесская обл.</span>
                        <br>
                        <span class="place">Бориваж</span>
                    </td>
                </tr><tr role="row" class="even">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2468-forwards">
                            <img class="logo mr-3" src="/pics/c/Y4RqJIw3zNFX.jpg">
                            <span class="title">Агростудио Групп</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">125</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201001"><span data-date="20201001">Окт 2020</span></td>
                    <td>
                        <span class="location">Черниговская обл.</span>
                        <br>
                        <span class="place">FCA</span>
                    </td>
                </tr><tr role="row" class="odd">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2468-forwards">
                            <img class="logo mr-3" src="/pics/c/Y4RqJIw3zNFX.jpg">
                            <span class="title">Агростудио Групп</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">153</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201001"><span data-date="20201001">Окт 2020</span></td>
                    <td>
                        <span class="location">Одесская обл.</span>
                    </td>
                </tr><tr role="row" class="even">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2468-forwards">
                            <img class="logo mr-3" src="/pics/c/Y4RqJIw3zNFX.jpg">
                            <span class="title">Агростудио Групп</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">125</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201001"><span data-date="20201001">Окт 2020</span></td>
                    <td>
                        <span class="location">Сумская обл.</span>
                        <br>
                        <span class="place">FCA</span>
                    </td>
                </tr><tr role="row" class="odd">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2468-forwards">
                            <img class="logo mr-3" src="/pics/c/Y4RqJIw3zNFX.jpg">
                            <span class="title">Агростудио Групп</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">154</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201101"><span data-date="20201101">Ноя 2020</span></td>
                    <td>
                        <span class="location">Одесская обл.</span>
                    </td>
                </tr><tr role="row" class="even">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2468-forwards">
                            <img class="logo mr-3" src="/pics/c/Y4RqJIw3zNFX.jpg">
                            <span class="title">Агростудио Групп</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">125</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201101"><span data-date="20201101">Ноя 2020</span></td>
                    <td>
                        <span class="location">Сумская обл.</span>
                        <br>
                        <span class="place">FCA</span>
                    </td>
                </tr><tr role="row" class="odd">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2468-forwards">
                            <img class="logo mr-3" src="/pics/c/Y4RqJIw3zNFX.jpg">
                            <span class="title">Агростудио Групп</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">125</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201101"><span data-date="20201101">Ноя 2020</span></td>
                    <td>
                        <span class="location">Черниговская обл.</span>
                        <br>
                        <span class="place">FCA</span>
                    </td>
                </tr><tr role="row" class="even">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2468-forwards">
                            <img class="logo mr-3" src="/pics/c/Y4RqJIw3zNFX.jpg">
                            <span class="title">Агростудио Групп</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">155</span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201201"><span data-date="20201201">Дек 2020</span></td>
                    <td>
                        <span class="location">Одесская обл.</span>
                    </td>
                </tr><tr role="row" class="odd">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2045-forwards">
                            <img class="logo mr-3" src="/pics/comp/2045_15757.jpg">
                            <span class="title">LNZ GROUP</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">208</span><span class="price-up"> &nbsp;<img src="/app/assets/img/price-up.svg"> <span>38</span></span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201001"><span data-date="20201001">Окт 2020</span></td>
                    <td>
                        <span class="location">Одесская обл.</span>
                    </td>
                </tr><tr role="row" class="even">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2045-forwards">
                            <img class="logo mr-3" src="/pics/comp/2045_15757.jpg">
                            <span class="title">LNZ GROUP</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">208</span><span class="price-up"> &nbsp;<img src="/app/assets/img/price-up.svg"> <span>40</span></span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201001"><span data-date="20201001">Окт 2020</span></td>
                    <td>
                        <span class="location">Николаевская обл.</span>
                    </td>
                </tr><tr role="row" class="odd">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2045-forwards">
                            <img class="logo mr-3" src="/pics/comp/2045_15757.jpg">
                            <span class="title">LNZ GROUP</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">208</span><span class="price-up"> &nbsp;<img src="/app/assets/img/price-up.svg"> <span>40</span></span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201101"><span data-date="20201101">Ноя 2020</span></td>
                    <td>
                        <span class="location">Николаевская обл.</span>
                    </td>
                </tr><tr role="row" class="even">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2045-forwards">
                            <img class="logo mr-3" src="/pics/comp/2045_15757.jpg">
                            <span class="title">LNZ GROUP</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">208</span><span class="price-up"> &nbsp;<img src="/app/assets/img/price-up.svg"> <span>38</span></span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201101"><span data-date="20201101">Ноя 2020</span></td>
                    <td>
                        <span class="location">Одесская обл.</span>
                    </td>
                </tr><tr role="row" class="odd">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2045-forwards">
                            <img class="logo mr-3" src="/pics/comp/2045_15757.jpg">
                            <span class="title">LNZ GROUP</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">209</span><span class="price-up"> &nbsp;<img src="/app/assets/img/price-up.svg"> <span>39</span></span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201201"><span data-date="20201201">Дек 2020</span></td>
                    <td>
                        <span class="location">Одесская обл.</span>
                    </td>
                </tr><tr role="row" class="even">
                    <td>
                        <a class="d-flex align-items-center" href="/kompanii/comp-2045-forwards">
                            <img class="logo mr-3" src="/pics/comp/2045_15757.jpg">
                            <span class="title">LNZ GROUP</span>
                        </a>
                    </td>
                    <td class="uah">
                    </td>
                    <td class="usd">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="price">209</span><span class="price-up"> &nbsp;<img src="/app/assets/img/price-up.svg"> <span>41</span></span>
                        </div>
                    </td>
                    <td data-sorttable-customkey="20201201"><span data-date="20201201">Дек 2020</span></td>
                    <td>
                        <span class="location">Николаевская обл.</span>
                    </td>
                </tr></tbody>
            </table></div>
        <div class="text-center mt-5">
        </div>
    </div>
@endsection
