@extends('layout.layout', ['meta' => $meta, 'id' => $id])

@section('content')
    @include('company.company-header', ['id' => $id, 'company_name' => $company['title']])
    <div class="container company mb-5">
        @if(!empty($port_place) || !empty($region_place))
            <h2 class="d-inline-block mt-4">Цены трейдера</h2>
            @if($updateDate != null)
                <div class="d-inline-block content-block px-3 py-1 mt-3 mb-4 mb-sm-0 ml-0 ml-sm-3">
                    <b>Обновлено {{$updateDate}}</b>
                </div>
            @endif
        @endif
        <div class="ports-tabs table-tabs mt-3">
            @if(!empty($port_price['UAH']))
                <a  id='uah' class="active" style="cursor: pointer; color: white">Закупки UAH</a>
            @endif
            @if(!empty($port_price['USD']))
                <a  id='usd' style="cursor: pointer; color: white">Закупки USD</a>
            @endif
        </div>

        @if(!empty($port_place))
            @include('company.tables.company-port-table')
        @endif

        @if(!empty($region_place))
            @include('company.tables.company-region-table')
        @endif
        <h2 class="mt-4">О компании</h2>
        <div class="about mt-3">
            {!! $company['content'] !!}
        </div>
    </div>
@endsection
