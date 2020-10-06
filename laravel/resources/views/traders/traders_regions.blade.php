@extends('layout.layout')
{{--Трейдер--}}

@section('content')
<div class="header__wrap">
    <header class="new_header">
        <div class="new_container">
            <div class="header__flex header__desktop">
                <div class="logo-wrap">
                    <a href="https://agrotender.com.ua" class="logo">
                        <img src="https://agrotender.com.ua/app/assets/img/logo_white.svg" alt="logo" class="logo_desktop">
                        <img src="https://agrotender.com.ua/app/assets/img/agromini.svg" alt="logo" class="logo_mobile">
                    </a>
                    <div class="hidden-links">
                        <a href="#">
                            <img src="https://agrotender.com.ua/app/assets/img/company/viber4.svg" alt="">
                        </a>
                        <a href="#">
                            <img src="https://agrotender.com.ua/app/assets/img/company/telegram-white.svg" alt="">
                        </a>
                    </div>
                </div>
                <div class="header__center__buttons">
                    <a href="https://agrotender.com.ua/board" class="header__center__button">Объявления</a>
                    <div class="header__tradersPrice">
                        <a href="https://agrotender.com.ua/traders" class="header__center__button withArrow">
                            Цены Трейдеров
                        </a>
                        <div class="header__hoverElem-wrap">
                            <div class="header__hoverElem">
                                <ul>
                                    <li>
                                        <a href="https://agrotender.com.ua/traders" class="header_fw600">Закупки</a>
                                    </li>
                                    <li>
                                        <a href="https://agrotender.com.ua/traders_forwards/region_ukraine/" class="header_fw600">Форварды</a>
                                    </li>
                                    <li>
                                        <a href="https://agrotender.com.ua/traders_sell" class="header_fw600">Продажи</a>
                                    </li>
                                    <li>
                                        <a href="https://agrotender.com.ua/tarif20.html" class="header__yellowText">Разместить компанию</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="header__tradersPrice special">
                        <a href="https://agrotender.com.ua/traders" class="header__center__button withBg">
                <span class="header__tradersPrice-dots">
                  <span></span>
                  <span></span>
                  <span></span>
                </span>
                        </a>
                        <div class="header__hoverElem-wrap">
                            <div class="header__hoverElem">
                                <ul>
                                    <li>
                                        <a href="https://agrotender.com.ua/traders">Компании</a>
                                    </li>
                                    <li>
                                        <a href="https://agrotender.com.ua/elev">Элеваторы</a>
                                    </li>
                                    <li>
                                        <span class="line"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header__right">
                    <a href="#" class="header__right__button">
                        <span>Мой профиль</span>
                        <img src="https://agrotender.com.ua/app/assets/img/profile.svg" alt="profile">
                    </a>
                    <div class="header__hoverElem-wrap">
                        <div class="header__hoverElem">
                            {if $user->auth}
                            <ul>
                                <li>
                                    <span>Цены трейдера:</span>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/prices">Таблица закупок</a>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/prices/contacts">Контакты трейдера</a>
                                </li>
                                <li>
                                    <span>Моя Компания:</span>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/company">Настройки</a>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/contacts">Контакты</a>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/posts">Объявления</a>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/balance/pay">Пополнить баланс</a>
                                </li>
                                <li>
                                    <span>Мой профиль:</span>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/">Настройки</a>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/logout" class="header__exit">Выход</a>
                                </li>
                            </ul>
                            {else}
                            <ul>
                                <li>
                                    <a href="/buyerreg">Регистрация</a>
                                </li>
                                <li>
                                    <a href="/buyerlog">Вход</a>
                                </li>
                            </ul>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
            <div class="header__mobile">
                <button class="header_drawerOpen-btn">
                    <img src="https://agrotender.com.ua/app/assets/img/menu.svg" alt="">
                </button>
                <a href="/" class="header_logo_mobile">
                    <img src="https://agrotender.com.ua/app/assets/img/logo_white.svg" alt="">
                </a>
                <a href="/" class="header_profile">
                    <img src="https://agrotender.com.ua/app/assets/img/profile_white.svg" alt="">
                </a>
            </div>
            <div class="drawer">
                <div class="drawer_content">
                    <div class="drawer__header">
                        <a href="/" class="drawer__header-logo">
                            <img src="https://agrotender.com.ua/app/assets/img/logo.svg" alt="">
                        </a>
                        <a href="#" class="drawer__header-social first">
                            <img src="https://agrotender.com.ua/app/assets/img/company/telegram_m.svg" alt="">
                        </a>
                        <a href="#" class="drawer__header-social">
                            <img src="https://agrotender.com.ua/app/assets/img/company/viber_m.svg" alt="">
                        </a>
                    </div>
                    <ul class="drawer__list">
                        <li>
                            <a href="#">Главная</a>
                        </li>
                        <li>
                            <a href="#">Объявления</a>
                        </li>
                        <li>
                            <a href="#">Цены трейдеров</a>
                        </li>
                        <li>
                            <a href="#">Компании</a>
                        </li>
                        <li>
                            <a href="#">Элеваторы</a>
                        </li>
                    </ul>
                    <div class="drawer_footer">
                        <ul class="drawer__list">
                            <li><a href="#">Выход</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>

<button class="openFilter">
    <img src="https://agrotender.com.ua/app/assets/img/blue_list.svg" alt="">
    <span>Открыть фильтры</span>
