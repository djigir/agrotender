@extends('layout.layout')

@section('content')

    <div class="container">
        <div class="row mt-4 pt-sm-3 mx-0 mx-sm-5 align-items-center justify-content-between">
            <div class="col-4 d-block">
                <h2 class="d-inline-block text-uppercase">Отзывы</h2>
            </div>
            <div class="col-8 text-center text-md-right">
                <a href="#" class="top-btn btn btn-primary align-bottom addReview">
                    <span class="pl-1 pr-1">Оставить отзыв</span>
                </a>
            </div>
        </div>
    </div>
    <div class="container mb-5">
        <div class="content-block mt-4 review py-3 px-4 mx-0 mx-sm-5 text-center">
            <b>У компании ещё нет ни одного отзыва.</b>
            <br>
            <b>Ваш может стать первым!</b>
        </div>
    </div>

@endsection
