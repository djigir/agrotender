<div class="container text-center mt-3 mb-3 tradersImages position-relative">
    @if($banners_top->count()>0)
        @foreach($banners_top as $banner)
            <div class="d-block d-sm-inline-block tradersImgBlock">
                <noindex>
                    <a class="topBanners" href="{{$banner->ban_link}}" rel="nofollow"
                       @if(strpos($banner->ban_link, "agrotender.com.ua")===false)
                       target="_blank"
                            @endif
                    >
                        <img
                                style="width:310px; height:70px;" id="topBan'.$banner['id'].'"
                                src="/files/{{$banner->ban_file}}" class="img-responsive tradersImg" alt=""/>
                    </a>
                </noindex>
            </div>
        @endforeach
    @endif

    @for ($i = 0; $i < (3-$banners_top->count()); $i++)
        <div class="d-block d-sm-inline-block tradersImgBlock">
            <noindex><a class="topBanners" href="https://agrotender.com.ua/reklama" rel="nofollow"><img
                            style="width:310px; height:70px;" id="topBan390" src="/files/pict/ad_buys.png"
                            class="img-responsive tradersImg" alt=""></a></noindex>
        </div>
    @endfor
</div>
