<div class="company-bg d-none d-sm-block">
    <img class="avatar" src="/pics/comp/5608_54749.jpg">
    <h1 class="title d-block mt-2">{!!  str_replace('\\', '', $company_name) !!} - Закупочные цены</h1>
    <div class="company-menu-container d-none d-sm-block">
        <div class="company-menu">
            <a href="{{route('company.index', $id)}}" class="{{$current_page == 'main' ? 'active' : ''}}" >Главная</a>
            <a href="{{route('company.index', $id)}}" class="" >Форварды</a>
            <a href="{{route('company.reviews', $id)}}" class="{{$current_page == 'reviews' ? 'active' : ''}}">Отзывы</a>
            <a href="{{route('company.cont', $id)}}" class="{{$current_page == 'contact' ? 'active' : ''}}">Контакты</a>
        </div>
    </div>
</div>
