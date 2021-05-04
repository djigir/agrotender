<div class="container mt-3">
	<ul class="breadcrumbs small p-0 d-none d-sm-block">
    <li><a href="/"><span>Главная</span></a></li>
    <li class="divider"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><h1>Новости</h1></li>
  </ul>
  {foreach $news as $item}
  <div class="content-block mb-4 newsItem py-3 row">
  	<div class="col-3 col-sm-auto">
  	  <img src="{if $item['filename_src'] neq null}/files/{$item['filename_src']}{else}/app/assets/img/no-image.png{/if}" class="image" alt="{$item['title']}">
  	</div>
  	<div class="col pl-0">
  	  <a class="title" href="/news/{$item['dtime']|date_format:"%m"}_{$item['dtime']|date_format:"%y"}/{$item['url']|unescape:'html'}">{$item['title']}</a>
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
  {if $news neq null && $totalPages > 1}
  <div class="row mx-0 mt-4 mb-5">
    <div class="col-12 pagination d-block text-center">
      {if $pageNumber neq 1}
      <a href="/news/page_{$pageNumber - 1}_15"><span class="mr-1"><i class="far fa-chevron-left"></i></span> <span class="d-none d-sm-inline-block">Предыдущая</span></a>
      {/if}
      {if ($pageNumber - 3) ge 1}
      <a class="mx-1" href="/news">1</a>
      ..
      {/if}
      {if ($pageNumber - 2) gt 0}
      <a class="d-none d-sm-inline-block mx-1" href="/news/page_{$pageNumber - 2}_15">{$pageNumber - 2}</a>
      {/if}
      {if ($pageNumber - 1) gt 0}
      <a class="d-none d-sm-inline-block mx-1" href="/news/page_{$pageNumber - 1}_15">{$pageNumber - 1}</a>
      {/if}
      <a href="#" class="active mx-1">{$pageNumber}</a>
      {if ($pageNumber + 1) le $totalPages}
      <a class="d-none d-sm-inline-block mx-1" href="/news/page_{$pageNumber + 1}_15">{$pageNumber + 1}</a>
      {/if}
      {if ($pageNumber + 2) le $totalPages}
      <a class="d-none d-sm-inline-block mx-1" href="/news/page_{$pageNumber + 2}_15">{$pageNumber + 2}</a>
      {/if}
      {if ($pageNumber + 3) le $totalPages}
      ..
      <a class="mx-1" href="/news/page_{$totalPages}_15">{$totalPages}</a>
      {/if}
      {if $pageNumber neq $totalPages}
      <a href="/news/page_{$pageNumber + 1}_15"><span class="d-none d-sm-inline-block">Следующая</span> <span class="ml-1"><i class="far fa-chevron-right"></i></span></a>
      {/if}
    </div>
  </div>
  {/if}
</div>