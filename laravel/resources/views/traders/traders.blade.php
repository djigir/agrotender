@extends('layout.layout', ['meta' => $meta])
@section('content')
    <div class="new_container">
        <div class="new_page_title">ОБНОВЛЕНИЯ ЗЕРНОТРЕЙДЕРОВ</div>
    </div>
    @include('traders.feed.traders_feed', ['feed' => $feed])
    @include('filters.filter-traders', ['regions' => $regions, 'rubricsGroup' => $rubricGroups, 'onlyPorts' => $onlyPorts])
    <div class="new_container traders mt2">
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

        

    @if($type_view == 'table')
        @include('traders.traders_forward_table', ['type_traders' => $type_traders])
    @else
        <div class="mt-3 traders_dev">
            <div class="new_page_title top_traders_title">ТОП ЗЕРНОТРЕЙДЕРЫ</div>
            <div class="new_traders vip">
                <div class="traders__item-wrap">
                <a href="#" class="traders__item">
                    <div class="traders__item__header filled">
                    <span class="vip">ТОП</span>
                    <img class="traders__item__image" src="https://agrotender.com.ua/pics/comp/4964_89599.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                    <div href="#" class="traders__item__content-title">
                        GrainCorp Ukraine
                    </div>
                    <div class="traders__item__content-description">
                        <p class="traders__item__content-p">
                        <span class="traders__item__content-p-title">Пшеница 1 кл.</span>
                        <span class="right">
                            <span class="traders__item__content-p-price">24 050</span>
                            <span class="traders__item__content-p-icon">
                            <img src="https://agrotender.com.ua/app/assets/img/price-up.svg" alt="">
                            </span>
                        </span>
                        </p>
                        <p class="traders__item__content-p">
                        <span class="traders__item__content-p-title">Жмых подсолнечный ггг</span>
                        <span class="right">
                            <span class="traders__item__content-p-price">24 050</span>
                            <span class="traders__item__content-p-icon">
                            <img src="https://agrotender.com.ua/app/assets/img/price-down.svg" alt="">
                            </span>
                        </span>
                        </p>
                        <p class="traders__item__content-p">
                        <span class="traders__item__content-p-title">Жмых подсолнечный ггг</span>
                        <span class="right">
                            <span class="traders__item__content-p-price">24 050</span>
                            <span class="traders__item__content-p-icon">
                            <img src="https://agrotender.com.ua/app/assets/img/price-down.svg" alt="">
                            </span>
                        </span>
                        </p>
                    </div>
                    <div class="traders__item__content-date">
                        <span class="traders__item__content-date-more">+ ещё</span>
                        <span class="orange">вчера</span>
                    </div>
                    </div>
                </a>
                </div>
                <div class="traders__item-wrap">
                <a href="#" class="traders__item">
                    <div class="traders__item__header filled">
                    <span class="vip">ТОП</span>
                    <img  class="traders__item__image" src="https://agrotender.com.ua/pics/c/p7KovMuRtsOV.jpg" alt="">                
                    </div>
                    <div class="traders__item__content">
                    <div href="#" class="traders__item__content-title">
                        Пiвденна Зернова Столиця
                    </div>
                    <div class="traders__item__content-description">
                        <p class="traders__item__content-p">
                        <span class="traders__item__content-p-title">Пшеница 1 кл.</span>
                        <span class="right">
                            <span class="traders__item__content-p-price">24 050</span>
                            <span class="traders__item__content-p-icon">
                            <img 
                                class="tyre" src="https://agrotender.com.ua/app/assets/img/price-not-changed.svg" alt="">
                            </span>
                        </span>
                        </p>
                        <p class="traders__item__content-p">
                        <span class="traders__item__content-p-title">Жмых подсолнечный ггг</span>
                        <span class="right">
                            <span class="traders__item__content-p-price">24 050</span>
                            <span class="traders__item__content-p-icon"></span>
                        </span>
                        </p>
                        <p class="traders__item__content-p">
                        <span class="traders__item__content-p-title">Жмых подсолнечный ггг</span>
                        <span class="right">
                            <span class="traders__item__content-p-price">24 050</span>
                            <span class="traders__item__content-p-icon">
                            <img src="https://agrotender.com.ua/app/assets/img/price-down.svg" alt="">
                            </span>
                        </span>
                        </p>
                    </div>
                    <div class="traders__item__content-date">
                        <span class="traders__item__content-date-more">+ ещё</span>
                        <span class="green">сегодня</span>
                    </div>
                    </div>
                </a>
                </div>
                <div class="traders__item-wrap">
                <a href="#" class="traders__item">
                    <div class="traders__item__header filled">
                    <span class="vip">ТОП</span>
                    <img class="traders__item__image"  src="https://agrotender.com.ua/pics/comp/1105_96102.jpg" alt="">    
                    </div>
                    <div class="traders__item__content">
                    <div href="#" class="traders__item__content-title">
                        Рамбурс
                    </div>
                    <div class="traders__item__content-description">
                        <p class="traders__item__content-p">
                        <span class="traders__item__content-p-title">Пшеница 1 кл.</span>
                        <span class="right">
                            <span class="traders__item__content-p-price">24 050</span>
                            <span class="traders__item__content-p-icon"></span>
                        </span>
                        </p>
                        <p class="traders__item__content-p">
                        <span class="traders__item__content-p-title">Жмых подсолнечный ггг</span>
                        <span class="right">
                            <span class="traders__item__content-p-price">24 050</span>
                            <span class="traders__item__content-p-icon"></span>
                        </span>
                        </p>
                        <p class="traders__item__content-p">
                        <span class="traders__item__content-p-title">Жмых подсолнечный ггг</span>
                        <span class="right">
                            <span class="traders__item__content-p-price">24 050</span>
                            <span class="traders__item__content-p-icon">
                            <img src="https://agrotender.com.ua/app/assets/img/price-down.svg" alt="">
                            </span>
                        </span>
                        </p>
                    </div>
                    <div class="traders__item__content-date">
                        <span class="traders__item__content-date-more">+ ещё</span>
                        <span class="black">04 июня</span>
                    </div>
                    </div>
                </a>
                </div>
                <div class="traders__item-wrap">
                <a href="#" class="traders__item">
                    <div class="traders__item__header filled">
                    <span class="vip">ТОП</span>
                    <img class="traders__item__image"  src="https://agrotender.com.ua/pics/comp/5576_41048.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                    <div href="#" class="traders__item__content-title">
                        Solagro
                    </div>
                    <div class="traders__item__content-description">
                        <p class="traders__item__content-p">
                        <span class="traders__item__content-p-title">Пшеница 1 кл.</span>
                        <span class="right">
                            <span class="traders__item__content-p-price">24 050</span>
                            <span class="traders__item__content-p-icon"></span>
                        </span>
                        </p>
                        <p class="traders__item__content-p">
                        <span class="traders__item__content-p-title">Жмых подсолнечный ггг</span>
                        <span class="right">
                            <span class="traders__item__content-p-price">24 050</span>
                            <span class="traders__item__content-p-icon"></span>
                        </span>
                        </p>
                        <p class="traders__item__content-p">
                        <span class="traders__item__content-p-title">Жмых подсолнечный ггг</span>
                        <span class="right">
                            <span class="traders__item__content-p-price">24 050</span>
                            <span class="traders__item__content-p-icon">
                            <img src="https://agrotender.com.ua/app/assets/img/price-down.svg" alt="">
                            </span>
                        </span>
                        </p>
                    </div>
                    <div class="traders__item__content-date">
                        <span class="traders__item__content-date-more">+ ещё</span>
                        <span class="black">04 июня</span>
                    </div>
                    </div>
                </a>
                </div>
            </div>
            @if(!empty($traders))
                <!-- Перенёс сюда эту секцию, т.к. секция "Все зернотренйдеры" должна быть тут -->
                @if($type_traders == 0 || $type_traders == 2)
                    @include('traders.block-info.traders')
                        @elseif($type_traders == 1)
                    @include('traders.block-info.forwards-block-info')
                @endif
                <div class="new_traders">
                    @foreach($traders as $trader)
                        @if($trader->culture_prices->count() > 0)
                            <div class="traders__item-wrap">
                            <a href="{{route('company.index', $trader->id) }}" class="traders__item {{($trader->trader_premium == 1 ? 'yellow' : '')}}">
                                <div class="traders__item__header">
                                    <img class="traders__item__image" src="{{ $trader->logo_file }}" alt="">
                                </div>
                                <div class="traders__item__content">
                                    <div href="#" class="traders__item__content-title">
                                        {{ $trader->title }}
                                    </div>
                                    @if(!$culture_translit)
                                        @foreach($trader->culture_prices->take(2) as $index => $price_culture)
                                            <div class="traders__item__content-description">
                                                <p class="traders__item__content-p">
                                                <span class="traders__item__content-p-title">{!! isset($price_culture->cultures[0]) ? $price_culture->cultures[0]->name : '' !!}</span>
                                                    <span class="right">
                                                      <span
                                                          class="traders__item__content-p-price ">{{$price_culture->curtype == 1 ? '$ ' : ''}}{{ round($price_culture->costval, 1) }}</span>
                                                      <span class="traders__item__content-p-icon">
{{--                                                              <img src="/app/assets/img/price-not-changed.svg">--}}
                                                      </span>
                                                    </span>
                                                </p>
                                            </div>
                                        @endforeach
                                    @else
                                    @if($port)
                                        @foreach($trader->places->take(2) as $index => $place)
                                            <div class="traders__item__content-description">
                                                <p class="traders__item__content-p">
                                                     <span class="traders__item__content-p-title">
                                                         @if(isset($place['port'][0]))
                                                                {{ $place['port'][0]['lang']['portname']}}
                                                         @endif
                                                     </span>
                                                     <span class="right">
                                                       <span class="traders__item__content-p-price ">{{$place->pivot->curtype == 1 ? '$ ' : ''}}{{ round($place->pivot->costval, 1) }}</span>
{{--                                                       <span class="traders__item__content-p-icon">  --}}
{{--                                                           <img src="/app/assets/img/price-not-changed.svg"> --}}
{{--                                                       </span>--}}
                                                     </span>
                                                </p>
                                            </div>
                                        @endforeach
                                    @endif
                                        @if($region)
                                            @foreach($trader->places->take(2) as $index => $place)
                                                <div class="traders__item__content-description">
                                                    <p class="traders__item__content-p">
                                                        <span class="traders__item__content-p-title">
                                                            {{  $place->region['name'].' обл.' }}
                                                        </span>
                                                        <span class="right">
                                                           <span class="traders__item__content-p-price ">{{$place->pivot->curtype == 1 ? '$ ' : ''}}{{ round($place->pivot->costval, 1) }}</span>
    {{--                                                       <span class="traders__item__content-p-icon">  --}}
    {{--                                                           <img src="/app/assets/img/price-not-changed.svg"> --}}
    {{--                                                       </span>--}}
                                                         </span>
                                                    </p>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                    <div class="traders__item__content-date">
                                        <span style="{{Carbon\Carbon::today() == $trader['date_price'] ? 'color:#FF7404' : Carbon\Carbon::yesterday() == $trader['date_price'] ? 'color:#009750' : 'color: #001430'}}">{{mb_convert_case($trader['date_price']->format('d F'), MB_CASE_TITLE, "UTF-8")}}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    @endif


@endsection
