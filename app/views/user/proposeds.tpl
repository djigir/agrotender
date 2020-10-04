<div class="container d-flex justify-content-between mt-3 mt-sm-0">
  <div class="submenu d-none d-sm-inline-block text-left">
    {if $user->company neq null && ($user->company['trader_price_avail'] or $user->company['trader_price_sell_avail'])}
    <a href="/u/proposeds"{if $type eq 0} class="active"{/if}>Входящие заявки: {$count['rec']}</a>
    {/if}
    <a href="/u/proposeds?type=1"{if $type eq 1} class="active"{/if}>Исходящие заявки: {$count['send']}</a>
  </div>
  <div class="d-inline-block dep text-center text-sm-right">
    <a href="/u/proposeds{if $type eq 1}?type=1{/if}"{if $status eq 0} class="active"{/if}>Все</a>
    <a href="/u/proposeds?status=1{if $type eq 1}&type=1{/if}"{if $status eq 1} class="active"{/if}">Активные</a>
    <a href="/u/proposeds?status=-1{if $type eq 1}&type=1{/if}"{if $status eq '-1'} class="active"{/if}">Завершённые</a>
  </div>
</div>
<div class="container mt-4 mb-5">
  <div class="scroll-x mt-3 pb-3">
  	<table class="sortTable proposedTable fixed-table">
  	  <thead>
  	  	<th>Дата</th>
        <th>Культура</th>
        <th>{if $type eq 1}Трейдер{else}Отправитель{/if}</th>
        <th>Объём</th>
        <th>Цена</th>
        <th>Область</th>
        <th>Описание</th>
        <th>Действия</th>
  	  </thead>
  	  <tbody>
  	  	{foreach $proposeds as $proposed}
        <tr{if isset($proposed['viewed']) && $proposed['viewed'] eq '0'} class="not-viewed"{/if}>
          <td>{$proposed['add_date']}</td>
          <td>{$proposed['rubric']}</td>
          <td>
            {if $type eq 1}
            <a href="#" class="showTraders" data-id="{$proposed['id']}">Посмотреть</a>
            {else}
              {if $proposed['company_id'] eq null}
              <span class="d-block">{$proposed['company']}</span>
              <span class="d-block">{$proposed['phone']}</span>
              {else}
            <a class="d-block" href="/kompanii/comp-{$proposed['company_id']}" target="_blank">{$proposed['company']}</a>
            <span class="d-block">{$proposed['phone']}</span>
              {/if}
            {/if}
          </td>
          <td>{$proposed['amount']}</td>
          <td>{$proposed['cost']}</td>
          <td>{$proposed['region']}</td>
          <td><a href="#" class="showComment" data-toggle="popover" data-placement="bottom" data-content="{$proposed['comment']}">Посмотреть</a></td>
          <td>
            {if $type eq 1}
            {if $proposed['status'] eq 0}
            <a href="#" class="getProposedTraders" data-id="{$proposed['id']}">Продано</a>
            <a href="#" class="removeProposed text-danger" data-id="{$proposed['id']}">Удалить</a>
            {else}
            <b>Подтверждена</b>
            {/if}
            {else}
            {if $proposed['p_status'] eq 0 or $proposed['p_status'] eq 1}
            <a href="#" class="cancelProposed text-danger" data-id="{$proposed['id']}">Отклонить</a>
            {else}
            <b class="text-danger">Отклонено</b>
            {/if}
            {/if}
          </td>
        </tr>
        {foreachelse}
        <tr>
          <td colspan="8">Список пуст</td>
        </tr>
        {/foreach}
  	  </tbody>
  	</table>
  </div>
  {if $proposeds neq null && $totalPages > 1}
  <div class="row mx-0 mt-4">
    <div class="col-12 pagination d-block text-center">
      {if $pageNumber eq null}
        {assign "page" "1"}
      {else}
        {assign "page" $pageNumber}
      {/if}
      {if $page neq 1}
      <a href="/u/proposeds?{if $status neq 0}status={$status}&{/if}{if $type neq 0}type={$type}&{/if}p={$page - 1}"><span class="mr-1"><i class="far fa-chevron-left"></i></span> <span class="d-none d-sm-inline-block">Предыдущая</span></a>
      {/if}
      {if ($page - 3) ge 1}
      <a class="mx-1" href="/u/proposeds{if $status neq 0}?status={$status}{/if}{if $type neq 0}{if $status neq 0}&{else}?{/if}type={$type}{/if}">1</a>
      ..
      {/if}
      {if ($page - 2) gt 0}
      <a class="d-none d-sm-inline-block mx-1" href="/u/proposeds?{if $status neq 0}status={$status}&{/if}{if $type neq 0}type={$type}&{/if}p={$page - 2}">{$page - 2}</a>
      {/if}
      {if ($page - 1) gt 0}
      <a class="d-none d-sm-inline-block mx-1" href="/u/proposeds?{if $status neq 0}status={$status}&{/if}{if $type neq 0}type={$type}&{/if}p={$page - 1}">{$page - 1}</a>
      {/if}
      <a href="#" class="active mx-1">{$page}</a>
      {if ($page + 1) le $totalPages}
      <a class="d-none d-sm-inline-block mx-1" href="/u/proposeds?{if $status neq 0}status={$status}&{/if}{if $type neq 0}type={$type}&{/if}p={$page + 1}">{$page + 1}</a>
      {/if}
      {if ($page + 2) le $totalPages}
      <a class="d-none d-sm-inline-block mx-1" href="/u/proposeds?{if $status neq 0}status={$status}&{/if}{if $type neq 0}type={$type}&{/if}p={$page + 2}">{$page + 2}</a>
      {/if}
      {if ($page + 3) le $totalPages}
      ..
      <a class="mx-1" href="/u/proposeds?{if $status neq 0}status={$status}&{/if}{if $type neq 0}type={$type}&{/if}p={$totalPages}">{$totalPages}</a>
      {/if}
      {if $page neq $totalPages}
      <a href="/u/proposeds?{if $status neq 0}status={$status}&{/if}{if $type neq 0}type={$type}&{/if}p={$page + 1}"><span class="d-none d-sm-inline-block">Следующая</span> <span class="ml-1"><i class="far fa-chevron-right"></i></span></a>
      {/if}
    </div>
  </div>
  {/if}
</div>
<div class="modal fade" id="tradersModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3">Список трейдеров</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mt-2">
        <div class="row m-0 justify-content-start">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="acceptModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <form class="form modal-content accept">
      <div class="modal-header">
        <h5 class="modal-title ml-3">Список трейдеров</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row m-0 list pl-3">
          <div class="col-12">
            <div class="list-items"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center pt-2">
        <button type="button" class="btn btn-block btn-primary px-5 accept-proposed">Отправить</button>
      </div>
    </form>
  </div>
</div>