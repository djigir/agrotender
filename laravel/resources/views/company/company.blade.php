@extends('layout.layout', ['meta' => $meta, 'id' => $id])

@section('content')

    @include('company.company-header', ['id' => $id, 'company_name' => $company['title']])
    <div class="new_container company mb-5">
        @if(!$port_place->isEmpty() || !$region_place->isEmpty())
            <!-- <h2 class="d-inline-block mt-4">Цены трейдера</h2> -->
            @if($updateDate)
                <div class="new_company_actual_date new_company_actual_date-desktop-and-mobile">Актуальная цена на <b>{{$updateDate}}</b></div>
                <!-- <div class="d-inline-block content-block px-3 py-1 mt-3 mb-4 mb-sm-0 ml-0 ml-sm-3">
                    <b>Обновлено {{$updateDate}}</b>
                </div> -->
            @endif
        @endif

        @if(!$port_place->isEmpty())
           @include('company.tables.company-port-table')
        @endif

        @if(!$region_place->isEmpty())
           @include('company.tables.company-region-table')
        @endif

        <h2 class="mt-4">О компании</h2>
        <div class="about mt-3">
            {!! $company['content'] !!}
        </div>
    </div>
    
    <div class="bg_filters bg_filters_spoiler"></div>
    <div class="open_company_menu">
        <ul class="spoiler">
            <li class="spoiler_small_mb">
                <a href="#" class="spoiler_flex">
                    <img src="{{$company['logo_file'] && file_exists($company['logo_file']) ? $company['logo_file'] : '/app/assets/img/no-image.png'}}" alt="">
                    <span>{{$company['title']}}</span>
                </a>
            </li>
            <li>
                <a href="#">Цены трейдера</a>
            </li>
            <li>
                <a href="#">Контакты</a>
            </li>
            <li>
                <a href="#">Отзывы</a>
            </li>
            <li>
                <a href="#">Форварды</a>
            </li>
        </ul>
        <button>Меню компании</button>
  </div>
@endsection
