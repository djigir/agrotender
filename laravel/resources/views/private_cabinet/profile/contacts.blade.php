@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.profile.profile_header')
    <div class="container mt-4 mb-5">
        <div class="dep mx-sm-5 text-center text-sm-left">
            <a href="/u/contacts" class="active">Главный офис</a>
            <a href="/u/contacts?dep=1">Отдел закупок</a>
            <a href="/u/contacts?dep=2">Отдел продаж</a>
            <a href="/u/contacts?dep=3">Отдел услуг</a>
            <a href="/u/contacts?dep=999">Telegram/Viber</a>
        </div>
        <div class="content-block trader-contact mx-sm-5 py-3 px-4">
            <div class="place d-flex justify-content-between">
                <div class="title">
                    <span>Главный офис</span>
                </div>
            </div>
            <div class="contacts mt-4">
                <form class="main-dep" novalidate="novalidate">
                    <div class="form-group row mb-4 pb-1">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Контактное лицо:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" placeholder="Контактное лицо" name="name" value="Дмитрий">
                        </div>
                    </div>
                    <div class="form-group row mb-4 pb-1">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" placeholder="+38 000 000 00 00" name="phone" value="0502753289" disabled="" maxlength="18"> <a href="#" class="changePhone" data-toggle="modal" data-target="#changePhone"><i class="fas fa-pencil"></i></a>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-4 pb-1">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Контактное лицо:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" placeholder="Контактное лицо" name="name2" value="">
                        </div>
                    </div>
                    <div class="form-group row mb-4 pb-1">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" placeholder="+38 000 000 00 00" name="phone2" value="" maxlength="18">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-4 pb-1">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Контактное лицо:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" placeholder="Контактное лицо" name="name3" value="">
                        </div>
                    </div>
                    <div class="form-group row mb-4 pb-1">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" placeholder="+38 000 000 00 00" name="phone3" value="" maxlength="18">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-4 pb-1">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Email для публикаций:</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" placeholder="Email" name="publicEmail" value="dmitriy.thorzhevskii@gmail.com">
                        </div>
                    </div>
                    <div class="form-group row mb-4 pb-1">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Область:</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="region">
                                <option value="1">АР Крым</option>
                                <option value="2">Винницкая область</option>
                                <option value="3">Волынская область</option>
                                <option value="4">Днепропетровская область</option>
                                <option value="5">Донецкая область</option>
                                <option value="6">Житомирская область</option>
                                <option value="7">Закарпатская область</option>
                                <option value="8">Запорожская область</option>
                                <option value="9">Ивано-Франковская область</option>
                                <option value="10">Киевская область</option>
                                <option value="11">Кировоградская область</option>
                                <option value="12">Луганская область</option>
                                <option value="13">Львовская область</option>
                                <option value="14">Николаевская область</option>
                                <option value="15">Одесская область</option>
                                <option value="16">Полтавская область</option>
                                <option value="17">Ровенская область</option>
                                <option value="18">Сумская область</option>
                                <option value="19">Тернопольская область</option>
                                <option value="20">Харьковская область</option>
                                <option value="21">Херсонская область</option>
                                <option value="22">Хмельницкая область</option>
                                <option value="23">Черкасская область</option>
                                <option value="24">Черниговская область</option>
                                <option value="25">Черновицкая область</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4 pb-1">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Населённый пункт:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" placeholder="Населённый пункт" name="city" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-4 text-center">
            <button class="btn btn-primary save px-5">Сохранить</button>
        </div>
    </div>
@endsection
