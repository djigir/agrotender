<?php
$route_name = \Route::getCurrentRoute()->getName();
$prefix = substr($route_name, 0, strpos($route_name, '.')).'.';

if($regions->count() > 0 && !$isMobile){
    $temp = $regions[25];
    $regions[25] = $regions[0];
    $regions[0] = $temp;
}
?>

  <div class="bg_filters"></div>
  <div class="new_fitlers_container">
    <button class="new_filters_btn" id="cultures_btn">{{$culture_name}}</button>
    <button class="new_filters_btn" id="regions_btn">{{$region_port_name}}</button>

    <div class="new_filters_dropdown" id="cultures_dropdown">
      <div class="new_filters_dropdown_column culures_first js_first">
        <ul>
          @foreach($rubricsGroup as $group => $item)
              <li class="{{$item['index_group'] == $group_id ? 'active': ''}}" group="{{$group+1}}">
                  <a href="#" data-id="{{$group+1}}">{{$item['groups']['name']}}</a>
              </li>
          @endforeach 
        </ul>
      </div>
      <div class="new_filters_dropdown_column content">
          @foreach($rubricsGroup as $group => $item)
              <div class="new_filters_dropdown_column_tab {{$item['index_group'] == $group_id ? 'active': ''}} js_content" group="{{$group+1}}" data-id="{{$group+1}}">
                @foreach($rubricsGroup[$group]['groups']["products"]->chunk(6) as $chunk)
                      <div class="new_filters_dropdown_column_item">
                          <ul>
                              @foreach($chunk as $item)
                                  <li>
                                      @if(!empty($region))
                                          <a href="{{route($prefix.'region_culture', [$region, $item['url']])}}">
                                              {{ $item['traders_product_lang'][0]['name']}}
                                              @if($item['count_item'] > 0)
                                                  ({{$item['count_item']}})
                                              @endif
                                          </a>
                                      @endif
                                      @if(!empty($port))
                                          <a href="{{route($prefix.'port_culture', [$port, $item['url']])}}">
                                              {{ $item['traders_product_lang'][0]['name']}}
                                              @if($item['count_item'] > 0)
                                                  ({{$item['count_item']}})
                                              @endif
                                          </a>
                                      @endif
                                  </li>
                              @endforeach
                          </ul>
                      </div>
                @endforeach
              </div>
          @endforeach
{{--        <div class="new_filters_dropdown_column_tab active js_content">--}}
{{--          <div class="new_filters_dropdown_column_item">--}}
{{--            <ul>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="region_ukraine">Вся Украина</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="kiyv">Киев</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="kiyv">Киев</a>--}}
{{--              </li>--}}
{{--            </ul>--}}
{{--          </div>--}}
{{--          <div class="new_filters_dropdown_column_item">--}}
{{--            <ul>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="region_ukraine">Вся Украина</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="kiyv">Киев</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="kiyv">Киев</a>--}}
{{--              </li>--}}
{{--            </ul>--}}
{{--          </div>--}}
{{--          <div class="new_filters_dropdown_column_item">--}}
{{--            <ul>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="region_ukraine">Вся Украина</a>--}}
{{--              </li>--}}
{{--            </ul>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--        <div class="new_filters_dropdown_column_tab js_content">--}}
{{--          <div class="new_filters_dropdown_column_item">--}}
{{--            <ul>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="region_ukraine">Вся Украина</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="kiyv">Киев</a>--}}
{{--              </li>--}}
{{--            </ul>--}}
{{--          </div>--}}
{{--          <div class="new_filters_dropdown_column_item">--}}
{{--            <ul>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="region_ukraine">Вся Украина</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="kiyv">Киев</a>--}}
{{--              </li>--}}
{{--            </ul>--}}
{{--          </div>--}}
{{--          <div class="new_filters_dropdown_column_item">--}}
{{--            <ul>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="region_ukraine">Вся Украина</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="kiyv">Киев</a>--}}
{{--              </li>--}}
{{--            </ul>--}}
{{--          </div>--}}
{{--        </div>--}}
      </div>
    </div>

    <div class="new_filters_dropdown" id="cultures_dropdown">
      <div class="new_filters_dropdown_column culures_first js_first">
        <ul>
          <li class="{{!empty($region) ? 'active' : ''}}">
            <a href="#" data-id="1">Области</a>
          </li>
          <li class="{{!empty($port) ? 'active' : ''}}">
            <a href="#" data-id="1">Порты</a>
          </li>
        </ul>
      </div>
      <div class="new_filters_dropdown_column content">
        <div class="new_filters_dropdown_column_tab {{!empty($region) ? 'active' : ''}}">
            @foreach($regions->chunk(9) as $chunk)
                <div class="new_filters_dropdown_column_item">
                    <ul>
                        @foreach($chunk as $region)
                            <li>
                                @if(!empty($culture) && !empty($region))
                                    <a data-id="1" data-url="{{$region['translit']}}" href="{{route($prefix.'region_culture', [$region['translit'], $culture_translit])}}">
                                        {{$region['name']}}
                                    </a>
                                @else
                                    @if(!empty($culture_translit))
                                        <a data-id="1" data-url="{{$region['translit']}}" href="{{route($prefix.'region_culture', [$region['translit'], $culture_translit])}}">
                                            {{$region['name']}}
                                        </a>
                                    @else
                                        <a data-id="1" data-url="{{$region['translit']}}" href="{{route($prefix.'region', $region['translit'])}}">
                                            {{$region['name']}}
                                        </a>
                                    @endif
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

