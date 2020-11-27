@extends('layout.layout', ['meta' => $meta])

@section('content')
    @include('company.company-header', ['id' => $id, 'company_name' => $company['title']])
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
                    @foreach($conts as $cont)
                        @if($dep_name == $cont->dep_name)
                        <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                            <div class="row m-0 px-3 px-sm-0">
                                <div class="col p-0">
                                    @if($cont->dolg !== null)<b>{{ $cont->dolg }} </b>@endif<span class="name">@if($cont->fio !== null ) {!! $cont->fio !!} @else - @endif</span>
                                </div>
                            </div>
                            <div class="row m-0 justify-content-center">
                                <div class="col-auto pr-2 text-center">
                                    <b>Телефон:</b> <span class="phone">@if($cont->phone !== null) {!! $cont->phone !!} @else - @endif</span>
                                </div>
                                @if(!empty($cont->email))
                                    <div class="col-auto pl-0 text-center">
                                        <b>Email:</b> <span class="email">@if($cont->email !== null) {!! $cont->email !!} @else - @endif</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    @if($traders_contacts->count() != 0)
    <div class="container mb-5">
        <h2 class="mt-4">Контакты трейдера</h2>
            @foreach($traders_contacts as $trader_contact)
                <div class="content-block trader-contact py-3 px-4">
                    <div class="place d-flex justify-content-between">
                        <div class="title">
                            <span>{{ $trader_contact['name'] }}</span>
                        </div>
                    </div>
                    <div class="contacts mt-4">
                        @foreach($trader_contact['traders_contacts'] as $contact_trader)
                            <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                                @if(!is_null($contact_trader['dolg']) || !is_null($contact_trader['fio']))
                                    <div class="row m-0 px-3 px-sm-0">
                                        <div class="col p-0">
                                            @if(!is_null($contact_trader['dolg']))
                                                <b>{{ $contact_trader['dolg'] }}</b>
                                            @endif
                                            <span class="name" {{--style="white-space: pre-line"--}}>
                            @if(!is_null($contact_trader['fio']))
                                                    {{strip_tags($contact_trader['fio']) }}
                                                @endif
                            </span>
                                        </div>
                                    </div>
                                @endif
                                <div class="row m-0 justify-content-center">
                                    <div class="col-auto pr-2 text-center">
                                        <b>Телефон:</b>
                                        <span class="phone"{{-- style="white-space: pre-line"--}}>
                                @if(!is_null($contact_trader['phone']))
                                                {{ strip_tags($contact_trader['phone']) }}
                                            @endif
                            </span>
                                    </div>
                                    @if( !empty($contact_trader['email'] && !is_null($contact_trader['email'])))
                                        <div class="col-auto pl-2 text-center">
                                            <b>Email:</b> &nbsp;<span class="email">@if(!is_null($contact_trader['email'])) {{ $contact_trader['email'] }} @endif</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

