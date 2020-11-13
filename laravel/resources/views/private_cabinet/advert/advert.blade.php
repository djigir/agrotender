@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    <div class="container submenu d-none d-sm-block text-left">
        <a href="/u/posts" class="active">Активные (0)</a>
        <a href="/u/posts?archive=1">Неактивные (0)</a>
    </div>
    <div class="container mt-4 mb-5 p-0">
        <h2 class="ml-3 mb-3 d-sm-none">Объявления <a href="/board/addpost" class="float-right text-orange mr-3">+ Создать</a></h2>
        <div class="content-block profile-posts nv">
            <div class="posts-head py-3 px-4 d-flex justify-content-between align-items-center">
                <div><span>Сортировка: </span> <a class="ml-3" href="/u/posts">По дате</a> <a class="ml-3" href="/u/posts?sort=title">По заголовку</a></div>
                <a href="/board/addpost" class="btn btn-warning float-right">Добавить объявление</a>
            </div>
            <div class="block d-flex py-2 justify-content-center align-items-center">
                У Вас нет активных объявлений.
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3 align-items-center">
            <select class="custom-select col-3">
                <option selected="">Выберите действие</option>
                <option value="1">Удалить</option>
                <option value="3">Переместить в неактивные</option>
            </select>
            <button class="btn btn-primary action-btn ml-3">Выполнить</button>
        </div>
    </div>
@endsection