{{--          <div class="new_filters_dropdown_column_item">--}}
{{--            <ul>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="region_ukraine">Вся Украина</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="kiyv">Киев</a>--}}
{{--              </li>--}}
{{--            </ul>--}}
{{--          </div>--}}
{{--          <div class="new_filters_dropdown_column_item">--}}
{{--            <ul>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="region_ukraine">Вся Украина</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="kiyv">Киев</a>--}}
{{--              </li>--}}
{{--            </ul>--}}
{{--          </div>--}}
{{--          <div class="new_filters_dropdown_column_item">--}}
{{--            <ul>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="region_ukraine">Вся Украина</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="1" data-url="kiyv">Киев</a>--}}
{{--              </li>--}}
{{--            </ul>--}}
{{--          </div>--}}
        </div>

        <div class="new_filters_dropdown_column_tab {{!empty($port) ? 'active' : ''}}">
            @foreach($onlyPorts->chunk(5) as $chunk)
                <div class="new_filters_dropdown_column_item">
                    <ul>
                        @foreach($chunk as $port)
                            <li>
                                @if(!empty($culture) && !empty($port))
                                    <a data-id="1" href="{{route($prefix.'port_culture', [$port['url'], $culture_translit])}}">
                                        {{$port['lang']['portname']}}
                                    </a>
                                @else
                                    @if(!empty($culture_translit))
                                        <a data-id="1" href="{{route($prefix.'port_culture', [$port['url'], $culture_translit])}}">
                                            {{$port['lang']['portname']}}
                                        </a>
                                    @else
                                        <a data-id="1" href="{{route($prefix.'port', $port['url'])}}">
                                            {{$port['lang']['portname']}}
                                        </a>
                                    @endif
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

