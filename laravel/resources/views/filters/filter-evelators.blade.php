<div class="container pt-2 pt-sm-3">
    <ol class="breadcrumbs small p-0 d-sm-block">
        <li>
            <a href="/"><span>Агротендер</span></a>
        </li>
        <i style="margin-right: .5rem" class="fas fa-chevron-right extra-small"></i>
        @foreach($breadcrumbs as $index_bread => $breadcrumb)
            <li>
                @if(!empty($breadcrumb['url']) && $breadcrumb['url'])
                    <a href="{{$breadcrumb['url']}}">
                        <h1>{!! $breadcrumb['name'] !!}</h1>
                    </a>
                @else
                    <h1>{{$breadcrumb['name']}}</h1>
                @endif
            </li>
        @endforeach
    </ol>
    <div class="row pt-0 pt-sm-3 my-3 my-sm-0 mb-sm-5">
        <div class="position-relative w-100">
            <div class="col-12 float-left d-block">
                <h2 class="d-inline-block text-uppercase">Элеваторы -
                    <span class="select-link">
                        <span class="select-region click_elev">{{$region_name}}</span>&nbsp;
                        <i class="far fa-chevron-down click_elev"></i>
                    </span>
                </h2>
            </div>
            <div class="dropdown-wrapper position-absolute regionDrop">
                <div class="dropdown" id="regionDrop" style="display: none;">
                    <span class="d-block">
                        <a class="regionLink d-inline-block {{!$region_translit ? 'text-muted disabled' : ''}}" href="{{route('elev.region', '')}}">
                            <span style="cursor: pointer">Вся Украина</span>
                        </a>
                        <a class="regionLink d-inline-block {{$region_translit == 'crimea' ? 'text-muted disabled' : ''}}" href="{{route('elev.region', 'crimea')}}">
                            <span>АР Крым</span>
                        </a>
                    </span>
                    <hr class="mt-1 mb-2">
                    <div class="section text-left">
                        <div class="row">
                            <div class="col" style="column-count: 3">
                                @foreach($regions as $index => $region)
                                    <a class="regionLink {{($region_translit == $region['translit']) ? 'active' : ''}}"
                                       href="{{route('elev.region', $region['translit'])}}">
                                        <span>{{$region['name'] != 'Вся Украина' ? $region['name'].' область' : 'Вся Украина'}}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
