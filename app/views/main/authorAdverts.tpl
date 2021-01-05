<div class="d-none d-sm-block container mt-3">
  <ul class="breadcrumbs small p-0">
    <li><a href="/">Агротендер</a></li>
    <li class="divider position-relative"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><h1>Объявления в Украние</h1></li>
  </ul>
</div>
{if $adverts neq null}
<table>
<thead>
  <tr><th>
<div class="container my-2 mt-sm-4 mb-sm-2">
  <div class="row">
    <div class="position-relative w-100">
      <div class="col-12 col-md-12 float-left mt-0 d-flex d-sm-block">
        <h2 class="d-inline-block text-uppercase">Все объявления автора: {if $author['company'] neq null}{$author['company']}{else}{$author['name']}{/if}</h2>
      </div>
    </div>
  </div>
</div>
</th></tr>
</thead>
<tbody>
  <tr><td>
<div class="container mb-4">
  {foreach from=$adverts item=adv}
    <div class="d-none d-md-block">
      <div class="row content-block postItem mx-0 mt-3 mt-sm-4 pt-2 pb-2 py-sm-3 px-1{if $adv['colored'] eq 1} colored{/if}">
        {if $adv['top'] neq null}
        <div class="ribbon">В ТОПе</div>
        {/if}
        <div class="row mx-0 w-100">
          <div class="col-auto pr-0 pl-1 pl-sm-3">
            <a href="/board/post-{$adv['id']}">
              <img src="{if $adv['image'] neq null}/{$adv['image']}{else}/app/assets/img/no-image.png{/if}" class="postImg" alt="{$adv['title']}">
              <span class="badge t{$adv['type_id']} align-self-center d-inline-block d-sm-none">{$adv['type']|substr:0:2}</span>
            </a>
          </div>
          <div class="col pr-0 pl-2 pl-sm-3">
            <div class="row m-0">
              <div class="col-12 col-sm-8 d-flex pl-1 pl-sm-0">
                <h1 class="title ml-0 d-none d-sm-block">
                  <span class="badge t{$adv['type_id']} d-none d-sm-inline-block">{$adv['type']}</span>
                  <a href="/board/post-{$adv['id']}" data-ellipsis="1">{$adv['title']}</a></span>
                </h1>
                <span class="title align-self-center ml-0 ml-sm-2 d-block d-sm-none">
                  <a href="/board/post-{$adv['id']}">{$adv['title']|truncate:30:"..":false}</a>
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
                    <span class="date float-right">{if ($smarty.now|date_format:"%Y/%m/%d") eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%Y/%m/%d %H:%M"}{/if}</span>
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
                    <span class="region align-self-center">{$adv['region']} область{if $adv['city'] neq null}, {$adv['city']}{/if}</span>
                  </div>
                  <div class="d-none d-sm-flex col-sm-3 justify-content-end">
                    <span class="date float-right">{if ($smarty.now|date_format:"%Y/%m/%d") eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%Y/%m/%d %H:%M"}{/if}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-block d-md-none">
      <a href="/board/post-{$adv['id']}">
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
                    <span class="a" data-ellipsis="1">{$adv['title']}</span>
                  </h1>
                  <span class="title align-self-center ml-0 ml-sm-2 d-block d-sm-none">
                    <span class="a">{$adv['title']|truncate:30:"..":false}</span>
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
                      <span class="date float-right">{if ($smarty.now|date_format:"%Y/%m/%d") eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%Y/%m/%d %H:%M"}{/if}</span>
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
                      <span class="region align-self-center">{$adv['region']} область{if $adv['city'] neq null}, {$adv['city']}{/if}</span>
                    </div>
                    <div class="d-none d-sm-flex col-sm-3 justify-content-end">
                      <span class="date float-right">{if ($smarty.now|date_format:"%Y/%m/%d") eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%Y/%m/%d %H:%M"}{/if}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
  {/foreach}
</div>
</td></tr>
</tbody>
</table>
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
      <a href="/board/author/{$author['id']}?p={$page - 1}"><span class="mr-1"><i class="far fa-chevron-left"></i></span> <span class="d-none d-sm-inline-block">Предыдущая</span></a>
      {/if}
      {if ($page - 3) ge 1}
      <a class="mx-1" href="/board/author/{$author['id']}">1</a>
      ..
      {/if}
      {if ($page - 2) gt 0}
      <a class="d-none d-sm-inline-block mx-1" href="/board/author/{$author['id']}?p={$page - 2}">{$page - 2}</a>
      {/if}
      {if ($page - 1) gt 0}
      <a class="d-none d-sm-inline-block mx-1" href="/board/author/{$author['id']}?p={$page - 1}">{$page - 1}</a>
      {/if}
      <a href="#" class="active mx-1">{$page}</a>
      {if ($page + 1) le $totalPages}
      <a class="d-sm-inline-block mx-1" href="/board/author/{$author['id']}?p={$page + 1}">{$page + 1}</a>
      {/if}
      {if ($page + 2) le $totalPages}
      <a class="d-sm-inline-block mx-1" href="/board/author/{$author['id']}?p={$page + 2}">{$page + 2}</a>
      {/if}
      {if ($page + 3) le $totalPages}
      ..
      <a class="mx-1" href="/board/author/{$author['id']}?p={$totalPages}">{$totalPages}</a>
      {/if}
      {if $page neq $totalPages}
      <a href="/board/author/{$author['id']}?p={$page + 1}"><span class="d-none d-sm-inline-block">Следующая</span> <span class="ml-1"><i class="far fa-chevron-right"></i></span></a>
      {/if}
    </div>
  </div>
</div>
{else}
  <div class="container empty mt-5">
  <div class="content-block p-5">
    <span class="title d-block">У автора нет других объявлений</span>
    <span class="all">Вы можете разместить своё объявление</span>
    <a href="/board/addpost" class="top-btn btn btn-warning align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">
      <i class="far fa-plus d-none d-md-inline-block"></i>
      <span class="pl-1 pr-1">Добавить объявление</span>
    </a>
    <span class="all d-block">Либо перейти в общий раздел с <a href="/board">объявлениями</a></span>
  </div>
</div>
{/if}