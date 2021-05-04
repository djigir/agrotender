<div class="container mt-3">
  <ul class="breadcrumbs small p-0 d-none d-sm-block">
    <li><a href="/"><span>Главная</span></a></li>
    <li class="divider"><i class="fas fa-chevron-right extra-small"></i></li>
    <li><a href="/faq"><span>Библиотека</span></a></li>
  </ul>
  <div class="content-block mb-4 newsBlock pt-3 pb-5 px-4 position-relative">
    <h2 class="title d-block w-100">{$item['title']}<hr></h2>
    <p>{$item['content']|stripslashes}</p>
    <div class="pr-5 mb-2 w-100 d-bottom">
      <a href="/faq" class="back float-left"><i class="far fa-arrow-left"></i> &nbsp;Библиотека</a>
      <span class="date float-right">{$item['add_date']|date_format:"%d.%m.%Y"}</span>
    </div>
  </div> 
</div>