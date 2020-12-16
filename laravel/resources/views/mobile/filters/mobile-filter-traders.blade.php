<div class="openFilter__wrap">
    <button class="openFilter chose_culture">
        <span>{{$culture_name}}</span>
    </button>
</div>
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
                <span>Фильтры</span>
                <a href="{{route('traders.region', 'ukraine')}}">Сбросить</a>
            </div>
            <div class="screens">
                <form action="">
                    <div class="first active">
                        <div class="mobile_filter-content">
                            <input type="text" id='new-input-mobile-rubric' name="rubric" value="{{$culture_translit != null ? $culture_translit : ''}}" class="remove-input">
                            <input type="text" id='new-input-mobile-region-t' name="region" value="{{$region_translit != null ? $region_translit: ''}}" class="remove-input">
                            <input type="text" id='new-input-mobile-port-t' name="port" value="{{$port_translit != null ? $port_translit: ''}}" class="remove-input">
                            <div class="mobile_filter-content-item withmargin" id="product" data-product="">{{$culture_name}}</div>
                            <div class="mobile_filter-content-item withmargin" id="region" data-region="">{{$region_port_name}}</div>
                        </div>

                        <div class="mobile-filter-footer">
                            <button type="submit">Применить</button>
                        </div>
                    </div>
                </form>

                <div class="second">
                    <div class="subItem">
                        @foreach($rubricsGroup as $group => $item)
                            <div class="mobile_filter-content-item" data-title="{{$item['groups']['name']}}">{{$item['groups']['name']}}</div>
                        @endforeach
                    </div>
                    <div class="subItem">
                        <div class="search_wrap">
                            <input type="text" placeholder="Название области или порта" class="search_filed">
                            <button>
                                <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                            </button>
                        </div>
                        <div class="default_value">
                            <div class="mobile_filter-section-text">Области</div>
                            <ul class="mobile_filter-section-list">
                                <li>
                                    <a class="click_region" href="#" data-id="1" data-url="ukraine">Вся Украина</a>
                                </li>
                                @foreach($regions as $region)
                                    <li>
                                        <a class="click_region" href="#" data-id="1" data-url="{{$region['translit']}}">{{$region['name']}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mobile_filter-section-text">Порты</div>
                            <ul class="mobile_filter-section-list">
                                @foreach($onlyPorts as $port)
                                    <li>
                                        <a class="click_port" href="#" data-id="1" data-url="{{$port['url']}}">{{$port['lang']['portname']}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="output_values">
                            <ul class="mobile_filter-section-list output"></ul>
                        </div>
                    </div>
                </div>

                <div class="third">
                    @foreach($rubricsGroup as $group => $item)
                        <div class="subItem">
                            <div class="search_wrap">
                                <input type="text" placeholder="Название культуры" class="search_filed">
                                <button>
                                    <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
                                </button>
                            </div>
                            <div class="default_value">
                                <?php
                                $NAME = [
                                    1 => 'Все зерновые',
                                    2 => 'Все масличные',
                                    3 => 'Все бобовые',
                                    4 => 'Все продукты переработки',
                                    5 => 'Все нишевые культуры',
                                    6 => 'Вся органика',
                                ];
                                ?>
                                <div class="mobile_filter-section-text">Популярное</div>
                                <ul class="mobile_filter-section-list">
                                    <li>
                                        <a class="click_culture" href="#" data-id="0" data-product="pshenica_2_kl">Пшеница 2 кл.</a>
                                    </li>
                                    <li>
                                        <a class="click_culture" href="#" data-id="0" data-product="pshenica_3_kl">Пшеница 3 кл.</a>
                                    </li>
                                    <li>
                                        <a class="click_culture" href="#" data-id="0" data-product="pshenica_4_kl">Пшеница 4 кл.</a>
                                    </li>
                                    <li>
                                        <a class="click_culture" href="#" data-id="0" data-product="yachmen">Ячмень</a>
                                    </li>
                                    <li>
                                        <a class="click_culture" href="#" data-id="0" data-product="kukuruza">Кукуруза</a>
                                    </li>
                                </ul>
                                <div class="mobile_filter-section-text">{{$NAME[$item['index_group']]}}</div>
                                <ul class="mobile_filter-section-list">
                                    @foreach($rubricsGroup[$group]['groups']["products"] as $cult)
                                        <li>
                                            <a class="click_culture" href="#" data-id="0" data-product="{{$cult['url']}}">{{$cult['traders_product_lang'][0]['name']}} ({{$cult['count_item']}})</a>
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