{{--          <div class="new_filters_dropdown_column_item">--}}
{{--            <ul>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="2" data-url="region_ukraine">ПОРТЫ</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="2" data-url="kiyv">ПОРТЫ</a>--}}
{{--              </li>--}}
{{--            </ul>--}}
{{--          </div>--}}
{{--          <div class="new_filters_dropdown_column_item">--}}
{{--            <ul>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="2" data-url="region_ukraine">ПОРТЫ</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="2" data-url="kiyv">ПОРТЫ</a>--}}
{{--              </li>--}}
{{--            </ul>--}}
{{--          </div>--}}
{{--          <div class="new_filters_dropdown_column_item">--}}
{{--            <ul>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="2" data-url="region_ukraine">ПОРТЫ</a>--}}
{{--              </li>--}}
{{--              <li>--}}
{{--                <a href="#" data-id="2" data-url="kiyv">ПОРТЫ</a>--}}
{{--              </li>--}}
{{--            </ul>--}}
{{--          </div>--}}
        </div>
      </div>
    </div>
  </div>


  <div class="openFilter__wrap">
    <button class="openFilter">
      <span>Выбрать культуру</span>
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
          <a href="#">Сбросить</a>
        </div>
        <div class="screens">
          <form action="">
              <div class="first active">
                <div class="mobile_filter-content">
{{--                    <input type="radio" id="currency-uah" name="currency"  value="0">--}}
{{--                    <input type="radio"  id="currency-usd" name="currency"  value="1">--}}
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
                    <div class="mobile_filter-content-item">{{$item['groups']['name']}}</div>
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
                                  <li>
                                      <a href="#" data-id="0" data-product="">Вся рубрика</a>
                                  </li>
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