</button>
<div class="mobile_filter-bg">
    <div class="mobile_filter">
        <div class="posrel">

            <div class="mobile_filter-header">
                <button class="back first-btn active">
                    <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                </button>
                <button class="back second-btn">
                    <img src="https://agrotender.com.ua/app/assets/img/chevron_left-bold.svg" alt="">
                </button>
                <button class="back third-btn">
                    <img src="https://agrotender.com.ua/app/assets/img/chevron_left-bold.svg" alt="">
                </button>
                <span>Фильтры</span>
                <a href="/traders/region_ukraine">Сбросить</a>
            </div>
            <div class="screens">
                <div class="first active">
                    <div class="mobile_filter-categories">
                        <div class="mobile_filter-subtitle">Выбрать</div>
                        <div class="mobile_filter-choose-items" data-current="traders">
                            <a href="/traders_forwards/region_ukraine" class="mobile_filter-choose-item">Форварды</a>
                            {if $section eq 'buy'}
                            <a href="/traders_sell" class="mobile_filter-choose-item">Продажи</a>
                            {else}
                            <a href="/traders/region_ukraine" class="mobile_filter-choose-item">Закупки</a>
                            {/if}
                        </div>
                    </div>
                    <div class="mobile_filter-content">
                        <div class="mobile_filter-content-item withmargin" id="product" data-product="">Выбрать продукцию</div>
                        <div class="mobile_filter-content-item withmargin" id="region" data-region="region_kyiv">Вся Украина</div>

                        <div class="currency" data-currency="">
                            <span class="currency-t">Валюта:</span>
                            <div class="mobile_filter-choose-items">
                                <span class="mobile_filter-choose-item active" data-currency="">Все</span>
                                <span class="mobile_filter-choose-item" data-currency="uah">UAH</span>
                                <span class="mobile_filter-choose-item" data-currency="usd">USD</span>
                            </div>
                        </div>
                    </div>

                    <div class="mobile-filter-footer">
                        <button>Применить</button>
                    </div>
                </div>

                <div class="second">
                    <div class="subItem">
                        <div class="mobile_filter-content-item">Зерновые</div>
                        <div class="mobile_filter-content-item">Масличные</div>
                        <div class="mobile_filter-content-item">Бобовые</div>
                        <div class="mobile_filter-content-item">Продукты переработки</div>
                        <div class="mobile_filter-content-item">Нишевые культуры</div>
                    </div>
                    <div class="subItem">
                        <div class="search_wrap">
                            <input type="text" placeholder="Название области или порта" class="search_filed">
                            <button>
                                <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                            </button>
                        </div>
                        <div class="mobile_filter-section-text">Порты</div>
                        <ul class="mobile_filter-section-list">
                            <li>
                                <a href="#" data-id="1" data-url="region_ukraine">Вся Украина</a>
                            </li>
                            <li>
                                <a href="#" data-id="1" data-url="kiyv">Киев</a>
                            </li>
                            <li>
                                <a href="#" data-id="1" data-url="kharkov">Харьков</a>
                            </li>
                            <li>
                                <a href="#" data-id="1" data-url="odessa">Одесса</a>
                            </li>
                            <li>
                                <a href="#" data-id="1" data-url="winnica">Винница</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="third">
                    <div class="subItem">
                        <div class="search_wrap">
                            <input type="text" placeholder="Название области или порта" class="search_filed">
                            <button>
                                <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                            </button>
                        </div>
                        <div class="mobile_filter-section-text">Популярное</div>
                        <ul class="mobile_filter-section-list">
                            <li>
                                <a href="#" data-id="0" data-product="psheniza_2kl">Пшеница 2 кл. (64)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0" data-product="psheniza_3kl">Пшеница 3 кл. (63)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0" data-product="psheniza_4kl">Пшеница 4 кл. (59)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Ячмень (51)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза (27)</a>
                            </li>
                        </ul>
                        <div class="mobile_filter-section-text">Все зерновые</div>
                        <ul class="mobile_filter-section-list">
                            <li>
                                <a href="#" data-id="0" data-product="">Вся рубрика</a>
                            </li>
                            <li>
                                <a href="#" data-id="0"  data-product="kukuruza">Кукуруза (27)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0"  data-product="kukuruza">>Кукуруза битая (2)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
                            </li>
                            <li>
                                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
                            </li>
                        </ul>
                    </div>
                    <div class="subItem">
                        <div class="mobile_filter-section-text">Популярное</div>
                        <ul class="mobile_filter-section-list">
                            <li>
                                <a href="#" data-id="0">Пшеница 2 кл. (64)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Пшеница 3 кл. (63)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Пшеница 4 кл. (59)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Ячмень (51)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза (27)</a>
                            </li>
                        </ul>
                        <div class="mobile_filter-section-text">Все зерновые</div>
                        <ul class="mobile_filter-section-list">
                            <li>
                                <a href="#" data-id="0">Вся рубрика</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза (27)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза битая (2)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
                            </li>
                            <li>
                                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
                            </li>
                        </ul>
                    </div>
                    <div class="subItem">
                        <div class="mobile_filter-section-text">Популярное</div>
                        <ul class="mobile_filter-section-list">
                            <li>
                                <a href="#" data-id="0">Пшеница 2 кл. (64)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Пшеница 3 кл. (63)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Пшеница 4 кл. (59)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Ячмень (51)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза (27)</a>
                            </li>
                        </ul>
                        <div class="mobile_filter-section-text">Все зерновые</div>
                        <ul class="mobile_filter-section-list">
                            <li>
                                <a href="#" data-id="0">Вся рубрика</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза (27)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза битая (2)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
                            </li>
                            <li>
                                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
                            </li>
                        </ul>
                    </div>
                    <div class="subItem">
                        <div class="mobile_filter-section-text">Популярное</div>
                        <ul class="mobile_filter-section-list">
                            <li>
                                <a href="#" data-id="0">Пшеница 2 кл. (64)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Пшеница 3 кл. (63)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Пшеница 4 кл. (59)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Ячмень (51)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза (27)</a>
                            </li>
                        </ul>
                        <div class="mobile_filter-section-text">Все зерновые</div>
                        <ul class="mobile_filter-section-list">
                            <li>
                                <a href="#" data-id="0">Вся рубрика</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза (27)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза битая (2)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
                            </li>
                            <li>
                                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
                            </li>
                        </ul>
                    </div>
                    <div class="subItem">
                        <div class="mobile_filter-section-text">Популярное</div>
                        <ul class="mobile_filter-section-list">
                            <li>
                                <a href="#" data-id="0">Пшеница 2 кл. (64)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Пшеница 3 кл. (63)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Пшеница 4 кл. (59)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Ячмень (51)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза (27)</a>
                            </li>
                        </ul>
                        <div class="mobile_filter-section-text">Все зерновые</div>
                        <ul class="mobile_filter-section-list">
                            <li>
                                <a href="#" data-id="0">Вся рубрика</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза (27)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза битая (2)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
                            </li>
                            <li>
                                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
                            </li>
                            <li>
                                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="filters-wrap">
  <div class="filters-inner">
    <div class="filters arrow-t">
      <div class="step-1 stp">
        <div class="position-relative scroll-wrap">
          <div class="mt-3">
            <span class="title ml-3 pt-3">Настройте фильтры:</span>
          </div>
          <a class="mt-3 p-4 content-block filter filter-type d-flex justify-content-between" href="#" type="{if $section neq 'buy'}_sell{/if}">
            <span>{if $section eq 'buy'}Закупки{else}Продажи{/if}</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
          <a class="mt-4 p-4 content-block filter filter-rubric d-flex justify-content-between" href="#" rubric="{if $rubric eq null}0{else}{$rubric['translit']}{/if}">
            <span>{if $rubric eq null}Выбрать продукцию{else}{$rubric['name']}{/if}</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
          <a class="mt-4 p-4 content-block filter filter-region d-flex justify-content-between" href="#" region="{if $region eq null}0{elseif $region['id'] eq 1}1{else}{$region['translit']}{/if}" port="{if $onlyPorts eq 'yes'}all{else}{if $port eq null}0{else}{$port['translit']}{/if}{/if}">
          <span>{if $onlyPorts eq 'yes'} Все порты {else} {if $region eq null} {if $port eq null} Вся Украина {else} {$port['name']} {/if} {elseif $region['id'] eq 1} АР Крым {else} {$region['name']} область {/if} {/if}</span>
          <span><i class="far fa-chevron-right"></i></span>
          </a>
          <a class="mt-4 p-4 content-block filter filter-currency d-flex justify-content-between" href="#">
            <span class="text-muted">Валюта:</span>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
              <label class="btn btn-radio{if $currency eq null} active{/if}">
                <input type="radio" name="currency" value="" autocomplete="off"{if $currency eq null} checked{/if}> Любая
              </label>
              <label class="btn btn-radio{if $currency neq null && $currency['code'] eq 'uah'} active{/if}">
                <input type="radio" name="currency" value="uah" autocomplete="off"{if $currency neq null && $currency['code'] eq 'uah'} checked{/if}> Гривна
              </label>
              <label class="btn btn-radio{if $currency neq null && $currency['code'] eq 'usd'} active{/if}">
                <input type="radio" name="currency" value="usd" autocomplete="off"{if $currency neq null && $currency['code'] eq 'usd'} checked{/if}> Доллар
              </label>
            </div>
          </a>
          <a class="mt-4 p-4 content-block filter filter-viewmod d-flex justify-content-between" href="#">
            <span class="text-muted">Показать:</span>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
              <label class="btn btn-radio{if $viewmod neq null} active{/if}">
                <input type="radio" name="viewmod" value="nontbl" autocomplete="off"{if $viewmod neq null} checked{/if}> Списком
              </label>
              <label class="btn btn-radio{if $viewmod eq null} active{/if}">
                <input type="radio" name="viewmod" value="" autocomplete="off"{if $viewmod eq null} checked{/if}> Таблицей
              </label>
            </div>
          </a>
          <div class="error-text mt-3 text-center">
            <span>Для сравнения цен выберите продукцию</span>
          </div>
        </div>
        <a class="show" href="#">
        Показать трейдеров
        </a>
      </div>



      <div class="step-2 stp h-100">
        <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
        <div class="scroll">
          <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders_forwards/region_ukraine">
            <span>Форварды</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
          <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders{if $section eq 'buy'}_sell{/if}">
            <span>{if $section eq 'buy'}Продажи{else}Закупки{/if}</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
          <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders_analitic/region_ukraine">
            <span>Аналитика закупок</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
          <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders_analitic_sell">
            <span>Аналитика продаж</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
        </div>
      </div>
      <div class="step-3 stp h-100">
        <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
        <div class="scroll">
          {foreach from=$rubricsGroup item=g}
          <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="{$g['id']}">
            <span>{$g['name']}</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
          {/foreach}
        </div>
      </div>
      <div class="step-3-1 stp h-100">
        <a class="back py-3 px-4 content-block d-block" step="3" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
        <div class="scroll">
          <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" group="">
            <span></span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
          {foreach from=$rubrics item=groups key=group_id}
            {foreach from=$groups item=group}
              {foreach from=$group item=r}
          <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-{$group_id}" group="{$r['translit']}">
            <span>{$r['name']}</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
              {/foreach}
            {/foreach}
          {/foreach}
        </div>
      </div>
      <div class="step-4 stp h-100">
        <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
        <div class="scroll">
          <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between" region="0">
          <span style="font-weight: 600;">Вся Украина</span>
          <span><i class="far fa-chevron-right"></i></span>
          </a>
          <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between" region="1">
            <span>АР Крым</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
          {foreach from=$regions_list item=col}
            {foreach from=$col item=region}
          <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between" region="{$region['translit']}">
            <span>{$region['name']} область</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
            {/foreach}
          {/foreach}
          <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between" port="all">
            <span style="font-weight: 600;">Все порты</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
          {foreach from=$ports item=col}
            {foreach from=$col item=port}
          <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between" port="{$port['translit']}">
            <span>{$port['name']}</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
            {/foreach}
          {/foreach}
        </div>
      </div>
    </div>
  </div>
