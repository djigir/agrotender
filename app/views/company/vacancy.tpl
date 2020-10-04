<div class="container">
  <div class="row mt-4 pt-sm-3 align-items-center justify-content-between">
    <div class="col-4 d-block">
      <h2 class="d-inline-block text-uppercase">Вакансии</h2>
    </div>
  </div>
</div>
<div class="container mt-4">
  {foreach $vacancy as $item}
  <a href="/kompanii/comp-{$company['id']}-vacancy-{$item['id']}"  class="content-block mb-4 newsItem py-3 px-4 d-flex justify-content-between align-items-center">
  	 <span class="title">{$item['title']}</span>
  	 <span class="date">{$item['add_date']|date_format:"%d.%m.%Y"}</span>
  </a> 
  {/foreach}
</div>