<!-- <div class="bg_filters"></div>
=======
<div class="d-none d-sm-block container mt-3">
<ol class="breadcrumbs small p-0">
    <li>
        <a href="/">Главная</a>
    </li>
    <i style="margin-right: .5rem" class="fas fa-chevron-right extra-small"></i>
{{--    @foreach($breadcrumbs as $index_bread => $breadcrumb)--}}
{{--        <li>--}}
{{--            @if($breadcrumb['url'])--}}
{{--                <a href="{{$breadcrumb['url']}}">--}}
{{--                    <h1>{!! $breadcrumb['name'] !!}</h1>--}}
{{--                </a>--}}
{{--            @else--}}
{{--                <h1>{!! $breadcrumb['name'] !!}</h1>--}}
{{--            @endif--}}
{{--        </li>--}}
{{--    @endforeach--}}
</ol>
</div>
{{--@include('traders.feed.traders_feed', ['feed' => $feed])--}}
<div class="bg_filters"></div>
>>>>>>> master
<div class="new_filters-wrap">
    <div class="replacement"></div>
    <div class="fixed-item">
        <div class="new_container">
            <div class="new_filters">
{{--                @include('filters.routeSection.firstSection')--}}
                <div class="filter__item producrion" id="choseProduct">
                    <button class="filter__button producrion-btn">
{{--                        {{$culture_name}}--}}
                    </button>
                    <div class="new_filters_dropdown-wrap">
                        <div class="new_filters_dropdown">
                            <div class="new_filters_dropdown-column">
                                <ul>
{{--                                    @foreach($rubricsGroup as $group => $item)--}}
{{--                                        <li class="group-culture {{$item['index_group'] == $group_id ? 'active': ''}}" group="{{$group+1}}">--}}
{{--                                            <a href="#">{{$item['groups']['name']}}</a>--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
                                </ul>
                            </div>
{{--                            @foreach($rubricsGroup as $group => $item)--}}
{{--                                <div class="new_filters_dropdown-content culture-group {{$item['index_group'] == $group_id ? 'active': ''}}" group="{{$group+1}}">--}}
{{--                                    <ul>--}}
{{--                                        @foreach($rubricsGroup[$group]['groups']["products"] as $index => $item)--}}
{{--                                            <li>--}}
{{--                                                @if(!empty($region))--}}
{{--                                                    <a style="pointer-events: {{$item['count_item'] == 0 ? 'none; color:#808080' : ''}}" href="{{route($prefix.'region_culture', [$region, $item['url']])}}">--}}
{{--                                                        {{ $item['traders_product_lang'][0]['name']}}--}}
{{--                                                        @if($item['count_item'] > 0)--}}
{{--                                                            ({{$item['count_item']}})--}}
{{--                                                        @endif--}}
{{--                                                    </a>--}}
{{--                                                @endif--}}
{{--                                                @if(!empty($port))--}}
{{--                                                    <a style="pointer-events: {{$item['count_item'] == 0 ? 'none; color:#808080' : ''}}" href="{{route($prefix.'port_culture', [$port, $item['url']])}}">--}}
{{--                                                        {{ $item['traders_product_lang'][0]['name']}}--}}
{{--                                                        @if($item['count_item'] > 0)--}}
{{--                                                            ({{$item['count_item']}})--}}
{{--                                                        @endif--}}
{{--                                                    </a>--}}
{{--                                                @endif--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
                        </div>
                    </div>
                </div>
                <div class="filter__item second" id="all_ukraine">
                    <button class="filter__button second">
{{--                        {{$region_port_name}}--}}
{{--                    </button>--}}
{{--                    <div class="new_filters_dropdown-wrap">--}}
{{--                        <div class="new_filters_dropdown">--}}
{{--                            <div class="new_filters_dropdown-column">--}}
{{--                                <ul>--}}
{{--                                    <li class="" id="active-region" check_active="{{!empty($region) ? true : false}}">--}}
{{--                                        <a href="#">Области</a>--}}
{{--                                    </li>--}}
{{--                                    <li class="" id="active-port" check_active="{{!empty($port) ? true : false}}">--}}
{{--                                        <a href="#">Порты</a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                            <div class="new_filters_dropdown-content active" id="show-region">--}}
{{--                                <ul>--}}
{{--                                    @foreach($regions as $index => $region)--}}
{{--                                        <li>--}}
{{--                                            @if(!empty($culture) && !empty($region))--}}
{{--                                                <a href="{{route($prefix.'region_culture', [$region['translit'], $culture_translit])}}">--}}
{{--                                                    {{$region['name']}}--}}
{{--                                                </a>--}}
{{--                                            @else--}}
{{--                                                @if(!empty($culture_translit))--}}
{{--                                                    <a href="{{route($prefix.'region_culture', [$region['translit'], $culture_translit])}}">--}}
{{--                                                        {{$region['name']}}--}}
{{--                                                    </a>--}}
{{--                                                @else--}}
{{--                                                    <a href="{{route($prefix.'region', $region['translit'])}}">--}}
{{--                                                        {{$region['name']}}--}}
{{--                                                    </a>--}}
{{--                                                @endif--}}
{{--                                            @endif--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}

{{--                            <div class="new_filters_dropdown-content" id="show-port" style="column-count: 3">--}}
{{--                                <ul>--}}
{{--                                    @foreach($onlyPorts as $index => $port)--}}
{{--                                        <li>--}}
{{--                                            @if(!empty($culture) && !empty($port))--}}
{{--                                                <a href="{{route($prefix.'port_culture', [$port['url'], $culture_translit])}}">--}}
{{--                                                    {{$port['portname']}}--}}
{{--                                                </a>--}}
{{--                                            @else--}}
{{--                                                @if(!empty($culture_translit))--}}
{{--                                                    <a href="{{route($prefix.'port_culture', [$port['url'], $culture_translit])}}">--}}
{{--                                                        {{$port['lang']['portname']}}--}}
{{--                                                    </a>--}}
{{--                                                @else--}}
{{--                                                    <a href="{{route($prefix.'port', $port['url'])}}">--}}
{{--                                                        {{$port['lang']['portname']}}--}}
{{--                                                    </a>--}}
{{--                                                @endif--}}
{{--                                            @endif--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter__item main">
                  <button class="filter__button main">USD</button>
                  <div class="new_filters_dropdown-wrap">
                    <div class="new_filters_dropdown">
                      <ul>
                        <li>
                          <a href="#">UAH</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <form style="display:flex;">
                    <div class="new_filters_checkbox first">
                        <button type="submit" class="btn-remove mt-0" name="currency" value="0">
                            <input class="inp-cbx" id="new_filters_currency_uah" type="checkbox"  currency="{{$currency}}">
                        <label class="cbx" for="new_filters_currency_uah">
                            <span>
                              <svg width="12px" height="10px">
                                <use xlink:href="#check"></use>
                              </svg>
                            </span>
                            <span name="uah">ГРН</span>
                        </label>
                        </button>
                    </div>
                    <div class="new_filters_checkbox second">
                        <button type="submit" class="btn-remove mt-0" name="currency" value="1">
                            <input class="inp-cbx" id="new_filters_currency_usd" type="checkbox" currency="{{$currency}}">
                        <label class="cbx" for="new_filters_currency_usd">
                            <span>
                              <svg width="12px" height="10px">
                                <use xlink:href="#check"></use>
                              </svg>
                            </span>
                            <span>USD</span>
                        </label>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<button class="openFilter">
  <img src="https://agrotender.com.ua/app/assets/img/blue_list.svg" alt="">
  <span>Открыть фильтры</span>
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
        <span>Фильтры</span>
        <a href="#">Сбросить</a>
      </div>
      <div class="screens">
        <div class="first active">
          <div class="mobile_filter-categories">
            <div class="mobile_filter-subtitle">Категория</div>
            <div class="mobile_filter-choose-items" data-current="traders">
              <a href="#" class="mobile_filter-choose-item active">Закупки</a>
              <a href="#" class="mobile_filter-choose-item">Форварды</a>
            </div>
          </div>
          <div class="mobile_filter-content">
            <div class="mobile_filter-content-item withmargin" id="product" data-product="">Выбрать продукцию</div>
            <div class="mobile_filter-content-item withmargin" id="region" data-region="region_kyiv">Вся Украина</div>
          </div>

          <div class="mobile-filter-footer">
            <button>Применить</button>
          </div>
        </div>

        <div class="second">
          <div class="subItem">
            <div class="mobile_filter-content-item">Зерновые</div>
            <div class="mobile_filter-content-item">Масличные</div>
            <div class="mobile_filter-content-item">Бобовые</div>
            <div class="mobile_filter-content-item">Продукты переработки</div>
            <div class="mobile_filter-content-item">Нишевые культуры</div>
          </div>
          <div class="subItem">
            <div class="search_wrap">
              <input type="text" placeholder="Название области или порта" class="search_filed">
              <button>
                <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
              </button>
            </div>
            <div class="mobile_filter-section-text">Порты</div>
            <ul class="mobile_filter-section-list">
              <li>
                <a href="#" data-id="1" data-url="region_ukraine">Вся Украина</a>
              </li>
              <li>
                <a href="#" data-id="1" data-url="kiyv">Киев</a>
              </li>
              <li>
                <a href="#" data-id="1" data-url="kharkov">Харьков</a>
              </li>
              <li>
                <a href="#" data-id="1" data-url="odessa">Одесса</a>
              </li>
              <li>
                <a href="#" data-id="1" data-url="winnica">Винница</a>
              </li>
            </ul>
          </div>
        </div>

        <div class="third">
          <div class="subItem">
            <div class="search_wrap">
              <input type="text" placeholder="Название области или порта" class="search_filed">
              <button>
                <img src="https://agrotender.com.ua/app/assets/img/times.svg" alt="">
              </button>
            </div>
            <div class="mobile_filter-section-text">Популярное</div>
            <ul class="mobile_filter-section-list">
              <li>
                <a href="#" data-id="0" data-product="psheniza_2kl">Пшеница 2 кл. (64)</a>
              </li>
              <li>
                <a href="#" data-id="0" data-product="psheniza_3kl">Пшеница 3 кл. (63)</a>
              </li>
              <li>
                <a href="#" data-id="0" data-product="psheniza_4kl">Пшеница 4 кл. (59)</a>
              </li>
              <li>
                <a href="#" data-id="0">Ячмень (51)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
              </li>
            </ul>
            <div class="mobile_filter-section-text">Все зерновые</div>
            <ul class="mobile_filter-section-list">
              <li>
                <a href="#" data-id="0" data-product="">Вся рубрика</a>
              </li>
              <li>
                <a href="#" data-id="0"  data-product="kukuruza">Кукуруза (27)</a>
              </li>
              <li>
                <a href="#" data-id="0"  data-product="kukuruza">>Кукуруза битая (2)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
              </li>
              <li>
                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
              </li>
            </ul>
          </div>
          <div class="subItem">
            <div class="mobile_filter-section-text">Популярное</div>
            <ul class="mobile_filter-section-list">
              <li>
                <a href="#" data-id="0">Пшеница 2 кл. (64)</a>
              </li>
              <li>
                <a href="#" data-id="0">Пшеница 3 кл. (63)</a>
              </li>
              <li>
                <a href="#" data-id="0">Пшеница 4 кл. (59)</a>
              </li>
              <li>
                <a href="#" data-id="0">Ячмень (51)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
              </li>
            </ul>
            <div class="mobile_filter-section-text">Все зерновые</div>
            <ul class="mobile_filter-section-list">
              <li>
                <a href="#" data-id="0">Вся рубрика</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза битая (2)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
              </li>
              <li>
                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
              </li>
            </ul>
          </div>
          <div class="subItem">
            <div class="mobile_filter-section-text">Популярное</div>
            <ul class="mobile_filter-section-list">
              <li>
                <a href="#" data-id="0">Пшеница 2 кл. (64)</a>
              </li>
              <li>
                <a href="#" data-id="0">Пшеница 3 кл. (63)</a>
              </li>
              <li>
                <a href="#" data-id="0">Пшеница 4 кл. (59)</a>
              </li>
              <li>
                <a href="#" data-id="0">Ячмень (51)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
              </li>
            </ul>
            <div class="mobile_filter-section-text">Все зерновые</div>
            <ul class="mobile_filter-section-list">
              <li>
                <a href="#" data-id="0">Вся рубрика</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза битая (2)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
              </li>
              <li>
                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
              </li>
            </ul>
          </div>
          <div class="subItem">
            <div class="mobile_filter-section-text">Популярное</div>
            <ul class="mobile_filter-section-list">
              <li>
                <a href="#" data-id="0">Пшеница 2 кл. (64)</a>
              </li>
              <li>
                <a href="#" data-id="0">Пшеница 3 кл. (63)</a>
              </li>
              <li>
                <a href="#" data-id="0">Пшеница 4 кл. (59)</a>
              </li>
              <li>
                <a href="#" data-id="0">Ячмень (51)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
              </li>
            </ul>
            <div class="mobile_filter-section-text">Все зерновые</div>
            <ul class="mobile_filter-section-list">
              <li>
                <a href="#" data-id="0">Вся рубрика</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза битая (2)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
              </li>
              <li>
                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
              </li>
            </ul>
          </div>
          <div class="subItem">
            <div class="mobile_filter-section-text">Популярное</div>
            <ul class="mobile_filter-section-list">
              <li>
                <a href="#" data-id="0">Пшеница 2 кл. (64)</a>
              </li>
              <li>
                <a href="#" data-id="0">Пшеница 3 кл. (63)</a>
              </li>
              <li>
                <a href="#" data-id="0">Пшеница 4 кл. (59)</a>
              </li>
              <li>
                <a href="#" data-id="0">Ячмень (51)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
              </li>
            </ul>
            <div class="mobile_filter-section-text">Все зерновые</div>
            <ul class="mobile_filter-section-list">
              <li>
                <a href="#" data-id="0">Вся рубрика</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза (27)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза битая (2)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза зерноотход (2)</a>
              </li>
              <li>
                <a href="#" data-id="0">Кукуруза кремнистая (1)</a>
              </li>
              <li>
                <a href="#"  data-id="0">Кукуруза с повыш. зерн.  (1)</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->

<style>
    .btn-remove{
        border: none;
        background: none;
        margin-top: 10px;
        margin-right: -10px;
        outline: 0 !important;
    }
</style>
