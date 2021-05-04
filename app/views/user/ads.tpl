{if $advError neq null}
<div class="container mt-4 mb-4">
  <div class="advLimit py-3 d-flex align-items-center justify-content-start">
    <img src="/app/assets/img/advError.png" class="ml-4">
    <div class="ml-4">
      {if $advError eq '1'}
      Вы достигли лимита активных объявлений на сайте: {$user->limits['max']}. <a href="/info/limit_adv">Узнать больше о лимитах</a> <br>
      Увеличьте лимит объявлений или деактивируйте ненужные - <a href="/u/posts/limits">Увеличить лимит объявлений</a>
      {else}
      Вы достигли лимита доступных к размещению объявлений. <a href="/info/limit_adv">Узнать больше о лимитах</a> <br>
      Следующие 10 объявлений будут доступны {"first day of next month"|date_format:'%d.%m.%Y'}. <a href="/u/posts/limits">Увеличить лимит объявлений сейчас</a> 
      {/if}
    </div>
  </div>
</div>
{/if}
<div class="container submenu d-none d-sm-block text-left">
  <a href="/u/posts"{if $archive eq 0} class="active"{/if}>Активные ({$activeCount})</a>
  <a href="/u/posts?archive=1"{if $archive eq 1} class="active"{/if}>Неактивные ({$archiveCount})</a>
