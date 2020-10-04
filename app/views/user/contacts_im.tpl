<div class="content-block trader-contact mx-sm-5 py-3 px-4">
  <div class="place d-flex justify-content-between">
    <div class="title">
      <span>{$depName}</span>
    </div>
  </div>
  <div class="contacts mt-4">
    <form class="im-dep">

      <div class="form-group row mb-4 pb-1">
        <label class="col-sm-4 col-form-label text-left text-sm-right" style="color: #1EACF8">Ники Telegram:<br><span class="small">формат: <b>@nickname1</b><br><b>@nickname2</b></span></label>
        <div class="col-sm-5">
          <textarea class="form-control" name="telegram" rows="6">{$user->telegram}</textarea>
        </div>
      </div>

      <div class="form-group row mb-4 pb-1">
        <label class="col-sm-4 col-form-label text-left text-sm-right" style="color: #7d50a2">Номера Viber:<br><span class="small">формат: <b>380501112233</b><br><b>380670001122</b></span></label>
        <div class="col-sm-5">
          <textarea class="form-control" name="viber" rows="6">{$user->viber}</textarea>
        </div>
      </div>

    </form>
  </div>
</div>

<div class="mt-4 text-center">
  <button class="btn btn-primary save-im px-5">Сохранить</button>
</div>
