@extends(AdminTemplate::getViewPath('_layout.base'))

@section('content')
    @if(\Request::segment(2) == 'comp_items' || \Request::segment(2) == 'comp_items_traders' || \Request::segment(2) == 'adv_torg_posts')
        <style>
            .dataTables_paginate {
                display: flex;
                padding: 1em 1.25rem 0;
                list-style: none;
                border-radius: .25rem;
                float: right;
            }
            .dataTables_info {
                font-weight: 500;
                font-size: 85%;
                padding-right: 1.25rem;
                text-align: right;
            }
            .test{
                margin-left: .5rem; margin-top: -1.1rem;
            }
        </style>
    @endif
    <div class="wrapper" id="vueApp">
        <nav class="main-header navbar navbar-expand bg-custom navbar-light">
            @include(AdminTemplate::getViewPath('_partials.header'))
        </nav>

        @php
            if (Cookie::get('menu-state') == 'close') {
                $menu_class = 'sidebar-collapse';
            }	else {
                $menu_class = 'sidebar-open';
            }
        @endphp

        <aside class="main-sidebar sidebar-light-fuchsia">
            @include(AdminTemplate::getViewPath('_partials.navigation'))
        </aside>

        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2 align-items-center">
                      <div class="col-sm-12">
                        {!! $template->renderBreadcrumbs($breadcrumbKey) !!}
                      </div>
                      <div class="col-sm-12">
                        <h1>
                          {!! $title !!}
                        </h1>
                      </div>
                    </div>
                </div>
            </div>

            <div class="content body">
                @stack('content.top')

                {!! $content !!}

                @stack('content.bottom')
            </div>
        </div>
    </div>
@stop
