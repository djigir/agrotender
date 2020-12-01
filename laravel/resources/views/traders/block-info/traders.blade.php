@if($traders->count() > 0)
    <div class="flex align-center justify-between mt2d4 mb2">
        <div class="new_page_title">ВСЕ ЗЕРНОТРЕЙДЕРЫ</div>
    </div>
@endif
{{--@if($type_traders == 0)--}}
{{--<div class="container mt-3 mt-sm-5">--}}
{{--    <div class="row mt-sm-0 pt-sm-0 mb-sm-4">--}}
{{--        <div class="position-relative w-100">--}}
{{--            @if(!$isMobile)--}}
{{--                <div class="col-12 col-md-9 float-md-right text-center text-md-right">--}}
{{--                    <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end d-none d-sm-inline-block">--}}
{{--                        <i class="far fa-plus mr-2"></i>--}}
{{--                        <span class="pl-1 pr-1">Разместить компанию</span>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="col-12 col-md-3 float-left mt-sm-0 d-flex justify-content-between d-sm-block">--}}
{{--                    @if($traders->count() > 0)--}}
{{--                        <div class="col-6 col-sm-12 pl-0">--}}
{{--                            <h2 class="d-inline-block text-uppercase">{{ $culture_translit ? 'Закупочные цены на: '.$culture_name : "Все трейдеры"}}</h2>--}}
{{--                            <div class="lh-1">--}}
{{--                                <a href="/tarif20.html" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    <div class="col-6 pr-0 text-right d-sm-none">--}}
{{--                        <a href="/tarif20.html" class="btn btn-warning align-items-end add-trader">--}}
{{--                            <span class="pl-1 pr-1">Стать трейдером</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            @if($isMobile && $region && $region != 'ukraine' && $culture_translit == null)--}}
{{--                <div class="col-12 col-md-3 float-left mt-sm-0 d-flex justify-content-between d-sm-block">--}}
{{--                    @if($traders->count() > 0)--}}
{{--                        <div class="col-6 col-sm-12 pl-0">--}}
{{--                            <h2 class="d-inline-block text-uppercase">{{ $culture_translit ? 'Закупочные цены на: '.$culture_name : "Все трейдеры"}}</h2>--}}
{{--                            <div class="lh-1">--}}
{{--                                <a href="/tarif20.html" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    <div class="col-6 pr-0 text-right d-sm-none">--}}
{{--                        <a href="/tarif20.html" class="btn btn-warning align-items-end add-trader">--}}
{{--                            <span class="pl-1 pr-1">Стать трейдером</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="d-sm-none container  pt-2 pt-sm-4">--}}
{{--                    <span class="searchTag d-inline-block">--}}
{{--                        {{$region_port_name}} область--}}
{{--                        <a href="{{route('traders.region', 'ukraine')}}"><i class="far fa-times close ml-2"></i></a>--}}
{{--                    </span>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            @if($isMobile && $culture_translit && $culture_name != 'Выбрать продукцию' && $traders->count() > 0)--}}
{{--                <div class="col-12 col-md-9 float-md-right text-center text-md-right">--}}
{{--                    <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end">--}}
{{--                        <i class="far fa-plus mr-2"></i>--}}
{{--                        <span class="pl-1 pr-1">Разместить компанию</span>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="col-12 col-md-3 float-left mt-4 mt-md-0 d-block">--}}
{{--                    <h2 class="d-inline-block text-uppercase">Все трейдеры</h2>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endif--}}
