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
                    @foreach($creators as $creator)
                        @if($creator->name !== '' && $creator->phone !== '')
                    <div class="row m-0">
                        <div class="col-12 col-sm pl-2 text-left">
                            <b class="name"> {{ $creator->name }} :</b> &nbsp;<span class="phone">{{ $creator->phone }}</span>
                        </div>
                    </div>
                        @endif
                        @if($creator->name2 !== '' && $creator->phone2 !== '')
                                <div class="row m-0">
                                    <div class="col-12 col-sm pl-2 text-left">
                                        <b class="name">{{ $creator->name2 }} :</b> &nbsp;<span class="phone">{{ $creator->phone2 }}</span>
                                    </div>
                                </div>
                        @endif
                            @if($creator->name3 !== '' && $creator->phone3 !== '')
                                <div class="row m-0">
                                    <div class="col-12 col-sm pl-2 text-left">
                                        <b class="name">{{ $creator->name3 }} :</b> &nbsp;<span class="phone">{{ $creator->phone3 }}</span>
                                    </div>
                                </div>
                            @endif
                    @endforeach
                </div>
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    <div class="row m-0">
                        <div class="col-12 col-sm pl-2 pr-2 text-left">
                            <b>Email :</b><span class="email"> {{ $creator->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--        {foreach from=$contacts item=arr key=depName}--}}
        @foreach($departament_name as  $dep_name)
        <div class="content-block trader-contact mx-sm-5 py-3 px-4">
            <div class="place d-flex justify-content-between">
                <div class="title">
                    <span>{{ $dep_name }}</span>
                </div>
            </div>
            <div class="contacts mt-4">
{{--                {foreach $arr as $contact}--}}
                @foreach($company_contacts as $contact)
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    <div class="row m-0 px-3 px-sm-0">
                        <div class="col p-0">
{{--                            {if $contact['dolg'] neq null}<b>{$contact['dolg']|strip_tags}:</b>{/if}{if $detect->isMobile()}<br>{/if} &nbsp;<span class="name">{if $contact['fio'] neq null}{$contact['fio']|strip_tags}{else}—{/if}</span>--}}
                        </div>
                    </div>
                    <div class="row m-0 justify-content-center">
                        <div class="col-auto pr-2 text-center">
{{--                            <b>Телефон:</b> &nbsp;<span class="phone">{if $contact['phone'] neq null}{$contact['phone']|strip_tags}{else}—{/if}</span>--}}
                        </div>
{{--                        {if $contact['email'] neq null}--}}
                        <div class="col-auto pl-0 text-center">
                            <b>Email:</b> &nbsp;<span class="email">{if $contact['email'] neq null}{$contact['email']|strip_tags}{else}—{/if}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{--<div class="content-block trader-contact mx-sm-5 py-3 px-4">
            <div class="place d-flex justify-content-between">
                <div class="title">
                    <span>Отдел закупок</span>
                </div>
            </div>
            <div class="contacts mt-4">
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    <div class="row m-0 px-3 px-sm-0">
                        <div class="col p-0">
                            <b>Отдел закупок:</b> &nbsp;<span class="name">Моргунов Евгений</span>
                        </div>
                    </div>
                    <div class="row m-0 justify-content-center">
                        <div class="col-auto pr-2 text-center">
                            <b>Телефон:</b> &nbsp;<span class="phone">+380672491112</span>
                        </div>
                    </div>
                </div>
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    <div class="row m-0 px-3 px-sm-0">
                        <div class="col p-0">
                            <b>Отдел закупок:</b> &nbsp;<span class="name">Меркушев Валерий</span>
                        </div>
                    </div>
                    <div class="row m-0 justify-content-center">
                        <div class="col-auto pr-2 text-center">
                            <b>Телефон:</b> &nbsp;<span class="phone">+380672467167</span>
                        </div>
                    </div>
                </div>
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    <div class="row m-0 px-3 px-sm-0">
                        <div class="col p-0">
                            <b>Отдел закупок Заподный регион:</b> &nbsp;<span class="name">Боршош Ярослав</span>
                        </div>
                    </div>
                    <div class="row m-0 justify-content-center">
                        <div class="col-auto pr-2 text-center">
                            <b>Телефон:</b> &nbsp;<span class="phone">+380672467174</span>
                        </div>
                    </div>
                </div>
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    <div class="row m-0 px-3 px-sm-0">
                        <div class="col p-0">
                            <b>Отдел закупок нишевые культуры:</b> &nbsp;<span class="name">Мовчан Алексей</span>
                        </div>
                    </div>
                    <div class="row m-0 justify-content-center">
                        <div class="col-auto pr-2 text-center">
                            <b>Телефон:</b> &nbsp;<span class="phone">+380503882122</span>
                        </div>
                    </div>
                </div>
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    <div class="row m-0 px-3 px-sm-0">
                        <div class="col p-0">
                            <b>Отдел закупок комбикормовый:</b> &nbsp;<span class="name">Пархоменко Константин</span>
                        </div>
                    </div>
                    <div class="row m-0 justify-content-center">
                        <div class="col-auto pr-2 text-center">
                            <b>Телефон:</b> &nbsp;<span class="phone">+380930731125</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}
        @endforeach
    </div>

@endsection
