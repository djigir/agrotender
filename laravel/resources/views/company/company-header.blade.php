<div class="company-bg">
    <div class="new_company_header container">
        <div class="img">
            <img src="{{$company->logo_file && file_exists($company->logo_file) ? $company->logo_file : '/app/assets/img/no-image.png'}}" alt="">
        </div>
        <div class="content">
            <div class="content_title">{!! $company['title'] !!}</div>
            <div class="content_subtitle">Закупочные цены</div>
{{--            <div class="new_company_actual_date new_company_actual_date-tablet">Актуальная цена на <b>{{$updateDate}}</b></div>--}}
            <div class="content_list">
                <a href="{{route('company.index', $id)}}" class="{{$current_page == 'main' ? 'active' : ''}}">Цены трейдера</a>
                @if($check_forwards)
                    <a href="{{route('company.forwards', $id)}}" class="{{$current_page == 'forwards' ? 'active' : ''}}">Форварды</a>
                @endif
                <a href="{{route('company.cont', $id)}}" class="{{$current_page == 'contact' ? 'active' : ''}}">Контакты</a>
                <a href="#">Объявления</a>
                <a href="{{route('company.reviews', $id)}}" class="{{$current_page == 'reviews' ? 'active' : ''}}">Отзывы</a>
            </div>
        </div>
    </div>
</div>
