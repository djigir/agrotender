<div class="submenu d-none d-sm-block text-center">
    <a href="{{route('user.advert.limit')}}" class="{{$type_page_tariff == 'advert_limit' ? 'active' : ''}}">Лимит объявлений</a>
    <a href="{{route('user.advert.upgrade')}}" class="{{$type_page_tariff == 'advert_upgrade' ? 'active' : ''}}">Улучшения объявлений</a>
    <a href="{{route('user.tariff.pay')}}" class="{{$type_page_tariff == 'balance_pay' ? 'active' : ''}}">Пополнить баланс</a>
    <a href="{{route('user.tariff.history')}}" class="{{$type_page_tariff == 'balance_history' ? 'active' : ''}}">История платежей</a>
    <a href="{{route('user.tariff.docs')}}" class="{{$type_page_tariff == 'balance_docs' ? 'active' : ''}}">Счета/акты</a>
</div>
