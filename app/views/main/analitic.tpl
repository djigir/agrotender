<div class="filters-wrap">
  <div class="filters-inner">
<div class="filters arrow-t">
  <div class="step-1">
    <div class="mt-3">
      <span class="title ml-3 pt-3">Настройте фильтры:</span>
    </div>
    <a class="mt-3 p-4 content-block filter filter-type d-flex justify-content-between" href="#" type="{if $section neq 'buy'}_sell{/if}">
    <span>Аналитика {if $section eq 'buy'}закупок{else}продаж{/if}</span>
    <span><i class="far fa-chevron-right"></i></span>
    </a>
    <a class="mt-4 p-4 content-block filter filter-rubric d-flex justify-content-between" href="#" rubric="{if $rubric eq null}0{else}{$rubric['id']}{/if}">
    <span>{if $rubric eq null}Выбрать продукцию{else}{$rubric['name']}{/if}</span>
    <span><i class="far fa-chevron-right"></i></span>
    </a>
    <a class="mt-4 p-4 content-block filter filter-region d-flex justify-content-between" href="#" region="{if $region eq null}0{elseif $region['id'] eq 1}1{else}{$region['translit']}{/if}" port="{if $onlyPorts eq 'yes'}all{else}{if $port eq null}0{else}{$port['translit']}{/if}{/if}">
    <span>{if $onlyPorts eq 'yes'} Все порты {else} {if $region eq null} {if $port eq null} Вся Украина {else} {$port['name']} {/if} {elseif $region['id'] eq 1} АР Крым {else} {$region['name']} область {/if} {/if}</span>
    <span><i class="far fa-chevron-right"></i></span>
    </a>
    <a class="mt-4 p-4 content-block filter filter-currency d-flex justify-content-between" href="#">
      <span class="text-muted">Валюта:</span>
      <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-radio{if $currency neq null && $currency['code'] eq 'uah'} active{/if}">
        <input type="radio" name="currency" value="uah" autocomplete="off"{if $currency neq null && $currency['code'] eq 'uah'} checked{/if}> Гривна
        </label>
        <label class="btn btn-radio{if $currency neq null && $currency['code'] eq 'usd'} active{/if}">
        <input type="radio" name="currency" value="usd" autocomplete="off"{if $currency neq null && $currency['code'] eq 'usd'} checked{/if}> Доллар
        </label>
      </div>
    </a>
    <a class="show" href="#">
    Смотреть статистику
    </a>
  </div>
  <div class="step-2 h-100">
    <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="scroll">
      <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders_forwards">
        <span>Форварды</span>
        <span><i class="far fa-chevron-right"></i></span>
      </a>
      <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders_analitic{if $section eq 'buy'}_sell{/if}/region_ukraine">
        <span>Аналитика {if $section eq 'buy'}продаж{else}закупок{/if}</span>
        <span><i class="far fa-chevron-right"></i></span>
      </a>
      <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders/region_ukraine">
        <span>Закупки</span>
        <span><i class="far fa-chevron-right"></i></span>
      </a>
      <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders_sell">
        <span>Продажи</span>
        <span><i class="far fa-chevron-right"></i></span>
      </a>
    </div>
  </div>
  <div class="step-3 h-100">
    <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="scroll">
      {foreach from=$rubricsGroup item=g}
      <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="{$g['id']}">
      <span>{$g['name']}</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/foreach}
    </div>
  </div>
  <div class="step-3-1 h-100">
    <a class="back py-3 px-4 content-block d-block" step="3" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="scroll">
      <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" group="">
      <span></span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {foreach from=$rubrics item=groups key=group_id}
      {foreach from=$groups item=group}
      {foreach from=$group item=r}
      <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-{$group_id}" group="{$r['translit']}">
      <span>{$r['name']}</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/foreach}
      {/foreach}
      {/foreach}
    </div>
  </div>
  <div class="step-4 h-100">
    <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="scroll">
      <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between" region="0">
      <span style="font-weight: 600;">Вся Украина</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between" region="1">
      <span>АР Крым</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {foreach from=$regions_list item=col}
      {foreach from=$col item=region}
      <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between" region="{$region['translit']}">
      <span>{$region['name']} область</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/foreach}
      {/foreach}
      <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between" port="all">
      <span style="font-weight: 600;">Все порты</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {foreach from=$ports item=col}
      {foreach from=$col item=port}
      <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between" port="{$port['translit']}">
      <span>{$port['name']}</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/foreach}
      {/foreach}
    </div>
  </div>
</div>
  </div>
