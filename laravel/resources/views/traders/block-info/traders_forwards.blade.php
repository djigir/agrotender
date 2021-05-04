<?php
$route_name = \Route::getCurrentRoute()->getName();
$prefix = substr($route_name, 0, strpos($route_name, '.')).'.';
?>
<div class="container empty my-5">
    <div class="content-block p-5">
        <span class="title">По Вашему запросу закупок не найдено</span><br>
        <span class="all">Предлагаем Вам ознакомиться с общим
            <a href="{{route($prefix.'region', 'ukraine')}}">списком трейдеров</a>
        </span>
    </div>
</div>