</div>
<div class="d-none d-sm-block container mt-3">
  <ol class="breadcrumbs small p-0">
    <li><a href="/"><span>Главная</span></a></li>
    {if $rubric neq null && $region eq null && $port eq null}
    <i class="fas fa-chevron-right extra-small"></i>
    <li><a href="{if $section eq 'buy'}/traders{else}/traders_sell{/if}"><span>{if $section eq 'buy'}Цены трейдеров{else}Продажи трейдеров{/if}</span></a></li>
    <i class="fas fa-chevron-right extra-small"></i>
    <li><h1>{$h1}</h1></li>
    {elseif $rubric eq null && ($region neq null or $port neq null)}
    <i class="fas fa-chevron-right extra-small"></i>
    <li><a href="{if $section eq 'buy'}/traders{else}/traders_sell{/if}"><span>{if $section eq 'buy'}Цены трейдеров{else}Продажи трейдеров{/if}</span></a></li>
    <i class="fas fa-chevron-right extra-small"></i>
    <li><h1>{$h1}</h1></li>
    {elseif $rubric neq null && ($region neq null or $port neq null)}
    <i class="fas fa-chevron-right extra-small"></i>
    <li><a href="{if $section eq 'buy'}/traders{else}/traders_sell{/if}"><span>{if $section eq 'buy'}Цены трейдеров{else}Продажи трейдеров{/if}</span></a></li>
    {if $section eq 'buy'}
    <i class="fas fa-chevron-right extra-small"></i>
    <li><a href="/traders/{if $rubric neq null}{$rubric['translit']}{elseif $port neq null}tport_{$port['translit']}{/if}"><span>Цена {if $rubric neq null}{$rubric['name']}{elseif $port neq null}{$port['name']}{/if}</span></a></li>
    {/if}
    <i class="fas fa-chevron-right extra-small"></i>
    <li><h1>{$h1}</h1></li>
    {else}
    <i class="fas fa-chevron-right extra-small"></i>
    <li><h1>{if $h1 neq ''}{$h1}{else}Цены трейдеров в {if $region['id'] eq null}Украине{else}{$region['parental']} области{/if}{/if}</h1></li>
    {/if}
  </ol>
</div> -->
{if $feed}
<div class="container mt-3 mt-sm-4 mb-3 mb-sm-0">
    <div class="content-block feed py-3 position-relative">
        <div class="swiper-container">
            <div class="swiper-wrapper mx-0 ">
                {foreach $feed as $item}
                {assign var=rubrics_count value=$item['r']|@count}
                <div class="swiper-slide">
                    <div class="feed-item row">
                        <div class="col-12 d-flex align-items-center">
                            <div class="circle{if $item@iteration is div by 2} two{/if} d-inline-block mr-1"></div> <a href="/kompanii/comp-{$item['company_id']}" class="title lh-1">{$item['company']|unescape|truncate:25:"..":true}</a>
                        </div>
                        <div class="col-12 prices">
                            <span class="price-{$item['onchange_class']} my-1">{$item['onchange']}</span>
                            {foreach from=$item['r'] item=rubrics key=rubric}
                            {if $rubrics@iteration eq 3}
                            {break}
                            {/if}
                            <div class="d-flex justify-content-between align-items-center ar">
                                <span class="rubric">{$rubric|unescape|truncate:18:"..":true}</span>
                                <div class="d-flex align-items-center lh-1 priceItem">
                                    {foreach $rubrics as $rubric_item}
                                    {foreach $rubric_item as $value}
                                    {if $value eq '0'}
                                    &nbsp;<img src="/app/assets/img/price-up.svg">
                                    {/if}
                                    {if $value eq '1'}
                                    &nbsp;<img src="/app/assets/img/price-down.svg">
                                    {/if}
                                    {/foreach}
                                    {/foreach}
                                </div>
                            </div>
                            {/foreach}
                        </div>
                        <div class="col-12 d-flex align-items-center justify-content-between mt-1">
                            <a href="/kompanii/comp-{$item['company_id']}" class="more">{if ($rubrics_count - 2) > 0}+ ещё {$rubrics_count - 2}{/if}</a>
                            <span class="time">{$item['change_time']}</span>
                        </div>
                    </div>
                </div>
                {/foreach}
            </div>
            <!-- Add Arrows -->
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
{/if}

<svg class="inline-svg">
    <symbol id="check" viewbox="0 0 12 10">
        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
    </symbol>
</svg>

