<div class="filters-wrap">
  <div class="filters-inner">
    <div class="filters arrow-t">
      <div class="step-1 stp">
        <div class="position-relative scroll-wrap">
          <div class="mt-3">
            <span class="title ml-3 pt-3">Настройте фильтры:</span>
          </div>
          <a class="mt-3 p-4 content-block filter filter-type d-flex justify-content-between" href="#" type="{if $section neq 'buy'}_sell{/if}">
            <span>{if $section eq 'buy'}Закупки{else}Продажи{/if}</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
          <a class="mt-4 p-4 content-block filter filter-rubric d-flex justify-content-between" href="#" rubric="{if $rubric eq null}0{else}{$rubric['translit']}{/if}">
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
              <label class="btn btn-radio{if $currency eq null} active{/if}">
                <input type="radio" name="currency" value="" autocomplete="off"{if $currency eq null} checked{/if}> Любая
              </label>
              <label class="btn btn-radio{if $currency neq null && $currency['code'] eq 'uah'} active{/if}">
                <input type="radio" name="currency" value="uah" autocomplete="off"{if $currency neq null && $currency['code'] eq 'uah'} checked{/if}> Гривна
              </label>
              <label class="btn btn-radio{if $currency neq null && $currency['code'] eq 'usd'} active{/if}">
                <input type="radio" name="currency" value="usd" autocomplete="off"{if $currency neq null && $currency['code'] eq 'usd'} checked{/if}> Доллар
              </label>
            </div>
          </a>
          <a class="mt-4 p-4 content-block filter filter-viewmod d-flex justify-content-between" href="#">
            <span class="text-muted">Показать:</span>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
              <label class="btn btn-radio{if $viewmod eq null} active{/if}">
                <input type="radio" name="viewmod" value="" autocomplete="off"{if $viewmod eq null} checked{/if}> Списком
              </label>
              <label class="btn btn-radio{if $viewmod neq null} active{/if}">
                <input type="radio" name="viewmod" value="tbl" autocomplete="off"{if $viewmod neq null} checked{/if}> Таблицей
              </label>
            </div>
          </a>
          <div class="error-text mt-3 text-center">
            <span>Для сравнения цен выберите продукцию</span>
          </div>
        </div>
        <a class="show" href="#">
        Показать трейдеров
        </a>
      </div>
      <div class="step-2 stp h-100">
        <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
        <div class="scroll">
          <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders{if $section eq 'buy'}_sell{/if}">
            <span>{if $section eq 'buy'}Продажи{else}Закупки{/if}</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
          <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders_analitic">
            <span>Аналитика закупок</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
          <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders_analitic_sell">
            <span>Аналитика продаж</span>
            <span><i class="far fa-chevron-right"></i></span>
          </a>
        </div>
      </div>
      <div class="step-3 stp h-100">
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
      <div class="step-3-1 stp h-100">
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
      <div class="step-4 stp h-100">
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
    {if $rubric neq null && $region eq null && $port eq null}
    <li class="divider position-relative"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><a href="{if $section eq 'buy'}/traders{else}/traders_sell{/if}"><span>{if $section eq 'buy'}Цены трейдеров{else}Продажи трейдеров{/if}</span></a></li>
    <li class="divider position-relative"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><h1>{$h1}</h1></li>
    {elseif $rubric eq null && ($region neq null or $port neq null)}
    <li class="divider position-relative"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><a href="{if $section eq 'buy'}/traders{else}/traders_sell{/if}"><span>{if $section eq 'buy'}Цены трейдеров{else}Продажи трейдеров{/if}</span></a></li>
    <li class="divider position-relative"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><h1>{$h1}</h1></li>
    {elseif $rubric neq null && ($region neq null or $port neq null)}
    <li class="divider position-relative"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><a href="{if $section eq 'buy'}/traders{else}/traders_sell{/if}"><span>{if $section eq 'buy'}Цены трейдеров{else}Продажи трейдеров{/if}</span></a></li>
    {if $section eq 'buy'}
    <li class="divider position-relative"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><a href="/traders/{if $rubric neq null}{$rubric['translit']}{elseif $port neq null}tport_{$port['translit']}{/if}"><span>Цена {if $rubric neq null}{$rubric['name']}{elseif $port neq null}{$port['name']}{/if}</span></a></li>
    {/if}
    <li class="divider position-relative"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><h1>{$h1}</h1></li>
    {else}
    <li class="divider position-relative"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><h1>{if $h1 neq ''}{$h1}{else}Цены трейдеров в {if $region['id'] eq null}Украине{else}{$region['parental']} области{/if}{/if}</h1></li>
    {/if}
  </ul>
  <div class="content-block mt-3 py-3 px-3">
    <div class="btn-group position-relative w-100 ">
      <div class="col pl-1">
        <button class="btn typeInput text-center drop-btn">{if $section eq 'buy'}Закупки{else}Продажи{/if} <i class="ml-2 small far fa-chevron-down"></i></button>
      </div>
        <div class="dropdown-wrapper position-absolute typeDrop">
          <div class="dropdown">
            <div class="section text-left">
              <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
              <div class="row">
                <div class="col">
                  {if $section eq 'buy'}
                  <a class="inline-link" href="/traders_sell">
                    <span>Продажи</span>
                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                  </a>
                  {else}
                  <a class="inline-link" href="/traders">
                    <span>Закупки</span>
                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                  </a>
                  {/if}
                  <a class="inline-link" href="/traders_analitic">
                    <span>Аналитика закупок</span>
                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                  </a>
                  <a class="inline-link" href="/traders_analitic_sell">
                    <span>Аналитика продаж</span>
                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <div class="col px-1 mx-1">
        <button class="btn rubricInput text-center drop-btn{if $viewmod eq 'tbl' && $rubric eq null} blue-shadow{/if}">{if $rubric eq null}Выбрать продукцию{else}{$rubric['name']}{/if} <i class="ml-2 small far fa-chevron-down"></i></button>
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
                      {$g['name']}</span>
                      <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                  </a>
                  {/foreach}
                </div>
                {foreach from=$rubrics item=groups key=group_id}
                  {foreach from=$groups item=group}
                  <div class="col-auto rubricGroup pr-0 mr-3 group-{$group_id}">
                    {foreach from=$group item=r}
                      <a rid="{$r['id']}" class="rubricLink{if $r['name'] eq $rubric['name']} active{/if}" href="/traders{if $section eq 'sell'}_sell{/if}{if $region neq null}/region_{$region['translit']}{else if $port neq null or $onlyPorts eq 'yes'}/tport_{if $port neq null}{$port['translit']}{else}all{/if}{else}/region_ukraine{/if}/{$r['translit']}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'tbl'}{if $currency !== null}&{else}?{/if}viewmod=tbl{/if}">
                      <span>{$r['name']}</span>
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
            <a class="regionLink d-inline-block{if $port eq null && $onlyPorts eq null && $region eq null} text-muted disabled"{else}"{/if} href="/traders{if $section eq 'sell'}_sell{/if}/region_ukraine{if $rubric neq null}/{$rubric['translit']}{else}/index{/if}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'tbl'}{if $currency !== null}&{else}?{/if}viewmod=tbl{/if}">
            <span>Вся Украина</span>
          </a>
          <a class="regionLink d-inline-block{if $region['id'] eq 1} text-muted disabled"{else}"{/if} href="/traders{if $section eq 'sell'}_sell{/if}/region_crimea/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'tbl'}{if $currency !== null}&{else}?{/if}viewmod=tbl{/if}">
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
                <a class="regionLink{if $c['name'] eq $region['name']} active{/if}" href="/traders{if $section eq 'sell'}_sell{/if}/region_{$c['translit']}/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'tbl'}{if $currency !== null}&{else}?{/if}viewmod=tbl{/if}">
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
            <a class="regionLink d-inline-block{if $onlyPorts eq 'yes'} text-muted disabled"{else}"{/if} href="/traders{if $section eq 'sell'}_sell{/if}/tport_all/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $viewmod eq 'tbl'}?viewmod=tbl{/if}">
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
                <a class="regionLink{if $c['name'] eq $port['name']} active{/if}" href="/traders{if $section eq 'sell'}_sell{/if}/tport_{$c['translit']}/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $viewmod eq 'tbl'}?viewmod=tbl{/if}">
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
                  {if $currency neq null}
                  <a class="inline-link" href="{$smarty.server.SCRIPT_URI}{if $viewmod eq 'tbl'}?viewmod=tbl{/if}">
                    <span>Любая валюта</span>
                  </a>
                  {/if}
                  {foreach from=$currencies item=c key=key}
                  <a class="inline-link{if $currency['id'] === $c['id']} active{/if}" href="{$smarty.server.SCRIPT_URI}{if $viewmod eq 'tbl'}?viewmod=tbl&{else}?{/if}currency={$key}">
                    <span>{$c['name']}</span>
                  </a>
                  {/foreach}
                </div>
              </div>
            </div>
          </div>
        </div>
      <div class="d-flex align-items-center">
        <a class="text-center filter-icon mr-3{if $viewmod eq null} active{/if}" rel="nofollow" href="{$smarty.server.SCRIPT_URL}{if $currency !== null}?currency={$currency['code']}{/if}"><i class="fas fa-th-large"></i></a>
        <a class="text-center filter-icon{if $viewmod eq 'tbl'} active{/if}" rel="nofollow" href="{$smarty.server.SCRIPT_URL}{if $currency !== null}?currency={$currency['code']}&{else}?{/if}viewmod=tbl"><i class="fas fa-bars lh-1-1"></i></a>
      </div>
    </div>
  </div>
