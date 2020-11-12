<?php
$route_name = \Route::getCurrentRoute()->getName();
$prefix = substr($route_name, 0, strpos($route_name, '.')).'.';
?>
<div class="container empty my-5">
    <div class="content-block p-5">
        <span class="title">По Вашему запросу закупок не найдено</span>
        <a class="sub d-flex align-items-center" href="/buyerreg">
            <img src="/app/assets/img/envelope.png" class="mr-3 mb-3 mt-3 mr-3"> Подписаться на изменение Цен Трейдеров</a>
        <span class="all">Предлагаем Вам ознакомиться с общим
            <a href="{{route($prefix.'region', 'ukraine')}}">списком трейдеров</a>
        </span>
    </div>
</div>
