<div class="ports-tabs table-tabs mt-3">
    @if($statusCurtypePort == 'UAH')
        <a id="port-uah" class="active region-port-table">Закупки UAH</a>
    @endif

    @if($statusCurtypePort == 'USD')
            <a id="port-usd" class="active region-port-table">Закупки USD</a>
    @endif

    @if($statusCurtypePort == 'UAH_USD')
       <a id="port-uah" class="active region-port-table">Закупки UAH</a>
       <a id="port-usd" class="region-port-table">Закупки USD</a>
    @endif
</div>
<div class="content-block prices-block mb-5" style="position: relative" currency="0">
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
                <tr>
                    <td class="py-1">
                        <span class="place-title">{{isset($place['port']['lang']) ? $place['port']['lang']['portname'] : ''}}</span>
                        <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                    </td>
                    @foreach($port_culture as $index => $data_port)
                        @if(isset($port_price[$place['id']]) && isset($port_price[$place['id']][$data_port['cult_id']]))
                            @if(isset($port_price[$place['id']][$data_port['cult_id']][0]))
                                <td class="port-UAH">
                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                        <span class="font-weight-600">{{round($port_price[$place['id']][$data_port['cult_id']][0][0]['costval'], 1)}}</span> &nbsp;
                                    </div>
                                </td>
                            @endif
                            @if(isset($port_price[$place['id']][$data_port['cult_id']][1]))
                                @if(isset($port_price[$place['id']][$data_port['cult_id']][1][0]['costval']))
                                <td class="port-USD" style="{{$statusCurtypePort == 'USD' ? '' : 'display: none'}}">
                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                        <span class="font-weight-600">{{round($port_price[$place['id']][$data_port['cult_id']][1][0]['costval'], 1)}}</span> &nbsp;
                                    </div>
                                </td>
                                @else
                                    <td></td>
                                @endif

                            @endif
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
@if(!empty($port_place))
    <div class="tableSecond">
        <div class="tableScroll blue">
            <table class="sortTable price-table ports-table" style="left: -240px; width: calc(100% + 240px)">
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
                    <tr>
                        <td class="py-1">
                            <span class="place-title">{{isset($place['port']['lang']) ? $place['port']['lang']['portname'] : ''}}</span>
                            <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                        </td>
                        @foreach($port_culture as $index => $data_port)
                            @if(isset($port_price[$place['id']]) && isset($port_price[$place['id']][$data_port['cult_id']]))
                                @if(isset($port_price[$place['id']][$data_port['cult_id']][0]))
                                    <td class="port-UAH">
                                        <div class="d-flex align-items-center justify-content-center lh-1">
                                            <span class="font-weight-600">{{round($port_price[$place['id']][$data_port['cult_id']][0][0]['costval'], 1)}}</span> &nbsp;
                                        </div>
                                    </td>
                                @endif
                                @if(isset($port_price[$place['id']][$data_port['cult_id']][1]))
                                    <td class="port-USD" style="{{$statusCurtypePort == 'USD' ? '' : 'display: none'}}">
                                        <div class="d-flex align-items-center justify-content-center lh-1">
                                            <span class="font-weight-600">{{round($port_price[$place['id']][$data_port['cult_id']][1][0]['costval'], 1)}}</span> &nbsp;
                                        </div>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            @else
                                <td></td>
                            @endif
                        @endforeach
                    </tr>
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
                <tr>
                    <td class="py-1">
                        <span class="place-title">{{isset($place['port']['lang']) ? $place['port']['lang']['portname'] : ''}}</span>
                        <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                    </td>
                    @foreach($port_culture as $index => $data_port)
                        @if(isset($port_price[$place['id']]) && isset($port_price[$place['id']][$data_port['cult_id']]))
                            @if(isset($port_price[$place['id']][$data_port['cult_id']][0]))
                                <td class="port-UAH">
                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                        <span class="font-weight-600">{{round($port_price[$place['id']][$data_port['cult_id']][0][0]['costval'], 1)}}</span> &nbsp;
                                    </div>
                                </td>
                            @endif
                            @if(isset($port_price[$place['id']][$data_port['cult_id']][1]))
                                <td class="port-USD" style="{{$statusCurtypePort == 'USD' ? '' : 'display: none'}}">
                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                        <span class="font-weight-600">{{round($port_price[$place['id']][$data_port['cult_id']][1][0]['costval'], 1)}}</span> &nbsp;
                                    </div>
                                </td>
                            @else
                                <td></td>
                            @endif
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
</div>
<style>
    .region-port-table{
        cursor: pointer;
        color: white !important;
    }
</style>
