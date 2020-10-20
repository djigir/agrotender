@extends('layout.layout', ['title' => $meta['title'],
'keywords' => $meta['keywords'],
'description' => $meta['description']])

@section('content')
    @include('company.company-header', ['id' => $id, 'company_name' => $company->title])

    <div class="container company mb-5">
        <h2 class="d-inline-block mt-4">Цены трейдера</h2>
        <div class="d-inline-block content-block px-3 py-1 mt-3 mb-4 mb-sm-0 ml-0 ml-sm-3">
            <b>Обновлено 15.10.2020</b>
        </div>
        <div class="ports-tabs table-tabs mt-3">
            @if(!empty($port_price['UAH']))
                <a  id='uah' class="active" style="cursor: pointer; color: white">Закупки UAH</a>
            @endif
            @if(!empty($port_price['USD']))
                <a  id='usd' style="cursor: pointer; color: white">Закупки USD</a>
            @endif
        </div>
        <div class="content-block prices-block mb-5" style="position: relative" currency="1">
            <div class="price-table-wrap ports scroll-x d-none d-sm-block">
                @if(!empty($port_place))
                    <div class="tableFirst" style="position: relative; z-index: 1;overflow: hidden;">
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

                <div class="tableSecond">
                    <div class="tableScroll blue">
                        <table class="sortTable price-table ports-table"
                               style="left: -240px; width: calc(100% + 240px)">
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
            </div>
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
        </div>
        @if(!empty($region_place))
            <div class="regions-tabs table-tabs mt-5">
                <a href="#" currency="0" class="active">Закупки UAH</a></div>
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
        <h2 class="mt-4">О компании</h2>
        <div class="about mt-3">
            {!! $company->content !!}
        </div>

    </div>
@endsection
<script>
    // window.onload = function () {
    //     $("#uah").click(function (event){
    //         $("#usd").removeClass('active');
    //         $("#uah").addClass('active');
    //
    //         $(".tableSecond").css('display', 'none');
    //         $(".tableFirst").css('display', 'block');
    //     });
    //
    //     $("#usd").click(function (event) {
    //         $("#usd").addClass('active');
    //         $("#uah").removeClass('active');
    //         $(".tableSecond").css('display', 'block');
    //         $(".tableFirst").css('display', 'none');
    //     });
    // }
</script>
