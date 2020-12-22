

<div class="d-none d-sm-block new_container mt-3">
    <ol class="breadcrumbs small p-0">
        <li>
            <a href="/">Главная</a>
        </li>
        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z" fill="#93A2BA"/>
        </svg>
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
            @if(isset($breadcrumb['arrow']))
                <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z" fill="#93A2BA"/>
                </svg>
            @endif
        @endforeach
    </ol>


    <div class="bg_filters"></div>

    <div
        class="new_fitlers_container"
        data-companyName=""
        data-category=""
        data-region=""
        data-type="companies"
    >
        <div class="company_filter">
            <form>
                <input type="text" class="company_filter-item search_field" placeholder="Название компании">
                <button type="button" class="company_filter-item chose_field first-btn new_filters_btn">Выбрать категорию</button>
                <button type="button" class="company_filter-item chose_field second-btn new_filters_btn">Вся Украина</button>
                <button type="submit" class="company_filter-item search_btn">Найти</button>
            </form>

            <div class="new_filters_dropdown" id="category_dropdown">
                <div class="new_filters_dropdown_column culures_first js_first">
                    <ul>
                        <li>
                            <a href="#">Hello</a>
                        </li>
                    </ul>
                </div>
                <div class="new_filters_dropdown_column content">
                    <div class="new_filters_dropdown_column_tab js_content">
                        <div class="new_filters_dropdown_column_item">
                            <ul>
                                <li>
                                    <a href="#" class="companies_link_category" data-url="hello">Hello</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="new_filters_dropdown" id="country_dropdown">
                <div class="new_filters_dropdown_column culures_first js_first">
                    <ul>
                        <li>
                            <a href="#">Hello</a>
                        </li>
                    </ul>
                </div>
                <div class="new_filters_dropdown_column content">
                    <div class="new_filters_dropdown_column_tab js_content">
                        <div class="new_filters_dropdown_column_item">
                            <ul>
                                <li>
                                    <a href="#" class="companies_link_country" data-url="world">World!</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
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
    -->

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
