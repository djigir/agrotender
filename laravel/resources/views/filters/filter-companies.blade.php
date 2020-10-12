<div class="d-none d-sm-block container mt-3">
    <ol class="breadcrumbs small p-0">
        <li><a href="/">Главная</a></li>
        <i class="fas fa-chevron-right extra-small"></i>
        <li><h1>Компании в Украине</h1></li>
    </ol>
    <div class="content-block mt-3 py-3 px-4">
        <div class="form-row align-items-center position-relative">
            <div class="col-3 mr-2">
                <button class="btn rubricInput text-center drop-btn">Все рубрики <i
                        class="ml-2 small far fa-chevron-down"></i></button>
            </div>
            <div class="dropdown-wrapper position-absolute rubricDrop">
                <div class="dropdown" id="rubricDrop" style="display: block;">
                    <div class="section text-left">
                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                        <div class="row">
                            <div class="col-auto">
                                @foreach($rubricGroups as $index => $rubric)
                                    <a class="rubricLink getRubricGroup " href="#" group="1">
                                    <span class="test">{{$index}}
                                        <span class="ml-4 float-right right">
                                            <i class="far fa-chevron-right"></i>
                                        </span>
                                    </span>
                                    </a>
                                @endforeach

                            </div>
                            <div class="col-auto rubricGroup pr-0 mr-3 group-1" style="display: block; column-count: 2">
                                @foreach($rubricGroups['Сельхоз производители']["comp_topic"] as $index => $culture)
                                    <a class="regionLink" href="{{route('company.company_region_rubric_number', ['ukraine', 1])}}">
                                        <span>{{$rubricGroups['Сельхоз производители']["comp_topic"][$index]['title']}}</span>
{{--                                        <span class="companyCount small">(1546)</span>--}}
                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                    </a>
                                @endforeach
                            </div>
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-2" style="display: none; column-count: 2">--}}
{{--                                @foreach($rubricGroups['Переработчики']["comp_topic"] as $index => $culture)--}}
{{--                                    <a class="regionLink" href="{{route('company.company_region_rubric_number', $rubricGroups['Переработчики']["comp_topic"][$index]['id'])}}">--}}
{{--                                        <span>{{$rubricGroups['Переработчики']["comp_topic"][$index]['title']}}</span>--}}
{{--                                    --}}{{--                                        <span class="companyCount small">(1546)</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                    </a>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-3" style="display: none; column-count: 2">--}}
{{--                                @foreach($rubricGroups['Техника и оборудование']["comp_topic"] as $index => $culture)--}}
{{--                                    <a class="regionLink" href="{{route('company.company_region_rubric_number', $rubricGroups['Техника и оборудование']["comp_topic"][$index]['id'])}}">--}}
{{--                                        <span>{{$rubricGroups['Техника и оборудование']["comp_topic"][$index]['title']}}</span>--}}
{{--                                    --}}{{--                                        <span class="companyCount small">(1546)</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                    </a>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-4" style="display: none; column-count: 2">--}}
{{--                                @foreach($rubricGroups['Агрохимия']["comp_topic"] as $index => $culture)--}}
{{--                                    <a class="regionLink" href="{{route('company.company_region_rubric_number', $rubricGroups['Агрохимия']["comp_topic"][$index]['id'])}}">--}}
{{--                                        <span>{{$rubricGroups['Агрохимия']["comp_topic"][$index]['title']}}</span>--}}
{{--                                    --}}{{--                                        <span class="companyCount small">(1546)</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                    </a>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-4" style="display: none; column-count: 2">--}}
{{--                                @foreach($rubricGroups['Закупка и реализация']["comp_topic"] as $index => $culture)--}}
{{--                                    <a class="regionLink" href="{{route('company.company_region_rubric_number', $rubricGroups['Закупка и реализация']["comp_topic"][$index]['id'])}}">--}}
{{--                                        <span>{{$rubricGroups['Закупка и реализация']["comp_topic"][$index]['title']}}</span>--}}
{{--                                    --}}{{--                                        <span class="companyCount small">(1546)</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                    </a>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-4" style="display: none; column-count: 2">--}}
{{--                                @foreach($rubricGroups['Перевозки']["comp_topic"] as $index => $culture)--}}
{{--                                    <a class="regionLink" href="{{route('company.company_region_rubric_number', $rubricGroups['Перевозки']["comp_topic"][$index]['id'])}}">--}}
{{--                                        <span>{{$rubricGroups['Перевозки']["comp_topic"][$index]['title']}}</span>--}}
{{--                                    --}}{{--                                        <span class="companyCount small">(1546)</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                    </a>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                            <div class="col-auto rubricGroup pr-0 mr-3 group-4" style="display: none; column-count: 2">--}}
{{--                                @foreach($rubricGroups['Услуги']["comp_topic"] as $index => $culture)--}}
{{--                                    <a class="regionLink" href="{{route('company.company_region_rubric_number', $rubricGroups['Услуги']["comp_topic"][$index]['id'])}}">--}}
{{--                                        <span>{{$rubricGroups['Услуги']["Услуги"][$index]['title']}}</span>--}}
{{--                                    --}}{{--                                        <span class="companyCount small">(1546)</span>--}}
{{--                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                    </a>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 mr-2">
                <button class="btn regionInput text-center drop-btn">Вся Украина<i
                        class="ml-2 small far fa-chevron-down"></i></button>
            </div>
            <div class="dropdown-wrapper position-absolute regionDrop">
                <div class="dropdown" style="display: none;">
            <span class="d-block">
              <a class="regionLink d-inline-block text-muted disabled"
                 href="{{route('company.company_and_region', 'ukraine')}}">
              <span>Вся Украина</span>
                  <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
              </a>
              <a class="regionLink d-inline-block" href="{{route('company.company_and_region', 'crimea')}}">
              <span>АР Крым</span>
                  <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
              </a>
            </span>
                    <hr class="mt-1 mb-2">
                    <div class="section text-left">
                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                        <div class="row">
                            <div class="col" style="column-count: 2">
                                @foreach($regions as $index => $region)
                                    @if($index > 0)
                                        <a class="regionLink"
                                           href="{{route('company.company_and_region', $region->translit)}}">
                                            <span>{{$region->name}} область</span>
                                            {{--                                        <span class="companyCount small">(180)</span>--}}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col searchDiv" data-tip="Введите поисковой запрос">
                <form class="searchForm">
                    <input maxlength="32" type="text" name="text" class="searchInput" placeholder="Я ищу..">
                </form>
            </div>
            <div class="col-auto">
                <i class="far fa-search searchIcon mt-2 ml-2"></i>
            </div>
        </div>
    </div>
    <div class="row mt-4 pt-3">
        <div class="col-12 col-sm-4 float-left mt-4 mt-md-0 d-flex d-sm-block">
            <h2 class="d-inline-block text-uppercase">Список компаний</h2>
            <a href="/tarif20.html" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
        </div>
        <div class="col-12 col-sm-8 float-md-right text-center text-md-right">
            <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end">
                <i class="far fa-plus mr-2"></i>
                <span class="pl-1 pr-1">Разместить компанию</span>
            </a>
            <!-- <a href="/add_buy_trader" class="top-btn btn btn-warning align-items-end">
              <span class="pt-1"><i class="far fa-plus mr-2"></i> Разместить компанию</span>
            </a> -->
        </div>
    </div>
</div>

<script>
    var cookies_obj = {};
    window.onload = function () {
        $(".test").click(function (event) {


        });
    }
</script>
