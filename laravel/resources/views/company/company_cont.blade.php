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
                    @if(!empty($creator->name) && !empty($creator->phone))
                        <div class="row m-0">
                            <div class="col-12 col-sm pl-2 text-left">
                                <b class="name"> {{ $creator->name }} :</b><span class="phone"> {{ $creator->phone }}</span>
                            </div>
                        </div>
                    @endif
                    @if(!empty($creator->name2) && !empty($creator->phone2))
                        <div class="row m-0">
                            <div class="col-12 col-sm pl-2 text-left">
                                <b class="name">{{ $creator->name2 }} :</b><span class="phone"> {{ $creator->phone2 }}</span>
                            </div>
                        </div>
                    @endif
                    @if(!empty($creator->name3) && !empty($creator->phone3))
                        <div class="row m-0">
                            <div class="col-12 col-sm pl-2 text-left">
                                <b class="name">{{ $creator->name3 }} :</b><span class="phone"> {{ $creator->phone3 }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                @if(!empty($creator->email))
                    <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                        <div class="row m-0">
                            <div class="col-12 col-sm pl-2 pr-2 text-left">
                                <b>Email :</b><span class="email"> {{ $creator->email }}</span>
                            </div>
                        </div>
                    </div>
                @endif
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
                    @foreach($departments_contacts as $dep_contact)
                        @if($dep_name == $dep_contact->dep_name)
                        <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                            <div class="row m-0 px-3 px-sm-0">
                                <div class="col p-0">
                                    @if(!empty($dep_contact->dolg))<b>{{ $dep_contact->dolg }}:</b>@endif<span class="name">@if(!empty($dep_contact->fio)) {!! $dep_contact->fio !!} @else - @endif</span>
                                </div>
                            </div>
                            <div class="row m-0 justify-content-center">
                                <div class="col-auto pr-2 text-center">
                                    <b>Телефон:</b> <span class="phone">@if(!empty($dep_contact->phone)) {!! $dep_contact->phone !!} @else - @endif</span>
                                </div>
                                @if(!empty($dep_contact->email))
                                    <div class="col-auto pl-0 text-center">
                                        <b>Email:</b> <span class="email">{!! $dep_contact->email !!}</span>
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
                @if($trader_contact['traders_contacts']->count() != 0)
                <div class="content-block trader-contact py-3 px-4">
                    <div class="place d-flex justify-content-between">
                        <div class="title">
                            <span>{{ $trader_contact->name }}</span>
                        </div>
                    </div>
                    <div class="contacts mt-4">
                        @foreach($trader_contact['traders_contacts'] as $contact_trader)
                            <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                                @if(!empty($contact_trader->dolg) || !empty($contact_trader->fio))
                                    <div class="row m-0 px-3 px-sm-0">
                                        <div class="col p-0">
                                            @if(!empty($contact_trader->dolg))
                                                <b>{{ $contact_trader->dolg }}:</b>
                                            @endif
                                            <span class="name">@if(!empty($contact_trader->fio)){{strip_tags($contact_trader->fio) }}@endif
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                <div class="row m-0 justify-content-center">
                                    <div class="col-auto pr-2 text-center">
                                        <b>Телефон:</b>
                                        <span class="phone">
                                        @if(!empty($contact_trader->phone)) {{ strip_tags($contact_trader->phone) }} @else - @endif</span>
                                    </div>

                                    @if(!empty($contact_trader->email && !empty($contact_trader->email)))
                                        <div class="col-auto pl-2 text-center">
                                            <b>Email:</b> &nbsp;<span class="email">@if(!empty($contact_trader->email)) {{ $contact_trader->email }} @endif</span>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
        @endforeach
        </div>
    @endif
@endsection

