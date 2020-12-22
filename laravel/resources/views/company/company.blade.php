@extends('layout.layout', ['meta' => $meta, 'id' => $id])

@section('content')
    @if($isMobile)
        @include('mobile.company-header-mobile')
    @else
        @include('company.company-header', ['id' => $id])
    @endif
    <div class="new_container company mb-5">
        @if(!$port_place->isEmpty() || !$region_place->isEmpty())
            @if(isset($updateDate) && $updateDate)
                <div class="new_company_actual_date new_company_actual_date-desktop-and-mobile">Актуальная цена на
                    <b>{{\Date::parse($updateDate)->format('d F'), MB_CASE_TITLE, "UTF-8"}}</b>
                </div>
            @endif
        @endif

        @if(!$port_place->isEmpty() && !$port_price->isEmpty())
           @include('company.tables.company-port-table')
        @endif

        @if(!$region_place->isEmpty() && !$region_price->isEmpty())
           @include('company.tables.company-region-table')
        @endif

        @if(!$traders_contacts->isEmpty())
            @include('company.company_cont_traders', ['traders_contacts' => $traders_contacts])
        @endif

        <h2 class="mt-4">О компании</h2>
        <div class="about mt-3">
            {!! $company->content !!}
        </div>
    </div>



@endsection
