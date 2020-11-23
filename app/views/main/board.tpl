<div class="filters-wrap">
  <div class="filters-inner">
<div class="filters arrow-t" id="filters">
  <div class="position-relative scroll-wrap">
    <div class="step-1 stp">
    <div class="mt-3">
      <span class="title ml-3 pt-3">Настройте фильтры:</span>
    </div>
    <div class="position-relative mt-3">
      <input type="text" class="pl-4 pr-5 py-4 content-block filter-search" placeholder="Я ищу.." value="{if $query neq null}{$query}{/if}">
      <i class="far fa-search searchFilterIcon"></i>
    </div>
    <a class="mt-5 p-4 content-block filter filter-type d-flex justify-content-between" href="#" type="{if $type eq null}0{else}{$type['translit']}{/if}">
    <span>{if $type eq null}Тип объявления{else}{$type['name']}{/if}</span>
    <span><i class="far fa-chevron-right"></i></span>
    </a>
    <a class="mt-4 p-4 content-block filter filter-rubric d-flex justify-content-between" href="#" rubric="{if $rubric eq null}0{else}{$rubric['id']}{/if}">
    <span>{if $rubric eq null}Выберите рубрику{else}{$rubric['title']}{/if}</span>
    <span><i class="far fa-chevron-right"></i></span>
    </a>
    <a class="mt-4 p-4 content-block filter filter-region d-flex justify-content-between" href="#" region="{if $region['id'] eq null}0{else}{$region['translit']}{/if} ">
    <span>{if $region['id'] eq null}Вся Украина{elseif $region['id'] eq 1}АР Крым{else}{$region['name']} область{/if}</span>
    <span><i class="far fa-chevron-right"></i></span>
    </a>
    <a class="showAdverts" href="#">Показать объявления</a>
  </div>
  <div class="step-2 stp">
    <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="mt-5">
      <a class="type px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" type="0">
      <span>Все объявления</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {foreach from=$types item=type}
      <a class="type px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" type="{$type['translit']}">
      <span>{$type['name']}</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/foreach}
    </div>
  </div>
  <div class="step-3 stp h-100">
    <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="scroll">
      {foreach from=$rubrics['groups'] item=group}
      <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="{$group['id']}">
      <span>{$group['title']}</span>
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
      {foreach from=$rubrics['subgroups'] item=subGroup}
      {if $subGroup['parent_id'] eq 0}
      <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-{$subGroup['menu_group_id']}" group="{$subGroup['id']}">
      <span>{$subGroup['title']}</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/if}
      {/foreach}
    </div>
  </div>
  <div class="step-3-2 stp h-100">
    <a class="back py-3 px-4 content-block d-block" step="3-1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="scroll">
      {foreach from=$rubrics['subgroups'] item=subGroup}
      {if $subGroup['parent_id'] neq 0}
      <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" group="{$subGroup['parent_id']}" rubricId="{$subGroup['id']}">
      <span>{$subGroup['title']}</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/if}
      {/foreach}
    </div>
  </div>
  <div class="step-4 stp h-100">
    <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="scroll">
      <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="0">
      <span>Вся Украина</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {foreach from=$regions_list item=col}
      {foreach from=$col item=region}
      <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="{$region['translit']}">
      <span>{$region['name']} область</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/foreach}
      {/foreach}
    </div>
  </div>
</div>
</div>
  </div>
