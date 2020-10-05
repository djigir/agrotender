<!doctype html>
<html lang="ru">
  <head>
    <title>{$title}</title>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="yandex-verification" content="19ad2285f183dd11" />
    {if isset($keywords)}
    <meta name="keywords" content="{$keywords}" />
    {/if}
    {if isset($description)}
    <meta name="description" content="{$description}" />
    {/if}
    <!-- Icons -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,800" rel="stylesheet">
    <!-- Required CSS -->
    {$header}
    {if $page eq 'board/index' && isset($pageNumber) && $pageNumber > 1}
    <link rel="canonical" href="https://agrotender.com.ua{if $query neq null}/s/{$query}{/if}/board/{if $region neq null}region_{$region['translit']}/{/if}{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}"/>
    {/if}
    {if $page|in_array:['main/traders','main/traders-s','main/traders-f'] && isset($viewmod) && $viewmod eq 'tbl'}
    <link rel="canonical" href="https://agrotender.com.ua{$smarty.server.SCRIPT_URL}"/>
    {/if}
    {if $page eq 'main/companies' or $page eq 'main/companies-r'}
    <link rel="canonical" href="https://agrotender.com.ua/kompanii/{if $region neq null}region_{$region['translit']}/{/if}{if $rubric neq null}/t{$rubric['id']}{/if}"/>
    {/if}
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-33473390-1"></script>

  </head>
  <body data-page="{$page}">
    
    <div class="">
      <header class="header">
        <div class="top container">
          <div class="row">
            <div class="col-1 d-flex align-items-center justify-content-start d-sm-none">
              <div class="float-left d-inline-block d-sm-none">
                <div class="burger align-self-center align-middle">
                  <div></div>
                  <div></div>
                  <div></div>
                </div>
              </div>
            </div>
            <div class="col-10 col-sm-6">
              <div class="float-left">
                <a href="/"><img alt="" src="/app/assets/img/logo6.svg" class="p-2" style="height: 50px;" /></a>
                <a href="viber://pa?chatURI=agrotender_bot&text=" id="viberHead" >
                  <img alt="" src="/app/assets/img/company/viber.svg" style="width: 24px" />
                </a>
                <a href="https://t.me/AGROTENDER_bot" id='telegramHead'>
                  <img alt="" src="/app/assets/img/company/telegram.svg" style="width: 20px" />
                </a>
                {if $page eq 'main/main'}
                <span class="align-self-center align-middle logo-text d-none d-lg-inline-block pl-2">Присоединяйся!</span>
                {else}
                <span class="align-self-center align-middle logo-text d-none d-lg-inline-block pl-2">Присоединяйся!</span>
                {/if}
              </div>
            </div>
            <div class="col-1 col-sm-6 d-flex align-items-center justify-content-end">
              <div class="float-right d-inline-block d-sm-none">
                {if $page|in_array:['board/index','board/advert', 'main/traders', 'main/traders-s', 'main/traders-f', 'main/traders_analitic', 'main/traders_analitic-s', 'main/companies', 'main/companies-r', 'main/companies-s']}
                <i class="far fa-search filtersIcon mr-3"></i>
                {/if}
              </div>
              <div class="d-none d-sm-block float-right right-links p-3">
                {if $user->auth}
                <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="head-name d-flex align-items-center position-relative">
                  <i class="fas fa-chevron-down mr-1"></i>
                  <span>{if $user->company neq null}{$user->company['title']}{else}{$user->name}{/if}</span>
                  <img alt="" src="{if $user->company neq null && $user->company['logo_file'] neq null}/{$user->company['logo_file']}{else}/app/assets/img/noavatar.png{/if}" class="ml-2 head-logo">
                  <span class="notification-badge top-badge"></span>
                </a>
                <div class="dropdown-menu mt-2 head-dropdown" aria-labelledby="dropdownMenuLink">

                  {if $user->company neq null && ($user->company['trader_price_avail'] eq 1 or $user->company['trader_price_sell_avail'] eq 1 or $user->company['trader_price_forward_avail'] eq 1)}
                  <h6 class="dropdown-header">Цены трейдеров:</h6>
                    {if $user->company['trader_price_avail'] eq 1}
                  <a class="dropdown-item" href="/u/prices">Таблица закупок</a>
                    {/if}
                    {if $user->company['trader_price_sell_avail'] eq 1}
                  <a class="dropdown-item" href="/u/prices?type=1">Таблица продаж</a>
                    {/if}
                    {if $user->company['trader_price_forward_avail'] eq 1}
                  <a class="dropdown-item{if $page eq 'user/pricesForward'} active{/if}" href="/u/prices/forwards">Форварды</a>
                    {/if}
                  {/if}
                  <a class="dropdown-item" href="/u/proposeds">Заявки <span class="notification-badge"></span></a>
                  <h6 class="dropdown-header">Объявления:</h6>
                  <a class="dropdown-item" href="/u/posts">Объявления</a>
                  <a class="dropdown-item" href="">Баланс: {$user->balance} грн</a>
                  <a class="dropdown-item" href="/u/balance/pay">Пополнить баланс</a>

                  <a class="dropdown-item" href="/u/posts/limits">Лимит объявлений</a>
                  <h6 class="dropdown-header">Профиль:</h6>
                  <a class="dropdown-item" href="/u/company">Компания</a>
                  <a class="dropdown-item" href="/u/contacts">Контакты</a>
                  <a class="dropdown-item" href="/logout">Выход</a>
                </div>
                {else}
                <a href="/buyerlog">Войти</a> &nbsp;|&nbsp; <a href="/buyerreg">Регистрация</a>
                {/if}
              </div>
            </div>
          </div>
        </div>
        <div class="d-none d-sm-flex justify-content-center align-items-center">
          <ul class="menu-links m-0 p-0">
          {* {$desktop} *}
            <li>
              <a href="/board" class="menu-link">Объявления</a>
            </li>
            <li>
              <a href="/kompanii" class="menu-link">Компании</a>
            </li>
            <li>
              <a href="/traders/region_ukraine" class="menu-link">Цены Трейдеров</a>
            </li>
            <li>
              <a href="/elev" class="menu-link">Элеваторы</a>
            </li>
            <li> 
              <a href="/traders_forwards/region_ukraine/pshenica_2_kl" class="menu-link">Форварды</a>
            </li>
             
          </ul>
        </div>
        <div class="overlay"></div>
        <div class="mobileMenu">
          <div class="container p-0">
            <div class="mobileHeader row mx-0 px-3">
              {if $user->auth}
              <a href="/u/" class="col-9">{if $user->company neq null}{$user->company['title']}{else}{$user->name}{/if}</a>
              <a href="/logout" class="right float-right logout col-3">Выход</a>
              {else}
              <a href="/buyerreg" class="col-8">Регистрация</a>
              <a href="/buyerlog" class="right float-right col-4">Вход</a>
              {/if}
            </div>
            <div class="links">
             {* {$mobile} *}
              <a href="/board">Объявления</a>
              <a href="/kompanii">Компании</a>
              <a href="/traders/region_ukraine">Цены Трейдеров</a>
              
              <a href="/elev">Элеваторы</a>
              <a href="/traders_forwards/region_ukraine/pshenica_2_kl">
              <b>Форварды<sup style="color: #ffd16d"> new</sup></b>
              </a>
            </div>
          </div>
        </div>
<!-- 
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
  </div> -->

  <!-- <div class="bg_filters"></div> -->

  
      {foreach $banners['header'] as $banner}
      {$banner}
      {/foreach}

       </header>
  </div>

     
      </header>
      {if $page == 'main/traders-new'}
      <a href="https://agrotender.com.ua/traders" class="sidesLink" style="background: url('/files/b2.jpg');" rel="nofollow"> <img alt="" src="/files/b2.jpg"> </a>
      {else}
      {if !in_array($page, ['main/reklama', 'main/signin', 'main/signup', 'main/restore', 'board/add', 'board/edit', 'board/success', 'main/act', 'main/thankyou', 'main/error', 'main/success', 'main/404', 'main/changeEmail', 'main/sitemap', 'main/addTrader'])}
      {foreach $banners['body'] as $banner}
      {$banner}
      {/foreach}
      {/if}
      {/if}
      <main class="main" role="main" data-page="{$page}">
        <div id="loading">
          <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
          </div>
        </div>
        {if $page neq 'main/addTrader' && $page neq 'main/reklama'}

        <div class="container text-center mt-3 mb-3 tradersImages position-relative">
        {foreach $banners['top'] as $banner}
        {$banner}
        {/foreach}
        </div>
        {/if}