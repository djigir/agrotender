<div class="company-bg d-none d-sm-block">
    <img class="avatar" src="/pics/comp/5608_54749.jpg">
    <h1 class="title d-block mt-2">{!!  str_replace('\\', '', $company_name) !!} - Закупочные цены</h1>
    <div class="company-menu-container d-none d-sm-block">
        <div class="company-menu">
            <a href="{{route('company.company', $id)}}" class="" >Главная</a>
            <a href="{{route('company.company_prices', $id)}}" class=""> Цены трейдера</a>
            <a href="{{route('company.company_reviews', $id)}}" class="">Отзывы</a>
            <a href="{{route('company.company_cont', $id)}}" class="">Контакты</a>
        </div>
    </div>
</div>
