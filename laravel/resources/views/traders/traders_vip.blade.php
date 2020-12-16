<div class="new_page_title top_traders_title mt4">ТОП ЗЕРНОТРЕЙДЕРЫ</div>
<div class="new_traders vip">
    @foreach($topTraders as $trader)
        <div class="traders__item-wrap">
            <a href="{{route('company.index', $trader->id)}}" class="traders__item">
                <div class="traders__item__header filled">
                    <span class="vip">ТОП</span>
                    <img class="traders__item__image" src="{{$trader->logo_file && file_exists($trader->logo_file) ? $trader->logo_file :'https://agrotender.com.ua/pics/comp/4964_89599.jpg'}}" alt="">
                </div>
                <div class="traders__item__content">
                    <div href="#" class="traders__item__content-title">{{$trader->title}}</div>
                    <div class="traders__item__content-description">
                            @if($trader->prices)
                                @foreach($trader->prices as $index => $price)
                            <p class="traders__item__content-p">
                                <span class="traders__item__content-p-title">{{ $price->name }}</span>
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
                            @endforeach
                        @endif
                    </div>
                    <div class="traders__item__content-date">
                        <span class="traders__item__content-date-more">+ ещё</span>
                        <?php
                            $class = 'black';
                            $text = mb_convert_case(\Date::parse($trader->prices->first()->change_date)->format('d F'), MB_CASE_TITLE, "UTF-8");

                            if(Carbon\Carbon::today()->toDateString() ==  Carbon\Carbon::parse($trader->prices->first()->change_date)->toDateString()){
                                $class = 'green';
                                $text = 'сегодня';
                            }

                            if(Carbon\Carbon::yesterday()->toDateString() ==  Carbon\Carbon::parse($trader->prices->first()->change_date)->toDateString()){
                                $class = 'orange';
                                $text = 'вчера';
                            }
                        ?>
                        <span class="{{$class}}">
                            {{$text}}
                        </span>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
