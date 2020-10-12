@extends('layout.layout')

@section('content')
    <div id="popmechanic-snippet" style="height: 0; min-height: 0;"></div>
    <div style="position: absolute; opacity: 1; height: 100%;"><a href="http://novaagro.com.ua/" id="body444" class="sidesLink bodyBanners" style="background: url(&quot;/files/pict/novaagro_body4-5.jpg&quot;); display: inline-table; height: 0%; width: 471px;" rel="nofollow" target="_blank"> <img src="/files/pict/novaagro_body4-5.jpg" alt="" style=""> <canvas width="471" height="1059" style="right: calc((100vw - 978px) / 1.92 + 958px); position: fixed; height: 100%; top: 0px; cursor: pointer; z-index: 1;"></canvas></a></div>
    <div style="position: absolute; opacity: 1; height: 100%;"><a href="http://novaagro.com.ua/" id="body444" class="sidesLink bodyBanners" style="background: url(&quot;/files/pict/novaagro_body4-5.jpg&quot;) right center; display: inline-table; height: 0%; width: 471px;" rel="nofollow" target="_blank"> <img src="/files/pict/novaagro_body4-5.jpg" alt="" style=""> <canvas width="471" height="1059" style="left: calc((100vw - 978px) / 1.92 + 958px); position: fixed; height: 100%; top: 0px; cursor: pointer; z-index: 1;"></canvas></a></div>
    <main class="main" role="main" data-page="main/companies-s">
        <div id="loading" style="display: none;">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>

        <div class="container text-center mt-3 mb-3 tradersImages position-relative">
            <div class="d-block d-sm-inline-block tradersImgBlock"><noindex><a class="topBanners" href="https://agrotender.com.ua/kompanii/comp-5529" rel="nofollow"><img style="width:310px; height:70px;" id="topBan460" src="/files/pict/tg_image_3314200872.jpeg" class="img-responsive tradersImg" alt=""></a></noindex></div>
            <div class="d-block d-sm-inline-block tradersImgBlock"><noindex><a class="topBanners" href="http://zernotrans.com.ua" rel="nofollow" target="_blank"><img style="width:310px; height:70px;" id="topBan403" src="/files/pict/zernotlans_light.jpg" class="img-responsive tradersImg" alt=""></a></noindex></div>
            <div class="d-block d-sm-inline-block tradersImgBlock"><noindex><a class="topBanners" href="https://agrotender.com.ua/kompanii/comp-812.html" rel="nofollow"><img style="width:310px; height:70px;" id="topBan325" src="/files/pict/Virtus370x100_tel-.png" class="img-responsive tradersImg" alt=""></a></noindex></div>
        </div>
        <div class="filters-wrap">
            <div class="filters-inner">
                <div class="filters arrow-t">
                    <div class="step-1 stp">
                        <div class="mt-3">
                            <span class="title ml-3 pt-3">Настройте фильтры:</span>
                        </div>
                        <div class="position-relative mt-3">
                            <input type="text" class="pl-4 pr-5 py-4 content-block filter-search" placeholder="Я ищу.." value="j">
                            <i class="far fa-search searchFilterIcon"></i>
                        </div>
                        <a class="mt-4 p-4 content-block filter filter-rubric d-flex justify-content-between" href="#" rubric="0">
                            <span>Выберите рубрику</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </a>
                        <a class="mt-4 p-4 content-block filter filter-region d-flex justify-content-between" href="#" region="0 ">
                            <span>Вся Украина</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </a>
                        <a class="show showCompanies" href="#">
                            Показать компании
                        </a>
                    </div>
                    <div class="step-3 stp h-100">
                        <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
                        <div class="scroll">
                            <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="1">
                                <span>Сельхоз производители</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="2">
                                <span>Переработчики</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="3">
                                <span>Техника и оборудование</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="4">
                                <span>Агрохимия</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="5">
                                <span>Закупка и реализация</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="6">
                                <span>Перевозки</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="7">
                                <span>Услуги</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="step-3-1 stp h-100">
                        <a class="back py-3 px-4 content-block d-block" step="3" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
                        <div class="scroll">
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="10">
                                <span>Зерновые &nbsp;<span class="companyCount small">(1546)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="11">
                                <span>Масличные  &nbsp;<span class="companyCount small">(1179)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="12">
                                <span>Бобовые &nbsp;<span class="companyCount small">(754)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="13">
                                <span>Овощеводство &nbsp;<span class="companyCount small">(328)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="14">
                                <span>Фрукты  и ягоды &nbsp;<span class="companyCount small">(341)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="21">
                                <span>Посевматериал &nbsp;<span class="companyCount small">(335)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="16">
                                <span>Свиноводство &nbsp;<span class="companyCount small">(126)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="18">
                                <span>КРС &nbsp;<span class="companyCount small">(105)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="17">
                                <span>Кролиководство &nbsp;<span class="companyCount small">(25)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="15">
                                <span>Птицефабрики &nbsp;<span class="companyCount small">(133)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="20">
                                <span>Рыбоводство &nbsp;<span class="companyCount small">(83)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="22">
                                <span>Молодняк животных &nbsp;<span class="companyCount small">(52)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-1" rubricid="19">
                                <span>Пчеловодство &nbsp;<span class="companyCount small">(125)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-2" rubricid="29">
                                <span>Грануляция &nbsp;<span class="companyCount small">(265)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-2" rubricid="23">
                                <span>Комбикормовые заводы &nbsp;<span class="companyCount small">(243)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-2" rubricid="30">
                                <span>Крупорушки &nbsp;<span class="companyCount small">(146)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-2" rubricid="24">
                                <span>Мельницы &nbsp;<span class="companyCount small">(281)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-2" rubricid="32">
                                <span>Молоковозаводы &nbsp;<span class="companyCount small">(49)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-2" rubricid="25">
                                <span>МЭЗы и Маслозаводы &nbsp;<span class="companyCount small">(347)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-2" rubricid="27">
                                <span>Переработка мяса &nbsp;<span class="companyCount small">(76)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-2" rubricid="31">
                                <span>Пивоварни, Ликеро-водочные заводы &nbsp;<span class="companyCount small">(27)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-2" rubricid="28">
                                <span>Сахарные заводы &nbsp;<span class="companyCount small">(90)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-2" rubricid="33">
                                <span>Фасовка &nbsp;<span class="companyCount small">(257)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-2" rubricid="26">
                                <span>Хлебозаводы, пекарни и кондитерки &nbsp;<span class="companyCount small">(106)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-3" rubricid="41">
                                <span>ГСМ &nbsp;<span class="companyCount small">(437)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-3" rubricid="36">
                                <span>Оборудование для животноводства &nbsp;<span class="companyCount small">(246)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-3" rubricid="40">
                                <span>Оборудование для переработки &nbsp;<span class="companyCount small">(377)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-3" rubricid="37">
                                <span>Оборудование для пчеловодства &nbsp;<span class="companyCount small">(42)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-3" rubricid="35">
                                <span>Оборудование для растениеводства &nbsp;<span class="companyCount small">(282)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-3" rubricid="38">
                                <span>Оборудование для рыбоводства &nbsp;<span class="companyCount small">(43)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-3" rubricid="39">
                                <span>Оборудование для хранения &nbsp;<span class="companyCount small">(352)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-3" rubricid="34">
                                <span>Производители сельхозтехники &nbsp;<span class="companyCount small">(471)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-4" rubricid="42">
                                <span>Средства защиты &nbsp;<span class="companyCount small">(451)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-4" rubricid="4">
                                <span>Удобрения &nbsp;<span class="companyCount small">(653)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-5" rubricid="47">
                                <span>Корма для животных &nbsp;<span class="companyCount small">(527)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-5" rubricid="46">
                                <span>Торговля Агрохимией &nbsp;<span class="companyCount small">(456)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-5" rubricid="44">
                                <span>Торговля продукцией животноводства &nbsp;<span class="companyCount small">(255)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-5" rubricid="43">
                                <span>Торговля сельхозпродукцией &nbsp;<span class="companyCount small">(1995)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-5" rubricid="45">
                                <span>Торговля сельхозтехникой и оборудованием &nbsp;<span class="companyCount small">(778)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-6" rubricid="48">
                                <span>Автотранспорт &nbsp;<span class="companyCount small">(845)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-6" rubricid="49">
                                <span>Ж/Д транспорт &nbsp;<span class="companyCount small">(283)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-6" rubricid="50">
                                <span>Морской транспорт &nbsp;<span class="companyCount small">(182)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-7" rubricid="51">
                                <span>Хранение урожая &nbsp;<span class="companyCount small">(450)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-7" rubricid="52">
                                <span>Посев и уборка урожая &nbsp;<span class="companyCount small">(211)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-7" rubricid="53">
                                <span>Строительство &nbsp;<span class="companyCount small">(376)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-7" rubricid="54">
                                <span>Ремонт &nbsp;<span class="companyCount small">(470)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-7" rubricid="55">
                                <span>Юридические услуги &nbsp;<span class="companyCount small">(139)</span></span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="step-4 stp h-100">
                        <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
                        <div class="scroll">
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="0">
                                <span>Вся Украина</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="vinnica">
                                <span>Винницкая область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="volin">
                                <span>Волынская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="dnepr">
                                <span>Днепропетровская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="donetsk">
                                <span>Донецкая область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="zhitomir">
                                <span>Житомирская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="zakorpat">
                                <span>Закарпатская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="zaporizh">
                                <span>Запорожская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="ivanofrank">
                                <span>Ивано-Франковская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="kyiv">
                                <span>Киевская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="kirovograd">
                                <span>Кировоградская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="lugansk">
                                <span>Луганская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="lviv">
                                <span>Львовская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="nikolaev">
                                <span>Николаевская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="odessa">
                                <span>Одесская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="poltava">
                                <span>Полтавская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="rovno">
                                <span>Ровенская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="sumy">
                                <span>Сумская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="ternopil">
                                <span>Тернопольская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="kharkov">
                                <span>Харьковская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="kherson">
                                <span>Херсонская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="khmelnitsk">
                                <span>Хмельницкая область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="cherkassi">
                                <span>Черкасская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="chernigov">
                                <span>Черниговская область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                            <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="chernovci">
                                <span>Черновицкая область</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none d-sm-block container mt-3">
            <ol class="breadcrumbs small p-0">
                <li><a href="/">Главная</a></li>
                <i class="fas fa-chevron-right extra-small"></i>
                <li><h1>Компании в Украине</h1></li>
            </ol>
            <div class="content-block mt-3 py-3 px-4">
                <div class="form-row align-items-center position-relative">
                    <div class="col-3 mr-2">
                        <button class="btn rubricInput text-center drop-btn">Все рубрики <i class="ml-2 small far fa-chevron-down"></i></button>
                    </div>
                    <div class="dropdown-wrapper position-absolute rubricDrop">
                        <div class="dropdown">
                            <div class="section text-left">
                                <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                                <div class="row">
                                    <div class="col-auto">
                                        <a class="rubricLink getRubricGroup" href="#" group="1">
                    <span>
                      Сельхоз производители
                      <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                  </span></a>
                                        <a class="rubricLink getRubricGroup" href="#" group="2">
                    <span>
                      Переработчики
                      <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                  </span></a>
                                        <a class="rubricLink getRubricGroup" href="#" group="3">
                    <span>
                      Техника и оборудование
                      <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                  </span></a>
                                        <a class="rubricLink getRubricGroup" href="#" group="4">
                    <span>
                      Агрохимия
                      <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                  </span></a>
                                        <a class="rubricLink getRubricGroup" href="#" group="5">
                    <span>
                      Закупка и реализация
                      <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                  </span></a>
                                        <a class="rubricLink getRubricGroup" href="#" group="6">
                    <span>
                      Перевозки
                      <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                  </span></a>
                                        <a class="rubricLink getRubricGroup" href="#" group="7">
                    <span>
                      Услуги
                      <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                  </span></a>
                                    </div>
                                    <div class="col-auto rubricGroup pr-0 mr-3 group-1">
                                        <a class="regionLink" href="/kompanii/region_ukraine/t10">
                                            <span>Зерновые</span>
                                            <span class="companyCount small">(1546)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t11">
                                            <span>Масличные </span>
                                            <span class="companyCount small">(1179)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t12">
                                            <span>Бобовые</span>
                                            <span class="companyCount small">(754)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t13">
                                            <span>Овощеводство</span>
                                            <span class="companyCount small">(328)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t14">
                                            <span>Фрукты  и ягоды</span>
                                            <span class="companyCount small">(341)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t21">
                                            <span>Посевматериал</span>
                                            <span class="companyCount small">(335)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t16">
                                            <span>Свиноводство</span>
                                            <span class="companyCount small">(126)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                    <div class="col-auto rubricGroup pr-0 mr-3 group-1">
                                        <a class="regionLink" href="/kompanii/region_ukraine/t18">
                                            <span>КРС</span>
                                            <span class="companyCount small">(105)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t17">
                                            <span>Кролиководство</span>
                                            <span class="companyCount small">(25)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t15">
                                            <span>Птицефабрики</span>
                                            <span class="companyCount small">(133)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t20">
                                            <span>Рыбоводство</span>
                                            <span class="companyCount small">(83)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t22">
                                            <span>Молодняк животных</span>
                                            <span class="companyCount small">(52)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t19">
                                            <span>Пчеловодство</span>
                                            <span class="companyCount small">(125)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                    <div class="col-auto rubricGroup pr-0 mr-3 group-2">
                                        <a class="regionLink" href="/kompanii/region_ukraine/t29">
                                            <span>Грануляция</span>
                                            <span class="companyCount small">(265)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t23">
                                            <span>Комбикормовые заводы</span>
                                            <span class="companyCount small">(243)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t30">
                                            <span>Крупорушки</span>
                                            <span class="companyCount small">(146)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t24">
                                            <span>Мельницы</span>
                                            <span class="companyCount small">(281)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t32">
                                            <span>Молоковозаводы</span>
                                            <span class="companyCount small">(49)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t25">
                                            <span>МЭЗы и Маслозаводы</span>
                                            <span class="companyCount small">(347)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t27">
                                            <span>Переработка мяса</span>
                                            <span class="companyCount small">(76)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                    <div class="col-auto rubricGroup pr-0 mr-3 group-2">
                                        <a class="regionLink" href="/kompanii/region_ukraine/t31">
                                            <span data-toggle="tooltip" data-placement="top" title="Пивоварни, Ликеро-водочные заводы">Пивоварни, Ликеро-водочны..</span>
                                            <span class="companyCount small">(27)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t28">
                                            <span>Сахарные заводы</span>
                                            <span class="companyCount small">(90)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t33">
                                            <span>Фасовка</span>
                                            <span class="companyCount small">(257)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t26">
                                            <span data-toggle="tooltip" data-placement="top" title="Хлебозаводы, пекарни и кондитерки">Хлебозаводы, пекарни и ко..</span>
                                            <span class="companyCount small">(106)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                    <div class="col-auto rubricGroup pr-0 mr-3 group-3">
                                        <a class="regionLink" href="/kompanii/region_ukraine/t41">
                                            <span>ГСМ</span>
                                            <span class="companyCount small">(437)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t36">
                                            <span data-toggle="tooltip" data-placement="top" title="Оборудование для животноводства">Оборудование для животнов..</span>
                                            <span class="companyCount small">(246)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t40">
                                            <span data-toggle="tooltip" data-placement="top" title="Оборудование для переработки">Оборудование для перерабо..</span>
                                            <span class="companyCount small">(377)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t37">
                                            <span data-toggle="tooltip" data-placement="top" title="Оборудование для пчеловодства">Оборудование для пчеловод..</span>
                                            <span class="companyCount small">(42)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t35">
                                            <span data-toggle="tooltip" data-placement="top" title="Оборудование для растениеводства">Оборудование для растение..</span>
                                            <span class="companyCount small">(282)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t38">
                                            <span data-toggle="tooltip" data-placement="top" title="Оборудование для рыбоводства">Оборудование для рыбоводс..</span>
                                            <span class="companyCount small">(43)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t39">
                                            <span>Оборудование для хранения</span>
                                            <span class="companyCount small">(352)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                    <div class="col-auto rubricGroup pr-0 mr-3 group-3">
                                        <a class="regionLink" href="/kompanii/region_ukraine/t34">
                                            <span data-toggle="tooltip" data-placement="top" title="Производители сельхозтехники">Производители сельхозтехн..</span>
                                            <span class="companyCount small">(471)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                    <div class="col-auto rubricGroup pr-0 mr-3 group-4">
                                        <a class="regionLink" href="/kompanii/region_ukraine/t42">
                                            <span>Средства защиты</span>
                                            <span class="companyCount small">(451)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t4">
                                            <span>Удобрения</span>
                                            <span class="companyCount small">(653)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                    <div class="col-auto rubricGroup pr-0 mr-3 group-5">
                                        <a class="regionLink" href="/kompanii/region_ukraine/t47">
                                            <span>Корма для животных</span>
                                            <span class="companyCount small">(527)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t46">
                                            <span>Торговля Агрохимией</span>
                                            <span class="companyCount small">(456)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t44">
                                            <span data-toggle="tooltip" data-placement="top" title="Торговля продукцией животноводства">Торговля продукцией живот..</span>
                                            <span class="companyCount small">(255)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t43">
                                            <span>Торговля сельхозпродукцией</span>
                                            <span class="companyCount small">(1995)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t45">
                                            <span data-toggle="tooltip" data-placement="top" title="Торговля сельхозтехникой и оборудованием">Торговля сельхозтехникой ..</span>
                                            <span class="companyCount small">(778)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                    <div class="col-auto rubricGroup pr-0 mr-3 group-6">
                                        <a class="regionLink" href="/kompanii/region_ukraine/t48">
                                            <span>Автотранспорт</span>
                                            <span class="companyCount small">(845)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t49">
                                            <span>Ж/Д транспорт</span>
                                            <span class="companyCount small">(283)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t50">
                                            <span>Морской транспорт</span>
                                            <span class="companyCount small">(182)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                    <div class="col-auto rubricGroup pr-0 mr-3 group-7">
                                        <a class="regionLink" href="/kompanii/region_ukraine/t51">
                                            <span>Хранение урожая</span>
                                            <span class="companyCount small">(450)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t52">
                                            <span>Посев и уборка урожая</span>
                                            <span class="companyCount small">(211)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t53">
                                            <span>Строительство</span>
                                            <span class="companyCount small">(376)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t54">
                                            <span>Ремонт</span>
                                            <span class="companyCount small">(470)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ukraine/t55">
                                            <span>Юридические услуги</span>
                                            <span class="companyCount small">(139)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 mr-2">
                        <button class="btn regionInput text-center drop-btn">Вся Украина<i class="ml-2 small far fa-chevron-down"></i></button>
                    </div>
                    <div class="dropdown-wrapper position-absolute regionDrop">
                        <div class="dropdown">
            <span class="d-block">
              <a class="regionLink d-inline-block text-muted disabled" href="/kompanii/region_ukraine/index">
              <span>Вся Украина</span>
                  <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
              </a>
              <a class="regionLink d-inline-block" href="/kompanii/region_crimea/index">
              <span>АР Крым</span>
                  <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
              </a>
            </span>
                            <hr class="mt-1 mb-2">
                            <div class="section text-left">
                                <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                                <div class="row">
                                    <div class="col">
                                        <a class="regionLink" href="/kompanii/region_vinnica/index">
                                            <span>Винницкая область</span>
                                            <span class="companyCount small">(180)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_volin/index">
                                            <span>Волынская область</span>
                                            <span class="companyCount small">(71)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_dnepr/index">
                                            <span>Днепропетровская область</span>
                                            <span class="companyCount small">(683)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_donetsk/index">
                                            <span>Донецкая область</span>
                                            <span class="companyCount small">(102)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_zhitomir/index">
                                            <span>Житомирская область</span>
                                            <span class="companyCount small">(112)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_zakorpat/index">
                                            <span>Закарпатская область</span>
                                            <span class="companyCount small">(26)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_zaporizh/index">
                                            <span>Запорожская область</span>
                                            <span class="companyCount small">(351)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ivanofrank/index">
                                            <span>Ивано-Франковская область</span>
                                            <span class="companyCount small">(43)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="regionLink" href="/kompanii/region_kyiv/index">
                                            <span>Киевская область</span>
                                            <span class="companyCount small">(1688)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_kirovograd/index">
                                            <span>Кировоградская область</span>
                                            <span class="companyCount small">(216)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_lugansk/index">
                                            <span>Луганская область</span>
                                            <span class="companyCount small">(37)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_lviv/index">
                                            <span>Львовская область</span>
                                            <span class="companyCount small">(117)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_nikolaev/index">
                                            <span>Николаевская область</span>
                                            <span class="companyCount small">(272)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_odessa/index">
                                            <span>Одесская область</span>
                                            <span class="companyCount small">(517)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_poltava/index">
                                            <span>Полтавская область</span>
                                            <span class="companyCount small">(210)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_rovno/index">
                                            <span>Ровенская область</span>
                                            <span class="companyCount small">(71)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="regionLink" href="/kompanii/region_sumy/index">
                                            <span>Сумская область</span>
                                            <span class="companyCount small">(135)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_ternopil/index">
                                            <span>Тернопольская область</span>
                                            <span class="companyCount small">(61)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_kharkov/index">
                                            <span>Харьковская область</span>
                                            <span class="companyCount small">(574)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_kherson/index">
                                            <span>Херсонская область</span>
                                            <span class="companyCount small">(190)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_khmelnitsk/index">
                                            <span>Хмельницкая область</span>
                                            <span class="companyCount small">(84)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_cherkassi/index">
                                            <span>Черкасская область</span>
                                            <span class="companyCount small">(251)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_chernigov/index">
                                            <span>Черниговская область</span>
                                            <span class="companyCount small">(123)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                        <a class="regionLink" href="/kompanii/region_chernovci/index">
                                            <span>Черновицкая область</span>
                                            <span class="companyCount small">(19)</span>
                                            <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col searchDiv" data-tip="Введите поисковой запрос">
                        <form class="searchForm">
                            <input maxlength="32" type="text" name="text" class="searchInput" placeholder="Я ищу.." value="j">
                        </form>
                    </div>
                    <div class="col-auto">
                        <i class="far fa-search searchIcon mt-2 ml-2"></i>
                    </div>
                </div>
            </div>
            <div class="row mt-4 pt-3">
                <div class="col-12 col-sm-4 float-left mt-4 mt-md-0 d-flex d-sm-block">
                    <h2 class="d-inline-block text-uppercase">Поиск: j</h2>
                    <a href="/tarif20.html" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
                </div>
                <div class="col-12 col-sm-8 float-md-right text-center text-md-right">
                    <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end">
                        <i class="far fa-plus mr-2"></i>
                        <span class="pl-1 pr-1">Разместить компанию</span>
                    </a>
                    <!-- <a href="/add_buy_trader" class="top-btn btn btn-warning align-items-end">
                      <span class="pt-1"><i class="far fa-plus mr-2"></i> Разместить компанию</span>
                    </a> -->
                </div>
            </div>
        </div>
        <div class="container pb-4 companies">
            <div class="row content-block companyItem mx-0 mt-4 pt-3 pb-1 py-sm-3 px-1 companyTop " }="">
                <div class="row mx-0 w-100">
                    <div class="col-auto pr-0 pl-2 pl-sm-3">
                        <div class="row m-0">
                            <div class="col-12 pl-0 pr-0 pr-sm-2">
                                <a href="/kompanii/comp-820"><img class="companyImg" src="/pics/comp/820_83166.jpg"></a>
                            </div>
                        </div>
                        <div class="row m-0 pt-3 d-none d-sm-flex">
                            <div class="col-12 pl-0 pr-2 text-center">
                                <span class="date">На сайте с Фев. 2015</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row lh-1">
                            <div class="col">
                                <span class="title"><a href="/kompanii/comp-820">Smart Trade</a></span>
                            </div>
                        </div>
                        <div class="row d-sm-none lh-1">
                            <div class="col">
                                <span class="date mb-2">На сайте с Фев. 2015</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col mt-1">
                                <p class="desc"><span style="color: rgb(0, 0, 0); font-family: Verdana, Arial, Helvetica, sans-serif; font-size: medium; line-height: 16px; text-align: justify;">Компания Smart Trade специализируется</span></p>
                            </div>
                        </div>
                        <div class="row lh-1-2">
                            <div class="col">
                                <span class="a-bold d-none d-sm-inline-block">Виды деятельности:</span>
                                <span class="activities d-none d-sm-block">Торговля сельхозпродукцией</span>
                                <span class="activities d-block d-sm-none">Торговля сельхозпродукцией</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col pt-2 mt-1">
                                <a class="link" href="/kompanii/comp-820-prices"><span>Цены Трейдера</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block col-md-3">
                        <div class="companySticker">
                            <span>380673234051</span>
                        </div>
                    </div>
                </div>
                <div class="row mx-0 d-sm-none lh-1 w-100">
                    <div class="col mt-2 text-center">
                        <a class="link" href="/kompanii/comp-820-prices"><span>Цены Трейдера</span></a>
                    </div>
                </div>
            </div>
            <div class="row content-block companyItem mx-0 mt-4 pt-3 pb-1 py-sm-3 px-1 companyTop " }="">
                <div class="row mx-0 w-100">
                    <div class="col-auto pr-0 pl-2 pl-sm-3">
                        <div class="row m-0">
                            <div class="col-12 pl-0 pr-0 pr-sm-2">
                                <a href="/kompanii/comp-1020"><img class="companyImg" src="/pics/comp/1020_85359.jpg"></a>
                            </div>
                        </div>
                        <div class="row m-0 pt-3 d-none d-sm-flex">
                            <div class="col-12 pl-0 pr-2 text-center">
                                <span class="date">На сайте с Июл. 2015</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row lh-1">
                            <div class="col">
                                <span class="title"><a href="/kompanii/comp-1020">Klam Oliya</a></span>
                            </div>
                        </div>
                        <div class="row d-sm-none lh-1">
                            <div class="col">
                                <span class="date mb-2">На сайте с Июл. 2015</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col mt-1">
                                <p class="desc">ООО «Klam Oliya» является украинской компанией, специализирующейся на оптовой торговле продуктами переработки масличных культур, а именно: нерафинированного подсолнечного масла 1 сорта, шрота</p>
                            </div>
                        </div>
                        <div class="row lh-1-2">
                            <div class="col">
                                <span class="a-bold d-none d-sm-inline-block">Виды деятельности:</span>
                                <span class="activities d-none d-sm-block">Зерновые, Масличные , Торговля сельхозпродукцией</span>
                                <span class="activities d-block d-sm-none">Зерновые, Масличные , Торговля сельхозпродукцией</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col pt-2 mt-1">
                                <a class="link" href="/kompanii/comp-1020-prices"><span>Цены Трейдера</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block col-md-3">
                        <div class="companySticker">
                            <span>380670061177</span>
                        </div>
                    </div>
                </div>
                <div class="row mx-0 d-sm-none lh-1 w-100">
                    <div class="col mt-2 text-center">
                        <a class="link" href="/kompanii/comp-1020-prices"><span>Цены Трейдера</span></a>
                    </div>
                </div>
            </div>
            <div class="row content-block companyItem mx-0 mt-4 pt-3 pb-1 py-sm-3 px-1  " }="">
                <div class="row mx-0 w-100">
                    <div class="col-auto pr-0 pl-2 pl-sm-3">
                        <div class="row m-0">
                            <div class="col-12 pl-0 pr-0 pr-sm-2">
                                <a href="/kompanii/comp-2702"><img class="companyImg" src="/pics/comp/2702_80537.jpg"></a>
                            </div>
                        </div>
                        <div class="row m-0 pt-3 d-none d-sm-flex">
                            <div class="col-12 pl-0 pr-2 text-center">
                                <span class="date">На сайте с Окт. 2016</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row lh-1">
                            <div class="col">
                                <span class="title"><a href="/kompanii/comp-2702">Зерновая База</a></span>
                            </div>
                        </div>
                        <div class="row d-sm-none lh-1">
                            <div class="col">
                                <span class="date mb-2">На сайте с Окт. 2016</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col mt-1">
                                <p class="desc">Торговая компания «Зерновая База» занимается реализацией преимущественно зерновых и масличных культур, основное место здесь занимают пшеница, овес, кукуруза, соя, подсолнечник. Все сырье</p>
                            </div>
                        </div>
                        <div class="row lh-1-2">
                            <div class="col">
                                <span class="a-bold d-none d-sm-inline-block">Виды деятельности:</span>
                                <span class="activities d-none d-sm-block">Мельницы, Торговля сельхозпродукцией, Хранение урожая</span>
                                <span class="activities d-block d-sm-none">Мельницы, Торговля сельхозпродукцией, Хранение урожая</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col pt-2 mt-1">
                                <a class="link" href="/kompanii/comp-2702-prices"><span>Цены Трейдера</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block col-md-3">
                        <div class="companySticker">
                            <span>380639976269</span>
                        </div>
                    </div>
                </div>
                <div class="row mx-0 d-sm-none lh-1 w-100">
                    <div class="col mt-2 text-center">
                        <a class="link" href="/kompanii/comp-2702-prices"><span>Цены Трейдера</span></a>
                    </div>
                </div>
            </div>
            <div class="row content-block companyItem mx-0 mt-4 pt-3 pb-1 py-sm-3 px-1  " }="">
                <div class="row mx-0 w-100">
                    <div class="col-auto pr-0 pl-2 pl-sm-3">
                        <div class="row m-0">
                            <div class="col-12 pl-0 pr-0 pr-sm-2">
                                <a href="/kompanii/comp-807"><img class="companyImg" src="/pics/c/yKRnRhlrVYeG.jpg"></a>
                            </div>
                        </div>
                        <div class="row m-0 pt-3 d-none d-sm-flex">
                            <div class="col-12 pl-0 pr-2 text-center">
                                <span class="date">На сайте с Фев. 2015</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row lh-1">
                            <div class="col">
                                <span class="title"><a href="/kompanii/comp-807">КАИС</a></span>
                            </div>
                        </div>
                        <div class="row d-sm-none lh-1">
                            <div class="col">
                                <span class="date mb-2">На сайте с Фев. 2015</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col mt-1">
                                <p class="desc"></p><p style="color: rgb(0, 0, 0); font-family: Arial, sans-serif; font-size: 14px; text-align: justify;">
                                    УАСП ООО «КАИС» - стабильная и динамичная зерноторговая</p>
                            </div>
                        </div>
                        <div class="row lh-1-2">
                            <div class="col">
                                <span class="a-bold d-none d-sm-inline-block">Виды деятельности:</span>
                                <span class="activities d-none d-sm-block">Зерновые, Масличные , Торговля сельхозпродукцией</span>
                                <span class="activities d-block d-sm-none">Зерновые, Масличные , Торговля сельхозпродукцией</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col pt-2 mt-1">
                                <a class="link" href="/kompanii/comp-807-prices"><span>Цены Трейдера</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block col-md-3">
                        <div class="companySticker">
                            <span>380992126704</span>
                            <span>380675764997</span>
                            <span>380677101430</span>
                        </div>
                    </div>
                </div>
                <div class="row mx-0 d-sm-none lh-1 w-100">
                    <div class="col mt-2 text-center">
                        <a class="link" href="/kompanii/comp-807-prices"><span>Цены Трейдера</span></a>
                    </div>
                </div>
            </div>
            <div class="row content-block companyItem mx-0 mt-4 pt-3 pb-1 py-sm-3 px-1  " }="">
                <div class="row mx-0 w-100">
                    <div class="col-auto pr-0 pl-2 pl-sm-3">
                        <div class="row m-0">
                            <div class="col-12 pl-0 pr-0 pr-sm-2">
                                <a href="/kompanii/comp-2062"><img class="companyImg" src="/pics/comp/2062_77022.jpg"></a>
                            </div>
                        </div>
                        <div class="row m-0 pt-3 d-none d-sm-flex">
                            <div class="col-12 pl-0 pr-2 text-center">
                                <span class="date">На сайте с Июл. 2016</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row lh-1">
                            <div class="col">
                                <span class="title"><a href="/kompanii/comp-2062">Агроресурс</a></span>
                            </div>
                        </div>
                        <div class="row d-sm-none lh-1">
                            <div class="col">
                                <span class="date mb-2">На сайте с Июл. 2016</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col mt-1">
                                <p class="desc">Компания "Агроресурс"&nbsp;- основана в 1996 году, сегодня является одним из основных операторов на ринке Украини и представляет широкий вибор сельскохозяйственной техники, запасных частей,</p>
                            </div>
                        </div>
                        <div class="row lh-1-2">
                            <div class="col">
                                <span class="a-bold d-none d-sm-inline-block">Виды деятельности:</span>
                                <span class="activities d-none d-sm-block" data-toggle="tooltip" data-placement="top" title="Средства защиты, Удобрения, Торговля сельхозпродукцией, Торговля сельхозтехникой и оборудованием, Хранение урожая">Средства защиты, Удобрения, Торговля сельхозпродукцией, Торговля сельхозт..</span>
                                <span class="activities d-block d-sm-none" data-toggle="tooltip" data-placement="top" title="Средства защиты, Удобрения, Торговля сельхозпродукцией, Торговля сельхозтехникой и оборудованием, Хранение урожая">Средства защиты, Удобрения, Торговля сельхозпродукцией,..</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col pt-2 mt-1">
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block col-md-3">
                        <div class="companySticker">
                            <span>0504533130</span>
                            <span>0504533130</span>
                            <span>(0522) 359035</span>
                        </div>
                    </div>
                </div>
                <div class="row mx-0 d-sm-none lh-1 w-100">
                    <div class="col mt-2 text-center">
                    </div>
                </div>
            </div>
            <div class="row content-block companyItem mx-0 mt-4 pt-3 pb-1 py-sm-3 px-1  " }="">
                <div class="row mx-0 w-100">
                    <div class="col-auto pr-0 pl-2 pl-sm-3">
                        <div class="row m-0">
                            <div class="col-12 pl-0 pr-0 pr-sm-2">
                                <a href="/kompanii/comp-1144"><img class="companyImg" src="/pics/comp/1144_65559.jpg"></a>
                            </div>
                        </div>
                        <div class="row m-0 pt-3 d-none d-sm-flex">
                            <div class="col-12 pl-0 pr-2 text-center">
                                <span class="date">На сайте с Сен. 2015</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row lh-1">
                            <div class="col">
                                <span class="title"><a href="/kompanii/comp-1144">ГРІН АГРО ПЛЮС</a></span>
                            </div>
                        </div>
                        <div class="row d-sm-none lh-1">
                            <div class="col">
                                <span class="date mb-2">На сайте с Сен. 2015</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col mt-1">
                                <p class="desc">Описание</p>
                            </div>
                        </div>
                        <div class="row lh-1-2">
                            <div class="col">
                                <span class="a-bold d-none d-sm-inline-block">Виды деятельности:</span>
                                <span class="activities d-none d-sm-block">Торговля сельхозпродукцией, Хранение урожая</span>
                                <span class="activities d-block d-sm-none">Торговля сельхозпродукцией, Хранение урожая</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col pt-2 mt-1">
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block col-md-3">
                        <div class="companySticker">
                            <span>+380500000000</span>
                        </div>
                    </div>
                </div>
                <div class="row mx-0 d-sm-none lh-1 w-100">
                    <div class="col mt-2 text-center">
                    </div>
                </div>
            </div>
            <div class="row content-block companyItem mx-0 mt-4 pt-3 pb-1 py-sm-3 px-1  " }="">
                <div class="row mx-0 w-100">
                    <div class="col-auto pr-0 pl-2 pl-sm-3">
                        <div class="row m-0">
                            <div class="col-12 pl-0 pr-0 pr-sm-2">
                                <a href="/kompanii/comp-942"><img class="companyImg" src="/pics/comp/942_42750.jpg"></a>
                            </div>
                        </div>
                        <div class="row m-0 pt-3 d-none d-sm-flex">
                            <div class="col-12 pl-0 pr-2 text-center">
                                <span class="date">На сайте с Май. 2015</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row lh-1">
                            <div class="col">
                                <span class="title"><a href="/kompanii/comp-942">РИВ.А.ХОЛДИНГ</a></span>
                            </div>
                        </div>
                        <div class="row d-sm-none lh-1">
                            <div class="col">
                                <span class="date mb-2">На сайте с Май. 2015</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col mt-1">
                                <p class="desc">ООО «Рив.А.Холдинг» – &nbsp;мощная многопрофильная и динамично развивающаяся компания, успешно работающая на рынке с 2000 года. С первых дней деятельности «Рив.А.Холдинг»</p>
                            </div>
                        </div>
                        <div class="row lh-1-2">
                            <div class="col">
                                <span class="a-bold d-none d-sm-inline-block">Виды деятельности:</span>
                                <span class="activities d-none d-sm-block" data-toggle="tooltip" data-placement="top" title="Зерновые, Масличные , Торговля сельхозпродукцией, Автотранспорт, Хранение урожая">Зерновые, Масличные , Торговля сельхозпродукцией, Автотранспорт, Хранение..</span>
                                <span class="activities d-block d-sm-none" data-toggle="tooltip" data-placement="top" title="Зерновые, Масличные , Торговля сельхозпродукцией, Автотранспорт, Хранение урожая">Зерновые, Масличные , Торговля сельхозпродукцией, Автот..</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col pt-2 mt-1">
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block col-md-3">
                        <div class="companySticker">
                            <span>+380978463603</span>
                        </div>
                    </div>
                </div>
                <div class="row mx-0 d-sm-none lh-1 w-100">
                    <div class="col mt-2 text-center">
                    </div>
                </div>
            </div>
            <div class="row content-block companyItem mx-0 mt-4 pt-3 pb-1 py-sm-3 px-1  " }="">
                <div class="row mx-0 w-100">
                    <div class="col-auto pr-0 pl-2 pl-sm-3">
                        <div class="row m-0">
                            <div class="col-12 pl-0 pr-0 pr-sm-2">
                                <a href="/kompanii/comp-1060"><img class="companyImg" src="/pics/comp/1060_22303.jpg"></a>
                            </div>
                        </div>
                        <div class="row m-0 pt-3 d-none d-sm-flex">
                            <div class="col-12 pl-0 pr-2 text-center">
                                <span class="date">На сайте с Авг. 2015</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row lh-1">
                            <div class="col">
                                <span class="title"><a href="/kompanii/comp-1060">РЕАЛ</a></span>
                            </div>
                        </div>
                        <div class="row d-sm-none lh-1">
                            <div class="col">
                                <span class="date mb-2">На сайте с Авг. 2015</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col mt-1">
                                <p class="desc">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Группа компаний «РЕАЛ» &nbsp;основана в 1997 году. Главным направлением деятельности является экспорт зерновых и масличных</p>
                            </div>
                        </div>
                        <div class="row lh-1-2">
                            <div class="col">
                                <span class="a-bold d-none d-sm-inline-block">Виды деятельности:</span>
                                <span class="activities d-none d-sm-block">Зерновые, Масличные , Бобовые, Торговля сельхозпродукцией, Ж/Д транспорт</span>
                                <span class="activities d-block d-sm-none" data-toggle="tooltip" data-placement="top" title="Зерновые, Масличные , Бобовые, Торговля сельхозпродукцией, Ж/Д транспорт">Зерновые, Масличные , Бобовые, Торговля сельхозпродукци..</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col pt-2 mt-1">
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block col-md-3">
                        <div class="companySticker">
                            <span>+380969779439</span>
                            <span>+380503036332</span>
                            <span>+380577281071</span>
                        </div>
                    </div>
                </div>
                <div class="row mx-0 d-sm-none lh-1 w-100">
                    <div class="col mt-2 text-center">
                    </div>
                </div>
            </div>
            <div class="row content-block companyItem mx-0 mt-4 pt-3 pb-1 py-sm-3 px-1  " }="">
                <div class="row mx-0 w-100">
                    <div class="col-auto pr-0 pl-2 pl-sm-3">
                        <div class="row m-0">
                            <div class="col-12 pl-0 pr-0 pr-sm-2">
                                <a href="/kompanii/comp-1376"><img class="companyImg" src="/pics/comp/1376_48781.jpg"></a>
                            </div>
                        </div>
                        <div class="row m-0 pt-3 d-none d-sm-flex">
                            <div class="col-12 pl-0 pr-2 text-center">
                                <span class="date">На сайте с Дек. 2015</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row lh-1">
                            <div class="col">
                                <span class="title"><a href="/kompanii/comp-1376">ТОВ "ВАТАВ"</a></span>
                            </div>
                        </div>
                        <div class="row d-sm-none lh-1">
                            <div class="col">
                                <span class="date mb-2">На сайте с Дек. 2015</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col mt-1">
                                <p class="desc">Ми надійний партнер у своему бізнесі. Чесність і прозорість - завжди приносить прибуток, та примножуе охочих до співпраці з нами.</p>
                            </div>
                        </div>
                        <div class="row lh-1-2">
                            <div class="col">
                                <span class="a-bold d-none d-sm-inline-block">Виды деятельности:</span>
                                <span class="activities d-none d-sm-block" data-toggle="tooltip" data-placement="top" title="Грануляция, Комбикормовые заводы, Оборудование для хранения, Торговля сельхозпродукцией, Автотранспорт">Грануляция, Комбикормовые заводы, Оборудование для хранения, Торговля сел..</span>
                                <span class="activities d-block d-sm-none" data-toggle="tooltip" data-placement="top" title="Грануляция, Комбикормовые заводы, Оборудование для хранения, Торговля сельхозпродукцией, Автотранспорт">Грануляция, Комбикормовые заводы, Оборудование для хран..</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col pt-2 mt-1">
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block col-md-3">
                        <div class="companySticker">
                            <span>+380977735703</span>
                            <span>+380933444123</span>
                        </div>
                    </div>
                </div>
                <div class="row mx-0 d-sm-none lh-1 w-100">
                    <div class="col mt-2 text-center">
                    </div>
                </div>
            </div>
            <div class="row content-block companyItem mx-0 mt-4 pt-3 pb-1 py-sm-3 px-1  " }="">
                <div class="row mx-0 w-100">
                    <div class="col-auto pr-0 pl-2 pl-sm-3">
                        <div class="row m-0">
                            <div class="col-12 pl-0 pr-0 pr-sm-2">
                                <a href="/kompanii/comp-339"><img class="companyImg" src="/pics/comp/339_84494.jpg"></a>
                            </div>
                        </div>
                        <div class="row m-0 pt-3 d-none d-sm-flex">
                            <div class="col-12 pl-0 pr-2 text-center">
                                <span class="date">На сайте с Мар. 2014</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row lh-1">
                            <div class="col">
                                <span class="title"><a href="/kompanii/comp-339">OOO " SPE-EUGEN"</a></span>
                            </div>
                        </div>
                        <div class="row d-sm-none lh-1">
                            <div class="col">
                                <span class="date mb-2">На сайте с Мар. 2014</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col mt-1">
                                <p class="desc">Оптовая торговля. Овощи, фрукты, грибы.
                                    Закупаем, продаем постоянно от 1 до 100 тонн в день.
                                    Skype  speeugen</p>
                            </div>
                        </div>
                        <div class="row lh-1-2">
                            <div class="col">
                                <span class="a-bold d-none d-sm-inline-block">Виды деятельности:</span>
                                <span class="activities d-none d-sm-block" data-toggle="tooltip" data-placement="top" title="Масличные , Фрукты  и ягоды, Торговля продукцией животноводства, Торговля сельхозпродукцией, Торговля сельхозтехникой и оборудованием">Масличные , Фрукты  и ягоды, Торговля продукцией животноводства, Торговля..</span>
                                <span class="activities d-block d-sm-none" data-toggle="tooltip" data-placement="top" title="Масличные , Фрукты  и ягоды, Торговля продукцией животноводства, Торговля сельхозпродукцией, Торговля сельхозтехникой и оборудованием">Масличные , Фрукты  и ягоды, Торговля продукцией животн..</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col pt-2 mt-1">
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block col-md-3">
                        <div class="companySticker">
                            <span>380962973055</span>
                            <span>+37379460938</span>
                            <span>+380960025123</span>
                        </div>
                    </div>
                </div>
                <div class="row mx-0 d-sm-none lh-1 w-100">
                    <div class="col mt-2 text-center">
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
            </div>
            <div class="row mx-0 mt-4">
                <div class="col-12 pagination d-block text-center">
                    <a href="#" class="active mx-1">1</a>
                    <a class="d-sm-inline-block mx-1" href="/kompanii/s/j/p2">2</a>
                    <a class="d-sm-inline-block mx-1" href="/kompanii/s/j/p3">3</a>
                    ..
                    <a class="mx-1" href="/kompanii/s/j/p44">44</a>
                    <a href="/kompanii/s/j/p2"><span class="d-none d-sm-inline-block">Следующая</span> <span class="ml-1"><i class="far fa-chevron-right"></i></span></a>
                </div>
            </div>
        </div>
    </main>
@endsection
