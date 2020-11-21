<?php
    $agent = new \Jenssegers\Agent\Agent;
    $isMobile = $agent->isMobile();
?>
<div class="row  mt-4 mobile-paginate">
    <div style="margin: 0 auto">
        @if ($paginator->hasPages())
            <nav>
                <ul class="pagination" style="{{ $isMobile ? 'width: 280px;': ''}}">
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span style="background-color: #eff1f5" class="page-link" aria-hidden="true">
                                <i class="far fa-chevron-left mr-1"></i>
                                @if(!$isMobile)Предыдущая @endif
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                                <i class="far fa-chevron-left mr-1"></i>@if(!$isMobile)Предыдущая @endif
                            </a>
                        </li>
                    @endif
                    <?php
                    $flag = true;
                    $flag2 = true;
                    ?>
                    @foreach ($elements as  $element)
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true">
                                <span style="background-color: #eff1f5" class="page-link">{{ $element }}</span>
                            </li>
                        @endif

                        @if (is_array($element))

                            @foreach ($element as $page => $url)
                                @if($paginator->currentPage() <= 2 && $loop->index >= 3)
                                    @continue
                                @elseif($paginator->currentPage() > 2 && $loop->index >= ($paginator->currentPage()+2))
                                    @continue
                                @endif
                                @if($paginator->currentPage() >= 4 && $page !== 1 && $page < ($paginator->currentPage()-2))
                                    @if($flag !== false)
                                        <?php
                                        $flag = false;
                                        ?>
                                        <li class="page-item disabled" aria-disabled="true" >
                                            <span style="background-color: #eff1f5" class="page-link">...</span>
                                        </li>
                                    @endif
                                    @continue
                                @endif

                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link" style="background-color: #ffd200">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                               aria-label="@lang('pagination.next')">@if(!$isMobile)Следующая @endif<i class="far fa-chevron-right mr-1"></i></a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">@if(!$isMobile)Следующая  @endif<i
                                    class="far fa-chevron-right mr-1"></i></span>
                        </li>
                    @endif
                </ul>
            </nav>
    </div>
</div>
@endif


<style>
    .page-link {
        background-color: #eff1f5;
        border: none;
        border-radius: 7px;
    }
    .page-item .page-link{
        outline: none !important;
    }
    .mobile-paginate {
        margin: 0 auto;
        margin-top: -4rem !important;
    }

    @media only screen and (max-width: 480px) {
        .mobile-paginate {
            margin-top: -0.5rem !important;
        }

        .pagination {
            display: block;
        }

        .pagination li {
            margin-bottom: 10px;
            display: inline-block;
        }
    }
</style>
