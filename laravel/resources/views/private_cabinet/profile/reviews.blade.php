@extends('layout.layout')

@section('content')
    @include('private_cabinet.cabinet-header')
    @include('private_cabinet.profile.profile_header')
    <div class="container mt-4 mb-5">
        <div class="dep mx-sm-5 text-center text-sm-left">
            <a href="{{ route('user.profile.reviews') }}" class="active">Мои отзывы</a>
        </div>
        @foreach($reviews[0] as $review)
            {{ dump($review) }}
            @foreach($reviews[1] as $company)
                {{ dump($company->title) }}
            @endforeach
        @endforeach

        <div class="content-block mt-4 review py-3 px-4 mx-0 mx-sm-5">
            <div class="row m-0">
                <div class="col-auto pl-0">
                    <img src="/pics/comp/4593_70690.jpg" class="avatar">
                </div>
                <div class="col pl-0">
                    <div class="row m-0 align-items-center">
                        <div class="col p-0">
                            <a href="/kompanii/comp-4593" target="_blank">Прометей</a>
                        </div>
                    </div>
                    <div class="row m-0 align-items-center lh-1">
                        <div class="col p-0">
                            <img src="/app/assets/img/rate-3.png">
                        </div>
                    </div>
                </div>
            </div>
            <span class="review-title">Отзыв</span>
            <p class="review-content">vbjhvycftyudr5tsa46dtufygyufdtu7</p>
            <span class="review-title">Достоинства:</span>
            <p class="review-content"> fg fycxtycuctctyctycyt</p>
            <span class="review-title">Недостатки:</span>
            <p class="review-content"> cvgctuctucxtrxreawaw</p>
        </div>
    </div>
@endsection
