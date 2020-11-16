@extends('layout.layout')
@dump($errors)
@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.profile.profile_header')
    <div class="container mt-4 mb-5">
        <div class="content-block px-5 py-4 company-settings position-relative">
            <h2>Настройки компании</h2>
            <form class="form company-form mt-4" method="POST" novalidate="novalidate"
                  action="{{route('user.profile.create_company')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">
                        Название компании
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-4 pl-1">
                        <input type="text" class="form-control {{$errors->first('title') ? 'error-input' : ''}}"
                               placeholder="Город" name="title" value="{{$company ? $company->title : old('title')}}">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Логотип</label>
                    <div class="col-sm-4 pl-1 d-flex align-items-center">
                        <img class="logo" src="{{$company ? $company->logo_file : '/app/assets/img/noavatar.png'}}">
                        <span class="ml-3 select-image">Выбрать изображение</span>
                        <input type="file" name="logo" class="d-block" value="{{$company ? $company->logo_file : ''}}">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label
                        class="col-sm-4 col-form-label d-flex align-items-start justify-content-start justify-content-sm-end">О
                        компании <span class="text-danger">*</span></label>
                    <div class="col-sm-7 d-flex align-items-center pl-1">
                        <textarea class="form-control {{$errors->first('content') ? 'error-input' : ''}}" name="content"
                                  id="content" rows="9"
                                  placeholder="Введите Ваше описание">{{$company ? $company->content : old('content')}}</textarea>
                    </div>
                </div>
                <hr class="my-4">
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Индекс</label>
                    <div class="col-sm-4 pl-1">
                        <input type="text" class="form-control" placeholder="Индекс" name="zipcode"
                               value="{{$company ? $company->zipcode : old('zipcode')}}">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Область <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-4 pl-1">
                        <select class="form-control" name="obl_id">
                            @foreach($regions as $index => $region)
                                <option value="{{$region['id']}}">{{$region['translit'] != 'crimea' ? $region['name'].' область' : $region['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Город <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-4 pl-1">
                        <input type="text" class="form-control" placeholder="Город" name="city" value="{{$company ? $company->city : old('city')}}">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Адрес</label>
                    <div class="col-sm-4 pl-1">
                        <input type="text" class="form-control" placeholder="Адрес" name="addr" value="{{$company ? $company->addr : old('addr')}}">
                    </div>
                </div>
                <hr class="my-4">
                <h3>Продукция</h3>
                <span class="desc extra-small">Выберите до 5 видов деятельности Вашей компании</span>
                <div class="text-center pl-0 pl-sm-5 mt-3">
                    <div class="rubrics-wrap d-inline-block pl-0 pl-sm-5">
                        @foreach($rubrics as $index => $rubric)
                            <div class="rubric-col pr-0 pr-sm-4">
                                <span class="rubric-title">{{$rubric->title}}</span>
                                @foreach($rubric->comp_topic as $index_item => $rubric_item)
                                    <div class="rubric-item">
                                        <input class="custom-control-input rubric-input" type="checkbox"
                                               value="{{$rubric_item['id']}}" name="rubrics[]"
                                               id="rubric{{$rubric_item['id']}}">
                                        <label class="custom-control-label" for="rubric{{$rubric_item['id']}}">
                                            {{$rubric_item['title']}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="comp-rules mt-4 text-center">
                    <div><span>Я обязуюсь соблюдать</span> <a href="/info/orfeta#p4" target="_blank">правила размещения
                            компании</a>.
                    </div>
                    <button type="submit" class="btn btn-primary px-5 text-center mt-3 save-comp">Сохранить</button>
                </div>
            </form>
        </div>
        {{--        <div class="comp-rules mt-4 text-center">--}}
        {{--            <div><span>Я обязуюсь соблюдать</span> <a href="/info/orfeta#p4" target="_blank">правила размещения компании</a>.</div>--}}
        {{--            <button type="submit" class="btn btn-primary px-5 text-center mt-3 save-comp">Сохранить</button>--}}
        {{--        </div>--}}
    </div>
    <div id="noty_layout__bottomLeft" role="alert" aria-live="polite" class="noty_layout animate__animated animate__fadeInRightBig animate__faster" style="display: none">
        <div id="noty_bar_0927b968-3a85-4457-bf37-d3b3d7644f63"
             class="noty_bar noty_type__warning noty_theme__nest noty_close_with_click noty_has_timeout noty_has_progressbar">
            <div class="noty_body">{{$errors->first('rubrics')}}</div>
            <div class="noty_progressbar" style="transition: width 4000ms linear 0s; width: 0%;"></div>
        </div>
    </div>
    @if(!$errors->any())
        <div style="display: none" id="noty_layout__bottomLeft" role="alert" aria-live="polite" class="noty_layout animate__animated animate__fadeInRightBig animate__faster">
            <div id="noty_bar_ca950bc5-dadd-4e3c-9ed3-e89a747899c8"
                 class="noty_bar noty_type__success noty_theme__nest noty_close_with_click noty_has_timeout noty_has_progressbar">
                <div class="noty_body">Компания обновлена.</div>
                <div class="noty_progressbar" style="transition: width 4000ms linear 0s; width: 0%;"></div>
            </div>
        </div>
    @endif
@endsection
