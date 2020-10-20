<div class="new_filters-wrap">
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
                    <button class="filter__button producrion-btn">
                        @if($culture_name)
                            {{$culture_name}}
                        @else
                            Выбрать продукцию
                        @endif
                    </button>
                    <div class="new_filters_dropdown-wrap">
                        <div class="new_filters_dropdown">
                            <div class="new_filters_dropdown-column">
                                <ul>
                                    @foreach($rubricsGroup as $group => $item)
                                        <li class="">
                                            <a href="#" class="test">{{$item['groups']['name']}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="new_filters_dropdown-content 1 active" id="cereals">
                                <ul>
                                    @foreach($rubricsGroup[0]["products"] as $index => $item)
                                       <li>
                                           @if(isset($current_region))
                                               <a href="{{route('traders.traders_regions_culture', [$current_region, $item['url']])}}?viewmod=nontbl">
                                                   {{ $item['culture']['name']}}
                                               </a>
                                           @endif
                                           @if(isset($current_port))
                                              <a href="{{route('traders.traders_port_culture', [$current_port, $item['url']])}}?viewmod=nontbl">
                                                {{ $item['culture']['name']}}
                                              </a>
                                           @endif
                                       </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="new_filters_dropdown-content 7" id="oilseeds">
                                <ul>
                                    @foreach($rubricsGroup[1]["products"] as $index => $item)
                                        <li>
                                            @if(isset($current_region))
                                                <a href="{{route('traders.traders_regions_culture', [$current_region, $item['url']])}}?viewmod=nontbl">
                                                    {{ $item['culture']['name']}}
                                                </a>
                                            @endif
                                            @if(isset($current_port))
                                                <a href="{{route('traders.traders_port_culture', [$current_port, $item['url']])}}?viewmod=nontbl">
                                                    {{ $item['culture']['name']}}
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="new_filters_dropdown-content 3 " id="legumes">
                                <ul>
                                    @foreach($rubricsGroup[2]["products"] as $index => $item)
                                        <li>
                                            @if(isset($current_region))
                                                <a href="{{route('traders.traders_regions_culture', [$current_region, $item['url']])}}?viewmod=nontbl">
                                                    {{ $item['culture']['name']}}
                                                </a>
                                            @endif
                                            @if(isset($current_port))
                                                <a href="{{route('traders.traders_port_culture', [$current_port, $item['url']])}}?viewmod=nontbl">
                                                    {{ $item['culture']['name']}}
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>


                            </div>
                            <div class="new_filters_dropdown-content 2" id="niche_crops">
                                <ul>
                                    @foreach($rubricsGroup[3]["products"] as $index => $item)
                                        <li>
                                            @if(isset($current_region))
                                                <a href="{{route('traders.traders_regions_culture', [$current_region, $item['url']])}}?viewmod=nontbl">
                                                    {{ $item['culture']['name']}}
                                                </a>
                                            @endif
                                            @if(isset($current_port))
                                                <a href="{{route('traders.traders_port_culture', [$current_port, $item['url']])}}?viewmod=nontbl">
                                                    {{ $item['culture']['name']}}
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>


                            </div>
                            <div class="new_filters_dropdown-content 4" id="processing_products">
                                <ul>
                                    @foreach($rubricsGroup[4]["products"] as $index => $item)
                                        <li>
                                            @if(isset($current_region))
                                                <a href="{{route('traders.traders_regions_culture', [$current_region, $item['url']])}}?viewmod=nontbl">
                                                    {{ $item['culture']['name']}}
                                                </a>
                                            @endif
                                            @if(isset($current_port))
                                                <a href="{{route('traders.traders_port_culture', [$current_port, $item['url']])}}?viewmod=nontbl">
                                                    {{ $item['culture']['name']}}
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="new_filters_dropdown-content 16" id="organic">
                                <ul>
                                    @foreach($rubricsGroup[5]["products"] as $index => $item)
                                        <li>
                                            @if(isset($current_region))
                                                <a href="{{route('traders.traders_regions_culture', [$current_region, $item['url']])}}?viewmod=nontbl">
                                                    {{ $item['culture']['name']}}
                                                </a>
                                            @endif
                                            @if(isset($current_port))
                                                <a href="{{route('traders.traders_port_culture', [$current_port, $item['url']])}}?viewmod=nontbl">
                                                    {{ $item['culture']['name']}}
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter__item second" id="all_ukraine">
                    <button class="filter__button second">
                        @if(isset($region_name))
                            {{$region_name}}
                        @endif

                        @if(isset($port_name))
                            {{$port_name}}
                        @endif
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
                                    @foreach($regions as $index => $region)
                                            <li>
                                                @if(isset($current_region) and isset($current_culture))
                                                    <a href="{{route('traders.traders_regions_culture', [$region['translit'], $current_culture])}}">
                                                        {{$region['name']}}
                                                    </a>
                                                @else
                                                    <a href="{{route('traders.traders_regions', $region['translit'])}}">
                                                        {{$region['name']}}
                                                    </a>
                                                @endif
                                            </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="new_filters_dropdown-content active">
                                <ul>
                                    @foreach($onlyPorts as $index => $port)
                                        <li>
                                            @if(isset($current_port) and isset($current_culture))
                                                <a href="{{route('traders.traders_port_culture', [$port['url'], $current_culture])}}">
                                                    {{$port['portname']}}
                                                </a>
                                            @else
                                                <a href="{{route('traders.traders_port', $port['url'])}}">
                                                    {{$port['portname']}}
                                                </a>
                                            @endif
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
