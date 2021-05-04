<div class="submenu d-none d-sm-block text-center">
  <a href="/u/posts/limits">Лимит объявлений</a>
  <a href="/u/posts/upgrade" class="active">Улучшения объявлений</a>
  <a href="/u/balance/pay">Пополнить баланс</a>
  <a href="/u/balance/history">История платежей</a>
  <a href="/u/balance/docs">Счета/акты</a>
</div>
<div class="container mt-4 mb-5">
  {if $advId neq null}
  <h2>Повысить эффективность объявления:</h2>
  <h2><a href="/board/post-{$advId}">{$advTitle}</a></h2>
  <div class="boardPacks my-5">
    {foreach from=$packs item=pack key=key}
      {if $pack|@count eq 3}
      <div class="content-block px-4 pack-block d-flex align-items-center row m-0 py-3 noselect pack-{$key}">
        <div class="col p-0 d-flex align-items-center lh-1">
          <span class="dot mr-3"></span> <span class="py-3">{if $pack[0]['pack_type'] eq 1}Поднятие в топ{else}Выделение цветом{/if}</span>
        </div>
        <div class="col-auto p-0 text-right">
          <div class="right-side d-flex">
            <select class="form-control mr-4 d-none d-sm-block selectNum">
              {foreach $pack as $option}
              <option value="{$option['id']}" cost="{$option['cost']}">{$option['period']} дней</option>
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
      <div class="col-12 d-flex align-items-center justify-content-center px-0 mb-3">
        <a href="/info/limit_adv#p3">Узнать больше о платных услугах</a>
      </div>
      <div class="col-12 d-flex align-items-center justify-content-center px-0 mb-3">
        <button class="btn payBtn ml-4 px-5" post-id="{$advId}">Оплатить</button>
      </div>
    </div>
  </div>
  {else}
  <h2>Текущие улучшения</h2>
  <div class="scroll-x py-4">
    <table class="sortTable">
      <thead>
        <th>Заказано</th>
        <th>Пакет</th>
        <th>Объявление</th>
        <th>Дата окончания</th>
        <th>Цена</th>
      </thead>
      <tbody>
        {foreach $payedPacks as $pack}
        <tr{if $smarty.now|date_format:'%Y-%m-%d %H:%i:%s' <= $pack['endt']} class="active"{/if}>
          <td>{$pack['stdt']}</td>
          <td>{$pack['title']}</td>
          <td><a href="/board/post-{$pack['post_id']}">{$pack['advTitle']}</a></td>
          <td>{$pack['endt']}</td>
          <td>{$pack['cost']}</td>
        </tr>
        {foreachelse}
        <td colspan="5" class="text-center">На даный момент Вы не приобрели ни одного улучшения.</td>
        {/foreach}
      </tbody>
    </table>
  </div>
  {/if}
</div>