<div class="header__wrap fixed-item" id="scroll-header" style="display: none">
    <header class="new_header">
        <div class="new_container">
            <div class="header__flex header__desktop">
                <div class="logo-wrap">
                    <a href="https://agrotender.com.ua" class="logo">
                        <img src="https://agrotender.com.ua/app/assets/img/logo_white.svg" alt="logo"
                             class="logo_desktop">
                        <img src="https://agrotender.com.ua/app/assets/img/agromini.svg" alt="logo" class="logo_mobile">
                    </a>
                    <div class="hidden-links">
                        <a href="#">
                            <img src="https://agrotender.com.ua/app/assets/img/company/viber4.svg" alt="">
                        </a>
                        <a href="#">
                            <img src="https://agrotender.com.ua/app/assets/img/company/telegram-white.svg" alt="">
                        </a>
                    </div>
                </div>
                <div class="header__center__buttons">
                    <a href="https://agrotender.com.ua/board" class="header__center__button">Объявления</a>
                    <div class="header__tradersPrice">
                        <a href="{{route('traders.')}}" class="header__center__button withArrow">
                            Цены Трейдеров
                        </a>
                        <div class="header__hoverElem-wrap">
                            <div class="header__hoverElem">
                                <ul>
                                    <li>
                                        <a href="{{route('traders.')}}" class="header_fw600">Закупки</a>
                                    </li>
                                    <li>
                                        <a href="#" class="header_fw600">Форварды</a>
                                    </li>
                                    <li>
                                        <a href="{{route('traders_sell.region', 'ukraine')}}" class="header_fw600">Продажи</a>
                                    </li>
                                    <li>
                                        <a href="https://agrotender.com.ua/tarif20.html" class="header__yellowText">Разместить компанию</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="header__tradersPrice special">
                        <a href="{{route('traders.')}}" class="header__center__button withBg">
                <span class="header__tradersPrice-dots">
                  <span></span>
                  <span></span>
                  <span></span>
                </span>
                        </a>
                        <div class="header__hoverElem-wrap">
                            <div class="header__hoverElem">
                                <ul>
                                    <li>
                                        <a href="{{route('traders.')}}">Компании</a>
                                    </li>
                                    <li>
                                        <a href="https://agrotender.com.ua/elev">Элеваторы</a>
                                    </li>
                                    <li>
                                        <span class="line"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header__right">
                    <a href="#" class="header__right__button">
                        <span>Мой профиль</span>
                        <img src="https://agrotender.com.ua/app/assets/img/profile.svg" alt="profile">
                    </a>
                    <div class="header__hoverElem-wrap">
                        <div class="header__hoverElem">
                            @if(auth()->user())
                            <ul>
                                <li>
                                    <span>Цены трейдера:</span>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/prices">Таблица закупок</a>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/prices/contacts">Контакты трейдера</a>
                                </li>
                                <li>
                                    <span>Моя Компания:</span>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/company">Настройки</a>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/contacts">Контакты</a>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/posts">Объявления</a>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/balance/pay">Пополнить баланс</a>
                                </li>
                                <li>
                                    <span>Мой профиль:</span>
                                </li>
                                <li>
                                    <a href="https://agrotender.com.ua/u/">Настройки</a>
                                </li>
                                <li>
                                    <a href="/logout" class="header__exit">Выход</a>
                                </li>
                            </ul>
                            @else
                                <ul>
                                    <li>
                                        <a href="/buyerreg">Регистрация</a>
                                    </li>
                                    <li>
                                        <a href="/buyerlog">Вход</a>
                                    </li>
                                </ul>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="header__mobile">
                <button class="header_drawerOpen-btn">
                    <img src="https://agrotender.com.ua/app/assets/img/menu.svg" alt="" id="drawerOpenMobile">
                </button>
                <a href="/" class="header_logo_mobile">
                    <img src="https://agrotender.com.ua/app/assets/img/logo_white.svg" alt="">
                </a>
                <a href="/" class="header_profile">
                    <img src="https://agrotender.com.ua/app/assets/img/profile_white.svg" alt="">
                </a>
            </div>
            <div class="drawer" id="drawer">
                <div class="drawer_content">
                    <div class="drawer__header">
                        <a href="/" class="drawer__header-logo">
                            <img src="https://agrotender.com.ua/app/assets/img/logo.svg" alt="">
                        </a>
                        <a href="#" class="drawer__header-social first">
                            <img src="https://agrotender.com.ua/app/assets/img/company/telegram_m.svg" alt="">
                        </a>
                        <a href="#" class="drawer__header-social">
                            <img src="https://agrotender.com.ua/app/assets/img/company/viber_m.svg" alt="">
                        </a>
                    </div>
                    <ul class="drawer__list">
                        <li>
                            <a href="#">Главная</a>
                        </li>
                        <li>
                            <a href="#">Объявления</a>
                        </li>
                        <li>
                            <a href="#">Цены трейдеров</a>
                        </li>
                        <li>
                            <a href="#">Компании</a>
                        </li>
                        <li>
                            <a href="#">Элеваторы</a>
                        </li>
                    </ul>
                    <div class="drawer_footer">
                        <ul class="drawer__list">
                            <li><a href="/logout">Выход</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="drawer">
                <div class="drawer_content">
                    <div class="drawer__header">
                        <a href="/" class="drawer__header-logo">
                            <img src="https://agrotender.com.ua/app/assets/img/logo.svg" alt="">
                        </a>
                        <a href="#" class="drawer__header-social first">
                            <img src="https://agrotender.com.ua/app/assets/img/company/telegram_m.svg" alt="">
                        </a>
                        <a href="#" class="drawer__header-social">
                            <img src="https://agrotender.com.ua/app/assets/img/company/viber_m.svg" alt="">
                        </a>
                    </div>
                    <ul class="drawer__list">
                        <li>
                            <a href="#">Главная</a>
                        </li>
                        <li>
                            <a href="#">Объявления</a>
                        </li>
                        <li>
                            <a href="#">Цены трейдеров</a>
                        </li>
                        <li>
                            <a href="#">Компании</a>
                        </li>
                        <li>
                            <a href="#">Элеваторы</a>
                        </li>
                    </ul>
                    <div class="drawer_footer">
                        <ul class="drawer__list">
                            <li><a href="/logout">Выход</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>
