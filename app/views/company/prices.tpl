<div class="submenu d-none d-sm-block text-center mt-4">
  {if $company['trader_price_avail'] neq 0 && $company['trader_price_visible'] neq 0 && $issetT1 neq null}
  <a href="/kompanii/comp-{$company['id']}-prices"{if $type eq 0} class="active"{/if}>Таблица закупок</a>
  {/if}
  {if $company['trader_price_sell_avail'] neq 0 && $company['trader_price_sell_visible'] neq 0 && $issetT2 neq null}
  <a href="/kompanii/comp-{$company['id']}-prices?type=1"{if $type eq 1} class="active"{/if}>Таблица продаж</a>
  {/if}
  <a href="/kompanii/comp-{$company['id']}-traderContacts">Контакты трейдера</a>
</div>
<div class="container mt-4">
  <h2 class="d-inline-block">Цены трейдера</h2>
  {if $updateDate neq null}
  <div class="d-inline-block content-block px-3 py-1 mt-3 mb-4 mb-sm-0 ml-0 ml-sm-3">
    <b>Обновлено {$updateDate}</b>
  </div>
  {/if}

  {if $issetUahPort neq null OR $issetUsdPort neq null}
  {if $portsPrices neq null}
  <div class="ports-tabs table-tabs mt-3">
  	{if $issetUahPort neq null}<a href="#" currency="0"{if $issetUahPort neq null} class="active"{/if}>{if $type eq 0}Закупки{else}Продажи{/if} UAH</a>{/if}
  	{if $issetUsdPort neq null}<a href="#" currency="1"{if $issetUahPort eq null} class="active"{/if}>{if $type eq 0}Закупки{else}Продажи{/if} USD</a>{/if}
  </div>
  <div class="content-block prices-block">
  	<div class="price-table-wrap ports scroll-x">
  	  <table class="sortTable price-table ports-table">
  	  <thead>
  	  <th>Порты/переходы</th>
  	  {foreach $traderPortsPricesRubrics as $rubric}
  	  <th rubric="{$rubric['id']}">{$rubric['name']}</th>
  	  {/foreach}
  	  </thead>
      <tbody>
  	  {foreach $portsPrices as $place}
      {if empty($place['rubrics'])}
        {continue}
      {/if}
  	  <tr>
  	  	<td place="{$place['id']}" class="{if empty($place['rubrics'])}py-3{else}py-1{/if}">
  	  	  <span class="place-title">{$place['portname']}</span>
  	  	  <span class="place-comment">{$place['place']}</span>
  	  	</td>
  	  	{if !empty($place['rubrics'])}
  	  	{foreach $place['rubrics'] as $rubric}
        <td place="{$place['id']}" rubric="{$rubric['id']}" currency="0" class="currency-0{if $issetUahPort eq null} d-none{/if}">
          {if $issetUahPort neq null}
          {if !empty($rubric['price'][0])}<div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">{$rubric['price'][0]['cost']}</span> {if $rubric['price'][0]['change_price'] neq ''}&nbsp;<img src="/app/assets/img/price-{$rubric['price'][0]['change_price']}.png">&nbsp; <span class="price{if $rubric['price'][0]['change_price'] neq ''}-{$rubric['price'][0]['change_price']}{/if}"> {$rubric['price'][0]['price_diff']|ltrim:'-'}</span>{/if}</div>{/if}
          {if !empty($rubric['price'][0]['comment']) }<span class="d-block lh-1 pb-1 extra-small">{$rubric['price'][0]['comment']}</span>{/if}
          {/if}
        </td>
  	  	<td place="{$place['id']}" rubric="{$rubric['id']}" currency="1" class="currency-1{if $issetUahPort eq null} d-table-cell{/if}">
  	  	  {if !empty($rubric['price'][1])}<div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">{$rubric['price'][1]['cost']}</span> {if $rubric['price'][1]['change_price'] neq ''}&nbsp;<img src="/app/assets/img/price-{$rubric['price'][1]['change_price']}.png">&nbsp; <span class="price{if $rubric['price'][1]['change_price'] neq ''}-{$rubric['price'][1]['change_price']}{/if}"> {$rubric['price'][1]['price_diff']|ltrim:'-'}</span>{/if}</div>{/if}
          {if !empty($rubric['price'][1]['comment']) }<span class="d-block lh-1 pb-1 extra-small">{$rubric['price'][1]['comment']}</span>{/if}
  	  	</td>
  	  	{/foreach}
  	  	{/if}
  	  </tr>
  	  {/foreach}
  	  </tbody>
      </table>
  	</div>
  </div>
  {/if}
{/if}
</div>
  {if $issetUahRegion neq null OR $issetUsdRegion neq null}
