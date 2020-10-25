<div class="d-none d-sm-block container mt-3">
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
                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
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
                                    <div class="col-auto rubricGroup pr-0 mr-3 groupCulture " group="{{$rubric['id']}}" style="display: none; column-count: 2">
                                        @foreach($rubricGroups[$rubric['id']]["comp_topic"] as $index => $culture)
                                            <a class="regionLink {{$culture_name == $culture['title'] ? 'active' : ''}}"
                                               href="{{route('company.company_region_rubric_number', [isset($region) ? $region : 'ukraine', $culture['id']])}}">
                                            <span>{{$culture['title']}}</span>
                                            <span class="companyCount small">({{$culture['cnt']}})</span>
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
                        <a class="regionLink d-inline-block {{(isset($region) and $region == 'ukraine') ? 'text-muted disabled' : ''}}" href="{{route('company.company_and_region', 'ukraine')}}">
                            <span style="cursor: pointer">Вся Украина</span>
                        </a>
                        <a class="regionLink d-inline-block {{(isset($region) and $region == 'crimea') ? 'text-muted disabled' : ''}}" href="{{route('company.company_and_region', 'crimea')}}">
                            <span>АР Крым</span>
                        </a>
                    </span>
                    <hr class="mt-1 mb-2">
                    <div class="section text-left">
                        <div class="row">
                            <div class="col" style="column-count: 3">
                                @foreach($regions as $index => $region)
                                    @if(isset($rubric_id) and isset($region))
                                        <a class="regionLink {{($region == $region['translit']) ? 'active' : '' }}"
                                           href="{{route('company.company_region_rubric_number', [$region['translit'], $rubric_id])}}">
                                            <span>{{$region['name'] != 'Вся Украина' ? $region['name'].' область' : 'Вся Украина'}} </span>
                                        </a>
                                    @else
                                        <a class="regionLink {{($region == $region['translit']) ? 'active' : ''}}"
                                           href="{{route('company.company_and_region', $region['translit'])}}">
                                            <span>{{$region['name'] != 'Вся Украина' ? $region['name'].' область' : 'Вся Украина'}} </span>
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
        <div class="col-12 col-sm-4 float-left mt-4 mt-md-0 d-flex d-sm-block">
            <h2 class="d-inline-block text-uppercase">{!! isset($query) ? 'Поиск: '. $query : 'Список компаний' !!}</h2>
            <a href="/tarif20.html" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
        </div>
        <div class="col-12 col-sm-8 float-md-right text-center text-md-right">
            <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end">
                <i class="far fa-plus mr-2"></i>
                <span class="pl-1 pr-1">Разместить компанию</span>
            </a>
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