<!--  <div class="header__wrap">
    <header class="new_header">
      <div class="new_container">
        <div class="header__flex header__desktop">
          <div class="logo-wrap">
            <a href="#" class="logo">
              <img src="https://agrotender.com.ua/app/assets/img/logo_white.svg" alt="logo" class="logo_desktop">
              <img src="https://agrotender.com.ua/app/assets/img/agromini.svg" alt="logo" class="logo_mobile">
            </a>
            <div class="hidden-links">
              <a href="#">
                <img src="https://agrotender.com.ua/app/assets/img/company/viber4.svg" alt="">
              </a>
              <a href="#">
                <img src="https://agrotender.com.ua/app/assets/img/company/telegram-white.svg" alt="">
              </a>
            </div>
          </div>
          <div class="header__center__buttons">
            <a href="https://agrotender.com.ua/board" class="header__center__button">Объявления</a>
            <div class="header__tradersPrice">
              <a href="https://agrotender.com.ua/traders" class="header__center__button withArrow">
                Цены Трейдеров
              </a>
              <div class="header__hoverElem-wrap">
                <div class="header__hoverElem">
                  <ul>
                    <li>
                      <a href="https://agrotender.com.ua/traders" class="header_fw600">Закупки</a>
                    </li>
                    <li>
                      <a href="https://agrotender.com.ua/traders_forwards/region_ukraine/pshenica_2_kl" class="header_fw600">Форварды</a>
                    </li>
                    <li>
                      <a href="https://agrotender.com.ua/traders_sell" class="header_fw600">Продажи</a>
                    </li>
                    <li>
                      <span class="line"></span>
                    </li>
                    <li>
                      <a href="https://agrotender.com.ua/tarif20.html" class="header__yellowText">Разместить компанию</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="header__tradersPrice special">
              <a href="https://agrotender.com.ua/traders" class="header__center__button withBg">
                <span class="header__tradersPrice-dots">
                  <span></span>
                  <span></span>
                  <span></span>
                </span>
              </a>
              <div class="header__hoverElem-wrap">
                <div class="header__hoverElem">
                  <ul>
                    <li>
                      <a href="https://agrotender.com.ua/traders">Компании</a>
                    </li>
                    <li>
                      <a href="https://agrotender.com.ua/elev">Элеваторы</a>
                    </li>
                    <li>
                      <span class="line"></span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="header__right">
            <a href="#" class="header__right__button">
              <span>Мой профиль</span>
              <img src="https://agrotender.com.ua/app/assets/img/profile.svg" alt="profile">
            </a>
            <div class="header__hoverElem-wrap">
              <div class="header__hoverElem">
                <ul>
                  <li>
                    <span>Цены трейдера:</span>
                  </li>
                  <li>
                    <a href="https://agrotender.com.ua/u/prices">Таблица закупок</a>
                  </li>
                  <li>
                    <a href="https://agrotender.com.ua/u/prices/contacts">Контакты трейдера</a>
                  </li>
                  <li>
                    <span>Моя Компания:</span>
                  </li>
                  <li>
                    <a href="https://agrotender.com.ua/u/company">Настройки</a>
                  </li>
                  <li>
                    <a href="https://agrotender.com.ua/u/contacts">Контакты</a>
                  </li>
                  <li>
                    <a href="https://agrotender.com.ua/u/posts">Объявления</a>
                  </li>
                  <li>
                    <a href="https://agrotender.com.ua/u/balance/pay">Пополнить баланс</a>
                  </li>
                  <li>
                    <span>Мой профиль:</span>
                  </li>
                  <li>
                    <a href="https://agrotender.com.ua/u/">Настройки</a>
                  </li>
                  <li>
                    <a href="https://agrotender.com.ua/logout" class="header__exit">Выход</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="header__mobile">
          <button class="header_drawerOpen-btn">
            <img src="https://agrotender.com.ua/app/assets/img/menu.svg" alt="">
          </button>
          <a href="/" class="header_logo_mobile">
            <img src="https://agrotender.com.ua/app/assets/img/logo_white.svg" alt="">
          </a>
          <a href="/" class="header_profile">
            <img src="https://agrotender.com.ua/app/assets/img/profile_white.svg" alt="">
          </a>
        </div>
        <div class="drawer">
          <div class="drawer_content">
            <div class="drawer__header">
              <a href="/" class="drawer__header-logo">
                <img src="https://agrotender.com.ua/app/assets/img/logo.svg" alt="">
              </a>
              <a href="#" class="drawer__header-social first">
                <img src="https://agrotender.com.ua/app/assets/img/company/telegram_m.svg" alt="">
              </a>
              <a href="#" class="drawer__header-social">
                <img src="https://agrotender.com.ua/app/assets/img/company/viber_m.svg" alt="">
              </a>
            </div>
            <ul class="drawer__list">
              <li>
                <a href="#">Главная</a>
              </li>
              <li>
                <a href="#">Объявления</a>
              </li>
              <li>
                <a href="#">Цены трейдеров</a>
              </li>
              <li>
                <a href="#">Компании</a>
              </li>
              <li>
                <a href="#">Элеваторы</a>
              </li>
            </ul>
            <div class="drawer_footer">
              <ul class="drawer__list">
                <li><a href="#">Выход</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </header>
  </div> -->

<div class="bg_filters"></div>

