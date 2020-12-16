<div class="bg_filters"></div>

<button class="openFilter companyFind">
    <span>Найти компанию</span>
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
                <span class="name_rubric">Фильтры</span>
                <a href="{{route('company.companies')}}" id="filterRebootBtn">Сбросить</a>
            </div>

            <div class="screens">
                <form class="first active">
                    <div class="mobile_filter-content">
                        <div class="search_wrap">
                            <input name='query' type="text" placeholder="Название компании" class="search_filed_no_js first_screen" id="companySearchField" value="{{isset($query) && $query != null ? $query : ''}}">
                            <button class="first_screen" id="companySearchBtn">
                                <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                            </button>
                        </div>
                        <input type="text" class="hidden" id='input-mobile-rubric-company' name="rubric" value='{{isset($rubric_id) ? $rubric_id : ''}}'>
                        <input type="text" class="hidden" id='input-mobile-region-company' name="region" value='{{isset($region) ? $region: ''}}'>

                        <div class="mobile_filter-content-item withmargin" id="product" data-product="">{{$culture_name}}</div>
                        <div class="mobile_filter-content-item withmargin" id="region" data-region="region_kyiv">{{$region_name}}</div>
                    </div>

                    <div class="mobile-filter-footer">
                        <button>Применить</button>
                    </div>
                </form>

                <div class="second">
                    <div class="subItem">
                        @foreach($rubricGroups as $index_group => $rubricGroup)
                            <div class="mobile_filter-content-item click_name_rubric" group="{{$rubricGroup['id']}}" name_rubric="{{$rubricGroup['title']}}">{{$rubricGroup['title']}}</div>
                        @endforeach
                    </div>
                    <div class="subItem">
                        <div class="search_wrap">
                            <input type="text" placeholder="Название области" class="search_filed">
                            <button>
                                <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                            </button>
                        </div>
                        <div class="default_value">
                            <div class="mobile_filter-section-text">Области</div>
                            <ul class="mobile_filter-section-list">
                                @if(isset($regions))
                                    @foreach($regions as $index_region => $region)
                                        @if($index_region == 1)
                                            <li>
                                                <a href="#" class="click-region-company" data-id="1" data-url="ukraine" region="{{ 'ukraine' }}" region_name="Вся Украина">Вся Украина</a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="#" class="click-region-company" data-id="1" data-url="{{ $region['translit'] }}" region="{{ $region['translit'] }}" region_name="{{$region['name']}}">
                                                {{$region['name']}}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="output_values">
                            <ul class="mobile_filter-section-list output"></ul>
                        </div>
                    </div>
                </div>

                <div class="third">
                    @foreach($rubricGroups as $index_group => $rubricGroup)
                        <div class="subItem">
                            <div class="search_wrap">
                                <input type="text" placeholder="Название культуры" class="search_filed">
                                <button>
                                    <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                                </button>
                            </div>
                            <div class="default_value">
{{--                                <div class="mobile_filter-section-text">Все зерновые</div>--}}
                                <ul class="mobile_filter-section-list">
                                    @foreach($rubricGroup['comp_topic'] as $index_culture => $culture)
                                        <li group="{{$rubricGroup['id']}}" rubric="{{$culture['id']}}">
                                            <a class="click-culture-company" href="#" data-id="0" culture-id="{{$culture['id']}}">{{$culture['title']}}
                                                @if($culture['cnt'] > 0)
                                                    ({{$culture['cnt']}})
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="output_values">
                                <ul class="mobile_filter-section-list output"></ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
