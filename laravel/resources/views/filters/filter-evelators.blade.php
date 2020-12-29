<?php
if($regions->count() > 0 && !$isMobile){
    $temp = $regions[25];
    $regions[25] = $regions[0];
    $regions[0] = $temp;
}
?>

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

<div class="new_fitlers_container mb-5">

    <h2 class="d-inline-block text-uppercase mr-3">Элеваторы</h2>
    <button class="new_filters_btn" id="cultures_btn">{{$region_name}}</button>

    <div class="new_filters_dropdown" id="country_dropdown">
        <div class="new_filters_dropdown_column content">
            <div class="new_filters_dropdown_column_tab js_content active without_first_column">
                @foreach($regions->chunk(7) as $index_chunk => $chunk)
                    <div class="new_filters_dropdown_column_item">
                        <ul>
                            @foreach($chunk as $index_region => $region)
                                <?php
                                    $class = '';
                                    $class_ukraine = '';

                                    if($region_translit == $region['translit'] ){
                                        $class = 'selected_in_filter';
                                    }

                                    if($region['translit'] == 'ukraine' && $region_translit == null){
                                        $class_ukraine = 'selected_in_filter';
                                    }
                                ?>
                                <li>
                                    <a href="{{$region['translit'] != 'ukraine' ? route('elev.region', $region['translit']) : route('elev.elevators')}}"
                                       class="companies_link_category {{$class}} {{$class_ukraine}}">{{$region['name']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
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
