@include('traders.block-info.traders')
<div class="new_container mt-3 traders_dev">
    <div class="new_traders">
        @foreach($traders as $trader)
            <div class="traders__item-wrap">
                <a href="{{route('company.index', $trader->id) }}" class="traders__item {{($trader->trader_premium == 1 ? 'yellow' : '')}}">
                    <div class="traders__item__header">
                        <img class="traders__item__image" src="{{ $trader->logo_file }}" alt="">
                    </div>
                    <div class="traders__item__content">
                        <div class="traders__item__content-title">{{ $trader->title }}</div>
                        @if($trader->prices)
                            @foreach($trader->prices->take(2) as $index => $price)
                                <div class="traders__item__content-description">
                                    <p class="traders__item__content-p">
                                        <span class="traders__item__content-p-title">{{ \Illuminate\Support\Str::limit($price->name, 12, $end='.') }}</span>
                                        <span class="right">
                                            <span class="traders__item__content-p-price">
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

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var add_count_item = 15;
    var count = 0;
    var start = add_count_item;
    var end = add_count_item * 2;

    var region = window.location.pathname.replace('traders', '').replace('region_', '').replace(/[\/\\]/g,'');
    var port = window.location.pathname.replace('traders', '').replace('tport_', '').replace(/[\/\\]/g,'');

    if(window.location.pathname.indexOf('region') !== -1){
        port = null;
    }

    if(window.location.pathname.indexOf('tport') !== -1){
        region = null;
    }

    $(window).scroll(function () {
        if(document.documentElement.scrollHeight - document.documentElement.scrollTop < document.documentElement.clientHeight + 800 && count < 1) {
            count++;
            $.ajax({
                url: window.location.origin + '/traders/get_traders',
                method: 'GET',
                data: {
                    region: region,
                    port: port,
                    start: start,
                    end: end,
                },
                success: function (data) {
                    $('.new_traders').append(data);
                    count = 0;
                    start += add_count_item;
                    end += add_count_item;
                }
            });
        }
    });
</script>
