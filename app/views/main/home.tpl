<div class="container mt-4">
  <div class="row">
    <div class="position-relative w-100">
      <div class="col-12 col-md-9 float-md-right text-center text-md-right">
        <a style="background: linear-gradient(180deg, #8A78E7 0%, #7E65FF 100%); border: none; height: 35px" href="viber://pa?chatURI=agrotender_bot&text=" class="top-btn btn btn-primary align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">
          <img alt="" src="/app/assets/img/company/viber4.svg" style="width: 18px"/>
          <span class="pl-1 pr-1">Продать в Viber</span>
        </a>
        <a style="background: linear-gradient(180deg, #5CA9F1 0%, #44A4FF 100%); border: none; height: 35px" href="https://t.me/AGROTENDER_bot" class="top-btn btn btn-primary align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">
          <img alt="" src="/app/assets/img/company/telegram-white.svg" style="width: 18px"/>
          <span class="pl-1 pr-1">Продать в Telegram</span>
        </a>
        <a href="/tarif20.html" class="top-btn btn btn-warning align-items-end">
          <i class="far fa-plus mr-2"></i>
          <span class="pl-1 pr-1">Разместить компанию</span>
        </a>
      </div>
      <div class="col-12 col-sm-3 float-left mt-4 mt-md-0 d-flex d-sm-block">
        <h2 class="d-inline-block text-uppercase">Цены трейдеров</h2>
        <div class="d-none d-sm-block">
          <a href="/traders/region_ukraine" class="small show-all mb-1 d-none d-sm-inline-block">Смотреть все</a>
        </div>
        <a href="/traders/region_ukraine" class="show-all float-right d-block d-sm-none align-self-center ml-auto ml-sm-2-relative">Все &nbsp;<i class="fas fa-angle-right position-absolute"></i></a>
      </div>
    </div>
  </div>
  <!-- <div class="d-flex justify-content-center align-items-center mt-3 mb-3 mt-sm-1 mt-lg-3">
    <ul class="categories m-0 pt-1 pb-1 p-lg-0">
       <li><a href="/" class="category active">Пшеница</a></li>
       <li><a href="/" class="category">Кукуруза</a></li>
       <li><a href="/" class="category">Пшеница 2 кл.</a></li>
       <li><a href="/" class="category">Пшеница 3 кл.</a></li>
       <li><a href="/" class="category">Ячмень</a></li>
       <li><a href="/" class="category">Подсолнечник</a></li>
       <li><a href="/" class="category">Соя</a></li>
     </ul>
    </div> -->
</div>
<div class="container swiper traders-swipe">
  <div class="swiper-container">
    <div class="swiper-wrapper">
      {foreach $prices as $rubric}
      <div class="swiper-slide" style="width: 464px; margin-right: 20px;">
        <div class="category-block">
          <span class="category-title d-inline-block">{$rubric['name']}</span>
          <div class="currency float-right d-flex">
            <a class="active" href="#" currency="0">UAH</a> &nbsp;|&nbsp; <a href="#" currency="1">USD</a>
          </div>
          <span class="xs-small text-head d-block">Сегодня макс. цена:</span>
          {foreach $rubric['prices'] as $price}
          <div class="row priceRow align-items-center" currency="{$price['curtype']}">
            <div class="col-4 pr-0">
              <a class="homeCompanyTitle" href="/kompanii/comp-{$price['companyId']}">{$price['company']|unescape}</a>
            </div>
            <div class="col-3 px-3">
              <div class="d-flex align-items-center justify-content-center lh-1"><span class="font-weight-600">{$price['price']}</span> {if $price['change_price'] neq ''}&nbsp;<img alt="" src="/app/assets/img/price-{$price['change_price']}.svg">&nbsp; <span class="price{if $price['change_price'] neq ''}-{$price['change_price']}{/if}"> {$price['price_diff']|ltrim:'-'}</span>{/if}</div>
            </div>
            <div class="col-1 p-0">
              {if $price['portname'] neq null}
              <img alt="" src="/app/assets/img/boat.png">
              <img alt="" src="/app/assets/img/yakor.png">
              {/if}
            </div>
            <div class="col-4 pl-0 pr-3 px-sm-0">
              <span class="region d-block">{$price['region']}</span>
              {if $price['place'] neq null}
              <span class="d-block d-sm-none place" {if $price['place']|count_characters:true gt 30}data-toggle="tooltip" data-placement="top" title="{$price['place']}"{/if}>{$price['place']|unescape|truncate:15:"..":true}</span>
              <span class="d-none d-sm-block place" {if $price['place']|count_characters:true gt 32}data-toggle="tooltip" data-placement="top" title="{$price['place']}"{/if}>{$price['place']|unescape|truncate:21:"..":true}</span>
              {else}
                {if $price['portname'] neq null}
              <span class="d-block place">{$price['portname']}</span>
                {/if}
              {/if}
            </div>
          </div>
          {/foreach}
        </div>
      </div>
      {/foreach}
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>
    <!-- If we need scrollbar -->
    <div class="swiper-scrollbar"></div>
  </div>
    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
