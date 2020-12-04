@extends('layout.layout', ['meta' => $meta])
@section('content')

    <div class="new_container traders mt2">
        <div class="d-none d-sm-block mt-3">
            <ol class="breadcrumbs small p-0">
                <li>
                    <a href="/reklama">Главная</a>
                </li>
                <i class="fas fa-chevron-right extra-small"></i>
                @foreach($breadcrumbs as $index_bread => $breadcrumb)
                    <li>
                        @if($breadcrumb['url'])
                            <a href="{{$breadcrumb['url']}}">
                                <h1>{!! $breadcrumb['name'] !!}</h1>
                            </a>
                        @else
                            <h1>{!! $breadcrumb['name'] !!}</h1>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>

        @include('traders.feed.traders_feed', ['feed' => $feed])

        @if(!$isMobile)
            @if($type_traders == 0 || $type_traders == 2)
                <div class="popular">
                    <span class="text">Популярные <span class="adaptive_remove">культуры:</span></span>
                    <a href="{{route('traders.region_culture', ['ukraine', 'pshenica_2_kl'])}}">Пшеница 2 кл.</a>
                    <a href="{{route('traders.region_culture', ['ukraine', 'pshenica_3_kl'])}}">Пшеница 3 кл.</a>
                    <a href="{{route('traders.region_culture', ['ukraine', 'kukuruza'])}}">Кукуруза</a>
                    <a href="{{route('traders.region_culture', ['ukraine', 'raps'])}}">Рапс</a>
                    <a href="{{route('traders.region_culture', ['ukraine', 'podsolnechnik'])}}">Подсолнечник</a>
                    <a href="{{route('traders.region_culture', ['ukraine', 'soya'])}}">Соя</a>
                    <a href="{{route('traders.region_culture', ['ukraine', 'yachmen'])}}">Ячмень</a>
                </div>
            @endif
        @endif

{{--        @if($type_view != 'table')--}}
            <div class="row new_filters_margin">
                <div class="col-8">
                    @include('filters.filter-traders', ['regions' => $regions, 'rubricsGroup' => $rubricGroups, 'onlyPorts' => $onlyPorts])
                </div>
                <div class="col-4 d-none d-lg-block">
                    <a href="/tarif20.html" class="new_add_company">Разместить компанию</a>
                </div>
            </div>
{{--        @endif--}}

{{--        @if($type_view == 'table')--}}
{{--            <div class="d-flex align-items-center new_filters_margin">--}}
{{--                <div class="new_page_title mr-auto d-none d-lg-block">ВСЕ ЗЕРНОТРЕЙДЕРЫ</div>--}}
{{--                @include('filters.filter-traders', ['regions' => $regions, 'rubricsGroup' => $rubricGroups, 'onlyPorts' => $onlyPorts])--}}
{{--            </div>--}}
{{--            @include('traders.traders_forward_table', ['type_traders' => $type_traders])--}}
{{--        @else--}}

        </div>

        <div class="mt-3 traders_dev">
            @if($type_traders != 0)
                @include('traders.block-info.forwards-block-info')
            @else
                @if($type_view == 'table')
                    @include('traders.block-info.traders')
                @endif
            @endif

            @if($type_view == 'table')
                @include('traders.traders_table', ['type_traders' => $type_traders])
            @else
                @if(!empty($topTraders))
                    @include('traders.traders_vip')
                @endif

                @if(!empty($traders))
                    @include('traders.traders_others')
                @endif
        {{--        @if(!empty($topTraders))--}}
        {{--            @include('traders.block-info.traders_top')--}}
        {{--        @endif--}}
        {{--        <div class="new_container container mt-3 traders_dev">--}}
        {{--            @if(!empty($topTraders))--}}
        {{--                <div class="new_traders">--}}
        {{--                    @foreach($topTraders as $trader)--}}
        {{--                        <div class="traders__item-wrap">--}}
        {{--                            <a href="{{route('company.index', $trader->id) }}" class="traders__item yellow">--}}
        {{--                                <div class="traders__item__header">--}}
        {{--                                    <img class="traders__item__image" src="{{ $trader->logo_file }}" alt="">--}}
        {{--                                </div>--}}
        {{--                                <div class="traders__item__content">--}}
        {{--                                    <div href="#" class="traders__item__content-title">--}}
        {{--                                        {{ $trader->title }}--}}
        {{--                                    </div>--}}
        {{--                                    @if($trader->prices)--}}
        {{--                                        @foreach($trader->prices as $index => $price)--}}
        {{--                                            <div class="traders__item__content-description">--}}
        {{--                                                <p class="traders__item__content-p">--}}
        {{--                                                    <span class="traders__item__content-p-title">--}}
        {{--                                                        {!! $price->name !!}--}}
        {{--                                                    </span>--}}
        {{--                                                    <span class="right">--}}
        {{--                                                      <span class="traders__item__content-p-price ">--}}
        {{--                                                          {{ $price->curtype == 1 ? '$ ' : ''}}--}}
        {{--                                                          {{ round($price->costval, 1) }}--}}
        {{--                                                      </span>--}}
        {{--                                                      <span class="traders__item__content-p-icon">--}}
        {{--                                                        @if($price->change_price == 0)--}}
        {{--                                                              <img src="/app/assets/img/price-not-changed.svg">--}}
        {{--                                                          @else--}}
        {{--                                                              <img src="/app/assets/img/price-{{$price->change_price_type}}.svg">--}}
        {{--                                                          @endif--}}
        {{--                                                      </span>--}}
        {{--                                                    </span>--}}
        {{--                                                </p>--}}
        {{--                                            </div>--}}
        {{--                                        @endforeach--}}
        {{--                                    @endif--}}
        {{--                                    <div class="traders__item__content-date">--}}
        {{--                                        <span style="{{Carbon\Carbon::today() == $trader->prices->first()->change_date ? 'color:#FF7404' : Carbon\Carbon::yesterday() == $trader->prices->first()->change_date ? 'color:#009750' : 'color: #001430'}}">--}}
        {{--                                            {{mb_convert_case(\Date::parse($trader->prices->first()->change_date)->format('d F'), MB_CASE_TITLE, "UTF-8")}}--}}
        {{--                                        </span>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                            </a>--}}
        {{--                        </div>--}}
        {{--                    @endforeach--}}
        {{--                </div>--}}
        {{--            @endif--}}
        {{--        </div>--}}
        @endif
</div>
@endsection
