@if(auth()->user())
    <div class="col-1 col-sm-6 d-flex align-items-center justify-content-end">
        <div class="d-none d-sm-block float-right right-links p-3">
            <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false" class="head-name d-flex align-items-center position-relative">
                <i class="fas fa-chevron-down mr-1"></i>
                <?php
                    $user = auth()->user();
                    $name = $user->company ? $user->company->title : $user->name;
                    $logo = $user->company ? $user->company->logo_file : '/app/assets/img/noavatar.png';
                ?>
                <span>{{ $name }}</span>
                <img alt="" src="{{$logo}}" class="ml-2 head-logo">
                <span class="notification-badge top-badge"></span>
            </a>
            <div class="dropdown-menu mt-2 head-dropdown" aria-labelledby="dropdownMenuLink">

                <a class="dropdown-item" href="{{route('user.application')}}">
                    Заявки
                    <span class="notification-badge"></span>
                </a>
                <h6 class="dropdown-header">Объявления:</h6>
                <a class="dropdown-item" href="{{route('user.advert.advert')}}">Объявления</a>
                <a class="dropdown-item" href="">Баланс: 0 грн</a>
                <a class="dropdown-item" href="{{route('user.tariff.pay')}}">Пополнить баланс</a>
                <a class="dropdown-item" href="{{route('user.advert.limit')}}">Лимит объявлений</a>
                <h6 class="dropdown-header">Профиль:</h6>
                <a class="dropdown-item" href="{{route('user.profile.company')}}">Компания</a>
                <a class="dropdown-item" href="{{route('user.profile.contacts')}}">Контакты</a>
                <a class="dropdown-item" href="/logout">Выход</a>
            </div>
        </div>
    </div>

@else
    <div class="col-1 col-sm-6 d-flex align-items-center justify-content-end">
        <div class="d-none d-sm-block float-right right-links p-3">
            <a href="/buyerlog">Войти</a> &nbsp;|&nbsp; <a href="/buyerreg">Регистрация</a>
        </div>
    </div>
@endif
