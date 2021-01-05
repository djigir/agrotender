<div class="company-bg">
    <div class="new_company_header new_container">
        <div class="img">
            <img src="{{$company->logo_file && file_exists($company->logo_file) ? '/'.$company->logo_file : '/app/assets/img/no-image.png'}}" alt="">
        </div>
        <div class="content">
            <?php
                $TEXT = [
                    'main' => 'Закупочные цены',
                    'contact' => 'Контакты',
                    'reviews' => 'Отзывы',
                    'forwards' => 'Форвардные цены',
                    'adverts' => 'Объявления',
                ];
            ?>
            <div class="content_title">{!! $company['title'] !!}</div>
            <div class="content_subtitle">{{$TEXT[$current_page]}}</div>
            <div class="content_list">
                <a href="{{route('company.index', $id)}}" class="{{$current_page == 'main' ? 'active' : ''}}">{{$company->trader_price_avail == 1 ? 'Цены трейдера' : 'О компании'}}</a>
                <a href="{{route('company.cont', $id)}}" class="{{$current_page == 'contact' ? 'active' : ''}}">Контакты</a>
{{--                <a href="{{route('company.reviews', $id)}}" class="{{$current_page == 'reviews' ? 'active' : ''}}">Отзывы</a>--}}

                @if($check_forwards)
                    <a href="{{route('company.forwards', $id)}}" class="{{$current_page == 'forwards' ? 'active' : ''}}">Форварды</a>
                @endif

                @if($check_adverts)
                    <a href="{{route('company.adverts', $id)}}" class="{{$current_page == 'adverts' ? 'active' : ''}}">Объявления</a>
                @endif

            </div>
        </div>
    </div>
</div>