</div>
<div class="container mt-4 mb-5 p-0">
  <h2 class="ml-3 mb-3 d-sm-none">Объявления <a href="/board/addpost" class="float-right text-orange mr-3">+ Создать</a></h2>
  {if $detect->isMobile()}
  <div class="content-block profile-posts">
    {foreach $adverts as $advert}
    <div class="block py-2{if $advert['colored'] eq 1} colored{/if}">
      <div class="row m-0 w-100">
        <div class="col-auto">
          <img src="/{if $advert['image'] neq null}{$advert['image']}{else}app/assets/img/no-image.png{/if}">
          <span class="badge t{$advert['type_id']} align-self-center d-inline-block d-sm-none">{$advert['type']|substr:0:2}</span> 
        </div>
        <div class="col-8 pl-0">
          <a class="title d-block lh-1-2" href="/board/post-{$advert['id']}">
            {if $advert['top'] neq null}<span class="badge t2 d-inline-block topBadge">ТОП</span> {/if}{$advert['title']|unescape|truncate:47:"..":true}
          </a>
          <div class="d-bottom w-100">
            <div class="row m-0">
              <div class="col pl-0 lh-1">
                <span class="price lh-1"> {if $advert['cost_dog'] eq 1}Договорная{elseif $advert['cost_dog'] eq 0 && $advert['cost'] eq null}0 грн.{else}{$advert['cost']} {if $advert['cost_cur'] eq 1}грн.{elseif $advert['cost_cur'] eq 2}${elseif $advert['cost_cur'] eq 3}€{elseif $advert['cost_cur'] eq 0}грн.{/if}{/if}</span>
              </div>
            </div>
            <div class="row m-0 align-items-center">
              <div class="col-6 pl-0">
                <span class="count lh-1"> {if $advert['amount'] neq null and $advert['izm'] neq null}{$advert['amount']} {$advert['izm']}{/if}</span>
              </div>
              <div class="col-6 pl-0 justify-content-end text-right"><span class="date lh-1">{$advert['up_dt']|date_format:"%Y/%m/%d"}</span></div>
            </div>
          </div>
        </div>
      </div>
      {if $archive eq 0}
      <div class="row mx-0 mt-3 align-items-center">
        <div class="col pr-1">
          {if $advert['free_up'] eq 1}
          <a href="#" post="{$advert['id']}" class="btn btn-up btn-block" cost="0">Поднять бесплатно</a>
          {else}
          <a href="#" post="{$advert['id']}" class="btn btn-up btn-block" cost="{$upPrice}">Поднять за {$upPrice}грн.</a>
          {/if}
        </div>
        <div class="col pl-1">
          <a href="/u/posts/upgrade?adv={$advert['id']}" class="btn btn-success btn-block">Рекламировать</a>
        </div>
      </div>
      {/if}
      <div class="row mx-0 mt-2">
        <div class="col pr-1">
          <a href="/board/edit{$advert['id']}" class="btn btn-primary btn-block">Редактировать</a>
        </div>
        <div class="col pl-1">
          {if $archive eq 0}
          <a href="#" post="{$advert['id']}" class="btn btn-danger btn-block setArchive" archive="1">Деактивировать</a>
          {else}
          <a href="#" post="{$advert['id']}" class="btn btn-success btn-block setArchive" archive="0">Активировать</a>
          {/if}
        </div>
      </div>
    </div>
    {foreachelse}
    <div class="block d-flex py-2 justify-content-center align-items-center">
      У Вас нет {if $archive eq 0}активных{else}неактивных{/if} объявлений.
    </div>
    {/foreach}
  </div>
  {else}
  <div class="content-block profile-posts nv">
    <div class="posts-head py-3 px-4 d-flex justify-content-between align-items-center">
      <div><span>Сортировка: </span> <a class="ml-3{if $sort eq 'add_date'} active{/if}" href="/u/posts{if $archive eq 1}?archive=1{/if}">По дате</a> <a class="ml-3{if $sort eq 'title'} active{/if}" href="/u/posts?{if $archive eq 1}archive=1&{/if}sort=title">По заголовку</a></div>
      <a href="/board/addpost" class="btn btn-warning float-right">Добавить объявление</a>
    </div>
    {foreach $adverts as $advert}
    <div class="block d-flex py-2{if $advert['colored'] eq 1} colored{/if}">
      <div class="col-auto pr-0 d-flex justify-content-center align-items-center">
        <input class="custom-control-input" type="checkbox" name="adverts[]" value="{$advert['id']}" id="advert{$advert['id']}"> <label class="custom-control-label ml-4" for="advert{$advert['id']}">&nbsp;</label>
      </div>
      <div class="col-1 px-0 d-flex justify-content-start align-items-center text-center">
        <span class="date">{$advert['up_dt']}</span>
      </div>
      <div class="col-auto">
        <img src="/{if $advert['image'] neq null}{$advert['image']}{else}app/assets/img/no-image.png{/if}">
        <span class="badge t{$advert['type_id']} d-none d-sm-inline-block">{$advert['type']}</span>
      </div>
      <div class="col-5 pl-0">
        <a class="title d-block" href="/board/post-{$advert['id']}">
          {if $advert['top'] neq null}<span class="badge t2 d-none d-sm-inline-block topBadge">ТОП</span> {/if}{$advert['title']}
        </a>
        <div class="links">
          <a href="/board/post-{$advert['id']}">
            <i class="fas fa-eye"></i>&nbsp; Посмотреть
          </a>
          <a href="/board/edit{$advert['id']}" class="ml-3">
            <i class="fas fa-pencil"></i>&nbsp; Редактировать
          </a>
          {if $archive eq 0}
          <a href="#" post="{$advert['id']}" class="ml-3 deact setArchive" archive="1">
            <i class="fas fa-times"></i>&nbsp; Деактивировать
          </a>
          {else}
          <a href="#" post="{$advert['id']}" class="ml-3 act setArchive" archive="0">
            <i class="fas fa-check"></i>&nbsp; Активировать
          </a>
          {/if}
        </div>
        <div class="d-bottom lh-1">
          <span class="extra-small">Просмотров: <b>{$advert['viewnum']}</b></span>
        </div>
      </div>
      <div class="{if $archive eq 0}col-2{else}col{/if} d-flex justify-content-center align-items-center">
        <div class="text-right">
          <span class="price d-block"> {if $advert['cost_dog'] eq 1}Договорная{elseif $advert['cost_dog'] eq 0 && $advert['cost'] eq null}Договорная{else}{$advert['cost']} {if $advert['cost_cur'] eq 1}грн.{elseif $advert['cost_cur'] eq 2}${elseif $advert['cost_cur'] eq 3}€{elseif $advert['cost_cur'] eq 0}грн.{/if}{/if}</span>
          <span class="count d-block"> {if $advert['amount'] neq null and $advert['izm'] neq null}{$advert['amount']} {$advert['izm']}{/if}</span>
        </div>
      </div>
      {if $archive eq 0}
      <div class="col-2 d-flex justify-content-center align-items-center">
        <div class="text-center">
          {if $advert['free_up'] eq 1}
          <a href="#" post="{$advert['id']}" class="btn btn-up w-100" cost="0">Поднять бесплатно</a>
          {else}
          <a href="#" post="{$advert['id']}" class="btn btn-up w-100" cost="{$upPrice}">Поднять за {$upPrice}грн.</a>
          {/if}
          <a href="/u/posts/upgrade?adv={$advert['id']}" class="btn btn-success mt-2 w-100">Рекламировать</a>
        </div>
      </div>
      {/if}
    </div>
    {foreachelse}
    <div class="block d-flex py-2 justify-content-center align-items-center">
      У Вас нет {if $archive eq 0}активных{else}неактивных{/if} объявлений.
    </div>
    {/foreach}
  </div>
  <div class="d-flex justify-content-end mt-3 align-items-center">
    <select class="custom-select col-3">
      <option selected="">Выберите действие</option>
      <option value="1">Удалить</option>
      {if $archive eq 1}
      <option value="2">Переместить в активные</option>
      {else}
      <option value="3">Переместить в неактивные</option>
      {/if}
    </select>
    <button class="btn btn-primary action-btn ml-3">Выполнить</button>
  </div> 
  {/if}
  {if $adverts neq null && $totalPages > 1}
  <div class="row mx-0 mt-5">
    <div class="col-12 pagination d-block text-center">
      {if $pagePagination eq null}
        {assign "page" "1"}
      {else}
        {assign "page" $pagePagination}
      {/if}
      {if $page neq 1}
      <a href="/u/posts?{if $archive eq 1}archive=1&{/if}p={$page - 1}"><span class="mr-1"><i class="far fa-chevron-left"></i></span> <span class="d-none d-sm-inline-block">Предыдущая</span></a>
      {/if}
      {if ($page - 3) ge 1}
      <a class="mx-1" href="/u/posts{if $archive eq 1}?archive=1{/if}">1</a>
      ..
      {/if}
      {if ($page - 2) gt 0}
      <a class="d-none d-sm-inline-block mx-1" href="/u/posts?{if $archive eq 1}archive=1&{/if}p={$page - 2}">{$page - 2}</a>
      {/if}
      {if ($page - 1) gt 0}
      <a class="d-none d-sm-inline-block mx-1" href="/u/posts?{if $archive eq 1}archive=1&{/if}p={$page - 1}">{$page - 1}</a>
      {/if}
      <a href="#" class="active mx-1">{$page}</a>
      {if ($page + 1) le $totalPages}
      <a class="d-none d-sm-inline-block mx-1" href="/u/posts?{if $archive eq 1}archive=1&{/if}p={$page + 1}">{$page + 1}</a>
      {/if}
      {if ($page + 2) le $totalPages}
      <a class="d-none d-sm-inline-block mx-1" href="/u/posts?{if $archive eq 1}archive=1&{/if}p={$page + 2}">{$page + 2}</a>
      {/if}
      {if ($page + 3) le $totalPages}
      ..
      <a class="mx-1" href="/u/posts?{if $archive eq 1}archive=1&{/if}p={$totalPages}">{$totalPages}</a>
      {/if}
      {if $page neq $totalPages}
      <a href="/u/posts?{if $archive eq 1}archive=1&{/if}p={$page + 1}"><span class="d-none d-sm-inline-block">Следующая</span> <span class="ml-1"><i class="far fa-chevron-right"></i></span></a>
      {/if}
    </div>
  </div>
  {/if}
</div>