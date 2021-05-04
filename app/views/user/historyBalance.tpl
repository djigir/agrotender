<div class="submenu d-none d-sm-block text-center">
  <a href="/u/posts/limits">Лимит объявлений</a>
  <a href="/u/posts/upgrade">Улучшения объявлений</a>
  <a href="/u/balance/pay">Пополнить баланс</a>
  <a href="/u/balance/history" class="active">История платежей</a>
  <a href="/u/balance/docs">Счета/акты</a>
</div>
<div class="container mt-4 mb-5">
  <h2>Список операций по счёту</h2>
  <div class="scroll-x py-4">
    <table class="sortTable">
      <thead>
        <th>Дата</th>
        <th>Назначение</th>
        <th>Сумма</th>
        <th>Счет</th>
      </thead>
      <tbody>
        {foreach $list as $row}
        <tr>
          <td>{$row['add_date']}</td>
          <td>{$row['purpose']}</td>
          <td>{$row['amount']}</td>
          <td>{if $row['file'] neq null}<a href="/{$row['file']}" target="_blank">{$row['bill_id']}</a>{else}-{/if}</td>
        </tr>
        {foreachelse}
        <td colspan="5" class="text-center">По Вашему счёта нет ни одной операции.</td>
        {/foreach}
      </tbody>
    </table>
  </div>
</div>