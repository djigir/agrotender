<div class="submenu d-none d-sm-block text-center">
  <a href="/u/">Авторизация</a>
  <a href="/u/contacts">Контакты</a>
  <a href="/u/notify">Уведомления</a>
  <a href="/u/reviews" class="active">Отзывы</a>
  <a href="/u/company">Компания</a>
  {if $user->company neq null}
  <a href="/u/news">Новости</a>
  <a href="/u/vacancy">Вакансии</a>
  {/if}
</div>
<div class="container mt-4 mb-5">
  <div class="dep mx-sm-5 text-center text-sm-left">
    <a href="/u/reviews"{if $type eq 0} class="active"{/if}>Мои отзывы</a>
    {if $user->company neq null}
    <a href="/u/reviews?type=1"{if $type eq '1'} class="active"{/if}>Моя компания</a>
    {/if}
  </div>
  {foreach $reviews as $review}
  <div class="content-block mt-4 review py-3 px-4 mx-0 mx-sm-5">
  	<div class="row m-0">
  	<div class="col-auto pl-0">
  	  <img src="{if $review['logo_file'] eq null}/app/assets/img/noavatar.png{else}/{$review['logo_file']}{/if}" class="avatar">
  	</div>
  	<div class="col pl-0">
  	  <div class="row m-0 align-items-center">
  	  	<div class="col p-0">
  	  	  <a href="{if $review['compId'] neq null}/kompanii/comp-{$review['compId']}{/if}" target="_blank">{if $review['compId'] eq null}{$review['author']}{else}{$review['title']}{/if}</a>
  	    </div>
  	  </div>
  	  <div class="row m-0 align-items-center lh-1">
  	  	<div class="col p-0">
  	  	  <img src="/app/assets/img/rate-{$review['rate']}.png">
  	    </div>
  	  </div>
  	</div>
  	</div>
  	{if $review['content'] neq null}
  	<span class="review-title">Отзыв</span>
  	<p class="review-content">{$review['content']}</p>
  	{/if}
  	{if $review['content_plus'] neq null}
  	<span class="review-title">Достоинства:</span>
  	<p class="review-content">{$review['content_plus']}</p>
  	{/if}
  	{if $review['content_minus'] neq null}
  	<span class="review-title">Недостатки:</span>
  	<p class="review-content">{$review['content_minus']}</p>
  	{/if}
  </div>
  {/foreach}
</div>