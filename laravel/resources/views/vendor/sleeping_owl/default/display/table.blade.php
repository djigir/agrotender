@if ( ! empty($title)
&&(!substr_count(request()->server('REQUEST_URI'),'/admin_dev/adv_torg_posts')
&& !substr_count(request()->server('REQUEST_URI'),'/admin_dev/adv_torg_post_companies') )
&& !substr_count(request()->server('REQUEST_URI'),'/admin_dev/comp_items_traders')
&& !substr_count(request()->server('REQUEST_URI'),'/admin_dev/comp_items')
&& !substr_count(request()->server('REQUEST_URI'),'/admin_dev/torg_elevators')
&& !substr_count(request()->server('REQUEST_URI'),'/admin_dev/traders_products')
&& !substr_count(request()->server('REQUEST_URI'),'/admin_dev/traders_products_sells')
&& !substr_count(request()->server('REQUEST_URI'),'/admin_dev/traders_ports')
&& !substr_count(request()->server('REQUEST_URI'),'/admin_dev/seo_titles')
&& !substr_count(request()->server('REQUEST_URI'),'/admin_dev/seo_titles_boards')
&& !substr_count(request()->server('REQUEST_URI'),'/admin_dev/comp_topics')
)
    <div class="row">
        <div class="col-lg-12 pt-3">
            {!! $title !!}
        </div>
    </div>
    <br/>
@endif

@yield('before.card')
@yield('before.panel')

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
               @if($route == '/admin_dev/torg_buyers'
                    || $route == '/admin_dev/py_bill_docs'
                    || \Request::segment(2) == 'torg_elevators'
                    || \Request::segment(2) == 'traders_products'
                    || \Request::segment(2) == 'traders_products_sells'
                    || \Request::segment(2) == 'traders_ports'
                    || \Request::segment(2) == 'seo_titles'
                    || \Request::segment(2) == 'seo_titles_boards'
                    || \Request::segment(2) == 'comp_topics'

               )
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

            @if((substr_count(request()->server('REQUEST_URI'),'/admin_dev/torg_elevators')) && \Request::segment(2) == 'torg_elevators')
                @include('vendor.sleeping_owl.default.column.custom_filter.torg_elevators_seo_port')
            @endif

            @if((substr_count(request()->server('REQUEST_URI'),'/admin_dev/traders_products')) && \Request::segment(2) == 'traders_products')
                @include('vendor.sleeping_owl.default.column.custom_filter.traders_products_sells')
            @endif

            @if((substr_count(request()->server('REQUEST_URI'),'/admin_dev/traders_products_sells')) && \Request::segment(2) == 'traders_products_sells')
                @include('vendor.sleeping_owl.default.column.custom_filter.traders_products_sells')
            @endif

            @if((substr_count(request()->server('REQUEST_URI'),'/admin_dev/seo_titles')) && \Request::segment(2) == 'seo_titles')
                @include('vendor.sleeping_owl.default.column.custom_filter.torg_elevators_seo_port')
            @endif

            @if((substr_count(request()->server('REQUEST_URI'),'/admin_dev/traders_ports')) && \Request::segment(2) == 'traders_ports')
                @include('vendor.sleeping_owl.default.column.custom_filter.torg_elevators_seo_port')
            @endif

            @if((substr_count(request()->server('REQUEST_URI'),'/admin_dev/seo_titles_boards')) && \Request::segment(2) == 'seo_titles_boards')
                @include('vendor.sleeping_owl.default.column.custom_filter.torg_elevators_seo_port')
            @endif

            @if((substr_count(request()->server('REQUEST_URI'),'/admin_dev/comp_topics')) && \Request::segment(2) == 'comp_topics')
                @include('vendor.sleeping_owl.default.column.custom_filter.comp_topics')
            @endif

    </div>

    @foreach($extensions as $ext)
        {!! $ext->render() !!}
    @endforeach

    @yield('card.footer')
    @yield('panel.footer')

    @if(\Request::segment(2) == 'comp_items'
       // || \Request::segment(2) == 'comp_items_traders'
        || \Request::segment(2) == 'adv_torg_posts'
        || \Request::segment(2) == 'adv_torg_post_complains'
        || \Request::segment(2) == 'torg_elevators'
        || \Request::segment(2) == 'seo_titles_boards'
        || \Request::segment(2) == 'adv_word_topics'
        || \Request::segment(2) == 'seo_titles'
        || \Request::segment(2) == 'torg_buyers'
        //|| \Request::segment(2) == 'comp_items_actives'
)
        <?php
            $SEGMENT = [
                'comp_items' => 'delete_traders_admin',
                //'comp_items_traders' => 'delete_traders_admin',
                'adv_torg_posts' => 'delete_posts_admin',
                'adv_torg_post_complains' => 'delete_torg_post_complains_admin',
                'torg_elevators' => 'delete_torg_elevators_admin',
                'adv_word_topics' => 'delete_adv_word_topics_admin',
                'seo_titles_boards' => 'delete_seo_titles_boards_admin',
                'seo_titles' => 'delete_seo_titles_admin',
                'torg_buyers' => 'delete_torg_buyers_admin',
                //'comp_items_actives' => 'delete_comp_items_actives_admin',
            ];

            $route = isset($SEGMENT[\Request::segment(2)]) ? $SEGMENT[\Request::segment(2)] : '';
            $delete = route($route);
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
