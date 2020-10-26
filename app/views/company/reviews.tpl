<div class="container">
  <div class="row mt-4 pt-sm-3 mx-0 mx-sm-5 align-items-center justify-content-between">
    <div class="col-4 d-block">
      <h2 class="d-inline-block text-uppercase">Отзывы</h2>
    </div>
    <div class="col-8 text-center text-md-right">
      <a href="#" class="top-btn btn btn-primary align-bottom addReview">
        <span class="pl-1 pr-1">Оставить отзыв</span>
      </a>
    </div>
  </div>
</div>
<div class="container mb-5">
  {foreach $reviews as $review}
  <div class="content-block mt-4 review pt-3 mx-0 mx-sm-5">
    <div class="row comment-row px-3" review-id="{$review['id']}">
        <div class="col-12">
          <textarea class="form-control" placeholder="Комментарий">{if $review['comment'] neq null}{$review['comment']}{/if} </textarea>
          <button class="btn btn-success btn-block mt-3 save-review-comment">Сохранить комментарий</button>
        <hr>
      </div>
    </div>

  	<div class="row m-0 px-3">

  	<div class="col-auto pl-0">
  	  <img src="{if $review['logo_file'] eq null}/app/assets/img/noavatar.png{else}/{$review['logo_file']}{/if}" class="avatar">
  	</div>
  	<div class="col pl-0">
  	  <div class="row m-0 align-items-center">
  	  	<div class="col p-0">
  	  	  {if $review['compId'] neq null}
          <a href="/kompanii/comp-{$review['compId']}" target="_blank">{$review['title']}</a>
          {else}
          <span class="author">{$review['author']}</span>
          {/if}
          {if $company['id'] == $user->company['id']}
          <i class="far fa-reply review-comment ml-1"></i>
          {/if}
  	    </div>
  	  </div>
  	  <div class="row m-0 align-items-center lh-1">
  	  	<div class="col p-0">
  	  	  <img src="/app/assets/img/rate-{$review['rate']}.png">
  	    </div>
  	  </div>
  	</div>
  	</div>
  	<div class="px-3">
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
    {if $review['comment'] neq null}

    {/if} 
    </div>
    {if $review['comment'] neq null}
    <div class="companyComment">
      <span>Комментарий компании:</span>
      <p class="mb-0">{$review['comment']}</p>
    </div>
    {/if} 
  </div>
  {foreachelse}
  <div class="content-block mt-4 review py-3 px-4 mx-0 mx-sm-5 text-center">
    <b>У компании ещё нет ни одного отзыва.</b>
    <br>
    <b>Ваш может стать первым!</b>
  </div>
  {/foreach}
</div>
{*{if $user->auth}*}
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <form class="form modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3">Оставить отзыв</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pr-5 mt-4">
        <div class="form-group row mb-4 pb-1">
          <label class="col-sm-3 col-form-label text-left text-sm-right">Достоинства <span class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" placeholder="Достоинства" name="good">
          </div>
        </div>
        <div class="form-group row mb-4 pb-1">
          <label class="col-sm-3 col-form-label text-left text-sm-right">Недостатки <span class="text-danger">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" placeholder="Недостатки" name="bad">
          </div>
        </div>
        <div class="form-group row mb-4 pb-1">
          <label class="col-sm-3 col-form-label text-left text-sm-right">Комментарий</label>
          <div class="col-sm-9">
            <textarea class="form-control" name="comment" rows="7"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer d-block text-center text-sm-left d-sm-flex justify-content-end pt-2 mb-2 px-5">
        <div id="colorstar" data-rate="3" class="starrr ratable text-center mr-3 d-block d-sm-inline-block mb-3 mb-sm-0">
          <span data-num="1" class="fas fa-star"></span>
          <span data-num="2" class="fas fa-star"></span>
          <span data-num="3" class="fas fa-star"></span>
          <span data-num="4" class="far fa-star"></span>
          <span data-num="5" class="far fa-star"></span>
        </div>
        <button type="button" class="btn btn-primary px-5 send-review">Отправить отзыв</button>
      </div>
    </form>
  </div>
</div>
{*{/if}*}