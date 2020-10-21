@extends('layout.layout', [
    'title' => $meta['title'],
'keywords' => $meta['keywords'],
'description' => $meta['description'], 'id' => $id])

@section('content')
    @include('company.company-header', ['id' => $id, 'company_name' => $company['title']])
    <div class="container company mb-5">
        <h2 class="d-inline-block mt-4">Цены трейдера</h2>
{{--        <div class="d-inline-block content-block px-3 py-1 mt-3 mb-4 mb-sm-0 ml-0 ml-sm-3">--}}
{{--            <b>Обновлено 15.10.2020</b>--}}
{{--        </div>--}}
        <div class="ports-tabs table-tabs mt-3">
            @if(!empty($port_price['UAH']))
                <a  id='uah' class="active" style="cursor: pointer; color: white">Закупки UAH</a>
            @endif
            @if(!empty($port_price['USD']))
                <a  id='usd' style="cursor: pointer; color: white">Закупки USD</a>
            @endif
        </div>
        <div class="content-block prices-block mb-5" style="position: relative" currency="1">
            @include('company.tables.company-port-table')
        </div>
        @include('company.tables.company-region-table')
        <h2 class="mt-4">О компании</h2>
        <div class="about mt-3">
            {!! $company['content'] !!}
        </div>
    </div>
@endsection
