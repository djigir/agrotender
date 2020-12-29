@extends('layout.layout', ['meta' => $meta])

@section('content')
    @if($isMobile)
        @include('mobile.company-header-mobile')
    @else
        @include('company.company-header', ['id' => $id])
    @endif
    <div class="container mt-4 mb-5">
        <h2 class="mt-4">Контакты</h2>
        <div class="content-block trader-contact py-3 px-4">
            <div class="place d-flex justify-content-between">
                <div class="title">
                    <span>Главный офис</span>
                </div>
            </div>
            <div class="contacts mt-4">
                @if($company->city !== null)
                    <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                        <div class="row m-0">
                            <div class="col-12 col-sm pl-2 text-left">
                                <span class="name">{{ $company->city }}</span>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    @if(!is_null($creator['name']) && $creator['name'] !== '' && !is_null($creator['phone']) && $creator['phone'] !== '')
                        <div class="row m-0">
                            <div class="col-12 col-sm pl-2 text-left">
                                <b class="name"> {{ $creator['name'] }} :</b><span class="phone"> {{ $creator['phone'] }}</span>
                            </div>
                        </div>
                    @endif
                    @if(!is_null($creator['name2']) && $creator['name2'] !== '' && !is_null($creator['phone2']) && $creator['phone2'] !== '')
                        <div class="row m-0">
                            <div class="col-12 col-sm pl-2 text-left">
                                <b class="name">{{ $creator['name2'] }} :</b><span class="phone"> {{ $creator['phone2'] }}</span>
                            </div>
                        </div>
                    @endif
                    @if(!is_null($creator['name3']) && $creator['name3'] !== '' && !is_null($creator['phone3']) && $creator['phone3']  !== '')
                        <div class="row m-0">
                            <div class="col-12 col-sm pl-2 text-left">
                                <b class="name">{{ $creator['name3'] }} :</b><span class="phone"> {{ $creator['phone3'] }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    <div class="row m-0">
                        <div class="col-12 col-sm pl-2 pr-2 text-left">
                            <b>Email :</b><span class="email"> {{ $creator['email'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach($departament_name as  $dep_name)
            <div class="content-block trader-contact py-3 px-4">
                <div class="place d-flex justify-content-between">
                    <div class="title">
                        <span>{{ $dep_name }}</span>
                    </div>
                </div>
                <div class="contacts mt-4">
                    @foreach($company_contacts as $contact)
                        <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                            <div class="row m-0 px-3 px-sm-0">
                                <div class="col p-0">
                                    @if($contact['dolg'] !== null)<b>{{ $contact['dolg'] }} </b>@endif<span class="name">@if($contact['fio'] !== null ) {!! $contact['fio'] !!} @else - @endif</span>
                                </div>
                            </div>
                            <div class="row m-0 justify-content-center">
                                <div class="col-auto pr-2 text-center">
                                    <b>Телефон:</b> <span class="phone">@if($contact['phone'] !== null) {!! $contact['phone'] !!} @else - @endif</span>
                                </div>
                                @if($contact['email'] !== null)
                                    <div class="col-auto pl-0 text-center">
                                        <b>Email:</b> <span class="email">@if($contact['email'] !== null) {!! $contact['email'] !!} @else - @endif</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    @if(!$traders_contacts->isEmpty())
        @include('company.company_cont_traders', ['traders_contacts' => $traders_contacts])
    @endif

@endsection

