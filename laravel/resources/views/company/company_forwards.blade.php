@extends('layout.layout')

@section('content')
    @include('company.company-header', ['id' => $id])
    <div class="container mt-4 mb-5">
        @if(!empty($prices_port))
        <div class="ports-tabs table-tabs mt-3">
            <a href="#" currency="1" class="active">Закупки USD</a>  </div>
        <div class="content-block prices-block mb-3">
            <div class="price-table-wrap ports scroll-x">
                <table class="sortTable price-table ports-table">
                    <thead>
                        <tr>
                            <th>Порты/переходы</th>
                            @foreach($rubrics_port as $index => $rubric)
                                <th rubric="{{$rubric['traders_products'][0]['id']}}">{{$rubric['traders_products'][0]['culture']['name']}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($prices_port as $index => $price)
                        <tr>
                            <td place="6443" class="py-1">
                                <span class="place-title">{{$price['traders_places'][0]['port']['lang']['portname']}}</span>
                                <span class="place-comment">{{$price['traders_places'][0]['place']}}</span>
                                <span class="popular">{{$price['dt']}}</span>
                            </td>
                            <td place="6443" rubric="14" currency="1" class="currency-1 d-table-cell">
                                <div class="d-flex align-items-center justify-content-center lh-1">
                                    <span class="font-weight-600">{{round($price['costval'], 1)}}</span></div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @if(!empty($prices_region))
        <div class="regions-tabs table-tabs">
            <a href="#" currency="1" class="active">Закупки USD</a>
        </div>
        <div class="content-block prices-block">
            <div class="price-table-wrap regions scroll-x">
                <table class="sortTable price-table regions-table">
                    <thead>
                    <tr>
                        <th>Регионы/элеваторы</th>
                        @foreach($rubrics_region as $index => $rubric)
                            <th rubric="{{$rubric['traders_products'][0]['id']}}">{{$rubric['traders_products'][0]['culture']['name']}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($prices_region as $index => $price)
                        <tr>
                            <td place="8085" class="py-1">
                                <span class="place-title">{{$price['traders_places'][0]['region']['name']}} обл</span>
                                <span class="place-comment">{{$price['traders_places'][0]['place']}}</span>
                                <span class="popular">{{$price['dt']}}</span>
                            </td>
                            <td place="6443" rubric="14" currency="1" class="currency-1 d-table-cell">
                                <div class="d-flex align-items-center justify-content-center lh-1">
                                 <span class="font-weight-600">{{round($price['costval'], 1)}}</span>
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
