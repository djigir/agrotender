@extends('layout.layout')


@section('content')
    @include('private_cabinet.cabinet-header')
    <div class="container d-flex justify-content-between mt-3 mt-sm-0">
        <div class="submenu d-none d-sm-inline-block text-left">
            <a href="/u/proposeds?type=1" class="active">Исходящие заявки: 0</a>
        </div>
        <div class="d-inline-block dep text-center text-sm-right">
            <a href="/u/proposeds?type=1" class="active">Все</a>
            <a href="/u/proposeds?status=1&amp;type=1" "="">Активные</a>
            <a href="/u/proposeds?status=-1&amp;type=1" "="">Завершённые</a>
        </div>
    </div>
    <div class="container mt-4 mb-5">
        <div class="scroll-x mt-3 pb-3">
            <table class="sortTable proposedTable fixed-table">
                <thead>
                <tr><th>Дата</th>
                    <th>Культура</th>
                    <th>Трейдер</th>
                    <th>Объём</th>
                    <th>Цена</th>
                    <th>Область</th>
                    <th>Описание</th>
                    <th>Действия</th>
                </tr></thead>
                <tbody>
                <tr>
                    <td colspan="8">Список пуст</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
