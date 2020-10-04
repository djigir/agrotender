<div class="container elevItem pt-3 mb-5">
  <ul class="breadcrumbs small p-0">
    <li><a href="/"><span>Агротендер</span></a></li>
    <i class="fas fa-chevron-right extra-small"></i>
    <li><a href="/elev"><span>Элеваторы</span></a></li>
    <i class="fas fa-chevron-right extra-small"></i>
    <li><a href="/elev/{$elev['region_translit']}"><span>{$elev['region_parental']} область</span></a></li>
    <i class="fas fa-chevron-right extra-small"></i>
    <li><h1>{$elev['name']}</h1></li>
  </ul>
  <div class="row mx-0 d-flex pt-2 pt-sm-5">
    <div class="col-auto pl-1">
      <img src="/app/assets/img/granary-4.png" class="logo">
    </div>
    <div class="col pl-1 text-left d-flex align-items-center">
      <span class="title">{$elev['orgname']}</span>
    </div>
  </div>
  <div class="content-block w-100 mt-3 mt-sm-5 py-2">
    <div class="row m-0 py-1 p-sm-3">
      <div class="col-12 col-sm-5 text-sm-right">
        <b>Адрес:</b>
      </div>
      <div class="col-12 col-sm-7">
        <span>{$elev['addr']}</span>
      </div>
    </div>
    <hr class="m-0">
    <div class="row m-0 py-1 p-sm-3">
      <div class="col-12 col-sm-5 text-sm-right">
        <b>Юридический адрес:</b>
      </div>
      <div class="col-12 col-sm-7">
        <span>{$elev['orgaddr']}</span>
      </div>
    </div>
    <hr class="m-0">
    <div class="row m-0 py-1 p-sm-3">
      <div class="col-12 col-sm-5 text-sm-right">
        <b>Директор:</b>
      </div>
      <div class="col-12 col-sm-7">
        <span>{$elev['director']}</span>
      </div>
    </div>
    <hr class="m-0">
    <div class="row m-0 py-1 p-sm-3">
      <div class="col-12 col-sm-5 text-sm-right">
        <b>Телефоны:</b>
      </div>
      <div class="col-12 col-sm-7">
        <span>{$elev['phone']}</span>
      </div>
    </div>
    <hr class="m-0">
    <div class="row m-0 py-1 p-sm-3">
      <div class="col-12 col-sm-5 text-sm-right">
        <b>Хранение:</b>
      </div>
      <div class="col-12 col-sm-7">
        <span>{$elev['holdcond']}</span>
      </div>
    </div>
    <hr class="m-0">
    {if $elev['email'] neq null}
    <div class="row m-0 py-1 p-sm-3">
      <div class="col-12 col-sm-5 text-sm-right">
        <b>Email:</b>
      </div>
      <div class="col-12 col-sm-7">
        <span>{$elev['email']}</span>
      </div>
    </div>
    <hr class="m-0">
    {/if}
    <div class="row m-0 py-1 p-sm-3">
      <div class="col-12 col-sm-5 text-sm-right">
        <b>Услуги по подработке:</b>
      </div>
      <div class="col-12 col-sm-7">
        <span>{$elev['descr_podr']}</span>
      </div>
    </div>
    <hr class="m-0">
    <div class="row m-0 py-1 p-sm-3">
      <div class="col-12 col-sm-5 text-sm-right">
        <b>Услуги по определению качества:</b>
      </div>
      <div class="col-12 col-sm-7">
        <span>{$elev['descr_qual']}</span>
      </div>
    </div>
  </div>
</div>
<div class="container d-flex justify-content-center mt-4 mb-5">
  {foreach $banners['bottom'] as $banner}
  {$banner}
  {/foreach}
</div>