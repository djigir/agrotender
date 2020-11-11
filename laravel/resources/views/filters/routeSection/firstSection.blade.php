<div class="filter__item main">

    <button class="filter__button main">
        @if($type_traders == 0)
            Закупки
        @elseif($type_traders == 1)
            Форварды
        @endif
    </button>

    <div class="new_filters_dropdown-wrap">
        <div class="new_filters_dropdown">
            <ul>
                @if($region)
                    @if($type_traders != 1)
                    <li>
                        <a href="{{$culture_translit ? route('traders_forward.region_culture', [$region , $culture_translit]) :  route('traders_forward.region',  $region)}}">Форварды</a>
                    </li>
                    @endif

                    @if($type_traders != 0)
                    <li>
                        <a href="{{$culture_translit ? route('traders.region_culture',  [$region , $culture_translit]) : route('traders.region',  $region)}}">Закупки</a>
                    </li>
                    @endif
                @endif

                @if($port)
                    @if($type_traders != 1)
                        <li>
                            <a href="{{$culture_translit ? route('traders_forward.port_culture', [$port , $culture_translit]) : route('traders_forward.port',  $port)}}">Форварды</a>
                        </li>
                    @endif

                    @if($type_traders != 0)
                        <li>
                            <a href="{{$culture_translit ? route('traders.port_culture',  [$port , 'kukuruza']) : route('traders.port',  $port)}}">Закупки</a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</div>
