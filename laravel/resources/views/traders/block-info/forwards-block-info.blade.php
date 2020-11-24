@if($isMobile && $culture_translit && $culture_name != 'Выбрать продукцию')
    <div class="d-sm-none container pt-2 pt-sm-4">
        <span class="searchTag d-inline-block">
            {{ $culture_name}}
            <a href="{{route('traders_forward.region', 'ukraine')}}"><i class="far fa-times close ml-2"></i></a>
        </span>
    </div>
@endif
<div class="container mt-0 mt-sm-3">
    <div class="row pt-sm-3">
        <div class="position-relative w-100">
            <div class="col-12 col-md-9 float-md-right text-center text-md-right">
                <a style="background: linear-gradient(180deg, #8A78E7 0%, #7E65FF 100%); border: none; height: 35px" href="viber://pa?chatURI=agrotender_bot&amp;text=Начать" class="top-btn btn btn-primary align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">
                    <img src="/app/assets/img/company/viber4.svg" style="width: 18px">
                    <span class="pl-1 pr-1">Продать в Viber</span>
                </a>
                <a style="background: linear-gradient(180deg, #5CA9F1 0%, #44A4FF 100%); border: none; height: 35px" href="https://t.me/AGROTENDER_bot" class="top-btn btn btn-primary align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">
                    <img src="/app/assets/img/company/telegram-white.svg" style="width: 18px">
                    <span class="pl-1 pr-1">Продать в Telegram</span>
                </a>
                <a href="/add_buy_trader" class="top-btn btn btn-warning align-items-end">
                    <i class="far fa-plus mr-2"></i>
                    <span class="pl-1 pr-1">Разместить компанию</span>
                </a>
            </div>
            @if($traders->count() > 0)
                <div class="col-12 col-md-3 float-left mt-4 mt-md-0 d-block">
                    <h2 class="d-inline-block text-uppercase">Все трейдеры</h2>
                    <div class="lh-1">
                        <a href="/add_buy_trader" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
