@extends('layout.layout')

@section('content')
    @if(!$isMobile)
        @include('filters.filter-evelators', ['regions' => $regions])
    @endif
<div class="container elev">
    @foreach($elevators as $index => $elevator)
        <div class="row mb-0 mb-sm-5 mx-0">
            <div class="col-12 col-sm-6 pr-0 {{$index%2==0 ? 'pr-sm-3' : ''}}">
                <a href="{{route('elev.elevator', $elevator->elev_url)}}"
                   class="row d-flex content-block p-2 {{$index%2==0 ? 'mr-0 mr-sm-4' : ''}}">
                    <div class="col-auto px-2 d-none d-sm-block">
                        <img src="/app/assets/img/granary-4.png" class="icon">
                    </div>
                    <div class="col pl-1 text-left d-flex align-items-center">
                        <div>
                            <span class="d-block title">{!! $elevator->orgname !!}</span>
                            <span class="d-block geo">{{$elevator->region['name']}} область / {{$elevator->name}} р-н</span>
                        </div>
                    </div>
                    <div class="col-auto px-2 d-flex align-items-center">
                        <i class="far fa-angle-right icon-right"></i>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
</div>

<div class="container d-flex justify-content-center mt-4 mb-5"></div>
@endsection
