<div class="container company mt-4 mb-5">
  <div class="row">
    <div class="position-relative w-100">
      <div class="col-12 col-md-3 float-md-right text-center text-md-right">
        <select class="form-control" name="typeAdverts">
          <option value=""{if $type eq null} selected{/if}>Все объявления</option>
          <option value="1"{if $type eq '1'} selected{/if}>Закупки</option>
          <option value="2"{if $type eq '2'} selected{/if}>Продажи</option>
          <option value="3"{if $type eq '3'} selected{/if}>Услуги</option>
        </select>
      </div>
      <div class="col-12 col-md-4 float-left mt-4 mt-md-0 d-flex d-sm-block">
        <h2 class="d-inline-block text-uppercase">Объявления</h2>
      </div>
    </div>
  </div>
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
              <a href="/board/post-{$adv['id']}">{$adv['title']}</a></span>
            </h1>
            <span class="title align-self-center ml-0 ml-sm-2 d-block d-sm-none">
              <a href="/board/post-{$adv['id']}">{$adv['title']|truncate:40:"..":false}</a>
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
                <span class="region align-self-center">{$adv['region']} область{if $adv['city'] neq null}, {$adv['city']}{/if}</span>
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
  {foreachelse}
  <div class="content-block text-center py-4 px-2 mt-4">
    <span class="emptyPosts">Список объявлений пуст.</span>
  </div>
  {/foreach}
</div>