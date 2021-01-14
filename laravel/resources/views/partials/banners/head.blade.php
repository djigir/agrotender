@if(isset($banners_top) && $banners_top)
    <div class="new_container text-center mt-3 mb-3 tradersImages position-relative ">
        <div class="banners_top">
            @if($banners_top->count()>0)
                @foreach($banners_top as $index => $banner)
                    <div class="d-sm-block tradersImgBlock">
                        <noindex>
                            <a class="topBanners" href="{{$banner->ban_link}}" rel="nofollow"
                               @if(strpos($banner->ban_link, "agrotender.com.ua")===false)
                               target="_blank"
                                @endif>
                                <!-- style="height: auto"  -->
                                <img class="header_banner img-responsive tradersImg" id="topBan" src="/files/{{$banner->ban_file}}"  alt=""/>
                            </a>
                        </noindex>
                    </div>
                @endforeach
            @endif

            @for ($i = 0; $i < (3-$banners_top->count()); $i++)
                <div class="d-block d-sm-inline-block tradersImgBlock">
                    <noindex>
                        <a class="topBanners" href="https://agrotender.com.ua/reklama" rel="nofollow">
                        <!-- style="width: 100%; height: auto" -->
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
