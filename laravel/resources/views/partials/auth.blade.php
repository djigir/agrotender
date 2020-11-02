@if(auth()->user())

    <div class="col-1 col-sm-6 d-flex align-items-center justify-content-end">
        <div class="d-none d-sm-block float-right right-links p-3">

            <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false" class="head-name d-flex align-items-center position-relative">
                <i class="fas fa-chevron-down mr-1"></i>
                <span>Test</span>
                <img alt="" src="/app/assets/img/noavatar.png" class="ml-2 head-logo">
                <span class="notification-badge top-badge"></span>
            </a>
            <div class="dropdown-menu mt-2 head-dropdown" aria-labelledby="dropdownMenuLink">

                <a class="dropdown-item" href="/u/proposeds">Заявки <span class="notification-badge"></span></a>
                <h6 class="dropdown-header">Объявления:</h6>
                <a class="dropdown-item" href="/u/posts">Объявления</a>
                <a class="dropdown-item" href="">Баланс: 0 грн</a>
                <a class="dropdown-item" href="/u/balance/pay">Пополнить баланс</a>

                <a class="dropdown-item" href="/u/posts/limits">Лимит объявлений</a>
                <h6 class="dropdown-header">Профиль:</h6>
                <a class="dropdown-item" href="/u/company">Компания</a>
                <a class="dropdown-item" href="/u/contacts">Контакты</a>
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
