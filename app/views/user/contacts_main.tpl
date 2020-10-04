<div class="content-block trader-contact mx-sm-5 py-3 px-4">
  <div class="place d-flex justify-content-between">
    <div class="title">
      <span>{$depName}</span>
    </div>
  </div>
  <div class="contacts mt-4">
    <form class="main-dep">
      <div class="form-group row mb-4 pb-1">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Контактное лицо:</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" placeholder="Контактное лицо" name="name" value="{$user->name}">
        </div>
      </div>
      <div class="form-group row mb-4 pb-1">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" placeholder="Телефон" name="phone" value="{$user->phone|ltrim:'38'}" disabled> <a href="#" class="changePhone" data-toggle="modal" data-target="#changePhone"><i class="fas fa-pencil"></i></a>
        </div>
      </div>
      <hr>
      <div class="form-group row mb-4 pb-1">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Контактное лицо:</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" placeholder="Контактное лицо" name="name2" value="{$user->name2}">
        </div>
      </div>
      <div class="form-group row mb-4 pb-1">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" placeholder="Телефон" name="phone2" value="{$user->phone2|ltrim:'38'}">
        </div>
      </div>
      <hr>
      <div class="form-group row mb-4 pb-1">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Контактное лицо:</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" placeholder="Контактное лицо" name="name3" value="{$user->name3}">
        </div>
      </div>
      <div class="form-group row mb-4 pb-1">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" placeholder="Телефон" name="phone3" value="{$user->phone3|ltrim:'38'}">
        </div>
      </div>
      <hr>
      <div class="form-group row mb-4 pb-1">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Email для публикаций:</label>
        <div class="col-sm-5">
          <input type="email" class="form-control" placeholder="Email" name="publicEmail" value="{$user->publicEmail}">
        </div>
      </div>
      <div class="form-group row mb-4 pb-1">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Область:</label>
        <div class="col-sm-5">
          <select class="form-control" name="region">
            {foreach $regions as $region}
            <option value="{$region['id']}"{if $user->region eq $region['id']} selected{/if}>{$region['name']}{if $region['id'] neq 1} область{/if}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <div class="form-group row mb-4 pb-1">
        <label class="col-sm-4 col-form-label text-left text-sm-right">Населённый пункт:</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" placeholder="Населённый пункт" name="city" value="{$user->city}">
        </div>
      </div>
    </form>
  </div>
</div>
<div class="mt-4 text-center">
  <button class="btn btn-primary save px-5">Сохранить</button>
</div>
