@if($traders->count() > 0)
    <div class="new_container">
            @if($type_traders == 0)
                <div class="new_page_title">ВСЕ ЗЕРНОТРЕЙДЕРЫ</div>
            @else
                <div class="new_page_title">ВСЕ ФОРВАРДНЫЕ ЦЕНЫ</div>
            @endif
        </div>
    </div>
@endif


