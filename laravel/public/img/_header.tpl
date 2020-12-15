<!doctype html>
<html lang="ru">
  <head>
    <title>{$title}</title>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {if isset($keywords)}
    <meta name="keywords" content="{$keywords}" />
    {/if}
    {if isset($description)}
    <meta name="description" content="{$description}" />
    {/if}
    <!-- Icons -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,800|Roboto:300,400,500" rel="stylesheet">
    <!-- Required CSS -->
    {$header}
    {if $page eq 'board/index' && isset($pageNumber) && $pageNumber > 1}
    <link rel="canonical" href="https://agrotender.com.ua{if $query neq null}/s/{$query}{/if}/board/{if $region neq null}region_{$region['translit']}/{/if}{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}.html"/>
    {/if}
    {if $page|in_array:['main/traders','main/traders-s','main/traders-f'] && isset($viewmod) && $viewmod eq 'tbl'}
    <link rel="canonical" href="https://agrotender.com.ua{$smarty.server.SCRIPT_URL}"/>
    {/if}
    {if $page eq 'main/companies' or $page eq 'main/companies-r'}
    <link rel="canonical" href="https://agrotender.com.ua/kompanii/{if $region neq null}region_{$region['translit']}/{/if}{if $rubric neq null}/t{$rubric['id']}{/if}.html"/>
    {/if}
    <!-- Google Tag Manager -->
    {literal}<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-TJXZ542');</script>{/literal}
    <!-- End Google Tag Manager -->
  </head>
  <body page="{$page}">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TJXZ542"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="wrap">
      <header class="header">
        <div class="top container">
          <div class="row">
            <div class="col-9 col-sm-6">
              <div class="float-left">
                <a href="/"><img src="/app/assets/img/logo.svg" class="p-2"></a>
                <a href="viber://pa?chatURI=agrotender_bot&text=Начать">
                  <img src="/app/assets/img/company/viber.svg" style="width: 24px"/>
                </a>
                <a href="https://t.me/AGROTENDER_bot">
                  <img src="/app/assets/img/company/telegram.svg" style="width: 20px"/>
                </a>
                {if $page eq 'main/main'}
                <h1 class="align-self-center align-middle logo-text d-none d-lg-inline-block pl-2">Присоединяйся!</h1>
                {else}
                <span class="align-self-center align-middle logo-text d-none d-lg-inline-block pl-2">Присоединяйся!</span>
                {/if}
              </div>
            </div>
            <div class="col d-flex align-items-center justify-content-end">
              <div class="float-right d-inline-block d-sm-none">
                {if $page|in_array:['board/index','board/advert', 'main/traders', 'main/traders-s', 'main/traders-f', 'main/traders_analitic', 'main/traders_analitic-s', 'main/companies', 'main/companies-r', 'main/companies-s']}
                <i class="far fa-search filtersIcon mr-3"></i>
                {/if}
                <div class="burger align-self-center align-middle">
                  <div></div>
                  <div></div>
                  <div></div>
                </div>
              </div>
              <div class="d-none d-sm-block float-right right-links p-3">
                {if $user->auth}
                <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="head-name d-flex align-items-center position-relative">
                  <i class="fas fa-chevron-down mr-1"></i>
                  <span>{if $user->company neq null}{$user->company['title']}{else}{$user->name}{/if}</span>
                  <img src="{if $user->company neq null && $user->company['logo_file'] neq null}/{$user->company['logo_file']}{else}/app/assets/img/noavatar.png{/if}" class="ml-2 head-logo">
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
                  <a class="dropdown-item" href="/u/balance/pay">Пополнить баланс</a>
                  <a class="dropdown-item" href="/u/posts/limits">Лимит объявлений</a>
                  <h6 class="dropdown-header">Профиль:</h6>
                  <a class="dropdown-item" href="/u/company">Компания</a>
                  <a class="dropdown-item" href="/u/contacts">Контакты</a>
                  <a class="dropdown-item" href="/logout">Выход</a>
                </div>
                {else}
                <a href="/buyerlog.html">Войти</a> &nbsp;|&nbsp; <a href="/buyerreg.html">Регистрация</a>
                {/if}
              </div>
            </div>
          </div>
        </div>
        <div class="d-none d-sm-flex justify-content-center align-items-center">
          <ul class="menu-links m-0 p-0">
            {$desktop}
            <li>
              <a href="https://agrotender.com.ua/traders_forwards/region_ukraine/pshenica_2_kl.html?viewmod=tbl" class="menu-link">
              <b>Форварды<sup style="color: #ffd16d"> new</sup></b>
              </a>
            </li>
          </ul>
        </div>
        <div class="overlay"></div>
        <div class="mobileMenu" style="">
          <div class="container p-0">
            <div class="mobileHeader row mx-0 px-3">
              {if $user->auth}
              <a href="/u/" class="col-9">{if $user->company neq null}{$user->company['title']}{else}{$user->name}{/if}</a>
              <a href="/buyerlog.html" class="right float-right logout col-3">Выход</a>
              {else}
              <a href="/buyerreg.html" class="col-8">Регистрация</a>
              <a href="/buyerlog.html" class="right float-right col-4">Вход</a>
              {/if}
            </div>
            <div class="links">
              {$mobile}
              <a href="https://agrotender.com.ua/traders_forwards/region_ukraine/pshenica_2_kl.html?viewmod=tbl">
              <b>Форварды<sup style="color: #ffd16d"> new</sup></b>
              </a>
            </div>
          </div>
        </div>
      </header>
      {if $page == 'main/traders-new'}
      <a href="https://agrotender.com.ua/traders.html" class="sidesLink" style="background: url('/files/b2.jpg');" rel="nofollow"> <img src="/files/b2.jpg"> </a>
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
        <div class="container text-center mt-3 tradersImages position-relative">
        {foreach $banners['top'] as $banner}
        {$banner}
        {/foreach}
        </div>
        {/if}