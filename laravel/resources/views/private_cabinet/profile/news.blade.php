@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.profile.profile_header')
<div class="container mt-4 mb-5 nv">
    <div class="content-block mx-0 mx-sm-5">
        <div class="pb-5 pt-4 px-4 lh-1">
            <div class="d-inline-block pt-3 pt-sm-2">
                <span>Всего новостей: <span class="count"><b>1</b></span></span>
            </div>
            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addNews">Добавить новость</button>
        </div>
        <div class="block row py-4 px-4 mx-0">
            <div class="col-3 col-sm-auto p-0">
                <span class="date small">2020-11-13 17:57:58</span>
            </div>
            <div class="col-7 col-sm pl-4">
                <span class="d-block title" href="/u/news/870"><b>Tets news</b></span>
            </div>
            <div class="col-1 col-sm-auto">
                <i class="fas fa-pencil-alt edit edit cursor-pointer mr-2" newsid="870"></i>
                <i class="fas fa-times remove text-danger cursor-pointer" newsid="870"></i>
            </div>
        </div>
    </div>
</div>
@endsection
