<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-8 offset-sm-2 mt-2 mt-sm-5 pt-0 pt-sm-5">
      <h2>Авторизация</h2>
      <form class="form sign-in">
        <div class="content-block mt-4 p-3 p-sm-5">
          <div class="form-group row mb-3 mb-sm-4">
            <label class="col-sm-4 col-form-label text-left text-sm-right">Email</label>
            <div class="col-sm-6">
              <input type="email" class="form-control" placeholder="Email" name="email" id="email">
            </div>
          </div>
          <div class="form-group row mt-3 mt-sm-3 mb-0">
            <label class="col-sm-4 col-form-label text-left text-sm-right">Пароль</label>
            <div class="col-sm-6">
              <input type="password" class="form-control" placeholder="Пароль" name="password" id="password">
              <a href="/buyerpassrest" class="forgot-password">Не можете войти?</a>
            </div>
          </div>
          <button type="submit" href="#" class="top-btn btn btn-primary align-bottom mt-4 d-block d-sm-none">
            <span class="pl-1 pr-1 btn-text">Войти</span>
            <span class="spinner-border spinner-border-sm btn-loading" role="status" aria-hidden="true"></span>
          </button>
        </div>
        <div class="mt-4 mb-4 text-center text-sm-left">
          <a href="/buyerreg" class="d-block d-sm-inline-block mb-4"><i class="fal fa-chevron-left mr-1"></i> <span>Создать аккаунт</span></a>
          <button type="submit" href="#" class="top-btn btn btn-primary align-bottom mb-5 mb-sm-0 float-right d-none d-sm-inline-block">
            <span class="pl-1 pr-1 btn-text">Войти</span>
            <span class="spinner-border spinner-border-sm btn-loading" role="status" aria-hidden="true"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>