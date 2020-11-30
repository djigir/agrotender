@extends('layout.layout', ['meta' => $meta, 'rubricGroups' => $rubricGroups,'regions' => $regions])

@section('content')
    @include('filters.filter-companies', ['regions' => $regions, 'rubricGroups' => $rubricGroups])
    <div class="d-none d-sm-block container mt-3"></div>
    <div class="d-sm-none container pt-4">
        @if($region_id)
            <div>
                <span class="searchTag regionTag d-inline-block">{{$region_name}}
                    <a href="{{!$rubric_id ? route('company.region', 'ukraine') : route('company.region_culture', ['ukraine', $rubric_id])}}">
                        <i class="far fa-times close ml-3"></i>
                    </a>
                </span>
            </div>
        @endif
        @if($rubric_id)
            <div>
                <span class="searchTag regionTag d-inline-block">{{$culture_name}}<a href="{{route('company.region', $region)}}">
                        <i class="far fa-times close ml-3"></i>
                    </a>
                </span>
            </div>
        @endif
    </div>
    <div class="container pb-4 companies">
        @foreach($companies as $index => $company)
            <div class="row content-block companyItem mx-0 mt-4 pt-3 pb-1 py-sm-3 px-1
                {{$company['trader_premium'] == 1 || $company['trader_premium'] == 2 ? 'companyTop' : ''}}"
                {{$company['trader_premium'] == 2 ?? 'style ="overflow:hidden;'}}>
                @if($company['trader_premium'] == 2)
                    <div class="ribbonComp">
                        VIP
                    </div>
                @endif
                <div class="row mx-0 w-100">
                    <div class="col-auto pr-0 pl-2 pl-sm-3">
                        <div class="row m-0">
                            <div class="col-12 pl-0 pr-0 pr-sm-2">
                                <a href="{{route('company.index', $company['id'])}}">
                                    <img class="companyImg" alt="{{$company['name']}}"
                                         src="{{ $company['logo_file'] ? $company['logo_file'] : '/app/assets/img/no-image.png' }}"/>
                                </a>
                            </div>
                        </div>
                        <div class="row m-0 pt-3 d-none d-sm-flex">
                            <div class="col-12 pl-0 pr-2 text-center">
                                <span class="date">На сайте {{$company['date']}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row lh-1">
                            <div class="col">
                                <span class="title">
                                    <a href="{{route('company.index', $company['id'])}}">{!!  str_replace('\\', '', $company['title']) !!}
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="row d-sm-none lh-1">
                            <div class="col">
                                <span class="date mb-2">На сайте {{$company['date']}}</span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col mt-1">
                                <p class="desc">{{ strip_tags($company['short']) }}</p>
                            </div>
                        </div>
                        <div class="row lh-1-2">
                            <div class="col">
                                <span class="a-bold d-none d-sm-inline-block">Виды деятельности:</span>
                                <span class="activities d-none d-sm-block"
                                      @if(strlen($company['activities_text']) > 75)
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title="{{$company['activities_text']}}"
                                      @endif aria-describedby="tooltip">
                                    {{ \Illuminate\Support\Str::limit($company['activities_text'], 75, $end='...') }}
                                </span>
                                <span class="activities d-block d-sm-none"
                                      @if(strlen($company['activities_text']) > 57)
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title="{{$company['activities_text']}}"
                              @endif>
                            {{ \Illuminate\Support\Str::limit($company['activities_text'], 57, $end='...') }}
                        </span>
                            </div>
                        </div>
                        <div class="row d-none d-sm-flex">
                            <div class="col pt-2 mt-1">
                                @if($company['trader_price_avail'] == 1 and $company['trader_price_visible'] == 1)
                                    <a class="link" href="{{route('company.index', $company['id'])}}"><span>Цены Трейдера</span></a>
                                @endif


{{--                                @if($company['purchases'] > 0)--}}
{{--                                    <a class="link" href="{{route('company.index', $company['id'])}}{{$company['id']}}-adverts?type=1"><span>Закупки ({{$company['purchases']}})</span></a>--}}
{{--                                @endif--}}

{{--                                @if($company['sales'] > 0)--}}
{{--                                    <a class="link" href="{{route('company.index', $company['id'])}}{{$company['id']}}-adverts?type=2"><span>Товары ({{$company['sales']}})</span></a>--}}
{{--                                @endif--}}

{{--                                @if($company['services'] > 0)--}}
{{--                                    <a class="link" href="{{route('company.index', $company['id'])}}{{$company['id']}}-adverts?type=3"><span>Услуги ({{$company['services']}})</span></a>--}}
{{--                                @endif--}}

                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block col-md-3">
                        @if($company['phone'] && $company['phone2'] && $company['phone3'])
                            <div class="companySticker">
                                @if($company['phone'])
                                    <span>{{$company['phone']}}</span>
                                @endif
                                @if($company['phone2'])
                                    <span>{{$company['phone2']}}</span>
                                @endif
                                @if($company['phone3'])
                                    <span>{{$company['phone3']}}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mx-0 d-sm-none lh-1 w-100">
                    <div class="col mt-2 text-center">
                        @if($company['trader_price_avail'] == 1 and $company['trader_price_visible'] == 1)
                            <a class="link" href="{{route('company.index', $company['id'])}}"><span>Цены Трейдера</span></a>
                        @endif

{{--                        @if($company['purchases'] > 0)--}}
{{--                            <a class="link" href="{{route('company.index', $company['id'])}}-adverts?type=1"><span>Закупки ({{$company['purchases']}})</span></a>--}}
{{--                        @endif--}}
{{--                        @if($company['sales'] > 0)--}}
{{--                            <a class="link" href="{{route('company.index', $company['id'])}}-adverts?type=2"><span>Товары ({{$company['sales']}})</span></a>--}}
{{--                        @endif--}}
{{--                        @if($company['services'] > 0)--}}
{{--                            <a class="link" href="{{route('company.index', $company['id'])}}-adverts?type=3"><span>Услуги ({{$company['services']}})</span></a>--}}
{{--                        @endif--}}

                    </div>
                </div>
            </div>
        @endforeach
        <div class="container">
            <div class="empty pt-0 pt-md-5">
                <div class="sketch mt-3 mt-md-5">
                    <div class="bee-sketch red"></div>
                    <div class="bee-sketch blue"></div>
                </div>
            </div>
        </div>
        {{ $companies->links() }}
    </div>
    @include('partials.banners.bottom')
@endsection

