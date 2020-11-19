@extends('layout.layout', ['meta' => $meta])
@section('content')
    @if($isMobile)
        @include('traders.feed.traders_feed', ['feed' => $feed])
    @else
        @include('filters.filter-traders', ['regions' => $regions, 'rubricsGroup' => $rubricGroups, 'onlyPorts' => $onlyPorts])
    @endif
    <div class="container mt-3 "></div>
    <div class="container traders mt-3 mt-sm-5">
        @if(!$isMobile)
            @if($type_traders == 0 || $type_traders == 2)
            <span class="popular" style="margin: 20px 0 ;display: block;">
                <span style="font-weight: 600; color: #707070;">
                <img src="/app/assets/img/speaker.svg" style="width: 24px; height: 24px">
                    Популярные культуры:
                </span>
                <a href="{{route('traders.region_culture', ['ukraine', 'pshenica_2_kl'])}}" class="popular__block">Пшеница 2 кл.</a>
                <a href="{{route('traders.region_culture', ['ukraine', 'pshenica_3_kl'])}}" class="popular__block">Пшеница 3 кл.</a>
                <a href="{{route('traders.region_culture', ['ukraine', 'pshenica_4_kl'])}}" class="popular__block">Пшеница 4 кл.</a>
                <a href="{{route('traders.region_culture', ['ukraine', 'podsolnechnik'])}}" class="popular__block">Подсолнечник</a>
                <a href="{{route('traders.region_culture', ['ukraine', 'soya'])}}" class="popular__block">Соя</a>
                <a href="{{route('traders.region_culture', ['ukraine', 'yachmen'])}}" class="popular__block">Ячмень</a>
            </span>
            @endif
        @endif

    @if($type_traders == 0)
        @include('traders.block-info.traders')
    @else
        @include('traders.block-info.forwards-block-info')
    @endif

    @if($type_view == 'table')
        @include('traders.traders_table', ['type_traders' => $type_traders])
    @else
    <div class="new_container container mt-3 traders_dev">
        @if(!empty($traders))
            <div class="new_traders">
                @foreach($traders as $trader)
                        <div class="traders__item-wrap">
                            <a href="{{route('company.index', $trader->id) }}" class="traders__item {{($trader->trader_premium == 1 ? 'yellow' : '')}}">
                                <div class="traders__item__header">
                                    <img class="traders__item__image" src="{{ $trader->logo_file }}" alt="">
                                </div>
                                <div class="traders__item__content">
                                    <div href="#" class="traders__item__content-title">
                                        {{ $trader->title }}
                                    </div>
                                    @if($trader->prices)
                                        @foreach($trader->prices as $index => $price)
                                            <div class="traders__item__content-description">
                                                <p class="traders__item__content-p">
                                                    <span class="traders__item__content-p-title">
                                                        {!! $price->name !!}
                                                    </span>
                                                    <span class="right">
                                                      <span class="traders__item__content-p-price ">
                                                          {{ $price->curtype == 1 ? '$ ' : ''}}
                                                          {{ round($price->costval, 1) }}
                                                      </span>
                                                      <span class="traders__item__content-p-icon">
                                                        @if($price->change_price == 0)
                                                            <img src="/app/assets/img/price-not-changed.svg">
                                                        @else
                                                              <img src="/app/assets/img/price-{{$price->change_price_type}}.svg">
                                                        @endif
                                                      </span>
                                                    </span>
                                                </p>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="traders__item__content-date">
                                       <span style="{{Carbon\Carbon::today() == $trader['date_price'] ? 'color:#FF7404' : Carbon\Carbon::yesterday() == $trader['date_price'] ? 'color:#009750' : 'color: #001430'}}">
                                           {{mb_convert_case(\Date::parse($trader->prices->first()->change_date)->format('d F'), MB_CASE_TITLE, "UTF-8")}}
                                       </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                @endforeach
            </div>
        @endif
    </div>
    @endif
@endsection
