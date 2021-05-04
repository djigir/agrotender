<div class="filters-wrap">
  <div class="filters-inner">
<div class="filters arrow-t">
  <div class="step-1 stp">
    <div class="mt-3">
      <span class="title ml-3 pt-3">Настройте фильтры:</span>
    </div>
    <div class="position-relative mt-3">
      <input type="text" class="pl-4 pr-5 py-4 content-block filter-search" placeholder="Я ищу.." value="{if $query neq null}{$query}{/if}">
      <i class="far fa-search searchFilterIcon"></i>
    </div>
    <a class="mt-5 p-4 content-block filter filter-type d-flex justify-content-between" href="#" type="{if $type eq null}0{else}{$type['translit']}{/if}">
    <span>{if $type eq null}Тип объявления{else}{$type['name']}{/if}</span>
    <span><i class="far fa-chevron-right"></i></span>
    </a>
    <a class="mt-4 p-4 content-block filter filter-rubric d-flex justify-content-between" href="#" rubric="{if $rubric eq null}0{else}{$rubric['id']}{/if}">
    <span>{if $rubric eq null}Выберите рубрику{else}{$rubric['title']}{/if}</span>
    <span><i class="far fa-chevron-right"></i></span>
    </a>
    <a class="mt-4 p-4 content-block filter filter-region d-flex justify-content-between" href="#" region="{if $region['id'] eq null}0{else}{$region['translit']}{/if} ">
    <span>{if $region['id'] eq null}Вся Украина{elseif $region['id'] eq 1}АР Крым{else}{$region['name']} область{/if}</span>
    <span><i class="far fa-chevron-right"></i></span>
    </a>
    <a class="showAdverts" href="#">
    Показать объявления
    </a>
  </div>
  <div class="step-2 stp">
    <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="mt-5">
      <a class="type px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" type="0">
      <span>Все объявления</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {foreach from=$types item=type}
      <a class="type px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" type="{$type['translit']}">
      <span>{$type['name']}</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/foreach}
    </div>
  </div>
  <div class="step-3 stp h-100">
    <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="scroll">
      {foreach from=$rubrics['groups'] item=group}
      <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="{$group['id']}">
      <span>{$group['title']}</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/foreach}
    </div>
  </div>
  <div class="step-3-1 stp h-100">
    <a class="back py-3 px-4 content-block d-block" step="3" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="scroll">
      <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" group="">
      <span></span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {foreach from=$rubrics['subgroups'] item=subGroup}
      {if $subGroup['parent_id'] eq 0}
      <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-{$subGroup['menu_group_id']}" group="{$subGroup['id']}">
      <span>{$subGroup['title']}</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/if}
      {/foreach}
    </div>
  </div>
  <div class="step-3-2 stp h-100">
    <a class="back py-3 px-4 content-block d-block" step="3-1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="scroll">
      {foreach from=$rubrics['subgroups'] item=subGroup}
      {if $subGroup['parent_id'] neq 0}
      <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" group="{$subGroup['parent_id']}" rubricId="{$subGroup['id']}">
      <span>{$subGroup['title']}</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/if}
      {/foreach}
    </div>
  </div>
  <div class="step-4 stp h-100">
    <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>
    <div class="scroll">
      <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="0">
      <span>Вся Украина</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {foreach from=$regions_list item=col}
      {foreach from=$col item=region}
      <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="{$region['translit']}">
      <span>{$region['name']} область</span>
      <span><i class="far fa-chevron-right"></i></span>
      </a>
      {/foreach}
      {/foreach}
    </div>
  </div>
</div>
  </div>
