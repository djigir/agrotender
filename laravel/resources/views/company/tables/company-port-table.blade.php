<div class="content-block prices-block mb-5" style="position: relative" currency="0">
<div class="price-table-wrap ports scroll-x d-none d-sm-block">
@if(!empty($port_place))
    <div class="tableFirst" style="position: relative; z-index: 1; overflow: hidden;">
        <table class="sortTable price-table ports-table">
            <thead>
            <tr>
                <th>Порты / Переходы</th>
                @foreach($port_culture as $index => $data_port)
                    <th>{{$data_port['name']}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($port_place as $index => $place)
                <tr>
                    <td class="py-1">
                        <span class="place-title">{{$place['portname']}}</span>
                        <span class="place-comment">{{$place['place']}}</span>
                    </td>
                    @if(isset($port_price['UAH'][$place['place_id']]))
                        @foreach($port_price['UAH'][$place['place_id']] as $index_price => $price)
                            <td class="currency">
                                @if(isset($price['costval']))
                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                        <span class="font-weight-600">{{$price['costval']}}</span> &nbsp;
                                        {{--                                                 <img src="/app/assets/img/price-up.svg">&nbsp;--}}
                                        {{--                                                  <span class="price-up">200</span>--}}
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
                        <th>{{$data_port['name']}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($port_place as $index => $place)
                    <tr>
                        <td class="py-1">
                            <span class="place-title">{{$place['portname']}}</span>
                            <span class="place-comment">{{$place['place']}}</span>
                        </td>
                        @if(isset($port_price['UAH'][$place['place_id']]))
                            @foreach($port_price['UAH'][$place['place_id']] as $index_price => $price)
                                <td class="currency">
                                    @if(isset($price['costval']))
                                        <div class="d-flex align-items-center justify-content-center lh-1">
                                            <span class="font-weight-600">{{$price['costval']}}</span> &nbsp;
                                            {{--                                                            <img src="/app/assets/img/price-up.svg">&nbsp;--}}
                                            {{--                                                            <span class="price-up">200</span>--}}
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
                    <th>{{$data_port['name']}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($port_place as $index => $place)
                <tr>
                    <td class="py-1">
                        <span class="place-title">{{$place['portname']}}</span>
                        <span class="place-comment">{{$place['place']}}</span>
                    </td>
                    @if(isset($port_price['UAH'][$place['place_id']]))
                        @foreach($port_price['UAH'][$place['place_id']] as $index_price => $price)
                            <td class="currency">
                                @if(isset($price['costval']))
                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                        <span class="font-weight-600">{{$price['costval']}}</span> &nbsp;
                                        {{--<img src="/app/assets/img/price-up.svg">&nbsp;--}}
                                        {{-- <span class="price-up">200</span>--}}
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
</div>
