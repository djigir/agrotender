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
                    <li>
                        <a href="{{$culture_translit ? route('traders_forward.region_culture', [$region , 'kukuruza']) :  route('traders_forward.region',  $region)}}">Форварды</a>
                    </li>
                    <li>
                        <a href="{{$culture_translit ? route('traders.region_culture',  [$region , 'kukuruza']) : route('traders.region',  $region)}}">Закупки</a>
                    </li>
                    <li>
                        <a href="{{$culture_translit ? route('traders_sell.region_culture',  [$region , 'kukuruza']) : route('traders_sell.region',  $region)}}">Продажи</a>
                    </li>
                @endif
                @if($port)
                    <li>
                        <a href="{{$culture_translit ? route('traders_forward.port_culture', [$port , $culture_translit]) : route('traders_forward.port',  $port)}}">Форварды</a>
                    </li>
                    <li>
                        <a href="{{$culture_translit ? route('traders.port_culture',  [$port , 'kukuruza']) : route('traders.port',  $port)}}">Закупки</a>
                    </li>
                    <li>
                        <a href="{{$culture_translit ? route('traders_sell.port_culture',  [$port , 'kukuruza']) : route('traders_sell.port',  $port)}}">Продажи</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
