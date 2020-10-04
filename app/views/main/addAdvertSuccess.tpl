<div class="container mt-5 pt-5">
  <div class="boardInfo text-center">
    <img src="/app/assets/img/check.png" width="70" class="mb-3">
    <span class="thankyou">Cпасибо, что опубликовали своё объявление! </span> 
    <span class="d-block">Вы можете просмотреть и отредактировать его в <a href="/u/posts">Личном кабинете</a>.</span>
    <div class="mt-3">
      <a href="/board/addpost" class="top-btn btn btn-warning align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0"> <i class="far fa-plus d-none d-md-inline-block"></i> <span class="pl-1 pr-1">Добавить объявление</span> </a>
    </div>
    <span class="mt-5 pt-5 ad">Рекламируйте ваше объявление и получайте <u>больше откликов!</u></span>
  </div>
  <div class="boardPacks my-5">
    {foreach from=$packs item=pack key=key}
      {if $pack|@count eq 3}
      <div class="content-block px-4 pack-block d-flex align-items-center row m-0 py-3 noselect pack-{$key}">
        <div class="col p-0 d-flex align-items-center lh-1">
          <span class="dot mr-3"></span> <span class="py-3">Поднятие в ТОП</span>
        </div>
        <div class="col-auto p-0 text-right">
          <div class="right-side d-flex">
            <select class="form-control mr-4 d-none d-sm-block selectNum">
              {foreach $pack as $option}
              <option value="{$option['id']}" cost="{$option['cost']}">{$option['sort_num']} дней</option>
              {/foreach}
            </select>
            <span class="price"><span class="cost">{$pack[0]['cost']|intval}</span><span class="currency ml-1">грн</span></span>
          </div>
        </div>
      </div>
      {else}
      <div class="content-block px-4 pack-block d-flex align-items-center row mx-0 my-4 py-3 noselect pack-{$key}" pack-id="{$pack['id']}">
        <div class="col p-0 d-flex align-items-center lh-1">
          <span class="dot mr-3"></span> <span class="py-3">{$pack['title']}</span>
        </div>
        <div class="col-auto p-0 text-right">
          <div class="right-side d-flex">
            <span class="price"><span class="cost">{$pack['cost']|intval}</span><span class="currency ml-1">грн</span></span>
          </div>
        </div>
      </div>
      {/if}
    {/foreach}
    <div class="totalPrice row mx-0 mt-4">
      <div class="col-8 col-sm-3 offset-4 offset-sm-9 px-4 py-2 text-right content-block ">
        <div class="right-side d-flex align-items-center justify-content-center lh-1">
          <span class="text">Всего к оплате: </span>
          <span class="price ml-3"><span class="cost">0</span><span class="currency ml-1">грн</span></span>
        </div>
      </div>
    </div>
    <div class="payFooter row mx-0 mt-5">
      <div class="col-12 col-sm">
        <a href="/info/limit_adv#p3">Узнать больше о платных услугах</a>
      </div>
      <div class="col d-flex align-items-center justify-content-end px-0">
        <a href="/u/posts">Отменить</a>
        <button class="btn payBtn ml-4 px-5" post-id="{$advId}">Оплатить</button>
      </div>
    </div>
  </div>
</div>