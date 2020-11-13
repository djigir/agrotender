@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    <div class="submenu d-none d-sm-block text-center">
        <a href="/u/" class="active">Авторизация</a>
        <a href="/u/contacts">Контакты</a>
        <a href="/u/notify">Уведомления</a>
        <a href="/u/reviews">Отзывы</a>
        <a href="/u/company">Компания</a>
    </div>
@endsection
