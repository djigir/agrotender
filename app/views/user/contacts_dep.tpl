<div class="content-block trader-contact mx-sm-5 py-3 px-4">
  <div class="place d-flex justify-content-between">
    <div class="title">
      <span>{$depName}</span>
    </div>
  </div>
  {foreach $contacts as $contact}
    <div class="contact my-3 text-center mx-5 px-4 position-relative">
      <div class="row m-0">
        <div class="col p-0">
          <b>Контакное лицо:</b> &nbsp;<span class="name">{if $contact['fio'] neq null}{$contact['fio']}{else}—{/if}</span>
        </div>
      </div>
      <div class="row m-0">
        <div class="col pr-2 text-right">
          <b>Телефон:</b> &nbsp;<span class="phone">{if $contact['phone'] neq null}{$contact['phone']|ltrim:'38'}{else}—{/if}</span>
        </div>
        <div class="col pl-2 text-left">
          <b>Email:</b> &nbsp;<span class="email">{if $contact['email'] neq null}{$contact['email']}{else}—{/if}</span>
        </div>
      </div>
      <div class="row m-0">
        <div class="col p-0">
          <b>Должность:</b> &nbsp;<span class="post">{if $contact['dolg'] neq null}{$contact['dolg']}{else}—{/if}</span>
        </div>
      </div>
      <div class="contact-manage d-flex flex-column">
        <i class="fas fa-pencil-alt edit-contact" contact="{$contact['id']}"></i>
        <i class="fas fa-times remove-contact mt-2" contact="{$contact['id']}"></i>
      </div>
    </div>
    {/foreach}
    <div class="text-center mt-4">
      <button class="btn add-contact px-5" data-toggle="modal" data-target="#contact">Добавить контакт</button>
    </div>
</div>
