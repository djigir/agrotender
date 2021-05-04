@extends('layout.layout', ['meta' => $meta])

@section('content')
    @if($isMobile)
        @include('mobile.company-header-mobile')
    @else
        @include('company.company-header', ['id' => $id])
    @endif

    <div class="new_container company mt-4 mb-5">
        <div class="row">
            <div class="position-relative w-100">
                <div class="col-12 col-md-3 float-md-right text-center text-md-right">
                    <form method="GET" name="formTypeAdverts">
                        <select class="form-control" name="type" onchange="fireSubmit(event)">
                            <option value="" @if(!$type) selected="" @endif >Все объявления</option>
                            <option value="1" @if($type == 1) selected="" @endif >Закупки</option>
                            <option value="2" @if($type == 2) selected="" @endif >Продажи</option>
                            <option value="3" @if($type == 3) selected="" @endif >Услуги</option>
                        </select>
                    </form>
                </div>
                <div class="col-12 col-md-4 float-left mt-4 mt-md-0 d-none d-md-block">
                    <h2 class="d-inline-block">Объявления</h2>
                </div>
            </div>
        </div>
        @if($adverts->isEmpty())
            <div class="content-block text-center py-4 px-2 mt-4">
                <span class="emptyPosts">Список объявлений пуст.</span>
            </div>
        @else
            @foreach($adverts as $advert)
                <?php
                $TYPE_ADVERTS = [
                    1 => 'Закупки',
                    2 => 'Продажи',
                    3 => 'Услуги'
                ];

                $TYPE_CURRENCY = [
                    0 => 'грн.',
                    1 => 'грн.',
                    2 => '$',
                    3 => '€',
                ];
                ?>
                <div class="row content-block postItem mx-0 mt-3 mt-sm-4 pt-2 pb-2 py-sm-3 px-1">
                    <div class="row mx-0 w-100">
                        <div class="col-auto pr-0 pl-1 pl-sm-3">
                            <?php
                            $src_img = $image_advert->where('item_id', $advert->id)->first();

                            if ($src_img) {
                                $src_img = $src_img->filename_ico;
                            } else {
                                $src_img = null;
                            }

                            ?>
                            <img src="{{$src_img && file_exists($src_img) ? '/'.$src_img : '/app/assets/img/no-image.png'}}"
                                 class="postImg" alt="{{$advert->title_post}}">
                            <span class="badge t{{$advert->type_id}} align-self-center d-inline-block d-sm-none">{{isset($TYPE_ADVERTS[$advert->type_id]) ? mb_substr($TYPE_ADVERTS[$advert->type_id], 0, 1, "UTF-8") : ''}}</span>
                        </div>
                        <div class="col pr-0 pl-2 pl-sm-3">
                            <div class="row m-0">
                                <div class="col-12 col-sm-8 d-flex pl-1 pl-sm-0">
                                    <h1 class="title ml-0 d-none d-sm-block">
                                        <span class="badge t{{$advert->type_id}} d-none d-sm-inline-block">{{isset($TYPE_ADVERTS[$advert->type_id]) ? $TYPE_ADVERTS[$advert->type_id] : ''}}</span>
                                        <a href="/board/post-{{$advert->id}}">{{$advert->title_post}}</a>
                                    </h1>
                                    <span class="title align-self-center ml-0 ml-sm-2 d-block d-sm-none">
                                  <a href="/board/post-{{$advert->id}}">{{$advert->title_post}}</a>
                                </span>
                                </div>
                                <div class="d-none d-sm-flex col-sm-4 pr-sm-3 justify-content-end">
                                    <span class="price float-right">
                                        @if($advert->cost_dog == 1)
                                            Договорная
                                        @elseif($advert->cost_dog == 0 && !$advert->cost)
                                            0 грн.
                                        @else
                                            {{$advert->cost}} {{$TYPE_CURRENCY[$advert->cost_cur]}}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="row mx-0 w-100 m-bottom">
                                <div class="col p-0">
                                    <div class="row mx-0 postRowHeight mt-1">
                                        <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-flex d-sm-none">
                                            <span class="price align-self-center">
                                                @if($advert->cost_dog == 1)
                                                    Договорная
                                                @elseif($advert->cost_dog == 0 && !$advert->cost)
                                                    0 грн.
                                                @else
                                                    {{$advert->cost}} {{$TYPE_CURRENCY[$advert->cost_cur]}}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                                            <span class="rubric align-self-center">
                                                <?php
                                                $rubric = $rubric_advert->where('id', $advert->parent_id)->first()->title;
                                                ?>

                                                @if(!empty($rubric))
                                                    {{$rubric}}
                                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z"
                                                              fill="#93A2BA"/>
                                                    </svg>
                                                @endif
                                                {{$advert->title_topic}}
                                            </span>
                                        </div>
                                        <div class="d-none d-sm-flex col-sm-3 pr-sm-3 justify-content-end">
                                            <span class="unit float-right">
                                                @if($advert->amount && $advert->izm)
                                                    {{$advert->amount}} {{$advert->izm}}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mx-0 mt-0 d-sm-none">
                                        <div class="col-4 col-sm-9 pl-1 pr-0">
                                            <span class="unit align-self-center">
                                                @if($advert->amount && $advert->izm)
                                                    {{$advert->amount}} {{$advert->izm}}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-8 justify-content-end">
                                            <?php
                                            $parse_up_dt = \Jenssegers\Date\Date::parse($advert->up_dt);
                                            $up_dt = $parse_up_dt->format('d') . ' ' . mb_convert_case(mb_substr($parse_up_dt->format('F'), 0, 3, "UTF-8"), MB_CASE_TITLE, "UTF-8") . '.';

                                            if (Carbon\Carbon::today()->toDateString() == Carbon\Carbon::parse($advert->up_dt)->toDateString()) {
                                                $up_dt = 'сегодня ' . Carbon\Carbon::parse($advert->up_dt)->format('H:m');
                                            }

                                            if (Carbon\Carbon::yesterday()->toDateString() == Carbon\Carbon::parse($advert->up_dt)->toDateString()) {
                                                $up_dt = 'вчера ' . Carbon\Carbon::parse($advert->up_dt)->format('H:m');
                                            }
                                            ?>
                                            <span class="date float-right">
                                                {{$up_dt}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mx-0 w-100 d-bottom">
                                <div class="col p-0">
                                    <div class="row mx-0">
                                        <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                                            <span class="author align-self-center">{{$advert->author}}</span>
                                        </div>
                                    </div>
                                    <div class="row ml-0 mr-3 mt-1">
                                        <div class="col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                                            <span class="region align-self-center">{{$advert->region}}
                                                область, {{$advert->city}}</span>
                                        </div>
                                        <div class="d-none d-sm-flex col-sm-3 justify-content-end">
                                            <?php
                                            $parse_up_dt = \Jenssegers\Date\Date::parse($advert->up_dt);
                                            $up_dt = $parse_up_dt->format('d') . ' ' . mb_convert_case(mb_substr($parse_up_dt->format('F'), 0, 3, "UTF-8"), MB_CASE_TITLE, "UTF-8") . '.';

                                            if (Carbon\Carbon::today()->toDateString() == Carbon\Carbon::parse($advert->up_dt)->toDateString()) {
                                                $up_dt = 'сегодня ' . Carbon\Carbon::parse($advert->up_dt)->format('H:m');
                                            }

                                            if (Carbon\Carbon::yesterday()->toDateString() == Carbon\Carbon::parse($advert->up_dt)->toDateString()) {
                                                $up_dt = 'вчера ' . Carbon\Carbon::parse($advert->up_dt)->format('H:m');
                                            }
                                            ?>
                                            <span class="date float-right">
                                                {{$up_dt}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <script>
      function fireSubmit (event) {
        document.forms['formTypeAdverts'].submit()
      }
    </script>
@endsection
