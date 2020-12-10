@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.profile.profile_header')
    <div class="container mt-4 mb-5">
        <div class="dep mx-sm-5 text-center text-sm-left">
            <a href="{{ route('user.profile.reviews') }}" @if(!isset($type)) class="active" @endif>Мои отзывы</a>
            @if($user_company->count() != 0)
                <a href="{{ route('user.profile.reviews', "type=1") }}" @if($type == 1) class="active" @endif>Моя компания</a>
            @endif
        </div>
        @foreach($reviews as $review)
        <div class="content-block mt-4 review py-3 px-4 mx-0 mx-sm-5">
            <div class="row m-0">
                <div class="col-auto pl-0">
                    <img src="{{ !empty($review->comp_logo) ? $review->comp_logo : "/app/assets/img/noavatar.png" }}" class="avatar">
                </div>
                <div class="col pl-0">
                    <div class="row m-0 align-items-center">
                        <div class="col p-0">
                            @if(!isset($type))
                                <a href="{{ route('company.index', $review->comp_id) }}" target="_blank">{!! $review->comp_title !!}</a>
                            @else
                                <a href="#" style="pointer-events: none;">{!! $review->author !!}</a>
                            @endif
                        </div>
                    </div>
                    <div class="row m-0 align-items-center lh-1">
                        <div class="col p-0">
                            <img src="/app/assets/img/rate-{{ $review->rate }}.png" alt="rate">
                        </div>
                    </div>
                </div>
            </div>
            <span class="review-title">Отзыв</span>
            <p class="review-content">{{ $review['comp_comment_lang']->content }}</p>
            <span class="review-title">Достоинства:</span>
            <p class="review-content">{{ $review['comp_comment_lang']->content_plus }}</p>
            <span class="review-title">Недостатки:</span>
            <p class="review-content">{{ $review['comp_comment_lang']->content_minus }}</p>
        </div>
        @endforeach
    </div>
@endsection
