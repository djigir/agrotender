<!DOCTYPE html>
<html lang="ru">
<head>
    <title>{!! $meta['meta_title'] ?? '' !!}</title>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="yandex-verification" content="19ad2285f183dd11"/>
    @if(isset($meta['meta_keywords']))
        <meta name="keywords" content="{{$meta['meta_keywords']}}"/>
    @endif

    @if(isset($meta['meta_description']))
        <meta name="description" content="{{$meta['meta_description']}}"/>
    @endif

<!-- Icons -->
    <style>
        .preloader_new {
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            background: #EFF1F5;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
            transition: 300ms all ease;
        }

        .preloader_new.hidden {
            opacity: 0;
            z-index: 0;
            pointer-events: none;
        }

        .sk-chase {
            width: 40px;
            height: 40px;
            position: relative;
            animation: sk-chase 2.5s infinite linear both;
        }

        .sk-chase-dot {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            animation: sk-chase-dot 2.0s infinite ease-in-out both;
        }

        .sk-chase-dot:before {
            content: '';
            display: block;
            width: 25%;
            height: 25%;
            background-color: #143573;
            border-radius: 100%;
            animation: sk-chase-dot-before 2.0s infinite ease-in-out both;
        }

        .sk-chase-dot:nth-child(1) { animation-delay: -1.1s; }
        .sk-chase-dot:nth-child(2) { animation-delay: -1.0s; }
        .sk-chase-dot:nth-child(3) { animation-delay: -0.9s; }
        .sk-chase-dot:nth-child(4) { animation-delay: -0.8s; }
        .sk-chase-dot:nth-child(5) { animation-delay: -0.7s; }
        .sk-chase-dot:nth-child(6) { animation-delay: -0.6s; }
        .sk-chase-dot:nth-child(1):before { animation-delay: -1.1s; }
        .sk-chase-dot:nth-child(2):before { animation-delay: -1.0s; }
        .sk-chase-dot:nth-child(3):before { animation-delay: -0.9s; }
        .sk-chase-dot:nth-child(4):before { animation-delay: -0.8s; }
        .sk-chase-dot:nth-child(5):before { animation-delay: -0.7s; }
        .sk-chase-dot:nth-child(6):before { animation-delay: -0.6s; }

        @keyframes sk-chase {
            100% { transform: rotate(360deg); }
        }

        @keyframes sk-chase-dot {
            80%, 100% { transform: rotate(360deg); }
        }

        @keyframes sk-chase-dot-before {
            50% {
                transform: scale(0.4);
            } 100%, 0% {
                  transform: scale(1.0);
              }
        }
    </style>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,800|Roboto:300,400,500"
          rel="stylesheet">
    <link rel="stylesheet" href="/app/assets/css/noty/mint.css">
    <link rel="stylesheet" href="/app/assets/css/noty/nest.css">
    <link rel="stylesheet" href="/app/assets/css/bill.css">
    <link rel="stylesheet" href="/app/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/app/assets/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/app/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="/app/assets/css/imagelightbox.css">
    <link rel="stylesheet" href="/app/assets/css/jquery.dmenu.css">
    <link rel="stylesheet" href="/app/assets/css/jquery.jgrowl.min.css">
    {{--    <link rel="stylesheet" href="/app/assets/css/landing.css">--}}
    <link rel="stylesheet" href="/app/assets/css/main.css">
    <link rel="stylesheet" href="/app/assets/css/multiple-select.css">
    <link rel="stylesheet" href="/app/assets/css/noty.css">
    <link rel="stylesheet" href="/app/assets/css/simplelightbox.min.css">
    <link rel="stylesheet" href="/app/assets/css/styles.css?d=12">
    <link rel="stylesheet" href="/app/assets/css/swiper.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
          integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="/app/assets/css/my-header.css">
{{--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">--}}
<!-- Required CSS -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-33473390-1"></script>
    <script src="//code-ya.jivosite.com/widget/wCymYduPKb" async></script>
</head>
<body data-page="{$page}">

<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TJXZ542" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
</noscript>
<div class="">

    <div class="bg_filters"></div>
    <div class="header__wrap">
        <header class="new_header">
            <div class="new_container">
                <div class="header__flex header__desktop">
                    <div class="logo-wrap">
                        <a href="/" class="logo">
                            <img src="/app/assets/img/logo_white.svg" alt="logo" class="logo_desktop">
                            <img src="/app/assets/img/agromini.svg" alt="logo" class="logo_mobile">
                        </a>
                        <div class="hidden-links">
                            <a href="viber://pa?chatURI=agrotender_bot&text=">
                                <img src="/app/assets/img/company/viber4.svg" alt="">
                            </a>
                            <a href="https://t.me/AGROTENDER_bot">
                                <img src="/app/assets/img/company/telegram-white.svg" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="header__center__buttons" id="traders_prices_dropdown_parent">
                        <div class="header__tradersPrice first no_hoverable flex">
                            <a href="{{route('traders.region', 'ukraine')}}" class="header__center__button">
                                Цены Трейдеров
                            </a>
                            <div class="header__tradersPrice-line"></div>
                            <button class="header__tradersPrice-arrow"></button>
                            <div class="header__hoverElem-wrap">
                                <div class="header__hoverElem" id="traders_prices_dropdown">
                                    <ul>
                                        <li>
                                            <a href="{{route('traders.region', 'ukraine')}}">Закупки</a>
                                        </li>
                                        <li>
                                            <a href="{{route('traders_forward.region', 'ukraine')}}">Форварды</a>
                                        </li>
                                        <li>
                                            <a href="{{route('elev.elevators')}}">Элеваторы</a>
                                        </li>
                                        <li>
                                            <a href="{{route('company.companies')}}">Компании</a>
                                        </li>
                                        <li>
                                            <a href="/tarif20.html" class="header__yellowText">Разместить компанию</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <a href="/board" class="header__center__button board">Объявления</a>
                    </div>
                    <div class="header__right">
                        <a href="{{auth()->user() ? '/u/' : '/buyerlog'}}" class="header__right__button">
                            <span>Мой профиль</span>
                            <img src="/app/assets/img/profile.svg" alt="profile">
                        </a>
                        <div class="header__hoverElem-wrap">
                            <div class="header__hoverElem">
                            @if(auth()->user())
                                <!-- if user authed -->
                                    <ul>
                                        <li>
                                            <span>Цены трейдера:</span>
                                        </li>
                                        <li>
                                            <a href="/u/prices">Таблица закупок</a>
                                        </li>
                                        <li>
                                            <a href="/contacts">Контакты трейдера</a>
                                        </li>
                                        <li>
                                            <span>Моя Компания:</span>
                                        </li>
                                        <li>
                                            <a href="/u/company">Настройки</a>
                                        </li>
                                        <li>
                                            <a href="/u/contacts">Контакты</a>
                                        </li>
                                        <li>
                                            <a href="/u/posts">Объявления</a>
                                        </li>
                                        <li>
                                            <span class="balance_title">Баланс</span>
                                            <span class="balance_amount zero_balance"><b>{{auth()->user()->getBalance()}}</b> грн</span>
                                            <a class="balance_top_up" href="/u/balance/pay">+ Пополнить баланс</a>
                                        </li>
                                        <li>
                                            <span>Мой профиль:</span>
                                        </li>
                                        <li>
                                            <a href="/u/">Настройки</a>
                                        </li>
                                        <li>
                                            <a href="/logout" class="header__exit">Выход</a>
                                        </li>
                                    </ul>
                            @else
                                <!-- if user not authed -->
                                    <ul>
                                        <li>
                                            <a href="/buyerreg"><b>Зарегистрироваться</b></a>
                                        </li>
                                        <li>
                                            <a href="/buyerlog">Войти</a>
                                        </li>
                                        <li>
                                            <span class="bordered_line"></span>
                                        </li>
                                        <li>
                                            <a href="/tarif20.html" class="header__yellowText">Разместить компанию</a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header__mobile">
                    <button class="header_drawerOpen-btn">
                        <img src="/app/assets/img/menu.svg" alt="">
                    </button>
                    <a href="/" class="header_logo_mobile">
                        <img src="/app/assets/img/logo_white.svg" alt="">
                    </a>
                    @if(auth()->user())
                        <a href="/u" class="header_profile">
                            <img src="/app/assets/img/profile_white.svg" alt="">
                        </a>
                    @else
                        <a href="/buyerlog" class="header_profile">
                            <img src="/app/assets/img/profile_white.svg" alt="">
                        </a>
                    @endif
                </div>
                <div class="drawer">
                    <div class="drawer_content">
                        <div class="drawer__header">
                            <a href="/" class="drawer__header-logo">
                                <img src="/app/assets/img/logo.svg" alt="">
                            </a>
                            <a href="https://t.me/AGROTENDER_bot" class="drawer__header-social first">
                                <img src="/app/assets/img/company/telegram_m.svg" alt="">
                            </a>
                            <a href="viber://pa?chatURI=agrotender_bot&text=" class="drawer__header-social">
                                <img src="/app/assets/img/company/viber_m.svg" alt="">
                            </a>
                        </div>
                        <ul class="drawer__list">
                            <li>
                                <a href="/" >Главная</a>
                            </li>
                            <li>
                                <a href="/board">Объявления</a>
                            </li>
                            <li>
                                <a href="{{route('traders.region', 'ukraine')}}" class="{{$page_type == 1 ? 'active' : ''}}">Цены трейдеров</a>
                            </li>
                            <li>
                                <a href="{{route('traders_forward.region', 'ukraine')}}" class="{{$page_type == 3 ? 'active' : ''}}">Форварды</a>
                            </li>
                            <li>
                                <a href="{{route('company.companies')}}" class="{{$page_type == 0 ? 'active' : ''}}">Компании</a>
                            </li>
                            <li>
                                <a href="{{route('elev.elevators')}}" class="{{$page_type == 2 ? 'active' : ''}}">Элеваторы</a>
                            </li>
                        </ul>
                        @if(auth()->user())
                            <div class="drawer_footer">
                                <ul class="drawer__list">
                                    <li><a href="/logout">Выход</a></li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>
    </div>
    @if(!$isMobile && !isset($id))
        @include('partials.banners.body')
    @endif
</div>

<div class="preloader_new">
    <div class="sk-chase ">
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
    </div>
</div>

<main class="main">
    <div id="loading"></div>
    @if(!isset($id))
        @include('partials.banners.head')
    @endif
    <style>
        .remove-input{
            position: absolute;
            background: none;
            width: 100%;
            height: 10%;
            margin-top: -12px;
            border: none;
            outline: none;
            opacity: 0;
            pointer-events: none;
        }

        .remove-style-btn{
            border: none;
            outline: none !important;

        }
    </style>
