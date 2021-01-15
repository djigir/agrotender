@if(!empty($feed))

    <div class="new_feed">
        <button class="new_feed-button prev swiper-button-disabled" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="true"></button>
        <div class="swiper-container swiper-container-horizontal">
            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
                @foreach ($feed as $item)
                <div class="swiper-slide swiper-slide-active" style="width: 207.5px; margin-right: 20px;">
                    <a href="{{ route('company.index', $item['comp_id']) }}" class="new_feed-item">
                        <span class="new_feed-item-title">{{ \Illuminate\Support\Str::limit($item['comp_title'], 21, $end='...') }}</span>
                        <div class="new_feed-item-state {{ $item['onchange_class']  }}">{{ $item['onchange'] }}</div>
                        @foreach($item['tpl_name'] as $culture)
                        <ul>
                            <li>
                                <span>{{ $culture }}</span>
                                @if($item['tf_change_price'] == 0)
                                    <img src="https://agrotender.com.ua/app/assets/img/price-up.svg" alt="">
                                @elseif($item['tf_change_price'] == 1)
                                    <img src="https://agrotender.com.ua/app/assets/img/price-down.svg" alt="">
                                @endif
                            </li>
                        </ul>
                        @endforeach
                        <div class="new_feed-item-bottom">
                            <span class="more">+ ещё</span>
                            <span>{{ \Carbon\Carbon::parse($item['tf_change_date'])->format('H:i') }}</span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
        <button class="new_feed-button next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false"></button>
    </div>
@endif

<style>
    .new_feed-button{
        outline: none !important;
    }
</style>
