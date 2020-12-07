<div class="regions-tabs table-tabs mt-5">
    @if($statusCurtypeRegion == 'UAH')
        <a  id="region-uah" class="active region-port-table">Закупки UAH</a>
    @endif

    @if($statusCurtypeRegion == 'USD')
        <a  id="region-usd" class="active region-port-table">Закупки USD</a>
    @endif

    @if($statusCurtypeRegion == 'UAH_USD')
        <a  id="region-uah" class="active region-port-table">Закупки UAH</a>
        <a  id="region-usd" class="region-port-table">Закупки USD</a>
    @endif
</div>

<div class="region-UAH" style="{{($statusCurtypeRegion == "UAH" || $statusCurtypeRegion == "UAH_USD") ? '' : 'display: none'}}">
    <div class="content-block prices-block  d-none d-sm-block" style="position: relative ">
        <div class="tableFirst" style="position: relative; z-index: 1;overflow: hidden;">
            <table class="sortTable price-table regions-table">
                <thead>
                <tr>
                    <th>Регионы / Элеваторы</th>
                    @foreach($region_culture as $index => $data_region)
                        <th>{!! $data_region['culture'] !!}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($region_place as $index => $place)
                    @if(!empty($place->regions))
                        <tr>
                            <td class="py-1">
                                <span class="place-title">{{$place['regions'][0]['name']}} обл.</span>
                                <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                            </td>
                            @foreach($region_culture as $index => $data_region)
                                @if(isset($region_price[$place['id']][0][$data_region['cult_id']]))
                                    <td class="region-UAH">
                                        <div class="d-flex align-items-center justify-content-center lh-1">
                                            <span class="font-weight-600 replace_numbers_js">{{round($region_price[$place['id']][0][$data_region['cult_id']][0]['costval'], 1)}}</span> &nbsp;
                                            @if($region_price[$place['id']][0][$data_region['cult_id']][0]['change_price'] != 0)
                                                <img src="/app/assets/img/price-{{$region_price[$place['id']][0][$data_region['cult_id']][0]['change_price_type']}}.svg">&nbsp;
                                                <span class="replace_numbers_js price-{{$region_price[$place['id']][0][$data_region['cult_id']][0]['change_price_type']}}">{{$region_price[$place['id']][0][$data_region['cult_id']][0]['change_price']}}</span>
                                            @endif
                                        </div>
                                        <span class="d-block lh-1 pb-1 extra-small">{{$region_price[$place['id']][0][$data_region['cult_id']][0]['comment']}}</span>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            @endforeach
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="tableSecond">
            <div class="tableScroll orange">
                <table class="sortTable orange price-table regions-table" style="left: -240px; width: calc(100% + 240px)">
                    <thead>
                    <tr>
                        <th>Регионы / Элеваторы</th>
                        @foreach($region_culture as $index => $data_region)
                            <th>{!! $data_region['culture'] !!}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($region_place as $index => $place)
                        @if(!empty($place->regions))
                            <tr>
                                <td class="py-1">
                                    <span class="place-title">{{$place['regions'][0]['name']}} обл.</span>
                                    <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                                </td>
                                @foreach($region_culture as $index => $data_region)
                                    @if(isset($region_price[$place['id']][0][$data_region['cult_id']]))
                                        <td class="region-UAH">
                                            <div class="d-flex align-items-center justify-content-center lh-1">
                                                <span class="font-weight-600 replace_numbers_js">{{round($region_price[$place['id']][0][$data_region['cult_id']][0]['costval'], 1)}}</span> &nbsp;
                                                @if($region_price[$place['id']][0][$data_region['cult_id']][0]['change_price'] != 0)
                                                    <img src="/app/assets/img/price-{{$region_price[$place['id']][0][$data_region['cult_id']][0]['change_price_type']}}.svg">&nbsp;
                                                    <span class="replace_numbers_js price-{{$region_price[$place['id']][0][$data_region['cult_id']][0]['change_price_type']}}">{{$region_price[$place['id']][0][$data_region['cult_id']][0]['change_price']}}</span>
                                                @endif
                                            </div>
                                            <span class="d-block lh-1 pb-1 extra-small text-center">{{$region_price[$place['id']][0][$data_region['cult_id']][0]['comment']}}</span>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <div class="price-table-wrap ports scroll-x  d-sm-none">
            <div class="content-block prices-block" style="position: relative">
                <table class="sortTable price-table regions-table">
                    <thead>
                    <tr>
                        <th>Регионы / Элеваторы</th>
                        @foreach($region_culture as $index => $data_region)
                            <th>{!! $data_region['culture'] !!}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($region_place as $index => $place)
                        @if(!empty($place->regions))
                            <tr>
                                <td class="py-1">
                                    <span class="place-title">{{$place['regions'][0]['name']}} обл.</span>
                                    <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                                </td>
                                @foreach($region_culture as $index => $data_region)
                                    @if(isset($region_price[$place['id']][0][$data_region['cult_id']]))
                                        <td class="region-UAH">
                                            <div class="d-flex align-items-center justify-content-center lh-1">
                                                <span class="font-weight-600 replace_numbers_js">{{round($region_price[$place['id']][0][$data_region['cult_id']][0]['costval'], 1)}}</span> &nbsp;
                                                @if($region_price[$place['id']][0][$data_region['cult_id']][0]['change_price'] != 0)
                                                    <img src="/app/assets/img/price-{{$region_price[$place['id']][0][$data_region['cult_id']][0]['change_price_type']}}.svg">&nbsp;
                                                    <span class="replace_numbers_js price-{{$region_price[$place['id']][0][$data_region['cult_id']][0]['change_price_type']}}">{{$region_price[$place['id']][0][$data_region['cult_id']][0]['change_price']}}</span>
                                                @endif
                                            </div>
                                            <span class="d-block lh-1 pb-1 extra-small text-center">{{$region_price[$place['id']][0][$data_region['cult_id']][0]['comment']}}</span>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>


