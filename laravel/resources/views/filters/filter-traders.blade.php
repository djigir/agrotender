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
</div>
<div class="bg_filters"></div>
<div class="new_filters-wrap">
    <div class="fixed-item">
        <div class="new_container">
            <div class="new_filters">
                <div class="filter__item main">
                    <button class="filter__button main">Закупки</button>
                    <div class="new_filters_dropdown-wrap">
                        <div class="new_filters_dropdown">
                            @if($region)
                                <ul>
                                    @if($culture_id && $region)
                                        <li>
                                            <a href="{{route('traders_forwards_culture', [$region , $culture_translit])}}">Форварды</a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="{{route('traders_sell',  $region)}}">Продажи</a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="filter__item producrion" id="choseProduct">
                    <button class="filter__button producrion-btn">
                        {{$culture_name}}
                    </button>
                    <div class="new_filters_dropdown-wrap">
                        <div class="new_filters_dropdown">
                            <div class="new_filters_dropdown-column">
                                <ul>
                                    @foreach($rubricsGroup as $group => $item)
                                        <li class="group-culture {{$item['index_group']+1 == $group_id ? 'active': ''}}" group="{{$group+1}}">
                                            <a href="#">{{$item['groups']['name']}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @foreach($rubricsGroup as $group => $item)
                                <div class="new_filters_dropdown-content culture-group {{$item['index_group']+1 == $group_id ? 'active': ''}}" group="{{$group+1}}">
                                    <ul>
                                        @foreach($rubricsGroup[$group]["products"] as $index => $item)
                                            <li>
                                                @if(!empty($region))
                                                    <a href="{{route('traders.traders_regions_culture', [$region, $item['url']])}}">
                                                        {{ $item['culture']['name']}}
                                                    </a>
                                                @endif

                                                @if(!empty($port))
                                                    <a href="{{route('traders.traders_port_culture', [$port, $item['url']])}}">
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
                        {{$region_port_name}}
                    </button>
                    <div class="new_filters_dropdown-wrap">
                        <div class="new_filters_dropdown">
                            <div class="new_filters_dropdown-column">
                                <ul>
                                    <li class="" id="active-region" check_active="{{!empty($region) ? true : false}}">
                                        <a href="#">Области</a>
                                    </li>
                                    <li class="" id="active-port" check_active="{{!empty($port) ? true : false}}">
                                        <a href="#">Порты</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="new_filters_dropdown-content active" id="show-region">
                                <ul>
                                    @foreach($regions as $index => $region)
                                        <li>
                                            @if(!empty($culture) && !empty($region))
                                                <a href="{{route('traders.traders_regions_culture', [$region['translit'], $culture_translit])}}">
                                                    {{$region['name']}}
                                                </a>
                                            @else
                                                @if(!empty($culture_translit))
                                                    <a href="{{route('traders.traders_regions_culture', [$region['translit'], $culture_translit])}}">
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
                                            @if(!empty($culture) && !empty($port))
                                                <a href="{{route('traders.traders_port_culture', [$port['url'], $culture_translit])}}">
                                                    {{$port['portname']}}
                                                </a>
                                            @else
                                                @if(!empty($culture_translit))
                                                    <a href="{{route('traders.traders_port_culture', [$port['url'], $culture_translit])}}">
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
                            <input class="inp-cbx" id="new_filters_currency_uah" type="checkbox"  currency="{{$currency}}">
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
                            <input class="inp-cbx" id="new_filters_currency_usd" type="checkbox" currency="{{$currency}}">
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
