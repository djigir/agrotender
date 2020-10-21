<!DOCTYPE html>
<html lang="ru">
<head>
    <title>{{ $meta['title'] ?? '' }}</title>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="yandex-verification" content="19ad2285f183dd11" />
    @if(isset($meta['keywords']))
        <meta name="keywords" content="{{$meta['keywords']}}" />
    @endif

    @if(isset($meta['description']))
        <meta name="description" content="{{$meta['description']}}" />
    @endif

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
{{--    <link rel="stylesheet" href="/app/assets/css/landing.css">--}}
    <link rel="stylesheet" href="/app/assets/css/main.css">
    <link rel="stylesheet" href="/app/assets/css/multiple-select.css">
    <link rel="stylesheet" href="/app/assets/css/noty.css">
    <link rel="stylesheet" href="/app/assets/css/simplelightbox.min.css">
    <link rel="stylesheet" href="/app/assets/css/styles.css">
    <link rel="stylesheet" href="/app/assets/css/swiper.min.css">
    <!-- Required CSS -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-33473390-1"></script>
</head>

<body data-page="{$page}">

<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TJXZ542" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

<div class="header__wrap">
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
                        @if(isset($id))
                            <i class="far fa-chevron-circle-down userIcon mr-3"></i>
                        @else
                            <i class="far fa-search searchIcon mt-2 ml-2"></i>
                        @endif
                    </div>
{{--                    <div class="d-none d-sm-block float-right right-links p-3">--}}
{{--                        @if(isset($user->auth))--}}

