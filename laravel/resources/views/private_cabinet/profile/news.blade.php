@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.profile.profile_header')
    <div class="container mt-4 mb-5 nv">
        <div class="content-block mx-0 mx-sm-5">
            <div class="pb-5 pt-4 px-4 lh-1">
                <div class="d-inline-block pt-3 pt-sm-2">
                    <span>Всего новостей:
                        <span class="count">
                            <b>{{$news->count()}}</b>
                        </span>
                    </span>
                </div>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addNews">Добавить
                    новость
                </button>
            </div>
            @if($news->count() == 0)
                <div class="block row py-4 px-4 mx-0 justify-content-center">
                    Список новостей пуст
                </div>
            @endif
            @foreach($news as $index => $newsItems)
                <div class="block row py-4 px-4 mx-0">
                    <div class="col-3 col-sm-auto p-0">
                        <span class="date small">{{$newsItems->add_date->toDateTimeString()}}</span>
                    </div>
                    <div class="col-7 col-sm pl-4">
                        <span class="d-block title"><b>{{$newsItems->title}}</b></span>
                    </div>
                    <div class="col-1 col-sm-auto">
                        <i class="fas fa-pencil-alt edit cursor-pointer mr-2 editNews" newsid="{{$newsItems->id}}"></i>
                        <i class="fas fa-times remove text-danger cursor-pointer deleteNews" newsid="{{$newsItems->id}}"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="addNews" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form class="form modal-content"  action="{{route('user.profile.action_news')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title ml-3">Добавить новость</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none;">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body pt-4">
                    <div class="form-group">
                        <label class="col col-form-label">Заголовок <span class="text-danger">*</span></label>
                        <div class="col pl-1">
                            <input type="text" class="form-control" placeholder="Заголовок" name="title">
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="col col-form-label">Изображение</label>
                        <div class="col pl-1 d-flex align-items-center">
{{--                            <img class="logo" src="/app/assets/img/nophoto.png" id="add-news-prev">--}}
                            <img class="logo" id="add-news-prev" src="">
                            <span class="ml-3 select-image">Выбрать изображение</span>
                            <input type="file" name="logo" class="d-block hidden-type-file" id="input-add-news">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col col-form-label">Описание <span class="text-danger">*</span></label>
                        <div class="col pl-1">
                            <textarea class="form-control" rows="7" name="content"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-block btn-primary px-5 add-news">Отправить</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade show" id="editNews" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form class="form modal-content edit-news-form" idNews="" id="form-edit" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="news_id" class="id_news_form_edit" value="">
                <div class="modal-header">
                    <h5 class="modal-title ml-3">Редактирование новости</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body pt-4">
                    <div class="form-group">
                        <label class="col col-form-label">Заголовок <span class="text-danger">*</span></label>
                        <div class="col pl-1">
                            <input type="text" class="form-control" placeholder="Заголовок" name="title" id="titleItems">
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <label class="col col-form-label">Изображение</label>
                        <div class="col pl-1 d-flex align-items-center">
                            <img class="logo prev-img" id="logo_edit" src="">
                            <span class="ml-3 select-image">Выбрать изображение</span>
                            <input type="file" name="logo" class="d-block hidden-type-file prev-input" id="logo_edit_input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col col-form-label">Описание <span class="text-danger">*</span></label>
                        <div class="col pl-1">
                            <textarea class="form-control" rows="7" name="content" id="contentItems"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-block btn-primary px-5 save-edit-news close-form" id="save-edit-news">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
    @if ($errors->any())
        <div id="noty_layout__bottomLeft" role="alert" aria-live="polite" class="noty_layout animate__animated animate__fadeInRightBig animate__faster" style="display: block">
            <div id="noty_bar_9da52369-9ae9-49da-858f-5f3687604672"
                 class="noty_bar noty_type__error noty_theme__nest noty_close_with_click noty_has_timeout noty_has_progressbar">
                <div class="noty_body">{{ $errors->first() }}</div>
                <div class="noty_progressbar" style="transition: width 4000ms linear 0s; width: 0%;"></div>
            </div>
        </div>
    @endif


    <div id="noty_layout__bottomLeft" role="alert" aria-live="polite" class="noty_layout animate__animated animate__fadeInRightBig animate__faster alert-for-ajax" style="display: none">
        <div id="noty_bar_9da52369-9ae9-49da-858f-5f3687604672"
             class="noty_bar noty_type__error noty_theme__nest noty_close_with_click noty_has_timeout noty_has_progressbar">
            <div class="noty_body" id="alert-message"></div>
            <div class="noty_progressbar" style="transition: width 4000ms linear 0s; width: 0%;"></div>
        </div>
    </div>

    <div class="modal-backdrop fade show" style="display: none"></div>

@endsection
