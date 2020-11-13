@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.tariff.tariff_header')
    <div class="container mt-4 mb-5">
        <h2>Пополнить баланс</h2>
        <div class="row mt-4">
            <div class="col-sm-5">
                <div class="content-block pay-block px-4 pt-3 pb-5 pay-height">
                    <span class="d-block title">Введите сумму пополнения</span>
                    <div class="mt-4 pt-3 position-relative">
                        <input type="number" name="amount" class="d-block form-control amountInput" min="50" max="99999" maxlength="5" placeholder="50">
                        <span class="currency">ГРН</span>
                        <span class="tip-text mt-2 d-block">Минимальная сумма: 50грн</span>
                    </div>
                    <span class="step">Шаг 1</span>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="content-block pay-block px-4 py-3 pay-height">
                    <span class="d-block title">Выберите способ пополнения</span>
                    <div class="row mx-0 mt-3 d-flex align-items-center justify-content-center">
                        <div type="privat24" class="way d-flex flex-column col-auto align-items-center justify-content-center px-4 py-2">
                            <img src="/app/assets/img/p24.png" class="mt-1">
                            <span class="d-block name mt-1">Приват24</span>
                        </div>
                        <div type="card" class="way d-flex flex-column col-auto align-items-center justify-content-center px-4 py-2 ml-4">
                            <img src="/app/assets/img/card.png" class="mt-3">
                            <span class="d-block name mt-3">Картой</span>
                        </div>
                        <div type="act" class="way d-flex flex-column col-auto align-items-center justify-content-center px-5 py-2 ml-4">
            <span class="price mt-3">
            <span class="cost">0</span>
            <span class="currency-act ml-1 mt-1">ГРН</span>
            </span>
                            <span class="d-block name mt-3">Запросить счёт</span>
                        </div>
                    </div>
                    <span class="step">Шаг 2</span>
                </div>
            </div>
        </div>
        <div class="pay-act">
            <div class="mt-4 content-block pay-block px-4 pt-3 pb-3">
                <span class="d-block title">Сформировать счет на оплату <span class="who float-right"><a href="#" data-who="individual" class="active">Физ. лицо</a> | <a href="#" data-who="entity">Юр. лицо</a></span></span>
                <div class="pay-alert mt-4 px-4 py-3">
                    <span>Пополнение счета на сайте Agrotender.com.ua</span>
                    <span class="price">
        <span class="amount">50</span> <span>грн</span>
        </span>
                </div>
                <form class="form act-form mt-4" novalidate="novalidate">
                    <span class="field-title d-block my-4">Реквизиты на оплату:</span>
                    <div class="form-group row mb-3 mb-sm-4 who entity align-items-center">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Название компании:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="company" id="company" placeholder="Компания">
                        </div>
                    </div>
                    <div class="form-group row mb-3 mb-sm-4 who individual align-items-center">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Ф.И.О. плательщика (укр.):</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" placeholder="Фамилия Имя Отчество" name="name" id="name">
                        </div>
                    </div>
                    <div class="form-group row mb-3 mb-sm-4 align-items-center">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="+38 000 000 00 00" maxlength="18">
                        </div>
                    </div>
                    <div class="form-group row mb-3 mb-sm-4 who entity align-items-center">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Юридический адрес:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="entityAddr" id="entityAddr" placeholder="Адрес">
                        </div>
                    </div>
                    <div class="form-group row mb-3 mb-sm-4 who entity align-items-center">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Код ЕГРПОУ:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="code" id="code" placeholder="Код">
                        </div>
                    </div>
                    <div class="form-group row mb-3 mb-sm-4 who entity align-items-center">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Индивидуальный номер<br>плательщика НДС:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="inn" id="inn" placeholder="номер">
                        </div>
                    </div>
                    <span class="field-title d-block my-4 docs">Почтовый адрес для отправки документов:</span>
                    <div class="form-group row mb-3 mb-sm-4 who align-items-center docs">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Область:</label>
                        <div class="col-sm-5">
                            <select name="region" id="region" class="form-control">
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
                    <div class="form-group row mb-3 mb-sm-4 who align-items-center docs">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Населённый пункт:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="city" id="city" placeholder="Населённый пункт">
                        </div>
                    </div>
                    <div class="form-group row mb-3 mb-sm-4 who align-items-center docs">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Почтовый индекс:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="zip" id="zip" placeholder="Индекс">
                        </div>
                    </div>
                    <div class="form-group row mb-3 mb-sm-4 who align-items-center docs">
                        <label class="col-sm-4 col-form-label text-left text-sm-right">Адрес:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="addr" id="addr" placeholder="Адрес">
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox mt-3 who entity docAddrCheck">
                        <input class="custom-control-input" type="checkbox" value="1" name="docAddrCheck" id="docAddrCheck">
                        <label class="custom-control-label" for="docAddrCheck">
                            Указать адрес на который выслать бухгалтерские документы
                        </label>
                    </div>
                </form>
            </div>
            <div class="payFooter row mx-0 mt-5">
                <div class="col d-flex align-items-center justify-content-end px-0">
                    <button class="btn payBtn ml-4 px-5">Сформировать счет</button>
                </div>
            </div>
        </div>
    </div>
@endsection
