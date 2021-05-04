<div class="container pt-2 pt-sm-3">
  <ol class="breadcrumbs small p-0 d-sm-block">
    <li><a href="/"><span>Агротендер</span></a></li>
    <i class="fas fa-chevron-right extra-small"></i>
    {if $region eq null}
    <li><h1>Элеваторы</h1></li>
    {else}
    <li><a href="/elev"><span>Элеваторы</span></a></li>
    <i class="fas fa-chevron-right extra-small"></i>
    <li><h1>Элеваторы в {$region['parental']} области</h1></li>
    {/if}
  </ol>
  <div class="row pt-0 pt-sm-3 my-3 my-sm-0 mb-sm-5">
    <div class="position-relative w-100">
      <div class="col-12 float-left d-block">
        <h2 class="d-inline-block text-uppercase">
          Элеваторы {if $region neq null}- {/if}<span class="select-link"><span class="select-region">{if $region eq null}Украины{else} {if $region['id'] eq 1}АР Крым{else}{$region['name']} область{/if}{/if}</span>&nbsp;<i class="far fa-chevron-down"></i></span>
        </h2>
      </div>
      <div class="dropdown-wrapper position-absolute regionDrop">
      <div class="dropdown">
          <span class="d-block">
          <a class="regionLink d-inline-block{if $region eq null} text-muted disabled{/if}" href="/elev">
          <span>Вся Украина</span>
          </a>
          <a class="regionLink d-inline-block{if $region neq null}{if $region['id'] eq 1} text-muted disabled{/if}{/if}" href="/elev/crimea">
          <span>АР Крым</span>
          </a>
          </span>
          <hr class="mt-1 mb-2">
          <div class="section text-left">
            <div class="row">
              {foreach from=$regions_list item=group}
              <div class="col">
                {foreach from=$group item=r}
                <a class="regionLink{if $region neq null and $region['id'] eq $r['id']} active{/if}" href="/elev/{$r['translit']}">
                  <span>{$r['name']} область</span>
                </a>
                {/foreach}
              </div>
              {/foreach}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container elev">
  {foreach from=$list item=group}
  <div class="row mb-0 mb-sm-5 mx-0">
    {foreach name=elev from=$group item=elev}
    <div class="col-12 col-sm-6{if $smarty.foreach.elev.first} pr-0 pr-sm-3{/if}">
      <a href="/elev/{$elev['url']}" class="row d-flex content-block p-2{if $smarty.foreach.elev.first} mr-0 mr-sm-4{/if}">
        <div class="col-auto px-2 d-none d-sm-block">
          <img src="/app/assets/img/granary-4.png" class="icon">
        </div>
        <div class="col pl-1 text-left d-flex align-items-center">
          <div>
            <span class="d-block title"{if $elev['name']|count_characters:true gt 35} data-toggle="tooltip" data-placement="top" title="{$elev['name']}"{/if}>{$elev['name']|unescape|truncate:35:"..":true}</span>
            <span class="d-block geo">{$elev['region']} область / {$elev['ray']} р-н</span>
          </div>
        </div>
        <div class="col-auto px-2 d-flex align-items-center">
          <i class="far fa-angle-right icon-right"></i>
        </div>
      </a>
    </div>
    {/foreach}
  </div>
  {/foreach}
</div>
<div class="container d-flex justify-content-center mt-4 mb-5">
  {foreach $banners['bottom'] as $banner}
  {$banner}
  {/foreach}
</div>