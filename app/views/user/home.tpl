<div class="submenu d-none d-sm-block text-center">
  <a href="/u/" class="active">Авторизация</a>
  <a href="/u/contacts">Контакты</a>
  <a href="/u/notify">Уведомления</a>
  <a href="/u/reviews">Отзывы</a>
  <a href="/u/company">Компания</a>
  {if $user->company neq null}
  <a href="/u/news">Новости</a>
  <a href="/u/vacancy">Вакансии</a>
  {/if}
</div>
<div class="container mt-4 mb-5">
  <h2 class="mx-0 mx-sm-5">Ваши личные данные</h2>
  <div class="content-block mt-4 px-5 py-3 personal mx-0 mx-sm-5">
  	<div class="pt-2 row d-block d-sm-flex mx-sm-0">
  		<b>Ваш текущий логин:</b> &nbsp;<span class="d-block d-sm-inline-block">{$user->email}</span>
  	</div>
    <hr class="my-4">
  	<h5>Сменить пароль</h5>
  	<form class="form change-password mt-0 mt-sm-3">
  	  <div class="form-group row d-flex align-items-center py-1 mb-2 mt-2">
        <label class="col-12 col-sm-4 col-form-label text-left text-sm-right px-0"><b>Старый пароль:</b></label>
        <div class="col-12 col-sm-5 pl-0 pl-sm-2">
        	<div class="input-group">
            <input type="password" class="form-control password" placeholder="Старый пароль" name="oldPassword" id="oldPassword">
            <span class="input-group-btn">
              <button type="button" class="form-control show-password">
                <i class="far fa-eye"></i>
              </button>
            </span>
          </div>
        </div>
      </div>
      <div class="form-group row d-flex align-items-center py-1 mb-2 mt-2">
        <label class="col-12 col-sm-4 col-form-label text-left text-sm-right px-0"><b>Новый пароль:</b></label>
        <div class="col-12 col-sm-5 pl-0 pl-sm-2">
          <div class="input-group">
            <input type="password" class="form-control password" placeholder="Новый пароль" name="password" id="password">
            <span class="input-group-btn">
              <button type="button" class="form-control show-password">
                <i class="far fa-eye"></i>
              </button>
            </span>
          </div>
        </div>
      </div>
      <div class="text-center col-12 col-sm-4 offset-sm-4 pt-3 pb-2">
      	<button type="submit" class="btn btn-success btn-block">Сохранить</button>
      </div>
  	</form>
  	<hr class="my-4">
  	<h5>Задать новый логин</h5>
  	<form class="form change-login mt-0 mt-sm-3">
      <div class="form-group row d-flex align-items-center py-1 mb-2 mt-2">
        <label class="col-12 col-sm-4 col-form-label text-left text-sm-right px-0"><b>Новый логин:</b></label>
        <div class="col-12 col-sm-5 pl-0 pl-sm-2">
          <input type="email" class="form-control" placeholder="Новый логин" name="email" id="email">
        </div>
      </div>
      <div class="text-center col-12 col-sm-4 offset-sm-4 pt-3 pb-2">
      	<button type="submit" class="btn btn-success btn-block">Сохранить</button>
      </div>
  	</form>
  </div>
</div>