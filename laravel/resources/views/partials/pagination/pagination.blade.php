@if ($paginator->hasPages())
    <div class="row  mt-4" style="margin: 0 auto">
        <div class="col-12  d-block text-center">
            <nav>
                <ul class="pagination ">
                    @if ($paginator->onFirstPage())
                        <li  class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span style="background-color: #eff1f5" class="page-link" aria-hidden="true">&lsaquo;Предыдущая</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;Предыдущая</a>
                        </li>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span style="background-color: #eff1f5" class="page-link">{{ $element }}</span></li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link" style="background-color: #ffd200">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Следующая&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">Следующая&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@endif
<style>
    .page-link{
        background-color: #eff1f5;
        border: none;
        border-radius: 7px;
    }
</style>
