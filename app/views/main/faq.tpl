<div class="container mt-3">
	<ul class="breadcrumbs small p-0 d-none d-sm-block">
    <li><a href="/"><span>Главная</span></a></li>
    <li class="divider"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><h1>Библиотека</h1></li>
  </ul>
  {foreach $faq as $item}
  <div class="content-block mb-4 newsItem px-0 pt-3 pb-1 row">
  	<div class="col">
  	  <a class="title" href="/faq/{$item['url']}">{$item['title']}</a>
  	  <p>{$item['content']|strip_tags|truncate:300:"..":false}</p>
  	  <div class="row mx w-100 d-bottom">
        <div class="col justify-content-end">
          <span class="date float-right">{$item['add_date']|date_format:"%d.%m.%Y"}</span>
        </div>
      </div>
  	</div>
  </div> 
  {/foreach}
  {if $faq neq null && $totalPages > 1}
  <div class="row mx-0 mt-4 mb-5">
    <div class="col-12 pagination d-block text-center">
      {if $pageNumber neq 1}
      <a href="/faq/page_{$pageNumber - 1}"><span class="mr-1"><i class="far fa-chevron-left"></i></span> <span class="d-none d-sm-inline-block">Предыдущая</span></a>
      {/if}
      {if ($pageNumber - 3) ge 1}
      <a class="mx-1" href="/faq">1</a>
      ..
      {/if}
      {if ($pageNumber - 2) gt 0}
      <a class="d-none d-sm-inline-block mx-1" href="/faq/p_{$pageNumber - 2}">{$pageNumber - 2}</a>
      {/if}
      {if ($pageNumber - 1) gt 0}
      <a class="d-none d-sm-inline-block mx-1" href="/faq/p_{$pageNumber - 1}">{$pageNumber - 1}</a>
      {/if}
      <a href="#" class="active mx-1">{$pageNumber}</a>
      {if ($pageNumber + 1) le $totalPages}
      <a class="d-none d-sm-inline-block mx-1" href="/faq/p_{$pageNumber + 1}">{$pageNumber + 1}</a>
      {/if}
      {if ($pageNumber + 2) le $totalPages}
      <a class="d-none d-sm-inline-block mx-1" href="/faq/p_{$pageNumber + 2}">{$pageNumber + 2}</a>
      {/if}
      {if ($pageNumber + 3) le $totalPages}
      ..
      <a class="mx-1" href="/faq/p_{$totalPages}">{$totalPages}</a>
      {/if}
      {if $pageNumber neq $totalPages}
      <a href="/faq/p_{$pageNumber + 1}"><span class="d-none d-sm-inline-block">Следующая</span> <span class="ml-1"><i class="far fa-chevron-right"></i></span></a>
      {/if}
    </div>
  </div>
  {/if}
</div>