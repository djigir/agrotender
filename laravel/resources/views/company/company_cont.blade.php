@extends('layout.layout')

@section('content')
    <div class="container mt-4 mb-5">
        <h2 class="mx-sm-5">Контакты</h2>
        <div class="content-block trader-contact mx-sm-5 py-3 px-4">
            <div class="place d-flex justify-content-between">
                <div class="title">
                    <span>Главный офис</span>
                </div>
            </div>
            <div class="contacts mt-4">
                {if $company['creator']['city'] neq null}
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    <div class="row m-0">
                        <div class="col-12 col-sm pl-2 text-left">
                            <span class="name">{$company['creator']['city']}</span>
                        </div>
                    </div>
                </div>
                {/if}
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    <div class="row m-0">
                        <div class="col-12 col-sm pl-2 text-left">
                            <b class="name">{$company['creator']['name']}:</b> &nbsp;<span class="phone">{$company['creator']['phone']}
                        </div>
                    </div>
                    {if $company['creator']['phone2'] neq null && $company['creator']['name2'] neq null}
                    <div class="row m-0">
                        <div class="col-12 col-sm pl-2 text-left">
                            <b class="name">{$company['creator']['name2']}:</b> &nbsp;<span class="phone">{$company['creator']['phone2']}
                        </div>
                    </div>
                    {/if}
                    {if $company['creator']['phone3'] neq null && $company['creator']['name3'] neq null}
                    <div class="row m-0">
                        <div class="col-12 col-sm pl-2 text-left">
                            <b class="name">{$company['creator']['name3']}:</b> &nbsp;<span class="phone">{$company['creator']['phone3']}
                        </div>
                    </div>
                    {/if}
                </div>
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    <div class="row m-0">
                        <div class="col-12 col-sm pl-2 pr-2 text-left">
                            <b>Email:</b> &nbsp;<span class="email">{$company['creator']['email']}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {foreach from=$contacts item=arr key=depName}
        <div class="content-block trader-contact mx-sm-5 py-3 px-4">
            <div class="place d-flex justify-content-between">
                <div class="title">
                    <span>{$depName}</span>
                </div>
            </div>
            <div class="contacts mt-4">
                {foreach $arr as $contact}
                <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                    <div class="row m-0 px-3 px-sm-0">
                        <div class="col p-0">
                            {if $contact['dolg'] neq null}<b>{$contact['dolg']|strip_tags}:</b>{/if}{if $detect->isMobile()}<br>{/if} &nbsp;<span class="name">{if $contact['fio'] neq null}{$contact['fio']|strip_tags}{else}—{/if}</span>
                        </div>
                    </div>
                    <div class="row m-0 justify-content-center">
                        <div class="col-auto pr-2 text-center">
                            <b>Телефон:</b> &nbsp;<span class="phone">{if $contact['phone'] neq null}{$contact['phone']|strip_tags}{else}—{/if}</span>
                        </div>
                        {if $contact['email'] neq null}
                        <div class="col-auto pl-0 text-center">
                            <b>Email:</b> &nbsp;<span class="email">{if $contact['email'] neq null}{$contact['email']|strip_tags}{else}—{/if}</span>
                        </div>
                        {/if}
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
        {/foreach}
    </div>
@endsection
