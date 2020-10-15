@extends('layout.layout')

@section('content')
    @include('company.company-header')
    <div class="container mt-4 mb-5">
        <h2 class="mx-sm-5">Контакты</h2>
        <div class="content-block trader-contact mx-sm-5 py-3 px-4">
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
        <div class="content-block trader-contact mx-sm-5 py-3 px-4">
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
                            @if($contact['dolg'] !== null)<b>{{ $contact['dolg'] }}</b>@endif<span class="name">@if($contact['fio'] !== null ) {{ $contact['fio'] }} @else - @endif</span>
                        </div>
                    </div>
                    <div class="row m-0 justify-content-center">
                        <div class="col-auto pr-2 text-center">
                            <b>Телефон:</b> <span class="phone">@if($contact['phone'] !== null) {{  $contact['phone'] }} @else - @endif</span>
                        </div>
                        @if($contact['email'] !== null)
                        <div class="col-auto pl-0 text-center">
                            <b>Email:</b> <span class="email">@if($contact['email'] !== null) {{ $contact['email'] }} @else - @endif</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <div class="container mb-5">
        <h2 class="mt-4">Контакты трейдера</h2>
        {if ($company['trader_price_avail'] == 1 or $company['trader_price_sell_avail'] == 1) and $traderContacts neq null}
        {foreach $traderContacts as $place}
        <div class="content-block trader-contact py-3 px-4">
            <div class="place d-flex justify-content-between">
                <div class="title">
                    <span>{$place['name']}</span>
                </div>
            </div>
            <div class="contacts mt-4">
                {foreach $place['contacts'] as $contact}
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    {if $contact['dolg'] neq null or $contact['fio'] neq null}
                    <div class="row m-0 px-3 px-sm-0">
                        <div class="col p-0">
                            {if $contact['dolg'] neq null}<b>{$contact['dolg']|strip_tags}:</b>{/if}{if $detect->isMobile()}<br>{/if} &nbsp;<span class="name">{if $contact['fio'] neq null}{$contact['fio']|strip_tags}{/if}</span>
                        </div>
                    </div>
                    {/if}
                    <div class="row m-0 justify-content-center">
                        <div class="col-auto pr-2 text-center">
                            <span class="phone">{if $contact['phone'] neq null}{$contact['phone']|strip_tags}{/if}</span>
                        </div>
                        {if $contact['email'] neq null}
                        <div class="col-auto pl-2 text-center">
                            <b>Email:</b> &nbsp;<span class="email">{if $contact['email'] neq null}{$contact['email']|strip_tags}{/if}</span>
                        </div>
                        {/if}
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
        {/foreach}
        {else}
        <div class="content-block trader-contact py-3 px-4 text-center">
            <b>Список контактов пуст :(</b>
        </div>
        {/if}
    </div>

@endsection