<div class="new_filters-wrap">
    <div class="replacement"></div>
    <div class="fixed-item">
        <div class="new_container">
            <div class="new_filters">
                <div class="filter__item main">
                    <button class="filter__button main">{if $section eq 'buy'}Закупки{else}Продажи{/if}</button>
                    <div class="new_filters_dropdown-wrap">
                        <div class="new_filters_dropdown">
                            <ul>
                                <li>
                                    <a href="/traders_forwards/region_ukraine">Форварды</a>
                                </li>
                                {if $section eq 'buy'}
                                <li>
                                    <a href="/traders_sell">Продажи</a>
                                </li>
                                {else}
                                <li>
                                    <a href="/traders/region_ukraine">Закупки</a>
                                </li>
                                {/if}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="filter__item producrion" id="choseProduct">
                    <button class="filter__button producrion-btn">{if $rubric eq null}Выбрать продукцию{else}{$rubric['name']}{/if}</button>
                    <div class="new_filters_dropdown-wrap">
                        <div class="new_filters_dropdown">
                            <div class="new_filters_dropdown-column">
                                <ul>
                                    {foreach from=$rubricsGroup item=g}
                                    <li class="{if $rubric['group_id'] eq $g['id']} active{/if}">
                                        <a href="#">{$g['name']}</a>
                                    </li>
                                    {/foreach}
                                </ul>
                            </div>
                            {foreach from=$rubrics item=groups key=group_id}
                            <div class="new_filters_dropdown-content {$group_id}">
                                {foreach from=$groups item=group}
                                <ul>
                                    {foreach from=$group item=r}
                                    <li>
                                        <a href="/traders{if $section eq 'sell'}_sell{/if}{if $region neq null}/region_{$region['translit']}{else if $port neq null or $onlyPorts eq 'yes'}/tport_{if $port neq null}{$port['translit']}{else}all{/if}{else}/region_ukraine{/if}/{$r['translit']}{if $currency !== null}?currency={$currency['code']}{/if}?viewmod=nontbl">{$r['name']}
                                            {foreach from=$r_count item=rc}
                                            {if $r['id'] eq $rc['id']}
                                            ({$rc['count']})
                                            {/if}
                                            {/foreach}
                                        </a>
                                    </li>
                                    {/foreach}
                                </ul>

                                {/foreach}
                            </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
                <div class="filter__item second" id="all_ukraine">
                    <button class="filter__button second">
                        {if $onlyPorts eq 'yes'}
                        Все порты
                        {else}
                        {if $region eq null}
                        {if $port eq null}
                        Вся Украина
                        {else}
                        {$port['name']}
                        {/if}
                        {elseif $region['id'] eq 1}
                        АР Крым
                        {else}
                        {$region['name']}
                        {/if}
                        {/if}
                    </button>
                    <div class="new_filters_dropdown-wrap">
                        <div class="new_filters_dropdown">
                            <div class="new_filters_dropdown-column">
                	<span class="d-block">
            <a href="/traders{if $section eq 'sell'}_sell{/if}/region_ukraine{if $rubric neq null}/{$rubric['translit']}{else}/index{/if}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'nontbl'}{if $currency !== null}&{else}?{/if}viewmod=nontbl{/if}">
            <span>Вся Украина</span>
          </a>
          <a href="/traders{if $section eq 'sell'}_sell{/if}/region_crimea/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'nontbl'}{if $currency !== null}&{else}?{/if}viewmod=nontbl{/if}">
            <span>АР Крым</span>
          </a>
          </span>
                                <ul>
                                    <li class="active">
                                        <a href="#">Области</a>
                                    </li>
                                    <li>
                                        <a href="#">Порты</a>
                                    </li>
                                </ul>
                                </ul>
                            </div>
                            <div class="new_filters_dropdown-content active">
                                <ul>
                                    {foreach from=$regions_list item=col}
                                    {foreach from=$col item=c}
                                    <li>
                                        <a href="/traders{if $section eq 'sell'}_sell{/if}/region_{$c['translit']}/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'nontbl'}{if $currency !== null}&{else}?{/if}viewmod=nontbl{/if}">
                                            {$c['name']}
                                        </a>
                                    </li>
                                    {/foreach}
                                    {/foreach}
                                </ul>
                            </div>
                            <div class="new_filters_dropdown-content">
                                <ul>
                                    {foreach from=$ports item=col}
                                    {foreach from=$col item=c}
                                    <li>
                                        <a href="/traders{if $section eq 'sell'}_sell{/if}/tport_{$c['translit']}/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $viewmod eq 'nontbl'}?viewmod=nontbl{/if}">
                                            {$c['name']}
                                        </a>
                                    </li>
                                    {/foreach}
                                    {/foreach}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="new_filters_checkbox first">
                    <input class="inp-cbx" id="new_filters_currency_uah" type="checkbox" />
                    <label class="cbx" for="new_filters_currency_uah">
            <span>
              <svg width="12px" height="10px">
                <use xlink:href="#check"></use>
              </svg>
            </span>
                        <span>ГРН</span>
                    </label>
                </div>
                <div class="new_filters_checkbox second">
                    <input class="inp-cbx" id="new_filters_currency_usd" type="checkbox" />
                    <label class="cbx" for="new_filters_currency_usd">
            <span>
              <svg width="12px" height="10px">
                <use xlink:href="#check"></use>
              </svg>
            </span>
                        <span>USD</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-none d-sm-block container mt-5">
    <div class="content-block mt-3 py-3 px-3">
        <div class="btn-group position-relative w-100 ">
            <div class="col pl-1">
                <button class="btn typeInput text-center drop-btn">{if $section eq 'buy'}Закупки{else}Продажи{/if} <i class="ml-2 small far fa-chevron-down"></i></button>
            </div>
            <div class="dropdown-wrapper position-absolute typeDrop">
                <div class="dropdown">
                    <div class="section text-left">
                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                        <div class="row">
                            <div class="col">
                                <a class="inline-link" href="/traders_forwards/region_ukraine">
                                    <span>Форварды</span>
                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                </a>
                                {if $section eq 'buy'}
                                <a class="inline-link" href="/traders_sell">
                                    <span>Продажи</span>
                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                </a>
                                {else}
                                <a class="inline-link" href="/traders/region_ukraine">
                                    <span>Закупки</span>
                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                </a>
                                {/if}
                                <a class="inline-link" href="/traders_analitic/region_ukraine">
                                    <span>Аналитика закупок</span>
                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                </a>
                                <a class="inline-link" href="/traders_analitic_sell">
                                    <span>Аналитика продаж</span>
                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col px-1 mx-1">
                <button class="btn rubricInput text-center drop-btn{if $viewmod eq null && $rubric eq null} blue-shadow{/if}">{if $rubric eq null}Выбрать продукцию{else}{$rubric['name']}{/if} <i class="ml-2 small far fa-chevron-down"></i></button>
            </div>
            <div class="dropdown-wrapper position-absolute rubricDrop">
                <div class="dropdown">
                    <div class="section text-left">
                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                        <div class="row">
                            <div class="col-auto">
                                {foreach from=$rubricsGroup item=g}
                                <a class="rubricLink getRubricGroup{if $rubric['group_id'] eq $g['id']} active{/if}" href="#" group="{$g['id']}">
                    <span>
                      {$g['name']}</span>
                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                </a>
                                {/foreach}
                            </div>
                            {foreach from=$rubrics item=groups key=group_id}
                            {foreach from=$groups item=group}
                            <div class="col-auto rubricGroup pr-0 mr-3 group-{$group_id}">
                                {foreach from=$group item=r}
                                <a rid="{$r['id']}" class="rubricLink{if $r['name'] eq $rubric['name']} active{/if}" href="/traders{if $section eq 'sell'}_sell{/if}{if $region neq null}/region_{$region['translit']}{else if $port neq null or $onlyPorts eq 'yes'}/tport_{if $port neq null}{$port['translit']}{else}all{/if}{else}/region_ukraine{/if}/{$r['translit']}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'nontbl'}{if $currency !== null}&{else}?{/if}viewmod=nontbl{/if}">
                                    <span>{$r['name']}</span>
                                </a>
                                {/foreach}
                            </div>
                            {/foreach}
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col px-2 mx-1">
                <button class="btn regionInput text-center drop-btn align-self-center">
                    {if $onlyPorts eq 'yes'}
                    Все порты
                    {else}
                    {if $region eq null}
                    {if $port eq null}
                    Вся Украина
                    {else}
                    {$port['name']}
                    {/if}
                    {elseif $region['id'] eq 1}
                    АР Крым
                    {else}
                    {$region['name']} область
                    {/if}
                    {/if}
                    <i class="ml-2 small far fa-chevron-down"></i>
                </button>
            </div>
            <div class="dropdown-wrapper position-absolute regionDrop">
                <div class="dropdown">
          <span class="d-block">
            <a class="regionLink d-inline-block{if $port eq null && $onlyPorts eq null && $region eq null} text-muted disabled"{else}"{/if} href="/traders{if $section eq 'sell'}_sell{/if}/region_ukraine{if $rubric neq null}/{$rubric['translit']}{else}/index{/if}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'nontbl'}{if $currency !== null}&{else}?{/if}viewmod=nontbl{/if}">
            <span>Вся Украина</span>
              </a>
              <a class="regionLink d-inline-block{if $region['id'] eq 1} text-muted disabled"{else}"{/if} href="/traders{if $section eq 'sell'}_sell{/if}/region_crimea/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'nontbl'}{if $currency !== null}&{else}?{/if}viewmod=nontbl{/if}">
            <span>АР Крым</span>
              </a>
          </span>
                    <hr class="mt-1 mb-2">
                    <div class="section text-left">
                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                        <div class="row">
                            {foreach from=$regions_list item=col}
                            <div class="col">
                                {foreach from=$col item=c}
                                <a class="regionLink{if $c['name'] eq $region['name']} active{/if}" href="/traders{if $section eq 'sell'}_sell{/if}/region_{$c['translit']}/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'nontbl'}{if $currency !== null}&{else}?{/if}viewmod=nontbl{/if}">
                                    <span>{$c['name']} область</span>
                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                </a>
                                {/foreach}
                            </div>
                            {/foreach}
                        </div>
                    </div>
                    {if $section eq 'buy'}
                    <br>
                    <span class="d-block">
            <a class="regionLink d-inline-block{if $onlyPorts eq 'yes'} text-muted disabled"{else}"{/if} href="/traders{if $section eq 'sell'}_sell{/if}/tport_all/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $viewmod eq 'nontbl'}?viewmod=nontbl{/if}">
            <span>Все порты</span>
                        </a>
          </span>
                    <hr class="mt-1 mb-2">
                    <div class="section text-left">
                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                        <div class="row">
                            {foreach from=$ports item=col}
                            <div class="col">
                                {foreach from=$col item=c}
                                <a class="regionLink{if $c['name'] eq $port['name']} active{/if}" href="/traders{if $section eq 'sell'}_sell{/if}/tport_{$c['translit']}/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $viewmod eq 'nontbl'}?viewmod=nontbl{/if}">
                                    <span>{$c['name']}</span>
                                    <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                                </a>
                                {/foreach}
                            </div>
                            {/foreach}
                        </div>
                    </div>
                    {/if}
                </div>
            </div>
            <div class="col px-2 mx-1">
                <button class="btn typeInput text-center drop-btn">{if $currency eq null}Валюта{else}{$currency['name']}{/if} <i class="ml-2 small far fa-chevron-down"></i></button>
            </div>
            <div class="dropdown-wrapper position-absolute currencyDrop">
                <div class="dropdown">
                    <div class="section text-left">
                        <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
                        <div class="row">
                            <div class="col">
                                {if $currency neq null}
                                <a class="inline-link" href="{$smarty.server.SCRIPT_URI}{if $viewmod eq 'nontbl'}?viewmod=nontbl{/if}">
                                    <span>Любая валюта</span>
                                </a>
                                {/if}
                                {foreach from=$currencies item=c key=key}
                                <a class="inline-link{if $currency['id'] === $c['id']} active{/if}" href="{$smarty.server.SCRIPT_URI}{if $viewmod eq 'nontbl'}?viewmod=nontbl&{else}?{/if}currency={$key}">
                                    <span>{$c['name']}</span>
                                </a>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {if $rubric neq null}
            <div class="d-flex align-items-center">
                <a class="text-center filter-icon mr-3{if $viewmod eq 'nontbl'} active{/if}" rel="nofollow" href="{$smarty.server.SCRIPT_URL}{if $currency !== null}?currency={$currency['code']}&{else}?{/if}viewmod=nontbl"><i class="fas fa-th-large"></i></a>
                <a class="text-center filter-icon{if $viewmod eq null} active{/if}" rel="nofollow" href="{$smarty.server.SCRIPT_URL}{if $currency !== null}?currency={$currency['code']}{/if}"><i class="fas fa-bars lh-1-1"></i></a>
            </div>
            {/if}
        </div>
    </div>
    <span class="popular" style="margin-top: 16px;display: block;">
  <span style="font-weight: 600; color: #707070;">
  <img src="/app/assets/img/speaker.svg" style="width: 24px; height: 24px"/>
   Популярные культуры: </span>
  <a href="/traders/region_ukraine/pshenica_2_kl" class="popular__block">Пшеница 2 кл.</a>
  <a href="/traders/region_ukraine/pshenica_3_kl" class="popular__block">Пшеница 3 кл.</a>
  <a href="/traders/region_ukraine/pshenica_4_kl" class="popular__block">Пшеница 4 кл.</a>
  <a href="/traders/region_ukraine/podsolnechnik" class="popular__block">Подсолнечник</a>
  <a href="/traders/region_ukraine/soya" class="popular__block">Соя</a>
  <a href="/traders/region_ukraine/yachmen" class="popular__block">Ячмень</a>
  </span>