</div>
<div class="d-none d-sm-block container mt-3">
  <ol class="breadcrumbs small p-0">
    <li><a href="/board">Объявления</a></li>
    {if $rubric neq null}
    <i class="fas fa-chevron-right extra-small"></i>
    <li><a href="{if $region eq null}/board{else}/board/region_{$region['translit']}/all{/if}">Объявления в {if $region eq null}Украине{else}{$region['parental']} области{/if}</a></li>
    <i class="fas fa-chevron-right extra-small"></i>
    <li><h1>{$h1}</h1></li>
    {else}
    {if $type eq null}
    <i class="fas fa-chevron-right extra-small"></i>
    <li><h1 style="font-size: 13px;color: #89a9b0;font-weight: normal;">Объявления в {if $region eq null}Украине{else}{$region['parental']} области{/if}</h1></li>
    {else}
    <i class="fas fa-chevron-right extra-small"></i>
    <li><a href="{if $region eq null}/board{else}/board/region_{$region['translit']}/all{/if}">Объявления в {if $region eq null}Украине{else}{$region['parental']} области{/if}</a></li>
    <i class="fas fa-chevron-right extra-small"></i>
    <li><h3 style="font-size: 13px;color: #89a9b0;font-weight: normal;">{$type['name']}</h3></li>
    {/if}
    {/if}
  </ol>
  <div class="content-block mt-3 py-3 px-4">
    <div class="form-row align-items-center position-relative">
      <div class="col-3 mr-2">
        <button class="btn typeInput text-center drop-btn">{if $type eq null}Все объявления{else}{$type['name']}{/if} <i class="ml-2 small far fa-chevron-down"></i></button>
      </div>
      <div class="dropdown-wrapper position-absolute typeDrop">
        <div class="dropdown">
          <div class="section text-left">
            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->
            <div class="row">
              <div class="col">
                {if $type neq null}
                <a class="typeLink" href="/board/{if $region neq null}region_{$region['translit']}/{/if}all{if $rubric neq null}_t{$rubric['id']}{/if}{if $pageNumber neq null}_p{$pageNumber}{/if}">
                <span>Все объявления</span>
                <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                </a>
                {/if}
                {foreach from=$types item=t}
                {if $t['id'] neq $type['id']}
                <a class="typeLink" href="/board/{if $region neq null}region_{$region['translit']}/{/if}{$t['translit']}{if $rubric neq null}_t{$rubric['id']}{/if}{if $pageNumber neq null}_p{$pageNumber}{/if}">
                <span>{$t['name']}</span>
                <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
                </a>
                {/if}
                {/foreach}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-3 mr-2">
        <button class="btn rubricInput text-center drop-btn">{if $rubric eq null}Все рубрики{else}{$rubric['title']}{/if} <i class="ml-2 small far fa-chevron-down"></i></button>
      </div>
      <div class="dropdown-wrapper position-absolute rubricDrop">
        <div class="dropdown">
          <div class="row">
            <div class="col-auto">
              {foreach from=$rubrics['groups'] key=gkey item=group}
              <a class="rcount rubricLink getRubricGroup{if $group['id'] eq $rubric['menu_group_id']} active{/if}" href="#" group="{$group['id']}">
              <span class="rtitle">{$group['title']}</span>
              <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>
              </a>
              {/foreach}
            </div>
          </div>
        </div>
      </div>
      <div class="dropdown-wrapper position-absolute rubricGroup">
        <div class="dropdown">
          <div class="dropHead">
            <a class="rubricLink backToRubric py-0" href="">
            <i class="far fa-chevron-left mr-2"></i> <span>Назад</span>
            </a>
            <a class="rubricLink selectRubric py-0 float-right" href="#">
            <span>Искать по всей рубрике</span>
            </a>
            <hr class="mt-2 mb-2">
          </div>
          <div class="rsection section d-flex flex-wrap justify-content-center">
            {foreach from=$rubrics['subgroups'] item=subGroup}
            <a class="rcount flex-fill{if $subGroup['parent_id'] eq 0} rparent{/if} {if $subGroup['parent_id'] eq 0}group-{$subGroup['menu_group_id']}{else}subgroup-{$subGroup['parent_id']}{/if} btn section{if $subGroup['id'] eq $rubric['id'] or $subGroup['id'] eq $rubric['parent_id']} active{/if}" rid="{$subGroup['id']} " href="/board/{if $region neq null}region_{$region['translit']}/{/if}{if $type eq null}all{else}{$type['translit']}{/if}_t{$subGroup['id']}{if $pageNumber neq null}_p{$pageNumber}{/if}"{if $subGroup['parent_id'] eq 0} subgroup="{$subGroup['id']}"{else} group="{$subGroup['parent_id']}"{/if}>
            <span class="float-left left mr-2 rubricGroupIcon"><i class="far fa-chevron-right"></i></span>
            <span class="rtitle">{$subGroup['title']} <div class="lds-dual-ring"></div></span>
            <!--<span{if $subGroup['title']|count_characters:true gt 27} data-toggle="tooltip" data-placement="top" title="{$subGroup['title']}"{/if}>{$subGroup['title']|truncate:27:"..":true}</span>-->
            </a>
            {/foreach}
          </div>
        </div>
      </div>
      <div class="col-3 mr-2">
        <button class="btn regionInput text-center drop-btn">{if $region eq null}Вся Украина{elseif $region['id'] eq 1}АР Крым{else}{$region['name']} область{/if}<i class="ml-2 small far fa-chevron-down"></i></button>
      </div>
      <div class="dropdown-wrapper position-absolute regionDrop">
        <div class="dropdown">
          <span class="d-block">
          <a class="regionLink d-inline-block{if $region eq null} text-muted disabled"{else}"{/if} href="/board/{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}{if $pageNumber neq null}_p{$pageNumber}{/if}">
          <span>Вся Украина</span>
          </a>
          <a class="regionLink d-inline-block{if $region['id'] eq 1} text-muted disabled"{else}"{/if} href="/board/region_crimea/{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}{if $pageNumber neq null}_p{$pageNumber}{/if}">
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
                {if $c['id'] eq 1} {continue} {/if}
                <a class="regionLink{if $c['name'] eq $region['name']} active{/if}" href="/board/region_{$c['translit']}/{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}{if $pageNumber neq null}_p{$pageNumber}{/if}">
                  <span>{$c['name']|truncate:22:"..":false} область</span>
                  <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->
                </a>
                {/foreach}
              </div>
              {/foreach}
            </div>
          </div>
        </div>
      </div>
      <form class="searchForm col">
        <div class="row">
          <div class="col searchDiv pr-0" data-tip="Введите поисковой запрос">
            <input maxlength="32" type="text" name="text" class="searchInput" placeholder="Я ищу.."{if $query neq null} value="{$query}"{/if}>
          </div>
          <div class="col-auto">
            <i class="far fa-search searchIcon mt-2 ml-2"></i>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
{if $region neq null or $rubric neq null or $type neq null}
<div class="d-sm-none container pt-4">
  {if $rubric neq null}
  <span class="searchTag d-inline-block">{$rubric['title']} <a href="/board/{if $region neq null}region_{$region['translit']}/{/if}{if $type neq null}{$type['translit']}{else}all{/if}{if $pageNumber neq null}_p{$pageNumber}{/if}"><i class="far fa-times close ml-2"></i></a></span>
  {/if}
  {if $region neq null}
  <span class="searchTag d-inline-block">{if $region['id'] eq 1}АР Крым{else}{$region['name']} область{/if} <a href="/board/{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}{if $pageNumber neq null}_p{$pageNumber}{/if}"><i class="far fa-times close ml-2"></i></a></span>
  {/if}
  {if $type neq null}
  <span class="searchTag d-inline-block">{$type['name']} <a href="/board/{if $region neq null}region_{$region['translit']}/{/if}all{if $rubric neq null}_t{$rubric['id']}{/if}{if $pageNumber neq null}_p{$pageNumber}{/if}"><i class="far fa-times close ml-2"></i></a></span>
  {/if}
