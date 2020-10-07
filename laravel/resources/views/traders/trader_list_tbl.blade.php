<div class="container traders mt-3 mt-sm-5">
    <div class="row mt-sm-0 pt-sm-0 mb-sm-4">
        <div class="position-relative w-100">
            {if ! $vipTraders}
            <div class="col-12 col-md-9 float-md-right text-center text-md-right">
                <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end d-none d-sm-inline-block">
                    <i class="far fa-plus mr-2"></i>
                    <span class="pl-1 pr-1">Разместить компанию</span>
                </a>
            </div>
            {/if}
            <div class="col-12 col-md-3 float-left mt-sm-0 d-flex justify-content-between d-sm-block">
                <div class="col-6 col-sm-12 pl-0">
                    <h2 class="d-inline-block text-uppercase">{if $rubric eq null}Все трейдеры{else}{$rubric['name']}{/if}</h2>
                    <div class="lh-1">
                        <a href="/tarif20.html" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
                    </div>
                </div>

                <div class="col-6 pr-0 text-right d-sm-none">
                    <a href="/tarif20.html" class="btn btn-warning align-items-end add-trader">
                        <span class="pl-1 pr-1">Стать трейдером</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
