{{--{{dd(Route::getRoutes())}}--}}
<div class="new_filters-wrap">
    <div class="replacement"></div>
    <div class="fixed-item">
        <div class="new_container">
            <div class="new_filters active">
                <div class="filter__item main">
                    <button class="filter__button main">Закупки</button>
                    <div class="new_filters_dropdown-wrap">
                        <div class="new_filters_dropdown">
                            <ul>
                                <li>
                                    <a href="/traders_forwards/region_ukraine">Форварды</a>
                                </li>
                                <li>
                                    <a href="/traders_sell">Продажи</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="filter__item producrion" id="choseProduct">
                    <button class="filter__button producrion-btn">Выбрать продукцию</button>
                    <div class="new_filters_dropdown-wrap">
                        <div class="new_filters_dropdown">
                            <div class="new_filters_dropdown-column">
                                <ul>
                                    @foreach($rubricsGroup as $group => $item)
                                        <li class="">
                                            <a href="#"  class="test">{{$group}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
{{--                         active Клас добавляю кастомно пока что не рабоает из js   --}}
                            <div class="new_filters_dropdown-content 1 active" id="cereals">
                                <ul>
                                    @foreach($rubricsGroup["Зерновые"]["group_culture"] as $index => $item)
                                        @if($index > count($rubricsGroup["Зерновые"]["group_culture"]) / 2)
                                            <li>
                                                <a href="/traders/region_ukraine/{{$rubricsGroup["Зерновые"]["group_culture"][$index]['url']}}?viewmod=nontbl">
                                                    {{$rubricsGroup["Зерновые"]["group_culture"][$index]['name']}}
{{--                                                    (50)--}}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                <ul>
                                    @foreach($rubricsGroup["Зерновые"]["group_culture"] as $index => $item)
                                        @if($index < count($rubricsGroup["Зерновые"]["group_culture"]) / 2)
                                            <li>
                                                <a href="/traders/region_ukraine/{{$rubricsGroup["Зерновые"]["group_culture"][$index]['url']}}">
                                                    {{$rubricsGroup["Зерновые"]["group_culture"][$index]['name']}}
{{--                                                    (50)--}}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
{{--                            <div class="new_filters_dropdown-content 7" id="oilseeds">--}}
{{--                                <ul>--}}
{{--                                    @foreach($rubricsGroup["Масличные"]["groups"]["traders_products"] as $index => $item)--}}

{{--                                        @if($index > count($rubricsGroup["Масличные"]["groups"]["traders_products"]) / 2)--}}
{{--                                            <li>--}}
{{--                                                <a href="/traders/region_ukraine/{{$rubricsGroup["Масличные"]["groups"]["traders_products"][$index]['url']}}">--}}
{{--                                                    {{$rubricsGroup["Масличные"]["groups"]["traders_products"][$index]['name']}}--}}
{{--                                                    (50)--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                                <ul>--}}
{{--                                    @foreach($rubricsGroup["Масличные"]["groups"]["traders_products"] as $index => $item)--}}
{{--                                        @if($index < count($rubricsGroup["Масличные"]["groups"]["traders_products"]) / 2)--}}
{{--                                            <li>--}}
{{--                                                <a href="/traders/region_ukraine/{{$rubricsGroup["Масличные"]["groups"]["traders_products"][$index]['url']}}">--}}
{{--                                                    {{$rubricsGroup["Масличные"]["groups"]["traders_products"][$index]['name']}}--}}
{{--                                                    (50)--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}

{{--                            </div>--}}
{{--                            <div class="new_filters_dropdown-content 3 " id="legumes">--}}
{{--                                <ul>--}}
{{--                                    @foreach($rubricsGroup["Бобовые"]["groups"]["traders_products"] as $index => $item)--}}

{{--                                        @if($index > count($rubricsGroup["Бобовые"]["groups"]["traders_products"]) / 2)--}}
{{--                                            <li>--}}
{{--                                                <a href="/traders/region_ukraine/{{$rubricsGroup["Бобовые"]["groups"]["traders_products"][$index]['url']}}">--}}
{{--                                                    {{$rubricsGroup["Бобовые"]["groups"]["traders_products"][$index]['name']}}--}}
{{--                                                    (50)--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                                <ul>--}}
{{--                                    @foreach($rubricsGroup["Бобовые"]["groups"]["traders_products"] as $index => $item)--}}
{{--                                        @if($index < count($rubricsGroup["Бобовые"]["groups"]["traders_products"]) / 2)--}}
{{--                                            <li>--}}
{{--                                                <a href="/traders/region_ukraine/{{$rubricsGroup["Бобовые"]["groups"]["traders_products"][$index]['url']}}">--}}
{{--                                                    {{$rubricsGroup["Бобовые"]["groups"]["traders_products"][$index]['name']}}--}}
{{--                                                    (50)--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}

{{--                            </div>--}}
{{--                            <div class="new_filters_dropdown-content 2" id="niche_crops">--}}
{{--                                <ul>--}}
{{--                                    @foreach($rubricsGroup["Нишевые культуры"]["groups"]["traders_products"] as $index => $item)--}}

{{--                                        @if($index > count($rubricsGroup["Нишевые культуры"]["groups"]["traders_products"]) / 2)--}}
{{--                                            <li>--}}
{{--                                                <a href="/traders/region_ukraine/{{$rubricsGroup["Нишевые культуры"]["groups"]["traders_products"][$index]['url']}}">--}}
{{--                                                    {{$rubricsGroup["Нишевые культуры"]["groups"]["traders_products"][$index]['name']}}--}}
{{--                                                    (50)--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                                <ul>--}}
{{--                                    @foreach($rubricsGroup["Нишевые культуры"]["groups"]["traders_products"] as $index => $item)--}}
{{--                                        @if($index < count($rubricsGroup["Нишевые культуры"]["groups"]["traders_products"]) / 2)--}}
{{--                                            <li>--}}
{{--                                                <a href="/traders/region_ukraine/{{$rubricsGroup["Нишевые культуры"]["groups"]["traders_products"][$index]['url']}}">--}}
{{--                                                    {{$rubricsGroup["Нишевые культуры"]["groups"]["traders_products"][$index]['name']}}--}}
{{--                                                    (50)--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}

{{--                            </div>--}}
{{--                            <div class="new_filters_dropdown-content 4" id="processing_products">--}}
{{--                                <ul>--}}
{{--                                    @foreach($rubricsGroup["Продукты переработки"]["groups"]["traders_products"] as $index => $item)--}}

{{--                                        @if($index > count($rubricsGroup["Продукты переработки"]["groups"]["traders_products"]) / 2)--}}
{{--                                            <li>--}}
{{--                                                <a href="/traders/region_ukraine/{{$rubricsGroup["Продукты переработки"]["groups"]["traders_products"][$index]['url']}}">--}}
{{--                                                    {{$rubricsGroup["Продукты переработки"]["groups"]["traders_products"][$index]['name']}}--}}
{{--                                                    (50)--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                                <ul>--}}
{{--                                    @foreach($rubricsGroup["Продукты переработки"]["groups"]["traders_products"] as $index => $item)--}}
{{--                                        @if($index < count($rubricsGroup["Продукты переработки"]["groups"]["traders_products"]) / 2)--}}
{{--                                            <li>--}}
{{--                                                <a href="/traders/region_ukraine/{{$rubricsGroup["Продукты переработки"]["groups"]["traders_products"][$index]['url']}}">--}}
{{--                                                    {{$rubricsGroup["Продукты переработки"]["groups"]["traders_products"][$index]['name']}}--}}
{{--                                                    (50)--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}

{{--                            </div>--}}
{{--                            <div class="new_filters_dropdown-content 16" id="organic">--}}
{{--                                <<ul>--}}
{{--                                    @foreach($rubricsGroup["Органика"]["groups"]["traders_products"] as $index => $item)--}}

{{--                                        @if($index > count($rubricsGroup["Органика"]["groups"]["traders_products"]) / 2)--}}
{{--                                            <li>--}}
{{--                                                <a href="/traders/region_ukraine/{{$rubricsGroup["Органика"]["groups"]["traders_products"][$index]['url']}}">--}}
{{--                                                    {{$rubricsGroup["Органика"]["groups"]["traders_products"][$index]['name']}}--}}
{{--                                                    (50)--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                                <ul>--}}
{{--                                    @foreach($rubricsGroup["Органика"]["groups"]["traders_products"] as $index => $item)--}}
{{--                                        @if($index < count($rubricsGroup["Органика"]["groups"]["traders_products"]) / 2)--}}
{{--                                            <li>--}}
{{--                                                <a href="/traders/region_ukraine/{{$rubricsGroup["Органика"]["groups"]["traders_products"][$index]['url']}}">--}}
{{--                                                    {{$rubricsGroup["Органика"]["groups"]["traders_products"][$index]['name']}}--}}
{{--                                                    (50)--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}

{{--                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="filter__item second" id="all_ukraine">
                    <button class="filter__button second">
                        Вся Украина
                    </button>
                    <div class="new_filters_dropdown-wrap">
                        <div class="new_filters_dropdown">
                            <div class="new_filters_dropdown-column">

                                <ul>
                                    <li class="active">
                                        <a href="#">Области</a>
                                    </li>
                                    <li>
                                        <a href="#">Порты</a>
                                    </li>
                                </ul>

                            </div>
                            <div class="new_filters_dropdown-content ">
                                <ul>
                                    <li>
                                        <a href="/traders/region_vinnica/index">
                                            Винницкая
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_volin/index">
                                            Волынская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_dnepr/index">
                                            Днепропетровская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_donetsk/index">
                                            Донецкая
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_zhitomir/index">
                                            Житомирская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_zakorpat/index">
                                            Закарпатская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_zaporizh/index">
                                            Запорожская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_ivanofrank/index">
                                            Ивано-Франковская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_kyiv/index">
                                            Киевская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_kirovograd/index">
                                            Кировоградская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_lugansk/index">
                                            Луганская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_lviv/index">
                                            Львовская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_nikolaev/index">
                                            Николаевская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_odessa/index">
                                            Одесская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_poltava/index">
                                            Полтавская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_rovno/index">
                                            Ровенская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_sumy/index">
                                            Сумская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_ternopil/index">
                                            Тернопольская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_kharkov/index">
                                            Харьковская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_kherson/index">
                                            Херсонская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_khmelnitsk/index">
                                            Хмельницкая
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_cherkassi/index">
                                            Черкасская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_chernigov/index">
                                            Черниговская
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_chernovci/index">
                                            Черновицкая
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_ukraine/index">Вся Украина</a>
                                    </li>
                                    <li>
                                        <a href="/traders/region_crimea/index">АР Крым</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="new_filters_dropdown-content active">
                                <ul>
                                    @foreach($onlyPorts as $index => $port)
                                        <li>
                                            <a href="{{route('traders_port', ['port_name' => $port['url']])}}">{{$port['portname']}}</a>
{{--                                            <a href="/traders/{{$port['url']}}">{{$port['portname']}}</a>--}}
                                        </li>
                                    @endforeach
                                    <li>
{{--                                        <a href="{{route('traders_region', 'crimea')}}">АР Крым</a>--}}
                                    </li>
                                    <li>
{{--                                        <a href="{{route('traders_regions', ['region' => 'ukraine'])}}">Вся Укрина</a>--}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="new_filters_checkbox first">
                    <input class="inp-cbx" id="new_filters_currency_uah" type="checkbox">
                    <label class="cbx" for="new_filters_currency_uah">
            <span>
              <svg width="12px" height="10px">
                <use xlink:href="#check"></use>
              </svg>
            </span>
                        <span>ГРН</span>
                    </label>
                </div>
                <div class="new_filters_checkbox second">
                    <input class="inp-cbx" id="new_filters_currency_usd" type="checkbox">
                    <label class="cbx" for="new_filters_currency_usd">
            <span>
              <svg width="12px" height="10px">
                <use xlink:href="#check"></use>
              </svg>
            </span>
                        <span>USD</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

{{--<div class="d-none d-sm-block container mt-5">--}}
{{--    <div class="content-block mt-3 py-3 px-3">--}}
{{--        <div class="btn-group position-relative w-100 ">--}}
{{--            <div class="col pl-1">--}}
{{--                <button class="btn typeInput text-center drop-btn">Закупки <i class="ml-2 small far fa-chevron-down"></i></button>--}}
{{--            </div>--}}
{{--            <div class="dropdown-wrapper position-absolute typeDrop">--}}
{{--                <div class="dropdown" style="display: none;">--}}
{{--                    <div class="section text-left">--}}
{{--                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->--}}
{{--                        <div class="row">--}}
{{--                            <div class="col">--}}
{{--                                <a class="inline-link" href="/traders_forwards/region_ukraine">--}}
{{--                                    <span>Форварды</span>--}}
{{--                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>--}}
{{--                                </a>--}}
{{--                                <a class="inline-link" href="/traders_sell">--}}
{{--                                    <span>Продажи</span>--}}
{{--                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>--}}
{{--                                </a>--}}
{{--                                <a class="inline-link" href="/traders_analitic/region_ukraine">--}}
{{--                                    <span>Аналитика закупок</span>--}}
{{--                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>--}}
{{--                                </a>--}}
{{--                                <a class="inline-link" href="/traders_analitic_sell">--}}
{{--                                    <span>Аналитика продаж</span>--}}
{{--                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col px-1 mx-1">--}}
{{--                <button class="btn rubricInput text-center drop-btn blue-shadow">Выбрать продукцию <i class="ml-2 small far fa-chevron-down"></i></button>--}}
{{--            </div>--}}
{{--            <div class="dropdown-wrapper position-absolute rubricDrop">--}}
{{--                <div class="dropdown" style="display: none;">--}}
{{--                    <div class="section text-left">--}}
{{--                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-auto">--}}
{{--                                <a class="rubricLink getRubricGroup" href="#" group="1">--}}
{{--                    <span>--}}
{{--                      Зерновые</span>--}}
{{--                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>--}}
{{--                                </a>--}}
{{--                                <a class="rubricLink getRubricGroup" href="#" group="2">--}}
{{--                    <span>--}}
{{--                      Масличные</span>--}}
{{--                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>--}}
{{--                                </a>--}}
{{--                                <a class="rubricLink getRubricGroup" href="#" group="3">--}}
{{--                    <span>--}}
{{--                      Бобовые</span>--}}
{{--                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>--}}
{{--                                </a>--}}
{{--                                <a class="rubricLink getRubricGroup" href="#" group="4">--}}
{{--                    <span>--}}
{{--                      Продукты переработки</span>--}}
{{--                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>--}}
{{--                                </a>--}}
{{--                                <a class="rubricLink getRubricGroup" href="#" group="7">--}}
{{--                    <span>--}}
{{--                      Нишевые культуры</span>--}}
{{--                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>--}}
{{--                                </a>--}}
{{--                                <a class="rubricLink getRubricGroup" href="#" group="16">--}}
{{--                    <span>--}}
{{--                      Органика</span>--}}
{{--                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-3" style="display: none;">--}}
{{--                                <a rid="30" class="rubricLink" href="/traders/region_ukraine/boby">--}}
{{--                                    <span>Бобы</span>--}}
{{--                                </a>--}}
{{--                                <a rid="77" class="rubricLink" href="/traders/region_ukraine/goroh">--}}
{{--                                    <span>Горох</span>--}}
{{--                                </a>--}}
{{--                                <a rid="27" class="rubricLink" href="/traders/region_ukraine/goroh_zheltyy">--}}
{{--                                    <span>Горох желтый</span>--}}
{{--                                </a>--}}
{{--                                <a rid="48" class="rubricLink" href="/traders/region_ukraine/goroh_zeleniy">--}}
{{--                                    <span>Горох зеленый</span>--}}
{{--                                </a>--}}
{{--                                <a rid="64" class="rubricLink" href="/traders/region_ukraine/goroh_fyragniy">--}}
{{--                                    <span>Горох фуражный</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-3" style="display: none;">--}}
{{--                                <a rid="26" class="rubricLink" href="/traders/region_ukraine/soya">--}}
{{--                                    <span>Соя</span>--}}
{{--                                </a>--}}
{{--                                <a rid="202" class="rubricLink" href="/traders/region_ukraine/soya_gmo">--}}
{{--                                    <span>Соя без ГМО</span>--}}
{{--                                </a>--}}
{{--                                <a rid="29" class="rubricLink" href="/traders/region_ukraine/fasol">--}}
{{--                                    <span>Фасоль</span>--}}
{{--                                </a>--}}
{{--                                <a rid="84" class="rubricLink" href="/traders/region_ukraine/Fasol_Beli">--}}
{{--                                    <span>Фасоль белая</span>--}}
{{--                                </a>--}}
{{--                                <a rid="83" class="rubricLink" href="/traders/region_ukraine/Fasol_Rkasni">--}}
{{--                                    <span>Фасоль красная</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-7" style="display: none;">--}}
{{--                                <a rid="45" class="rubricLink" href="/traders/region_ukraine/gorchica_belaia">--}}
{{--                                    <span>Горчица белая</span>--}}
{{--                                </a>--}}
{{--                                <a rid="46" class="rubricLink" href="/traders/region_ukraine/gorchica_jeltaia">--}}
{{--                                    <span>Горчица желтая</span>--}}
{{--                                </a>--}}
{{--                                <a rid="50" class="rubricLink" href="/traders/region_ukraine/gorchica_chernaia">--}}
{{--                                    <span>Горчица черная</span>--}}
{{--                                </a>--}}
{{--                                <a rid="22" class="rubricLink" href="/traders/region_ukraine/grechiha">--}}
{{--                                    <span>Гречиха</span>--}}
{{--                                </a>--}}
{{--                                <a rid="49" class="rubricLink" href="/traders/region_ukraine/koriandr">--}}
{{--                                    <span>Кориандр</span>--}}
{{--                                </a>--}}
{{--                                <a rid="39" class="rubricLink" href="/traders/region_ukraine/len">--}}
{{--                                    <span>Лён</span>--}}
{{--                                </a>--}}
{{--                                <a rid="28" class="rubricLink" href="/traders/region_ukraine/nut">--}}
{{--                                    <span>Нут</span>--}}
{{--                                </a>--}}
{{--                                <a rid="204" class="rubricLink" href="/traders/region_ukraine/nut_7_mm">--}}
{{--                                    <span>Нут &gt; 7 мм</span>--}}
{{--                                </a>--}}
{{--                                <a rid="20" class="rubricLink" href="/traders/region_ukraine/proso_beloe">--}}
{{--                                    <span>Просо белое</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-7" style="display: none;">--}}
{{--                                <a rid="18" class="rubricLink" href="/traders/region_ukraine/proso_zheltoe">--}}
{{--                                    <span>Просо желтое</span>--}}
{{--                                </a>--}}
{{--                                <a rid="19" class="rubricLink" href="/traders/region_ukraine/proso_krasnoe">--}}
{{--                                    <span>Просо красное</span>--}}
{{--                                </a>--}}
{{--                                <a rid="15" class="rubricLink" href="/traders/region_ukraine/sorgo">--}}
{{--                                    <span>Сорго</span>--}}
{{--                                </a>--}}
{{--                                <a rid="16" class="rubricLink" href="/traders/region_ukraine/sorgo_beloe">--}}
{{--                                    <span>Сорго белое</span>--}}
{{--                                </a>--}}
{{--                                <a rid="17" class="rubricLink" href="/traders/region_ukraine/sorgo_krasnoe">--}}
{{--                                    <span>Сорго красное</span>--}}
{{--                                </a>--}}
{{--                                <a rid="58" class="rubricLink" href="/traders/region_ukraine/chechevica">--}}
{{--                                    <span>Чечевица</span>--}}
{{--                                </a>--}}
{{--                                <a rid="172" class="rubricLink" href="/traders/region_ukraine/chechevica_zelenaya">--}}
{{--                                    <span>Чечевица зеленая</span>--}}
{{--                                </a>--}}
{{--                                <a rid="209" class="rubricLink" href="/traders/region_ukraine/chechevica_krasnaia">--}}
{{--                                    <span>Чечевица красная</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-4" style="display: none;">--}}
{{--                                <a rid="56" class="rubricLink" href="/traders/region_ukraine/jmih_soeviy">--}}
{{--                                    <span>Жмых соевый</span>--}}
{{--                                </a>--}}
{{--                                <a rid="54" class="rubricLink" href="/traders/region_ukraine/maslo_soevoe">--}}
{{--                                    <span>Масло соевое</span>--}}
{{--                                </a>--}}
{{--                                <a rid="191" class="rubricLink" href="/traders/region_ukraine/Otrybi_kukuruznie">--}}
{{--                                    <span>Отруби кукурузные</span>--}}
{{--                                </a>--}}
{{--                                <a rid="43" class="rubricLink" href="/traders/region_ukraine/otrybi_pshenichnie_granylirovannie">--}}
{{--                                    <span>Отруби пшен. гран.</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-4" style="display: none;">--}}
{{--                                <a rid="55" class="rubricLink" href="/traders/region_ukraine/otrybi_pshenichnie">--}}
{{--                                    <span>Отруби пшеничные</span>--}}
{{--                                </a>--}}
{{--                                <a rid="35" class="rubricLink" href="/traders/region_ukraine/shrot_podsoln_vysokoprot">--}}
{{--                                    <span>Шрот подсолн. высокопрот.</span>--}}
{{--                                </a>--}}
{{--                                <a rid="41" class="rubricLink" href="/traders/region_ukraine/shrot_soeviy">--}}
{{--                                    <span>Шрот соевый</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-1" style="display: block;">--}}
{{--                                <a rid="14" class="rubricLink" href="/traders/region_ukraine/kukuruza">--}}
{{--                                    <span>Кукуруза (50)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="80" class="rubricLink" href="/traders/region_ukraine/kykyryza_bitaia">--}}
{{--                                    <span>Кукуруза битая (2)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="81" class="rubricLink" href="/traders/region_ukraine/kykyryza_zernoothod">--}}
{{--                                    <span>Кукуруза зерноотход (2)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="59" class="rubricLink" href="/traders/region_ukraine/Kykyryza_kremnistaia">--}}
{{--                                    <span>Кукуруза кремнистая (1)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="85" class="rubricLink" href="/traders/region_ukraine/kukuruza_povishenoy_zernovoy">--}}
{{--                                    <span>Кукуруза с повыш. зерн. (1)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="71" class="rubricLink" href="/traders/region_ukraine/Kykyryza_fyrajnaia">--}}
{{--                                    <span>Кукуруза фуражная (8)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="38" class="rubricLink" href="/traders/region_ukraine/oves">--}}
{{--                                    <span>Овес (8)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="73" class="rubricLink" href="/traders/region_ukraine/oves_golozerniy">--}}
{{--                                    <span>Овес голозерный (1)</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-1" style="display: block;">--}}
{{--                                <a rid="8" class="rubricLink" href="/traders/region_ukraine/pshenica_2_kl">--}}
{{--                                    <span>Пшеница 2 кл. (53)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="9" class="rubricLink" href="/traders/region_ukraine/pshenica_3_kl">--}}
{{--                                    <span>Пшеница 3 кл. (56)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="10" class="rubricLink" href="/traders/region_ukraine/pshenica_4_kl">--}}
{{--                                    <span>Пшеница 4 кл. (63)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="187" class="rubricLink" href="/traders/region_ukraine/pshenica_spelta">--}}
{{--                                    <span>Пшеница спельта (1)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="60" class="rubricLink" href="/traders/region_ukraine/pshenica_tverdaia_iarovaia">--}}
{{--                                    <span>Пшеница твердая (3)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="57" class="rubricLink" href="/traders/region_ukraine/roj">--}}
{{--                                    <span>Рожь (6)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="62" class="rubricLink" href="/traders/region_ukraine/tritikale">--}}
{{--                                    <span>Тритикале (1)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="13" class="rubricLink" href="/traders/region_ukraine/yachmen">--}}
{{--                                    <span>Ячмень (39)</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-2" style="display: none;">--}}
{{--                                <a rid="24" class="rubricLink" href="/traders/region_ukraine/podsolnechnik">--}}
{{--                                    <span>Подсолнечник</span>--}}
{{--                                </a>--}}
{{--                                <a rid="23" class="rubricLink" href="/traders/region_ukraine/podsolnechnik_bez_nds">--}}
{{--                                    <span>Подсолнечник (без НДС)</span>--}}
{{--                                </a>--}}
{{--                                <a rid="169" class="rubricLink" href="/traders/region_ukraine/podsolnechnik_visokooleinovi">--}}
{{--                                    <span>Подсолнечник высокоолеин.</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-2" style="display: none;">--}}
{{--                                <a rid="25" class="rubricLink" href="/traders/region_ukraine/raps">--}}
{{--                                    <span>Рапс</span>--}}
{{--                                </a>--}}
{{--                                <a rid="88" class="rubricLink" href="/traders/region_ukraine/raps_gmo">--}}
{{--                                    <span>Рапс с ГМО</span>--}}
{{--                                </a>--}}
{{--                                <a rid="66" class="rubricLink" href="/traders/region_ukraine/raps_tehnicheskiy">--}}
{{--                                    <span>Рапс технический</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-16" style="display: none;">--}}
{{--                                <a rid="214" class="rubricLink" href="/traders/region_ukraine/pshenica_spelta_bio">--}}
{{--                                    <span>Пшеница спельта БИО</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col px-2 mx-1">--}}
{{--                <button class="btn regionInput text-center drop-btn align-self-center">--}}
{{--                    Вся Украина--}}
{{--                    <i class="ml-2 small far fa-chevron-down"></i>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="dropdown-wrapper position-absolute regionDrop">--}}
{{--                <div class="dropdown" style="display: none;">--}}
{{--          <span class="d-block">--}}
{{--            <a class="regionLink d-inline-block text-muted disabled" href="/traders/region_ukraine/index">--}}
{{--            <span>Вся Украина</span>--}}
{{--          </a>--}}
{{--          <a class="regionLink d-inline-block" href="/traders/region_crimea/index">--}}
{{--            <span>АР Крым</span>--}}
{{--          </a>--}}
{{--          </span>--}}
{{--                    <hr class="mt-1 mb-2">--}}
{{--                    <div class="section text-left">--}}
{{--                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->--}}
{{--                        <div class="row">--}}
{{--                            <div class="col">--}}
{{--                                <a class="regionLink" href="/traders/region_vinnica/index">--}}
{{--                                    <span>Винницкая область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_volin/index">--}}
{{--                                    <span>Волынская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_dnepr/index">--}}
{{--                                    <span>Днепропетровская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_donetsk/index">--}}
{{--                                    <span>Донецкая область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_zhitomir/index">--}}
{{--                                    <span>Житомирская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_zakorpat/index">--}}
{{--                                    <span>Закарпатская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_zaporizh/index">--}}
{{--                                    <span>Запорожская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_ivanofrank/index">--}}
{{--                                    <span>Ивано-Франковская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <a class="regionLink" href="/traders/region_kyiv/index">--}}
{{--                                    <span>Киевская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_kirovograd/index">--}}
{{--                                    <span>Кировоградская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_lugansk/index">--}}
{{--                                    <span>Луганская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_lviv/index">--}}
{{--                                    <span>Львовская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_nikolaev/index">--}}
{{--                                    <span>Николаевская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_odessa/index">--}}
{{--                                    <span>Одесская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_poltava/index">--}}
{{--                                    <span>Полтавская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_rovno/index">--}}
{{--                                    <span>Ровенская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <a class="regionLink" href="/traders/region_sumy/index">--}}
{{--                                    <span>Сумская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_ternopil/index">--}}
{{--                                    <span>Тернопольская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_kharkov/index">--}}
{{--                                    <span>Харьковская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_kherson/index">--}}
{{--                                    <span>Херсонская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_khmelnitsk/index">--}}
{{--                                    <span>Хмельницкая область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_cherkassi/index">--}}
{{--                                    <span>Черкасская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_chernigov/index">--}}
{{--                                    <span>Черниговская область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/region_chernovci/index">--}}
{{--                                    <span>Черновицкая область</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <br>--}}
{{--                    <span class="d-block">--}}
{{--            <a class="regionLink d-inline-block" href="/traders/tport_all/index">--}}
{{--            <span>Все порты</span>--}}
{{--          </a>--}}
{{--          </span>--}}
{{--                    <hr class="mt-1 mb-2">--}}
{{--                    <div class="section text-left">--}}
{{--                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->--}}
{{--                        <div class="row">--}}
{{--                            <div class="col">--}}
{{--                                <a class="regionLink" href="/traders/tport_berdjansk/index">--}}
{{--                                    <span>Бердянский МП</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/tport_mariupolskij/index">--}}
{{--                                    <span>Мариупольский МП</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/tport_navallogistik/index">--}}
{{--                                    <span>Наваль Логистик</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/tport_nikatera/index">--}}
{{--                                    <span>Ника-Тера</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/tport_nikolaevskij/index">--}}
{{--                                    <span>Николаевский МП</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <a class="regionLink" href="/traders/tport_nikolaevskijrp/index">--}}
{{--                                    <span>Николаевский РечПорт</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/tport_odesskij/index">--}}
{{--                                    <span>Одесский МП</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/tport_olvia/index">--}}
{{--                                    <span>Ольвия МП</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/tport_hersonskij/index">--}}
{{--                                    <span>Херсонский МП</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/tport_hersonskijrp/index">--}}
{{--                                    <span>Херсонский РечПорт</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <a class="regionLink" href="/traders/tport_chernomorskij/index">--}}
{{--                                    <span>Черноморский МП</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/tport_ochakov/index">--}}
{{--                                    <span>Ю-Порт Очаков</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                                <a class="regionLink" href="/traders/tport_juzhnyj/index">--}}
{{--                                    <span>Южный МП</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col px-2 mx-1">--}}
{{--                <button class="btn typeInput text-center drop-btn">Валюта <i class="ml-2 small far fa-chevron-down"></i></button>--}}
{{--            </div>--}}
{{--            <div class="dropdown-wrapper position-absolute currencyDrop">--}}
{{--                <div class="dropdown" style="display: none;">--}}
{{--                    <div class="section text-left">--}}
{{--                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->--}}
{{--                        <div class="row">--}}
{{--                            <div class="col">--}}
{{--                                <a class="inline-link" href="?currency=uah">--}}
{{--                                    <span>Гривна</span>--}}
{{--                                </a>--}}
{{--                                <a class="inline-link" href="?currency=usd">--}}
{{--                                    <span>Доллар</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <span class="popular" style="margin-top: 16px;display: block;">--}}
{{--  <span style="font-weight: 600; color: #707070;">--}}
{{--  <img src="/app/assets/img/speaker.svg" style="width: 24px; height: 24px">--}}
{{--   Популярные культуры: </span>--}}
{{--  <a href="/traders/region_ukraine/pshenica_2_kl" class="popular__block">Пшеница 2 кл.</a>--}}
{{--  <a href="/traders/region_ukraine/pshenica_3_kl" class="popular__block">Пшеница 3 кл.</a>--}}
{{--  <a href="/traders/region_ukraine/pshenica_4_kl" class="popular__block">Пшеница 4 кл.</a>--}}
{{--  <a href="/traders/region_ukraine/podsolnechnik" class="popular__block">Подсолнечник</a>--}}
{{--  <a href="/traders/region_ukraine/soya" class="popular__block">Соя</a>--}}
{{--  <a href="/traders/region_ukraine/yachmen" class="popular__block">Ячмень</a>--}}
{{--  </span>--}}
{{--</div>--}}
<script>
    window.onload = function () {
        $( "#choseProduct" ).click(function() {

            if(!$( "#choseProduct" ).hasClass('active')){
                $( "#choseProduct" ).addClass('active');
            }else{
                $( "#choseProduct" ).removeClass('active');
            }

        });

        $( "#all_ukraine" ).click(function() {
            if(!$( "#all_ukraine" ).hasClass('active')){
                $( "#all_ukraine" ).addClass('active');
            }else{
                $( "#all_ukraine" ).removeClass('active');
            }

        });
        $( ".regionInput" ).click(function() {
            if(!$( ".regionInput" ).hasClass('isopen')){
                $( ".regionInput" ).addClass('isopen');
            }else{
                $( ".regionInput" ).removeClass('isopen');
            }

        });

        $( ".rubricInput" ).click(function() {
            if(!$( ".rubricInput" ).hasClass('isopen')){
                $( ".rubricInput" ).addClass('isopen');
            }else{
                $( ".rubricInput" ).removeClass('isopen');
            }

        });

        $( ".test" ).click(function(event) {
            // console.log(event.target.innerHTML);
            console.log(window);

        });

        function activeCulture(group) {
            console.log(group);
            let culture = {
                0: 'cereals',
                1: 'oilseeds',
                2: 'legumes',
                3: 'processing_products',
                4: 'niche_crops',
                5: 'services',
            }



        }
        // $( "#choseProduct" ).addClass('active');

    }
</script>
