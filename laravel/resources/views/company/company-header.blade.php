<?php
$check_forwards = \App\Models\Comp\CompItems::where([
    ['id', $id], ['trader_price_forward_avail', 1], ['trader_price_forward_visible', 1], ['visible', 1]
])
    ->count();
?>
<div class="company-bg d-none d-sm-block">
    <img class="avatar" src="/pics/comp/5608_54749.jpg">
    <h1 class="title d-block mt-2">{!! !empty($company)  ? str_replace('\\', '', $company['title']) : '' !!} - Закупочные цены</h1>
    <div class="company-menu-container d-none d-sm-block">
        <div class="company-menu">
            <a href="{{route('company.index', $id)}}" class="{{$current_page == 'main' ? 'active' : ''}}" >Главная</a>
            @if($check_forwards != 0)
                <a href="{{route('company.forwards', $id)}}" class="" >Форварды</a>
            @endif
            <a href="{{route('company.reviews', $id)}}" class="{{$current_page == 'reviews' ? 'active' : ''}}">Отзывы</a>
            <a href="{{route('company.cont', $id)}}" class="{{$current_page == 'contact' ? 'active' : ''}}">Контакты</a>
        </div>
    </div>
</div>
