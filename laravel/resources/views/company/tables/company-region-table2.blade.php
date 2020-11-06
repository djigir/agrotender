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
@if(!empty($region_place))
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
                    <tr>
                        <td class="py-1">
                            <span class="place-title">{{$place['region']['name']}} обл.</span>
                            <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                        </td>
                        @foreach($region_culture as $index => $data_region)
                            @if(isset($region_price[$place['id']]) && isset($region_price[$place['id']][$data_region['cult_id']]))
                                @if(isset($region_price[$place['id']][$data_region['cult_id']][0]))
                                    <td class="region-UAH">
                                        <div class="d-flex align-items-center justify-content-center lh-1">
                                            <span class="font-weight-600">{{round($region_price[$place['id']][$data_region['cult_id']][0][0]['costval'], 1)}}</span> &nbsp;
                                        </div>
                                    </td>
                                @endif
                                @if(isset($region_price[$place['id']][$data_region['cult_id']][1]))
                                    <td class="region-USD" style="{{($statusCurtypeRegion == "UAH" || $statusCurtypeRegion == "UAH_USD") ? 'display: none' : ''}}">
                                        <div class="d-flex align-items-center justify-content-center lh-1">
                                            <span class="font-weight-600">{{round($region_price[$place['id']][$data_region['cult_id']][1][0]['costval'], 1)}}</span> &nbsp;
                                        </div>
                                    </td>
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
                        <tr>
                            <td class="py-1">
                                <span class="place-title">{{$place['region']['name']}} обл.</span>
                                <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                            </td>
                            @foreach($region_culture as $index => $data_region)
                                @if(isset($region_price[$place['id']]) && isset($region_price[$place['id']][$data_region['cult_id']]))
                                    @if(isset($region_price[$place['id']][$data_region['cult_id']][0]))
                                        <td class="region-UAH">
                                            <div class="d-flex align-items-center justify-content-center lh-1">
                                                <span class="font-weight-600">{{round($region_price[$place['id']][$data_region['cult_id']][0][0]['costval'], 1)}}</span> &nbsp;
                                            </div>
                                        </td>
                                    @endif
                                    @if(isset($region_price[$place['id']][$data_region['cult_id']][1]))
                                        <td class="region-USD" style="{{($statusCurtypeRegion == "UAH" || $statusCurtypeRegion == "UAH_USD") ? 'display: none' : ''}}">
                                            <div class="d-flex align-items-center justify-content-center lh-1">
                                                <span class="font-weight-600">{{round($region_price[$place['id']][$data_region['cult_id']][1][0]['costval'], 1)}}</span> &nbsp;
                                            </div>
                                        </td>
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
                        <tr>
                            <td class="py-1">
                                <span class="place-title">{{$place['region']['name']}} обл.</span>
                                <span class="place-comment">{!! strip_tags($place['place']) !!}</span>
                            </td>
                            @foreach($region_culture as $index => $data_region)
                                @if(isset($region_price[$place['id']]) && isset($region_price[$place['id']][$data_region['cult_id']]))
                                    @if(isset($region_price[$place['id']][$data_region['cult_id']][0]))
                                        <td class="region-UAH">
                                            <div class="d-flex align-items-center justify-content-center lh-1">
                                                <span class="font-weight-600">{{round($region_price[$place['id']][$data_region['cult_id']][0][0]['costval'], 1)}}</span> &nbsp;
                                            </div>
                                        </td>
                                    @endif
                                    @if(isset($region_price[$place['id']][$data_region['cult_id']][1]))
                                        <td class="region-USD" style="{{($statusCurtypeRegion == "UAH" || $statusCurtypeRegion == "UAH_USD") ? 'display: none' : ''}}">
                                            <div class="d-flex align-items-center justify-content-center lh-1">
                                                <span class="font-weight-600">{{round($region_price[$place['id']][$data_region['cult_id']][1][0]['costval'], 1)}}</span> &nbsp;
                                            </div>
                                        </td>
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
@endif
<style>
    .region-port-table{
        cursor: pointer;
        color: white !important;
    }

</style>
