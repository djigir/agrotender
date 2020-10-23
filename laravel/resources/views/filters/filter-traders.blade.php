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
                        @if(isset($culture_name))
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
                                        <li class="group-culture {{$item['id'] == $group_culture_id ? 'active': ''}}" group="{{$group+1}}">
                                            <a href="#">{{$item['groups']['name']}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @foreach($rubricsGroup as $group => $item)
                                <div class="new_filters_dropdown-content culture-group {{$item['id'] == $group_culture_id ? 'active': ''}}" group="{{$group+1}}">
                                    <ul>
                                        @foreach($rubricsGroup[$group]["products"] as $index => $item)
                                            <li>
                                                @if(isset($current_region))
                                                    <a href="{{route('traders.traders_regions_culture', [$current_region, $item['url']])}}">
                                                        {{ $item['culture']['name']}}
                                                    </a>
                                                @endif

                                                @if(isset($current_port))
                                                    <a href="{{route('traders.traders_port_culture', [$current_port, $item['url']])}}">
                                                        {{ $item['culture']['name']}}
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
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
                                    <li class="active" id="active-region">
                                        <a href="#">Области</a>
                                    </li>
                                    <li class="" id="active-port">
                                        <a href="#">Порты</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="new_filters_dropdown-content active" id="show-region">
                                <ul>
                                    @foreach($regions as $index => $region)
                                        <li>
                                            @if(!empty($current_culture) && !empty($current_region))
                                                <a href="{{route('traders.traders_regions_culture', [$region['translit'], $current_culture])}}">
                                                    {{$region['name']}}
                                                </a>
                                            @else
                                                @if(!empty($current_culture))
                                                    <a href="{{route('traders.traders_regions_culture', [$region['translit'], $current_culture])}}">
                                                        {{$region['name']}}
                                                    </a>
                                                @else
                                                    <a href="{{route('traders.traders_regions', $region['translit'])}}">
                                                        {{$region['name']}}
                                                    </a>
                                                @endif
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="new_filters_dropdown-content" id="show-port" style="column-count: 3">
                                <ul>
                                    @foreach($onlyPorts as $index => $port)
                                        <li>
                                            @if(isset($current_culture) and isset($current_port))
                                                <a href="{{route('traders.traders_port_culture', [$port['url'], $current_culture])}}">
                                                    {{$port['portname']}}
                                                </a>
                                            @else
                                                @if(isset($current_culture))
                                                    <a href="{{route('traders.traders_port_culture', [$port['url'], $current_culture])}}">
                                                        {{$port['portname']}}
                                                    </a>
                                                @else
                                                    <a href="{{route('traders.traders_port', $port['url'])}}">
                                                        {{$port['portname']}}
                                                    </a>
                                                @endif
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <form style="display:flex;">
                    <div class="new_filters_checkbox first">
                        <button type="submit" class="btn-remove" name="currency" value="0">
                            <input class="inp-cbx" id="new_filters_currency_uah" type="checkbox">
                        <label class="cbx" for="new_filters_currency_uah">
                            <span>
                              <svg width="12px" height="10px">
                                <use xlink:href="#check"></use>
                              </svg>
                            </span>
                            <span name="uah">ГРН</span>
                        </label>
                        </button>
                    </div>
                    <div class="new_filters_checkbox second">
                        <button type="submit" class="btn-remove" name="currency" value="1">
                            <input class="inp-cbx" id="new_filters_currency_usd" type="checkbox">
                        <label class="cbx" for="new_filters_currency_usd">
                            <span>
                              <svg width="12px" height="10px">
                                <use xlink:href="#check"></use>
                              </svg>
                            </span>
                            <span>USD</span>
                        </label>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<style>
    .btn-remove{
        border: none;
        background: none;
        margin-top: 10px;
        margin-right: -10px;
        outline: 0 !important;
    }
</style>