</div>
{if $region neq null or $rubric neq null or $currency neq null}
<div class="d-sm-none container pt-4">
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
{if $feed}
<div class="container mt-5">
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
                    &nbsp;<img src="/app/assets/img/price-up.png">
                    {/if}
                    {if $value eq '1'}
                    &nbsp;<img src="/app/assets/img/price-down.png">
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
{/if}
{if $viewmod neq 'tbl'}
  {if $traders neq null}
<div class="container mt-3 mt-sm-5">
  <div class="row mt-sm-0 pt-sm-0 mb-sm-4">
    <div class="position-relative w-100">
      <div class="col-12 col-md-8 float-md-right text-center text-md-right">
        <a href="#" class="offer-btn top-btn btn btn-primary align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">
          <i class="far fa-plus d-none d-md-inline-block"></i>
          <span class="pl-1 pr-1">Предложить трейдеру</span>
        </a>
        <a href="/add_buy_trader" class="top-btn btn btn-warning align-items-end d-none d-sm-inline-block">
          <span class="pl-1 pr-1">Стать трейдером</span>
        </a>
      </div>
      <div class="col-12 col-md-4 float-left mt-sm-0 d-flex justify-content-between d-sm-block">
        <div class="col-6 col-sm-12 pl-0">
          <h2 class="d-inline-block text-uppercase">{if $rubric eq null}Все трейдеры{else}{$rubric['name']}{/if}</h2>
          <div class="lh-1">
            <a href="/add_buy_trader" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
          </div>
        </div>
        <div class="col-6 pr-0 text-right d-sm-none">
          <a href="/add_buy_trader" class="btn btn-warning align-items-end add-trader">
          <span class="pl-1 pr-1">Стать трейдером</span>
        </a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container mt-3">
  {foreach from=$traders item=group}
  {if $group@index eq 3}
  <div class="row mb-0 mb-sm-4 pb-sm-2 mx-0 justify-content-center align-items-center">
    <a href="{if !$user->auth}/buyerreg{else}/u/notify{/if}" class="subscribe-block d-flex align-items-center justify-content-center">
      <img src="/app/assets/img/envelope-light.png" class="mr-3">
      <span class="lh-1">Подписаться на изменения цен{if $rubric neq null}: {$rubric['name']}{/if}</span>
    </a>
  </div>
  {/if}
  <div class="row mb-0 mb-sm-4 pb-sm-2">
    {foreach name=group from=$group item=trader}
    <div class="col-6 col-sm-2 px-3 position-relative">
      <div class="row newTraderItem mx-0{if $trader['top'] eq '1'} top{/if}">
        <div class="col-12 d-flex px-0 justify-content-center wrap-logo">
          <a href="/kompanii/comp-{$trader['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}">
            <img class="logo" src="/{$trader['logo']}">
          </a>
        </div>
        <div class="col-12 px-0 date d-flex justify-content-center align-items-center">
          <span class="lh-1">{if $smarty.now|date_format:"%Y/%m/%d" eq $trader['date']|date_format:"%Y/%m/%d"}<span class="today">сегодня</span>{else}{$trader['date2']}{/if}</span>
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
              &nbsp;{if $price['change_price'] neq ''}<img src="/app/assets/img/price-{$price['change_price']}.png">{else}<span class="no-change">-</span>{/if}
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
  {if $traders neq null}
  <div class="text-center">
    {foreach $banners['bottom'] as $banner}
    {$banner}
    {/foreach}
  </div>
  <div class="container mt-4 mb-5">
  {if $rubric neq null && $text neq '' && $page eq 1}
  {$text}
  {/if}
  </div>
  {/if}