</div>
<div class="container mt-4 d-none d-sm-block">
  <div class="row">
    <div class="col align-self-center">
      <ol class="breadcrumbs postBreadcrumbs small p-0 my-auto">
      <li><a href="/board"><span>Объявления</span></a></li>
      <i class="fas fa-chevron-right extra-small"></i>
      <li><a href="/board/region_{$advert['region_url']}/all">Объявления в {if $advert['region'] eq "АР Крым"}АР Крым{else}{$advert['parental']} области{/if}</a></li>
      <i class="fas fa-chevron-right extra-small"></i>
      <li><a href="/board/region_{$advert['region_url']}/all_t{$advert['rubric_id']}">{$advert['rubric']} в {if $advert['region'] eq "АР Крым"}АР Крым{else}{$advert['parental']} области{/if}</a></li>
      <i class="fas fa-chevron-right extra-small"></i>
      <li><a href="/board/region_{$advert['region_url']}/all_t{$advert['subrubric_id']}">{$advert['subrubric']} в {if $advert['region'] eq "АР Крым"}АР Крым{else}{$advert['parental']} области{/if}</a></li>
      </ol>
    </div>
    <div class="col-auto justify-content-end">
      <a href="/board/addpost" class="top-btn btn btn-warning align-bottom mr-0 mr-sm-3 mb-3 mb-sm-0">
        <i class="far fa-plus d-none d-md-inline-block"></i>
        <span class="pl-1 pr-1">Добавить объявление</span>
      </a>
    </div>
  </div>
  <hr class="post-top-hr">
