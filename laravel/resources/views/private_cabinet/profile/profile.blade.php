@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.profile.profile_header')

    <div class="container mt-4 mb-5">
        <h2 class="mx-0 mx-sm-5">Ваши личные данные</h2>
        <div class="content-block mt-4 px-5 py-3 personal mx-0 mx-sm-5">
            <div class="pt-2 row d-block d-sm-flex mx-sm-0">
                <b>Ваш текущий логин:</b> &nbsp;<span class="d-block d-sm-inline-block">{{ auth()->user()->login }}</span>
            </div>
            <hr class="my-4">
            <h5>Сменить пароль</h5>
            <form class="form change-password mt-0 mt-sm-3" novalidate="novalidate" method="POST" action="{{ route('user.profile.change_pass') }}">
                @csrf
                <div class="form-group row d-flex align-items-center py-1 mb-2 mt-2">
                    <label class="col-12 col-sm-4 col-form-label text-left text-sm-right px-0"><b>Старый пароль:</b></label>
                    <div class="col-12 col-sm-5 pl-0 pl-sm-2">
                        <div class="input-group">
                            <input type="password" class="form-control password" placeholder="Старый пароль" name="oldPassword" id="oldPassword">
                            <span class="input-group-btn">
              <button type="button" class="form-control show-password">
                <i class="far fa-eye"></i>
              </button>
            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center py-1 mb-2 mt-2">
                    <label class="col-12 col-sm-4 col-form-label text-left text-sm-right px-0"><b>Новый пароль:</b></label>
                    <div class="col-12 col-sm-5 pl-0 pl-sm-2">
                        <div class="input-group">
                            <input type="password" class="form-control password" placeholder="Новый пароль" name="passwd" id="password">
                            <span class="input-group-btn">
              <button type="button" class="form-control show-password">
                <i class="far fa-eye"></i>
              </button>
            </span>
                        </div>
                    </div>
                </div>
                <div class="text-center col-12 col-sm-4 offset-sm-4 pt-3 pb-2">
                    <button type="submit" class="btn btn-success btn-block">Сохранить</button>
                </div>
            </form>
            <hr class="my-4">
            <h5>Задать новый логин</h5>
            <form class="form change-login mt-0 mt-sm-3" novalidate="novalidate" method="POST" action="{{ route('user.profile.change_login') }}">
                @csrf
                <div class="form-group row d-flex align-items-center py-1 mb-2 mt-2">
                    <label class="col-12 col-sm-4 col-form-label text-left text-sm-right px-0"><b>Новый логин:</b></label>
                    <div class="col-12 col-sm-5 pl-0 pl-sm-2">
                        <input type="email" class="form-control" placeholder="Новый логин" name="login" id="email">
                    </div>
                </div>
                <div class="text-center col-12 col-sm-4 offset-sm-4 pt-3 pb-2">
                    <button type="submit" class="btn btn-success btn-block">Сохранить</button>
                </div>
            </form>
        </div>
    </div>


    @if($errors->any() || session('success'))
        <div id="noty_layout__bottomLeft" role="alert" aria-live="polite"
             class="noty_bar noty_type__info noty_theme__nest noty_close_with_click noty_has_timeout noty_has_progressbar noty_effects_close animate__animated animate__fadeInRightBig animate__faster"
             style="display: block">
            <div class="noty_body">{{ $errors->first() ? $errors->first() :  session('success') }}</div>
            <div class="noty_progressbar" style="transition: width 4000ms linear 0s; width: 0%;"></div>
        </div>
    @endif

@endsection