</div>

<!-- Vip Traders Title -->
{if $vipTraders }
{if $viewmod eq 'nontbl' || $rubric eq null}


<div class="container mt-3 mt-sm-5">
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
                    <h2 class="d-inline-block text-uppercase">{if $rubric eq null}ТОП трейдеры{else}{$rubric['name']}{/if}</h2>
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
{/if}

{/if}

<!--End Vip Traders Title -->


<!-- VIP Traders Banner  -->

{if $viewmod eq 'nontbl' || $rubric eq null}
{if $traders neq null}
<div class="container mt-3 ">



    {foreach from=$vipTraders item=group}
    {if $group@index eq 3}{foreach $banners['traders'] as $banner}
    <div class="row mb-0 mb-sm-4 pb-sm-2 mx-0 justify-content-center align-items-center">

        {$banner}

    </div>
    {/foreach}
    {/if}
    <!-- End Vip Traders Banner -->

    <!-- VIP Traders -->





    {if $region neq null or $rubric neq null or $currency neq null}
    <div class="d-sm-none container pt-2 pt-sm-4">
        {if $rubric neq null}
        <span class="searchTag d-inline-block">{$rubric['name']} <a href="/traders{if $region neq null}/region_{$region['translit']}{else}/region_ukraine{/if}{if $currency neq null}?currency={$currency['code']}{/if}"><i class="far fa-times close ml-2"></i></a></span>
        {/if}
        {if $region neq null}
        <span class="searchTag d-inline-block">{if $region['id'] eq 1}АР Крым{else}{$region['name']} область{/if} <a href="/traders{if $rubric neq null}/{$rubric['translit']}{/if}{if $currency neq null}?currency={$currency['code']}{/if}"><i class="far fa-times close ml-2"></i></a></span>
        {/if}
        {if $currency neq null}
        <span class="searchTag d-inline-block">{$currency['name']} <a href="/traders{if $region neq null}/region_{$region['translit']}{else}/region_ukraine{/if}{if $rubric neq null}/{$rubric['translit']}{else}/index{/if}"><i class="far fa-times close ml-2"></i></a></span>
        {/if}
    </div>
    {/if}

    <div class="new_traders vip">
        {foreach name=group from=$group item=trader}
        <div class="traders__item-wrap">

            <a href="/kompanii/comp-{$trader['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}" class="traders__item {if $trader['top'] eq '1'} yellow{/if}">
                <div class="traders__item__header">
                    <span class="vip">ТОП</span>
                    <img class="traders__item__image" src="/{$trader['logo']}" alt="">
                </div>
                <div class="traders__item__content">
                    <div href="#" class="traders__item__content-title">
                        {$trader['title']|unescape|truncate:25:"...":true}
                    </div>
                    <div class="traders__item__content-description">
                        {foreach from=$trader['prices'] item=price}
                        <p class="traders__item__content-p">
                            <span class="traders__item__content-p-title">{$price['title']|unescape|truncate:14:"...":true}</span>
                            <span class="right">
                  <span class="traders__item__content-p-price {if $price['change_price'] neq ''}price-{$price['change_price']}" data-toggle="tooltip" data-placement="right" title="Старая цена: {if $price['currency'] eq 1}${/if}{$price['old_price']}"{else}"{/if}>{if $price['currency'] eq 1}$&nbsp;{/if}{$price['price']}</span>
                            <span class="traders__item__content-p-icon">
                     {if $price['change_price'] neq ''}<img src="/app/assets/img/price-{$price['change_price']}.svg">{/if}
                  {if $price['change_price'] eq ''}<img src="/app/assets/img/price-not-changed.svg">{/if}
                  </span>
                            </span>
                        </p>
                        {/foreach}
                    </div>
                    <div class="traders__item__content-date">
                        <!--               <span class="traders__item__content-date-more">+ ещё {$trader['review']['count']}</span> -->
                        {if $smarty.now|date_format:"%Y-%m-%d" eq $trader['date']}<span class="green">сегодня</span>{elseif "-1 day"|date_format:"%Y-%m-%d" eq $trader['date']}<span style="color:#FF7404;">вчера</span>{else}<span style="color:#001430;">{$trader['date2']}</span>{/if}
                    </div>
                </div>
            </a>
        </div>
        {/foreach}
    </div>



    {foreachelse}
    {/foreach}

</div>
<!-- End Vip Traders -->


{if $viewmod eq 'nontbl' || $rubric eq null}

{if $traders neq null}
<div class="container traders mt-3 mt-sm-5">
    <div class="row mt-sm-0 pt-sm-0 mb-sm-4">
        <div class="position-relative w-100">
            {if ! $vipTraders}
            <div class="col-12 col-md-9 float-md-right text-center text-md-right">
                <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end d-none d-sm-inline-block">
                    <i class="far fa-plus mr-2"></i>
                    <span class="pl-1 pr-1">Разместить компанию</span>
                </a>
            </div>
            {/if}
            <div class="col-12 col-md-3 float-left mt-sm-0 d-flex justify-content-between d-sm-block">
                <div class="col-6 col-sm-12 pl-0">
                    <h2 class="d-inline-block text-uppercase">{if $rubric eq null}Все трейдеры{else}{$rubric['name']}{/if}</h2>
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
{/if}
{/if}
{if $region neq null or $rubric neq null or $currency neq null}
<div class="d-sm-none container  pt-2 pt-sm-4">
    {if $rubric neq null}
    <span class="searchTag d-inline-block">{$rubric['name']} <a href="/traders{if $region neq null}/region_{$region['translit']}{else}/region_ukraine{/if}{if $currency neq null}?currency={$currency['code']}{/if}"><i class="far fa-times close ml-2"></i></a></span>
    {/if}
    {if $region neq null}
    <span class="searchTag d-inline-block">{if $region['id'] eq 1}АР Крым{else}{$region['name']} область{/if} <a href="/traders{if $rubric neq null}/{$rubric['translit']}{/if}{if $currency neq null}?currency={$currency['code']}{/if}"><i class="far fa-times close ml-2"></i></a></span>
    {/if}
    {if $currency neq null}
    <span class="searchTag d-inline-block">{$currency['name']} <a href="/traders{if $region neq null}/region_{$region['translit']}{else}/region_ukraine{/if}{if $rubric neq null}/{$rubric['translit']}{else}/index{/if}"><i class="far fa-times close ml-2"></i></a></span>
    {/if}
