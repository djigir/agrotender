@extends('layout.layout', ['title' => $meta['meta_title'],
'keywords' => $meta['meta_title'],
'description' => $meta['meta_title']])

@section('content')
    @if($isMobile)
        @include('mobile.company-header-mobile')
    @else
        @include('company.company-header', ['id' => $id])
    @endif
    <div class="new_container">
        <div class="row mt-4 pt-sm-3 mx-0 mx-sm-5 align-items-center justify-content-between">
            <div class="col-4 d-block">
                <h2 class="d-inline-block text-uppercase">Отзывы</h2>
            </div>
            <div class="col-8 text-center text-md-right" id="reviews">
                <a href="#" class="top-btn btn btn-primary align-bottom addReview">
{{--                    <span class="pl-1 pr-1">Оставить отзыв</span>--}}
<!-- Button trigger modal -->
                <span data-toggle="modal" data-target="#exampleModalCenter"><span>Оставить отзыв</span></span>
                </a>
            </div>
        </div>
    </div>
    <div class="new_container mb-5">
    @forelse($reviews_with_comp as $review)
        <div class="content-block mt-4 review pt-3 mx-0 mx-sm-5">
            <div class="row comment-row px-3" review-id="{{ $review['id'] }}">
                <div class="col-12">
                    <textarea class="form-control" placeholder="Комментарий">{if $review['comment'] neq null}{$review['comment']}{/if} </textarea>
                    <button class="btn btn-success btn-block mt-3 save-review-comment">Сохранить комментарий</button>
                    <hr>
                </div>
            </div>
            <div class="row m-0 px-3">
                <div class="col-auto pl-0">
                    <img src="{{!empty($review['company']) ? $review['company']['logo_file'] : '/app/assets/img/noavatar.png' }}" class="avatar">
                </div>
                <div class="col pl-0">
                    <div class="row m-0 align-items-center">
                        <div class="col p-0">
                            @if(!empty($review['company']))
                                 <a href="{{ route('company.index', $review['company']['id']) }}" target="_blank">{!! $review['company']['title'] !!} </a>
                            @else
                                <span class="author">{{ $review['author'] }}</span>
                            @endif
                            {{-- доделать когда будет авторизация --}}
                            {{--{if $company['id'] == $user->company['id']}
                            <i class="far fa-reply review-comment ml-1"></i>
                            {/if}--}}
                            {{-- доделать когда будет авторизация --}}
                        </div>
                    </div>
                    <div class="row m-0 align-items-center lh-1">
                        <div class="col p-0">
                            <img src="/app/assets/img/rate-{{ $review['rate'] }}.png">
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-3">
            @if(isset($review['comment_lang']['content']))
                    <span class="review-title">Отзыв</span>
                <p class="review-content">{{ $review['comment_lang']['content'] }}</p>
                @endif
                    @if(isset($review['comment_lang']['content_plus']))
                <span class="review-title">Достоинства:</span>
                <p class="review-content">{{ $review['comment_lang']['content_plus'] }}</p>
                @endif

                    @if(isset($review['comment_lang']['content_minus']))
                <span class="review-title">Недостатки:</span>
                <p class="review-content">{{ $review['comment_lang']['content_minus'] }}</p>
                @endif

                {{-- найти коментарий компании
                @if(!is_null($review['comment']) && $review['comment'] !== '')

                @endif--}}
            </div>
            {{--{if $review['comment'] neq null}
            <div class="companyComment">
                <span>Комментарий компании:</span>
                <p class="mb-0">{$review['comment']}</p>
            </div>
            {/if}--}}
        </div>

        @empty
        <div class="content-block mt-4 review py-3 px-4 mx-0 mx-sm-5 text-center">
            <b>У компании ещё нет ни одного отзыва.</b>
            <br>
            <b>Ваш может стать первым!</b>
        </div>
        @endforelse
    </div>


    @auth()
        <div class="modal fade show" id="reviewModal" tabindex="-1" role="dialog" style="display: none">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <form class="form modal-content"  action="{{route('company.create_review', $id)}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title ml-3">Оставить отзыв</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body pr-5 mt-4">
                        <div class="form-group row mb-4 pb-1">
                            <label class="col-sm-3 col-form-label text-left text-sm-right">Достоинства <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Достоинства" name="content_plus" required minlength="20">
                            </div>
                        </div>
                        <div class="form-group row mb-4 pb-1">
                            <label class="col-sm-3 col-form-label text-left text-sm-right">Недостатки <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Недостатки" name="content_minus" required minlength="20">
                            </div>
                        </div>
                        <div class="form-group row mb-4 pb-1">
                            <label class="col-sm-3 col-form-label text-left text-sm-right">Комментарий</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="content" rows="7"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-block text-center text-sm-left d-sm-flex justify-content-end pt-2 mb-2 px-5">
                        <div id="colorstar" data-rate="3" class="starrr ratable text-center mr-3 d-block d-sm-inline-block mb-3 mb-sm-0">
                            <span rate="1" data-num="1" class="fas fa-star" id="first-rate"></span>
                            <span rate="2" data-num="2" class="fas fa-star add_rate"></span>
                            <span rate="3" data-num="3" class="fas fa-star add_rate"></span>
                            <span rate="4" data-num="4" class="far fa-star add_rate"></span>
                            <span rate="5" data-num="5" class="far fa-star add_rate"></span>
                            <input type="text" class="rate_input" name="rate" value="3" style="opacity: 0; border: none; outline: none">
                        </div>
                        <button type="submit" class="btn btn-primary px-5 send-review">Отправить отзыв</button>
                    </div>
                </form>
            </div>
        </div>
    @endauth

    @if(!auth()->user())
    <div id="noty_layout__bottomLeft" role="alert" aria-live="polite" class="noty_layout animate__animated animate__fadeInRightBig animate__faster" style="display: none">
        <div id="noty_bar_9da52369-9ae9-49da-858f-5f3687604672"
             class="noty_bar noty_type__error noty_theme__nest noty_close_with_click noty_has_timeout noty_has_progressbar">
            <div class="noty_body">Нужно авторизоваться.</div>
            <div class="noty_progressbar" style="transition: width 4000ms linear 0s; width: 0%;"></div>
        </div>
    </div>
    @endif

    @if ($errors->any())
        <div id="noty_layout__bottomLeft" role="alert" aria-live="polite" class="noty_layout animate__animated animate__fadeInRightBig animate__faster" style="display: block">
            <div id="noty_bar_9da52369-9ae9-49da-858f-5f3687604672"
                 class="noty_bar noty_type__error noty_theme__nest noty_close_with_click noty_has_timeout noty_has_progressbar">
                <div class="noty_body">Укажите достоинства и недостатки компании.</div>
                <div class="noty_progressbar" style="transition: width 4000ms linear 0s; width: 0%;"></div>
            </div>
        </div>
    @endif

    @auth()
    <div class="fade" id="bg-modal"></div>
    @endauth

@endsection