</div>
<div class="d-none d-sm-block container mt-3">
  <ul class="breadcrumbs small p-0">
    <li><a href="/"><span>Главная</span></a></li>
    {if $rubric neq null or $region neq null or $port neq null}
    <li class="divider position-relative"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><a href="/traders_analitic{if $section neq 'buy'}_sell{/if}"><span>Аналитика {if $section eq 'buy'}закупок{else}продаж{/if}</span></a></li>
    {/if}
    <li class="divider position-relative"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><h1>{$h1}</h1></li>
  </ul>
  <div class="content-block mt-3 py-3 px-3">
    <div class="btn-group position-relative w-100 ">
      <div class="col pl-1">
        <button class="btn typeInput text-center drop-btn">Аналитика {if $section eq 'buy'}закупок{else}продаж{/if} <i class="ml-2 small far fa-chevron-down"></i></button>
      </div>
      <div class="dropdown-wrapper position-absolute typeDrop">
        <div class="dropdown">
          <div class="section text-left">
            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
            <div class="row">
              <div class="col">
                {if $section eq 'buy'}
                <a class="inline-link" href="/traders_analitic_sell">
                <span>Аналитика продаж</span>
                <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                </a>
                {else}
                <a class="inline-link" href="/traders_analitic/region_ukraine">
                <span>Аналитика закупок</span>
                <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                </a>
                {/if}
                <a class="inline-link" href="/traders_forwards/region_ukraine">
                  <span>Форварды</span>
                  <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                </a>
                <a class="inline-link" href="/traders/region_ukraine">
                <span>Закупки</span>
                <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                </a>
                <a class="inline-link" href="/traders_sell">
                <span>Продажи</span>
                <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col px-1 mx-1">
        <button class="btn rubricInput text-center drop-btn">{if $rubric eq null}Выбрать продукцию{else}{$rubric['name']}{/if} <i class="ml-2 small far fa-chevron-down"></i></button>
      </div>
      <div class="dropdown-wrapper position-absolute rubricDrop">
        <div class="dropdown">
          <div class="section text-left">
            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
            <div class="row">
              <div class="col-auto">
                {foreach from=$rubricsGroup item=g}
                <a class="rubricLink getRubricGroup{if $rubric['group_id'] eq $g['id']} active{/if}" href="#" group="{$g['id']}">
                  <span>
                    {$g['name']}</sp an>
                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                </a>
                {/foreach}
              </div>
              {foreach from=$rubrics item=groups key=group_id}
              {foreach from=$groups item=group}
              <div class="col-auto rubricGroup pr-0 mr-3 group-{$group_id}">
              {foreach from=$group item=r}
              <a class="rubricLink{if $r['name'] eq $rubric['name']} active{/if}" href="/traders_analitic{if $section eq 'sell'}_sell{/if}{if $region neq null}/region_{$region['translit']}{else if $port neq null}/tport_{$port['translit']}{/if}/{$r['translit']}">
              <span{if $r['name']|count_characters:true gt 27} data-toggle="tooltip" data-placement="top" title="{$r['name']}"{/if}>{$r['name']|truncate:27:"..":true}</span>
              </a>
              {/foreach}
              </div>
              {/foreach}
              {/foreach}
            </div>
          </div>
        </div>
      </div>
      <div class="col px-2 mx-1">
        <button class="btn regionInput text-center drop-btn align-self-center">
        {if $onlyPorts eq 'yes'}
        Все порты
        {else}
        {if $region eq null}
        {if $port eq null}
        Вся Украина
        {else}
        {$port['name']}
        {/if}
        {elseif $region['id'] eq 1}
        АР Крым
        {else}
        {$region['name']} область
        {/if}
        {/if}
        <i class="ml-2 small far fa-chevron-down"></i>
        </button>
      </div>
      <div class="dropdown-wrapper position-absolute regionDrop">
        <div class="dropdown">
          <span class="d-block">
          <a class="regionLink d-inline-block{if $port eq null && $onlyPorts eq null && $region eq null} text-muted disabled"{else}"{/if} href="/traders_analitic{if $section eq 'sell'}_sell{/if}{if $rubric neq null}/{$rubric['translit']}{/if}">
          <span>Вся Украина</span>
          </a>
          <a class="regionLink d-inline-block{if $region['id'] eq 1} text-muted disabled"{else}"{/if} href="/traders_analitic{if $section eq 'sell'}_sell{/if}/region_crimea/{if $rubric neq null}{$rubric['translit']}{else}index{/if}">
          <span>АР Крым</span>
          </a>
          </span>
          <hr class="mt-1 mb-2">
          <div class="section text-left">
            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
            <div class="row">
              {foreach from=$regions_list item=col}
              <div class="col">
                {foreach from=$col item=c}
                <a class="regionLink{if $c['name'] eq $region['name']} active{/if}" href="/traders_analitic{if $section eq 'sell'}_sell{/if}/region_{$c['translit']}/{if $rubric neq null}{$rubric['translit']}{else}index{/if}">
                  <span>{$c['name']} область</span>
                  <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                </a>
                {/foreach}
              </div>
              {/foreach}
            </div>
          </div>
          {if $section eq 'buy'}
          <br>
          <span class="d-block">
          <a class="regionLink d-inline-block{if $onlyPorts eq 'yes'} text-muted disabled"{else}"{/if} href="/traders_analitic{if $section eq 'sell'}_sell{/if}/tport_all/{if $rubric neq null}{$rubric['translit']}{else}index{/if}">
          <span>Все порты</span>
          </a>
          </span>
          <hr class="mt-1 mb-2">
          <div class="section text-left">
            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
            <div class="row">
              {foreach from=$ports item=col}
              <div class="col">
                {foreach from=$col item=c}
                <a class="regionLink{if $c['name'] eq $port['name']} active{/if}" href="/traders_analitic{if $section eq 'sell'}_sell{/if}/tport_{$c['translit']}/{if $rubric neq null}{$rubric['translit']}{else}index{/if}">
                  <span>{$c['name']}</span>
                  <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                </a>
                {/foreach}
              </div>
              {/foreach}
            </div>
          </div>
          {/if}
        </div>
      </div>
      <div class="col px-2 mx-1">
        <button class="btn typeInput text-center drop-btn">{if $currency eq null}Валюта{else}{$currency['name']}{/if} <i class="ml-2 small far fa-chevron-down"></i></button>
      </div>
      <div class="dropdown-wrapper position-absolute currencyDrop">
        <div class="dropdown">
          <div class="section text-left">
            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
            <div class="row">
              <div class="col">
                {foreach from=$currencies item=c key=key}
                <a class="inline-link{if $currency['id'] === $c['id']} active{/if}" href="{$smarty.server.SCRIPT_URI}?currency={$key}">
                <span>{$c['name']}</span>
                <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                </a>
                {/foreach}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row mt-2 mt-sm-4 pt-sm-3">
    <div class="position-relative w-100">
      <div class="col-12 col-md-4 float-left mt-4 mt-md-0 d-block text-center text-sm-left">
        <h2 class="d-inline-block text-uppercase">Аналитика {if $section eq 'buy'}закупок{else}продаж{/if}</h2>
      </div>
    </div>
  </div>
