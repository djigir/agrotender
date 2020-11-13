@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.tariff.tariff_header')
    <div class="container mt-4 mb-5">
        <h2>Список операций по счёту</h2>
        <div class="scroll-x py-4">
            <table class="sortTable">
                <thead>
                <tr><th>Дата</th>
                    <th>Назначение</th>
                    <th>Сумма</th>
                    <th>Счет</th>
                </tr></thead>
                <tbody>
                <tr><td colspan="5" class="text-center">По Вашему счёта нет ни одной операции.</td>
                </tr></tbody>
            </table>
        </div>
    </div>
@endsection
