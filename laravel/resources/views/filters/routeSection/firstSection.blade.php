<div class="filter__item main">

    <button class="filter__button main">
        @if($type_traders == 0)
            Закупки
        @elseif($type_traders == 1)
            Форварды
        @else
            Продажи
        @endif
    </button>

    <div class="new_filters_dropdown-wrap">
        <div class="new_filters_dropdown">
            <ul>
                @if($region)
                    @if($type_traders != 1 && $culture_translit)
                        <li>
                            <a href="{{route('traders_forward.region_culture', [$region , $culture_translit])}}">Форварды</a>
                        </li>
                    @endif
                    @if($type_traders != 0)
                        <li>
                            <a href="{{$culture_translit ? route('traders.region_culture',  [$region , $culture_translit]) : route('traders.region',  $region)}}">Закупки</a>
                        </li>
                    @endif

                    @if($type_traders != 2)
                        <li>
                            <a href="{{$culture_translit ? route('traders_sell.region_culture',  [$region , $culture_translit]) : route('traders_sell.region',  $region)}}">Продажи</a>
                        </li>
                    @endif
                @endif
                @if($port)
                    @if($culture_id && $port && $type_traders != 1)
                        <li>
                            <a href="{{route('traders_forward.port_culture', [$port , $culture_translit])}}">Форварды</a>
                        </li>
                    @endif
                    @if($type_traders != 0)
                        <li>
                            <a href="{{$culture_translit ? route('traders.port_culture',  [$port , $culture_translit]) : route('traders.port',  $port)}}">Закупки</a>
                        </li>
                    @endif

                    @if($type_traders != 2)
                        <li>
                            <a href="{{$culture_translit ? route('traders_sell.port_culture',  [$port , $culture_translit]) : route('traders_sell.port',  $port)}}">Продажи</a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</div>
