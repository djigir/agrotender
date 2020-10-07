<div class="container mt-3 ">



    {foreach from=$vipTraders item=group}
    {if $group@index eq 3}{foreach $banners['traders'] as $banner}
    <div class="row mb-0 mb-sm-4 pb-sm-2 mx-0 justify-content-center align-items-center">

        {$banner}

    </div>
    {/foreach}
    {/if}
    <!-- End Vip Traders Banner -->

    <!-- VIP Traders -->





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

    <div class="new_traders vip">
        {foreach name=group from=$group item=trader}
        <div class="traders__item-wrap">

            <a href="/kompanii/comp-{$trader['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}" class="traders__item {if $trader['top'] eq '1'} yellow{/if}">
                <div class="traders__item__header">
                    <span class="vip">ТОП</span>
                    <img class="traders__item__image" src="/{$trader['logo']}" alt="">
                </div>
                <div class="traders__item__content">
                    <div href="#" class="traders__item__content-title">
                        {$trader['title']|unescape|truncate:25:"...":true}
                    </div>
                    <div class="traders__item__content-description">
                        {foreach from=$trader['prices'] item=price}
                        <p class="traders__item__content-p">
                            <span class="traders__item__content-p-title">{$price['title']|unescape|truncate:14:"...":true}</span>
                            <span class="right">
                  <span class="traders__item__content-p-price {if $price['change_price'] neq ''}price-{$price['change_price']}" data-toggle="tooltip" data-placement="right" title="Старая цена: {if $price['currency'] eq 1}${/if}{$price['old_price']}"{else}"{/if}>{if $price['currency'] eq 1}$&nbsp;{/if}{$price['price']}</span>
                            <span class="traders__item__content-p-icon">
                     {if $price['change_price'] neq ''}<img src="/app/assets/img/price-{$price['change_price']}.svg">{/if}
                  {if $price['change_price'] eq ''}<img src="/app/assets/img/price-not-changed.svg">{/if}
                  </span>
                            </span>
                        </p>
                        {/foreach}
                    </div>
                    <div class="traders__item__content-date">
                        <!--               <span class="traders__item__content-date-more">+ ещё {$trader['review']['count']}</span> -->
                        {if $smarty.now|date_format:"%Y-%m-%d" eq $trader['date']}<span class="green">сегодня</span>{elseif "-1 day"|date_format:"%Y-%m-%d" eq $trader['date']}<span style="color:#FF7404;">вчера</span>{else}<span style="color:#001430;">{$trader['date2']}</span>{/if}
                    </div>
                </div>
            </a>
        </div>
        {/foreach}
    </div>



    {foreachelse}
    {/foreach}

</div>
