@extends('layout.layout')

@section('content')
    @include('company.company-header', ['id' => $id])
    @if(!$prices_port->isEmpty() || !$prices_region->isEmpty())

    @if($updateDate)
        <div class="new_company_actual_date">Актуальная цена на <b>{{$updateDate}}</b></div>
    @endif
    <!--<div class="container mt-4">
        <h2 class="d-inline-block">Цены трейдера</h2>
        @if($updateDate)
            <div class="d-inline-block content-block px-3 py-1 mt-3 mb-4 mb-sm-0 ml-0 ml-sm-3">
                <b>Обновлено {{$updateDate}}</b>
            </div>
        @endif
    </div> -->
    @endif
    <div class="container mt-4 mb-5">
        @if($prices_port->count() != 0)
            <div class="ports-tabs table-tabs mt-3">
                <a href="#" currency="1" class="active">Закупки USD</a>
            </div>
            <div class="content-block prices-block mb-3">
                <div class="price-table-wrap ports scroll-x">
                    <table class="sortTable price-table ports-table">
                        <thead>
                            <tr>
                                <th>Порты / Переходы</th>
                                @foreach($rubrics_port as $index => $rubric)
                                    <th rubric="{{$index}}">{{$rubric}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($prices_port as $index => $price)
                            <tr>
                                <td class="py-1">
                                    <span class="place-title">{{$price->traders_places[0]->traders_ports[0]->traders_ports_lang[0]['portname']}}</span>
                                    <span class="place-comment">{{$price->traders_places[0]->place}}</span>
                                    <b class="popular">{{mb_convert_case($price->date->format('F Y'), MB_CASE_TITLE, "UTF-8")}}</b>
                                </td>
                                <td class="currency-1 d-table-cell">
                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                        <span class="font-weight-600">{{round($price->costval, 1)}}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if($prices_region->count() != 0)
            <div class="regions-tabs table-tabs">
                <a href="#" currency="1" class="active">Закупки USD</a>
            </div>
            <div class="content-block prices-block">
                <div class="price-table-wrap regions scroll-x">
                    <table class="sortTable price-table regions-table">
                        <thead>
                        <tr>
                            <th>Регионы / Элеваторы</th>
                            @foreach($rubrics_region as $index => $rubric)
                                <th rubric="{{$index}}">{{$rubric}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($prices_region as $index => $price)
                            <tr>
                                <td class="py-1">
                                    <span class="place-title">{{$price->traders_places[0]->regions[0]['name']}} обл</span>
                                    <span class="place-comment">{{$price->traders_places[0]->place}}</span>
                                    <b class="popular">{{mb_convert_case($price->date->format('F Y'), MB_CASE_TITLE, "UTF-8")}}</b>
                                </td>
                                <td class="currency-1 d-table-cell">
                                    <div class="d-flex align-items-center justify-content-center lh-1">
                                     <span class="font-weight-600">{{round($price->costval, 1)}}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
