<div class="ports-tabs table-tabs mt-3">
    @if($statusCurtypePort == 'UAH')
        <a href="#" currency="0" id="port-uah" class="active region-port-table">Закупки UAH</a>
    @endif

    @if($statusCurtypePort == 'USD')
        <a href="#" currency="1" id="port-usd" class="active region-port-table">Закупки USD</a>
    @endif

    @if($statusCurtypePort == 'UAH_USD')
        <a href="#" currency="0" id="port-uah" class="active region-port-table">Закупки UAH</a>
        <a href="#" currency="1" id="port-usd" class="region-port-table">Закупки USD</a>
    @endif
</div>

<div class="content-block prices-block  mb-5" style="position: relative" currency="0">
    <div class="port-UAH" style="{{($statusCurtypePort == "UAH" || $statusCurtypePort == "UAH_USD") ? '' : 'display: none'}}">
        <div class="price-table-wrap ports scroll-x d-none d-sm-block">
            @if(!empty($port_place))
                <div class="tableFirst" style="position: relative; z-index: 1; overflow: hidden;">
                    <table class="sortTable price-table ports-table">
                        <thead>
                        <tr>
                            <th>Порты / Переходы</th>
                            @foreach($port_culture as $index => $data_port)
                                <th>{!! $data_port['culture'] !!}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($port_place as $index => $place)
                            @if(!empty($place->traders_ports))
                                <tr>
                                    <td class="py-1">
                                        <span class="place-title">{{isset($place->traders_ports[0]['lang']) ? $place->traders_ports[0]['lang']['portname'] : ''}}</span>
                                        <span class="place-comment">{!! strip_tags($place->place) !!}</span>
                                    </td>
                                    @if(isset($port_price[$place['id']]) && !empty($port_price[$place['id']][0]))
                                        @foreach($port_culture as $index_port_uah => $data_port)
                                            @if(isset($port_price[$place['id']][0][$data_port['cult_id']]))
                                                <td class="port-UAH">
                                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                                        <span class="font-weight-600 replace_numbers_js">
                                                            {{round($port_price[$place['id']][0][$data_port['cult_id']][0]['costval'], 1)}}
                                                        </span> &nbsp;
                                                        @if($port_price[$place['id']][0][$data_port['cult_id']][0]['change_price'] != 0 && \Carbon\Carbon::now()->diffInDays($port_price[$place['id']][0][$data_port['cult_id']][0]['change_date']) <= $max_days)
                                                            <img src="/app/assets/img/price-{{$port_price[$place['id']][0][$data_port['cult_id']][0]['change_price_type']}}.svg">&nbsp;
                                                            <span class="replace_numbers_js price-{{$port_price[$place['id']][0][$data_port['cult_id']][0]['change_price_type']}}">{{$port_price[$place['id']][0][$data_port['cult_id']][0]['change_price']}}</span>
                                                        @endif

                                                    </div>
                                                    <span class="d-block lh-1 pb-1 extra-small text-center">{{$port_price[$place['id']][0][$data_port['cult_id']][0]['comment']}}</span>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endforeach
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if(!empty($port_place))
                <div class="tableSecond">
                    <div class="tableScroll blue">
                        <table class="sortTable price-table ports-table"
                               style="left: -240px; width: calc(100% + 240px)">
                            <thead>
                            <tr>
                                <th>Порты / Переходы</th>
                                @foreach($port_culture as $index => $data_port)
                                    <th>{!! $data_port['culture'] !!}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($port_place as $index => $place)
                                @if(!empty($place->traders_ports))
                                    <tr>
                                        <td class="py-1">
                                        <span
                                            class="place-title">{{isset($place->traders_ports[0]['lang']) ? $place->traders_ports[0]['lang']['portname'] : ''}}</span>
                                            <span class="place-comment">{!! strip_tags($place->place) !!}</span>
                                        </td>
                                        @if(isset($port_price[$place['id']]) && !empty($port_price[$place['id']][0]))
                                            @foreach($port_culture as $index_port_uah => $data_port)
                                                @if(isset($port_price[$place['id']][0][$data_port['cult_id']]))
                                                    <td class="port-UAH">
                                                        <div class="d-flex align-items-center justify-content-center lh-1">
                                                        <span class="font-weight-600 replace_numbers_js ">
                                                            {{round($port_price[$place['id']][0][$data_port['cult_id']][0]['costval'], 1)}}
                                                        </span> &nbsp;
                                                            @if($port_price[$place['id']][0][$data_port['cult_id']][0]['change_price'] != 0 && \Carbon\Carbon::now()->diffInDays($port_price[$place['id']][0][$data_port['cult_id']][0]['change_date']) <= $max_days)
                                                                <img src="/app/assets/img/price-{{$port_price[$place['id']][0][$data_port['cult_id']][0]['change_price_type']}}.svg">&nbsp;
                                                                <span class="replace_numbers_js price-{{$port_price[$place['id']][0][$data_port['cult_id']][0]['change_price_type']}}">{{$port_price[$place['id']][0][$data_port['cult_id']][0]['change_price']}}</span>
                                                            @endif

                                                        </div>
                                                        <span
                                                            class="d-block lh-1 pb-1 extra-small text-center">{{$port_price[$place['id']][0][$data_port['cult_id']][0]['comment']}}</span>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        @if(!empty($port_place))
            <div class="d-sm-none price-table-wrap ports scroll-x">
                <table class="sortTable price-table ports-table">
                    <thead>
                    <tr>
                        <th>Порты / Переходы</th>
                        @foreach($port_culture as $index => $data_port)
                            <th>{!! $data_port['culture'] !!}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($port_place as $index => $place)
                        @if(!empty($place->traders_ports))
                            <tr>
                                <td class="py-1">
                                        <span
                                            class="place-title">{{isset($place->traders_ports[0]['lang']) ? $place->traders_ports[0]['lang']['portname'] : ''}}</span>
                                    <span class="place-comment">{!! strip_tags($place->place) !!}</span>
                                </td>
                                @if(isset($port_price[$place['id']]) && !empty($port_price[$place['id']][0]))
                                    @foreach($port_culture as $index_port_uah => $data_port)
                                        @if(isset($port_price[$place['id']][0][$data_port['cult_id']]))
                                            <td class="port-UAH">
                                                <div class="d-flex align-items-center justify-content-center lh-1">
                                                        <span class="font-weight-600 replace_numbers_js">
                                                            {{round($port_price[$place['id']][0][$data_port['cult_id']][0]['costval'], 1)}}
                                                        </span> &nbsp;
                                                    @if($port_price[$place['id']][0][$data_port['cult_id']][0]['change_price'] != 0 && \Carbon\Carbon::now()->diffInDays($port_price[$place['id']][0][$data_port['cult_id']][0]['change_date']) <= $max_days)
                                                        <img src="/app/assets/img/price-{{$port_price[$place['id']][0][$data_port['cult_id']][0]['change_price_type']}}.svg">&nbsp;
                                                        <span class="replace_numbers_js  price-{{$port_price[$place['id']][0][$data_port['cult_id']][0]['change_price_type']}}">{{$port_price[$place['id']][0][$data_port['cult_id']][0]['change_price']}}</span>
                                                    @endif

                                                </div>
                                                <span
                                                    class="d-block lh-1 pb-1 extra-small text-center">{{$port_price[$place['id']][0][$data_port['cult_id']][0]['comment']}}</span>
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                    @endforeach
                                @endif
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="port-USD" style="{{($statusCurtypePort == "UAH" || $statusCurtypePort == "UAH_USD") ? 'display: none' : ''}}">
        <div class="price-table-wrap ports scroll-x d-none d-sm-block">
            @if(!empty($port_place))
                <div class="tableFirst" style="position: relative; z-index: 1; overflow: hidden;">
                    <table class="sortTable price-table ports-table">
                        <thead>
                        <tr>
                            <th>Порты / Переходы</th>
                            @foreach($port_culture as $index => $data_port)
                                <th>{!! $data_port['culture'] !!}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($port_place as $index => $place)
                            @if(!empty($place->traders_ports))
                                <tr>
                                    <td class="py-1">
                                        <span
                                            class="place-title">{{isset($place->traders_ports[0]['lang']) ? $place->traders_ports[0]['lang']['portname'] : ''}}</span>
                                        <span class="place-comment">{!! strip_tags($place->place) !!}</span>
                                    </td>
                                    @if(isset($port_price[$place['id']]) && !empty($port_price[$place['id']][1]))
                                        @foreach($port_culture as $index_port_usd => $data_port)
                                            @if(isset($port_price[$place['id']][1][$data_port['cult_id']]))
                                                <td class="port-USD">
                                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                                        <span class="font-weight-600 replace_numbers_js ">
                                                            {{round($port_price[$place['id']][1][$data_port['cult_id']][0]['costval'], 1)}}
                                                        </span> &nbsp;
                                                        @if($port_price[$place['id']][1][$data_port['cult_id']][0]['change_price'] != 0 && \Carbon\Carbon::now()->diffInDays($port_price[$place['id']][1][$data_port['cult_id']][0]['change_date']) <= $max_days)
                                                            <img src="/app/assets/img/price-{{$port_price[$place['id']][1][$data_port['cult_id']][0]['change_price_type']}}.svg">&nbsp;
                                                            <span class="replace_numbers_js price-{{$port_price[$place['id']][1][$data_port['cult_id']][0]['change_price_type']}}">{{$port_price[$place['id']][1][$data_port['cult_id']][0]['change_price']}}</span>
                                                        @endif
                                                    </div>
                                                    <span class="d-block lh-1 pb-1 extra-small text-center">{{$port_price[$place['id']][1][$data_port['cult_id']][0]['comment']}}</span>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endforeach
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if(!empty($port_place))
                <div class="tableSecond">
                    <div class="tableScroll blue">
                        <table class="sortTable price-table ports-table"
                               style="left: -240px; width: calc(100% + 240px)">
                            <thead>
                            <tr>
                                <th>Порты / Переходы</th>
                                @foreach($port_culture as $index => $data_port)
                                    <th>{!! $data_port['culture'] !!}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($port_place as $index => $place)
                                @if(!empty($place->traders_ports))
                                    <tr>
                                        <td class="py-1">
                                        <span
                                            class="place-title">{{isset($place->traders_ports[0]['lang']) ? $place->traders_ports[0]['lang']['portname'] : ''}}</span>
                                            <span class="place-comment">{!! strip_tags($place->place) !!}</span>
                                        </td>
                                        @if(isset($port_price[$place['id']]) && !empty($port_price[$place['id']][1]))
                                            @foreach($port_culture as $index_port_usd => $data_port)
                                                @if(isset($port_price[$place['id']][1][$data_port['cult_id']]))
                                                    <td class="port-USD">
                                                        <div class="d-flex align-items-center justify-content-center lh-1">
                                                        <span class="font-weight-600 replace_numbers_js ">
                                                            {{round($port_price[$place['id']][1][$data_port['cult_id']][0]['costval'], 1)}}
                                                        </span> &nbsp;
                                                            @if($port_price[$place['id']][1][$data_port['cult_id']][0]['change_price'] != 0 && \Carbon\Carbon::now()->diffInDays($port_price[$place['id']][1][$data_port['cult_id']][0]['change_date']) <= $max_days)
                                                                <img src="/app/assets/img/price-{{$port_price[$place['id']][1][$data_port['cult_id']][0]['change_price_type']}}.svg">&nbsp;
                                                                <span class="replace_numbers_js  price-{{$port_price[$place['id']][1][$data_port['cult_id']][0]['change_price_type']}}">{{$port_price[$place['id']][1][$data_port['cult_id']][0]['change_price']}}</span>
                                                            @endif
                                                        </div>
                                                        <span
                                                            class="d-block lh-1 pb-1 extra-small text-center">{{$port_price[$place['id']][1][$data_port['cult_id']][0]['comment']}}</span>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        @if(!empty($port_place))
            <div class="d-sm-none price-table-wrap ports scroll-x">
                <table class="sortTable price-table ports-table">
                    <thead>
                    <tr>
                        <th>Порты / Переходы</th>
                        @foreach($port_culture as $index => $data_port)
                            <th>{!! $data_port['culture'] !!}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($port_place as $index => $place)
                        @if(!empty($place->traders_ports))
                            <tr>
                                <td class="py-1">
                                        <span
                                            class="place-title">{{isset($place->traders_ports[0]['lang']) ? $place->traders_ports[0]['lang']['portname'] : ''}}</span>
                                    <span class="place-comment">{!! strip_tags($place->place) !!}</span>
                                </td>
                                @if(isset($port_price[$place['id']]) && !empty($port_price[$place['id']][1]))
                                    @foreach($port_culture as $index_port_usd => $data_port)
                                        @if(isset($port_price[$place['id']][1][$data_port['cult_id']]))
                                            <td class="port-USD">
                                                <div class="d-flex align-items-center justify-content-center lh-1">
                                                        <span class="font-weight-600 replace_numbers_js ">
                                                            {{round($port_price[$place['id']][1][$data_port['cult_id']][0]['costval'], 1)}}
                                                        </span> &nbsp;
                                                    @if($port_price[$place['id']][1][$data_port['cult_id']][0]['change_price'] != 0 && \Carbon\Carbon::now()->diffInDays($port_price[$place['id']][1][$data_port['cult_id']][0]['change_date']) <= $max_days)
                                                        <img src="/app/assets/img/price-{{$port_price[$place['id']][1][$data_port['cult_id']][0]['change_price_type']}}.svg">&nbsp;
                                                        <span class="replace_numbers_js  price-{{$port_price[$place['id']][1][$data_port['cult_id']][0]['change_price_type']}}">{{$port_price[$place['id']][1][$data_port['cult_id']][0]['change_price']}}</span>
                                                    @endif
                                                </div>
                                                <span class="d-block lh-1 pb-1 extra-small text-center">{{$port_price[$place['id']][1][$data_port['cult_id']][0]['comment']}}</span>
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                    @endforeach
                                @endif
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
<style>
    .region-port-table {
        cursor: pointer;
        color: white !important;
    }
</style>
