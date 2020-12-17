@if(isset($banners_top) && $banners_top)
    <div class="container text-center mt-3 mb-3 tradersImages position-relative">
        <div class="row">
            @if($banners_top->count()>0)
                @foreach($banners_top as $banner)
                    <div class="d-block d-sm-inline-block tradersImgBlock col-4">
                        <noindex>
                            <a class="topBanners" href="{{$banner->ban_link}}" rel="nofollow"
                               @if(strpos($banner->ban_link, "agrotender.com.ua")===false)
                               target="_blank"
                                @endif>
                                <!-- style="width:310px; height:70px;" -->
                                <img class="header_banner img-responsive tradersImg" id="topBan" src="/files/{{$banner->ban_file}}"  alt=""/>
                            </a>
                        </noindex>
                    </div>
                @endforeach
            @endif

            @for ($i = 0; $i < (3-$banners_top->count()); $i++)
                <div class="d-block d-sm-inline-block tradersImgBlock col-4">
                    <noindex>
                        <a class="topBanners" href="https://agrotender.com.ua/reklama" rel="nofollow">
                            <img
                                id="topBan390" src="/files/pict/ad_buys.png"
                                class="header_banner img-responsive tradersImg" alt="">
                        </a>
                    </noindex>
                </div>
            @endfor
        </div>
    </div>
@endif
