@foreach($traders as $trader)
    <div class="traders__item-wrap">
        <a href="{{route('company.index', $trader->id) }}" class="traders__item {{($trader->trader_premium == 1 ? 'yellow' : '')}}">
            <div class="traders__item__header">
                <img class="logo mr-3" src="{{ $trader->logo_file && file_exists($trader->logo_file) ? $trader->logo_file : '/app/assets/img/no-image.png'}}">
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
