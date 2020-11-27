@extends('layout.layout')

@section('content')
   @include('filters.filter-evelators', ['regions' => $regions])

<div class="container elev">
    @foreach($elevators as $index => $elevator)
        <div class="row mb-0 mb-sm-5 mx-0">
            @foreach($elevator as $index_ele => $elev)
                <div class="col-12 col-sm-6 {{$index_ele % 2 == 0 ? 'pr-0 pr-sm-3' : ''}}">
                    <a href="{{route('elev.elevator', $elev->elev_url)}}" class="row d-flex content-block p-2 {{$index_ele % 2 == 0 ? 'mr-0 mr-sm-4' : ''}}">
                        <div class="col-auto px-2 d-none d-sm-block">
                            <img src="/app/assets/img/granary-4.png" class="icon">
                        </div>
                        <div class="col pl-1 text-left d-flex align-items-center">
                            <div>

                                <span class="d-block title">{!! \Illuminate\Support\Str::limit($elev->lang_elevator[0]['name'], 33, $end='...') !!}</span>
                                <span class="d-block geo">{{$elev->region[0]['name']}} область / {{$elev->lang_rayon[0]['name']}} р-н</span>
                            </div>
                        </div>
                        <div class="col-auto px-2 d-flex align-items-center">
                            <i class="far fa-angle-right icon-right"></i>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
