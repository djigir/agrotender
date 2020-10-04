
<div class="container mt-4">
  <h2 class="d-inline-block">Цены трейдера</h2>
  {if $updateDate neq null}
  <div class="d-inline-block content-block px-3 py-1 mt-3 mb-4 mb-sm-0 ml-0 ml-sm-3">
    <b>Обновлено {$updateDate}</b>
  </div>
  {/if}
</div>
<div class="container mt-4 mb-5">
  {if $portsPrices }
  <div class="ports-tabs table-tabs mt-3">
    {if $isAvailPortUah }<a href="#" currency="0"{if $isAvailPortUah } class="active"{/if}>Закупки UAH</a>{/if}
    {if $isAvailPortUsd }<a href="#" currency="1"{if !$isAvailPortUah } class="active"{/if}>Закупки USD</a>{/if}
  </div>
  <div class="content-block prices-block mb-3">
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
          <span class="popular">{$place['monthLabel']}</span>
        </td>
        {if !empty($place['rubrics'])}
        {foreach $place['rubrics'] as $rubric}
        <td place="{$place['id']}" rubric="{$rubric['id']}" currency="0" class="currency-0{if !$isAvailPortUah } d-none{/if}">
          {if $isAvailPortUah }
          {if !empty($rubric['price'][0])}<div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">{$rubric['price'][0]['cost']}</span> {if $rubric['price'][0]['change_price'] neq ''}&nbsp;<img src="/app/assets/img/price-{$rubric['price'][0]['change_price']}.png">&nbsp; <span class="price{if $rubric['price'][0]['change_price'] neq ''}-{$rubric['price'][0]['change_price']}{/if}"> {$rubric['price'][0]['price_diff']|ltrim:'-'}</span>{/if}</div>{/if}
          {if !empty($rubric['price'][0]['comment']) }<span class="d-block lh-1 pb-1 extra-small">{$rubric['price'][0]['comment']}</span>{/if}
          {/if}
        </td>
        <td place="{$place['id']}" rubric="{$rubric['id']}" currency="1" class="currency-1{if !$isAvailPortUah } d-table-cell{/if}">
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
{if $regionsPrices neq null}
  <div class="regions-tabs table-tabs">
    {if $isAvailRegionUah }<a href="#" currency="0" class="active">Закупки UAH</a>{/if}
    {if $isAvailRegionUsd }<a href="#" currency="1"{if !$isAvailRegionUah } class="active"{/if}>Закупки USD</a>{/if}
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
      <tr>
        <td place="{$place['id']}" class="{if empty($place['rubrics'])}py-3{else}py-1{/if}">
          <span class="place-title">{$place['region']}{if $place['region_id'] neq 1} обл.{/if}</span>
          <span class="place-comment">{$place['place']}</span>
          <span class="popular">{$place['monthLabel']}</span>
        </td>
        {foreach $place['rubrics'] as $rubric}
        <td place="{$place['id']}" rubric="{$rubric['id']}" currency="0" class="currency-0{if !$isAvailRegionUah } d-none{/if}">
          {if $isAvailRegionUah }
          {if !empty($rubric['price'][0])}<div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">{$rubric['price'][0]['cost']}</span></div>{/if}
          {if !empty($rubric['price'][0]['comment']) }<span class="d-block lh-1 pb-1 extra-small">{$rubric['price'][0]['comment']}</span>{/if}
          {/if}
        </td>
        <td place="{$place['id']}" rubric="{$rubric['id']}" currency="1" class="currency-1 {if !$isAvailRegionUah } d-table-cell{/if}">
          {if !empty($rubric['price'][1])}<div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">{$rubric['price'][1]['cost']}</span></div>{/if}
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

{if $traderContacts neq null}
  <h2 class="mt-4">Контакты трейдера</h2>
  {foreach $traderContacts as $place}
  <div class="content-block trader-contact py-3 px-4">
    <div class="place d-flex justify-content-between">
      <div class="title">
        <span>{$place['name']}</span>
      </div>
    </div>
    <div class="contacts mt-4">
      {foreach $place['contacts'] as $contact}
      <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
        {if $contact['dolg'] neq null or $contact['fio'] neq null}
        <div class="row m-0 px-3 px-sm-0">
          <div class="col p-0">
            {if $contact['dolg'] neq null}<b>{$contact['dolg']|strip_tags}:</b>{/if}{if $detect->isMobile()}<br>{/if} &nbsp;<span class="name">{if $contact['fio'] neq null}{$contact['fio']|strip_tags}{/if}</span>
          </div>
        </div>
        {/if}
        <div class="row m-0 justify-content-center">
          <div class="col-auto pr-2 text-center">
            <span class="phone">{if $contact['phone'] neq null}{$contact['phone']|strip_tags}{/if}</span>
          </div>
          {if $contact['email'] neq null}
          <div class="col-auto pl-2 text-center">
            <span class="email">{if $contact['email'] neq null}{$contact['email']|strip_tags}{/if}</span>
          </div>
          {/if}
        </div>
      </div>
      {/foreach}
    </div>
  </div>
  {/foreach}
{/if}
</div>
