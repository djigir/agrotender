@if ( ! empty($title) && (!substr_count(request()->server('REQUEST_URI'),'/admin_dev/adv_torg_posts')&& !substr_count(request()->server('REQUEST_URI'),'/admin_dev/adv_torg_post_companies') )
&& !substr_count(request()->server('REQUEST_URI'),'/admin_dev/comp_items_traders') && !substr_count(request()->server('REQUEST_URI'),'/admin_dev/comp_items'))
    <div class="row">
        <div class="col-lg-12 pt-3">
            {!! $title !!}
        </div>
    </div>
    <br/>
@endif

@yield('before.card')
@yield('before.panel')

<?php $route = request()->server('REQUEST_URI'); ?>
@if($route == '/admin_dev/torg_elevators')
    <div style="display: flex; justify-content: space-between; padding-bottom: 1rem; margin-top: -1rem;">
        <div>
            <h1 style="font-size: 23px; line-height: 28px; margin-left: 1.5rem">
                Элеваторы
            </h1>
        </div>
        <div style="margin-top: -.5rem;">
            @if ($creatable)
                <span>{{$title}}</span>
                <a href="{{ url($createUrl) }}" style="float: right" class="btn btn-primary btn-create">
                    <i class="fas fa-plus"></i> {{ $newEntryButtonText }}
                </a>
            @endif
        </div>
    </div>
@endif

<div class="card card-default {!! $card_class !!}">
    <div class="card-heading card-header">

        <?php $route_export = '';  ?>

        {{-- добавить кнопку если роуты .... --}}
        @if(request()->server('REQUEST_URI') == '/admin_dev/torg_buyers')
             <?php $route_export = route('admin.download_users'); ?>
        @endif

        @if(request()->server('REQUEST_URI') == '/admin_dev/torg_buyers')
            <form action="{{ $route_export }}" class="export-form" style="margin-bottom: 1rem;" autocomplete="off">
                <input type="hidden" name="obl_id" class="export-input_obl" value="">
                <input type="hidden" name="section_id" class="export-input_section" value="">
                <input type="hidden" name="email_filter" class="export-input_email_filter" value="">
                <input type="hidden" name="phone_filter" class="export-input_phone_filter" value="">
                <input type="hidden" name="name_filter" class="export-input_name_filter" value="">
                <input type="hidden" name="id_filter" class="export-input_id_filter" value="">
                <input type="hidden" name="ip_filter" class="export-input_ip_filter" value="">
                <input type="submit" value="Выгрузить csv" class="export-btn btn btn-warning btn-create export-btn">
            </form>
        @endif

        {{-- убрать кнопку "Новая запись" если роуты .... --}}
        <?php $route = request()->server('REQUEST_URI'); ?>

        @if ($creatable)
            <a href="{{ url($createUrl) }}" class="btn btn-primary btn-create"
               @if($route == '/admin_dev/torg_buyers' || $route == '/admin_dev/py_bill_docs')
               style="display: none" @endif>
                <i class="fas fa-plus"></i> {{ $newEntryButtonText }}
            </a>
        @endif

        <div class="pull-right block-actions">
            @yield('card.heading.actions')
            @yield('panel.heading.actions')

            @yield('card.buttons')
            @yield('panel.buttons')
        </div>

        @yield('card.heading')
        @yield('panel.heading')
            @if((substr_count(request()->server('REQUEST_URI'),'/admin_dev/adv_torg_posts') ||substr_count(request()->server('REQUEST_URI'),'/admin_dev/adv_torg_post_companies') ) && !substr_count($createUrl,'/admin_dev/adv_torg_post_moder_msgs') )
                @include('vendor.sleeping_owl.default.column.custom_filter.adv_torg_post')
            @endif

            @if((substr_count(request()->server('REQUEST_URI'),'/admin_dev/comp_items_traders')) && \Request::segment(2) == 'comp_items_traders')
                @include('vendor.sleeping_owl.default.column.custom_filter.comp_items_traders')
            @endif

            @if((substr_count(request()->server('REQUEST_URI'),'/admin_dev/comp_items')) && \Request::segment(2) == 'comp_items')
                @include('vendor.sleeping_owl.default.column.custom_filter.comp_items')
            @endif

    </div>

    @foreach($extensions as $ext)
        {!! $ext->render() !!}
    @endforeach

    @yield('card.footer')
    @yield('panel.footer')

    @if(\Request::segment(2) == 'comp_items' || \Request::segment(2) == 'comp_items_traders' || \Request::segment(2) == 'adv_torg_posts')
        <?php
            $delete = route('delete_traders_admin');

            if(\Request::segment(2) == 'adv_torg_posts'){
                $delete = route('delete_posts_admin');
            }
        ?>

        <div id="actionTR" style="display: none; margin-left: 1.2rem; margin-top: -5.1rem; padding-bottom: 2.5rem; z-index: 5000; width: 50%;" class="pull-left block-actions">
            <form data-type="display-actions" id="action_form" style="display: inline-flex;">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="action_select">
                    <select id="sleepingOwlActionsStore" name="action" tabindex="-1" aria-hidden="true" class="form-control sleepingOwlActionsStore">
                        <option value="0">Нет действия</option>
                        <option data-method="get" value="{{$delete}}">
                            Удалить
                        </option>
                    </select>
                </div>
                <div class="action_btn pl-2">
                    <button type="submit" data-method="post" class="row-action btn btn-action btn-default">
                        Применить
                    </button>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    @endif
</div>

@yield('after.card')
@yield('after.panel')

<script src="../../../../../../../app/assets/my_js/admin.js"></script>
