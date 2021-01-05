@include('traders.block-info.traders')
@if($traders->count() > 0)
<div class="new_container mt-3 traders_dev" port="{{$port_translit}}" region="{{$region_translit}}" id="traders_card_param">
    <div class="new_traders" id="content_traders">
        @foreach($traders as $trader)
            <div class="traders__item-wrap">
                <a href="{{$type_traders == 1 ? route('company.forwards', $trader->id) : route('company.index', $trader->id)}}" class="traders__item {{($trader->trader_premium == 1 ? 'yellow' : '')}}">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="{{ $trader->logo_file && file_exists($trader->logo_file) ? $trader->logo_file : '/app/assets/img/no-image.png'}}" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div class="traders__item__content-title">{{ $trader->title }}</div>
                        @if($trader->prices)
                            @foreach($trader->prices->take(2) as $index => $price)
                                <div class="traders__item__content-description">
                                    <p class="traders__item__content-p">
                                        <span class="traders__item__content-p-title">{{ \Illuminate\Support\Str::limit($price->name, 12, $end='.') }}</span>
                                        <span class="right">
                                            <span class="traders__item__content-p-price replace_numbers_js">
                                                {{ $price->curtype == 1 ? '$ ' : ''}}
                                                {{ round($price->costval, 1) }}
                                            </span>
                                            <span class="traders__item__content-p-icon">
                                                @if($price->change_price == 0)
                                                    <img src="/app/assets/img/price-not-changed.svg">
                                                @else
                                                    <img src="/app/assets/img/price-{{$price->change_price_type}}.svg">
                                                @endif
                                            </span>
                                        </span>
                                    </p>
                                </div>
                            @endforeach
                        @endif
                        <div class="traders__item__content-date">
                            <span class="traders__item__content-date-more">+ ещё</span>
                            @if(!isset($trader->min_date))
                                <?php
                                    $color = 'color: #001430';
                                    $text = mb_convert_case(\Date::parse($trader->change_date)->format('d F'), MB_CASE_TITLE, "UTF-8");

                                    if(Carbon\Carbon::today()->toDateString() == Carbon\Carbon::parse($trader->change_date)->toDateString()){
                                        $color = 'color: #009750';
                                        $text = 'сегодня';
                                    }

                                    if(Carbon\Carbon::yesterday()->toDateString() == Carbon\Carbon::parse($trader->change_date)->toDateString()){
                                        $color = 'color: #FF7404';
                                        $text = 'вчера';
                                    }
                                ?>

                                <span style="{{$color}}">
                                    {{$text}}
                                </span>
                            @else
                                <span style="display: flex; color: #001430">
                                   <span>{{\Carbon\Carbon::parse($trader->min_date)->format('m.Y')}}</span>
                                    <span style="margin: 0 2px">-</span>
                                    <span>{{\Carbon\Carbon::parse($trader->max_date)->format('m.Y')}}</span>
                                {{-- <span>{{mb_convert_case(\Date::parse($trader->min_date)->format('F'), MB_CASE_TITLE, "UTF-8")}}</span> <span style="margin: 0 2px">-</span> <span style="margin-right: 2px" >{{mb_convert_case(\Date::parse($trader->max_date)->format('F'), MB_CASE_TITLE, "UTF-8")}}</span>  <span>{{\Date::parse($trader->max_date)->format('y')}}</span>--}}
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endif
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var add_count_item = 15;
    var count = 0;
    var start = add_count_item;
    var execute_request = true;

    var region = $('#traders_card_param').attr('region');
    var port = $('#traders_card_param_param').attr('port');

    $(window).scroll(function () {
        if(execute_request && document.documentElement.scrollHeight - document.documentElement.scrollTop < document.documentElement.clientHeight + 3000 && count < 1) {
            replaceWithSpacesAllItems();
            count++;
            $.ajax({
                url: window.location.origin + '/traders/get_traders_card',
                method: 'GET',
                data: {
                    region: region,
                    port: port,
                    start: start,
                },
                success: function (data) {
                    $('#content_traders').append(data);
                    replaceWithSpacesAllItems()
                    count = 0;
                    start += add_count_item;
                    if(data == ''){
                        execute_request = false;
                    }
                }
            });
        }
    });
</script>
