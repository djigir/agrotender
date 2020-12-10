<div class="d-none d-sm-block new_container mt-3">
    <ol class="breadcrumbs small p-0">
        <li>
            <a href="/">Главная</a>
        </li>
        <i class="fas fa-chevron-right extra-small"></i>
        @foreach($breadcrumbs as $index_bread => $breadcrumb)
            <li>
                @if($breadcrumb['url'])
                    <a href="{{$breadcrumb['url']}}">
                        <h1>{!! $breadcrumb['name'] !!}</h1>
                    </a>
                @else
                    <h1>{{$breadcrumb['name']}}</h1>
                @endif
            </li>
        @endforeach
    </ol>
    <div class="content-block mt-3 py-3 px-4">
        <div class="form-row align-items-center position-relative">
            <div class="col-3 mr-2">
                <button class="btn rubricInput text-center drop-btn" id="rubricOpen">
                     {{$culture_name}}
                    <i class="ml-2 small far fa-chevron-down"></i>
                </button>
            </div>
            <div class="dropdown-wrapper position-absolute rubricDrop">
                <div class="dropdown" id="rubricDrop" style="display: none;">
                    <div class="section text-left">
                        <div class="row">
                            <div style="display: flex;">
                                <div class="col-auto">
                                    @foreach($rubricGroups as $index => $rubric)
                                        <a class="rubricLink getRubricGroup" group="{{$rubric['id']}}" >
                                            <span class="test">{{$rubric['title']}}
                                                <span class="ml-4 float-right right">
                                                    <i class="far fa-chevron-right"></i>
                                                </span>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                                @foreach($rubricGroups as $index => $rubric)
                                    <!-- column-count: 2 -->
                                    <div class="col-auto rubricGroup pr-0 mr-3 groupCulture group-{{$rubric['id']}}" group="{{$rubric['id']}}" style="display: none;">
                                        @foreach($rubricGroups[$rubric['id']]["comp_topic"] as $index => $culture)
                                            <a class="regionLink {{$culture_name == $culture['title'] ? 'active' : ''}}" href="{{route('company.region_culture', [isset($region) ? $region : 'ukraine', $culture['id']])}}">
                                                <span>{{$culture['title']}}</span>
                                                @if($culture['cnt'] > 0)
                                                    <span class="companyCount small">
                                                        ({{$culture['cnt']}})
                                                    </span>
                                                @endif
                                                <span class="float-right right"><i class="far fa-chevron-right"></i></span>
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 mr-2">
                <button class="btn regionInput text-center drop-btn">
                    {{$region_name}}
                <i class="ml-2 small far fa-chevron-down"></i>
                </button>
            </div>
            <div class="dropdown-wrapper position-absolute regionDrop">
                <div class="dropdown" id="regionDrop" style="display: none;">
                    <span class="d-block">
                        <a class="regionLink d-inline-block {{(isset($region) and $region == 'ukraine') ? 'text-muted disabled' : ''}}" href="{{($rubric_id and $region) ? route('company.region_culture', ['ukraine', $rubric_id]): route('company.region', 'ukraine')}}">
                            <span style="cursor: pointer">Вся Украина</span>
                        </a>
                        <a class="regionLink d-inline-block {{(isset($region) and $region == 'crimea') ? 'text-muted disabled' : ''}}" href="{{($rubric_id and $region) ? route('company.region_culture', ['crimea', $rubric_id]) : route('company.region', 'crimea')}}">
                            <span>АР Крым</span>
                        </a>
                    </span>
                    <hr class="mt-1 mb-2">
                    <div class="section text-left">
                        <div class="row">
                            <div class="col" style="column-count: 3">
                                @foreach($regions as $index => $region)
                                    @if($rubric_id and $region)
                                        <a class="regionLink {{(!empty($obj_region) && $obj_region['translit'] == $region['translit']) ? 'active' : '' }}"
                                           href="{{route('company.region_culture', [$region['translit'], $rubric_id])}}">
                                            <span>{{$region['name'] != 'Вся Украина' ? $region['name'].' область' : 'Вся Украина'}} </span>
                                            <span class="companyCount small">({{$region['count_items']}})</span>
                                        </a>
                                    @else
                                        <a class="regionLink {{(!empty($obj_region) && $obj_region['translit'] == $region['translit']) ? 'active' : ''}}"
                                           href="{{route('company.region', $region['translit'])}}">
                                            <span>{{$region['name'] != 'Вся Украина' ? $region['name'].' область' : 'Вся Украина'}}</span>
                                            <span class="companyCount small">({{$region['count_items']}})</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col searchDiv" data-tip="Введите поисковой запрос">
                <form class="searchForm" style="display: flex" method="GET">
                    @if(isset($query) && $query != null)
                        <input maxlength="32" type="text" name="query" id="searchInput" class="searchInput" placeholder="Я ищу.."
                               value="{{isset($query) && $query != null ? $query : ''}}">
                    @else
                        <input maxlength="32" type="text" name="query" id="searchInput" class="searchInput" placeholder="Я ищу.." value="">
                    @endif

                    <div class="col-auto search">
                        <button type="submit" class="btn-search">
                            <i class="far fa-search searchIcon mt-2 ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>


        </div>
    </div>
    <div class="row mt-4 pt-3">
        <div class="col-12 col-sm-6 float-left mt-0 d-flex d-sm-block">
            <h2 class="d-inline-block text-uppercase">{!! isset($query) ? 'Поиск: '. $query : 'Список компаний' !!}</h2>
            <div>
                <a href="/tarif20.html" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
            </div>
        </div>
        <div class="col-12 col-sm-6 float-md-right text-right">
            <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end">
                <i class="far fa-plus mr-2"></i>
                <span class="pl-1 pr-1">Разместить компанию</span>
            </a>
        </div>
    </div>
