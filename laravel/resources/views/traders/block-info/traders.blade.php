@if($traders->count() > 0)
    <div class="new_container traders_table_title_css">
            @if($type_traders == 0)
                <div class="new_page_title">ВСЕ ЗЕРНОТРЕЙДЕРЫ</div>
            @else
                <div class="new_page_title">ВСЕ ФОРВАРДНЫЕ ЦЕНЫ</div>
            @endif
            @if($type_view === 'table')
                @include('filters.filter-traders', ['regions' => $regions, 'rubricsGroup' => $rubricGroups, 'onlyPorts' => $onlyPorts])
            @endif
        </div>
    </div>
@endif


