<div class="container company mb-5">
  {if $trader eq 1}
  <h2 class="d-inline-block mt-4">Цены трейдера</h2>
  {if $updateDate neq null}
  <div class="d-inline-block content-block px-3 py-1 mt-3 mb-4 mb-sm-0 ml-0 ml-sm-3">
    <b>Обновлено {$updateDate}</b>
  </div>
  {/if}
  {if $portsPrices neq null}
  <div class="ports-tabs table-tabs mt-3">
    {if $issetUahPort neq null}<a href="#" currency="0" class="active">{if $type eq 0}Закупки{else}Продажи{/if} UAH</a>{/if}
    {if $issetUsdPort neq null}<a href="#" currency="1"{if $issetUahPort eq null} class="active"{/if}>{if $type eq 0}Закупки{else}Продажи{/if} USD</a>{/if}
  </div>
  <div class="content-block prices-block{if $regionsPrices neq null} mb-4{/if}">
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
  {if $regionsPrices neq null}
  <div class="regions-tabs table-tabs">
    {if $issetUahRegion neq null}<a href="#" currency="0" class="active">{if $type eq 0}Закупки{else}Продажи{/if} UAH</a>{/if}
    {if $issetUsdRegion neq null}<a href="#" currency="1"{if $issetUahRegion eq null} class="active"{/if}>{if $type eq 0}Закупки{else}Продажи{/if} USD</a>{/if}
  </div>
  <style>
    .tableScroll {
      background: red
    }
    .tableScroll::-webkit-scrollbar  {
      background: transparent;
    }
    .tableScroll.orange::-webkit-scrollbar-thumb {
      background-color: #ffa800;
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
    }
  </style>
  <div class="content-block prices-block" style="position: relative">
    <div class="" style="position: relative; z-index: 1;overflow: hidden;">
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
        <td place="{$place['id']}" rubric="{$rubric['id']}" currency="0" class="currency-0 {if $issetUahRegion eq null} d-none{/if}">
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
    <div class="" style="position: absolute; z-index: 2;width: 100%; left: 0; top: 0; right: 0;">
      <div style="position: absolute; left: 240px; width: calc(100% - 240px); overflow-x: scroll;" class="tableScroll">
      <table class="sortTable orange price-table regions-table" style="left: -240px; width: calc(100% + 240px)">
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
        <td place="{$place['id']}" rubric="{$rubric['id']}" currency="0" class="currency-0 {if $issetUahRegion eq null} d-none{/if}">
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
  </div>
  {/if}
  {/if}
  <h2 class="mt-4">О компании</h2>
  <div class="about mt-3">{$company['content']}</div>
  {if ($company['trader_price_avail'] == 1 or $company['trader_price_sell_avail'] == 1) and $traderContacts neq null}
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
  {if $adverts|@count > 0}
  <h2 class="mt-4">Объявления</h2>
  {foreach $adverts as $adv}
  <div class="row content-block postItem mx-0 mt-3 mt-sm-4 pt-2 pb-2 py-sm-3 px-1{if $adv['colored'] eq 1} colored{/if}">
    {if $adv['top'] neq null}
    <div class="ribbon">В ТОПе</div>
    {/if}
    <div class="row mx-0 w-100">
      <div class="col-auto pr-0 pl-1 pl-sm-3">
        <img src="{if $adv['image'] neq null}/{$adv['image']}{else}/app/assets/img/no-image.png{/if}" class="postImg" alt="{$adv['title']}">
        <span class="badge t{$adv['type_id']} align-self-center d-inline-block d-sm-none">{$adv['type']|substr:0:2}</span> 
      </div>
      <div class="col pr-0 pl-2 pl-sm-3">
        <div class="row m-0">
          <div class="col-12 col-sm-8 d-flex pl-1 pl-sm-0">
            <h1 class="title ml-0 d-none d-sm-block">
              <span class="badge t{$adv['type_id']} d-none d-sm-inline-block">{$adv['type']}</span>
              <a href="/board/post-{$adv['id']}.html">{$adv['title']}</a></span>
            </h1>
            <span class="title align-self-center ml-0 ml-sm-2 d-block d-sm-none">
              <a href="/board/post-{$adv['id']}.html">{$adv['title']|truncate:40:"..":false}</a>
            </span>
          </div>
          <div class="d-none d-sm-flex col-sm-4 pr-sm-3 justify-content-end">
            <span class="price float-right">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}0 грн.{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
          </div>
        </div>
        <div class="row mx-0 w-100 m-bottom">
          <div class="col p-0">
            <div class="row mx-0 postRowHeight mt-1">
              <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-flex d-sm-none">
                <span class="price align-self-center">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}0 грн.{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
              </div>
              <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                <span class="rubric align-self-center">{$adv['rubric']}</span>
              </div>
              <div class="d-none d-sm-flex col-sm-3 pr-sm-3 justify-content-end">
                <span class="unit float-right">{if $adv['amount'] neq null and $adv['izm'] neq null}{$adv['amount']} {$adv['izm']}{/if}</span>
              </div>
            </div>
            <div class="row mx-0 mt-0 d-sm-none">
              <div class="col-4 col-sm-9 pl-1 pr-0">
                <span class="unit align-self-center">{if $adv['amount'] neq null and $adv['izm'] neq null}{$adv['amount']} {$adv['izm']}{/if}</span>
              </div>
              <div class="col-8 justify-content-end">
                <span class="date float-right">{if ($smarty.now|date_format:"%Y/%m/%d") eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']}{/if}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="row mx-0 w-100 d-bottom">
          <div class="col p-0">
            <div class="row mx-0">
              <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                <span class="author align-self-center">{$adv['author']}</span>
              </div>
            </div>
            <div class="row ml-0 mr-3 mt-1">
              <div class="col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                <span class="region align-self-center">{$adv['region']} обл.{if $adv['city'] neq null}, {$adv['city']}{/if}</span>
              </div>
              <div class="d-none d-sm-flex col-sm-3 justify-content-end">
                <span class="date float-right">{if ($smarty.now|date_format:"%Y/%m/%d") eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']}{/if}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {/foreach}
  {/if}
  {if $company['news']|@count > 0}
  <div class="row mt-4 mb-2">
    <div class="position-relative w-100">
      <div class="col-12 col-md-4 float-left mt-4 mt-md-0 d-flex d-sm-block">
        <h2 class="d-inline-block">Новости</h2>
        <div class="d-none d-sm-block">
          <a href="/kompanii/comp-{$company['id']}-news.html" class="small show-all mb-1 d-none d-sm-inline-block">Смотреть все</a>
        </div>
        <a href="/kompanii/comp-{$company['id']}-news.html" class="show-all float-right d-block d-sm-none align-self-center ml-auto ml-sm-2-relative">Все &nbsp;<i class="fas fa-angle-right position-absolute"></i></a>
      </div>
    </div>
  </div>
  <div class="row">
  {foreach from=$company['news'] item=newsItem key=key}
  {if $key > 2}
    {break}
  {/if}
    <div class="col-12 col-sm-4">
      <div class="content-block newsItem d-flex align-items-center py-2 px-1">
        <img src="{if $newsItem['pic_src'] != ''}/{$newsItem['pic_src']}{else}/app/assets/img/no-image.png{/if}">
        <a class="ml-2" href="/kompanii/comp-{$company['id']}-news-{$newsItem['id']}.html">{$newsItem['title']}</a>
      </div>
    </div>
  {/foreach}
  </div>
  {/if}
  {if $company['vacancy']|@count > 0}
  <div class="row mt-4 mb-2">
    <div class="position-relative w-100">
      <div class="col-12 col-md-4 float-left mt-4 mt-md-0 d-flex d-sm-block">
        <h2 class="d-inline-block">Вакансии</h2>
        <div class="d-none d-sm-block">
          <a href="/kompanii/comp-{$company['id']}-vacancy.html" class="small show-all mb-1 d-none d-sm-inline-block">Смотреть все</a>
        </div>
        <a href="/kompanii/comp-{$company['id']}-vacancy.html" class="show-all float-right d-block d-sm-none align-self-center ml-auto ml-sm-2-relative">Все &nbsp;<i class="fas fa-angle-right position-absolute"></i></a>
      </div>
    </div>
  </div>
  <div class="row">
  {foreach from=$company['vacancy'] item=vacancyItem key=key}
  {if $key > 2}
    {break}
  {/if}
    <div class="col-12 col-sm-4">
      <div class="content-block vacancyItem d-flex align-items-center py-3 px-3">
        <a class="ml-2" href="/kompanii/comp-{$company['id']}-vacancy-{$vacancyItem['id']}.html">{$vacancyItem['title']}</a>
      </div>
    </div>
  {/foreach}
  </div>
  {/if}
  {if $company['reviews']|@count > 0}
  <div class="row mt-4 mb-2">
    <div class="position-relative w-100">
      <div class="col-12 col-md-4 float-left mt-4 mt-md-0 d-flex d-sm-block">
        <h2 class="d-inline-block">Отзывы</h2>
        <div class="d-none d-sm-block">
          <a href="/kompanii/comp-{$company['id']}-reviews.html" class="small show-all mb-1 d-none d-sm-inline-block">Смотреть все</a>
        </div>
        <a href="/kompanii/comp-{$company['id']}-reviews.html" class="show-all float-right d-block d-sm-none align-self-center ml-auto ml-sm-2-relative">Все &nbsp;<i class="fas fa-angle-right position-absolute"></i></a>
      </div>
    </div>
  </div>
  <div class="row">
  {foreach from=$company['reviews'] item=review key=key}
  {if $key > 2}
    {break}
  {/if}
    <div class="col-12 col-sm-4">
      <div class="content-block review py-3 px-3">
        <div class="row m-0">
          <div class="col-auto pl-0">
            <img src="{if $review['logo_file'] eq null}/app/assets/img/noavatar.png{else}/{$review['logo_file']}{/if}" class="avatar">
          </div>
          <div class="col pl-0">
            <div class="row m-0 align-items-center">
              <div class="col p-0">
                {if $review['compId'] neq null}
                <a href="/kompanii/comp-{$review['compId']}.html" target="_blank">{$review['title']}</a>
                {else}
                <span class="author">{$review['author']}</span>
                {/if}
              </div>
            </div>
            <div class="row m-0 align-items-center lh-1">
              <div class="col p-0">
                <img src="/app/assets/img/rate-{$review['rate']}.png">
              </div>
            </div>
          </div>
        </div>
        {if $review['content'] neq null}
        <span class="review-title">Отзыв</span>
         <p class="review-content mb-0">{$review['content']}</p>
         {/if}
      </div>
    </div>
  {/foreach}
  </div>
  {/if}
</div>
<!--
<div class="row">
    <div class="position-relative w-100">
      <div class="col-12 col-md-8 float-md-right text-center text-md-right">
        <a href="/board/addpost.html" class="top-btn btn btn-warning align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">
          <i class="far fa-plus d-none d-md-inline-block"></i>
          <span class="pl-1 pr-1">Добавить объявление</span>
        </a>
      </div>
      <div class="col-12 col-md-4 float-left mt-4 mt-md-0 d-flex d-sm-block">
        <h2 class="d-inline-block text-uppercase">Новости</h2>
        <div class="d-none d-sm-block">
          <a href="/kompanii/comp-{$company['id']}-news.html" class="small show-all mb-1 d-none d-sm-inline-block">Смотреть все</a>
        </div>
        <a href="/kompanii/comp-{$company['id']}-news.html" class="show-all float-right d-block d-sm-none align-self-center ml-auto ml-sm-2-relative">Все &nbsp;<i class="fas fa-angle-right position-absolute"></i></a>
      </div>
    </div>
  </div>
  -->