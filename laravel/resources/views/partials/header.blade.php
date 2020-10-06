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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,800|Roboto:300,400,500" rel="stylesheet">
    <link rel="stylesheet" href="/app/assets/css/noty/mint.css">
    <link rel="stylesheet" href="/app/assets/css/noty/nest.css">
    <link rel="stylesheet" href="/app/assets/css/bill.css">
    <link rel="stylesheet" href="/app/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/app/assets/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/app/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="/app/assets/css/imagelightbox.css">
    <link rel="stylesheet" href="/app/assets/css/jquery.dmenu.css">
    <link rel="stylesheet" href="/app/assets/css/jquery.jgrowl.min.css">
    <link rel="stylesheet" href="/app/assets/css/landing.css">
    <link rel="stylesheet" href="/app/assets/css/main.css">
    <link rel="stylesheet" href="/app/assets/css/multiple-select.css">
    <link rel="stylesheet" href="/app/assets/css/noty.css">
    <link rel="stylesheet" href="/app/assets/css/simplelightbox.min.css">
    <link rel="stylesheet" href="/app/assets/css/styles.css">
    <link rel="stylesheet" href="/app/assets/css/swiper.min.css">
    <!-- Required CSS -->
    {$header}
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-33473390-1"></script>
    <style>
        .tableScroll::-webkit-scrollbar  {
            background: transparent;
        }
        .tableScroll.orange::-webkit-scrollbar-thumb {
            background-color: #ffa800 !important;
            border-bottom-left-radius: 10px !important;
            border-bottom-right-radius: 10px !important;
        }
        .tableScroll.blue::-webkit-scrollbar-thumb {
            background-color: #1056B2 !important;
            border-bottom-left-radius: 10px !important;
            border-bottom-right-radius: 10px !important;
        }
        .tableSecond {
            position: absolute;
            z-index: 2;
            width: 100%;
            left: 0;
            top: 0;
            right: 0;
        }
        .tableFirst .py-1 {
            position: relative;
            overflow: hidden;
        }
        .tableFirst .py-1:before {
            content: '';
            transform: rotate(180deg);
            right: 0;
            top: 0;
            left: calc(100% - 15px);
            bottom: 0;
            position: absolute;
            box-shadow: rgba(167, 167, 167, 0.62) -17px 1px 18px -18px inset;
        }
        .tableSecond:before {
            content: ''
        }
        .tableSecond .tableScroll {
            position: absolute; left: 240px; width: calc(100% - 240px); overflow-x: scroll;
        }
        .tableSecond .tableScroll tbody{
            position: relative
        }
        .tableSecond .tableScroll tbody:before {
            content: '';
            position: absolute;
            left: 0;
            width: 10px;
            right: 0;
            z-index: 9;
        }
        .tableSecond .tableScroll:before {
            content: ''
        }
    </style>
</head>
<body data-page="{$page}">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TJXZ542"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="wrap">
    <header class="header">
        <div class="top container">
            <div class="row">
                <div class="col-1 d-flex align-items-center justify-content-start d-sm-none">
                    <div class="float-right d-inline-block d-sm-none">
                        <div class="burger align-self-center align-middle">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <div class="col-10 col-sm-6">
                    <div class="float-left">
                        <a href="/"><img src="/app/assets/img/logo6.svg" class="p-2" style="height: 50px;"></a>
                        <a id="viberHead" href="viber://pa?chatURI=agrotender_bot&text=">
                            <img src="/app/assets/img/company/viber.svg" style="width: 24px"/>
                        </a>
                        <a id="telegramHead" href="https://t.me/AGROTENDER_bot">
                            <img src="/app/assets/img/company/telegram.svg" style="width: 20px"/>
                        </a>
                        <span class="align-self-center align-middle logo-text d-none d-lg-inline-block pl-2">Присоединяйся!</span>
                    </div>
                </div>
                <div class="col-1 col-sm-6 d-flex align-items-center justify-content-end">
                    <div class="float-right d-inline-block d-sm-none">
                        <i class="far fa-chevron-circle-down userIcon mr-3"></i>
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
                        <a href="/buyerlog">Войти</a> &nbsp;|&nbsp; <a href="/buyerreg">Регистрация</a>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none d-sm-flex justify-content-center align-items-center">
            <ul class="menu-links m-0 p-0">
                {$desktop}
                <li>
                    <a href="https://agrotender.com.ua/traders_forwards/region_ukraine/kukuruza?viewmod=tbl" class="menu-link">Форварды</a>
                </li>
            </ul>
        </div>
        <div class="overlay"></div>
        <div class="mobileMenu">
            <div class="container p-0">
                <div class="mobileHeader row mx-0 px-3">
                    <a class="col-9" href="/u/">{if $user->company neq null}{$user->company['title']}{else}{$user->name}{/if}</a>
                    <a href="/logout" class="right float-right logout col-3">Выход</a>
                </div>
                <div class="links">
                    {$mobile}
                    <a href="https://agrotender.com.ua/traders_forwards/region_ukraine/kukuruza?viewmod=tbl">Форварды</a>
                </div>
            </div>
        </div>
        <div class="userMobileMenu">
            <div class="d-flex head py-2 px-4 align-items-center justify-content-between">
                <a class="back main" href="#">< Назад</a>
                <img class="avatar" src="{if $company['logo_file'] neq null}/{$company['logo_file']}{else}/app/assets/img/noavatar.png{/if}">
            </div>
            <div class="items d-flex flex-column justify-content-between">
                {$menu}
                <a href="https://agrotender.com.ua/traders_forwards/region_ukraine/pshenica_2_kl?viewmod=tbl">Форварды</a>
            </div>
        </div>
    </header>
    <main class="main" role="main" data-page="{$page}">
        <div id="loading">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="company-bg d-none d-sm-block">
            <a href="/kompanii/comp-{$company['id']}">
                {if $company['logo_file'] neq null}
                <img class="avatar" src="/{$company['logo_file']}" class="ml-2 head-logo">
                {/if}
                {if $page eq 'company/main'}
                <h1 class="title d-block mt-2">{$company['title']}{if $trader eq '1' && $company['trader_price_avail'] eq 1 && $company['trader_price_visible'] eq 1} - Закупочные цены{/if}</h1>
                {else}
                <span class="title d-block mt-2">{$company['title']}</span>
                {/if}
            </a>
            <div class="company-menu-container d-none d-sm-block">
                <div class="company-menu">
                    {$menu}
                </div>
            </div>
        </div>
    </main>
</div>
