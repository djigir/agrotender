<div class="submenu d-none d-sm-block text-center">
  <a href="/u/">Авторизация</a>
  <a href="/u/contacts">Контакты</a>
  <a href="/u/notify">Уведомления</a>
  <a href="/u/reviews">Отзывы</a>
  <a href="/u/company" class="active">Компания</a>
  {if $user->company neq null}
  <a href="/u/news">Новости</a>
  <a href="/u/vacancy">Вакансии</a>
  {/if}
</div>
<div class="container mt-4 mb-5">
  <div class="content-block px-5 py-4 company-settings position-relative">
  	<h2>Настройки компании {if $user->company neq null}{if $user->company['visible'] eq 1}<button class="btn setVisible red float-right d-none d-sm-inline-block" visible="0">Скрыть компанию</button><a class="setVisible d-inline-block d-sm-none" href="#" visible="0"><i class="far fa-eye-slash"></i></a>{else}<button class="btn setVisible green float-right d-none d-sm-inline-block" visible="1">Показывать компанию</button><a class="setVisible d-inline-block d-sm-none" href="#" visible="1"><i class="far fa-eye"></i></a>{/if}{/if}</h2>
  	<form class="form company-form mt-4">
      <div class="form-group row mt-4">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Название компании <span class="text-danger">*</span></label>
        <div class="col-sm-4 pl-1">
          <input type="text" class="form-control" placeholder="Город" name="title"{if $user->company neq null} value="{$user->company['title']}"{/if}>
        </div>
      </div>
      <div class="form-group row mt-4">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Логотип</label>
        <div class="col-sm-4 pl-1 d-flex align-items-center">
          <img class="logo" src="{if $user->company neq null and $user->company['logo_file'] neq null}/{$user->company['logo_file']}{else}/app/assets/img/noavatar.png{/if}">
          <span class="ml-3 select-image">Выбрать изображение</span>
          <input type="file" name="logo" class="d-none">
        </div>
      </div>
      <div class="form-group row mt-4">
        <label class="col-sm-4 col-form-label d-flex align-items-start justify-content-start justify-content-sm-end">О компании <span class="text-danger">*</span></label>
        <div class="col-sm-7 d-flex align-items-center pl-1">
          <textarea class="form-control" name="content" id="content" rows="9" placeholder="Введите Ваше описание">{if $user->company neq null}{$user->company['content']}{/if}</textarea>
        </div>
      </div>
      <hr class="my-4">
      <div class="form-group row mt-4">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Индекс</label>
        <div class="col-sm-4 pl-1">
          <input type="text" class="form-control" placeholder="Индекс" name="zipcode"{if $user->company neq null} value="{$user->company['zipcode']}"{/if}>
        </div>
      </div>
      <div class="form-group row mt-4">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Область <span class="text-danger">*</span></label>
        <div class="col-sm-4 pl-1">
          <select class="form-control" name="region">
            {foreach $regions as $region}
            <option value="{$region['id']}"{if $user->company neq null && $user->company['obl_id'] eq $region['id']} selected{/if}>{$region['name']}{if $region['id'] neq 1} область{/if}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <div class="form-group row mt-4">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Город <span class="text-danger">*</span></label>
        <div class="col-sm-4 pl-1">
          <input type="text" class="form-control" placeholder="Город" name="city"{if $user->company neq null} value="{$user->company['city']}"{/if}>
        </div>
      </div>
      <div class="form-group row mt-4">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Адрес</label>
        <div class="col-sm-4 pl-1">
          <input type="text" class="form-control" placeholder="Адрес" name="addr"{if $user->company neq null} value="{$user->company['addr']}"{/if}>
        </div>
      </div>
      <hr class="my-4">
      <h3>Продукция</h3>
      <span class="desc extra-small">Выберите до 5 видов деятельности Вашей компании</span>
      <div class="text-center pl-0 pl-sm-5 mt-3">
      	<div class="rubrics-wrap d-inline-block pl-0 pl-sm-5">
      	{foreach $rubrics as $group}
        <div class="rubric-col pr-0 pr-sm-4">
          <span class="rubric-title">{$group['title']}</span>
          {foreach $group['rubrics'] as $rubric}
      	  <div class="rubric-item">
      		<input class="custom-control-input rubric-input" type="checkbox" value="{$rubric['id']}" name="rubrics[]" id="rubric{$rubric['id']}"{if $user->company neq null && $rubric['id']|in_array:$user->company['topics']} checked{/if}>
            <label class="custom-control-label" for="rubric{$rubric['id']}">
              {$rubric['title']}
            </label>
      	  </div>
      	{/foreach}
      </div>
      {/foreach}
      </div>
      </div>
  	</form>
  </div>
  <div class="comp-rules mt-4 text-center">
  	<div><span>Я обязуюсь соблюдать</span> <a href="/info/orfeta#p4" target="_blank">правила размещения компании</a>.</div>
  	<button class="btn btn-primary px-5 text-center mt-3 save-comp">Сохранить</button>
  </div>
</div>