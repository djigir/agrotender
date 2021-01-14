@extends('layout.layout', ['meta' => $meta])

@section('content')
    @if($isMobile)
        @include('mobile.company-header-mobile')
    @else
        @include('company.company-header', ['id' => $id])
    @endif
{{--    @dd($company_contacts, $departament_name, $creator)--}}

    @include('company.company_contacts', ['company_contacts' => $company_contacts])


    @if(!$traders_contacts->isEmpty())
        @include('company.company_traders_contacts', ['traders_contacts' => $traders_contacts])
    @endif

@endsection

