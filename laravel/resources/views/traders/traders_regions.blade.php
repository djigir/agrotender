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
                <div class="col-12 col-md-3 float-left mt-sm-0 d-flex justify-content-between d-sm-block">
                    <div class="col-6 col-sm-12 pl-0">
                        <h2 class="d-inline-block text-uppercase">Все трейдеры</h2>
                        <div class="lh-1">
                            <a href="/tarif20.html" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
                        </div>
                    </div>

                    <div class="col-6 pr-0 text-right d-sm-none">
                        <a href="/tarif20.html" class="btn btn-warning align-items-end add-trader">
                            <span class="pl-1 pr-1">Стать трейдером</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="new_container container mt-3 traders_dev">
        @if(!empty($traders))
            <div class="new_traders">
                @foreach($traders as $trader)
                    <div class="traders__item-wrap">
                        <a href="{{route('company.company', $trader['id']) }}" class="traders__item {{($trader['trader_premium'] == 1 ? 'yellow' : '')}} ">
                            <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                                <img class="traders__item__image" src="{{ $trader['logo_file'] }}" data-primary-color="255,255,255">
                            </div>
                            <div class="traders__item__content">
                                <div href="#" class="traders__item__content-title">
                                    {{ $trader['title'] }}
                                </div>
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
                                <div class="traders__item__content-date">
                                    <!-- <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                                    <span class="green">{{ 'дата' }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
