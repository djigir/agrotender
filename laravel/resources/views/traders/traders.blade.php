@extends('layout.layout', ['meta' => $meta])

@section('content')
    <div class="new_container traders mt2">
        <div class="d-none d-sm-block mt-3">
            <ol class="breadcrumbs small p-0">
                <li>
                    <a href="/">Главная</a>
                </li>
                <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z" fill="#93A2BA"/>
                </svg>
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
                    @if(isset($breadcrumb['arrow']))
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z" fill="#93A2BA"/>
                        </svg>
                    @endif
                @endforeach
            </ol>
        </div>
        @include('traders.feed.traders_feed', ['feed' => $feed])
            @if($type_traders == 0 || $type_traders == 2)
                <div class="d-none d-lg-block">
                    <div class="popular">
                        <span class="text">Популярные <span class="adaptive_remove">культуры:</span></span>
                        <a href="{{route('traders.region_culture', ['ukraine', 'pshenica_2_kl'])}}">Пшеница&nbsp;2&nbsp;кл.</a>
                        <a href="{{route('traders.region_culture', ['ukraine', 'pshenica_3_kl'])}}">Пшеница&nbsp;3&nbsp;кл.</a>
                        <a href="{{route('traders.region_culture', ['ukraine', 'kukuruza'])}}">Кукуруза</a>
                        <a href="{{route('traders.region_culture', ['ukraine', 'raps'])}}">Рапс</a>
                        <a href="{{route('traders.region_culture', ['ukraine', 'podsolnechnik'])}}">Подсолнечник</a>
                        <a href="{{route('traders.region_culture', ['ukraine', 'soya'])}}">Соя</a>
                        <a href="{{route('traders.region_culture', ['ukraine', 'yachmen'])}}">Ячмень</a>
                    </div>
                </div>
                <div class="d-lg-none">
                    <div class="new_page_title mt-4">Популярные культуры</div>
                    <div class="popular">
                        <a href="{{route('traders.region_culture', ['ukraine', 'pshenica_2_kl'])}}">Пшеница&nbsp;2&nbsp;кл.</a>
                        <a href="{{route('traders.region_culture', ['ukraine', 'pshenica_3_kl'])}}">Пшеница&nbsp;3&nbsp;кл.</a>
                        <a href="{{route('traders.region_culture', ['ukraine', 'kukuruza'])}}">Кукуруза</a>
                        <a href="{{route('traders.region_culture', ['ukraine', 'raps'])}}">Рапс</a>
                        <a href="{{route('traders.region_culture', ['ukraine', 'podsolnechnik'])}}">Подсолнечник</a>
                        <a href="{{route('traders.region_culture', ['ukraine', 'soya'])}}">Соя</a>
                        <a href="{{route('traders.region_culture', ['ukraine', 'yachmen'])}}">Ячмень</a>
                    </div>
                </div>
            @endif

        <div class="row new_filters_margin">
            <div class="col-8">
                @if(!$isMobile)
                    @include('filters.filter-traders', ['regions' => $regions, 'rubricsGroup' => $rubricGroups, 'onlyPorts' => $onlyPorts])
                @else
                    @include('mobile.filters.mobile-filter-traders', ['regions' => $regions, 'rubricsGroup' => $rubricGroups, 'onlyPorts' => $onlyPorts])
                @endif
            </div>
            <div class="col-4 d-none d-lg-block">
                <a href="/tarif20.html" class="new_add_company">Разместить компанию</a>
            </div>
        </div>

    </div>

    <div class="mt-3 traders_dev">
        @if($type_view == 'table')
            @include('traders.block-info.traders', ['type_traders' => $type_traders])
        @endif

        @if($type_view == 'table')
            @include('traders.traders_table', ['type_traders' => $type_traders])
        @else
           @include('traders.traders_vip', ['topTraders' => $traders->where('trader_premium', '=', 2)])
           @include('traders.traders_others', ['traders' => $traders->where('trader_premium', '!=', 2)])
        @endif
    </div>
@endsection
