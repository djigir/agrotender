<div class="container mt-4">
  <h2>Подать объявление на AGROTender</h2>
  <form class="form form-advert">
    <div class="content-block mt-4 px-4 py-3 px-sm-5 py-sm-5 mb-4">
      <div class="form-group row mb-3 mb-sm-5">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Заголовок <span class="text-danger">*</span></label>
        <div class="col-sm-6 mb-3">
          <input type="text" class="form-control" placeholder="Заголовок" name="title" id="title">
          <span class="small titleCounter">Доступно символов: <b>70</b></span>
        </div>
      </div>
      <div class="form-group row mb-3 mb-sm-4">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Рубрика <span class="text-danger">*</span></label>
        <div class="col-sm-5 d-flex align-items-center">
          <select class="form-control select-rubric" id="rubric">
            <option value="" disabled selected>Выберите рубрику</option>
          </select>
          <div class="d-none"></div>
          <img class="select-rubric-img d-none d-sm-block" src="/app/assets/img/select-rubric.png">
          <input type="hidden" class="rubric" name="rubric" value="">
        </div>
      </div>
      <hr>
      <div class="form-group row my-3 my-sm-4">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Тип <span class="text-danger">*</span></label>
        <div class="col-sm-2 d-flex align-items-center">
          <select class="form-control" name="type" id="type">
            <option value="">Выбрать</option>
            <option value="1">Закупки</option>
            <option value="2">Продажи</option>
            <option value="3">Услуги</option>
          </select>
        </div>
      </div>
      <div class="form-group row mb-3 mb-sm-5">
        <label class="col-sm-3 col-form-label d-flex align-items-start justify-content-start justify-content-sm-end">Описание <span class="text-danger">*</span></label>
        <div class="col-sm-7 d-flex align-items-center">
          <textarea class="form-control" name="description" id="description" rows="9" placeholder="Введите Ваше описание"></textarea>
          <img class="board-desc-img d-none d-sm-block" src="/app/assets/img/board-desc.png">
        </div>
      </div>
      <div class="form-group row my-3 my-sm-4 position-relative">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Цена</label>
        <div class="col-sm-4 d-flex align-items-center">
          <input type="text" name="price" class="form-control" id="price" placeholder="Цена">
          <select class="ml-3 form-control" name="currency" id="currency">
            <option value="1">грн.</option>
            <option value="2">$</option>
            <option value="3">€</option>
          </select>
          <div class="custom-control custom-checkbox ml-3">
            <input class="custom-control-input" type="checkbox" value="1" name="agree" id="agree">
            <label class="custom-control-label" for="agree">
              Договорная
            </label>
          </div>
        </div>
        <img src="/app/assets/img/real-price.png" class="real-price-img d-none d-sm-block">
      </div>
      <div class="form-group row my-3 my-sm-4">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Объем/кол-во</label>
        <div class="col-sm-6 d-flex align-items-center">
          <input type="text" name="count" class="form-control" id="count" placeholder="Объем/кол-во">
          <span class="mx-3">Ед.изм.</span>
          <select class="form-control" name="unit" id="unit">
            <option value="" selected disabled>Выбрать</option>
            <optgroup label="Меры массы">
              <option value="т">т</option>
              <option value="ц">ц</option>
              <option value="кг">кг</option>
              <option value="г">г</option>
            </optgroup>
            <optgroup label="Меры объема">
              <option value="куб. м">куб. м</option>
              <option value="куб. дм">куб. дм</option>
              <option value="куб. см">куб. см</option>
              <option value="л">л</option>
              <option value="мл">мл</option>
            </optgroup>
            <optgroup label="Количество">
              <option value="ед.">ед.</option>
              <option value="шт.">шт.</option>
              <option value="пара">пара</option>
              <option value="комплект">комплект</option>
              <option value="упаковка">упаковка</option>
              <option value="мешок">мешок</option>
              <option value="ящик">ящик</option>
              <option value="рулон">рулон</option>
              <option value="моток">моток</option>
              <option value="секция">секция</option>
              <option value="услуга">услуга</option>
            </optgroup>
            <optgroup label="Меры площади">
              <option value="кв. м">кв. м</option>
              <option value="гектар">гектар</option>
              <option value="сотка">сотка</option>
            </optgroup>
            <optgroup label="Меры длины">
              <option value="м">м</option>
              <option value="дм">дм</option>
              <option value="см">см</option>
            </optgroup>
            <optgroup label="Единицы времени">
              <option value="час">час</option>
              <option value="день">день</option>
              <option value="неделя">неделя</option>
              <option value="месяц">месяц</option>
              <option value="год">год</option>
            </optgroup>
          </select>
        </div>
      </div>
      <div class="form-group row my-3 my-sm-4 position-relative">
        <label class="col-sm-3 col-form-label d-flex align-items-start justify-content-start justify-content-sm-end">Картинки</label>
        <div class="col-sm-7 align-items-center">
          <div class="images-box p-2 text-center">
            <div class="image-block empty selected">
              <img src="/app/assets/img/add-photo.png">
              <i class="far fa-times remove"></i>
            </div>
            <div class="image-block empty">
              <img src="/app/assets/img/add-photo.png">
              <i class="far fa-times remove"></i>
            </div>
            <div class="image-block empty">
              <img src="/app/assets/img/add-photo.png">
              <i class="far fa-times remove"></i>
            </div>
            <div class="image-block empty">
              <img src="/app/assets/img/add-photo.png">
              <i class="far fa-times remove"></i>
            </div>
            <div class="image-block empty">
              <img src="/app/assets/img/add-photo.png">
              <i class="far fa-times remove"></i>
            </div>
            <div class="image-block empty">
              <img src="/app/assets/img/add-photo.png">
              <i class="far fa-times remove"></i>
            </div>
            <div class="image-block empty">
              <img src="/app/assets/img/add-photo.png">
              <i class="far fa-times remove"></i>
            </div>
            <div class="image-block empty">
              <img src="/app/assets/img/add-photo.png">
              <i class="far fa-times remove"></i>
            </div>
            <input type="hidden" name="cover" class="cover" value="">
          </div>
        </div>
        <img src="/app/assets/img/like-photos.png" class="like-photos-img d-none d-sm-block">
      </div>
      <hr>
      <div class="form-group row my-3 my-sm-4">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Область <span class="text-danger">*</span></label>
        <div class="col-sm-6 d-flex align-items-center">
          <select name="regions" id="regions" class="form-control">
            {foreach $regions as $region}
            <option value="{$region['id']}"{if $user->region eq $region['id']} selected{/if}>{$region['name']}{if $region['id'] != 1} область{/if}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <div class="form-group row my-3 my-sm-4">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Населённый пункт <span class="text-danger">*</span></label>
        <div class="col-sm-4 d-flex align-items-center">
          <input class="form-control" name="city" id="city" placeholder="Населённый пункт" value="{$user->city}">
        </div>
      </div>
      <div class="form-group row my-3 mt-sm-4 mb-sm-0">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Контакты </label>
        <div class="col-sm-5">
          <input type="text" class="form-control" value="{$user->phone}{if $user->phone2}, {$user->phone2}{/if}{if $user->phone3}, {$user->phone3}{/if}" disabled>
        </div>
      </div>
    </div>
    <div class="text-center mb-5">
      <span class="d-block rules mb-4">Я обязуюсь соблюдать <a href="/info/orfeta#p3" target="_blank">Правила размещения объявлений</a></span>
      <button type="submit" class="top-btn btn btn-primary align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">Опубликовать</button>
    </div>
  </form>
  <input type="file" name="images" class="d-none images-input" multiple>
