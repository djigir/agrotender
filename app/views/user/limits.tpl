<div class="submenu d-none d-sm-block text-center">
  <a href="/u/posts/limits" class="active">Лимит объявлений</a>
  <a href="/u/posts/upgrade">Улучшения объявлений</a>
  <a href="/u/balance/pay">Пополнить баланс</a>
  <a href="/u/balance/history">История платежей</a>
  <a href="/u/balance/docs">Счета/акты</a>
</div>
<div class="container mt-4">
  <h2>Активные пакеты</h2>
  <div class="scroll-x mt-3 pb-3">
  	<table class="sortTable">
  	  <thead>
  	  	<th>Пакет</th>
  	  	<th>Действителен с</th>
  	  	<th>Действителен до</th>
  	  	<th>Цена</th>
  	  </thead>
  	  <tbody>
  	  	{foreach $activePacks as $pack}
  	  	<tr>
  	  	  <td><b>{$pack['title']}</b></td>
  	  	  <td>{$pack['stdt']}</td>
  	  	  <td>{$pack['endt']}</td>
  	  	  <td><b>{$pack['cost']}</b></td>
  	  	</tr>
        {foreachelse}
        <td colspan="4">На данный момент у Вас нет активных увеличений лимитов</td>
  	  	{/foreach}
  	  </tbody>
  	</table>
  </div>
</div>
<div class="container mt-2 mb-5 limits">
  <h2 class="d-flex align-items-end w-100 justify-content-between"><span>Увеличить лимит объявлений</span> <a href="https://agrotender.com.ua/info/limit_adv#p2" class="small">Подробнее о лимитах</a></h2>
  <div class="packs mt-3">
  	{foreach $packs as $pack}
  	<div class="content-block px-4 pack-block d-flex align-items-center row mx-0 my-3 py-3 noselect pack" pack-id="{$pack['id']}">
        <div class="col p-0 d-flex align-items-center lh-1">
          <span class="dot mr-3"></span> <span class="py-3">{$pack['title']}</span>
        </div>
        <div class="col-auto p-0 text-right">
          <div class="right-side d-flex">
            <span class="price"><span class="cost">{$pack['cost']|intval}</span><span class="currency ml-1">грн</span></span>
          </div>
        </div>
      </div>
    {/foreach}
  </div>
  <div class="totalPrice row mx-0 mt-5 justify-content-end">
      <div class="px-4 py-2 text-right content-block ">
        <div class="right-side d-flex align-items-center justify-content-center lh-1">
          <span class="text">Всего к оплате: </span>
          <span class="price ml-3"><span class="cost">0</span><span class="currency ml-1">грн</span></span>
        </div>
      </div>
      <button class="btn payBtn ml-4 px-5 mt-3 mt-sm-0">Оплатить</button>
    </div>
</div>