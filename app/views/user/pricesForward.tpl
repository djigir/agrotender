
{include file="user/pricesMenu.tpl" active="forwards"}

<div class="container mt-5 mb-0">
  <div class="d-none d-sm-block position-relative pb-5">
    <div class="d-block position-absolute w-100">
      <a href="/info/orfeta#p5" class="float-left d-inline-block"><u>Правила заполнения таблиц</u></a>
    {if $visible eq 1}
      <button class="btn setVisible red float-right" visible="0">Скрыть таблицу</button>
    {else}
      <button class="btn setVisible green float-right" visible="1">Показать таблицу</button>
    {/if}
    </div>
  </div>

{if $portsPrices neq null}
  <h3 class="mb-3">Долларовые цены USD</h3>
  <div class="ports-tabs table-tabs">
    {foreach $forwardMonths as $month name=f1}
    <a href="#" date="{$month.start}"{if $smarty.foreach.f1.first } class="active"{/if}>{$month.label}</a>
    {/foreach}
  </div>
  <div class="content-block prices-block mb-5">
    <div class="price-table-wrap ports mb-3 scroll-x">
      <table class="sortTable price-table ports-table" currency="1" place-type="ports">
      <thead>
      <th>Порты/переходы</th>
      {foreach $traderPortsPricesRubrics as $rubric}
      <th rubric="{$rubric['id']}" place_type="2">
        <div class="d-flex justify-content-center align-items-center">
          <span>{$rubric['name']}</span> <span class="lh-2"><i class="fas fa-times delete-rubric ml-2"></i></span> <span class="changeColPrices"><i class="fas fa-pencil ml-2"></i></span>
        </div>
      </th>
      {/foreach}
      </thead>
      <tbody>
      {foreach $portsPrices as $place}
      <tr>
        <td place="{$place['id']}"{if empty($place['rubrics'])} class="py-3"{/if}>
          <span class="place-title">{$place['portname']}</span>
          <span class="place-comment">{$place['place']}</span>
          <div class="place-manage">
            <i class="fas fa-pencil-alt edit-comment d-block"></i>
            <i class="fas fa-times delete-place d-block mt-1"></i>
          </div>
        </td>
        {if !empty($place['rubrics'])}
        {foreach $place['rubrics'] as $rubric}
        <td>
          {foreach $forwardMonths as $month name=f1}
          <div region="{$place['region_id']}" place="{$place['id']}" rubric="{$rubric['id']}" currency="1" date="{$month.start}" class="price-cell"{if !$smarty.foreach.f1.first } style="display:none;"{/if}>
            <input type="text" class="d-block price-cost" placeholder="-"{if !empty($rubric['price'][$month.start][1])}value="{$rubric['price'][$month.start][1]['cost']}"{/if}>
            <input type="text" class="d-block price-comment" placeholder="коммент"{if !empty($rubric['price'][$month.start][1])} value="{$rubric['price'][$month.start][1]['comment']}"{/if}>
          </div>
          {/foreach}
        </td>
        {/foreach}
        {/if}
      </tr>
      {/foreach}
      </tbody>
      </table>
    </div>
    <div class="row m-0 d-none d-sm-flex pt-2 pb-3">
      <div class="col-4 offset-8 d-flex align-items-center">
        <select class="form-control rubric">
          {foreach from=$availPortsRubrics item=rubrics key=groupName}
          <optgroup label="{$groupName}">
            {foreach $rubrics as $rubric}
            <option value="{$rubric['id']}">{$rubric['name']}</option>
            {/foreach}
          </optgroup>
          {/foreach}
        </select>
        <button class="btn prices-btn add-rubric ml-3" placeType="2">Добавить</button>
      </div>
    </div>
    <div class="row m-0 d-sm-none pt-2 pb-3">
      <div class="col text-center"><button class="btn prices-btn addPlaceOpen" data-toggle="modal" data-target="#addPortsModal" placeType="2">Добавить продукцию</button></div>
    </div>
  </div>

  <h3 class="mb-3 mt-3">Гривневые цены UAH</h3>
  <div class="regions-tabs table-tabs">
    {foreach $forwardMonths as $month name=f1}
    <a href="#" date="{$month.start}"{if $smarty.foreach.f1.first } class="active"{/if}>{$month.label}</a>
    {/foreach}
  </div>
  <div class="content-block prices-block mb-5">
    <div class="price-table-wrap regions mb-3 scroll-x">
      <table class="sortTable price-table regions-table" currency="0" place-type="ports">
      <thead>
      <th>Порты/переходы</th>
      {foreach $traderPortsPricesRubrics as $rubric}
      <th rubric="{$rubric['id']}" place_type="2">
        <div class="d-flex justify-content-center align-items-center">
          <span>{$rubric['name']}</span> <span class="lh-2"><i class="fas fa-times delete-rubric ml-2"></i></span> <span class="changeColPrices"><i class="fas fa-pencil ml-2"></i></span>
        </div>
      </th>
      {/foreach}
      </thead>
      <tbody>
      {foreach $portsPrices as $place}
      <tr>
        <td place="{$place['id']}"{if empty($place['rubrics'])} class="py-3"{/if}>
          <span class="place-title">{$place['portname']}</span>
          <span class="place-comment">{$place['place']}</span>
          <div class="place-manage">
            <i class="fas fa-pencil-alt edit-comment d-block"></i>
            <i class="fas fa-times delete-place d-block mt-1"></i>
          </div>
        </td>
        {if !empty($place['rubrics'])}
        {foreach $place['rubrics'] as $rubric}
        <td>
          {foreach $forwardMonths as $month name=f1}
          <div region="{$place['region_id']}" place="{$place['id']}" rubric="{$rubric['id']}" currency="0" date="{$month.start}" class="price-cell"{if !$smarty.foreach.f1.first } style="display:none;"{/if}>
            <input type="text" class="d-block price-cost" placeholder="-"{if !empty($rubric['price'][$month.start][0])}value="{$rubric['price'][$month.start][0]['cost']}"{/if}>
            <input type="text" class="d-block price-comment" placeholder="коммент"{if !empty($rubric['price'][$month.start][0])} value="{$rubric['price'][$month.start][0]['comment']}"{/if}>
          </div>
          {/foreach}
        </td>
        {/foreach}
        {/if}
      </tr>
      {/foreach}
      </tbody>
      </table>
    </div>
    <div class="row m-0 d-none d-sm-flex pt-2 pb-3">
      <div class="col-4 offset-8 d-flex align-items-center">
        <select class="form-control rubric">
          {foreach from=$availPortsRubrics item=rubrics key=groupName}
          <optgroup label="{$groupName}">
            {foreach $rubrics as $rubric}
            <option value="{$rubric['id']}">{$rubric['name']}</option>
            {/foreach}
          </optgroup>
          {/foreach}
        </select>
        <button class="btn prices-btn add-rubric ml-3" placeType="2">Добавить</button>
      </div>
    </div>
    <div class="row m-0 d-sm-none pt-2 pb-3">
      <div class="col text-center"><button class="btn prices-btn addPlaceOpen" data-toggle="modal" data-target="#addPortsModal" placeType="2">Добавить продукцию</button></div>
    </div>
  </div>
{else}
  <div class="alert alert-primary">
    Публикация цен в портах/переходах доступна только для трейдеров, подтвердивших документально возможность хранения и отгрузки продукции в интересующем порту. Достаточно сбросить скан-копии первой и последней страницы договора.<br>Заявки можно отправлять на <a href="mailto:trader@agrotender.com.ua">trader@agrotender.com.ua</a> или свяжитесь с Вашим персональным менеджером.
  </div>
{/if}

  <h3 class="mb-3">Долларовые цены USD</h3>
  <div class="ports-tabs table-tabs">
    {foreach $forwardMonths as $month name=f1}
    <a href="#" date="{$month.start}"{if $smarty.foreach.f1.first } class="active"{/if}>{$month.label}</a>
    {/foreach}
  </div>
  <div class="content-block prices-block">
    <div class="price-table-wrap ports mb-3 scroll-x">
      <table class="sortTable price-table ports-table" date="{$forwardMonths.0.start}" currency="1" place-type="regions">
      <thead>
      {if $regionsPrices }
      <th>Регионы/элеваторы</th>
      {/if}
      {foreach $traderRegionsPricesRubrics as $rubric}
      <th rubric="{$rubric['id']}" place_type="0">
        <div class="d-flex justify-content-center align-items-center">
          <span>{$rubric['name']}</span> <span class="lh-2"><i class="fas fa-times delete-rubric ml-2"></i></span> <span class="changeColPrices"><i class="fas fa-pencil ml-2"></i></span>
        </div>
      </th>
      {/foreach}
      </thead>
      <tbody>
      {foreach $regionsPrices as $place}
      <tr>
        <td place="{$place['id']}"{if empty($place['rubrics'])} class="py-2"{/if}>
          <span class="place-title">{$place['region']}{if $place['region_id'] neq 1} обл.{/if}</span>
          <span class="place-comment">{$place['place']}</span>
          <div class="place-manage">
            <i class="fas fa-pencil-alt edit-comment d-block"></i>
            <i class="fas fa-times delete-place d-block mt-1"></i>
          </div>
        </td>
        {if !empty($place['rubrics'])}
        {foreach $place['rubrics'] as $rubric}
        <td>
          {foreach $forwardMonths as $month name=f1}
          <div region="{$place['region_id']}" place="{$place['id']}" rubric="{$rubric['id']}" currency="1" date="{$month.start}" class="price-cell"{if !$smarty.foreach.f1.first } style="display:none;"{/if}>
            <input type="text" class="d-block price-cost" placeholder="-"{if !empty($rubric['price'][$month.start][1])}value="{$rubric['price'][$month.start][1]['cost']}"{/if}>
            <input type="text" class="d-block price-comment" placeholder="коммент"{if !empty($rubric['price'][$month.start][1])} value="{$rubric['price'][$month.start][1]['comment']}"{/if}>
          </div>
          {/foreach}
        </td>
        {/foreach}
        {/if}
      </tr>
      {/foreach}
      </tbody>
      </table>
    </div>
    <div class="row m-0 d-none d-sm-flex pt-2 pb-3">
      <div class="col-8 d-flex align-items-center">
        <select class="form-control region">
          {foreach $regions as $region}
          <option value="{$region['id']}">{$region['name']}{if $region['id'] neq 1} обл.{/if}</option>
          {/foreach}
        </select>
        <input type="text" class="form-control place ml-3" placeholder="Место приёмки">
        <button class="btn prices-btn add-place ml-3" placeType="0">Добавить</button>
      </div>
      <div class="col-4 d-flex align-items-center">
        <select class="form-control rubric">
          {foreach from=$availRegionsRubrics item=rubrics key=groupName}
          <optgroup label="{$groupName}">
            {foreach $rubrics as $rubric}
            <option value="{$rubric['id']}">{$rubric['name']}</option>
            {/foreach}
          </optgroup>
          {/foreach}
        </select>
        <button class="btn prices-btn add-rubric ml-3" placeType="0">Добавить</button>
      </div>
    </div>
    <div class="row m-0 d-sm-none pt-2 pb-3">
      <div class="col text-center"><button class="btn prices-btn addPlaceOpen" data-toggle="modal" data-target="#addRegionsModal" placeType="0">Добавить продукцию</button></div>
    </div>
  </div>

  <h3 class="mb-3 mt-3">Гривневые цены UAH</h3>
  <div class="regions-tabs table-tabs">
    {foreach $forwardMonths as $month name=f1}
    <a href="#" date="{$month.start}"{if $smarty.foreach.f1.first } class="active"{/if}>{$month.label}</a>
    {/foreach}
  </div>
  <div class="content-block prices-block">
    <div class="price-table-wrap regions mb-3 scroll-x">
      <table class="sortTable price-table regions-table" date="{$forwardMonths.0.start}" currency="0" place-type="regions">
      <thead>
      {if $regionsPrices }
      <th>Регионы/элеваторы</th>
      {/if}
      {foreach $traderRegionsPricesRubrics as $rubric}
      <th rubric="{$rubric['id']}" place_type="0">
        <div class="d-flex justify-content-center align-items-center">
          <span>{$rubric['name']}</span> <span class="lh-2"><i class="fas fa-times delete-rubric ml-2"></i></span> <span class="changeColPrices"><i class="fas fa-pencil ml-2"></i></span>
        </div>
      </th>
      {/foreach}
      </thead>
      <tbody>
      {foreach $regionsPrices as $place}
      <tr>
        <td place="{$place['id']}"{if empty($place['rubrics'])} class="py-2"{/if}>
          <span class="place-title">{$place['region']}{if $place['region_id'] neq 1} обл.{/if}</span>
          <span class="place-comment">{$place['place']}</span>
          <div class="place-manage">
            <i class="fas fa-pencil-alt edit-comment d-block"></i>
            <i class="fas fa-times delete-place d-block mt-1"></i>
          </div>
        </td>
        {if !empty($place['rubrics'])}
        {foreach $place['rubrics'] as $rubric}
        <td>
          {foreach $forwardMonths as $month name=f1}
          <div region="{$place['region_id']}" place="{$place['id']}" rubric="{$rubric['id']}" currency="0" date="{$month.start}" class="price-cell"{if !$smarty.foreach.f1.first } style="display:none;"{/if}>
            <input type="text" class="d-block price-cost" placeholder="-"{if !empty($rubric['price'][$month.start][0])}value="{$rubric['price'][$month.start][0]['cost']}"{/if}>
            <input type="text" class="d-block price-comment" placeholder="коммент"{if !empty($rubric['price'][$month.start][0])} value="{$rubric['price'][$month.start][0]['comment']}"{/if}>
          </div>
          {/foreach}
        </td>
        {/foreach}
        {/if}
      </tr>
      {/foreach}
      </tbody>
      </table>
    </div>
    <div class="row m-0 d-none d-sm-flex pt-2 pb-3">
      <div class="col-8 d-flex align-items-center">
        <select class="form-control region">
          {foreach $regions as $region}
          <option value="{$region['id']}">{$region['name']}{if $region['id'] neq 1} обл.{/if}</option>
          {/foreach}
        </select>
        <input type="text" class="form-control place ml-3" placeholder="Место приёмки">
        <button class="btn prices-btn add-place ml-3" placeType="0">Добавить</button>
      </div>
      <div class="col-4 d-flex align-items-center">
        <select class="form-control rubric">
          {foreach from=$availRegionsRubrics item=rubrics key=groupName}
          <optgroup label="{$groupName}">
            {foreach $rubrics as $rubric}
            <option value="{$rubric['id']}">{$rubric['name']}</option>
            {/foreach}
          </optgroup>
          {/foreach}
        </select>
        <button class="btn prices-btn add-rubric ml-3" placeType="0">Добавить</button>
      </div>
    </div>
    <div class="row m-0 d-sm-none pt-2 pb-3">
      <div class="col text-center"><button class="btn prices-btn addPlaceOpen" data-toggle="modal" data-target="#addRegionsModal" placeType="0">Добавить продукцию</button></div>
    </div>
  </div>
