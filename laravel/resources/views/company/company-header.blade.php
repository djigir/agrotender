<div class="company-bg d-none d-sm-block">
    <img class="avatar" src="{{$company['logo_file'] && file_exists($company['logo_file']) ? $company['logo_file'] : '/app/assets/img/no-image.png'}}">
    <h1 class="title d-block mt-2">{!! $current_page == 'main'  ? str_replace('\\', '', $company['title']).' - Закупочные цены' : $company['title'] !!} </h1>
    <div class="company-menu-container d-none d-sm-block">
        <div class="company-menu">
            <a href="{{route('company.index', $id)}}" class="{{$current_page == 'main' ? 'active' : ''}}" >Главная</a>
            @if($check_forwards)
                <a href="{{route('company.forwards', $id)}}" class="{{$current_page == 'forwards' ? 'active' : ''}}" >Форварды</a>
            @endif
            <a href="{{route('company.reviews', $id)}}" class="{{$current_page == 'reviews' ? 'active' : ''}}">Отзывы</a>
            <a href="{{route('company.cont', $id)}}" class="{{$current_page == 'contact' ? 'active' : ''}}">Контакты</a>
        </div>
    </div>
</div>