<div class="container mt-4 mb-5">
  {if $regionsPrices neq null}
  <div class="regions-tabs table-tabs">
    {if $issetUahRegion neq null}<a href="#" currency="0" class="active">{if $type eq 0}Закупки{else}Продажи{/if} UAH</a>{/if}
    {if $issetUsdRegion neq null}<a href="#" currency="1"{if $issetUahRegion eq null} class="active"{/if}>{if $type eq 0}Закупки{else}Продажи{/if} USD</a>{/if}
  </div>
  <div class="content-block prices-block">
  	<div class="price-table-wrap regions scroll-x">
  	  <table class="sortTable price-table regions-table">
  	  <thead>
  	  <th>Регионы/элеваторы</th>
  	  {foreach $traderRegionsPricesRubrics as $rubric}
  	  <th rubric="{$rubric['id']}">{$rubric['name']}</th>
  	  {/foreach}
  	  </thead>
      <tbody>
  	  {foreach $regionsPrices as $place}
  	  {if empty($place['rubrics'])}
  	    {continue}
  	  {/if}
  	  <tr>
  	  	<td place="{$place['id']}" class="{if empty($place['rubrics'])}py-3{else}py-1{/if}">
  	  	  <span class="place-title">{$place['region']}{if $place['region_id'] neq 1} обл.{/if}</span>
  	  	  <span class="place-comment">{$place['place']}</span>
  	  	</td>
  	  	{foreach $place['rubrics'] as $rubric}
        <td place="{$place['id']}" rubric="{$rubric['id']}" currency="0" class="currency-0{if $issetUahRegion eq null} d-none{/if}">
          {if $issetUahRegion neq null}
          {if !empty($rubric['price'][0])}<div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">{$rubric['price'][0]['cost']}</span> {if $rubric['price'][0]['change_price'] neq ''}&nbsp;<img src="/app/assets/img/price-{$rubric['price'][0]['change_price']}.png">&nbsp; <span class="price{if $rubric['price'][0]['change_price'] neq ''}-{$rubric['price'][0]['change_price']}{/if}"> {$rubric['price'][0]['price_diff']|ltrim:'-'}</span>{/if}</div>{/if}
          {if !empty($rubric['price'][0]['comment']) }<span class="d-block lh-1 pb-1 extra-small">{$rubric['price'][0]['comment']}</span>{/if}
          {/if}
        </td>
  	  	<td place="{$place['id']}" rubric="{$rubric['id']}" currency="1" class="currency-1 {if $issetUahRegion eq null} d-table-cell{/if}">
  	  	  {if !empty($rubric['price'][1])}<div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">{$rubric['price'][1]['cost']}</span> {if $rubric['price'][1]['change_price'] neq ''}&nbsp;<img src="/app/assets/img/price-{$rubric['price'][1]['change_price']}.png">&nbsp; <span class="price{if $rubric['price'][1]['change_price'] neq ''}-{$rubric['price'][1]['change_price']}{/if}"> {$rubric['price'][1]['price_diff']|ltrim:'-'}</span>{/if}</div>{/if}
          {if !empty($rubric['price'][1]['comment']) }<span class="d-block lh-1 pb-1 extra-small">{$rubric['price'][1]['comment']}</span>{/if}
  	  	</td>
  	  	{/foreach}
  	  </tr>
  	  {/foreach}
  	  </tbody>
      </table>
  	</div>
  </div>
  {/if}
</div>
{/if}