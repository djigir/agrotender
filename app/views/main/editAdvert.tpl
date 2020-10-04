<div class="container mt-4">
  <h2>Редактирование объявления</h2>
  <form class="form form-advert">
    <div class="content-block mt-4 px-4 py-3 px-sm-5 py-sm-5 mb-4">
      <div class="form-group row mb-3 mb-sm-4">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Заголовок <span class="text-danger">*</span></label>
        <div class="col-sm-6">
          <input type="text" class="form-control" placeholder="Заголовок" name="title" id="title" value="{$advert['title']}">
          <span class="small titleCounter">Доступно символов: <b>{math equation="x - y" x=70 y=$advert['title']|strlen}</b></span>
        </div>
      </div>
      <div class="form-group row mb-3 mb-sm-4">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Рубрика <span class="text-danger">*</span></label>
        <div class="d-flex align-items-center col-sm-8">
          <input type="hidden" class="rubric" name="rubric" value="{$advert['topic_id']}">
          <span class="rubric-text">{$rubric['title']}</span>
          <button class="btn btn-change select-rubric ml-3">Изменить</button>
        </div>
      </div>
      <hr>
      <div class="form-group row my-3 my-sm-4">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Тип <span class="text-danger">*</span></label>
        <div class="col-sm-2 d-flex align-items-center">
          <select class="form-control" name="type" id="type">
            <option value="1"{if $advert['type_id'] eq 1} selected{/if}>Закупки</option>
            <option value="2"{if $advert['type_id'] eq 2} selected{/if}>Продажи</option>
            <option value="3"{if $advert['type_id'] eq 3} selected{/if}>Услуги</option>
          </select>
        </div>
      </div>
      <div class="form-group row mb-3 mb-sm-5">
        <label class="col-sm-3 col-form-label d-flex align-items-start justify-content-start justify-content-sm-end">Описание <span class="text-danger">*</span></label>
        <div class="col-sm-7 d-flex align-items-center">
          <textarea class="form-control" name="description" id="description" rows="9" placeholder="Введите Ваше описание">{$advert['content']}</textarea>
          <img class="board-desc-img d-none d-sm-block" src="/app/assets/img/board-desc.png">
        </div>
      </div>
      <div class="form-group row my-3 my-sm-4 position-relative">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Цена</label>
        <div class="col-sm-4 d-flex align-items-center">
          <input type="text" name="price" class="form-control" id="price" placeholder="Цена" value="{$advert['cost']}">
          <select class="ml-3 form-control" name="currency" id="currency">
            <option value="1"{if $advert['cost_cur'] eq 1} selected{/if}>грн.</option>
            <option value="2"{if $advert['cost_cur'] eq 2} selected{/if}>$</option>
            <option value="3"{if $advert['cost_cur'] eq 3} selected{/if}>€</option>
          </select>
          <div class="custom-control custom-checkbox ml-3">  
            <input class="custom-control-input" type="checkbox" value="1" name="agree" id="agree"{if $advert['cost_dog'] eq 1} checked{/if}>
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
          <input type="text" name="count" class="form-control" id="count" placeholder="Объем/кол-во" value="{$advert['amount']}">
          <span class="mx-3">Ед.изм.</span>
          <select class="form-control" name="unit" id="unit">
            <option value="" disabled{if $advert['izm'] eq null} selected{/if}>Выбрать</option>
            <optgroup label="Меры массы">
              <option value="т"{if $advert['izm'] eq 'т'} selected{/if}>т</option>
              <option value="ц"{if $advert['izm'] eq 'ц'} selected{/if}>ц</option>
              <option value="кг"{if $advert['izm'] eq 'кг'} selected{/if}>кг</option>
              <option value="г"{if $advert['izm'] eq 'г'} selected{/if}>г</option>
            </optgroup>
            <optgroup label="Меры объема">
              <option value="куб. м"{if $advert['izm'] eq 'куб. м'} selected{/if}>куб. м</option>
              <option value="куб. дм"{if $advert['izm'] eq 'куб. дм'} selected{/if}>куб. дм</option>
              <option value="куб. см"{if $advert['izm'] eq 'куб. см'} selected{/if}>куб. см</option>
              <option value="л"{if $advert['izm'] eq 'л'} selected{/if}>л</option>
              <option value="мл"{if $advert['izm'] eq 'мл'} selected{/if}>мл</option>
            </optgroup>
            <optgroup label="Количество">
              <option value="ед."{if $advert['izm'] eq 'ед.'} selected{/if}>ед.</option>
              <option value="шт."{if $advert['izm'] eq 'шт.'} selected{/if}>шт.</option>
              <option value="пара"{if $advert['izm'] eq 'пара'} selected{/if}>пара</option>
              <option value="комплект"{if $advert['izm'] eq 'комплект'} selected{/if}>комплект</option>
              <option value="упаковка"{if $advert['izm'] eq 'упаковка'} selected{/if}>упаковка</option>
              <option value="мешок"{if $advert['izm'] eq 'мешок'} selected{/if}>мешок</option>
              <option value="ящик"{if $advert['izm'] eq 'ящик'} selected{/if}>ящик</option>
              <option value="рулон"{if $advert['izm'] eq 'рулон'} selected{/if}>рулон</option>
              <option value="моток"{if $advert['izm'] eq 'моток'} selected{/if}>моток</option>
              <option value="секция"{if $advert['izm'] eq 'секция'} selected{/if}>секция</option>
              <option value="услуга"{if $advert['izm'] eq 'услуга'} selected{/if}>услуга</option>
            </optgroup>
            <optgroup label="Меры площади">
              <option value="кв. м"{if $advert['izm'] eq 'кв. м'} selected{/if}>кв. м</option>
              <option value="гектар"{if $advert['izm'] eq 'гектар'} selected{/if}>гектар</option>
              <option value="сотка"{if $advert['izm'] eq 'сотка'} selected{/if}>сотка</option>
            </optgroup>
            <optgroup label="Меры длины">
              <option value="м"{if $advert['izm'] eq 'м'} selected{/if}>м</option>
              <option value="дм"{if $advert['izm'] eq 'дм'} selected{/if}>дм</option>
              <option value="см"{if $advert['izm'] eq 'см'} selected{/if}>см</option>
            </optgroup>
            <optgroup label="Единицы времени">
              <option value="час"{if $advert['izm'] eq 'час'} selected{/if}>час</option>
              <option value="день"{if $advert['izm'] eq 'день'} selected{/if}>день</option>
              <option value="неделя"{if $advert['izm'] eq 'неделя'} selected{/if}>неделя</option>
              <option value="месяц"{if $advert['izm'] eq 'месяц'} selected{/if}>месяц</option>
              <option value="год"{if $advert['izm'] eq 'год'} selected{/if}>год</option>
            </optgroup>
          </select>
        </div>
      </div>
      <div class="form-group row my-3 my-sm-4 position-relative">
        <label class="col-sm-3 col-form-label d-flex align-items-start justify-content-start justify-content-sm-end">Картинки</label>
        <div class="col-sm-7 align-items-center">
          <div class="images-box p-2 text-center">
            {for $i=0 to 7}
            {if isset($photos[$i])}
            <div class="image-block {if $photos[$i]['sort_num'] eq 1} selected{/if}">
              <img src="/{$photos[$i]['filename_ico']}" img-id="{$photos[$i]['file_id']}">
              <i class="far fa-times remove server"></i>
            </div>
            {else}
            <div class="image-block empty{if $i eq 0} selected{/if}">
              <img src="/app/assets/img/add-photo.png">
              <i class="far fa-times remove"></i>
            </div>
            {/if}
            {/for}
            <input type="hidden" name="cover" class="cover" value="{if isset($photos[0])}{$photos[0]['file_id']}{/if}">
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
            <option value="{$region['id']}"{if $advert['obl_id'] eq $region['id']} selected{/if}>{$region['name']}{if $region['id'] != 1} область{/if}</option>
            {/foreach}
          </select>
          <input type="hidden" class="regionsList" value="{','|implode:$advertRegions}">
        </div>
      </div>
      <div class="form-group row my-3 my-sm-4">
        <label class="col-sm-3 col-form-label d-flex align-items-center justify-content-start justify-content-sm-end">Населённый пункт <span class="text-danger">*</span></label>
        <div class="col-sm-4 d-flex align-items-center">
          <input class="form-control" name="city" id="city" placeholder="Населённый пункт" value="{$advert['city']}">
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
      <button type="submit" class="top-btn btn btn-primary align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0 px-5">Сохранить</button>
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
            <input type="text" class="form-control newPhone" name="phone" value="{$user->phone|ltrim:'380'}">
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