</div>
<div class="container px-0 px-sm-3 mt-0 mt-sm-4">
  {if $detect->isMobile()}
  <div class="post content-block mx-0 pb-3">
    <div class="swiper-container">
      <div class="swiper-wrapper" style="width: 100vw;">
        {if $photos neq null}
        {foreach from=$photos item=photo}
        <a class="swiper-slide image-link" href="/{$photo['filename']}" data-imagelightbox="g">
          <img src="/{$photo['filename']}" class="background">
          <img src="/{$photo['filename']}" alt="{$advert['title']}">
        </a>
        {/foreach}
        {else}
        <div class="text-center my-4 w-100">
          <img src="/app/assets/img/no-image-big.png">
        </div>
        {/if}
      </div>
      <!-- Add Arrows -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
    <div class="row mx-0 justify-content-between px-4 mt-3 align-items-end">
      <div class="col">
        <span class="price text-uppercase">{if $advert['cost_dog'] eq 1}Договорная{elseif $advert['cost_dog'] eq 0 && $advert['cost'] eq null}Договорная{else}{$advert['cost']} {if $advert['cost_cur'] eq 1}грн.{elseif $advert['cost_cur'] eq 2}${elseif $advert['cost_cur'] eq 3}€{elseif $advert['cost_cur'] eq 0}грн.{/if}{/if}</span>
      </div>
      <div class="col text-right">
        <span class="date">{$advert['up_dt']}</span>
      </div>
    </div>
    <div class="row mx-0 justify-content-between px-4 align-items-end">
      <div class="col">
        <span class="count d-block">{if $advert['amount'] neq null and $advert['izm'] neq null}{$advert['amount']} {$advert['izm']}{/if}</span>
      </div>
      <div class="col text-right">
        <span class="id">ID: {$advert['id']}</span>
      </div>
    </div>
  </div>
  <div class="post content-block mx-0 mt-3 p-4 mb-5">
    <h1 class="title">{$advert['title']}</h1>
    <p class="text mt-3">{$advert['content']}</p>
  </div>

  <div class="post content-block mx-0 mt-3 px-4 pb-3 pt-3 mb-5">
    <div class="px-2 py-0 d-flex align-items-center">
        <img src="{if $advert['logo_file'] neq null}/{$advert['logo_file']}{else}/app/assets/img/nophoto.png{/if}" class="avatar mob" alt="{if $advert['company_title'] neq null}{$advert['company_title']}{else}{$advert['author_name']}{/if}">
        <div class="ml-3">
          <a class="d-block" href="/board/author/{$advert['author_id']}">{if $advert['company_title'] neq null}{$advert['company_title']}{else}{$advert['author_name']}{/if}</a>
          <span class="d-block">На сайте с {$advert['author_reg']}</span>
        </div>
      </div>
    {if $other neq null}
      <div class="other mt-3">
        <h3 class="authorPosts">Объявления автора</h3>
        {foreach from=$other item=adv}
        <div class="row mx-0 mt-3 position-relative">
          <div class="col-3 p-0">
            <a href="/board/post-{$adv['id']}">
              <img src="{if $adv['image'] neq null && file_exists($adv['image'])}/{$adv['image']}{else}/app/assets/img/no-image.png{/if}" alt="{$adv['title']}">
            </a>
          </div>
          <div class="col-9 pr-0 pl-2 small position-relative">
            <span class="title d-block" href="#"{if $adv['title']|count_characters:true gt 30} data-toggle="tooltip" data-placement="top" title="{$adv['title']}"{/if}>
              <a href="/board/post-{$adv['id']}" class="d-block">{$adv['title']|truncate:30:"..":true}</a>
            </span>
            <span class="d-bottom"{if $adv['region']|count_characters:true gt 18}data-toggle="tooltip" data-placement="top" title="{$adv['region']}"{/if}>{if $adv['region'] eq "АР Крым"}АР Крым{else}{$adv['region']|truncate:18:"..":true} область{/if}</span>
          </div>
        </div>
        {/foreach}
        <a class="author-btn btn mt-4 small d-block" href="/board/author/{$advert['author_id']}">Все объявления автора</a>
      </div>
      {/if}
  </div>
  {else}
  <div class="row post content-block p-4 h-100 mx-0">
    <div class="col-9">
      <h1 class="title">{$advert['title']}</h1>
      <div class="row mt-3">
        <div class="col">
          <span class="region">{if $advert['region'] eq "АР Крым"}АР Крым{else}{$advert['region']} область{/if}, {$advert['city']}</span>
        </div>
        <div class="col-auto">
          <span class="date">Обновлено: {$advert['up_dt']}</span>
        </div>
      </div>
      <div class="row mt-1">
        <div class="col">
          <span class="rubric">Рубрика: </span><a href="/board/all_t{$advert['subrubric_id']}" target="_blank">{$advert['subrubric']}</a>
        </div>
        <div class="col-auto">
          <span class="id">ID: {$advert['id']}</span>
        </div>
      </div>
      {if $photos neq null}
      <div class="swiper-container mt-4">
        <div class="swiper-wrapper">
          {foreach from=$photos item=photo}
          <a class="swiper-slide image-link">
          <img src="{if $photo['filename'] neq null && file_exists($photo['filename'])}/{$photo['filename']}{else} /app/assets/img/no-image.png{/if}" class="background">
          <img src="{if $photo['filename'] neq null && file_exists($photo['filename'])}/{$photo['filename']}{else} /app/assets/img/no-image.png{/if}" alt="{$advert['title']}" data-imagelightbox="g" href="/{$photo['filename']}">
          </a>
          {/foreach}
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
      {else}
      <div class="text-center my-4">
        <img src="/app/assets/img/no-image-big.png">
      </div>
      {/if}
      {if $advert['content'] neq null}
      <div class="mt-3 desc">
        <h3 class="d-block title">Описание от продавца</h3>
        <p class="text mt-3">{$advert['content']}</p>
      </div>
      {/if}
      <hr>
      <div class="d-none d-sm-flex justify-content-between">
        <a href="/board/region_{$advert['region_url']}/{$advert['type_translit']}_t{$advert['subrubric_id']}">< Назад</a>
        <span class="text-muted"><b><i class="far fa-eye"></i></b> Просмотров: {$advert['viewnum']}</span>
      </div>
    </div>
    <div class="col-3 pr-0 pl-4">
      <span class="price d-block text-uppercase">{if $advert['cost_dog'] eq 1}Договорная{elseif $advert['cost_dog'] eq 0 && $advert['cost'] eq null}Договорная{else}{$advert['cost']} {if $advert['cost_cur'] eq 1}грн.{elseif $advert['cost_cur'] eq 2}${elseif $advert['cost_cur'] eq 3}€{elseif $advert['cost_cur'] eq 0}грн.{/if}{/if}</span>
      <span class="count d-block">{if $advert['amount'] neq null and $advert['izm'] neq null}{$advert['amount']} {$advert['izm']}{/if}</span>
      <div class="contacts text-left mt-3">
        <img class="img-contact" src="/app/assets/img/a-contact.png">
        <div class="row mx-0">
          <div class="col-auto pr-1 pl-2">
            <i class="fas fa-mobile-alt"></i>
          </div>
          <div class="col pl-2">
            {if $contacts eq null}
            <a class="phone d-block" href="tel:{$advert['phone']}"> {$advert['phone']}</a>
            <span class="name d-block">{$advert['author_name']}</span>
            {if $advert['phone2'] neq null}
            <hr class="contact-hr my-2">
            <a class="phone d-block" href="tel:{$advert['phone2']}"> {$advert['phone2']}</a>
            <span class="name d-block">{$advert['name2']}</span>
            {/if}
            {if $advert['phone3'] neq null}
            <hr class="contact-hr my-2">
            <a class="phone d-block" href="tel:{$advert['phone3']}"> {$advert['phone3']}</a>
            <span class="name d-block">{$advert['name3']}</span>
            {/if}
            {else}
            {foreach $contacts as $contact}
            {if $contact@index eq 3}
              {break}
            {/if}
            <a class="phone d-block" href="tel:{$contact['phone']}"> {$contact['phone']}</a>
            <span class="name d-block">{$contact['fio']}</span>
            {if !$contacts|@end}
            <hr class="contact-hr my-2">
            {/if}
            {/foreach}
            {if $contacts|@count > 2}
            <div class="text-center">
              <a href="/kompanii/comp-{$advert['company_id']}-cont">Больше контактов</a>
            </div>
            {/if}
            {/if}
          </div>
        </div>
      </div>
      <div class="mt-2 pb-4 complain text-center">
        <i class="fas fa-exclamation-circle mr-1"></i>
        <a href="#" class="small complain" data-toggle="modal" data-target="#complain"><span>Пожаловаться на объявление</span> </a>
      </div>
      <a class="mt-5 author px-2 pb-2 pt-5 position-relative text-center d-block" href="{if $advert['company_title'] eq null}/board/author/{$advert['author_id']}{else}/kompanii/comp-{$advert['company_id']}{/if}">
        <img src="{if $advert['logo_file'] neq null && file_exists($adv['logo_file'])}/{$advert['logo_file']}{else}/app/assets/img/nophoto.png{/if}" class="avatar" alt="{if $advert['company_title'] neq null}{$advert['company_title']}{else}{$advert['author_name']}{/if}">
        <span class="postCompanyTitle">{if $advert['company_title'] neq null}{$advert['company_title']}{else}{$advert['author_name']}{/if}</span>
        <span class="d-block">На сайте с {$advert['author_reg']}</span>
      </a>
      {if $other neq null}
      <div class="mt-5 other">
        <h3 class="authorPosts">Объявления автора</h3>
        {foreach from=$other item=adv}
        <div class="row mx-0 mt-3 position-relative">
          <div class="col-3 p-0">
            <a href="/board/post-{$adv['id']}">
              <img src="{if $adv['image'] neq null && file_exists($adv['image'])}/{$adv['image']}{else}/app/assets/img/no-image.png{/if}" alt="{$adv['title']}">
            </a>
          </div>
          <div class="col-9 pr-0 pl-2 small position-relative">
            <span class="title d-block" href="#"{if $adv['title']|count_characters:true gt 30} data-toggle="tooltip" data-placement="top" title="{$adv['title']}"{/if}>
              <a href="/board/post-{$adv['id']}" class="d-block">{$adv['title']|truncate:30:"..":true}</a>
            </span>
            <span class="d-bottom"{if $adv['region']|count_characters:true gt 18}data-toggle="tooltip" data-placement="top" title="{$adv['region']}"{/if}>{if $adv['region'] eq "АР Крым"}АР Крым{else}{$adv['region']|truncate:18:"..":true} обл.{/if}</span>
          </div>
        </div>
        {/foreach}
        <a class="author-btn btn mt-4 small d-block" href="/board/author/{$advert['author_id']}">Все объявления автора</a>
      </div>
      {/if}
    </div>
  </div>
  {/if}