</div>
{/if}
<div class="new_container container mt-3 traders_dev">
    {foreach from=$traders item=group}
    <div class="new_traders ">
        {foreach name=group from=$group item=trader}
        <div class="traders__item-wrap">

            <a href="/kompanii/comp-{$trader['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}" class="traders__item {if $trader['top'] eq '1'} yellow{/if}">
                <div class="traders__item__header">
                    <img class="traders__item__image" src="/{$trader['logo']}" alt="">
                </div>
                <div class="traders__item__content">
                    <div href="#" class="traders__item__content-title">
                        {$trader['title']|unescape|truncate:25:"...":true}
                    </div>
                    <div class="traders__item__content-description">
                        {foreach from=$trader['prices'] item=price}
                        <p class="traders__item__content-p">
                            <span class="traders__item__content-p-title">{$price['title']|unescape|truncate:14:"...":true}</span>
                            <span class="right">
                  <span class="traders__item__content-p-price {if $price['change_price'] neq ''}price-{$price['change_price']}" data-toggle="tooltip" data-placement="right" title="Старая цена: {if $price['currency'] eq 1}${/if}{$price['old_price']}"{else}"{/if}>{if $price['currency'] eq 1}$&nbsp;{/if}{$price['price']}</span>

                            <span class="traders__item__content-p-icon">
                    {if $price['change_price'] neq ''}<img src="/app/assets/img/price-{$price['change_price']}.svg">{/if}
                  {if $price['change_price'] eq ''}<img src="/app/assets/img/price-not-changed.svg">{/if}
                  </span>
                            </span>
                        </p>
                        {/foreach}
                    </div>
                    <div class="traders__item__content-date">
                        <!--               <span class="traders__item__content-date-more">+ ещё {$trader['review']['count']}</span> -->
                        {if $smarty.now|date_format:"%Y-%m-%d" eq $trader['date']}<span class="green">сегодня</span>{elseif "-1 day"|date_format:"%Y-%m-%d" eq $trader['date']}<span style="color:#FF7404;">вчера</span>{else}<span style="color:#001430;">{$trader['date2']}</span>{/if}
                    </div>
                </div>
            </a>
        </div>
        {/foreach}
    </div>
    {/foreach}
    <!--     {if $rubric eq null}{foreach $banners['traders'] as $banner}
      <div class="row mb-0 mb-sm-4 pb-sm-2 mx-0 justify-content-center align-items-center">

        {$banner}

      </div>
          {/foreach}

    {/if} -->
</div>

<!-- <div class="container mt-3 traders">
  {foreach from=$traders item=group}
  {if $group@index eq 3}{foreach $banners['traders'] as $banner}
  <div class="row mb-0 mb-sm-4 pb-sm-2 mx-0 justify-content-center align-items-center">

    {$banner}

  </div>
 {/foreach}
  {/if}

<div class="row mb-0 mb-sm-4 pb-sm-2">


      {if $region neq null or $rubric neq null or $currency neq null}
<div class="d-sm-none container pt-2 pt-sm-4">
  {if $rubric neq null}
  <span class="searchTag d-inline-block">{$rubric['name']} <a href="/traders{if $region neq null}/region_{$region['translit']}{else}/region_ukraine{/if}{if $currency neq null}?currency={$currency['code']}{/if}"><i class="far fa-times close ml-2"></i></a></span>
  {/if}
  {if $region neq null}
  <span class="searchTag d-inline-block">{if $region['id'] eq 1}АР Крым{else}{$region['name']} область{/if} <a href="/traders{if $rubric neq null}/{$rubric['translit']}{/if}{if $currency neq null}?currency={$currency['code']}{/if}"><i class="far fa-times close ml-2"></i></a></span>
  {/if}
  {if $currency neq null}
  <span class="searchTag d-inline-block">{$currency['name']} <a href="/traders{if $region neq null}/region_{$region['translit']}{else}/region_ukraine{/if}{if $rubric neq null}/{$rubric['translit']}{else}/index{/if}"><i class="far fa-times close ml-2"></i></a></span>
  {/if}
</div>
{/if}

    {foreach name=group from=$group item=trader}
    <div class="col-6 col-sm-2 px-3 position-relative">
      <div class="row newTraderItem mx-0{if $trader['top'] eq '1'} top{/if}">
        <div class="col-12 d-flex px-0 justify-content-center wrap-logo">
          <a href="/kompanii/comp-{$trader['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}">
            <img class="logo" src="/{$trader['logo']}">
          </a>
        </div>
        <div class="col-12 px-0 date d-flex justify-content-center align-items-center">
          <span class="lh-1">{if $smarty.now|date_format:"%Y-%m-%d" eq $trader['date']}<span class="today">сегодня</span>{else}{$trader['date2']}{/if}</span>
        </div>
        <div class="col-12 px-0 d-flex justify-content-center align-items-center px-2 py-2 title text-center">
          <a href="/kompanii/comp-{$trader['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}">{$trader['title']}</a>
        </div>
        <div class="col-12 prices px-2">
          {foreach from=$trader['prices'] item=price}
          <div class="d-flex justify-content-between align-items-center ar">
            <span class="rubric">{$price['title']|unescape|truncate:18:"..":true}</span>
            <div class="d-flex align-items-center lh-1 priceItem">
              <span class="amount text-right {if $price['change_price'] neq ''}price-{$price['change_price']}" data-toggle="tooltip" data-placement="right" title="Старая цена: {if $price['currency'] eq 1}${/if}{$price['old_price']}"{else}"{/if}>{if $price['currency'] eq 1}${/if}{$price['price']}</span>
              &nbsp;{if $price['change_price'] neq ''}<img src="/app/assets/img/price-{$price['change_price']}.svg">{/if}
            </div>
          </div>
          {/foreach}
        </div>
        <div class="col-12 px-0 d-flex justify-content-between align-items-center px-2 pb-2 rating text-center">
          <a class="stars" href="/kompanii/comp-{$trader['id']}-reviews">
            {for $i=1 to 5}
            {if $i <= $trader['review']['rating']}
            <i class="fas fa-star"></i>
            {else}
            <i class="far fa-star"></i>
            {/if}
            {/for}
          </a>
          <a href="/kompanii/comp-{$trader['id']}-reviews"><span>{$trader['review']['count']}</span></a>
        </div>
      </div>
    </div>
    {/foreach}
  </div>
  {foreachelse}
  {/foreach}
 {if $rubric eq null}{foreach $banners['traders'] as $banner}
  <div class="row mb-0 mb-sm-4 pb-sm-2 mx-0 justify-content-center align-items-center">

    {$banner}

  </div>
      {/foreach}

{/if}
</div>
<div class="container mt-3">
  {if $traders neq null}
  <div class="text-center">
    {foreach $banners['bottom'] as $banner}
    {$banner}
    {/foreach}
  </div>
  {/if}
  <div class="container mt-4 mb-5">

  </div>
</div>
  {/if} -->
{else}
<div class="container mt-0 mt-sm-3">
    <div class="row pt-sm-3">
        <div class="position-relative w-100">
            <div class="col-12 col-md-9 float-md-right text-center text-md-right">
                <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end">
                    <i class="far fa-plus mr-2"></i>
                    <span class="pl-1 pr-1">Разместить компанию</span>
                </a>
            </div>
            {if $tableList neq null}
            <div class="col-12 col-md-3 float-left mt-4 mt-md-0 d-block">
                <h2 class="d-inline-block text-uppercase">Все трейдеры</h2>
            </div>
            {/if}
        </div>
    </div>
</div>
{if $rubric eq null}
<div class="container empty my-5">
    <div class="content-block p-5 position-relative text-center">
        <img class="get-rubric-img" src="/app/assets/img/get-rubric.png" style="transform: translateX(-50px);">
        <span class="get-rubric">Для сравнения цен выберите продукцию в рубрикаторе</span>
    </div>
