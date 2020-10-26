@extends('layout.layout', ['title' => $meta['title'],
'keywords' => $meta['keywords'],
'description' => $meta['description']])

@section('content')

    @include('company.company-header', ['id' => $id, 'company_name' => $company['title']])

    <div class="container">
        <div class="row mt-4 pt-sm-3 mx-0 mx-sm-5 align-items-center justify-content-between">
            <div class="col-4 d-block">
                <h2 class="d-inline-block text-uppercase">Отзывы</h2>
            </div>
            <div class="col-8 text-center text-md-right">
                <a href="#" class="top-btn btn btn-primary align-bottom addReview">
{{--                    <span class="pl-1 pr-1">Оставить отзыв</span>--}}
<!-- Button trigger modal -->
                <span data-toggle="modal" data-target="#exampleModalCenter">Оставить отзыв</span>
                </a>
            </div>
        </div>
    </div>
    <div class="container mb-5">
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
                    <img src="@if(isset($review['logo_file'])) {{ $review['logo_file'] }} @else /app/assets/img/noavatar.png   @endif" class="avatar">
                </div>
                <div class="col pl-0">
                    <div class="row m-0 align-items-center">
                        <div class="col p-0">

                            @if(isset($review['title']))
                                 <a href="{{ route('company.company', $review['comp_id']) }}" target="_blank">{!! $review['title'] !!} </a>
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
                    @if(!is_null($review['comp_comment_lang']['content']) && $review['comp_comment_lang']['content'] !== '')
                <span class="review-title">Отзыв</span>
                <p class="review-content">{{ $review['comp_comment_lang']['content'] }}</p>
                @endif

                    @if(!is_null($review['comp_comment_lang']['content_plus']) && $review['comp_comment_lang']['content_plus'] !== '')
                <span class="review-title">Достоинства:</span>
                <p class="review-content">{{ $review['comp_comment_lang']['content_plus'] }}</p>
                @endif

                    @if(!is_null($review['comp_comment_lang']['content_minus']) && $review['comp_comment_lang']['content_minus'] !== '')
                <span class="review-title">Недостатки:</span>
                <p class="review-content">{{ $review['comp_comment_lang']['content_minus'] }}</p>
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

{{--    @auth()--}}
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-3" id="exampleModalLongTitle">Оставить отзыв</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <div class="form-group row mb-4 pb-1">
                                <label class="col-sm-3 col-form-label text-left text-sm-right">Достоинства <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Достоинства" name="good">
                                </div>
                            </div>
                            <div class="form-group row mb-4 pb-1">
                                <label class="col-sm-3 col-form-label text-left text-sm-right">Недостатки <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Недостатки" name="bad">
                                </div>
                            </div>
                            <div class="form-group row mb-4 pb-1">
                                <label class="col-sm-3 col-form-label text-left text-sm-right">Комментарий</label>
                                <div class="col-sm-9">
                            <textarea class="form-control" name="comment" rows="7"
                                      style="margin-top: 0px; margin-bottom: 0px; height: 254px;"></textarea>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer d-block text-center text-sm-left d-sm-flex justify-content-end pt-2 mb-2 px-5">
                        <div id="colorstar" data-rate="1"
                             class="starrr ratable text-center mr-3 d-block d-sm-inline-block mb-3 mb-sm-0">
                            <span data-num="1" class="fas fa-star"></span>
                            <span data-num="2" class="far fa-star"></span>
                            <span data-num="3" class="far fa-star"></span>
                            <span data-num="4" class="far fa-star"></span>
                            <span data-num="5" class="far fa-star"></span>
                        </div>
                        <button type="submit" class="btn btn-primary px-5 send-review" name="add_comment">Отправить отзыв</button>
                    </div>
                        </form>
                </div>
            </div>
        </div>
{{--    @endauth--}}


    <div id="noty_layout__bottomLeft" role="alert" aria-live="polite" class="noty_layout animate__animated animate__fadeInRightBig animate__faster" style="display: none">
        <div id="noty_bar_9da52369-9ae9-49da-858f-5f3687604672"
             class="noty_bar noty_type__error noty_theme__nest noty_close_with_click noty_has_timeout noty_has_progressbar">
            <div class="noty_body">Нужно авторизоваться.</div>
            <div class="noty_progressbar" style="transition: width 4000ms linear 0s; width: 0%;"></div>
        </div>
    </div>





@endsection
