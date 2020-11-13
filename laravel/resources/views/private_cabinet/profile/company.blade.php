@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.profile.profile_header')
    <div class="container mt-4 mb-5">
        <div class="content-block px-5 py-4 company-settings position-relative">
            <h2>Настройки компании </h2>
            <form class="form company-form mt-4" novalidate="novalidate">
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Название компании <span class="text-danger">*</span></label>
                    <div class="col-sm-4 pl-1">
                        <input type="text" class="form-control" placeholder="Город" name="title">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Логотип</label>
                    <div class="col-sm-4 pl-1 d-flex align-items-center">
                        <img class="logo" src="/app/assets/img/noavatar.png">
                        <span class="ml-3 select-image">Выбрать изображение</span>
                        <input type="file" name="logo" class="d-none">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label d-flex align-items-start justify-content-start justify-content-sm-end">О компании <span class="text-danger">*</span></label>
                    <div class="col-sm-7 d-flex align-items-center pl-1">
                        <textarea class="form-control" name="content" id="content" rows="9" placeholder="Введите Ваше описание"></textarea>
                    </div>
                </div>
                <hr class="my-4">
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Индекс</label>
                    <div class="col-sm-4 pl-1">
                        <input type="text" class="form-control" placeholder="Индекс" name="zipcode">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Область <span class="text-danger">*</span></label>
                    <div class="col-sm-4 pl-1">
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
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Город <span class="text-danger">*</span></label>
                    <div class="col-sm-4 pl-1">
                        <input type="text" class="form-control" placeholder="Город" name="city">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Адрес</label>
                    <div class="col-sm-4 pl-1">
                        <input type="text" class="form-control" placeholder="Адрес" name="addr">
                    </div>
                </div>
                <hr class="my-4">
                <h3>Продукция</h3>
                <span class="desc extra-small">Выберите до 5 видов деятельности Вашей компании</span>
                <div class="text-center pl-0 pl-sm-5 mt-3">
                    <div class="rubrics-wrap d-inline-block pl-0 pl-sm-5">
                        <div class="rubric-col pr-0 pr-sm-4">
                            <span class="rubric-title">Сельхоз производители</span>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="10" name="rubrics[]" id="rubric10">
                                <label class="custom-control-label" for="rubric10">
                                    Зерновые
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="11" name="rubrics[]" id="rubric11">
                                <label class="custom-control-label" for="rubric11">
                                    Масличные
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="12" name="rubrics[]" id="rubric12">
                                <label class="custom-control-label" for="rubric12">
                                    Бобовые
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="13" name="rubrics[]" id="rubric13">
                                <label class="custom-control-label" for="rubric13">
                                    Овощеводство
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="14" name="rubrics[]" id="rubric14">
                                <label class="custom-control-label" for="rubric14">
                                    Фрукты  и ягоды
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="15" name="rubrics[]" id="rubric15">
                                <label class="custom-control-label" for="rubric15">
                                    Птицефабрики
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="16" name="rubrics[]" id="rubric16">
                                <label class="custom-control-label" for="rubric16">
                                    Свиноводство
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="17" name="rubrics[]" id="rubric17">
                                <label class="custom-control-label" for="rubric17">
                                    Кролиководство
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="18" name="rubrics[]" id="rubric18">
                                <label class="custom-control-label" for="rubric18">
                                    КРС
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="19" name="rubrics[]" id="rubric19">
                                <label class="custom-control-label" for="rubric19">
                                    Пчеловодство
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="20" name="rubrics[]" id="rubric20">
                                <label class="custom-control-label" for="rubric20">
                                    Рыбоводство
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="21" name="rubrics[]" id="rubric21">
                                <label class="custom-control-label" for="rubric21">
                                    Посевматериал
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="22" name="rubrics[]" id="rubric22">
                                <label class="custom-control-label" for="rubric22">
                                    Молодняк животных
                                </label>
                            </div>
                        </div>
                        <div class="rubric-col pr-0 pr-sm-4">
                            <span class="rubric-title">Переработчики</span>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="23" name="rubrics[]" id="rubric23">
                                <label class="custom-control-label" for="rubric23">
                                    Комбикормовые заводы
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="24" name="rubrics[]" id="rubric24">
                                <label class="custom-control-label" for="rubric24">
                                    Мельницы
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="25" name="rubrics[]" id="rubric25">
                                <label class="custom-control-label" for="rubric25">
                                    МЭЗы и Маслозаводы
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="26" name="rubrics[]" id="rubric26">
                                <label class="custom-control-label" for="rubric26">
                                    Хлебозаводы, пекарни и кондитерки
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="27" name="rubrics[]" id="rubric27">
                                <label class="custom-control-label" for="rubric27">
                                    Переработка мяса
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="28" name="rubrics[]" id="rubric28">
                                <label class="custom-control-label" for="rubric28">
                                    Сахарные заводы
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="29" name="rubrics[]" id="rubric29">
                                <label class="custom-control-label" for="rubric29">
                                    Грануляция
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="30" name="rubrics[]" id="rubric30">
                                <label class="custom-control-label" for="rubric30">
                                    Крупорушки
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="31" name="rubrics[]" id="rubric31">
                                <label class="custom-control-label" for="rubric31">
                                    Пивоварни, Ликеро-водочные заводы
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="32" name="rubrics[]" id="rubric32">
                                <label class="custom-control-label" for="rubric32">
                                    Молоковозаводы
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="33" name="rubrics[]" id="rubric33">
                                <label class="custom-control-label" for="rubric33">
                                    Фасовка
                                </label>
                            </div>
                        </div>
                        <div class="rubric-col pr-0 pr-sm-4">
                            <span class="rubric-title">Техника и оборудование</span>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="34" name="rubrics[]" id="rubric34">
                                <label class="custom-control-label" for="rubric34">
                                    Производители сельхозтехники
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="35" name="rubrics[]" id="rubric35">
                                <label class="custom-control-label" for="rubric35">
                                    Оборудование для растениеводства
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="36" name="rubrics[]" id="rubric36">
                                <label class="custom-control-label" for="rubric36">
                                    Оборудование для животноводства
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="37" name="rubrics[]" id="rubric37">
                                <label class="custom-control-label" for="rubric37">
                                    Оборудование для пчеловодства
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="38" name="rubrics[]" id="rubric38">
                                <label class="custom-control-label" for="rubric38">
                                    Оборудование для рыбоводства
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="39" name="rubrics[]" id="rubric39">
                                <label class="custom-control-label" for="rubric39">
                                    Оборудование для хранения
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="40" name="rubrics[]" id="rubric40">
                                <label class="custom-control-label" for="rubric40">
                                    Оборудование для переработки
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="41" name="rubrics[]" id="rubric41">
                                <label class="custom-control-label" for="rubric41">
                                    ГСМ
                                </label>
                            </div>
                        </div>
                        <div class="rubric-col pr-0 pr-sm-4">
                            <span class="rubric-title">Агрохимия</span>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="4" name="rubrics[]" id="rubric4">
                                <label class="custom-control-label" for="rubric4">
                                    Удобрения
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="42" name="rubrics[]" id="rubric42">
                                <label class="custom-control-label" for="rubric42">
                                    Средства защиты
                                </label>
                            </div>
                        </div>
                        <div class="rubric-col pr-0 pr-sm-4">
                            <span class="rubric-title">Закупка и реализация</span>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="43" name="rubrics[]" id="rubric43">
                                <label class="custom-control-label" for="rubric43">
                                    Торговля сельхозпродукцией
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="44" name="rubrics[]" id="rubric44">
                                <label class="custom-control-label" for="rubric44">
                                    Торговля продукцией животноводства
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="45" name="rubrics[]" id="rubric45">
                                <label class="custom-control-label" for="rubric45">
                                    Торговля сельхозтехникой и оборудованием
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="46" name="rubrics[]" id="rubric46">
                                <label class="custom-control-label" for="rubric46">
                                    Торговля Агрохимией
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="47" name="rubrics[]" id="rubric47">
                                <label class="custom-control-label" for="rubric47">
                                    Корма для животных
                                </label>
                            </div>
                        </div>
                        <div class="rubric-col pr-0 pr-sm-4">
                            <span class="rubric-title">Перевозки</span>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="48" name="rubrics[]" id="rubric48">
                                <label class="custom-control-label" for="rubric48">
                                    Автотранспорт
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="49" name="rubrics[]" id="rubric49">
                                <label class="custom-control-label" for="rubric49">
                                    Ж/Д транспорт
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="50" name="rubrics[]" id="rubric50">
                                <label class="custom-control-label" for="rubric50">
                                    Морской транспорт
                                </label>
                            </div>
                        </div>
                        <div class="rubric-col pr-0 pr-sm-4">
                            <span class="rubric-title">Услуги</span>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="51" name="rubrics[]" id="rubric51">
                                <label class="custom-control-label" for="rubric51">
                                    Хранение урожая
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="52" name="rubrics[]" id="rubric52">
                                <label class="custom-control-label" for="rubric52">
                                    Посев и уборка урожая
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="53" name="rubrics[]" id="rubric53">
                                <label class="custom-control-label" for="rubric53">
                                    Строительство
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="54" name="rubrics[]" id="rubric54">
                                <label class="custom-control-label" for="rubric54">
                                    Ремонт
                                </label>
                            </div>
                            <div class="rubric-item">
                                <input class="custom-control-input rubric-input" type="checkbox" value="55" name="rubrics[]" id="rubric55">
                                <label class="custom-control-label" for="rubric55">
                                    Юридические услуги
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="comp-rules mt-4 text-center">
            <div><span>Я обязуюсь соблюдать</span> <a href="/info/orfeta#p4" target="_blank">правила размещения компании</a>.</div>
            <button class="btn btn-primary px-5 text-center mt-3 save-comp">Сохранить</button>
        </div>
    </div>
@endsection
