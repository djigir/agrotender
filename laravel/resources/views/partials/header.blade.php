<!DOCTYPE html>
<html lang="ru">
<head>
    <title>{!! $meta['title'] ?? '' !!}</title>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="yandex-verification" content="19ad2285f183dd11"/>
    @if(isset($meta['keywords']))
        <meta name="keywords" content="{{$meta['keywords']}}"/>
    @endif

    @if(isset($meta['description']))
        <meta name="description" content="{{$meta['description']}}"/>
    @endif

<!-- Icons -->
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
    <link rel="stylesheet" href="/app/assets/css/styles.css">
    <link rel="stylesheet" href="/app/assets/css/swiper.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
          integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="/app/assets/css/my-header.css">
    <!-- Required CSS -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-33473390-1"></script>
</head>

<body data-page="{$page}">

<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TJXZ542" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
</noscript>
<div class="">
    <header class="header">
        <div class="top container">
            <div class="row" style="{{$isMobile ? 'flex-wrap: nowrap' : ''}}">
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
                @if(!$isMobile)
                    @include('partials.auth')
                @endif

                <div class="col-1 col-sm-6 d-flex align-items-center justify-content-end">
                    <div class="float-right d-inline-block d-sm-none">
                        @if(isset($id))
                            <i class="far fa-chevron-circle-down userIcon mr-3"></i>
                        @else
                            <i class="far fa-search searchIcon mobile-icon mt-2 ml-2"></i>
                        @endif
                    </div>
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
                    <a href="{{route('traders.region', 'ukraine')}}" class="menu-link">Цены Трейдеров</a>
                </li>
                <li>
                    <a href="/elev" class="menu-link">Элеваторы</a>
                </li>
                <li>
                    <a href="{{route('traders_forward.region_culture', ['ukraine', 'pshenica_2_kl'])}}"
                       class="menu-link">Форварды</a>
                </li>
            </ul>
        </div>
        @include('mobile.mobile_menu')
    </header>
    @if(!$isMobile && !isset($id))
        @include('partials.banners.body')
    @endif
</div>
<main class="main" role="main" data-page="{$page}">
    <div id="loading"></div>
    @if(!isset($id) && $page_type != 1)
        @include('partials.banners.head')
    @endif
    @if($isMobile)
        @if($page_type == 0)
            @include('mobile.filters.mobile-filter-companies')
        @else
            @include('mobile.filters.mobile-filter-traders')
        @endif
    @endif
    @if(!isset($id))
        @include('partials.header-scroll')
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
        }

        .remove-style-btn{
            border: none;
            outline: none !important;

        }
    </style>
