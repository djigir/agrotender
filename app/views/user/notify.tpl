<div class="submenu d-none d-sm-block text-center">
  <a href="/u/">Авторизация</a>
  <a href="/u/contacts">Контакты</a>
  <a href="/u/notify" class="active">Уведомления</a>
  <a href="/u/reviews">Отзывы</a>
  <a href="/u/company">Компания</a>
  {if $user->company neq null}
  <a href="/u/news">Новости</a>
  <a href="/u/vacancy">Вакансии</a>
  {/if}
</div>
<div class="container mt-4 mb-5">
  <h2 class="mx-5">Доска объявлений</h2>
  <form class="content-block mt-4 mb-4 mx-2 mx-sm-5 py-4 px-4 px-sm-5 personal">
    <b>Выберите, какие уведомления вы хотите получать:</b>
    <hr>
    <div class="custom-control custom-checkbox px-sm-5">
      <input type="checkbox" name="up" value="1" class="custom-control-input upAdv advSub" id="up"{if $user->sub['up'] eq 1} checked{/if}>
      <label class="custom-control-label" for="up">Бесплатное поднятие объявлений</label>
    </div>
    <div class="custom-control custom-checkbox mt-2 px-sm-5">
      <input type="checkbox" name="deact" value="1" class="custom-control-input deactAdv advSub" id="deact"{if $user->sub['deact'] eq 1} checked{/if}>
      <label class="custom-control-label" for="deact">Деактивация объявлений</label>
    </div>
  </form>
  <h2 class="mx-5">Цены трейдеров</h2>
  <div class="content-block mt-4 mb-4 mx-2 mx-sm-5 py-4 px-4 px-sm-5 personal">
    <div class="row">
    <div class="col-12 col-sm-6 px-0 pr-sm-4">
      <label class="col-form-label"><b>Выберите рубрику:</b></label>
      <select class="form-control" name="rubric">
        {foreach $rubrics as $group}
        <optgroup label="{$group['name']}">
          {foreach $group['rubrics'] as $rubric}
          <option value="{$rubric['id']}">{$rubric['name']}</option>
          {/foreach}
        </optgroup>
        {/foreach}
      </select>
    </div>
    <div class="col-12 col-sm-6 px-0 pl-sm-2">
      <label class="col-form-label"><b>Выберите интенсивность:</b></label>
      <div class="mt-sm-2">
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" name="period" value="1" class="custom-control-input" id="per1" checked>
          <label class="custom-control-label" for="per1">Каждый час</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" name="period" value="24" class="custom-control-input" id="per2">
          <label class="custom-control-label" for="per2">Раз в день</label>
        </div>
      </div>
    </div>
    </div>
    <hr class="my-4 ">
    <div class="text-center col-12 col-sm-4 offset-sm-4">
      <button class="btn btn-block btn-primary save">Добавить рубрику</button>
    </div>
  </div>
  {if $activeSub}
  <h2 class="mx-5">Ваши подписки</h2>
  <div class="scroll-x mx-5 mt-4 pb-4 px-2">
    <table class="sortTable">
      <thead>
        <th>Рубрика</th>
        <th>Частота</th>
        <th>Активная</th>
        <th>Действует до:</th>
        <th>Действия</th>
      </thead>
      <tbody>
        {foreach $activeSub as $sub}
        <tr>
          <td><a href="/traders/{$sub['url']}" target="_blank">{$sub['gname']} > {$sub['cultname']}</a></td>
          <td>{if $sub['period'] eq 1}Каждый час{else}Раз в день{/if}</td>
          <td>{if $sub['active'] eq 1}Да{else}Нет{/if}</td>
          <td>{$sub['untildt']}</td>
          <td>{if $sub['active'] eq 0}<a href="#" class="upSub" subId="{$sub['subid']}">Продлить</a><br>{/if}<a href="#" class="removeSub" subId="{$sub['subid']}">Удалить</a></td>
        </tr>
        {/foreach}
      </tbody>
    </table>
  </div> 
  {/if}
</div>