<div class="region-USD" style="{{($statusCurtypeRegion == "UAH" || $statusCurtypeRegion == "UAH_USD") ? 'display: none' : ''}}">
    <div class="content-block prices-block  d-none d-sm-block" style="position: relative ">
        <div class="tableFirst" style="position: relative; z-index: 1;overflow: hidden;">
            <table class="sortTable price-table regions-table">
                <thead>
                <tr>
                    <th>Регионы / Элеваторы</th>
                    @foreach($region_culture as $index => $data_region)
                        <th>{!! $data_region['culture'] !!}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($region_place as $index => $place)
                    @if(!empty($place->regions))
                        <tr>
                            <td class="py-1">
                                <span class="place-title">{{$place['regions'][0]['name']}} обл.</span>
                                <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                            </td>
                            @foreach($region_culture as $index => $data_region)
                                @if(isset($region_price[$place['id']][1][$data_region['cult_id']][0]))
                                    <td class="region-USD">
                                        <div class="d-flex align-items-center justify-content-center lh-1">
                                            <span class="font-weight-600 replace_numbers_js">{{round($region_price[$place['id']][1][$data_region['cult_id']][0]['costval'], 1)}}</span> &nbsp;
                                            @if($region_price[$place['id']][1][$data_region['cult_id']][0]['change_price'] != 0)
                                                <img src="/app/assets/img/price-{{$region_price[$place['id']][1][$data_region['cult_id']][0]['change_price_type']}}.svg">&nbsp;
                                                <span class="replace_numbers_js price-{{$region_price[$place['id']][1][$data_region['cult_id']][0]['change_price_type']}}">{{$region_price[$place['id']][1][$data_region['cult_id']][0]['change_price']}}</span>
                                            @endif
                                        </div>
                                        <span class="d-block lh-1 pb-1 extra-small text-center">{{$region_price[$place['id']][1][$data_region['cult_id']][0]['comment']}}</span>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            @endforeach
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="tableSecond">
            <div class="tableScroll orange">
                <table class="sortTable orange price-table regions-table" style="left: -240px; width: calc(100% + 240px)">
                    <thead>
                    <tr>
                        <th>Регионы / Элеваторы</th>
                        @foreach($region_culture as $index => $data_region)
                            <th>{!! $data_region['culture'] !!}</th>
                        @endforeach

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($region_place as $index => $place)
                        @if(!empty($place->regions))
                            <tr>
                                <td class="py-1">
                                    <span class="place-title">{{$place['regions'][0]['name']}} обл.</span>
                                    <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                                </td>
                                @foreach($region_culture as $index => $data_region)
                                    @if(isset($region_price[$place['id']][1][$data_region['cult_id']][0]))
                                        <td class="region-USD">
                                            <div class="d-flex align-items-center justify-content-center lh-1">
                                                <span class="font-weight-600 replace_numbers_js">{{round($region_price[$place['id']][1][$data_region['cult_id']][0]['costval'], 1)}}</span> &nbsp;
                                                @if($region_price[$place['id']][1][$data_region['cult_id']][0]['change_price'] != 0)
                                                    <img src="/app/assets/img/price-{{$region_price[$place['id']][1][$data_region['cult_id']][0]['change_price_type']}}.svg">&nbsp;
                                                    <span class="replace_numbers_js price-{{$region_price[$place['id']][1][$data_region['cult_id']][0]['change_price_type']}}">{{$region_price[$place['id']][1][$data_region['cult_id']][0]['change_price']}}</span>
                                                @endif
                                            </div>
                                            <span class="d-block lh-1 pb-1 extra-small text-center">{{$region_price[$place['id']][1][$data_region['cult_id']][0]['comment']}}</span>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endif
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
                            <th>{!! $data_region['culture'] !!}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($region_place as $index => $place)
                        @if(!empty($place->regions))
                            <tr>
                                <td class="py-1">
                                    <span class="place-title">{{$place['regions'][0]['name']}} обл.</span>
                                    <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                                </td>
                                @foreach($region_culture as $index => $data_region)
                                    @if(isset($region_price[$place['id']][1][$data_region['cult_id']][0]))
                                        <td class="region-USD">
                                            <div class="d-flex align-items-center justify-content-center lh-1">
                                                <span class="font-weight-600 replace_numbers_js">{{round($region_price[$place['id']][1][$data_region['cult_id']][0]['costval'], 1)}}</span> &nbsp;
                                                @if($region_price[$place['id']][1][$data_region['cult_id']][0]['change_price'] != 0)
                                                    <img src="/app/assets/img/price-{{$region_price[$place['id']][1][$data_region['cult_id']][0]['change_price_type']}}.svg">&nbsp;
                                                    <span class="replace_numbers_js price-{{$region_price[$place['id']][1][$data_region['cult_id']][0]['change_price_type']}}">{{$region_price[$place['id']][1][$data_region['cult_id']][0]['change_price']}}</span>
                                                @endif
                                            </div>
                                            <span class="d-block lh-1 pb-1 extra-small text-center">{{$region_price[$place['id']][1][$data_region['cult_id']][0]['comment']}}</span>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<style>
    .region-port-table{
        cursor: pointer;
        color: white !important;
    }

</style>