</div>
<div class="modal fade rubricModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header if-not-empty-rubric">
        <h5 class="modal-title ml-5 pl-5">Выберите одну из предложенных рубрик ...</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-3 px-4 if-not-empty-rubric">
        <div class="proposeds mb-4 col-sm-9 d-flex p-0">
        </div>
        <hr class="mt-3 mb-0">
      </div>
      <div class="modal-header pt-0">
        <h5 class="modal-title ml-5 pl-5 if-not-empty-rubric">... либо выберите рубрику из списка</h5>
        <h5 class="modal-title ml-5 pl-5 if-empty-rubric pt-3">Выберите рубрику из списка</h5>
      </div>
      <div class="modal-body px-4 pt-2">
        <div class="section d-flex flex-wrap justify-content-center">
        {foreach from=$rubrics['groups'] item=group}
        <a class="flex-fill getRubricGroup btn section main" group="{$group['id']}">
          <span class="float-left left mr-2 rubricGroupIcon"><i class="far fa-chevron-right"></i></span>
          <span>{$group['title']}</span>
        </a>
        {/foreach}
        <a class="flex-fill btn section main backToRubric">
          <span class="float-left left mr-2 rubricGroupIcon"><i class="far fa-chevron-left"></i></span>
          <span>Назад</span>
        </a>
        {foreach from=$rubrics['subgroups'] item=subGroup}
        <a class="flex-fill btn section {if $subGroup['parent_id'] eq 0}group-{$subGroup['menu_group_id']}{else}subgroup-{$subGroup['parent_id']}{/if}"{if $subGroup['parent_id'] eq 0} subgroup="{$subGroup['id']}"{else} group="{$subGroup['id']}"{/if}>
          <span class="float-left left mr-2 rubricGroupIcon"><i class="far fa-chevron-right"></i></span>
          <span>{$subGroup['title']}</span>
        </a>
        {/foreach}
        </div>
      </div>
    </div>
  </div>
</div>
{if $user->activePhone eq 0}
<div class="modal fade" id="confirmPhone" tabindex="-1" role="dialog" aria-hidden="true">
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
          Необходимо подтвердить Ваш номер телефона:
          <div class="form-group my-3 col-12 col-sm-6 offset-sm-3">
            <input type="text" class="form-control newPhone" name="phone" value="{$user->phone|ltrim:'38'}">
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
          Мы отправили смс на номер <span class="phone">+{$user->phone}</span> <br>с кодом подтверждения. Пожалуйста, введите его в поле ниже:
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
{/if}