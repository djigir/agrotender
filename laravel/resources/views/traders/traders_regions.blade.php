@extends('layout.layout')
{{--Трейдер--}}

@section('content')

    @include('filters.filter-traders', ['section' => $section,'regions' => $regions,'rubricsGroup' => $rubric,'onlyPorts' => $onlyPorts])
    <div class="d-none d-sm-block container mt-5">
        <span class="popular" style="margin-top: 16px;display: block;">
          <span style="font-weight: 600; color: #707070;">
          <img src="/app/assets/img/speaker.svg" style="width: 24px; height: 24px">
           Популярные культуры: </span>
          <a href="/traders/region_ukraine/pshenica_2_kl" class="popular__block">Пшеница 2 кл.</a>
          <a href="/traders/region_ukraine/pshenica_3_kl" class="popular__block">Пшеница 3 кл.</a>
          <a href="/traders/region_ukraine/pshenica_4_kl" class="popular__block">Пшеница 4 кл.</a>
          <a href="/traders/region_ukraine/podsolnechnik" class="popular__block">Подсолнечник</a>
          <a href="/traders/region_ukraine/soya" class="popular__block">Соя</a>
          <a href="/traders/region_ukraine/yachmen" class="popular__block">Ячмень</a>
      </span>
    </div>
    <div class="container traders mt-3 mt-sm-5">
        <div class="row mt-sm-0 pt-sm-0 mb-sm-4">
            <div class="position-relative w-100">
                <div class="col-12 col-md-9 float-md-right text-center text-md-right">
                    <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end d-none d-sm-inline-block">
                        <i class="far fa-plus mr-2"></i>
                        <span class="pl-1 pr-1">Разместить компанию</span>
                    </a>
                </div>
                <div class="col-12 col-md-3 float-left mt-sm-0 d-flex justify-content-between d-sm-block">
                    <div class="col-6 col-sm-12 pl-0">
                        <h2 class="d-inline-block text-uppercase">Все трейдеры</h2>
                        <div class="lh-1">
                            <a href="/tarif20.html" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
                        </div>
                    </div>

                    <div class="col-6 pr-0 text-right d-sm-none">
                        <a href="/tarif20.html" class="btn btn-warning align-items-end add-trader">
                            <span class="pl-1 pr-1">Стать трейдером</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="new_container container mt-3 traders_dev">
        <div class="new_traders ">
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6608" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/NUsnWWRvHghW.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            МАКАРДІ
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Нут</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">12 500</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Чечевица</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">15 000</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Горох желтый</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">8 000</span>

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

                <a href="/kompanii/comp-6546" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/4NJgh3XkncYD.jpg" alt="" data-primary-color="251,218,89">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            KADORR Agro Group
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечник</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 13500">14 000</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6150">62 000</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Сорго белое</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">5 000</span>

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

                <a href="/kompanii/comp-5559" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/1ahFioC9j0C7.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Sintez Group &amp; Co
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Фасоль красн.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">22 000</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Чечевица кр..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">14 000</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 14100">14 200</span>

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

                <a href="/kompanii/comp-5608" class="traders__item  yellow">
                    <div class="traders__item__header">
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
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 13300">14 000</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7650">7 700</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6700">6 750</span>

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

                <a href="/kompanii/comp-1115" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/1115_84695.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            НОВААГРО
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 200</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Гречиха</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-down" data-toggle="tooltip" data-placement="right" title="Старая цена: 18510">18 500</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-down.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 000</span>

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

                <a href="/kompanii/comp-2136" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/2136_85457.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            BG Trade SA
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: $216">$&nbsp;234</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: $218">$&nbsp;235</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза фу..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: $184">$&nbsp;202</span>

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
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/Wf6mpqolc469.png" alt="" data-primary-color="0,197,97">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            ВІН-ЕКСПО
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница спе..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">14 000</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Просо красно.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">5 700</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
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
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-4081" class="traders__item  yellow">
                    <div class="traders__item__header">
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
                  <span class="traders__item__content-p-price ">14 800</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 100</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 050</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 2 отзыва</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6606" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/vGw5Emv1Gqli.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Петрус-Кондитер
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7300">7 350</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
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
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#001430;">10 Октября</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6302" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/9AkVDpHt9eUN.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            G.R. Agro
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечник</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 14000">14 100</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 350</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 500</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#001430;">9 Октября</span>            </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="new_traders ">
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-4593" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/4593_70690.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Прометей
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6020">6 070</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечник</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 13800">14 050</span>

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
                            <span style="color:#001430;">9 Октября</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-1105" class="traders__item  yellow">
                    <div class="traders__item__header">
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
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6100">6 200</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Горох желтый</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">6 350</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">$&nbsp;222</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#001430;">9 Октября</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6293" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/1RnbTG5LXytX.jpeg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Пирятинский деликатес
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: $228">$&nbsp;229</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
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
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 1 отзыв</span> -->
                            <span style="color:#001430;">9 Октября</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-1968" class="traders__item  yellow">
                    <div class="traders__item__header">
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
                            <span style="color:#001430;">9 Октября</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-1167" class="traders__item  yellow">
                    <div class="traders__item__header">
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
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7260">7 340</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 1 отзыв</span> -->
                            <span style="color:#001430;">9 Октября</span>            </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="new_traders ">
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-5529" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/5529_86405.jpg" alt="" data-primary-color="38,179,67">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Лихачевский Элеватор
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6600">6 900</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
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
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#001430;">9 Октября</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6354" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/tsdL477Tawjd.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            ТК Восток
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7425">7 500</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
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
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#001430;">8 Октября</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-3193" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/3193_80434.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            АГРОЛІДЕР ЄВРОПА
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Горчица черн.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 16500">19 700</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
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
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#001430;">8 Октября</span>            </div>
                    </div>
                </a>
            </div>
        </div>
        <!--
     -->
    </div>
@endsection