<div class="container d-none d-md-block production-container">
  <h3 class="mt-4 mb-3">Продукция:</h3>
  <div class="d-flex justify-content-between productions m-0 p-0 row position-relative">
    <a href="/" class="production" group="1">
      <img alt="" src="/app/assets/img/cereal.png" class="align-self-center">
      <img alt="" src="/app/assets/img/cereal-hover.png" class="align-self-center">
      <span class="pl-2 align-middle">Зерновые</span>
    </a>
    <a href="/" class="production" group="2">
      <img alt="" src="/app/assets/img/sunflover.png" class="align-self-center">
      <img alt="" src="/app/assets/img/sunflower-hover.png" class="align-self-center">
      <span class="pl-2 align-middle">Масличные</span>
    </a>
    <a href="/" class="production" group="3">
      <img alt="" src="/app/assets/img/plant.png" class="align-self-center">
      <img alt="" src="/app/assets/img/plant-hover.png" class="align-self-center">
      <span class="pl-2 align-middle">Бобовые</span>
    </a>
    <a href="/" class="production" group="4">
      <img alt="" src="/app/assets/img/seeds.png" class="align-self-center">
      <img alt="" src="/app/assets/img/seeds-hover.png" class="align-self-center">
      <span class="pl-2 align-middle">Продукты переработки</span>
    </a>
    <a href="/" class="production" group="7">
      <img alt="" src="/app/assets/img/sprout.png" class="align-self-center">
      <img alt="" src="/app/assets/img/sprout-hover.png" class="align-self-center">
      <span class="pl-2 align-middle">Нишевые культуры</span>
    </a>
  </div>
  <div class="position-relative">
    <div class="dropdown">
      <span class="xs-small text-head d-block mb-2 ml-4">Выберите подкатегорию</span>
      <div class="section text-left">
        <div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>
      </div>
    </div>
  </div>
</div>
<div class="container mt-3 mb-2 d-none d-md-block">
 
  <span class="popular" style="margin-top: 16px;display: block;">
  <span style="font-weight: 600; color: #707070;">
  <img alt="" src="/app/assets/img/speaker.svg" style="width: 24px; height: 24px"/>
     Популярные культуры: </span> 
    <a href="https://agrotender.com.ua/traders/region_ukraine/pshenica_2_kl?viewmod=tbl" class="popular__block">Пшеница 2 кл.</a>
    <a href="https://agrotender.com.ua/traders/region_ukraine/pshenica_3_kl?viewmod=tbl" class="popular__block">Пшеница 3 кл.</a>
    <a href="https://agrotender.com.ua/traders/region_ukraine/kukuruza?viewmod=tbl" class="popular__block">Кукуруза</a>
    <a href="https://agrotender.com.ua/traders/region_ukraine/raps?viewmod=tbl" class="popular__block">Рапс</a>
    <a href="https://agrotender.com.ua/traders/region_ukraine/podsolnechnik?viewmod=tbl" class="popular__block">Подсолнечник</a>
    <a href="https://agrotender.com.ua/traders/region_ukraine/soya?viewmod=tbl" class="popular__block">Соя</a>
    <a href="https://agrotender.com.ua/traders/region_ukraine/yachmen?viewmod=tbl" class="popular__block">Ячмень</a>
  </span>
</div>
<div class="container">
  <h2 class="d-inline-block text-uppercase mt-4 mb-3">Нам доверяют</h2>
