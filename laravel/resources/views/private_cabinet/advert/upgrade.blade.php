@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.tariff.tariff_header')
    <div class="container mt-4 mb-5">
        <h2>Текущие улучшения</h2>
        <div class="scroll-x py-4">
            <table class="sortTable">
                <thead>
                <tr><th>Заказано</th>
                    <th>Пакет</th>
                    <th>Объявление</th>
                    <th>Дата окончания</th>
                    <th>Цена</th>
                </tr></thead>
                <tbody>
                <tr><td colspan="5" class="text-center">На даный момент Вы не приобрели ни одного улучшения.</td>
                </tr></tbody>
            </table>
        </div>
    </div>
@endsection