</div>

<div class="new_container">
    <h2 class="d-block text-uppercase d-sm-none companies_list">{!! isset($query) ? 'Поиск: '. $query : 'Список компаний' !!}</h2>
</div>


<div class="bg_filters"></div>

<button class="openFilter companyFind">
    <span>Найти компанию</span>
    <img src="https://agrotender.com.ua/app/assets/img/search_icon.svg" alt="">
</button>

<div class="mobile_filter-bg">
    <div class="mobile_filter">
    <div class="posrel">
        <div class="mobile_filter-header">
        <button class="back first-btn active">
            <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
        </button>
        <button class="back second-btn">
            <img src="https://agrotender.com.ua/app/assets/img/chevron_left-bold.svg" alt="">
        </button>
        <button class="back third-btn">
            <img src="https://agrotender.com.ua/app/assets/img/chevron_left-bold.svg" alt="">
        </button>
        <span>Фильтры</span>
        <a href="{{route('company.companies')}}" id="filterRebootBtn">Сбросить</a>
        </div>

        <div class="screens">
        <div class="first active">
            <div class="mobile_filter-content">
                <div class="search_wrap">
                    <input type="text" placeholder="Название компании" class="search_filed_no_js first_screen" id="companySearchField">             
                    <button class="first_screen" id="companySearchBtn">
                        <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                    </button>
                </div>
                <div class="mobile_filter-content-item withmargin" id="product" data-product="">Выбрать продукцию</div>
                <div class="mobile_filter-content-item withmargin" id="region" data-region="region_kyiv">Вся Украина</div>
            </div>

            <div class="mobile-filter-footer">
            <button>Применить</button>
            </div>
        </div>

        <div class="second">
            <div class="subItem">
            <div class="mobile_filter-content-item">Зерновые</div>
            <div class="mobile_filter-content-item">Масличные</div>
            <div class="mobile_filter-content-item">Бобовые</div>
            <div class="mobile_filter-content-item">Продукты переработки</div>
            <div class="mobile_filter-content-item">Нишевые культуры</div>
            </div>
            <div class="subItem">
            <div class="search_wrap">
                <input type="text" placeholder="Название области или порта" class="search_filed">             
                <button>
                <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                </button>
            </div>
            <div class="default_value">
                <div class="mobile_filter-section-text">Порты</div>
                <ul class="mobile_filter-section-list">
                <li>
                    <a href="#" data-id="1" data-url="region_ukraine">Вся Украина</a>
                </li>
                <li>
                    <a href="#" data-id="1" data-url="kiyv">Киев</a>
                </li>
                <li>
                    <a href="#" data-id="1" data-url="kharkov">Харьков</a>
                </li>
                <li>
                    <a href="#" data-id="1" data-url="odessa">Одесса</a>
                </li>
                <li>
                    <a href="#" data-id="1" data-url="winnica">Винница</a>
                </li>
                </ul>
            </div>
            <div class="output_values">
                <ul class="mobile_filter-section-list output"></ul>
            </div>
            </div>
        </div>

        <div class="third">
            <div class="subItem">
            <div class="search_wrap">
                <input type="text" placeholder="Название области или порта" class="search_filed">             
                <button>
                <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                </button>
            </div>
            <div class="default_value">
                <div class="mobile_filter-section-text">Популярное</div>
                <ul class="mobile_filter-section-list">
                <li>
                    <a href="#" data-id="0" data-product="psheniza_2kl">Пшеница 2 кл. (64)</a>
                </li>
                <li>
                    <a href="#" data-id="0" data-product="psheniza_3kl">Пшеница 3 кл. (63)</a>
                </li>
                <li>
                    <a href="#" data-id="0" data-product="psheniza_4kl">Пшеница 4 кл. (59)</a>
                </li>
                <li>
                    <a href="#" data-id="0">Ячмень (51)</a>
                </li>
                <li>
                    <a href="#" data-id="0">Кукуруза (27)</a>
                </li>
                </ul>
                <div class="mobile_filter-section-text">Все зерновые</div>
                <ul class="mobile_filter-section-list">
                <li>
                    <a href="#" data-id="0" data-product="">Вся рубрика</a>
                </li>
                <li>
                    <a href="#" data-id="0"  data-product="kukuruza">Кукуруза (27)</a>
                </li>
                <li>
                    <a href="#" data-id="0"  data-product="kukuruza">>Кукуруза битая (2)</a>
                </li>
                <li>
                    <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
                </li>
                <li>
                    <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
                </li>
                <li>
                    <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
                </li>
                </ul>
            </div>
            <div class="output_values">
                <ul class="mobile_filter-section-list output"></ul>
            </div>
            </div>
            <div class="subItem">
            <div class="mobile_filter-section-text">Популярное</div>
            <ul class="mobile_filter-section-list">
                <li>
                <a href="#" data-id="0">Пшеница 2 кл. (64)</a>
                </li>
                <li>
                <a href="#" data-id="0">Пшеница 3 кл. (63)</a>
                </li>
                <li>
                <a href="#" data-id="0">Пшеница 4 кл. (59)</a>
                </li>
                <li>
                <a href="#" data-id="0">Ячмень (51)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
                </li>
            </ul>
            <div class="mobile_filter-section-text">Все зерновые</div>
            <ul class="mobile_filter-section-list">
                <li>
                <a href="#" data-id="0">Вся рубрика</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза битая (2)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
                </li>
                <li>
                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
                </li>
            </ul>
            </div>
            <div class="subItem">
            <div class="mobile_filter-section-text">Популярное</div>
            <ul class="mobile_filter-section-list">
                <li>
                <a href="#" data-id="0">Пшеница 2 кл. (64)</a>
                </li>
                <li>
                <a href="#" data-id="0">Пшеница 3 кл. (63)</a>
                </li>
                <li>
                <a href="#" data-id="0">Пшеница 4 кл. (59)</a>
                </li>
                <li>
                <a href="#" data-id="0">Ячмень (51)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
                </li>
            </ul>
            <div class="mobile_filter-section-text">Все зерновые</div>
            <ul class="mobile_filter-section-list">
                <li>
                <a href="#" data-id="0">Вся рубрика</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза битая (2)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
                </li>
                <li>
                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
                </li>
            </ul>
            </div>
            <div class="subItem">
            <div class="mobile_filter-section-text">Популярное</div>
            <ul class="mobile_filter-section-list">
                <li>
                <a href="#" data-id="0">Пшеница 2 кл. (64)</a>
                </li>
                <li>
                <a href="#" data-id="0">Пшеница 3 кл. (63)</a>
                </li>
                <li>
                <a href="#" data-id="0">Пшеница 4 кл. (59)</a>
                </li>
                <li>
                <a href="#" data-id="0">Ячмень (51)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
                </li>
            </ul>
            <div class="mobile_filter-section-text">Все зерновые</div>
            <ul class="mobile_filter-section-list">
                <li>
                <a href="#" data-id="0">Вся рубрика</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза битая (2)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
                </li>
                <li>
                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
                </li>
            </ul>
            </div>
            <div class="subItem">
            <div class="mobile_filter-section-text">Популярное</div>
            <ul class="mobile_filter-section-list">
                <li>
                <a href="#" data-id="0">Пшеница 2 кл. (64)</a>
                </li>
                <li>
                <a href="#" data-id="0">Пшеница 3 кл. (63)</a>
                </li>
                <li>
                <a href="#" data-id="0">Пшеница 4 кл. (59)</a>
                </li>
                <li>
                <a href="#" data-id="0">Ячмень (51)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
                </li>
            </ul>
            <div class="mobile_filter-section-text">Все зерновые</div>
            <ul class="mobile_filter-section-list">
                <li>
                <a href="#" data-id="0">Вся рубрика</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза битая (2)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
                </li>
                <li>
                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
                </li>
                <li>
                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
                </li>
            </ul>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>

<style>
    .btn-search{
        background: none;
        border: none;
        outline: 0 !important;
    }

    .searchInput {
        padding: .375rem 6rem .475rem 1.4rem!important;
    }
</style>