</div>
<div class="container mt-0 mb-5">
  <div class="mt-4 text-center pt-2">
    <a href="#" class="save-prices btn btn-bloc btn-primary px-5">Сохранить цены</a>
    <a href="/kompanii/comp-{$user->company['id']}-forwards" target="_blank" class="mt-3 d-block"><u>Посмотреть страницу с ценами</u></a>
  </div>
</div>

<div class="modal fade editModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <form class="form modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3">Изменить название места</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center mx-2">
          <div class="form-group my-3 col-12">
            <input type="text" class="form-control modal-comment text-center" placeholder="Название места">
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary px-5 update-place">Сохранить</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade addRegionsModal" id="addRegionsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <form class="form modal-content">
      <div class="modal-body">
        <h2 class="text-center">Добавить регион/элеватор</h2>
        <select class="form-control d-block region my-4">
          {foreach $regions as $region}
          <option value="{$region['id']}">{$region['name']}{if $region['id'] neq 1} обл.{/if}</option>
          {/foreach}
        </select>
        <input type="text" class="form-control d-block place my-4" placeholder="Место приёмки">
        <button class="btn btn-block prices-btn faded add-place my-4" placeType="0">Добавить</button>
        <h2 class="text-center">Добавить продукцию</h2>
        <select class="form-control rubric my-3">
          {foreach from=$availRegionsRubrics item=rubrics key=groupName}
          <optgroup label="{$groupName}">
            {foreach $rubrics as $rubric}
            <option value="{$rubric['id']}">{$rubric['name']}</option>
            {/foreach}
          </optgroup>
          {/foreach}
        </select>
        <button class="btn btn-block prices-btn add-rubric my-3" placeType="2">Добавить</button>
      </div>
      <div class="modal-footer justify-content-center">
        <a class="d-block" data-dismiss="modal" href="#">Отмена</a>
      </div>
    </form>
  </div>
</div>

<div id="PopoverContent" class="d-none">
  <div class="row mx-0 px-1 align-items-center">
    <div class="col-12 px-1 d-flex align-items-center">
      <input type="text" class="form-control" placeholder="Цена">
      <button class="btn prices-btn ml-2"> ОК </button>
    </div>
  </div>
</div>
