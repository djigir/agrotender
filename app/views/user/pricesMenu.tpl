<div class="submenu d-none d-sm-block text-center" acttype="{$type}">
  {if $user->company['trader_price_forward_avail'] eq 1 }
  <a href="/u/prices/forwards"{if $active eq 'forwards' } class="active"{/if}>Форварды</a>
  {/if}
  {if $user->company['trader_price_avail'] neq 0}
  <a href="/u/prices"{if $active eq 'prices' and $type eq 0} class="active"{/if}>Таблица закупок</a>
  {/if}
  {if $user->company['trader_price_sell_avail'] neq 0}
  <a href="/u/prices?type=1"{if $active eq 'prices' and $type eq 1} class="active"{/if}>Таблица продаж</a>
  {/if}
  <a href="/u/prices/contacts"{if $active eq 'contacts' } class="active"{/if}>Контакты трейдера</a>
</div>