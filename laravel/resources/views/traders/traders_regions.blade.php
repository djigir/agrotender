@extends('layout.layout')
{{--Трейдер--}}

@section('content')
    @include('layout.layout-filter', ['section' => $section, 'rubricsGroup' => $rubric, 'onlyPorts' => $onlyPorts])
    <div class="new_container container mt-3 traders_dev">
        <div class="new_traders ">
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6546" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(251, 218, 89);">
                        <img class="traders__item__image" src="/pics/c/4NJgh3XkncYD.jpg" alt="" data-primary-color="251,218,89">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            KADORR Agro Group
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6620">6 650</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6100">6 150</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7650">7 750</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-1105" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(51, 106, 77);">
                        <img class="traders__item__image" src="/pics/comp/1105_96102.jpg" alt="" data-primary-color="51,106,77">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Рамбурс
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">6 100</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя без ГМО</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">$&nbsp;436</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 100</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-4081" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/4081_95081.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Escador
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечник</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 13900">14 050</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6950">7 000</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7000">7 050</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 2 отзыва</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6293" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/1RnbTG5LXytX.jpeg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Пирятинский деликатес
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7720">7 760</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 14100">14 450</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7720">7 760</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 1 отзыв</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-1968" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/HrkW02a6FUzF.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            АДМ ЮКРЕЙН
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6995">7 225</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">6 700</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6965">7 195</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="new_traders ">
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-5559" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/1ahFioC9j0C7.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Sintez Group &amp; Co
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 13600">14 100</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Горох желтый</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">6 500</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Фасоль</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">22 000</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 1 отзыв</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6302" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/9AkVDpHt9eUN.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            G.R. Agro
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 500</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечник</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">14 000</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 500</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-1167" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/1167_80788.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            SUNGRAIN
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6000">6 030</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 5800">5 850</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7310">7 370</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 1 отзыв</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6606" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/vGw5Emv1Gqli.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Петрус-Кондитер
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 400</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 400</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 300</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-1115" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/1115_84695.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            НОВААГРО
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Гречиха</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 18500">18 510</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">6 700</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">6 850</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="new_traders ">
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-5529" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(38, 179, 67);">
                        <img class="traders__item__image" src="/pics/comp/5529_86405.jpg" alt="" data-primary-color="38,179,67">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Лихачевский Элеватор
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-down" data-toggle="tooltip" data-placement="right" title="Старая цена: 6700">7</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-down.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-down" data-toggle="tooltip" data-placement="right" title="Старая цена: 6700">7</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-down.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6600">6 900</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6532" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(0, 197, 97);">
                        <img class="traders__item__image" src="/pics/c/Wf6mpqolc469.png" alt="" data-primary-color="0,197,97">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            ВІН-ЕКСПО
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Просо желтое</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 5600">5 700</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Масло соевое</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">$&nbsp;780</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница спе..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">14 000</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-4593" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/4593_70690.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Прометей
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7130">7 220</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7500">7 600</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7470">7 570</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6354" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/tsdL477Tawjd.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            ТК Восток
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6325">6 350</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7350">7 400</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7425">7 500</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-3193" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/3193_80434.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            АГРОЛІДЕР ЄВРОПА
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Горчица бела.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-down" data-toggle="tooltip" data-placement="right" title="Старая цена: 17000">16 800</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-down.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Нут</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 10000">13 000</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Чечевица</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 12000">14 500</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="new_traders ">
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-820" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/820_83166.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Smart Trade
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Отруби пшен..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">4 850</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Отруби пшен..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">4 650</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Шрот подсол..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: $228">$&nbsp;230</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 3 отзыва</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6596" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/XKwBhLDbeJoY.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            AGROLA
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Отруби пшен..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">5 150</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Отруби пшен..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">4 850</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-5608" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/5608_54749.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            KERNEL
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечни..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 13000">13 300</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6650">6 700</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6400">6 450</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
        </div>
        <!--
     -->
        <div class="new_traders "> <div class="traders__item-wrap">
                <a href="/kompanii/comp-4964" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/4964_89599.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            GrainCorp Ukraine
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:$ &nbsp;218">$&nbsp;220</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:7270">7 370</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">5 Октября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-2136" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/2136_85457.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            BG Trade SA
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза фураж…</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:$ &nbsp;184">$&nbsp;188</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:$ &nbsp;218">$&nbsp;219</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">2 Октября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-6566" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/aUIPbx18fK57.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Caravan Agro
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Лён</span>
                                <span class="right"><span class="traders__item__content-p-price">13 000</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Сорго красное</span>
                                <span class="right"><span class="traders__item__content-p-price">4 900</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">1 Октября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-812" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/812_47610.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            VIRTUS
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price">7 000</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price">6 900</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">29 Сентября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-959" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/959_83651.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            AnkoAgroTrade
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Рапс с ГМО</span>
                                <span class="right"><span class="traders__item__content-p-price">$&nbsp;395</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Сорго белое</span>
                                <span class="right"><span class="traders__item__content-p-price">$&nbsp;160</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">22 Сентября</span>
                        </div>
                    </div></a></div></div><div class="new_traders "> <div class="traders__item-wrap">
                <a href="/kompanii/comp-3720" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/3720_73076.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Global Commodities Swiss …
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Рапс с ГМО</span>
                                <span class="right"><span class="traders__item__content-p-price">$&nbsp;380</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя без ГМО</span>
                                <span class="right"><span class="traders__item__content-p-price">$&nbsp;408</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">21 Сентября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-6477" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/5Fvt5CVFpaEb.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Region Grain Company AG
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right"><span class="traders__item__content-p-price">5 350</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price">7 100</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">17 Сентября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-2045" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/2045_15757.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            LNZ GROUP
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя</span>
                                <span class="right"><span class="traders__item__content-p-price">12 250</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечник</span>
                                <span class="right"><span class="traders__item__content-p-price">12 300</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">11 Сентября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-1490" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/1490_34978.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Ukrlandfarming
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя</span>
                                <span class="right"><span class="traders__item__content-p-price">11 900</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right"><span class="traders__item__content-p-price">5 400</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">10 Сентября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-1020" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/1020_85359.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Klam Oliya
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Шрот подсолн. …</span>
                                <span class="right"><span class="traders__item__content-p-price">$&nbsp;207</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right"><span class="traders__item__content-p-price">$&nbsp;155</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">27 Июля</span>
                        </div>
                    </div></a></div></div><div class="new_traders "> <div class="traders__item-wrap">
                <a href="/kompanii/comp-1119" class="traders__item ">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/BnLleiOjlrCn.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            CORETRADE
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price">7 870</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:6600">6 700</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span class="green">сегодня</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-1943" class="traders__item ">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/1943_73237.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            ТАС АГРО
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя</span>
                                <span class="right"><span class="traders__item__content-p-price">14 000</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:6300">6 400</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span class="green">сегодня</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-3962" class="traders__item ">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/3962_63556.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            СІЕЙТІ
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя без ГМО</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:14300">14 400</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right"><span class="traders__item__content-p-price">5 800</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span class="green">сегодня</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-5962" class="traders__item ">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/p7DUB6TKdciH.JPG" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Orex Distribution
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:6850">7 000</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:6900">7 050</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span class="green">сегодня</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-6441" class="traders__item ">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/p7KovMuRtsOV.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Південна Зернова Столиця
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:7520">7 720</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечник</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:13500">13 900</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span class="green">сегодня</span>
                        </div>
                    </div></a></div></div></div>
@endsection
