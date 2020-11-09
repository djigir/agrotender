<div class="ports-tabs table-tabs mt-3">
    @if(!empty($port_price['UAH']))
        <a id="port-uah" class="active region-port-table">Закупки UAH</a>
    @endif
    @if(!empty($port_price['USD']) && empty($port_price['UAH']))
        <a id="port-usd" class="active region-port-table">Закупки USD</a>
    @elseif(!empty($port_price['USD']) )
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
                    <th>{!! $data_port['name'] !!}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($port_place as $index => $place)
                <tr>
                    <td class="py-1">
                        <span class="place-title">{{$place['portname']}}</span>
                        <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                    </td>
                    @if(isset($port_price['UAH'][$place['place_id']]))
                        @foreach($port_price['UAH'][$place['place_id']] as $index_price => $price)
                            <td class="port-UAH">
                                @if(isset($price['costval']))
                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                        <span class="font-weight-600">{{round($price['costval'], 1)}}</span> &nbsp;
                                    </div>
                                    @if($price['comment'] != '' and !$price['comment'])
                                        <span class="d-block lh-1 pb-1 extra-small">{{$price['comment']}}</span>
                                    @endif
                                @endif
                            </td>
                        @endforeach
                    @endif
                    @if(isset($port_price['USD'][$place['place_id']]))
                        @foreach($port_price['USD'][$place['place_id']] as $index_price => $price)
                            <td class="port-USD" style="{{!empty($port_price['UAH']) ? 'display: none' : ''}}">
                                @if(isset($price['costval']))
                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                        <span class="font-weight-600">{{round($price['costval'], 1)}}</span> &nbsp;
                                    </div>
                                    @if($price['comment'] != '' and !$price['comment'])
                                        <span class="d-block lh-1 pb-1 extra-small">{{$price['comment']}}</span>
                                    @endif
                                @endif
                            </td>
                        @endforeach
                    @endif
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
                        <th>{!! $data_port['name'] !!}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($port_place as $index => $place)
                    <tr>
                        <td class="py-1">
                            <span class="place-title">{{$place['portname']}}</span>
                            <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                        </td>
                        @if(isset($port_price['UAH'][$place['place_id']]))
                            @foreach($port_price['UAH'][$place['place_id']] as $index_price => $price)
                                <td class="port-UAH">
                                    @if(isset($price['costval']))
                                        <div class="d-flex align-items-center justify-content-center lh-1">
                                            <span class="font-weight-600">{{round($price['costval'], 1)}}</span> &nbsp;
                                        </div>
                                        @if($price['comment'] != '' and !$price['comment'])
                                            <span class="d-block lh-1 pb-1 extra-small">{{$price['comment']}}</span>
                                        @endif

                                    @endif
                                </td>
                            @endforeach
                        @endif
                        @if(isset($port_price['USD'][$place['place_id']]))
                            @foreach($port_price['USD'][$place['place_id']] as $index_price => $price)
                                <td class="port-USD" style="{{!empty($port_price['UAH']) ? 'display: none' : ''}}">
                                    @if(isset($price['costval']))
                                        <div class="d-flex align-items-center justify-content-center lh-1">
                                            <span class="font-weight-600">{{round($price['costval'], 1)}}</span> &nbsp;
                                        </div>
                                        @if($price['comment'] != '' and !$price['comment'])
                                            <span class="d-block lh-1 pb-1 extra-small">{{$price['comment']}}</span>
                                        @endif
                                    @endif
                                </td>
                            @endforeach
                        @endif
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
                    <th>{!! $data_port['name'] !!}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($port_place as $index => $place)
                <tr>
                    <td class="py-1">
                        <span class="place-title">{{$place['portname']}}</span>
                        <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                    </td>
                    @if(isset($port_price['UAH'][$place['place_id']]))
                        @foreach($port_price['UAH'][$place['place_id']] as $index_price => $price)
                            <td class="port-UAH">
                                @if(isset($price['costval']))
                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                        <span class="font-weight-600">{{round($price['costval'], 1)}}</span> &nbsp;
                                    </div>
                                    @if($price['comment'] != '' and !$price['comment'])
                                        <span class="d-block lh-1 pb-1 extra-small">{{$price['comment']}}</span>
                                    @endif

                                @endif
                            </td>
                        @endforeach
                    @endif
                    @if(isset($port_price['USD'][$place['place_id']]))
                        @foreach($port_price['USD'][$place['place_id']] as $index_price => $price)
                            <td class="port-USD" style="{{!empty($port_price['UAH']) ? 'display: none' : ''}}">
                                @if(isset($price['costval']))
                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                        <span class="font-weight-600">{{round($price['costval'], 1)}}</span> &nbsp;
                                    @if($price['comment'] != '' and !$price['comment'])
                                        <span class="d-block lh-1 pb-1 extra-small">{{$price['comment']}}</span>
                                    @endif
                                @endif
                            </td>
                        @endforeach
                    @endif
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
