<div class="new_filters-wrap">
{{--    <div class="replacement"></div>--}}
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
                                            <a href="#" class="test">{{$group}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
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
                            <div class="new_filters_dropdown-content active">
                                <ul>
                                    @foreach($regions as $index => $region)
                                        <li>
                                            <a href="{{route('traders.traders_regions', $region->translit)}}">{{$region->name}}</a>
                                        </li>
                                    @endforeach
                                    <li>
                                        <a href="{{route('traders.traders_regions', ['region' => 'ukraine'])}}">Вся Укрина</a>
                                    </li>

                                </ul>

                            </div>
                            <div class="new_filters_dropdown-content ">
                                <ul>
                                    @foreach($onlyPorts as $index => $port)
                                        <li>
                                            <a href="{{route('traders.traders_port', $port['url'])}}">{{$port['portname']}}</a>
                                        </li>
                                    @endforeach
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


<script>
    window.onload = function () {
        $("#choseProduct").click(function () {

            if (!$("#choseProduct").hasClass('active')) {
                $("#choseProduct").addClass('active');
            } else {
                $("#choseProduct").removeClass('active');
            }

        });

        $("#all_ukraine").click(function () {
            if (!$("#all_ukraine").hasClass('active')) {
                $("#all_ukraine").addClass('active');
            } else {
                $("#all_ukraine").removeClass('active');
            }

        });
        $(".regionInput").click(function () {
            if (!$(".regionInput").hasClass('isopen')) {
                $(".regionInput").addClass('isopen');
            } else {
                $(".regionInput").removeClass('isopen');
            }

        });

        $(".rubricInput").click(function () {
            if (!$(".rubricInput").hasClass('isopen')) {
                $(".rubricInput").addClass('isopen');
            } else {
                $(".rubricInput").removeClass('isopen');
            }

        });

        $(".test").click(function (event) {
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
