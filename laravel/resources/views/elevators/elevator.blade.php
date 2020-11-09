@extends('layout.layout')

@section('content')
    <div class="container elevItem pt-3 mb-5">
        <ul class="breadcrumbs small p-0">
            <li><a href="/"><span>Агротендер</span></a></li>
            <i class="fas fa-chevron-right extra-small"></i>
            <li><a href="/elev"><span>Элеваторы</span></a></li>
            <i class="fas fa-chevron-right extra-small"></i>
            <li><a href="/elev/dnepr"><span>Днепропетровской область</span></a></li>
            <i class="fas fa-chevron-right extra-small"></i>
            <li><h1>Зерно-Агро</h1></li>
        </ul>
        <div class="row mx-0 d-flex pt-2 pt-sm-5">
            <div class="col-auto pl-1">
                <img src="/app/assets/img/granary-4.png" class="logo">
            </div>
            <div class="col pl-1 text-left d-flex align-items-center">
                <span class="title">{{$elevator['lang_elevator']['name']}}</span>
            </div>
        </div>
        <div class="content-block w-100 mt-3 mt-sm-5 py-2">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Адрес:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{!! $elevator['lang_elevator']['addr'] !!}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Юридический адрес:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{!! $elevator['lang_elevator']['addr'] !!}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Директор:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{{$elevator['lang_elevator']['director']}}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Телефоны:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{{$elevator['phone']}}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Хранение:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{{$elevator['lang_elevator']['holdcond']}}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Email:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{{$elevator['email']}}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Услуги по подработке:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{{$elevator['lang_elevator']['descr_podr']}}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Услуги по определению качества:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{{$elevator['lang_elevator']['descr_qual']}}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
