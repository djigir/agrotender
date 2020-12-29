<?php
if($regions->count() > 0 && !$isMobile){
    $temp = $regions[25];
    $regions[25] = $regions[0];
    $regions[0] = $temp;
}
?>

<div class="d-none d-sm-block new_container mt-3">
    <ol class="breadcrumbs small p-0">
        <li>
            <a href="/">Главная</a>
        </li>
        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.35355 4.35355C7.54882 4.15829 7.54882 3.84171 7.35355 3.64645L4.17157 0.464466C3.97631 0.269204 3.65973 0.269204 3.46447 0.464466C3.2692 0.659728 3.2692 0.976311 3.46447 1.17157L6.29289 4L3.46447 6.82843C3.2692 7.02369 3.2692 7.34027 3.46447 7.53553C3.65973 7.7308 3.97631 7.7308 4.17157 7.53553L7.35355 4.35355ZM0 4.5H7V3.5H0V4.5Z" fill="#93A2BA"/>
        </svg>
        @foreach($breadcrumbs as $index_bread => $breadcrumb)
            <li>
                @if($breadcrumb['url'])
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

    <div
        class="new_fitlers_container"
        data-companyName="{{ isset($query) && $query ? $query : ''}}"
        data-category="{{$culture_name}}"
        data-region="{{$region_name}}"
        data-type="companies"
    >
        <div class="company_filter">
            <form>
                <input type="text" class="company_filter-item search_field" placeholder="Название компании" value="{{isset($query) && $query != null ? $query : ''}}" id="test">
                <button type="button" class="company_filter-item chose_field first-btn new_filters_btn">{{$culture_name}}</button>
                <button type="button" class="company_filter-item chose_field second-btn new_filters_btn">{{$region_name}}</button>
                <button type="submit" class="company_filter-item search_btn">Найти</button>
            </form>

            <div class="new_filters_dropdown" id="category_dropdown">
                <div class="new_filters_dropdown_column culures_first js_first">
                    <ul>
                        @foreach($rubricGroups as $index => $rubric)
                            <?php
                                $class = '';

                                if($index == $group_id){
                                    $class = 'active';
                                }

                                if(!$group_id && $index == 1){
                                    $class = 'active';
                                }
                            ?>
                            <li class="{{$class}}">
                                <a href="#">{{$rubric['title']}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="new_filters_dropdown_column content">
                    @foreach($rubricGroups as $index => $rubric)
                        <?php
                            $class = '';
                            $class_a = '';

                            if($index == $group_id){
                                $class = 'active';
                            }

                            if(!$group_id && $index == 1){
                                $class = 'active';
                            }
                        ?>
                        <div class="new_filters_dropdown_column_tab js_content {{$class}}">
                            @foreach(collect($rubricGroups[$rubric['id']]["comp_topic"])->chunk(7) as $chunk)
                                <div class="new_filters_dropdown_column_item">
                                    <ul>
                                        @foreach($chunk as $item)
                                            <li>
                                                <a class="{{$rubric_id == $item['id'] ? 'selected_in_filter' : ''}}" href="{{route('company.region_culture', [isset($region) ? $region : 'ukraine', $item['id']])}}" class="companies_link_country" data-url="world">{{$item['title']}} ({{$item['cnt']}})</a>
                                            </li>
                                       @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="new_filters_dropdown" id="country_dropdown">
                <div class="new_filters_dropdown_column content">
                    <div class="new_filters_dropdown_column_tab js_content active without_first_column">
                        @foreach($regions->chunk(7) as $index_chunk => $chunk)
                            <div class="new_filters_dropdown_column_item">
                                <ul>
                                    @foreach($chunk as $index_region => $region)
                                        <?php
                                            $class = '';
                                            if($region_translit == $region['translit']){
                                                $class = 'selected_in_filter';
                                            }
                                        ?>
                                        @if(isset($region['count_items']) and $region['count_items'] > 0)
                                            <li>
                                                @if($rubric_id and $region)
                                                    <a class="{{$class}}" href="{{route('company.region_culture', [$region['translit'], $rubric_id])}}" class="companies_link_category">
                                                        {{$region['name']}}({{$region['count_items']}})
                                                    </a>
                                                @else
                                                    <a class="{{$class}}" href="{{route('company.region', $region['translit'])}}" class="companies_link_category">
                                                        {{$region['name']}}({{$region['count_items']}})
                                                    </a>
                                                @endif
                                            </li>
                                        @else
                                            @if($index_chunk == 0 and $index_region == 0)
                                                <li>
                                                    <a class="{{$class}}" href="{{($rubric_id and $region) ? route('company.region_culture', ['ukraine', $rubric_id]): route('company.region', 'ukraine')}}"
                                                       class="companies_link_category">
                                                        {{$region['name']}}
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <span class="companies_link_category">{{$region['name']}}</span>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 pt-3">
        <div class="col-12 col-sm-6 float-left mt-0 d-flex d-sm-block">
            <h2 class="d-inline-block text-uppercase">{!! isset($query) ? 'Поиск: '. $query : 'Список компаний' !!}</h2>
            <div>
                <a href="/tarif20.html" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
            </div>
        </div>
        <div class="col-12 col-sm-6 float-md-right text-right">
            <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end">
                <i class="far fa-plus mr-2"></i>
                <span class="pl-1 pr-1">Разместить компанию</span>
            </a>
        </div>
    </div>
</div>

<div class="new_container">
    <h2 class="d-block text-uppercase d-sm-none companies_list">{!! isset($query) ? 'Поиск: '. $query : 'Список компаний' !!}</h2>
</div>



<style>
    .btn-search{
        background: none;
        border: none;
        outline: 0 !important;
    }

    .searchInput {
        padding: .375rem 6rem .475rem 1.4rem!important;
    }
</style>
