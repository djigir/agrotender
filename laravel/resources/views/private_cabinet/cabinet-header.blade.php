
<div class="company-bg d-none d-sm-block mb-4">
    <a href="/kompanii/comp-">
        <span class="title d-block mt-2"></span>
    </a>
    <div class="company-menu-container d-none d-sm-block">
        <div class="company-menu">
            <a href="{{route('user.profile.profile')}}" class="{{$type_page == 'profile' ? 'active' : ''}}">Профиль</a>
            <a href="{{route('user.advert.advert')}}" class="{{$type_page == 'advert' ? 'active' : ''}}">Объявления</a>
            <a href="{{route('user.application')}}" class="position-relative {{$type_page == 'application' ? 'active' : ''}}">Заявки
                <span class="notification-badge top-badge"></span>
            </a>
            <a href="{{route('user.profile.prices')}}" class="{{$type_page == 'prices' ? 'active' : ''}}">Цены трейдера</a>
            <a href="{{route('user.advert.limit')}}" class="{{$type_page == 'tariff' ? 'active' : ''}}">Тарифы</a>
        </div>
    </div>
</div>