</div>
{else}
{if $tableList neq null}
<div class="container pb-5 pb-sm-4 pt-4 mb-4 scroll-x">
    <table class="sortTable sortable{if !$detect->isMobile()} dTable{/if}" cellspacing="0">
        {if !$detect->isMobile()}
        <thead>
        <tr>
            <th>Компании</th>
            {if $currency eq null}
            <th class="sth">UAH <i class="fas fa-sort" style="font-size: 12px;"></i></th>
            <th class="sth">USD <i class="fas fa-sort" style="font-size: 12px;"></i></th>
            {else}
            {if $currency['code'] eq 'uah'}
            <th class="sth">UAH <i class="fas fa-sort" style="font-size: 12px;"></i></th>
            {else}
            <th class="sth">USD <i class="fas fa-sort" style="font-size: 12px;"></i></th>
            {/if}
            {/if}
            <th class="sth">Дата <i class="sort-date-icon fas fa-sort" style="font-size: 12px;"></i></th>
            <th>Место закупки</th>
        </tr>
        </thead>
        {/if}
        <tbody>
        {if !$detect->isMobile()}
        {foreach from=$tableList item=row}
        <tr{if $row['top'] eq 1 } class="vip"{/if} {if $row['top'] eq 2 } class="vip" style="background-color: #FFDA56;"{/if}>
        <td {if $row['top'] eq 2 } style="overflow: hidden; background-color: #FFDA56;" {/if}>
        {if $row['top'] eq 2 } <div class="ribbonTrade">ТОП</div> {/if}
        <a class="d-flex align-items-center" href="/kompanii/comp-{$row['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}">
            <img class="logo mr-3" src="/{$row['logo']}">
            <span class="title">{$row['title']}</span>
            {if $row['top'] eq 2}<span class="status">ТОП</span>{/if}
        </a>
        </td>
        {if $currency eq null}
        <td class="uah" {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
        {if $row['prices']['uah']['price'] neq null}
        <div class="d-flex align-items-center justify-content-center">
            <span class="price">{$row['prices']['uah']['price']}</span>{if $row['prices']['uah']['change_price'] neq ''}<span class="price{if $row['prices']['uah']['change_price'] neq ''}-{$row['prices']['uah']['change_price']}{/if}">  &nbsp;<img src="/app/assets/img/price-{$row['prices']['uah']['change_price']}.svg"> <span>{$row['prices']['uah']['price_diff']|ltrim:'-'}</span>{/if}</span>
        </div>
        {if isset($row['prices']['uah']['comment']) && $row['prices']['uah']['comment'] neq null}
        <span class="d-block text-muted extra-small">{$row['prices']['uah']['comment']}</span>
        {/if}
        {/if}
        </td>
        <td class="usd" {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
        {if $row['prices']['usd']['price'] neq null}
        <div class="d-flex align-items-center justify-content-center">
            <span class="price">{$row['prices']['usd']['price']}</span>{if $row['prices']['usd']['change_price'] neq ''}<span class="price{if $row['prices']['usd']['change_price'] neq ''}-{$row['prices']['usd']['change_price']}{/if}"> &nbsp;<img src="/app/assets/img/price-{$row['prices']['usd']['change_price']}.svg"> <span>{$row['prices']['usd']['price_diff']|ltrim:'-'}</span>{/if}</span>
        </div>
        {if isset($row['prices']['usd']['comment']) && $row['prices']['usd']['comment'] neq null}
        <span class="d-block text-muted extra-small">{$row['prices']['usd']['comment']}</span>
        {/if}
        {/if}
        </td>
        {else}
        {if $currency['code'] eq 'uah'}
        <td class="uah" {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
        {if $row['prices']['uah']['price'] neq null}
        <div class="d-flex align-items-center justify-content-center">
            <span class="price">{$row['prices']['uah']['price']}</span>{if $row['prices']['uah']['change_price'] neq ''}<span class="price{if $row['prices']['uah']['change_price'] neq ''}-{$row['prices']['uah']['change_price']}{/if}"> &nbsp;<img src="/app/assets/img/price-{$row['prices']['uah']['change_price']}.svg"> <span>{$row['prices']['uah']['price_diff']|ltrim:'-'}</span>{/if}</span>
        </div>
        {if isset($row['prices']['uah']['comment']) && $row['prices']['uah']['comment'] neq null}
        <span class="d-block text-muted extra-small">{$row['prices']['uah']['comment']}</span>
        {/if}
        {/if}
        </td>
        {else}
        <td class="usd" {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
        {if $row['prices']['usd']['price'] neq null}
        <div class="d-flex align-items-center justify-content-center">
            <span class="price">{$row['prices']['usd']['price']}</span>{if $row['prices']['usd']['change_price'] neq ''}<span class="price{if $row['prices']['usd']['change_price'] neq ''}-{$row['prices']['usd']['change_price']}{/if}"> &nbsp;<img src="/app/assets/img/price-{$row['prices']['usd']['change_price']}.svg"> <span>{$row['prices']['usd']['price_diff']|ltrim:'-'}</span>{/if}</span>
        </div>
        {if isset($row['prices']['usd']['comment']) && $row['prices']['usd']['comment'] neq null}
        <span class="d-block text-muted extra-small">{$row['prices']['usd']['comment']}</span>
        {/if}
        {/if}
        </td>
        {/if}
        {/if}
        <td {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if} data-sorttable-customkey="{$row['date']|date_format:"%Y%m%d"}"><span data-date="{$row['date']|date_format:"%Y%m%d"}">{if $smarty.now|date_format:"%Y-%m-%d" eq $row['date']}<span class="today">{$row['date2']}</span>{else}{$row['date2']}{/if}</span></td>
        <td {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
        <span class="location">{$row['location']}</span>
        {if $row['place'] neq null}
        <br>
        <span class="place">{$row['place']}</span>
        {/if}
        </td>
        </tr {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
        {/foreach}
        {else}
        {foreach from=$tableList item=row}
        <tr{if $row['top'] eq 1} class="vip"{/if} {if $row['top'] eq 2 } class="vip"{/if}>
        <td  {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
        <div class="d-flex align-items-center price-div" {if $row['top'] eq 2 } style="overflow: hidden; background-color: #FFDA56" {/if}   >
        {if $row['top'] eq 2 } <div class="ribbonTrade">ТОП</div> {/if}
        <!--  {if $row['top'] neq 2 } <div class="ribbonTrade"> &ensp;&ensp;&ensp;</div> {/if} -->

        <img class="logo mr-3" src="/{$row['logo']}" data-toggle="tooltip" data-placement="top" title="{$row['title']}">
        <a class="flex-1" href="/kompanii/comp-{$row['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}">
            {foreach from=$row['prices'] item=price}
            <span class="m-price">{if $price['currency'] eq 0}UAH{else}USD{/if}: <span class="price{if $price['change_price'] neq ''}-{$price['change_price']}{/if}">{$price['price']} {if $price['change_price'] neq ''} &nbsp;<i class="fas fa-chevron-{$price['change_price']}"></i> {$price['price_diff']|ltrim:'-'}{/if}</span></span>
            {/foreach}
        </a>
</div>
</td>
</tr>
<tr class="t2 {if $row['top'] eq 1} vip{/if}">
    <td style="border-bottom: 1px solid #295ca1;">
        <div class="d-flex align-items-center justify-content-center">
            <span data-toggle="tooltip" data-placement="top" class="d-block">{$row['date']|date_format:"%d.%m.%Y"}</span>
            <a href="/kompanii/comp-{$row['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}" class="d-block flex-1">
                <span class="location d-block">{$row['location']}</span>
                {if $row['place'] neq null}
                <span class="place d-block">{$row['place']}</span>
                {/if}
            </a>
        </div>
    </td>
</tr>
{/foreach}
{/if}
</tbody>
</table>
<div class="text-center mt-5">
    {foreach $banners['bottom'] as $banner}
    {$banner}
    {/foreach}
</div>
</div>
<div class="container mt-4 mb-5">
    {if $rubric neq null && $text neq '' && $pageNumber eq 1}
    {$text}
    {/if}
</div>
{/if}
{/if}
{/if}
{if ($traders eq null && $viewmod eq 'nontbl') or ($viewmod eq null && $tableList eq null && $rubric neq null)}
<div class="container empty my-5">
    <div class="content-block p-5">
        <span class="title">По Вашему запросу {if $section eq 'buy'}закупок{else}продаж{/if} не найдено</span>
        <a class="sub d-flex align-items-center" href="{if !$user->auth}/buyerreg{else}/u/notify{/if}"><img src="/app/assets/img/envelope.png" class="mr-3 mb-3 mt-3 mr-3"> Подписаться на изменение Цен Трейдеров</a>
        <span class="all">Предлагаем Вам ознакомиться с общим <a href="/traders{if $section neq 'buy'}_sell{/if}">списком трейдеров</a></span>
    </div>
</div>
{/if}
@endsection