{{--                        <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="head-name d-flex align-items-center position-relative">--}}
{{--                            <i class="fas fa-chevron-down mr-1"></i>--}}
{{--                            <span>{if $user->company neq null}{$user->company['title']}{else}{$user->name}{/if}</span>--}}
{{--                            <img src="{if $user->company neq null && $user->company['logo_file'] neq null}/{$user->company['logo_file']}{else}/app/assets/img/noavatar.png{/if}" class="ml-2 head-logo">--}}
{{--                            <span class="notification-badge top-badge"></span>--}}
{{--                        </a>--}}
{{--                        <div class="dropdown-menu mt-2 head-dropdown" aria-labelledby="dropdownMenuLink">--}}
{{--                            {if $user->company neq null && ($user->company['trader_price_avail'] eq 1 or $user->company['trader_price_sell_avail'] eq 1 or $user->company['trader_price_forward_avail'] eq 1)}--}}
{{--                            <h6 class="dropdown-header">Цены трейдеров:</h6>--}}
{{--                            {if $user->company['trader_price_avail'] eq 1}--}}
{{--                            <a class="dropdown-item" href="/u/prices">Таблица закупок</a>--}}
{{--                            {/if}--}}
{{--                            {if $user->company['trader_price_sell_avail'] eq 1}--}}
{{--                            <a class="dropdown-item" href="/u/prices?type=1">Таблица продаж</a>--}}
{{--                            {/if}--}}
{{--                            {if $user->company['trader_price_forward_avail'] eq 1}--}}
{{--                            <a class="dropdown-item{if $page eq 'user/pricesForward'} active{/if}" href="/u/prices/forwards">Форварды</a>--}}
{{--                            {/if}--}}
{{--                            {/if}--}}
{{--                            <a class="dropdown-item" href="/u/proposeds">Заявки <span class="notification-badge"></span></a>--}}
{{--                            <h6 class="dropdown-header">Объявления:</h6>--}}
{{--                            <a class="dropdown-item" href="/u/posts">Объявления</a>--}}
{{--                            <a class="dropdown-item" href="/u/balance/pay">Пополнить баланс</a>--}}
{{--                            <a class="dropdown-item" href="/u/posts/limits">Лимит объявлений</a>--}}
{{--                            <h6 class="dropdown-header">Профиль:</h6>--}}
{{--                            <a class="dropdown-item" href="/u/company">Компания</a>--}}
{{--                            <a class="dropdown-item" href="/u/contacts">Контакты</a>--}}
{{--                            <a class="dropdown-item" href="/logout">Выход</a>--}}
{{--                        </div>--}}
{{--                        @else--}}
{{--                        <a href="/buyerlog">Войти</a> &nbsp;|&nbsp; <a href="/buyerreg">Регистрация</a>--}}
{{--                        <a href="/login">Войти</a> &nbsp;|&nbsp; <a href="/register">Регистрация</a>--}}
{{--                        @endif--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
        <div class="d-none d-sm-flex justify-content-center align-items-center">
            <ul class="menu-links m-0 p-0">
                <li>
                    <a href="/board" class="menu-link">Объявления</a>
                </li>
                <li>
                    <a href="{{route('company.companies')}}" class="menu-link">Компании</a>
                </li>
                <li>
                    <a href="{{route('traders.traders_regions', 'ukraine')}}" class="menu-link">Цены Трейдеров</a>
                </li>
                <li>
                    <a href="/elev" class="menu-link">Элеваторы</a>
                </li>
                <li>
                    <a href="{{route('traders.traders_regions_culture', ['ukraine', 'pshenica_2_kl'])}}" class="menu-link">Форварды</a>
                </li>
            </ul>
        </div>
        @include('menu.mobile_menu')
    </header>
    <main class="main" role="main" data-page="{$page}">
        <div id="loading"></div>
        {{--            <div class="container text-center mt-3 mb-3 tradersImages position-relative">--}}
        {{--                <div class="d-block d-sm-inline-block tradersImgBlock"><noindex><a class="topBanners" href="https://agrotender.com.ua/kompanii/comp-812.html" rel="nofollow"><img style="width:310px; height:70px;" id="topBan325" src="/files/pict/Virtus370x100_tel-.png" class="img-responsive tradersImg" alt=""></a></noindex></div>--}}
        {{--                <div class="d-block d-sm-inline-block tradersImgBlock"><noindex><a class="topBanners" href="http://zernotrans.com.ua" rel="nofollow" target="_blank"><img style="width:310px; height:70px;" id="topBan403" src="/files/pict/zernotlans_light.jpg" class="img-responsive tradersImg" alt=""></a></noindex></div>--}}
        {{--                <div class="d-block d-sm-inline-block tradersImgBlock"><noindex><a class="topBanners" href="https://agrotender.com.ua/reklama" rel="nofollow"><img style="width:310px; height:70px;" id="topBan390" src="/files/pict/ad_buys.png" class="img-responsive tradersImg" alt=""></a></noindex></div>--}}
        {{--            </div>--}}
        <div class="filters-wrap" style="display: none;">
            <div class="filters-inner">
                <div class="filters arrow-t">
                    <div class="step-1 stp" style="">
                        <div class="mt-3">
                            <span class="title ml-3 pt-3">Настройте фильтры:</span>
                        </div>
                        <div class="position-relative mt-3">
                            <input type="text" class="pl-4 pr-5 py-4 content-block filter-search" placeholder="Я ищу.." value="">
                            <i class="far fa-search searchFilterIcon"></i>
                        </div>
                        <a id="mobile-rubric" class="mt-4 p-4 content-block filter filter-rubric d-flex justify-content-between" href="#" rubric="0">
                            <span>Выберите рубрику</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </a>
                        <a id="mobile-region" class="mt-4 p-4 content-block filter filter-region d-flex justify-content-between" href="#" region="0 ">
                            <span>Вся Украина</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </a>
                        <a class="show showCompanies" href="#">
                            Показать компании
                        </a>
                    </div>
                    <div class="step-3 stp h-100" style="display: none;">
                        <a class="back py-3 px-4 content-block d-block" step="1" href="#">
                            <span class="back" id="back">
                                <i class="far fa-chevron-left mr-1"></i>
                                Назад
                            </span>
                        </a>
                        <div class="scroll">
                            @if(isset($rubricGroups))
                                @foreach($rubricGroups as $index_group => $rubricGroup)
                                    <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="{{$rubricGroup['id']}}">
                                        <span>{{$rubricGroup['title']}}</span>
                                        <span><i class="far fa-chevron-right"></i></span>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="step-3-1 stp h-100" style="display: none;">
                        <a class="back py-3 px-4 content-block d-block" step="3" href="#">
                            <span id="back3">
                                <i class="far fa-chevron-left mr-1"></i>
                                Назад
                            </span>
                        </a>
                        <div class="scroll">
                            @if(isset($rubricGroups))
                                @foreach($rubricGroups as $index_group => $rubricGroup)
                                    @foreach($rubricGroup['comp_topic'] as $index_culture => $culture)
                                        <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-{{$rubricGroup['id']}}"  rubricId="{{$culture['id']}}">
                                            <span>{{$culture['title']}} &nbsp;
{{--                                               <span class="companyCount small"😠{$rgi['count']})</span> --}}
                                            </span>
                                            <span><i class="far fa-chevron-right"></i></span>
                                        </a>
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="step-4 stp h-100" style="display: none;">
                        <a class="back py-3 px-4 content-block d-block" step="1" href="#">
                            <span id="back2">
                                <i class="far fa-chevron-left mr-1"></i>
                                Назад
                            </span>
                        </a>
                        <div class="scroll">
                            @if(isset($regions))
                                @foreach($regions as $index_region => $region)
                                    <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="0">
                                        @if($region['name'] == 'Вся Украина' or $region['name'] == 'АР Крым')
                                            <span>{{$region['name']}}</span>
                                        @else
                                            <span>{{$region['name']}} область</span>
                                        @endif
                                        <span>
                                            <i class="far fa-chevron-right"></i>
                                        </span>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="company-bg d-none d-sm-block">--}}
{{--            <a href="/kompanii/comp-{$company['id']}">--}}
{{--                {if $company['logo_file'] neq null}--}}
{{--                <img class="avatar" src="/{$company['logo_file']}" class="ml-2 head-logo">--}}
{{--                {/if}--}}
{{--                {if $page eq 'company/main'}--}}
{{--                <h1 class="title d-block mt-2">{$company['title']}{if $trader eq '1' && $company['trader_price_avail'] eq 1 && $company['trader_price_visible'] eq 1} - Закупочные цены{/if}</h1>--}}
{{--                {else}--}}
{{--                <span class="title d-block mt-2">{$company['title']}</span>--}}
{{--                {/if}--}}
{{--            </a>--}}
{{--            <div class="company-menu-container d-none d-sm-block">--}}
{{--                <div class="company-menu">--}}
{{--                    {$menu}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </main>
</div>
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