</div>
<div class="container swiper trust-swipe">
  <div class="swiper-container">
    <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
      {foreach $randomTraders as $trader}
      <div class="swiper-slide d-flex" style="width: 101px; margin-right: 20px;">
        <a href="/kompanii/comp-{$trader['id']}" class="content-block p-2">
        <img alt="" src="/{$trader['logo_file']}" class="trust-img">
        </a>
      </div>
      {/foreach}
    </div>
  </div>
  <!-- If we need navigation buttons -->
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>
</div>
<div class="container mt-4">
  <div class="row">
    <div class="position-relative w-100">
      <div class="col-12 col-md-8 float-md-right text-center text-md-right">
        <a href="/board/addpost" class="top-btn btn btn-warning align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">
          <i class="far fa-plus d-none d-md-inline-block"></i>
          <span class="pl-1 pr-1">Добавить объявление</span>
        </a>
      </div>
      <div class="col-12 col-sm-4 float-left mt-4 mt-md-0 d-flex d-sm-block">
        <h2 class="d-inline-block text-uppercase">Объявления</h2>
        <div class="d-none d-sm-block">
          <a href="/board" class="small show-all mb-1 d-none d-sm-inline-block">Смотреть все</a>
        </div>
        <a href="/board" class="show-all float-right d-block d-sm-none align-self-center ml-auto ml-sm-2-relative">Все &nbsp;<i class="fas fa-angle-right position-absolute"></i></a>
      </div>
    </div>
  </div>
  <!-- <div class="d-flex justify-content-center align-items-center mt-3 mb-3 mt-sm-1 mt-lg-3">
    <ul class="categories m-0 pt-1 pb-1 p-lg-0">
       <li><a href="/" class="category active">Пшеница</a></li>
       <li><a href="/" class="category">Кукуруза</a></li>
       <li><a href="/" class="category">Пшеница 2 кл.</a></li>
       <li><a href="/" class="category">Пшеница 3 кл.</a></li>
       <li><a href="/" class="category">Ячмень</a></li>
       <li><a href="/" class="category">Подсолнечник</a></li>
       <li><a href="/" class="category">Соя</a></li>
     </ul>
    </div> -->
