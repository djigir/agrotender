<div class="container mt-5 mb-5">
  {if $type eq null}
  <div class="row mx-0">
    <div class="col-12 col-sm-6">
      <a class="content-block d-block py-2 px-4 sitemap-title" href="/sitemap/adverts">
        Объявления
      </a>
    </div>
    <div class="col-12 col-sm-6">
      <a class="content-block d-block py-2 px-4 sitemap-title" href="/sitemap/traders">
        Цены трейдеров
      </a>
    </div>
  </div>
  {elseif $type eq 'adverts'}
    {if $rubric eq null}
      {foreach $rubrics as $group}
      <a class="content-block my-2 px-2 py-1 d-block" href="/sitemap/adverts/rubric-{$group['id']}"><b>{$group['title']} ({$group['totalAdverts']})</b></a>
      {foreach $group['rubrics'] as $rubric}
      <a class="content-block my-2 px-2 py-1 d-block" href="/sitemap/adverts/rubric-{$rubric['id']}">{$rubric['title']} ({$rubric['totalAdverts']})</a>
      {/foreach}
      {/foreach}
    {else}
      <a class="content-block my-2 px-2 py-1 d-block" href="/sitemap/adverts"><b>< {$rubricName}</b></a>
      {foreach $regions as $region}
      <a class="content-block my-2 px-2 py-1 d-block" href="/board/region_{$region['translit']}/all_t{$rubric}">{$region['name']} ({$region['totalAdverts']})</a>
      {/foreach}
    {/if}
  {elseif $type eq 'traders'}
    {if $rubric eq null}
      {foreach $rubrics as $rubric}
      <a class="content-block my-2 px-2 py-1 d-block" href="/sitemap/traders/rubric-{$rubric['id']}"><b>{$rubric['name']}</b></a>
      {/foreach}
    {else}
      <a class="content-block my-2 px-2 py-1 d-block" href="/sitemap/traders"><b>< {$rubricInfo['name']}</b></a>
      {foreach $regions as $region}
      <a class="content-block my-2 px-2 py-1 d-block" href="/traders/region_{$region['translit']}/{$rubricInfo['url']}">{$region['name']}</a>
      {/foreach}
    {/if}
  {/if}
</div>