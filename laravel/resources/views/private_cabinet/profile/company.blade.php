@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.profile.profile_header')
    <div class="container mt-4 mb-5">
        <div class="content-block px-5 py-4 company-settings position-relative">
            <h2>Настройки компании
                @if($company)
                    <form action="{{route('user.profile.toggle_visible')}}" method="POST" style="margin-top: -26px;">
                        @csrf
                        <button type="submit"
                                class="btn setVisible {{$company->visible == 0 ? 'green' : 'red'}} float-right d-none d-sm-inline-block"
                                id="changeVisibleCompany">
                            {{$company->visible == 0 ? 'Показывать компанию' : 'Скрыть компанию'}}
                        </button>
                        <input type="text" name="visible" value="{{$company->visible}}"
                               style="opacity: 0; border: none; outline: none; width: 0" id="visible" visible="1">
                    </form>
                @endif
            </h2>
            <form class="form company-form mt-4" method="POST"
                  action="{{route('user.profile.create_company')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">
                        Название компании
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-4 pl-1">
                        <input type="text" class="form-control {{$errors->first('title') ? 'error-input' : ''}}"
                               placeholder="Город" name="title"
                               value="{{$company && !$errors->first('title') && !$errors->any() ? $company->title : old('title')}}">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Логотип</label>
                    <div class="col-sm-4 pl-1 d-flex align-items-center">
                        <img class="logo" src="{{$company ? $company->logo_file : '/app/assets/img/noavatar.png'}}">
                        <span class="ml-3 select-image">Выбрать изображение</span>
                        <input type="file" name="logo" class="d-block">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label
                        class="col-sm-4 col-form-label d-flex align-items-start justify-content-start justify-content-sm-end">О
                        компании <span class="text-danger">*</span></label>
                    <div class="col-sm-7 d-flex align-items-center pl-1">
                        <textarea class="form-control {{$errors->first('content') ? 'error-input' : ''}}" name="content"
                                  id="content" rows="9"
                                  placeholder="Введите Ваше описание">{{$company && !$errors->first('content') && !$errors->any() ? $company->content : old('content')}}</textarea>
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
                                <option
                                    value="{{$region['id']}}">{{$region['translit'] != 'crimea' ? $region['name'].' область' : $region['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Город <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-4 pl-1">
                        <input type="text" class="form-control" placeholder="Город" name="city"
                               value="{{$company ? $company->city : old('city')}}">
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label class="col-sm-4 col-form-label text-left text-sm-right">Адрес</label>
                    <div class="col-sm-4 pl-1">
                        <input type="text" class="form-control" placeholder="Адрес" name="addr"
                               value="{{$company ? $company->addr : old('addr')}}">
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
                                               value="{{$rubric_item->id}}" name="rubrics[]"
                                               id="rubric{{$rubric_item->id}}" {{!empty($select_rubric) && $select_rubric->has($rubric_item->id) ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="rubric{{$rubric_item->id}}">
                                            {{$rubric_item->title}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="comp-rules mt-4 text-center">
                    <div>
                        <span>Я обязуюсь соблюдать</span>
                        <a href="/info/orfeta#p4" target="_blank">правила размещения компании</a>.
                    </div>
                    <button type="submit" class="btn btn-primary px-5 text-center mt-3 save-comp" id="save-comp">Сохранить</button>
                </div>
            </form>
        </div>
        {{--        <div class="comp-rules mt-4 text-center">--}}
        {{--            <div><span>Я обязуюсь соблюдать</span> <a href="/info/orfeta#p4" target="_blank">правила размещения компании</a>.</div>--}}
        {{--            <button type="submit" class="btn btn-primary px-5 text-center mt-3 save-comp">Сохранить</button>--}}
        {{--        </div>--}}
    </div>
@endsection
