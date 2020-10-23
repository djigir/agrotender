@if($banner_traders)
<div class="text-center">
    <div class="d-block d-sm-inline-block mx-2 position-relative">
        <noindex>
            <a class="bottomBanners" href="{{$banner_bottom->ban_link}}" rel="nofollow"
               @if(strpos($banner_bottom->ban_link, "agrotender.com.ua")===false)
               target="_blank"
                    @endif            >
                <img style=" height:120px;" src="/files/{{$banner_bottom->ban_file}}"
                     class="tradersImgBottom"
                     id="bottom-b"></a>
        </noindex>
    </div>
</div>
@endif