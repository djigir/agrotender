<!-- <div class="container pt-2 pt-sm-3">
    <ol class="breadcrumbs small p-0 d-sm-block">
        <li>
            <a href="/"><span>Агротендер</span></a>
        </li>
        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z" fill="#93A2BA"/>
        </svg>
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
            @if(isset($breadcrumb['arrow']))
                <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z" fill="#93A2BA"/>
                </svg>
            @endif
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
</div> -->

<ol class="breadcrumbs small p-0 d-sm-block">
    <li>
        <a href="/"><span>Агротендер</span></a>
    </li>
    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z" fill="#93A2BA"/>
    </svg>
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
        @if(isset($breadcrumb['arrow']))
            <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z" fill="#93A2BA"/>
            </svg>
        @endif
    @endforeach
</ol>

<div class="bg_filters"></div>

<div class="new_fitlers_container">

    <h2 class="d-inline-block text-uppercase">Элеваторы</h2>
    <button class="new_filters_btn" id="cultures_btn">Выбрать страну</button>

    <div class="new_filters_dropdown" id="country_dropdown">
        <div class="new_filters_dropdown_column content">
            <div class="new_filters_dropdown_column_tab js_content active without_first_column">
                <div class="new_filters_dropdown_column_item">
                    <ul>
                        <li>
                            <a href="#" class="companies_link_category">Украина</a>
                        </li>
                        <li>
                            <a href="#" class="companies_link_category">Киев</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-remove{
        border: none;
        background: none;
        margin-top: 10px;
        margin-right: -10px;
        outline: 0 !important;
    }
</style>
