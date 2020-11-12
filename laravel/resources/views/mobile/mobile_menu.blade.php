<?php
$check_forwards = \App\Models\Comp\CompItems::where([
    'id' => $id,
    'trader_price_forward_avail' => 1,
    'trader_price_forward_visible' => 1,
    'visible' => 1
])->count();
?>
<div class="overlay"></div>
<div class="mobileMenu">
    <div class="container p-0">
        <div class="mobileHeader row mx-0 px-3">
            <a class="col-9" href="/u/">
                {{--{if $user->company neq null}{$user->company['title']}{else}{$user->name}{/if}--}}
            </a>
            <a href="/logout" class="right float-right logout col-3">Выход</a>
        </div>
        <div class="links">
            <a href="#">Обьявления</a>
            <a href="{{route('company.companies')}}">Компании</a>
            <a href="{{route('traders.region', 'ukraine')}}">Цены Трейдеров</a>
            <a href="{{route('elev.elevators')}}">Элеваторы</a>
            <a href="#">Форварды</a>
        </div>
    </div>
</div>

<div class="userMobileMenu" style="display: none">
    <div class="d-flex head py-2 px-4 align-items-center justify-content-between">
        <a id='one-back' class=" main" href="#"><i class="far fa-chevron-left mr-1"></i> Назад</a>
        <img class="avatar" src="{{(!empty($company) &&  $company['logo_file']) ? $company['logo_file'] : '/app/assets/img/noavatar.png'}}">
    </div>
    <div class="items d-flex flex-column justify-content-between">
        @if(isset($id))
            <a href="{{route('company.index', $id)}}" class="menu-item" >Главная</a>
            @if($check_forwards != 0)
                <a href="{{route('company.forwards', $id)}}" class="menu-item" >Форварды</a>
            @endif
            <a href="{{route('company.reviews', $id)}}" class="menu-item">Отзывы</a>
            <a href="{{route('company.cont', $id)}}" class="menu-item">Контакты</a>
        @endif
    </div>
</div>

