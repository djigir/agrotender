@extends('layout.layout')
{{--Трейдер--}}

@section('content')

    @include('layout.layout-filter', ['section' => $section, 'rubricsGroup' => $rubric, 'onlyPorts' => $onlyPorts])

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
                    <a href="/traders/region_ukraine">Сбросить</a>
                </div>
                <div class="screens">
                    <div class="first active">
                        <div class="mobile_filter-categories">
                            <div class="mobile_filter-subtitle">Выбрать</div>
                            <div class="mobile_filter-choose-items" data-current="traders">
                                <a href="/traders_forwards/region_ukraine" class="mobile_filter-choose-item">Форварды</a>
                                {if $section eq 'buy'}
                                <a href="/traders_sell" class="mobile_filter-choose-item">Продажи</a>
                                {else}
                                <a href="/traders/region_ukraine" class="mobile_filter-choose-item">Закупки</a>
                                {/if}
                            </div>
                        </div>
                        <div class="mobile_filter-content">
                            <div class="mobile_filter-content-item withmargin" id="product" data-product="">Выбрать продукцию</div>
                            <div class="mobile_filter-content-item withmargin" id="region" data-region="region_kyiv">Вся Украина</div>

                            <div class="currency" data-currency="">
                                <span class="currency-t">Валюта:</span>
                                {{--                                {foreach from=$currencies item=c key=key}--}}
                                {{--                                <a class="inline-link{if $currency['id'] === $c['id']} active{/if}" href="{$smarty.server.SCRIPT_URI}{if $viewmod eq 'nontbl'}?viewmod=nontbl&{else}?{/if}currency={$key}">--}}
                                {{--                                    <span>{$c['name']}</span>--}}
                                {{--                                </a>--}}
                                {{--                                {/foreach}--}}
                                <div class="mobile_filter-choose-items">
                                    <span class="mobile_filter-choose-item active" data-currency="">Все</span>
                                    <span class="mobile_filter-choose-item" data-currency="uah">UAH</span>
                                    <span class="mobile_filter-choose-item" data-currency="usd">USD</span>
                                </div>
                            </div>
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
    </div>


    @if(isset($feed) && $feed)
        <div class="container mt-3 mt-sm-4 mb-3 mb-sm-0">
            <div class="content-block feed py-3 position-relative">
                <div class="swiper-container">
                    <div class="swiper-wrapper mx-0 ">
                        {foreach $feed as $item}
                        {assign var=rubrics_count value=$item['r']|@count}
                        <div class="swiper-slide">
                            <div class="feed-item row">
                                <div class="col-12 d-flex align-items-center">
                                    <div class="circle{if $item@iteration is div by 2} two{/if} d-inline-block mr-1"></div> <a href="/kompanii/comp-{$item['company_id']}" class="title lh-1">{$item['company']|unescape|truncate:25:"..":true}</a>
                                </div>
                                <div class="col-12 prices">
                                    <span class="price-{$item['onchange_class']} my-1">{$item['onchange']}</span>
                                    {foreach from=$item['r'] item=rubrics key=rubric}
                                    {if $rubrics@iteration eq 3}
                                    {break}
                                    {/if}
                                    <div class="d-flex justify-content-between align-items-center ar">
                                        <span class="rubric">{$rubric|unescape|truncate:18:"..":true}</span>
                                        <div class="d-flex align-items-center lh-1 priceItem">
                                            {foreach $rubrics as $rubric_item}
                                            {foreach $rubric_item as $value}
                                            {if $value eq '0'}
                                            &nbsp;<img src="/app/assets/img/price-up.svg">
                                            {/if}
                                            {if $value eq '1'}
                                            &nbsp;<img src="/app/assets/img/price-down.svg">
                                            {/if}
                                            {/foreach}
                                            {/foreach}
                                        </div>
                                    </div>
                                    {/foreach}
                                </div>
                                <div class="col-12 d-flex align-items-center justify-content-between mt-1">
                                    <a href="/kompanii/comp-{$item['company_id']}" class="more">{if ($rubrics_count - 2) > 0}+ ещё {$rubrics_count - 2}{/if}</a>
                                    <span class="time">{$item['change_time']}</span>
                                </div>
                            </div>
                        </div>
                        {/foreach}
                    </div>
                    <!-- Add Arrows -->
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    @endif

    <svg class="inline-svg">
        <symbol id="check" viewbox="0 0 12 10">
            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
        </symbol>
    </svg>


    <div class="bg_filters"></div>



    <!-- VIP Traders Banner  -->
    @if($traders->count()>0)


        @if($viewmod == 'nontbl' )
            @include('traders.trader_list_nontbl',['traders'=>$traders])
        @else
            @include('traders.trader_list_tbl',['traders'=>$traders])
        @endif
        <!-- End Vip Traders -->




    @endif
    {{--    {if $region neq null or $rubric neq null or $currency neq null}--}}
    {{--    <div class="d-sm-none container  pt-2 pt-sm-4">--}}
    {{--        {if $rubric neq null}--}}
    {{--        <span class="searchTag d-inline-block">{$rubric['name']} <a href="/traders{if $region neq null}/region_{$region['translit']}{else}/region_ukraine{/if}{if $currency neq null}?currency={$currency['code']}{/if}"><i class="far fa-times close ml-2"></i></a></span>--}}
    {{--        {/if}--}}
    {{--        {if $region neq null}--}}
    {{--        <span class="searchTag d-inline-block">{if $region['id'] eq 1}АР Крым{else}{$region['name']} область{/if} <a href="/traders{if $rubric neq null}/{$rubric['translit']}{/if}{if $currency neq null}?currency={$currency['code']}{/if}"><i class="far fa-times close ml-2"></i></a></span>--}}
    {{--        {/if}--}}
    {{--        {if $currency neq null}--}}
    {{--        <span class="searchTag d-inline-block">{$currency['name']} <a href="/traders{if $region neq null}/region_{$region['translit']}{else}/region_ukraine{/if}{if $rubric neq null}/{$rubric['translit']}{else}/index{/if}"><i class="far fa-times close ml-2"></i></a></span>--}}
    {{--        {/if}--}}
    {{--    </div>--}}
    {{--    {/if}--}}
    <div class="new_container container mt-3 traders_dev">
        @foreach($traders as $trader)
            {{--           {{dump($trader)}}--}}
            <div class="new_traders ">
                <div class="traders__item-wrap">
                    {{--<a href="/kompanii/comp-{$trader['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}" class="traders__item {if $trader['top'] eq '1'} yellow{/if}">--}}
                    <a href="{{ route('company.company_id', $trader->id) }}" class="traders__item {if $trader['top'] eq '1'} yellow{/if}">
                        <div class="traders__item__header">
                            <img class="traders__item__image" src="/{{--{{$trader->logo_filename}}--}}" alt="">
                        </div>
                        {{-- /kompanii/comp-{{ $trader->id }} --}}
                        <div class="traders__item__content">
                            <div href="#" class="traders__item__content-title">
                                {{ $trader->title }}
                                {{--                            {$trader['title']|unescape|truncate:25:"...":true}--}}
                            </div>
                            <div class="traders__item__content-description">
                                {{--{foreach from=$trader['prices'] item=price}--}}

                                @foreach($prices as $price)
                                    <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">
{{--                                    {{$price["traders_products_lang"]["name"]}}--}}
                                    <!--{$price['title']|unescape|truncate:14:"...":true}-->
                                </span>
                                        <span class="right">
{{--                  <span class="traders__item__content-p-price {if $price['change_price'] neq ''}price-{$price['change_price']}" data-toggle="tooltip" data-placement="right" title="Старая цена: {if $price['currency'] eq 1}${/if}{$price['old_price']}"{else}"{/if}>{if $price['currency'] eq 1}$&nbsp;{/if}{$price['price']}</span>--}}
                                            {{ $price['costval'] }}
                                <span class="traders__item__content-p-icon">

                    {{--{if $price['change_price'] neq ''}<img src="/app/assets/img/price-{$price['change_price']}.svg">{/if}
                  {if $price['change_price'] eq ''}<img src="/app/assets/img/price-not-changed.svg">{/if}--}}

                                </span>
                                </span>
                                    </p>
                                @endforeach
                            </div>
                            <div class="traders__item__content-date">
                                <!--               <span class="traders__item__content-date-more">+ ещё {$trader['review']['count']}</span> -->
                                {{--                            {if $smarty.now|date_format:"%Y-%m-%d" eq $trader['date']}<span class="green">сегодня</span>{elseif "-1 day"|date_format:"%Y-%m-%d" eq $trader['date']}<span style="color:#FF7404;">вчера</span>{else}<span style="color:#001430;">{$trader['date2']}</span>{/if}--}}
                            </div>
                        </div>
                    </a>
                </div>
            </div>
    @endforeach
    <!--     {if $rubric eq null}{foreach $banners['traders'] as $banner}
          <div class="row mb-0 mb-sm-4 pb-sm-2 mx-0 justify-content-center align-items-center">

            {$banner}

          </div>
              {/foreach}

        {/if} -->
    </div>

    <!-- <div class="container mt-3 traders">
      {foreach from=$traders item=group}
      {if $group@index eq 3}{foreach $banners['traders'] as $banner}
      <div class="row mb-0 mb-sm-4 pb-sm-2 mx-0 justify-content-center align-items-center">

        {$banner}

      </div>
     {/foreach}
      {/if}

    <div class="row mb-0 mb-sm-4 pb-sm-2">


          {if $region neq null or $rubric neq null or $currency neq null}
    <div class="d-sm-none container pt-2 pt-sm-4">
      {if $rubric neq null}
      <span class="searchTag d-inline-block">{$rubric['name']} <a href="/traders{if $region neq null}/region_{$region['translit']}{else}/region_ukraine{/if}{if $currency neq null}?currency={$currency['code']}{/if}"><i class="far fa-times close ml-2"></i></a></span>
      {/if}
      {if $region neq null}
      <span class="searchTag d-inline-block">{if $region['id'] eq 1}АР Крым{else}{$region['name']} область{/if} <a href="/traders{if $rubric neq null}/{$rubric['translit']}{/if}{if $currency neq null}?currency={$currency['code']}{/if}"><i class="far fa-times close ml-2"></i></a></span>
      {/if}
      {if $currency neq null}
      <span class="searchTag d-inline-block">{$currency['name']} <a href="/traders{if $region neq null}/region_{$region['translit']}{else}/region_ukraine{/if}{if $rubric neq null}/{$rubric['translit']}{else}/index{/if}"><i class="far fa-times close ml-2"></i></a></span>
      {/if}
    </div>
    {/if}

        {foreach name=group from=$group item=trader}
        <div class="col-6 col-sm-2 px-3 position-relative">
          <div class="row newTraderItem mx-0{if $trader['top'] eq '1'} top{/if}">
            <div class="col-12 d-flex px-0 justify-content-center wrap-logo">
              <a href="/kompanii/comp-{$trader['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}">
                <img class="logo" src="/{$trader['logo']}">
              </a>
            </div>
            <div class="col-12 px-0 date d-flex justify-content-center align-items-center">
              <span class="lh-1">{if $smarty.now|date_format:"%Y-%m-%d" eq $trader['date']}<span class="today">сегодня</span>{else}{$trader['date2']}{/if}</span>
            </div>
            <div class="col-12 px-0 d-flex justify-content-center align-items-center px-2 py-2 title text-center">
              <a href="/kompanii/comp-{$trader['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}">{$trader['title']}</a>
            </div>
            <div class="col-12 prices px-2">
              {foreach from=$trader['prices'] item=price}
              <div class="d-flex justify-content-between align-items-center ar">
                <span class="rubric">{$price['title']|unescape|truncate:18:"..":true}</span>
                <div class="d-flex align-items-center lh-1 priceItem">
                  <span class="amount text-right {if $price['change_price'] neq ''}price-{$price['change_price']}" data-toggle="tooltip" data-placement="right" title="Старая цена: {if $price['currency'] eq 1}${/if}{$price['old_price']}"{else}"{/if}>{if $price['currency'] eq 1}${/if}{$price['price']}</span>
                  &nbsp;{if $price['change_price'] neq ''}<img src="/app/assets/img/price-{$price['change_price']}.svg">{/if}
                </div>
              </div>
              {/foreach}
            </div>
            <div class="col-12 px-0 d-flex justify-content-between align-items-center px-2 pb-2 rating text-center">
              <a class="stars" href="/kompanii/comp-{$trader['id']}-reviews">
                {for $i=1 to 5}
                {if $i <= $trader['review']['rating']}
                <i class="fas fa-star"></i>
                {else}
                <i class="far fa-star"></i>
                {/if}
                {/for}
              </a>
              <a href="/kompanii/comp-{$trader['id']}-reviews"><span>{$trader['review']['count']}</span></a>
            </div>
          </div>
        </div>
        {/foreach}
      </div>
      {foreachelse}
      {/foreach}
     {if $rubric eq null}{foreach $banners['traders'] as $banner}
      <div class="row mb-0 mb-sm-4 pb-sm-2 mx-0 justify-content-center align-items-center">

        {$banner}

      </div>
          {/foreach}

    {/if}
    </div>
    <div class="container mt-3">
      {if $traders neq null}
      <div class="text-center">
        {foreach $banners['bottom'] as $banner}
        {$banner}
        {/foreach}
      </div>
      {/if}
      <div class="container mt-4 mb-5">

      </div>
    </div>
      {/if} -->
    {else}
    <div class="container mt-0 mt-sm-3">
        <div class="row pt-sm-3">
            <div class="position-relative w-100">
                <div class="col-12 col-md-9 float-md-right text-center text-md-right">
                    <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end">
                        <i class="far fa-plus mr-2"></i>
                        <span class="pl-1 pr-1">Разместить компанию</span>
                    </a>
                </div>
                {if $tableList neq null}
                <div class="col-12 col-md-3 float-left mt-4 mt-md-0 d-block">
                    <h2 class="d-inline-block text-uppercase">Все трейдеры</h2>
                </div>
                {/if}
            </div>
        </div>
    </div>
    {if $rubric eq null}
    <div class="container empty my-5">
        <div class="content-block p-5 position-relative text-center">
            <img class="get-rubric-img" src="/app/assets/img/get-rubric.png" style="transform: translateX(-50px);">
            <span class="get-rubric">Для сравнения цен выберите продукцию в рубрикаторе</span>
        </div>
    </div>
    {else}
    {if $tableList neq null}
    <div class="container pb-5 pb-sm-4 pt-4 mb-4 scroll-x">
        <table class="sortTable sortable{if !$detect->isMobile()} dTable{/if}" cellspacing="0">
            {if !$detect->isMobile()}
            <thead>
            <tr>
                <th>Компании</th>
                {if $currency eq null}
                <th class="sth">UAH <i class="fas fa-sort" style="font-size: 12px;"></i></th>
                <th class="sth">USD <i class="fas fa-sort" style="font-size: 12px;"></i></th>
                {else}
                {if $currency['code'] eq 'uah'}
                <th class="sth">UAH <i class="fas fa-sort" style="font-size: 12px;"></i></th>
                {else}
                <th class="sth">USD <i class="fas fa-sort" style="font-size: 12px;"></i></th>
                {/if}
                {/if}
                <th class="sth">Дата <i class="sort-date-icon fas fa-sort" style="font-size: 12px;"></i></th>
                <th>Место закупки</th>
            </tr>
            </thead>
            {/if}
            <tbody>
            {if !$detect->isMobile()}
            {foreach from=$tableList item=row}
            <tr{if $row['top'] eq 1 } class="vip"{/if} {if $row['top'] eq 2 } class="vip" style="background-color: #FFDA56;"{/if}>
            <td {if $row['top'] eq 2 } style="overflow: hidden; background-color: #FFDA56;" {/if}>
            {if $row['top'] eq 2 } <div class="ribbonTrade">ТОП</div> {/if}
            <a class="d-flex align-items-center" href="/kompanii/comp-{$row['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}">
                <img class="logo mr-3" src="/{$row['logo']}">
                <span class="title">{$row['title']}</span>
                {if $row['top'] eq 2}<span class="status">ТОП</span>{/if}
            </a>
            </td>
            {if $currency eq null}
            <td class="uah" {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
            {if $row['prices']['uah']['price'] neq null}
            <div class="d-flex align-items-center justify-content-center">
                <span class="price">{$row['prices']['uah']['price']}</span>{if $row['prices']['uah']['change_price'] neq ''}<span class="price{if $row['prices']['uah']['change_price'] neq ''}-{$row['prices']['uah']['change_price']}{/if}">  &nbsp;<img src="/app/assets/img/price-{$row['prices']['uah']['change_price']}.svg"> <span>{$row['prices']['uah']['price_diff']|ltrim:'-'}</span>{/if}</span>
            </div>
            {if isset($row['prices']['uah']['comment']) && $row['prices']['uah']['comment'] neq null}
            <span class="d-block text-muted extra-small">{$row['prices']['uah']['comment']}</span>
            {/if}
            {/if}
            </td>
            <td class="usd" {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
            {if $row['prices']['usd']['price'] neq null}
            <div class="d-flex align-items-center justify-content-center">
                <span class="price">{$row['prices']['usd']['price']}</span>{if $row['prices']['usd']['change_price'] neq ''}<span class="price{if $row['prices']['usd']['change_price'] neq ''}-{$row['prices']['usd']['change_price']}{/if}"> &nbsp;<img src="/app/assets/img/price-{$row['prices']['usd']['change_price']}.svg"> <span>{$row['prices']['usd']['price_diff']|ltrim:'-'}</span>{/if}</span>
            </div>
            {if isset($row['prices']['usd']['comment']) && $row['prices']['usd']['comment'] neq null}
            <span class="d-block text-muted extra-small">{$row['prices']['usd']['comment']}</span>
            {/if}
            {/if}
            </td>
            {else}
            {if $currency['code'] eq 'uah'}
            <td class="uah" {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
            {if $row['prices']['uah']['price'] neq null}
            <div class="d-flex align-items-center justify-content-center">
                <span class="price">{$row['prices']['uah']['price']}</span>{if $row['prices']['uah']['change_price'] neq ''}<span class="price{if $row['prices']['uah']['change_price'] neq ''}-{$row['prices']['uah']['change_price']}{/if}"> &nbsp;<img src="/app/assets/img/price-{$row['prices']['uah']['change_price']}.svg"> <span>{$row['prices']['uah']['price_diff']|ltrim:'-'}</span>{/if}</span>
            </div>
            {if isset($row['prices']['uah']['comment']) && $row['prices']['uah']['comment'] neq null}
            <span class="d-block text-muted extra-small">{$row['prices']['uah']['comment']}</span>
            {/if}
            {/if}
            </td>
            {else}
            <td class="usd" {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
            {if $row['prices']['usd']['price'] neq null}
            <div class="d-flex align-items-center justify-content-center">
                <span class="price">{$row['prices']['usd']['price']}</span>{if $row['prices']['usd']['change_price'] neq ''}<span class="price{if $row['prices']['usd']['change_price'] neq ''}-{$row['prices']['usd']['change_price']}{/if}"> &nbsp;<img src="/app/assets/img/price-{$row['prices']['usd']['change_price']}.svg"> <span>{$row['prices']['usd']['price_diff']|ltrim:'-'}</span>{/if}</span>
            </div>
            {if isset($row['prices']['usd']['comment']) && $row['prices']['usd']['comment'] neq null}
            <span class="d-block text-muted extra-small">{$row['prices']['usd']['comment']}</span>
            {/if}
            {/if}
            </td>
            {/if}
            {/if}
            <td {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if} data-sorttable-customkey="{$row['date']|date_format:"%Y%m%d"}"><span data-date="{$row['date']|date_format:"%Y%m%d"}">{if $smarty.now|date_format:"%Y-%m-%d" eq $row['date']}<span class="today">{$row['date2']}</span>{else}{$row['date2']}{/if}</span></td>
            <td {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
            <span class="location">{$row['location']}</span>
            {if $row['place'] neq null}
            <br>
            <span class="place">{$row['place']}</span>
            {/if}
            </td>
            </tr {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
            {/foreach}
            {else}
            {foreach from=$tableList item=row}
            <tr{if $row['top'] eq 1} class="vip"{/if} {if $row['top'] eq 2 } class="vip"{/if}>
            <td  {if $row['top'] eq 2 } style="background-color: #FFDA56;" {/if}>
            <div class="d-flex align-items-center price-div" {if $row['top'] eq 2 } style="overflow: hidden; background-color: #FFDA56" {/if}   >
            {if $row['top'] eq 2 } <div class="ribbonTrade">ТОП</div> {/if}
            <!--  {if $row['top'] neq 2 } <div class="ribbonTrade"> &ensp;&ensp;&ensp;</div> {/if} -->

            <img class="logo mr-3" src="/{$row['logo']}" data-toggle="tooltip" data-placement="top" title="{$row['title']}">
            <a class="flex-1" href="/kompanii/comp-{$row['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}">
                {foreach from=$row['prices'] item=price}
                <span class="m-price">{if $price['currency'] eq 0}UAH{else}USD{/if}: <span class="price{if $price['change_price'] neq ''}-{$price['change_price']}{/if}">{$price['price']} {if $price['change_price'] neq ''} &nbsp;<i class="fas fa-chevron-{$price['change_price']}"></i> {$price['price_diff']|ltrim:'-'}{/if}</span></span>
                {/foreach}
            </a>
    </div>
    </td>
    </tr>
    <tr class="t2 {if $row['top'] eq 1} vip{/if}">
        <td style="border-bottom: 1px solid #295ca1;">
            <div class="d-flex align-items-center justify-content-center">
                <span data-toggle="tooltip" data-placement="top" class="d-block">{$row['date']|date_format:"%d.%m.%Y"}</span>
                <a href="/kompanii/comp-{$row['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}" class="d-block flex-1">
                    <span class="location d-block">{$row['location']}</span>
                    {if $row['place'] neq null}
                    <span class="place d-block">{$row['place']}</span>
                    {/if}
                </a>
            </div>
        </td>
    </tr>
    {/foreach}
    {/if}
    </tbody>
    </table>
    <div class="text-center mt-5">
        {foreach $banners['bottom'] as $banner}
        {$banner}
        {/foreach}
    </div>
    </div>
    <div class="container mt-4 mb-5">
        {if $rubric neq null && $text neq '' && $pageNumber eq 1}
        {$text}
        {/if}
    </div>
    {/if}
    {/if}
    {/if}
    {if ($traders eq null && $viewmod eq 'nontbl') or ($viewmod eq null && $tableList eq null && $rubric neq null)}
    <div class="container empty my-5">
        <div class="content-block p-5">
            <span class="title">По Вашему запросу {if $section eq 'buy'}закупок{else}продаж{/if} не найдено</span>
            <a class="sub d-flex align-items-center" href="{if !$user->auth}/buyerreg{else}/u/notify{/if}"><img src="/app/assets/img/envelope.png" class="mr-3 mb-3 mt-3 mr-3"> Подписаться на изменение Цен Трейдеров</a>
            <span class="all">Предлагаем Вам ознакомиться с общим <a href="/traders{if $section neq 'buy'}_sell{/if}">списком трейдеров</a></span>
        </div>
    </div>
    {/if}



    @include('layout.layout-filter', ['section' => $section, 'rubricsGroup' => $rubric, 'onlyPorts' => $onlyPorts])
    <div class="new_container container mt-3 traders_dev">
        <div class="new_traders ">
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6546" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(251, 218, 89);">
                        <img class="traders__item__image" src="/pics/c/4NJgh3XkncYD.jpg" alt="" data-primary-color="251,218,89">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            KADORR Agro Group
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6620">6 650</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6100">6 150</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7650">7 750</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-1105" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(51, 106, 77);">
                        <img class="traders__item__image" src="/pics/comp/1105_96102.jpg" alt="" data-primary-color="51,106,77">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Рамбурс
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">6 100</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя без ГМО</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">$&nbsp;436</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 100</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-4081" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/4081_95081.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Escador
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечник</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 13900">14 050</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6950">7 000</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7000">7 050</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 2 отзыва</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6293" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/1RnbTG5LXytX.jpeg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Пирятинский деликатес
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7720">7 760</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 14100">14 450</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7720">7 760</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 1 отзыв</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-1968" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/HrkW02a6FUzF.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            АДМ ЮКРЕЙН
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6995">7 225</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">6 700</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6965">7 195</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="new_traders ">
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-5559" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/1ahFioC9j0C7.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Sintez Group &amp; Co
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 13600">14 100</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Горох желтый</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">6 500</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Фасоль</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">22 000</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 1 отзыв</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6302" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/9AkVDpHt9eUN.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            G.R. Agro
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 500</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечник</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">14 000</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 500</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-1167" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/1167_80788.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            SUNGRAIN
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6000">6 030</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 5800">5 850</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7310">7 370</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 1 отзыв</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6606" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/vGw5Emv1Gqli.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Петрус-Кондитер
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 400</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 400</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">7 300</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-1115" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/1115_84695.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            НОВААГРО
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Гречиха</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 18500">18 510</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">6 700</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">6 850</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="new_traders ">
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-5529" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(38, 179, 67);">
                        <img class="traders__item__image" src="/pics/comp/5529_86405.jpg" alt="" data-primary-color="38,179,67">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Лихачевский Элеватор
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-down" data-toggle="tooltip" data-placement="right" title="Старая цена: 6700">7</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-down.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-down" data-toggle="tooltip" data-placement="right" title="Старая цена: 6700">7</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-down.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6600">6 900</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span class="green">сегодня</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6532" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(0, 197, 97);">
                        <img class="traders__item__image" src="/pics/c/Wf6mpqolc469.png" alt="" data-primary-color="0,197,97">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            ВІН-ЕКСПО
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Просо желтое</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 5600">5 700</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Масло соевое</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">$&nbsp;780</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница спе..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">14 000</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-4593" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/4593_70690.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Прометей
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7130">7 220</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7500">7 600</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7470">7 570</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6354" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/tsdL477Tawjd.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            ТК Восток
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6325">6 350</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7350">7 400</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 7425">7 500</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-3193" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/3193_80434.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            АГРОЛІДЕР ЄВРОПА
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Горчица бела.</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-down" data-toggle="tooltip" data-placement="right" title="Старая цена: 17000">16 800</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-down.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Нут</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 10000">13 000</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Чечевица</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 12000">14 500</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="new_traders ">
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-820" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/820_83166.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            Smart Trade
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Отруби пшен..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">4 850</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Отруби пшен..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">4 650</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Шрот подсол..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: $228">$&nbsp;230</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 3 отзыва</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-6596" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/c/XKwBhLDbeJoY.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            AGROLA
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Отруби пшен..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">5 150</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Отруби пшен..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price ">4 850</span>

                  <span class="traders__item__content-p-icon">
                                      <img src="/app/assets/img/price-not-changed.svg">                  </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
            <div class="traders__item-wrap">

                <a href="/kompanii/comp-5608" class="traders__item  yellow">
                    <div class="traders__item__header" style="background-color: rgb(255, 255, 255);">
                        <img class="traders__item__image" src="/pics/comp/5608_54749.jpg" alt="" data-primary-color="255,255,255">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title">
                            KERNEL
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечни..</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 13000">13 300</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6650">6 700</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right">
                  <span class="traders__item__content-p-price price-up" data-toggle="tooltip" data-placement="right" title="Старая цена: 6400">6 450</span>

                  <span class="traders__item__content-p-icon">
                    <img src="/app/assets/img/price-up.svg">                                    </span>
                </span>
                            </p>
                        </div>
                        <div class="traders__item__content-date">
                            <!--               <span class="traders__item__content-date-more">+ ещё 0 отзывов</span> -->
                            <span style="color:#FF7404;">вчера</span>            </div>
                    </div>
                </a>
            </div>
        </div>
        <!--
     -->
        <div class="new_traders "> <div class="traders__item-wrap">
                <a href="/kompanii/comp-4964" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/4964_89599.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            GrainCorp Ukraine
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:$ &nbsp;218">$&nbsp;220</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:7270">7 370</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">5 Октября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-2136" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/2136_85457.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            BG Trade SA
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза фураж…</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:$ &nbsp;184">$&nbsp;188</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:$ &nbsp;218">$&nbsp;219</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">2 Октября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-6566" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/aUIPbx18fK57.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Caravan Agro
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Лён</span>
                                <span class="right"><span class="traders__item__content-p-price">13 000</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Сорго красное</span>
                                <span class="right"><span class="traders__item__content-p-price">4 900</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">1 Октября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-812" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/812_47610.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            VIRTUS
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price">7 000</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price">6 900</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">29 Сентября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-959" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/959_83651.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            AnkoAgroTrade
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Рапс с ГМО</span>
                                <span class="right"><span class="traders__item__content-p-price">$&nbsp;395</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Сорго белое</span>
                                <span class="right"><span class="traders__item__content-p-price">$&nbsp;160</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">22 Сентября</span>
                        </div>
                    </div></a></div></div><div class="new_traders "> <div class="traders__item-wrap">
                <a href="/kompanii/comp-3720" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/3720_73076.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Global Commodities Swiss …
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Рапс с ГМО</span>
                                <span class="right"><span class="traders__item__content-p-price">$&nbsp;380</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя без ГМО</span>
                                <span class="right"><span class="traders__item__content-p-price">$&nbsp;408</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">21 Сентября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-6477" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/5Fvt5CVFpaEb.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Region Grain Company AG
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right"><span class="traders__item__content-p-price">5 350</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 4 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price">7 100</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">17 Сентября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-2045" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/2045_15757.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            LNZ GROUP
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя</span>
                                <span class="right"><span class="traders__item__content-p-price">12 250</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечник</span>
                                <span class="right"><span class="traders__item__content-p-price">12 300</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">11 Сентября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-1490" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/1490_34978.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Ukrlandfarming
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя</span>
                                <span class="right"><span class="traders__item__content-p-price">11 900</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right"><span class="traders__item__content-p-price">5 400</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">10 Сентября</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-1020" class="traders__item  yellow">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/1020_85359.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Klam Oliya
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Шрот подсолн. …</span>
                                <span class="right"><span class="traders__item__content-p-price">$&nbsp;207</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Ячмень</span>
                                <span class="right"><span class="traders__item__content-p-price">$&nbsp;155</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span style="color:#001430;">27 Июля</span>
                        </div>
                    </div></a></div></div><div class="new_traders "> <div class="traders__item-wrap">
                <a href="/kompanii/comp-1119" class="traders__item ">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/BnLleiOjlrCn.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            CORETRADE
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price">7 870</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:6600">6 700</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span class="green">сегодня</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-1943" class="traders__item ">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/1943_73237.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            ТАС АГРО
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя</span>
                                <span class="right"><span class="traders__item__content-p-price">14 000</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:6300">6 400</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span class="green">сегодня</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-3962" class="traders__item ">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/comp/3962_63556.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            СІЕЙТІ
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Соя без ГМО</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:14300">14 400</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Кукуруза</span>
                                <span class="right"><span class="traders__item__content-p-price">5 800</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-not-changed.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span class="green">сегодня</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-5962" class="traders__item ">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/p7DUB6TKdciH.JPG" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Orex Distribution
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:6850">7 000</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 2 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:6900">7 050</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span class="green">сегодня</span>
                        </div>
                    </div></a></div> <div class="traders__item-wrap">
                <a href="/kompanii/comp-6441" class="traders__item ">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="/pics/c/p7KovMuRtsOV.jpg" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div href="#" class="traders__item__content-title title">
                            Південна Зернова Столиця
                        </div>
                        <div class="traders__item__content-description">
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Пшеница 3 кл.</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:7520">7 720</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">Подсолнечник</span>
                                <span class="right"><span class="traders__item__content-p-price" price-up"="" data-toggle="tooltip" data-placement="right" title="Старая цена:13500">13 900</span><span class="traders__item__content-p-icon"><img src="/app/assets/img/price-up.svg"> </span></span>
                            </p>
                        </div><div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё </span>
                            <span class="green">сегодня</span>
                        </div>
                    </div></a></div></div></div>
@endsection
