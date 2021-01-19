@extends(AdminTemplate::getViewPath('_layout.base'))

@section('content')
    <div class="wrapper" id="vueApp">
{{--        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">--}}
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

{{--        <aside class="main-sidebar sidebar-dark-primary elevation-4">--}}
{{--        <aside class="main-sidebar sidebar-light-fuchsia elevation-4">--}}
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
