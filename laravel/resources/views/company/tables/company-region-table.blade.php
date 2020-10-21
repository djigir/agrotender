@if(!empty($region_place))
    <div class="regions-tabs table-tabs mt-5">
        <a href="#" currency="0" class="active">Закупки UAH</a>
    </div>
    <div class="content-block prices-block  d-none d-sm-block" style="position: relative ">
        <div class="tableFirst" style="position: relative; z-index: 1;overflow: hidden;">
            <table class="sortTable price-table regions-table">
                <thead>
                <tr>
                    <th>Регионы / Элеваторы</th>
                    @foreach($region_culture as $index => $data_region)
                        <th>{{$data_region['name']}}</th>
                    @endforeach

                </tr>
                </thead>
                <tbody>
                @foreach($region_place as $index => $place)

                    <tr>
                        <td class="py-1">
                            <span class="place-title">{{$place['region']}}</span>
                            <span class="place-comment">{{$place['place']}}</span>
                        </td>
                        @if(isset($region_price['UAH'][$place['place_id']]))
                            @foreach($region_price['UAH'][$place['place_id']] as $index_price => $price)
                                <td class="currency">
                                    @if(isset($price['costval']))
                                        <div class="d-flex align-items-center justify-content-center lh-1">
                                            <span class="font-weight-600">{{$price['costval']}}</span> &nbsp;
                                            {{--<img src="/app/assets/img/price-up.svg">&nbsp;--}}
                                            {{--<span class="price-up">200</span>--}}
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

        <div class="tableSecond ">
            <div class="tableScroll orange">
                <table class="sortTable orange price-table regions-table" style="left: -240px; width: calc(100% + 240px)">
                    <thead>
                    <tr>
                        <th>Регионы / Элеваторы</th>
                        @foreach($region_culture as $index => $data_region)
                            <th>{{$data_region['name']}}</th>
                        @endforeach

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($region_place as $index => $place)

                        <tr>
                            <td class="py-1">
                                <span class="place-title">{{$place['region']}}</span>
                                <span class="place-comment">{{$place['place']}}</span>
                            </td>
                            @if(isset($region_price['UAH'][$place['place_id']]))
                                @foreach($region_price['UAH'][$place['place_id']] as $index_price => $price)
                                    <td class="currency">
                                        @if(isset($price['costval']))
                                            <div class="d-flex align-items-center justify-content-center lh-1">
                                                <span class="font-weight-600">{{$price['costval']}}</span> &nbsp;
                                                {{--<img src="/app/assets/img/price-up.svg">&nbsp;--}}
                                                {{--<span class="price-up">200</span>--}}
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
    </div>
    @if(!empty($region_place))
        <div class="price-table-wrap ports scroll-x  d-sm-none">
            <div class="content-block prices-block" style="position: relative">
                <table class="sortTable price-table regions-table">
                    <thead>
                    <tr>
                        <th>Регионы / Элеваторы</th>
                        @foreach($region_culture as $index => $data_region)
                            <th>{{$data_region['name']}}</th>
                        @endforeach

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($region_place as $index => $place)
                        <tr>
                            <td class="py-1">
                                <span class="place-title">{{$place['region']}}</span>
                                <span class="place-comment">{{$place['place']}}</span>
                            </td>
                            @if(isset($region_price['UAH'][$place['place_id']]))
                                @foreach($region_price['UAH'][$place['place_id']] as $index_price => $price)
                                    <td class="currency">
                                        @if(isset($price['costval']))
                                            <div class="d-flex align-items-center justify-content-center lh-1">
                                                <span class="font-weight-600">{{$price['costval']}}</span> &nbsp;
                                                {{--<img src="/app/assets/img/price-up.svg">&nbsp;--}}
                                                {{--<span class="price-up">200</span>--}}
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
@endif
