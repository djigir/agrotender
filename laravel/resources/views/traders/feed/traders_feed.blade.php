{{--<div class="container mt-3 mt-sm-4 mb-3 mb-sm-0">--}}
{{--    <div class="content-block feed py-3 position-relative">--}}
{{--        <div class="swiper-container swiper-container-horizontal">--}}
{{--            <div class="swiper-wrapper mx-0 " style="transform: translate3d(0px, 0px, 0px);">--}}
{{--                @foreach ($feed as $item)--}}
{{--                {foreach $feed as $item}--}}
{{--                {assign var=rubrics_count value=$item['r']|@count}--}}
{{--                <div class="swiper-slide swiper-slide-active" style="width: 192px; margin-right: 20px;">--}}
{{--                    <div class="feed-item row">--}}
{{--                        <div class="col-12 d-flex align-items-center">--}}
{{--                            <div class="circle{if $item@iteration is div by 2} two{/if} d-inline-block mr-1"></div> <a href="/kompanii/comp-{$item['company_id']}" class="title lh-1">{$item['company']|unescape|truncate:25:"..":true}</a>--}}
{{--                        </div>--}}
{{--                        <div class="col-12 prices">--}}
{{--                            <span class="price-{$item['onchange_class']} my-1">{$item['onchange']}</span>--}}
{{--                            {foreach from=$item['r'] item=rubrics key=rubric}--}}
{{--                            {if $rubrics@iteration eq 3}--}}
{{--                            {break}--}}
{{--                            {/if}--}}
{{--                            <div class="d-flex justify-content-between align-items-center ar">--}}
{{--                                <span class="rubric">{$rubric|unescape|truncate:18:"..":true}</span>--}}
{{--                                <div class="d-flex align-items-center lh-1 priceItem">--}}
{{--                                    {foreach $rubrics as $rubric_item}--}}
{{--                                    {foreach $rubric_item as $value}--}}
{{--                                    {if $value eq '0'}--}}
{{--                                    &nbsp;<img src="/app/assets/img/price-up.png">--}}
{{--                                    {/if}--}}
{{--                                    {if $value eq '1'}--}}
{{--                                    &nbsp;<img src="/app/assets/img/price-down.png">--}}
{{--                                    {/if}--}}
{{--                                    {/foreach}--}}
{{--                                    {/foreach}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            {/foreach}--}}
{{--                        <div class="col-12 d-flex align-items-center justify-content-between mt-1">--}}
{{--                            <a href="/kompanii/comp-{$item['company_id']}" class="more">{if ($rubrics_count - 2) > 0}+ ещё {$rubrics_count - 2}{/if}</a>--}}
{{--                            <span class="time">{$item['change_time']}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            <!-- Add Arrows -->--}}
{{--                <!-- Add Arrows -->--}}
{{--            </div>--}}
{{--            <div class="swiper-button-next"></div>--}}
{{--            <div class="swiper-button-prev"></div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    {/if}--}}
{{--</div>--}}

<div class="container mt-3 mt-sm-4 mb-3 mb-sm-0">
    <div class="content-block feed py-3 position-relative">
        <div class="swiper-container swiper-container-horizontal">
            <div class="swiper-wrapper mx-0 " style="transform: translate3d(0px, 0px, 0px);">
                @foreach ($feed as $item)
                <div class="swiper-slide swiper-slide-active" style="width: 192px; margin-right: 20px;">
                    <div class="feed-item row">
                        <div class="col-12 d-flex align-items-center">
                            <div class="circle d-inline-block mr-1"></div> <a href="{{ route('company.index', $item['comp_id']) }}" class="title lh-1">{{ $item['comp_title'] }}</a>
                        </div>
                        <div class="col-12 prices">
                            <span class="price-{{ $item['onchange_class'] }} my-1">{{ $item['onchange'] }}</span>
                            <div class="d-flex justify-content-between align-items-center ar">
                                <span class="rubric">Пшеница 4 кл.</span>
                                <div class="d-flex align-items-center lh-1 priceItem">
                                    &nbsp;<img src="/app/assets/img/price-down.svg">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center ar">
                                <span class="rubric">Пшеница 3 кл.</span>
                                <div class="d-flex align-items-center lh-1 priceItem">
                                    &nbsp;<img src="/app/assets/img/price-down.svg">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex align-items-center justify-content-between mt-1">
                            <a href="{{ route('company.index', $item['comp_id']) }}" class="more">+ ещё 2</a>
                            <span class="time">{{ \Carbon\Carbon::parse($item['tf_change_date'])->format('H:i') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Add Arrows -->
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
        <button class="new_feed-button next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false"></button>
        <button class="new_feed-button prev" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="false"></button>
    </div>
</div>
