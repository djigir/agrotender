@extends('layout.layout', ['meta' => $meta])

@section('content')
    @include('filters.filter-traders', ['regions' => $regions, 'rubricsGroup' => $rubricGroups, 'onlyPorts' => $onlyPorts])
    <div class="container mt-3 "></div>
    <div class="container traders mt-3 mt-sm-5">
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

    <div class="new_container container mt-3 traders_dev">
        @if(!empty($traders))
            <div class="new_traders">
                @foreach($traders as $trader)
                    <div class="traders__item-wrap">
                        <a href="{{route('company.index', $trader['id']) }}" class="traders__item {{($trader['trader_premium'] == 1 ? 'yellow' : '')}} ">
                            <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                                <img class="traders__item__image" src="{{ $trader['logo_file'] }}" data-primary-color="255,255,255">
                            </div>
                            <div class="traders__item__content">
                                <div href="#" class="traders__item__content-title">
                                    {{ $trader['title'] }}
                                </div>
                                @if(isset($trader['cultures']))
                                    @foreach($trader['cultures'] as $index => $culture)
                                        <div class="traders__item__content-description">
                                            @if($index < 3)
                                            <p class="traders__item__content-p">
                                                <span class="traders__item__content-p-title">{{ $culture['name'] }}</span>
                                                    <span class="right">
                                                    <span class="traders__item__content-p-price price-down" data-toggle="tooltip" data-placement="right"
                                                          title="Старая цена: 6010">{{--{{ $prices['costval'] }}--}}</span>
                                                    <span class="traders__item__content-p-icon">
                                                        <img src="/app/assets/img/price-down.svg">
                                                    </span>
                                                </span>
                                            </p>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    @foreach($trader['traders_prices'] as $index => $prices)
                                        <div class="traders__item__content-description">
                                            @if($index < 3)
                                                <p class="traders__item__content-p">
                                                    <span class="traders__item__content-p-title">
                                                        {{$prices['region']['name']}} обл.
{{--                                         <span style="color: black; font-weight: bold; margin-left: 2px">{{ $prices['place_name'] }}</span>--}}
                                                    </span>
                                                    <span class="right">
                                                        <span class="traders__item__content-p-price price-down" data-toggle="tooltip" data-placement="right"
                                                              title="Старая цена: 6010">{{$prices['costval']}}</span>
{{--                                                        <span class="traders__item__content-p-icon">--}}
{{--                                                            <img src="/app/assets/img/price-down.svg">--}}
{{--                                                        </span>--}}
                                                    </span>
                                                </p>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
{{--                                <div class="traders__item__content-date">--}}
{{--                                    <!-- <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->--}}
{{--                                    <span class="green">{{ 'дата' }}</span>--}}
{{--                                </div>--}}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
