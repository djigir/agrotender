<div class="submenu d-none d-sm-block text-center mt-4">
  {if $company['trader_price_avail'] neq 0 && $company['trader_price_visible'] neq 0 && $issetT1 neq null}
  <a href="/kompanii/comp-{$company['id']}-prices">Таблица закупок</a>
  {/if}
  {if $company['trader_price_sell_avail'] neq 0 && $company['trader_price_sell_visible'] neq 0 && $issetT2 neq null}
  <a href="/kompanii/comp-{$company['id']}-prices?type=1">Таблица продаж</a>
  {/if}
  <a href="/kompanii/comp-{$company['id']}-traderContacts" class="active">Контакты трейдера</a>
</div>
<div class="container mb-5">
  <h2 class="mt-4">Контакты трейдера</h2>
{if ($company['trader_price_avail'] == 1 or $company['trader_price_sell_avail'] == 1) and $traderContacts neq null}
  {foreach $traderContacts as $place}
  <div class="content-block trader-contact py-3 px-4">
    <div class="place d-flex justify-content-between">
      <div class="title">
        <span>{$place['name']}</span>
      </div>
    </div>
    <div class="contacts mt-4">
      {foreach $place['contacts'] as $contact}
      <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
        {if $contact['dolg'] neq null or $contact['fio'] neq null}
        <div class="row m-0 px-3 px-sm-0">
          <div class="col p-0">
            {if $contact['dolg'] neq null}<b>{$contact['dolg']|strip_tags}:</b>{/if}{if $detect->isMobile()}<br>{/if} &nbsp;<span class="name">{if $contact['fio'] neq null}{$contact['fio']|strip_tags}{/if}</span>
          </div>
        </div>
        {/if}
        <div class="row m-0 justify-content-center">
          <div class="col-auto pr-2 text-center">
            <span class="phone">{if $contact['phone'] neq null}{$contact['phone']|strip_tags}{/if}</span>
          </div>
          {if $contact['email'] neq null}
          <div class="col-auto pl-2 text-center">
            <b>Email:</b> &nbsp;<span class="email">{if $contact['email'] neq null}{$contact['email']|strip_tags}{/if}</span>
          </div>
          {/if}
        </div>
      </div>
      {/foreach}
    </div>
  </div>
  {/foreach}
  {else}
  <div class="content-block trader-contact py-3 px-4 text-center">
    <b>Список контактов пуст :(</b>
  </div>
  {/if}
</div>