</div>
{/if}
{if $topAdverts neq null}
<div class="container mb-4">
  <table class="d-none d-md-block">
    <thead>
      <tr><th>
      <div class="container">
      <div class="row mt-sm-4 pt-sm-3">
        <div class="position-relative w-100">
          <div class="col-12 col-md-8 float-md-right text-center text-md-right d-none d-sm-block">
            <a href="/board/addpost" class="top-btn btn btn-warning align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0 addPostBoard">
              <i class="far fa-plus d-none d-md-inline-block"></i>
              <span class="pl-1 pr-1">Добавить объявление</span>
            </a>
          </div>
          <div class="col-12 col-md-4 float-left mt-4 mt-md-0 d-block">
            <h2 class="d-inline-block text-uppercase">Топ объявления</h2>
            <div>
              <a href="/info/limit_adv#p3" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    </th></tr>
    </thead>
    <tbody>
      {foreach from=$topAdverts item=adv}
      <tr>
        <td>
          <div class="row content-block postItem mx-0 mt-3 mt-sm-4 pt-2 pb-2 py-sm-3 px-1{if $adv['colored'] eq 1} colored{/if}" style="max-width: 948px">
            <div class="ribbon">ТОП</div>
              <div class="row mx-0 w-100">
                <div class="col-auto pr-0 pl-1 pl-sm-3">
                  <a href="/board/post-{$adv['id']}">
                    <img src="/app/assets/img/no-image.png" class="postImg">
{*                    <img src="{if $adv['image'] neq null && file_exists($adv['image'])}/{$adv['image']}{else}/app/assets/img/no-image.png{/if}" class="postImg" alt="{$adv['title']}">*}
                  </a>
                  <span class="badge t{$adv['type_id']} align-self-center d-inline-block d-sm-none">{$adv['type']|substr:0:2}</span> 
                </div>
                <div class="col pr-0 pl-2 pl-sm-3">
                  <div class="row m-0">
                    <div class="col-12 col-sm-8 d-flex pl-1 pl-sm-0">
                      <h3 class="title ml-0 d-none d-sm-block">
                        <span class="badge t{$adv['type_id']} d-none d-sm-inline-block">{$adv['type']}</span>
                        <a href="/board/post-{$adv['id']}">{$adv['title']}</a></span>
                      </h3>
                      <span class="title align-self-center ml-0 ml-sm-2 d-block d-sm-none">
                        <a href="/board/post-{$adv['id']}" data-ellipsis="2">{$adv['title']}</a>
                      </span>
                    </div>
                    <div class="d-none d-sm-flex col-sm-4 pr-sm-3 justify-content-end">
                      <span class="price float-right">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}Договорная{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
                    </div>
                  </div>
                  <div class="row mx-0 w-100 m-bottom">
                    <div class="col p-0">
                      <div class="row mx-0 postRowHeight mt-1">
                        <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-flex d-sm-none">
                          <span class="price align-self-center">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}Договорная{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
                        </div>
                        <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                          <span class="rubric align-self-center">{$adv['rubric']}</span>
                        </div>
                        <div class="d-none d-sm-flex col-sm-3 pr-sm-3 justify-content-end">
                          <span class="unit float-right">{if $adv['amount'] neq null and $adv['izm'] neq null}{$adv['amount']} {$adv['izm']}{/if}</span>
                        </div>
                      </div>
                      <div class="row mx-0 mt-2 d-sm-none">
                        <div class="col justify-content-between align-items-bottom pl-1">
                          <span class="unit align-self-center">{if $adv['amount'] neq null and $adv['izm'] neq null}{$adv['amount']} {$adv['izm']}{/if}</span>
                          <span class="date float-right text-right">{if $smarty.now|date_format:"%Y/%m/%d" eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%d.%m.%Y"}{/if}</span>
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
                        <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                          <span class="region align-self-center">{if $adv['region'] eq 'АР Крым'}АР Крым{else}{$adv['region']} область{/if}{if $adv['city'] neq null}, {$adv['city']}{/if}</span>
                        </div>
                        <div class="d-none d-sm-flex col-sm-3 justify-content-end">
                          <span class="date float-right">{if $smarty.now|date_format:"%Y/%m/%d" eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%Y/%m/%d в %H:%M"}{/if}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </td>
      </tr>
      {/foreach}
    </tbody>
  </table>
  <table class="d-block d-md-none">
    <thead>
      <tr><th>
      <div class="container">
      <div class="row mt-sm-4 pt-sm-3">
        <div class="position-relative w-100">
          <div class="col-12 col-md-8 float-md-right text-center text-md-right d-none d-sm-block">
            <a href="/board/addpost" class="top-btn btn btn-warning align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0 addPostBoard">
              <i class="far fa-plus d-none d-md-inline-block"></i>
              <span class="pl-1 pr-1">Добавить объявление</span>
            </a>
          </div>
          <div class="col-12 col-md-4 float-left mt-4 mt-md-0 d-block">
            <h2 class="d-inline-block text-uppercase">Топ объявления</h2>
            <div>
              <a href="/info/limit_adv#p3" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    </th></tr>
    </thead>
    <tbody>
      {foreach from=$topAdverts item=adv}
      <tr>
        <td>
          <a href="/board/post-{$adv['id']}" class="d-block">
            <div class="row content-block postItem mx-0 mt-3 mt-sm-4 pt-2 pb-2 py-sm-3 px-1{if $adv['colored'] eq 1} colored{/if}">
              <div class="ribbon">ТОП</div>
                <div class="row mx-0 w-100">
                  <div class="col-auto pr-0 pl-1 pl-sm-3">
                    <img src="/app/assets/img/no-image.png" class="postImg">
{*                    <img src="{if $adv['image'] neq null && file_exists($adv['image'])}/{$adv['image']}{else}/app/assets/img/no-image.png{/if}" class="postImg" alt="{$adv['title']}">*}
                    <span class="badge t{$adv['type_id']} align-self-center d-inline-block d-sm-none">{$adv['type']|substr:0:2}</span>
                  </div>
                  <div class="col pr-0 pl-2 pl-sm-3">
                    <div class="row m-0">
                      <div class="col-12 col-sm-8 d-flex pl-1 pl-sm-0">
                        <h3 class="title ml-0 d-none d-sm-block">
                          <span class="badge t{$adv['type_id']} d-none d-sm-inline-block">{$adv['type']}</span>
                          <span class="a">{$adv['title']}</span>
                        </h3>
                        <span class="title align-self-center ml-0 ml-sm-2 d-block d-sm-none">
                          <span class="a" data-ellipsis="2">{$adv['title']}</span>
                        </span>
                      </div>
                      <div class="d-none d-sm-flex col-sm-4 pr-sm-3 justify-content-end">
                        <span class="price float-right">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}Договорная{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
                      </div>
                    </div>
                    <div class="row mx-0 w-100 m-bottom">
                      <div class="col p-0">
                        <div class="row mx-0 postRowHeight mt-1">
                          <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-flex d-sm-none">
                            <span class="price align-self-center">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}Договорная{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
                          </div>
                          <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                            <span class="rubric align-self-center">{$adv['rubric']}</span>
                          </div>
                          <div class="d-none d-sm-flex col-sm-3 pr-sm-3 justify-content-end">
                            <span class="unit float-right">{if $adv['amount'] neq null and $adv['izm'] neq null}{$adv['amount']} {$adv['izm']}{/if}</span>
                          </div>
                        </div>
                        <div class="row mx-0 mt-2 d-sm-none">
                          <div class="col justify-content-between align-items-bottom pl-1">
                            <span class="unit align-self-center">{if $adv['amount'] neq null and $adv['izm'] neq null}{$adv['amount']} {$adv['izm']}{/if}</span>
                            <span class="date float-right text-right">{if $smarty.now|date_format:"%Y/%m/%d" eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%d.%m.%Y"}{/if}</span>
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
                          <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                            <span class="region align-self-center">{if $adv['region'] eq 'АР Крым'}АР Крым{else}{$adv['region']} область{/if}{if $adv['city'] neq null}, {$adv['city']}{/if}</span>
                          </div>
                          <div class="d-none d-sm-flex col-sm-3 justify-content-end">
                            <span class="date float-right">{if $smarty.now|date_format:"%Y/%m/%d" eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%Y/%m/%d в %H:%M"}{/if}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </a>
        </td>
      </tr>
      {/foreach}
    </tbody>
  </table>
</div>
{/if}
{if $adverts neq null}
<div class="container mb-4">
  <table  class="d-none d-md-block">
  <thead>
    <tr><th>
  <div class="container my-2 mt-sm-4 mb-sm-2">
    <div class="row">
      <div class="position-relative w-100">
        {if $topAdverts eq null}
        <div class="col-12 col-md-4 float-md-right text-center text-md-right d-none d-sm-block">
          <a href="/board/addpost" class="top-btn btn btn-warning align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0 addPostBoard">
            <i class="far fa-plus d-none d-md-inline-block"></i>
            <span class="pl-1 pr-1">Добавить объявление</span>
          </a>
        </div>
        {/if}
        <div class="col-12 col-md-8 float-left {if $query neq null}mt-2{else}mt-0{/if} d-flex d-sm-block">
          <h2 class="d-inline-block text-uppercase">{if $query neq null}Поиск: {$query}{else}Все объявления{/if}</h2>
        </div>
      </div>
    </div>
  </div>
  </th></tr>
  </thead>
  <tbody>
    {foreach from=$adverts item=adv}
    <tr><td>
    <div class="row content-block postItem mx-0 mt-3 mt-sm-4 pt-2 pb-2 py-sm-3 px-1{if $adv['colored'] eq 1} colored{/if}"  style="max-width: 948px">
      {if $adv['top'] neq null}
      <div class="ribbon">ТОП</div>
      {/if}
      <div class="row mx-0 w-100">
        <div class="col-auto pr-0 pl-1 pl-sm-3">
          <a href="/board/post-{$adv['id']}">
            <img src="/app/assets/img/no-image.png" class="postImg">
{*            <img src="{if $adv['image'] neq null && file_exists($adv['image'])}/{$adv['image']}{else}/app/assets/img/no-image.png{/if}" class="postImg" alt="{$adv['title']}">*}
          </a>
          <span class="badge t{$adv['type_id']} align-self-center d-inline-block d-sm-none">{$adv['type']|substr:0:2}</span> 
        </div>
        <div class="col pr-0 pl-2 pl-sm-3">
          <div class="row m-0">
            <div class="col-12 col-sm-8 d-flex pl-1 pl-sm-0">
              <h3 class="title ml-0 d-none d-sm-block">
                <span class="badge t{$adv['type_id']} d-none d-sm-inline-block">{$adv['type']}</span>
                <a href="/board/post-{$adv['id']}">{$adv['title']}</a></span>
              </h3>
              <span class="title align-self-center ml-0 ml-sm-2 d-block d-sm-none">
                <a href="/board/post-{$adv['id']}">{$adv['title']|truncate:45:"..":true}</a>
              </span>
            </div>
            <div class="d-none d-sm-flex col-sm-4 pr-sm-3 justify-content-end">
              <span class="price float-right">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}Договорная{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
            </div>
          </div>
          <div class="row mx-0 w-100 m-bottom">
            <div class="col p-0">
              <div class="row mx-0 postRowHeight mt-1">
                <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-flex d-sm-none">
                  <span class="price align-self-center">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}Договорная{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
                </div>
                <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                  <span class="rubric align-self-center">{$adv['rubric']}</span>
                </div>
                <div class="d-none d-sm-flex col-sm-3 pr-sm-3 justify-content-end">
                  <span class="unit float-right">{if $adv['amount'] neq null and $adv['izm'] neq null}{$adv['amount']} {$adv['izm']}{/if}</span>
                </div>
              </div>
              <div class="row mx-0 mt-0 d-sm-none">
                <div class="col justify-content-between align-items-bottom pl-1">
                  <span class="unit align-self-center">{if $adv['amount'] neq null and $adv['izm'] neq null}{$adv['amount']} {$adv['izm']}{/if}</span>
                  <span class="date float-right text-right">{if $smarty.now|date_format:"%Y/%m/%d" eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%d.%m.%Y"}{/if}</span>
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
                  <span class="region align-self-center">{if $adv['region'] eq 'АР Крым'}АР Крым{else}{$adv['region']} область{/if}{if $adv['city'] neq null}, {$adv['city']}{/if}</span>
                </div>
                <div class="d-none d-sm-flex col-sm-3 justify-content-end">
                  <span class="date float-right">{if $smarty.now|date_format:"%Y/%m/%d" eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%Y/%m/%d в %H:%M"}{/if}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </td></tr>
    {/foreach}
  </tbody>
  </table>
  <table  class="d-block d-md-none">
    <thead>
      <tr><th>
    <div class="container my-2 mt-sm-4 mb-sm-2">
      <div class="row">
        <div class="position-relative w-100">
          {if $topAdverts eq null}
          <div class="col-12 col-md-4 float-md-right text-center text-md-right d-none d-sm-block">
            <a href="/board/addpost" class="top-btn btn btn-warning align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0 addPostBoard">
              <i class="far fa-plus d-none d-md-inline-block"></i>
              <span class="pl-1 pr-1">Добавить объявление</span>
            </a>
          </div>
          {/if}
          <div class="col-12 col-md-8 float-left {if $query neq null}mt-2{else}mt-0{/if} d-flex d-sm-block">
            <h2 class="d-inline-block text-uppercase">{if $query neq null}Поиск: {$query}{else}Все объявления{/if}</h2>
          </div>
        </div>
      </div>
    </div>
    </th></tr>
    </thead>
    <tbody>
      {foreach from=$adverts item=adv}
      <tr>
        <td>
          <a href="/board/post-{$adv['id']}">
            <div class="row content-block postItem mx-0 mt-3 mt-sm-4 pt-2 pb-2 py-sm-3 px-1{if $adv['colored'] eq 1} colored{/if}">
              {if $adv['top'] neq null}
              <div class="ribbon">ТОП</div>
              {/if}
              <div class="row mx-0 w-100">
                <div class="col-auto pr-0 pl-1 pl-sm-3">
                  <img src="{if $adv['image'] neq null}/{$adv['image']}{else}/app/assets/img/no-image.png{/if}" class="postImg" alt="{$adv['title']}">
                  <span class="badge t{$adv['type_id']} align-self-center d-inline-block d-sm-none">{$adv['type']|substr:0:2}</span> 
                </div>
                <div class="col pr-0 pl-2 pl-sm-3">
                  <div class="row m-0">
                    <div class="col-12 col-sm-8 d-flex pl-1 pl-sm-0">
                      <h3 class="title ml-0 d-none d-sm-block">
                        <span class="badge t{$adv['type_id']} d-none d-sm-inline-block">{$adv['type']}</span>
                        <span class="a">{$adv['title']}</span>
                      </h3>
                      <span class="title align-self-center ml-0 ml-sm-2 d-block d-sm-none">
                        <span class="a">{$adv['title']|truncate:45:"..":true}</span>
                      </span>
                    </div>
                    <div class="d-none d-sm-flex col-sm-4 pr-sm-3 justify-content-end">
                      <span class="price float-right">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}Договорная{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
                    </div>
                  </div>
                  <div class="row mx-0 w-100 m-bottom">
                    <div class="col p-0">
                      <div class="row mx-0 postRowHeight mt-1">
                        <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-flex d-sm-none">
                          <span class="price align-self-center">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}Договорная{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
                        </div>
                        <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                          <span class="rubric align-self-center">{$adv['rubric']}</span>
                        </div>
                        <div class="d-none d-sm-flex col-sm-3 pr-sm-3 justify-content-end">
                          <span class="unit float-right">{if $adv['amount'] neq null and $adv['izm'] neq null}{$adv['amount']} {$adv['izm']}{/if}</span>
                        </div>
                      </div>
                      <div class="row mx-0 mt-0 d-sm-none">
                        <div class="col justify-content-between align-items-bottom pl-1">
                          <span class="unit align-self-center">{if $adv['amount'] neq null and $adv['izm'] neq null}{$adv['amount']} {$adv['izm']}{/if}</span>
                          <span class="date float-right text-right">{if $smarty.now|date_format:"%Y/%m/%d" eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%d.%m.%Y"}{/if}</span>
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
                          <span class="region align-self-center">{if $adv['region'] eq 'АР Крым'}АР Крым{else}{$adv['region']} область{/if}{if $adv['city'] neq null}, {$adv['city']}{/if}</span>
                        </div>
                        <div class="d-none d-sm-flex col-sm-3 justify-content-end">
                          <span class="date float-right">{if $smarty.now|date_format:"%Y/%m/%d" eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%Y/%m/%d в %H:%M"}{/if}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
      </td>
    </tr>
      {/foreach}
    </tbody>
  </table>
</div>
<div class="container d-flex justify-content-center mb-4">
  {foreach $banners['bottom'] as $banner}
  {$banner}
  {/foreach}
</div>
<div class="container mb-5">
  <div class="row mx-0 mt-4">
    <div class="col-12 pagination d-block text-center">
      {if $pagePagination eq null}
        {assign "page" "1"}
      {else}
        {assign "page" $pagePagination}
      {/if}
      {if $page neq 1}
      <a href="{if $query neq null}/s/{$query}{/if}/board/{if $region neq null}region_{$region['translit']}/{/if}{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}_p{$page - 1}"><span class="mr-1"><i class="far fa-chevron-left"></i></span> <span class="d-none d-sm-inline-block">Предыдущая</span></a>
      {/if}
      {if ($page - 3) ge 1}
      <a class="mx-1" href="{if $query neq null}/s/{$query}{/if}/board/{if $region neq null}region_{$region['translit']}/{/if}{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}">1</a>
      ..
      {/if}
      {if ($page - 2) gt 0}
      <a class="d-none d-sm-inline-block mx-1" href="{if $query neq null}/s/{$query}{/if}/board/{if $region neq null}region_{$region['translit']}/{/if}{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}_p{$page - 2}">{$page - 2}</a>
      {/if}
      {if ($page - 1) gt 0}
      <a class="d-none d-sm-inline-block mx-1" href="{if $query neq null}/s/{$query}{/if}/board/{if $region neq null}region_{$region['translit']}/{/if}{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}_p{$page - 1}">{$page - 1}</a>
      {/if}
      <a href="#" class="active mx-1">{$page}</a>
      {if ($page + 1) le $totalPages}
      <a class="d-sm-inline-block mx-1" href="{if $query neq null}/s/{$query}{/if}/board/{if $region neq null}region_{$region['translit']}/{/if}{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}_p{$page + 1}">{$page + 1}</a>
      {/if}
      {if ($page + 2) le $totalPages}
      <a class="d-sm-inline-block mx-1" href="{if $query neq null}/s/{$query}{/if}/board/{if $region neq null}region_{$region['translit']}/{/if}{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}_p{$page + 2}">{$page + 2}</a>
      {/if}
      {if ($page + 3) le $totalPages}
      ..
      <a class="mx-1" href="{if $query neq null}/s/{$query}{/if}/board/{if $region neq null}region_{$region['translit']}/{/if}{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}_p{$totalPages}">{$totalPages}</a>
      {/if}
      {if $page neq $totalPages}
      <a href="{if $query neq null}/s/{$query}{/if}/board/{if $region neq null}region_{$region['translit']}/{/if}{if $type neq null}{$type['translit']}{else}all{/if}{if $rubric neq null}_t{$rubric['id']}{/if}_p{$page + 1}"><span class="d-none d-sm-inline-block">Следующая</span> <span class="ml-1"><i class="far fa-chevron-right"></i></span></a>
      {/if}
    </div>
  </div>
  {if $text neq ''}
  <br>
  {$text}
  {/if}
</div>
{else}
  <div class="container empty mt-5">
  <div class="content-block p-5">
    <span class="title d-block">По Вашему запросу объявлений не найдено</span>
    <span class="all">Вы можете разместить своё объявление</span>
    <a href="/board/addpost" class="top-btn btn btn-warning align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0 addPostBoard">
      <i class="far fa-plus d-none d-md-inline-block"></i>
      <span class="pl-1 pr-1">Добавить объявление</span>
    </a>
    <span class="all d-block">Либо перейти в общий раздел с <a href="/board">объявлениями</a></span>
  </div>
</div>
{/if}
<a href="/board/addpost" class="add-advert-btn">Добавить объявление</a>