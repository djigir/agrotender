<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-10 offset-sm-1 mt-4">
      <h2>Регистрация</h2>
      <form class="form sign-up">
        <div class="content-block mt-4 p-4 p-sm-5">
          <div class="form-group row mb-4 pb-1">
            <label class="col-sm-4 col-form-label text-left text-sm-right">Email</label>
            <div class="col-sm-5" data-tip="Введите e-mail, на который будет отправлена ссылка активации аккаунта. &#13;&#10;Этот e-mail не будет виден другим пользователям.">
              <input type="email" class="form-control" placeholder="Email" name="email" id="email">
              <span class="error-text"></span>
            </div>
          </div>
          <div class="form-group row my-4 py-1">
            <label class="col-sm-4 col-form-label text-left text-sm-right">Пароль</label>
            <div class="col-sm-5" data-tip="Введите пароль, от 6 до 20 символов">
              <div class="input-group">
                <input type="password" class="form-control password" placeholder="Пароль" name="password" id="password">
                <span class="input-group-btn">
                <button type="button" class="form-control show-password">
                <i class="far fa-eye"></i>
                </button>
                </span>
              </div>
            </div>
          </div>
<!--           <div class="form-group row my-4 py-1">
            <label class="col-sm-4 col-form-label text-left text-sm-right">Повторите пароль</label>
            <div class="col-sm-5">
              <div class="input-group">
                <input type="password" class="form-control password" placeholder="Повторите пароль" name="rePassword" id="rePassword">
                <span class="input-group-btn">
                <button type="button" class="form-control show-password">
                <i class="far fa-eye"></i>
                </button>
                </span>
              </div>
            </div>
          </div> -->
          <div class="form-group row my-4 py-1">
            <label class="col-sm-4 col-form-label text-left text-sm-right">Контактное лицо</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" placeholder="Как к Вам обращаться" name="name" id="name">
            </div>
          </div>
          <div class="form-group row my-4 py-1">
            <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон</label>
            <div class="col-sm-5">
              <input type="text" class="form-control phone" placeholder="Телефон" name="phone" id="phone">
            </div>
          </div>
          <!-- <div class="form-group row mt-4 pt-1">
            <label class="col-sm-4 col-form-label text-left text-sm-right">Область</label>
            <div class="col-sm-5">
              <select class="form-control" name="region" id="region">
                <option value="" disabled selected>Выберите Вашу область</option>
                {foreach $regions as $region}
                <option value="{$region['id']}">{$region['name']}{if $region['id'] neq 1} область{/if}</option>
                {/foreach}
              </select>
            </div>
          </div> -->
          <button type="submit" href="#" class="top-btn btn btn-primary align-bottom mt-4 d-block d-sm-none">
            <span class="pl-1 pr-1 btn-text">Зарегистрироваться</span>
            <span class="spinner-border spinner-border-sm btn-loading" role="status" aria-hidden="true"></span>
          </button>
        </div>
        <div class="mt-4 mb-4 text-center text-sm-left">
          <a href="/buyerlog" class="d-block d-sm-inline-block mb-4"><i class="fal fa-chevron-left"></i> <span>Вход</span></a>
          <button type="submit" href="#" class="top-btn btn btn-primary align-bottom mb-5 mb-sm-0 float-right d-none d-sm-inline-block">
            <span class="pl-1 pr-1 btn-text">Зарегистрироваться</span>
            <span class="spinner-border spinner-border-sm btn-loading" role="status" aria-hidden="true"></span>
          </button>
        </div>
      </form>
    </div>
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
        <button type="button" class="btn btn-primary px-5 send-code">Отправить</button>
      </div>
    </form>
  </div>
</div>