</div>
<div class="container d-block d-md-block mb-1 mt-3">
  {foreach from=$topAdv item=top}
  <div class="row mr-0 ml-0 mt-0 mb-4 justify-content-between">
    {foreach from=$top key=k item=adv}
    <a class="homeAdv col-12 col-5ths px-0 m-0 mb-1" href="/board/post-{$adv['id']}">
      <div class="row m-0">
        <div class="col-4 col-md-12 p-0 text-center">
          <img alt="" src="{if $adv['image'] neq null}/{$adv['image']}{else}/app/assets/img/no-image.png{/if}">
        </div>
        <div class="col-8 col-md-12 p-0">
          <span class="title d-block mt-md-1 ml-md-2 pl-md-1">{$adv['title']|truncate:16:"..":true}</span>
          <span class="price d-block mt-2 mt-md-0 text-md-right pr-md-3 pb-md-1">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}0 грн.{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
          <div class="d-flex d-md-none align-items-end justify-content-between mr-2">
            <span class="count">{$adv['amount']} {$adv['izm']}</span>
            <span class="date small">{if $smarty.now|date_format:"%Y/%m/%d" eq $adv['add_date']|date_format:"%Y/%m/%d"}Сегодня в {$adv['add_date']|date_format:"%H:%M"}{else}{$adv['add_date']|date_format:"%Y/%m/%d в %H:%M"}{/if}</span>
          </div>
        </div>
      </div>
    </a>
    {/foreach}
  </div>
  {/foreach}
</div>
<!--<div class="container d-none d-md-block categories-container mb-4">
  <h5 class="mt-4 mb-3">Категории:</h5>
  <div class="row mr-0 ml-0 mb-4">
    <a href="/" class="homeCategory content-block col-md p-3 d-flex align-items-center">
      <img alt="" src="/app/assets/img/cereals.png">
      <span class="title ml-4 mt-1">Сельхоз продукция</span>
    </a>
    <a href="/" class="homeCategory content-block col-md p-3 d-flex align-items-center">
      <img alt="" src="/app/assets/img/cow.png">
      <span class="title ml-4 mt-1">Животноводство</span>
    </a>
    <a href="/" class="homeCategory content-block col-md p-3 d-flex align-items-center">
      <img alt="" src="/app/assets/img/cereals.png">
      <span class="title ml-4 mt-1">С/х химия и удобрения</span>
    </a>
  </div>
  <div class="row mr-0 ml-0 mb-4">
    <a href="/" class="homeCategory content-block col-md p-3 d-flex align-items-center">
      <img alt="" src="/app/assets/img/planting.png">
      <span class="title ml-4 mt-1">Посадочный материал</span>
    </a>
    <a href="/" class="homeCategory content-block col-md p-3 d-flex align-items-center">
      <img alt="" src="/app/assets/img/chicken.png">
      <span class="title ml-4 mt-1">Корма для животных</span>
    </a>
    <a href="/" class="homeCategory content-block col-md p-3 d-flex align-items-center">
      <img alt="" src="/app/assets/img/tractor.png">
      <span class="title ml-4 mt-1">Техника</span>
    </a>
  </div>
  <div class="row mr-0 ml-0 mb-4">
    <a href="/" class="homeCategory content-block col-md p-3 d-flex align-items-center">
      <img alt="" src="/app/assets/img/farm.png">
      <span class="title ml-4 mt-1">Услуги АПК</span>
    </a>
    <a href="/" class="homeCategory content-block col-md p-3 d-flex align-items-center">
      <img alt="" src="/app/assets/img/farm-house.png">
      <span class="title ml-4 mt-1">С/х земли и предприятия</span>
    </a>
    <a href="/" class="homeCategory content-block col-md p-3 d-flex align-items-center">
      <img alt="" src="/app/assets/img/harvester.png">
      <span class="title ml-4 mt-1">Оборудование</span>
    </a>
  </div>
</div>
<div class="container mt-3 d-none d-md-block">
  <span class="popular">Популярные разделы: Кукуруза, Пшеница 2 кл., Пшеница 6 кл., Ячмень, Подсолнечник, Гречка, Овес</span>
</div> -->
<div class="container d-flex justify-content-center mt-4">
  {foreach $banners['bottom'] as $banner}
  {$banner}
  {/foreach}
</div>
<div class="container mt-4 mb-4 pt-2 homeDesc text-center text-md-left">
  <h1 class="title">АГРОТЕНДЕР - АГРАРНЫЙ САЙТ УКРАИНЫ №1</h1>
  <p class="desc mt-3 d-none d-md-block">
    Agrotender – портал, где покупать и продавать сельскохозяйственную продукцию выгодно. Компания была создана в 2010 году ключевыми специалистами агрорынка.
  </p>
  <h2 class="desc mt-3 d-none d-md-block">
    Agrotender: направления деятельности
  </h2>
  <p class="desc mt-3 d-none d-md-block">
    «Агротендер» - это крупнейшая информационная аграрная площадка Украины. Это каталог, который объединяет всех игроков сельхоз рынка: как производителей, так и оптовых трейдеров. Но немного больше.
  </p>
  <p class="desc mt-3 d-none d-md-block">
    Все производители и трейдеры, зарегистрированные на агропортале, публикуют свои предложения и актуальую стоимость. На портале можно посмотреть максимальную цену зерновых и масличных на сегодняшний день, ее динамику (увеличение/снижение). При этом цены всегда оперативные и свежые, что позволяет быстро принимать правильные решения.
  </p>
  <p class="desc mt-3 d-none d-md-block">
    “Агротендер” собирает актуальные предложения о продаже агропродукции, информирует, кто из трейдеров изменил стоимость закупки в областях и портах, у кого максимальная цена на зерно, какие тенденции на зерновом рынке. Вся информация в вашем смартфоне - через чат-бота.
  </p>
  <p class="desc mt-3 d-none d-md-block">
    Трейдерам и производителям зерновых удобно, что все предложения собраны в одном месте. Агробазар, но в интернете.
  </p>
  <p class="desc mt-3 d-none d-md-block">
    Сегодня это самый крупный агропортал, на котором представлены:
  </p>
  <ul>
    <li>Зерновые;</li>
    <li>Масличные;</li>
    <li>Бобовые;</li>
    <li>Продукты переработки;</li>
    <li>Нишевые культуры;</li>
  </ul>
  <h2 class="desc mt-3 d-none d-md-block">
    Преимущества портала Агротендер
  </h2>
  <ul>
    <li>актуальность и достоверность информации. Цена на товар формируются  исключительно из реальных предложений и спроса;</li>
    <li>удобство для трейдера. Теперь не нужно держать огромный штат менеджеров, которые будут обзванивать производителей и формировать свою базу цен  - получайте информацию от чат-бота;</li>
    <li>удобство для производителей. Выставляйте свои предложения и продавайте максимально выгодно.</li>
    <li>умные и функциональные чат-боты в вайбер и телеграм для покупки/продажи агропродукции с уведомлениями об изменениях цен в вашем смартфоне. Оставив заявку вы сразу получите выгодные предложение от ведущих зернотрейдеров Украины.</li>
    <li>Нишевые культуры;</li>
  </ul>
  <p class="desc mt-3 d-none d-md-block">
  </p>
  <p class="desc mt-3 d-none d-md-block">
  </p>
</div>
<div class="modal fade notification-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="form modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3 notification-title" id="exampleModalLabel">Подтверждение номера телефона</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body notification-text">
        
      </div>
      <div class="modal-footer justify-content-center">
        <a class="btn btn-primary px-5 link-button"></a>
      </div>
    </div>
  </div>
</div>