</div>
  {/if}
{else}
<div class="container">
  <div class="row pt-sm-3">
    <div class="position-relative w-100">
      <div class="col-12 col-md-8 float-md-right text-center text-md-right">
        <a href="#" class="offer-btn top-btn btn btn-primary align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">
          <i class="far fa-plus d-none d-md-inline-block"></i>
          <span class="pl-1 pr-1">Предложить трейдеру</span>
        </a>
        <a href="/add_buy_trader" class="top-btn btn btn-warning align-items-end">
          <span class="pl-1 pr-1">Стать трейдером</span>
        </a>
      </div>
      {if $tableList neq null}
      <div class="col-12 col-md-4 float-left mt-4 mt-md-0 d-block">
        <h2 class="d-inline-block text-uppercase">Все трейдеры</h2>
      </div>
      {/if}
    </div>
  </div>
</div>
  {if $rubric eq null}
<div class="container empty my-5">
  <div class="content-block p-5 position-relative text-center">
    <img class="get-rubric-img" src="/app/assets/img/get-rubric.png">
    <span class="get-rubric">Для сравнения цен выберите продукцию в рубрикаторе</span>
  </div>
</div>
  {else}
    {if $tableList neq null}
<div class="container pb-5 pb-sm-4 pt-4 mb-4 scroll-x">
  <table class="sortTable sortable" cellspacing="0">
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
      <tr{if $row['top'] eq 1} class="vip"{/if}>
        <td>
          <a class="d-flex align-items-center" href="/kompanii/comp-{$row['id']}{if $section neq 'buy'}-prices?type=1{else}{/if}">
            <img class="logo mr-3" src="/{$row['logo']}">
            <span class="title">{$row['title']}</span>
            {if $row['top'] eq 1}<span class="status">ТОП</span>{/if}
          </a>
        </td>
        {if $currency eq null}
        <td class="uah">
          {if $row['prices']['uah']['price'] neq null}
          <div class="d-flex align-items-center justify-content-center">
            <span class="price">{$row['prices']['uah']['price']}</span>{if $row['prices']['uah']['change_price'] neq ''}<span class="price{if $row['prices']['uah']['change_price'] neq ''}-{$row['prices']['uah']['change_price']}{/if}">  &nbsp;<img src="/app/assets/img/price-{$row['prices']['uah']['change_price']}.png"> <span>{$row['prices']['uah']['price_diff']|ltrim:'-'}</span>{/if}</span>
          </div>
          {if isset($row['prices']['uah']['comment']) && $row['prices']['uah']['comment'] neq null}
          <span class="d-block text-muted extra-small">{$row['prices']['uah']['comment']}</span>
          {/if}
          {/if}
        </td>
        <td class="usd">
          {if $row['prices']['usd']['price'] neq null}
          <div class="d-flex align-items-center justify-content-center">
            <span class="price">{$row['prices']['usd']['price']}</span>{if $row['prices']['usd']['change_price'] neq ''}<span class="price{if $row['prices']['usd']['change_price'] neq ''}-{$row['prices']['usd']['change_price']}{/if}"> &nbsp;<img src="/app/assets/img/price-{$row['prices']['usd']['change_price']}.png"> <span>{$row['prices']['usd']['price_diff']|ltrim:'-'}</span>{/if}</span>
          </div>
          {if isset($row['prices']['usd']['comment']) && $row['prices']['usd']['comment'] neq null}
          <span class="d-block text-muted extra-small">{$row['prices']['usd']['comment']}</span>
          {/if}
          {/if}
        </td>
        {else}
          {if $currency['code'] eq 'uah'}
        <td class="uah">
          {if $row['prices']['uah']['price'] neq null}
          <div class="d-flex align-items-center justify-content-center">
            <span class="price">{$row['prices']['uah']['price']}</span>{if $row['prices']['uah']['change_price'] neq ''}<span class="price{if $row['prices']['uah']['change_price'] neq ''}-{$row['prices']['uah']['change_price']}{/if}"> &nbsp;<img src="/app/assets/img/price-{$row['prices']['uah']['change_price']}.png"> <span>{$row['prices']['uah']['price_diff']|ltrim:'-'}</span>{/if}</span>
          </div>
          {if isset($row['prices']['uah']['comment']) && $row['prices']['uah']['comment'] neq null}
          <span class="d-block text-muted extra-small">{$row['prices']['uah']['comment']}</span>
          {/if}
          {/if}
        </td>
          {else}
        <td class="usd">
          {if $row['prices']['usd']['price'] neq null}
          <div class="d-flex align-items-center justify-content-center">
            <span class="price">{$row['prices']['usd']['price']}</span>{if $row['prices']['usd']['change_price'] neq ''}<span class="price{if $row['prices']['usd']['change_price'] neq ''}-{$row['prices']['usd']['change_price']}{/if}"> &nbsp;<img src="/app/assets/img/price-{$row['prices']['usd']['change_price']}.png"> <span>{$row['prices']['usd']['price_diff']|ltrim:'-'}</span>{/if}</span>
          </div>
          {if isset($row['prices']['usd']['comment']) && $row['prices']['usd']['comment'] neq null}
          <span class="d-block text-muted extra-small">{$row['prices']['usd']['comment']}</span>
          {/if}
          {/if}
        </td>
          {/if}
        {/if}
        <td data-sorttable-customkey="{$row['date']|date_format:"%Y%m%d"}"><span data-date="{$row['date']|date_format:"%Y%m%d"}">{if $smarty.now|date_format:"%Y/%m/%d" eq $row['date']|date_format:"%Y/%m/%d"}<span class="today">{$row['date2']}</span>{else}{$row['date2']}{/if}</span></td>
        <td>
          <span class="location">{$row['location']}</span>
          {if $row['place'] neq null}
          <br>
          <span class="place">{$row['place']}</span>
          {/if}
        </td>
      </tr>
      {/foreach}
      {else}
      {foreach from=$tableList item=row}
      <tr{if $row['top'] eq 1} class="vip"{/if}>
        <td>
          <div class="d-flex align-items-center price-div">
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
            <span data-toggle="tooltip" data-placement="top" class="d-block">{$row['date']}</span>
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
    {/if}
  {/if}
{/if}
  {if ($traders eq null && $viewmod neq 'tbl') or ($viewmod eq 'tbl' && $tableList eq null && $rubric neq null)}
  <div class="container empty my-5">
  <div class="content-block p-5">
    <span class="title">По Вашему запросу {if $section eq 'buy'}закупок{else}продаж{/if} не найдено</span>
    <a class="sub d-flex align-items-center" href="{if !$user->auth}/buyerreg{else}/u/notify{/if}"><img src="/app/assets/img/envelope.png" class="mr-3 mb-3 mt-3"> Подписаться на изменение Цен Трейдеров</a>
    <span class="all">Предлагаем Вам ознакомиться с общим <a href="/traders{if $section neq 'buy'}_sell{/if}">списком трейдеров</a></span>
  </div>
</div>
  {/if}