</div>
{if $similar neq null}
<div class="container my-4">
  <div class="row">
    <div class="position-relative w-100">
      <div class="col-12 col-md-4 float-left mt-0 d-flex d-sm-block">
        <h2 class="d-inline-block text-uppercase">Похожие объявления</h2>
      </div>
    </div>
  </div>
</div>
<div class="container mb-5 ">
  {foreach from=$similar item=adv}
  <div class="d-none d-md-block">
    <div class="row content-block postItem mx-0 mt-3 mt-sm-4 pt-2 pb-2 py-sm-3 px-1{if $adv['colored'] eq 1} colored{/if}">
      {if $adv['top'] neq null}
      <div class="ribbon">В ТОПе</div>
      {/if}
      <div class="row mx-0 w-100">
        <div class="col-auto pr-0 pl-1 pl-sm-3">
          <a href="/board/post-{$adv['id']}">
            <img src="{if $adv['image'] neq null && file_exists($adv['image'])}/{$adv['image']}{else}/app/assets/img/no-image.png{/if}" class="postImg" alt="{$adv['title']}">
          </a>
        </div>
        <div class="col pr-0 pl-2 pl-sm-3">
          <div class="row m-0">
            <div class="col-12 col-sm-8 d-flex pl-1 pl-sm-0">
              <div class="title ml-0 d-block">
                <span class="badge t{$adv['type_id']} align-self-center d-none d-sm-inline-block">{$adv['type']}</span>
                <a href="/board/post-{$adv['id']}" data-ellipsis="1">{$adv['title']}</a></span>
              </div>
            </div>
            <div class="d-none d-sm-flex col-sm-4 pr-sm-3 justify-content-end">
              <span class="price float-right">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}Договорная{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
            </div>
          </div>
          <div class="row mx-0 w-100 m-bottom">
            <div class="col p-0">
              <div class="row mx-0 postRowHeight mt-1">
                <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                  <span class="rubric align-self-center">{$adv['rubric']}</span>
                </div>
                <div class="d-none d-sm-flex col-sm-3 pr-sm-3 justify-content-end">
                  <span class="unit float-right">{if $adv['amount'] neq null and $adv['izm'] neq null}{$adv['amount']} {$adv['izm']}{/if}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="row mx-0 w-100 d-bottom">
            <div class="col p-0">
              <div class="row mx-0">
                <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                  <span class="author align-self-center">{$adv['author']}</span>
                </div>
              </div>
              <div class="row ml-0 mr-3 mt-1">
                <div class="col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                  <span class="region align-self-center">{$adv['region']} область{if $adv['city'] neq null}, {$adv['city']}{/if}</span>
                </div>
                <div class="d-sm-flex col-sm-3 justify-content-end">
                  <span class="date float-right">{if $smarty.now|date_format:"%Y/%m/%d" eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%Y/%m/%d в %H:%M"}{/if}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="d-block d-md-none">
    <a href="/board/post-{$adv['id']}">
      <div class="row content-block postItem mx-0 mt-3 mt-sm-4 pt-2 pb-2 py-sm-3 px-1{if $adv['colored'] eq 1} colored{/if}">
        {if $adv['top'] neq null}
        <div class="ribbon">В ТОПе</div>
        {/if}
        <div class="row mx-0 w-100">
          <div class="col-auto pr-0 pl-1 pl-sm-3">
            <img src="{if $adv['image'] neq null && file_exists($adv['image'])}/{$adv['image']}{else}/app/assets/img/no-image.png{/if}" class="postImg" alt="{$adv['title']}">
          </div>
          <div class="col pr-0 pl-2 pl-sm-3">
            <div class="row m-0">
              <div class="col-12 col-sm-8 d-flex pl-1 pl-sm-0">
                <div class="title ml-0 d-block">
                  <span class="badge t{$adv['type_id']} align-self-center d-none d-sm-inline-block">{$adv['type']}</span>
                  <span class="a" data-ellipsis="1">{$adv['title']}</span>
                </div>
              </div>
              <div class="d-none d-sm-flex col-sm-4 pr-sm-3 justify-content-end">
                <span class="price float-right">{if $adv['cost_dog'] eq 1}Договорная{elseif $adv['cost_dog'] eq 0 && $adv['cost'] eq null}Договорная{else}{$adv['cost']} {if $adv['cost_cur'] eq 1}грн.{elseif $adv['cost_cur'] eq 2}${elseif $adv['cost_cur'] eq 3}€{elseif $adv['cost_cur'] eq 0}грн.{/if}{/if}</span>
              </div>
            </div>
            <div class="row mx-0 w-100 m-bottom">
              <div class="col p-0">
                <div class="row mx-0 postRowHeight mt-1">
                  <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                    <span class="rubric align-self-center">{$adv['rubric']}</span>
                  </div>
                  <div class="d-none d-sm-flex col-sm-3 pr-sm-3 justify-content-end">
                    <span class="unit float-right">{if $adv['amount'] neq null and $adv['izm'] neq null}{$adv['amount']} {$adv['izm']}{/if}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mx-0 w-100 d-bottom">
              <div class="col p-0">
                <div class="row mx-0">
                  <div class="col-12 col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                    <span class="author align-self-center">{$adv['author']}</span>
                  </div>
                </div>
                <div class="row ml-0 mr-3 mt-1">
                  <div class="col-sm-9 pl-1 pl-sm-0 d-none d-sm-flex">
                    <span class="region align-self-center">{$adv['region']} область{if $adv['city'] neq null}, {$adv['city']}{/if}</span>
                  </div>
                  <div class="d-sm-flex col-sm-3 justify-content-end">
                    <span class="date float-right">{if $smarty.now|date_format:"%Y/%m/%d" eq $adv['up_dt']|date_format:"%Y/%m/%d"}Сегодня в {$adv['up_dt']|date_format:"%H:%M"}{else}{$adv['up_dt']|date_format:"%Y/%m/%d в %H:%M"}{/if}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  {/foreach}
</div>
{/if}
{if !empty($banners['bottom'])}
<div class="container d-flex justify-content-center mt-4 mb-5">
  {foreach $banners['bottom'] as $banner}
  {$banner}
  {/foreach}
</div>
{/if}
{if $detect->isMobile()}
<span class="call-btn">Показать номер</span>
<div class="post-contacts">
  {if $contacts eq null}
            <a class="phone d-block" href="tel:{$advert['phone']}"> {$advert['phone']}</a>
            <span class="name d-block">{$advert['author_name']}</span>
            {if $advert['phone2'] neq null}
            <hr class="contact-hr my-2">
            <a class="phone d-block" href="tel:{$advert['phone2']}"> {$advert['phone2']}</a>
            <span class="name d-block">{$advert['name2']}</span>
            {/if}
            {if $advert['phone3'] neq null}
            <hr class="contact-hr my-2">
            <a class="phone d-block" href="tel:{$advert['phone3']}"> {$advert['phone3']}</a>
            <span class="name d-block">{$advert['name3']}</span>
            {/if}
            {else}
            {foreach $contacts as $contact}
            {if $contact@index eq 3}
              {break}
            {/if}
            <a class="phone d-block" href="tel:{$contact['phone']}"> {$contact['phone']}</a>
            <span class="name d-block">{$contact['fio']}</span>
            {if !$contacts|@end}
            <hr class="contact-hr my-2">
            {/if}
            {/foreach}
  {/if}
</div>
{/if}
<div class="modal fade" id="complain" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <form class="form modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3">Пожаловаться на объявление</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body py-0">
        <div class="form-group my-3">
          <textarea placeholder="Текст жалобы" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-block btn-primary px-5 send-complain">Отправить</button>
      </div>
    </form>
  </div>
</div>