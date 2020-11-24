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

<div class="modal fade" id="addVacancy" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="form modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title ml-3">Добавить вакансию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body pt-4">
                <div class="form-group">
                    <label class="col col-form-label">Заголовок <span class="text-danger">*</span></label>
                    <div class="col pl-1">
                        <input type="text" class="form-control" placeholder="Заголовок" name="title">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col col-form-label">Описание <span class="text-danger">*</span></label>
                    <div class="col pl-1">
                        <textarea class="form-control" rows="7" name="description"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-block btn-primary px-5 add-news">Отправить</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="editVacancy" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="form modal-content">
            <div class="modal-header">
                <h5 class="modal-title ml-3">Редактирование вакансии</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-4">
                <div class="form-group">
                    <label class="col col-form-label">Заголовок <span class="text-danger">*</span></label>
                    <div class="col pl-1">
                        <input type="text" class="form-control" placeholder="Заголовок" name="title">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col col-form-label">Описание <span class="text-danger">*</span></label>
                    <div class="col pl-1">
                        <textarea class="form-control" rows="7" name="description"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-block btn-primary px-5 edit-vacancy">Сохранить</button>
            </div>
        </form>
    </div>
</div>
@endsection
