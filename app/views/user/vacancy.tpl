<div class="submenu d-none d-sm-block text-center">
  <a href="/u/">Авторизация</a>
  <a href="/u/contacts">Контакты</a>
  <a href="/u/notify">Уведомления</a>
  <a href="/u/reviews">Отзывы</a>
  <a href="/u/company">Компания</a>
  {if $user->company neq null}
  <a href="/u/news">Новости</a>
  <a href="/u/vacancy" class="active">Вакансии</a>
  {/if}
</div>
<div class="container mt-4 mb-5 nv">
  <div class="content-block mx-0 mx-sm-5">
    <div class="pb-5 pt-4 px-4 lh-1">
      <div class="d-inline-block pt-3 pt-sm-2">
        <span>Всего вакансий: <span class="count"><b>{$vacancy|@count}</b></span></span>
      </div>
      <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addVacancy">Добавить вакансию</button>
    </div>
    {foreach $vacancy as $n}
    <div class="block row py-4 px-4 mx-0">
      <div class="col-3 col-sm-auto p-0">
        <span class="date small">{$n['add_date']}</span>
      </div>
      <div class="col-7 col-sm pl-4">
        <span class="d-block title"><b>{$n['title']}</b></span>
      </div>
      <div class="col-2 col-sm-auto">
        <i class="fas fa-pencil-alt edit edit cursor-pointer mr-2" vacancyId="{$n['id']}"></i>
        <i class="fas fa-times remove text-danger cursor-pointer" vacancyId="{$n['id']}"></i>
      </div>
    </div>
    {foreachelse}
    <div class="block row py-4 px-4 mx-0 justify-content-center">
      Список вакансий пуст
    </div>
    {/foreach}
  </div>
</div>
<div class="modal fade" id="addVacancy" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form class="form modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3">Добавить новость</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-4">
        <div class="form-group">
          <label class="col col-form-label">Заголовок <span class="text-danger">*</span></label>
          <div class="col pl-1">
            <input type="text" class="form-control" placeholder="Заголовок" name="title">
          </div>
        </div>
        <div class="form-group">
          <label class="col col-form-label">Описание <span class="text-danger">*</span></label>
          <div class="col pl-1">
            <textarea class="form-control" rows="7" name="description"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="submit" class="btn btn-block btn-primary px-5 add-vacancy">Отправить</button>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="editVacancy" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form class="form modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3">Редактирование новости</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-4">
        <div class="form-group">
          <label class="col col-form-label">Заголовок <span class="text-danger">*</span></label>
          <div class="col pl-1">
            <input type="text" class="form-control" placeholder="Заголовок" name="title">
          </div>
        </div>
        <div class="form-group">
          <label class="col col-form-label">Описание <span class="text-danger">*</span></label>
          <div class="col pl-1">
            <textarea class="form-control" rows="7" name="description"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="submit" class="btn btn-block btn-primary px-5 edit-vacancy">Сохранить</button>
      </div>
    </form>
  </div>
</div>