@extends('layout.layout', ['meta' => $meta])
@section('content')
    @include('filters.filter-traders', ['regions' => $regions, 'rubricsGroup' => $rubricGroups, 'onlyPorts' => $onlyPorts])
    <div class="container mt-3 "></div>
    <div class="container traders mt-3 mt-sm-5">
        @if(!$isMobile)
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
        <div class="row mt-sm-0 pt-sm-0 mb-sm-4">
            <div class="position-relative w-100">
                <div class="col-12 col-md-9 float-md-right text-center text-md-right">
                    <a id="addCompanny" href="/tarif20.html"
                       class="top-btn btn btn-warning align-items-end d-none d-sm-inline-block">
                        <i class="far fa-plus mr-2"></i>
                        <span class="pl-1 pr-1">Разместить компанию</span>
                    </a>
                </div>
                @if($type_traders == 0)
                    @include('traders.block-info.traders')
                @elseif(empty($traders) && ($type_traders == 1 || $type_traders == 2 ))
                    @include('traders.block-info.traders_forwards')
                @endif
            </div>
        </div>
    </div>
    @if($type_view == 'table')
        @include('traders.traders_forward_table')
    @else
        <div class="new_container container mt-3 traders_dev">
            @if(!empty($traders))
                <div class="new_traders">
                    @foreach($traders as $trader)
                        <div class="traders__item-wrap">
                            <a href="{{route('company.index', $trader['id']) }}"
                               class="traders__item {{($trader['trader_premium'] == 1 ? 'yellow' : '')}}">
                                <div class="traders__item__header">
                                    <img class="traders__item__image" src="{{ $trader['logo_file'] }}" alt="">
                                </div>
                                <div class="traders__item__content">
                                    <div href="#" class="traders__item__content-title">
                                        {{ $trader['title'] }}
                                    </div>
                                    @if($type_traders != 1 && !$culture_translit)
                                        @foreach($trader['traders_prices'] as $index => $price_culture)
                                            <div class="traders__item__content-description">
                                                @if($index < 2)
                                                    <p class="traders__item__content-p">
                                                    <span
                                                        class="traders__item__content-p-title">{{ $price_culture['culture']['name'] }}</span>
                                                        <span class="right">
                                                  <span
                                                      class="traders__item__content-p-price ">{{ $price_culture['costval'] }}</span>
                                                  <span class="traders__item__content-p-icon">
                                                    {{--  <img src="/app/assets/img/price-not-changed.svg">  --}}
                                                  </span>
                                                </span>
                                                    </p>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($trader['traders_prices'] as $index => $prices)
                                            <div class="traders__item__content-description">
                                                @if($index < 2)
                                                    @if(isset($prices['port']) && isset($prices['region']))
                                                        <p class="traders__item__content-p">
                                                            <span class="traders__item__content-p-title">{{ $port != null ? $prices['port']['lang']['portname']  : $prices['region']['name'].' обл.'}} </span>
                                                            <span class="right">
                                                  <span
                                                      class="traders__item__content-p-price ">{{$prices['costval']}}</span>
                                                  <span class="traders__item__content-p-icon">
                                                    {{--  <img src="/app/assets/img/price-not-changed.svg"> --}}
                                                  </span>
                                                </span>
                                                        </p>
                                                    @endif
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="traders__item__content-date">
                                        <span style="{{Carbon\Carbon::today() == $trader['date_price'] ? 'color:#FF7404' : Carbon\Carbon::yesterday() == $trader['date_price'] ? 'color:#009750' : 'color: #001430'}}">{{mb_convert_case($trader['date_price']->format('d F'), MB_CASE_TITLE, "UTF-8")}}</span>
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
