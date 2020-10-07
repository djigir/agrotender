<div class="d-none d-sm-block container mt-5">
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
                                <a class="inline-link" href="/traders_forwards/region_ukraine">
                                    <span>Форварды</span>
                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                </a>
                                {if $section eq 'buy'}
                                <a class="inline-link" href="/traders_sell">
                                    <span>Продажи</span>
                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                </a>
                                {else}
                                <a class="inline-link" href="/traders/region_ukraine">
                                    <span>Закупки</span>
                                    <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                                </a>
                                {/if}
                                <a class="inline-link" href="/traders_analitic/region_ukraine">
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
                <button class="btn rubricInput text-center drop-btn{if $viewmod eq null && $rubric eq null} blue-shadow{/if}">{if $rubric eq null}Выбрать продукцию{else}{$rubric['name']}{/if} <i class="ml-2 small far fa-chevron-down"></i></button>
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
                                <a rid="{$r['id']}" class="rubricLink{if $r['name'] eq $rubric['name']} active{/if}" href="/traders{if $section eq 'sell'}_sell{/if}{if $region neq null}/region_{$region['translit']}{else if $port neq null or $onlyPorts eq 'yes'}/tport_{if $port neq null}{$port['translit']}{else}all{/if}{else}/region_ukraine{/if}/{$r['translit']}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'nontbl'}{if $currency !== null}&{else}?{/if}viewmod=nontbl{/if}">
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
            <a class="regionLink d-inline-block{if $port eq null && $onlyPorts eq null && $region eq null} text-muted disabled"{else}"{/if} href="/traders{if $section eq 'sell'}_sell{/if}/region_ukraine{if $rubric neq null}/{$rubric['translit']}{else}/index{/if}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'nontbl'}{if $currency !== null}&{else}?{/if}viewmod=nontbl{/if}">
            <span>Вся Украина</span>
              </a>
              <a class="regionLink d-inline-block{if $region['id'] eq 1} text-muted disabled"{else}"{/if} href="/traders{if $section eq 'sell'}_sell{/if}/region_crimea/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'nontbl'}{if $currency !== null}&{else}?{/if}viewmod=nontbl{/if}">
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
                                <a class="regionLink{if $c['name'] eq $region['name']} active{/if}" href="/traders{if $section eq 'sell'}_sell{/if}/region_{$c['translit']}/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $currency !== null}?currency={$currency['code']}{/if}{if $viewmod eq 'nontbl'}{if $currency !== null}&{else}?{/if}viewmod=nontbl{/if}">
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
            <a class="regionLink d-inline-block{if $onlyPorts eq 'yes'} text-muted disabled"{else}"{/if} href="/traders{if $section eq 'sell'}_sell{/if}/tport_all/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $viewmod eq 'nontbl'}?viewmod=nontbl{/if}">
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
                                <a class="regionLink{if $c['name'] eq $port['name']} active{/if}" href="/traders{if $section eq 'sell'}_sell{/if}/tport_{$c['translit']}/{if $rubric neq null}{$rubric['translit']}{else}index{/if}{if $viewmod eq 'nontbl'}?viewmod=nontbl{/if}">
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
                                <a class="inline-link" href="{$smarty.server.SCRIPT_URI}{if $viewmod eq 'nontbl'}?viewmod=nontbl{/if}">
                                    <span>Любая валюта</span>
                                </a>
                                {/if}
                                {foreach from=$currencies item=c key=key}
                                <a class="inline-link{if $currency['id'] === $c['id']} active{/if}" href="{$smarty.server.SCRIPT_URI}{if $viewmod eq 'nontbl'}?viewmod=nontbl&{else}?{/if}currency={$key}">
                                    <span>{$c['name']}</span>
                                </a>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {if $rubric neq null}
            <div class="d-flex align-items-center">
                <a class="text-center filter-icon mr-3{if $viewmod eq 'nontbl'} active{/if}" rel="nofollow" href="{$smarty.server.SCRIPT_URL}{if $currency !== null}?currency={$currency['code']}&{else}?{/if}viewmod=nontbl"><i class="fas fa-th-large"></i></a>
                <a class="text-center filter-icon{if $viewmod eq null} active{/if}" rel="nofollow" href="{$smarty.server.SCRIPT_URL}{if $currency !== null}?currency={$currency['code']}{/if}"><i class="fas fa-bars lh-1-1"></i></a>
            </div>
            {/if}
        </div>
    </div>
    <span class="popular" style="margin-top: 16px;display: block;">
  <span style="font-weight: 600; color: #707070;">
  <img src="/app/assets/img/speaker.svg" style="width: 24px; height: 24px"/>
   Популярные культуры: </span>
  <a href="/traders/region_ukraine/pshenica_2_kl" class="popular__block">Пшеница 2 кл.</a>
  <a href="/traders/region_ukraine/pshenica_3_kl" class="popular__block">Пшеница 3 кл.</a>
  <a href="/traders/region_ukraine/pshenica_4_kl" class="popular__block">Пшеница 4 кл.</a>
  <a href="/traders/region_ukraine/podsolnechnik" class="popular__block">Подсолнечник</a>
  <a href="/traders/region_ukraine/soya" class="popular__block">Соя</a>
  <a href="/traders/region_ukraine/yachmen" class="popular__block">Ячмень</a>
  </span>
</div>
