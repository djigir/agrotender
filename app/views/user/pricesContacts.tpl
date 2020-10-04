
{include file="user/pricesMenu.tpl" active="contacts"}

<div class="container mt-4 px-sm-5 mb-5">
  {foreach $contacts as $place}
  <div class="content-block trader-contact mx-sm-5 py-3 px-4">
  	<div class="place d-flex justify-content-between">
  	  <div class="title">
  	  	<span>{$place['name']}</span>
  	  	<i class="fas fa-pencil-alt edit-place" place="{$place['id']}"></i>
  	  </div>
  	  <div class="manage">
  	  	<i class="fas fa-times remove-place" place="{$place['id']}"></i>
  	  </div>
  	</div>
    <div class="contacts mt-4">
      {foreach $place['contacts'] as $contact}
      <div class="contact my-3 text-center mx-5 px-4 position-relative">
      	<div class="row m-0">
      	  <div class="col p-0">
      	    <b>Контакное лицо:</b> &nbsp;<span class="name">{if $contact['fio'] neq null}{$contact['fio']}{else}—{/if}</span>
      	  </div>
        </div>
        <div class="row m-0">
          <div class="col pr-2 text-right">
      	    <b>Телефон:</b> &nbsp;<span class="phone">{if $contact['phone'] neq null}{$contact['phone']}{else}—{/if}</span>
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
          <i class="fas fa-pencil-alt edit-contact" contact="{$contact['id']}" place="{$place['id']}"></i>
          <i class="fas fa-times remove-contact mt-2" contact="{$contact['id']}" place="{$place['id']}"></i>
        </div>
      </div>
      {/foreach}
      <div class="text-center mt-4">
      	<button class="btn add-contact px-5" place="{$place['id']}">Добавить контакт</button>
      </div>
    </div>
  </div>
  {/foreach}
  <div class="text-center text-center mt-5 buttons">
  	<button class="btn btn-warning d-block d-sm-inline-block px-5 px-sm-3" data-toggle="modal" data-target="#placeModal">Добавить регион/точку приёмки</button>
  </div>
</div>
<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form class="form contact-form modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3">Контактные данные</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-4">
        <div class="form-group row mb-4 pb-1">
          <label class="col-sm-4 col-form-label text-left text-sm-right">Должность:</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" placeholder="Должность" name="post">
          </div>
        </div>
        <div class="form-group row mb-4 pb-1">
          <label class="col-sm-4 col-form-label text-left text-sm-right">Контактное лицо:</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" placeholder="Контактное лицо" name="name">
          </div>
        </div>
        <div class="form-group row mb-4 pb-1">
          <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" placeholder="Телефон" name="phone">
          </div>
        </div>
        <div class="form-group row mb-4 pb-1">
          <label class="col-sm-4 col-form-label text-left text-sm-right">E-mail:</label>
          <div class="col-sm-6">
            <input type="email" class="form-control" placeholder="E-mail" name="email">
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="submit" class="btn btn-block btn-primary px-5">Сохранить</button>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="editContact" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form class="form edit-contact-form modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3">Контактные данные</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-4">
        <div class="form-group row mb-4 pb-1">
          <label class="col-sm-4 col-form-label text-left text-sm-right">Должность:</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" placeholder="Должность" name="post">
          </div>
        </div>
        <div class="form-group row mb-4 pb-1">
          <label class="col-sm-4 col-form-label text-left text-sm-right">Контактное лицо:</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" placeholder="Контактное лицо" name="name">
          </div>
        </div>
        <div class="form-group row mb-4 pb-1">
          <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" placeholder="Телефон" name="phone">
          </div>
        </div>
        <div class="form-group row mb-4 pb-1">
          <label class="col-sm-4 col-form-label text-left text-sm-right">E-mail:</label>
          <div class="col-sm-6">
            <input type="email" class="form-control" placeholder="E-mail" name="email">
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="submit" class="btn btn-block btn-primary px-5">Сохранить</button>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="placeModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <form class="form modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3">Укажите регион/точку приёмки</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body py-0">
        <div class="form-group my-3">
          <input type="text" class="form-control place text-center" placeholder="Регион/точка приёмки">
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-block btn-primary px-5 add-place">Сохранить</button>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="editPlaceModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <form class="form modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3">Изменить название</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body py-0">
        <div class="form-group my-3">
          <input type="text" class="form-control place text-center" placeholder="Регион/точка приёмки">
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-block btn-primary px-5 save-place">Сохранить</button>
      </div>
    </form>
  </div>
</div>