<div class="container">
  <div class="row mt-4 pt-sm-3 align-items-center justify-content-between">
    <div class="col-4 d-block">
      <h2 class="d-inline-block text-uppercase">Новости</h2>
    </div>
  </div>
</div>
<div class="container mt-4">
  {foreach $news as $item}
  <div class="content-block mb-4 newsItem py-3 row">
    <div class="col-3 col-sm-auto">
      <img src="{if isset($item['filename_src'])}/files/{$item['filename_src']}{else}/app/assets/img/no-image.png{/if}" class="image" alt="{$item['title']}">
    </div>
    <div class="col pl-0">
      <a class="title" href="/kompanii/comp-{$company['id']}-news-{$item['id']}">{$item['title']}</a>
      <p class="d-none d-sm-block">{$item['content']|strip_tags|truncate:300:"..":false}{if $item['content']|count_characters:true gt 300} <a href="/news/{$item['dtime']|date_format:"%m"}_{$item['dtime']|date_format:"%y"}/{$item['url']}" class="d-block"><b>Читать далее <i class="far fa-arrow-right"></i></b></a>{/if}</p>
      <div class="row mx-0 w-100 d-bottom d-none d-sm-flex">
        <div class="col justify-content-end">
          <span class="date float-right">{if isset($item['dtime'])}{$item['dtime']|date_format:"%d.%m.%Y"}{/if}</span>
        </div>
      </div>
    </div>
    <div class="row mx-0 d-sm-none">
      <div class="col">
        <p>{$item['content']|strip_tags|truncate:300:"..":false}{if $item['content']|count_characters:true gt 300} <a href="/news/{$item['dtime']|date_format:"%m"}_{$item['dtime']|date_format:"%y"}/{$item['url']}" class="d-block"><b>Читать далее <i class="far fa-arrow-right"></i></b></a>{/if}</p>
        <div class="row mx-0 w-100 d-bottom d-sm-none">
          <div class="col justify-content-end pr-4">
            <span class="date float-right mr-2">{if isset($item['dtime'])}{$item['dtime']|date_format:"%d.%m.%Y"}{/if}</span>
          </div>
        </div>
      </div>
    </div>
  </div> 
  {/foreach}
</div>