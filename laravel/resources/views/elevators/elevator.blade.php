@extends('layout.layout')

@section('content')
    <div class="new_container elevItem pt-3 mb-5">
        <ul class="breadcrumbs small p-0">
            <li><a href="/"><span>Агротендер</span></a></li>
            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z" fill="#93A2BA"/>
            </svg>
            <li><a href="{{route('elev.elevators')}}"><span>Элеваторы</span></a></li>
            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z" fill="#93A2BA"/>
            </svg>
            @foreach($breadcrumbs as $index_bread => $breadcrumb)
                <li>
                    @if($breadcrumb['url'])
                        <a href="{{$breadcrumb['url']}}">
                            <h1>{!! $breadcrumb['name'] !!}</h1>
                        </a>
                    @else
                        <h1>{!! $breadcrumb['name'] !!}</h1>
                    @endif
                </li>
                @if(isset($breadcrumb['arrow']))
                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z" fill="#93A2BA"/>
                    </svg>
                @endif
            @endforeach
        </ul>
        <div class="row mx-0 d-flex">
            <div class="col-auto pl-1">
                <img src="/app/assets/img/silo.svg" class="logo">
            </div>
            <div class="col pl-1 text-left d-flex align-items-center">
                <span class="title">{!! $elevator->lang_elevator[0]['orgname'] !!}</span>
            </div>
        </div>
        <div class="content-block w-100 mt-3 py-2">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Адрес:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{!! $elevator->lang_elevator[0]->addr !!}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Юридический адрес:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{!! $elevator->lang_elevator[0]->orgaddr !!}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Директор:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{{$elevator->lang_elevator[0]->director}}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Телефоны:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{{$elevator->phone}}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Хранение:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{{$elevator->lang_elevator[0]->holdcond}}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Email:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{{$elevator->email}}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Услуги по подработке:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{{$elevator->lang_elevator[0]->descr_podr}}</span>
                </div>
            </div>
            <hr class="m-0">
            <div class="row m-0 py-1 p-sm-3">
                <div class="col-12 col-sm-5 text-sm-right">
                    <b>Услуги по определению качества:</b>
                </div>
                <div class="col-12 col-sm-7">
                    <span>{{$elevator->lang_elevator[0]->descr_qual}}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
