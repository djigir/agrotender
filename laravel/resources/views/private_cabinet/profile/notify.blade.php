@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.profile.profile_header')
    <div class="container mt-4 mb-5">
        <h2 class="mx-5">Доска объявлений</h2>
        <form class="content-block mt-4 mb-4 mx-2 mx-sm-5 py-4 px-4 px-sm-5 personal">
            <b>Выберите, какие уведомления вы хотите получать:</b>
            <hr>
            <div class="custom-control custom-checkbox px-sm-5">
                <input type="checkbox" name="up" value="1" class="custom-control-input upAdv advSub" id="up" checked="">
                <label class="custom-control-label" for="up">Бесплатное поднятие объявлений</label>
            </div>
            <div class="custom-control custom-checkbox mt-2 px-sm-5">
                <input type="checkbox" name="deact" value="1" class="custom-control-input deactAdv advSub" id="deact" checked="">
                <label class="custom-control-label" for="deact">Деактивация объявлений</label>
            </div>
        </form>
        <h2 class="mx-5">Цены трейдеров</h2>
        <div class="content-block mt-4 mb-4 mx-2 mx-sm-5 py-4 px-4 px-sm-5 personal">
            <div class="row">
                <div class="col-12 col-sm-6 px-0 pr-sm-4">
                    <label class="col-form-label"><b>Выберите рубрику:</b></label>
                    <select class="form-control" name="rubric">
                        <optgroup label="Зерновые">
                            <option value="14">Кукуруза</option>
                            <option value="80">Кукуруза битая</option>
                            <option value="81">Кукуруза зерноотход</option>
                            <option value="59">Кукуруза кремнистая</option>
                            <option value="85">Кукуруза с повыш. зерн.</option>
                            <option value="71">Кукуруза фуражная</option>
                            <option value="38">Овес</option>
                            <option value="73">Овес голозерный</option>
                            <option value="8">Пшеница 2 кл.</option>
                            <option value="9">Пшеница 3 кл.</option>
                            <option value="10">Пшеница 4 кл.</option>
                            <option value="86">Пшеница битая</option>
                            <option value="187">Пшеница спельта</option>
                            <option value="60">Пшеница твердая</option>
                            <option value="57">Рожь</option>
                            <option value="62">Тритикале</option>
                            <option value="13">Ячмень</option>
                        </optgroup>
                        <optgroup label="Масличные">
                            <option value="24">Подсолнечник</option>
                            <option value="169">Подсолнечник высокоолеин.</option>
                            <option value="25">Рапс</option>
                            <option value="88">Рапс с ГМО</option>
                            <option value="66">Рапс технический</option>
                        </optgroup>
                        <optgroup label="Бобовые">
                            <option value="30">Бобы</option>
                            <option value="77">Горох</option>
                            <option value="27">Горох желтый</option>
                            <option value="48">Горох зеленый</option>
                            <option value="26">Соя</option>
                            <option value="202">Соя без ГМО</option>
                            <option value="29">Фасоль</option>
                            <option value="84">Фасоль белая</option>
                            <option value="83">Фасоль красная</option>
                        </optgroup>
                        <optgroup label="Продукты переработки">
                            <option value="221">Кукурузная барда</option>
                            <option value="54">Масло соевое</option>
                            <option value="223">Отруби гороховые</option>
                            <option value="191">Отруби кукурузные</option>
                            <option value="43">Отруби пшен. гран.</option>
                            <option value="55">Отруби пшеничные</option>
                            <option value="222">Рисовая мучка</option>
                            <option value="35">Шрот подсолн. высокопрот.</option>
                        </optgroup>
                        <optgroup label="Нишевые культуры">
                            <option value="40">Вика</option>
                            <option value="45">Горчица белая</option>
                            <option value="46">Горчица желтая</option>
                            <option value="50">Горчица черная</option>
                            <option value="22">Гречиха</option>
                            <option value="49">Кориандр</option>
                            <option value="39">Лён</option>
                            <option value="28">Нут</option>
                            <option value="204">Нут &gt; 7 мм</option>
                            <option value="20">Просо белое</option>
                            <option value="18">Просо желтое</option>
                            <option value="19">Просо красное</option>
                            <option value="15">Сорго</option>
                            <option value="16">Сорго белое</option>
                            <option value="17">Сорго красное</option>
                            <option value="203">Спельта</option>
                            <option value="58">Чечевица</option>
                            <option value="172">Чечевица зеленая</option>
                            <option value="209">Чечевица красная</option>
                        </optgroup>
                        <optgroup label="Органика">
                            <option value="216">Просо БИО</option>
                            <option value="214">Пшеница спельта БИО</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-12 col-sm-6 px-0 pl-sm-2">
                    <label class="col-form-label"><b>Выберите интенсивность:</b></label>
                    <div class="mt-sm-2">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="period" value="1" class="custom-control-input" id="per1" checked="">
                            <label class="custom-control-label" for="per1">Каждый час</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="period" value="24" class="custom-control-input" id="per2">
                            <label class="custom-control-label" for="per2">Раз в день</label>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4 ">
            <div class="text-center col-12 col-sm-4 offset-sm-4">
                <button class="btn btn-block btn-primary save">Добавить рубрику</button>
            </div>
        </div>
    </div>
@endsection
