@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.profile.profile_header')
<div class="container mt-4 mb-5 nv">
    <div class="content-block mx-0 mx-sm-5">
        <div class="pb-5 pt-4 px-4 lh-1">
            <div class="d-inline-block pt-3 pt-sm-2">
                <span>Всего вакансий: <span class="count"><b>1</b></span></span>
            </div>
            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addVacancy">Добавить вакансию</button>
        </div>
        <div class="block row py-4 px-4 mx-0">
            <div class="col-3 col-sm-auto p-0">
                <span class="date small">2020-11-13 17:58:23</span>
            </div>
            <div class="col-7 col-sm pl-4">
                <span class="d-block title"><b>Tets vacancy</b></span>
            </div>
            <div class="col-2 col-sm-auto">
                <i class="fas fa-pencil-alt edit edit cursor-pointer mr-2" vacancyid="268"></i>
                <i class="fas fa-times remove text-danger cursor-pointer" vacancyid="268"></i>
            </div>
        </div>
    </div>
</div>
@endsection
