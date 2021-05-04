<div class="submenu d-none d-sm-block text-center">
  <a href="/u/">Авторизация</a>
  <a href="/u/contacts" class="active">Контакты</a>
  <a href="/u/notify">Уведомления</a>
  <a href="/u/reviews">Отзывы</a>
  <a href="/u/company">Компания</a>
  {if $user->company neq null}
  <a href="/u/news">Новости</a>
  <a href="/u/vacancy">Вакансии</a>
  {/if}
</div>
<div class="container mt-4 mb-5">
  <div class="dep mx-sm-5 text-center text-sm-left">
    <a href="/u/contacts"{if $dep === 0} class="active"{/if}>Главный офис</a>
    <a href="/u/contacts?dep=1"{if $dep === '1'} class="active"{/if}>Отдел закупок</a>
    <a href="/u/contacts?dep=2"{if $dep === '2'} class="active"{/if}>Отдел продаж</a>
    <a href="/u/contacts?dep=3"{if $dep === '3'} class="active"{/if}>Отдел услуг</a>
    <a href="/u/contacts?dep=999"{if $dep === '999'} class="active"{/if}>Telegram/Viber</a>
  </div>
  {if $dep eq 0}
    {include file="user/contacts_main.tpl"}
  {elseif $dep == 999}
    {include file="user/contacts_im.tpl"}
  {else}
    {include file="user/contacts_dep.tpl"}
  {/if}
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
<div class="modal fade" id="changePhone" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form class="form modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3" id="exampleModalLabel">Изменение номера телефона</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center mx-2">
          Укажите Ваш новый номер номер телефона в поле ниже:
          <div class="form-group my-3 col-12 col-sm-6 offset-sm-3">
            <input type="text" class="form-control newPhone" name="newPhone">
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary px-5 send-phone" data-loading="<span class='spinner-border spinner-border-sm'></span> Отправка...">Отправить</button>
      </div>
    </form>
  </div>
</div>
<div class="modal fade codeModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form class="form modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3" id="exampleModalLabel">Подтверждение номера телефона</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center mx-2">
          Мы отправили смс на номер <span class="phone"></span> <br>с кодом подтверждения. Пожалуйста, введите его в поле ниже:
          <div class="form-group my-3 col-12 col-sm-4 offset-sm-4">
            <input type="text" class="form-control code text-center" placeholder="Код" name="code">
          </div>
          <a href="#" rel="nofollow" class="repeat-code small">Отправить ещё раз.</a>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary px-5 send-code" data-loading="<span class='spinner-border spinner-border-sm'></span> Проверка...">Отправить</button>
      </div>
    </form>
  </div>
</div>
