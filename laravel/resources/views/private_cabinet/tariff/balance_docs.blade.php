@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.tariff.tariff_header')
    <div class="container mt-4 mb-5">
        <h2>Список счетов/актов</h2>
        <div class="scroll-x mt-1 py-3">
            <table class="sortTable">
                <thead>
                <tr><th>Дата</th>
                    <th>Тип</th>
                    <th>Счёт №</th>
                    <th>Статус</th>
                    <th>Сумма</th>
                    <th>Плательщик</th>
                    <th>Действия</th>
                </tr></thead>
                <tbody>
                <tr>
                    <td colspan="7">Список счетов пуст.</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
