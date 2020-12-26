<?php
if($regions->count() > 0){
    $temp = $regions[25];
    $regions[25] = $regions[0];
    $regions[0] = $temp;
}
?>

<div class="new_container">
    <h2 class="text-uppercase companies_list">Компании</h2>
</div>

<div class="bg_filters"></div>
<button class="openFilter companyFind">
    <span>{{$region_name ? $region_name : 'Выбрать область'}}</span>
    <img src="https://agrotender.com.ua/app/assets/img/search_icon.svg" alt="">
</button>

<div class="mobile_filter-bg">
    <div class="mobile_filter">
        <div class="posrel">
            <div class="mobile_filter-header">
                <button class="back first-btn active">
                    <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                </button>
                <button class="back second-btn">
                    <img src="https://agrotender.com.ua/app/assets/img/chevron_left-bold.svg" alt="">
                </button>
                <button class="back third-btn">
                    <img src="https://agrotender.com.ua/app/assets/img/chevron_left-bold.svg" alt="">
                </button>
                <span class="name_rubric">Выбрать область</span>
                <a href="/elev" id="filterRebootBtn">Сбросить</a>
            </div>

            <div class="screens">
                <form class="first active">
                    <div class="subItem active">
                        <div class="search_wrap">
                            <input type="text" placeholder="Название области" class="search_filed">
                            <button>
                                <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                            </button>
                        </div>
                        <div class="default_value">
                            <ul class="mobile_filter-section-list">
                                @foreach($regions as $index_chunk => $region)
                                    <li>
                                        <a href="{{$region['translit'] != 'ukraine' ? route('elev.region', $region['translit']) : route('elev.elevators')}}" class="companies_link_category">{{$region['name']}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="output_values">
                            <ul class="mobile_filter-section-list output"></ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
