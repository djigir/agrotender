@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.tariff.tariff_header')
    <div class="container mt-4">
        <h2>Активные пакеты</h2>
        <div class="scroll-x mt-3 pb-3">
            <table class="sortTable">
                <thead>
                <tr><th>Пакет</th>
                    <th>Действителен с</th>
                    <th>Действителен до</th>
                    <th>Цена</th>
                </tr></thead>
                <tbody>
                <tr><td colspan="4">На данный момент у Вас нет активных увеличений лимитов</td>
                </tr></tbody>
            </table>
        </div>
    </div>
    <div class="container mt-2 mb-5 limits">
        <h2 class="d-flex align-items-end w-100 justify-content-between"><span>Увеличить лимит объявлений</span> <a href="https://agrotender.com.ua/info/limit_adv#p2" class="small">Подробнее о лимитах</a></h2>
        <div class="packs mt-3">
            <div class="content-block px-4 pack-block d-flex align-items-center row mx-0 my-3 py-3 noselect pack" pack-id="7">
                <div class="col p-0 d-flex align-items-center lh-1">
                    <span class="dot mr-3"></span> <span class="py-3">+5 объявлений на 30 дней</span>
                </div>
                <div class="col-auto p-0 text-right">
                    <div class="right-side d-flex">
                        <span class="price"><span class="cost">49</span><span class="currency ml-1">грн</span></span>
                    </div>
                </div>
            </div>
            <div class="content-block px-4 pack-block d-flex align-items-center row mx-0 my-3 py-3 noselect pack" pack-id="27">
                <div class="col p-0 d-flex align-items-center lh-1">
                    <span class="dot mr-3"></span> <span class="py-3">+2 объявления на 30 дней</span>
                </div>
                <div class="col-auto p-0 text-right">
                    <div class="right-side d-flex">
                        <span class="price"><span class="cost">39</span><span class="currency ml-1">грн</span></span>
                    </div>
                </div>
            </div>
            <div class="content-block px-4 pack-block d-flex align-items-center row mx-0 my-3 py-3 noselect pack" pack-id="28">
                <div class="col p-0 d-flex align-items-center lh-1">
                    <span class="dot mr-3"></span> <span class="py-3">+1 объявления на 30 дней</span>
                </div>
                <div class="col-auto p-0 text-right">
                    <div class="right-side d-flex">
                        <span class="price"><span class="cost">29</span><span class="currency ml-1">грн</span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="totalPrice row mx-0 mt-5 justify-content-end">
            <div class="px-4 py-2 text-right content-block ">
                <div class="right-side d-flex align-items-center justify-content-center lh-1">
                    <span class="text">Всего к оплате: </span>
                    <span class="price ml-3"><span class="cost">0</span><span class="currency ml-1">грн</span></span>
                </div>
            </div>
            <button class="btn payBtn ml-4 px-5 mt-3 mt-sm-0">Оплатить</button>
        </div>
    </div>
@endsection
