<div class="company-bg d-none d-sm-block">
    <div class="new_company_header container">
        <div class="img">
            <img src="{{$company['logo_file'] && file_exists($company['logo_file']) ? $company['logo_file'] : '/app/assets/img/no-image.png'}}" alt="">
        </div>
        <div class="content">
            <div class="content_title">{{$company['title']}}</div>
            <div class="content_subtitle">Закупочные цены</div>
            <div class="content_list">
                <a href="#" class="active">Цены трейдера</a>
                <a href="#">Контакты</a>
                <a href="#">Объявления</a>
                <a href="#">Отзывы</a>
            </div>
        </div>
    </div>
</div>