</div>
<div class="container mt-4">
  <div class="tr-graph content-block p-3">
    <form method="GET" id="graphdtfrm" class="row mx-0 justify-content-center">
      {if $currency neq null}
      <input type="hidden" name="currency" value="{$currency['code']}">
      {/if}
      <div class="tr-graph-tab col-12 text-center justify-content-center col-sm-auto pl-0 pr-3 mb-2 mb-sm-0">
        <a href="#" data-fr="year" data-frid="month" start="{"-1 year -1 day"|date_format:"%d.%m.%Y"}" end="{"-1 day"|date_format:"%d.%m.%Y"}"><span>Год</span></a>
        <a href="#" data-fr="quart" data-frid="week" start="{"-3 month -1 day"|date_format:"%d.%m.%Y"}" end="{"-1 day"|date_format:"%d.%m.%Y"}"><span>Квартал</span></a>
        <a href="#" data-fr="month" data-frid="day" start="{"-1 month -1 day"|date_format:"%d.%m.%Y"}" end="{"-1 day"|date_format:"%d.%m.%Y"}"><span>Месяц</span></a>
        <a href="#" data-fr="week" data-frid="day" start="{"-1 week -1 day"|date_format:"%d.%m.%Y"}" end="{"-1 day"|date_format:"%d.%m.%Y"}"><span>Неделя</span></a>
      </div>
      <div class="tr-graph-dt col-12 text-center justify-content-center col-sm-auto px-3 my-2 my-sm-0">
        <span class="lh-1 mr-2">От: </span>
        <input type="text" id="from" class="input-date" name="start" value="{$start}">
        <span class="lh-1 mr-2 ml-3">До: </span>
        <input type="text" id="to" class="input-date" name="end" value="{$end}">
      </div>
      <div class="tr-graph-disc col-12 text-center justify-content-center col-sm-auto px-3 my-2 my-sm-0">
        <select name="step" id="dtstepval" class="select-step">
          <option value="month"{if $step eq 'month'} selected{/if}>Деталировка по: Месяцам</option>
          <option value="week"{if $step eq 'week'} selected{/if}>Деталировка по: Неделям</option>
          <option value="day"{if $step eq 'day'} selected{/if}>Деталировка по: Дням</option>
        </select>
      </div>
      <div class="col-12 text-center justify-content-center col-sm-auto pl-3 pr-0 my-2 my-sm-0">
        <button type="submit" class="btn btn-show">Показать</button>
      </div>
    </form>
  </div>
  {if $rubric eq null}
  <div class="empty content-block my-5 p-5 position-relative text-center">
    <span class="get-rubric">Для сравнения цен выберите продукцию в рубрикаторе</span>
  </div>
  {else}
  <div class="tr-graph-chart content-block mt-5 p-3 mb-4">
    <div id="trpricechart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  </div>
  {/if}
</div>
<div class="container d-flex justify-content-center mt-5 mb-5">
  {foreach $banners['bottom'] as $banner}
  {$banner}
  {/foreach}
</div>