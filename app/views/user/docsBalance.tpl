<div class="submenu d-none d-sm-block text-center">
  <a href="/u/posts/limits">Лимит объявлений</a>
  <a href="/u/posts/upgrade">Улучшения объявлений</a>
  <a href="/u/balance/pay">Пополнить баланс</a>
  <a href="/u/balance/history">История платежей</a>
  <a href="/u/balance/docs" class="active">Счета/акты</a>
</div>
<div class="container mt-4 mb-5">
  <h2>Список счетов/актов</h2>
  <div class="scroll-x mt-1 py-3">
  	<table class="sortTable">
  	  <thead>
  	  	<th>Дата</th>
  	  	<th>Тип</th>
  	  	<th>Счёт №</th>
  	  	<th>Статус</th>
  	  	<th>Сумма</th>
  	  	<th>Плательщик</th>
  	  	<th>Действия</th>
  	  </thead>
  	  <tbody>
  	  	{foreach $docs as $doc}
  	  	<tr>
  	  	  <td><b>{$doc['add_date']}</b></td>
  	  	  <td>{$doc['docType']}</td>
  	  	  <td><b>{$doc['bill_id']}</b></td>
  	  	  <td><b>{$doc['billstatus']}</b></td>
  	  	  <td><b>{$doc['amount']}</b></td>
  	  	  <td>{$doc['otitle']}</td>
  	  	  <td><a href="/{$doc['filename']}" target="_blank"><u>Посмотреть</u></td>
  	  	</tr>
  	  	{foreachelse}
  	  	<tr>
  	  	  <td colspan="7">Список счетов пуст.</td>
  	  	</tr>
  	  	{/foreach}
  	  </tbody>
  	</table>
  </div>
</div>