<div class="company-bg">
    <div class="new_company_header container">
        <div class="img">
            <img src="{{$company->logo_file && file_exists($company->logo_file) ? $company->logo_file : '/app/assets/img/no-image.png'}}" alt="">
        </div>
        <div class="content">
            <div class="content_title">{!! $company['title'] !!}</div>
            <div class="content_subtitle">Закупочные цены</div>
        </div>
    </div>
</div>

<div class="bg_filters bg_filters_spoiler"></div>
<div class="open_company_menu">
    <ul class="spoiler">
        <li class="spoiler_small_mb">
            <a href="#" class="spoiler_flex">
                <img src="{{$company->logo_file && file_exists($company->logo_file) ? $company->logo_file : '/app/assets/img/no-image.png'}}" alt="">
                <span>{{$company->title}}</span>
            </a>
        </li>
        <li>
            <a href="{{route('company.index', $id)}}" class="{{$current_page == 'main' ? 'active' : ''}}">Цены трейдера</a>
        </li>
        <li>
            <a href="{{route('company.cont', $id)}}" class="{{$current_page == 'contact' ? 'active' : ''}}">Контакты</a>
        </li>
        <li>
            <a href="{{route('company.reviews', $id)}}" class="{{$current_page == 'reviews' ? 'active' : ''}}">Отзывы</a>
        </li>
        @if($check_forwards)
            <li>
                <a href="{{route('company.forwards', $id)}}" class="{{$current_page == 'forwards' ? 'active' : ''}}">Форварды</a>
            </li>
        @endif
        @if($check_adverts)
            <li>
                <a href="{{route('company.adverts', $id)}}" class="{{$current_page == 'adverts' ? 'active' : ''}}">Объявления</a>
            </li>
        @endif
    </ul>
    <button>Меню компании</button>
</div>
