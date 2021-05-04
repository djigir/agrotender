<div class="container mt-5">
  <div class="content-block mb-4 newsBlock pt-3 pb-5 row px-4 position-relative">
    <h2 class="title d-block w-100">{$item['title']}<hr></h2>
    <p class="pb-3">{$item['content']}</p>
    <div class="pr-5 mb-2 w-100 d-bottom">
      <a href="/kompanii/comp-{$company['id']}-vacancy" class="back float-left"><i class="far fa-arrow-left"></i> &nbsp;Все вакансии</a>
      <span class="date float-right">{$item['add_date']|date_format:"%d.%m.%Y"}</span>
    </div>
  </div> 
</div>