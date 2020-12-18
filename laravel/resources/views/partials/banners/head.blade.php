@if(isset($banners_top) && $banners_top)
    <div class="container text-center mt-3 mb-3 tradersImages position-relative">
        <div class="row">
            @if($banners_top->count()>0)
                @foreach($banners_top as $index => $banner)
                    <div class="d-sm-block tradersImgBlock col-md-4 {{$index == 2 ? 'col-12' : 'd-none d-md-block'}}">
                        <noindex>
                            <a class="topBanners" href="{{$banner->ban_link}}" rel="nofollow"
                               @if(strpos($banner->ban_link, "agrotender.com.ua")===false)
                               target="_blank"
                                @endif>
                                <img class="header_banner img-responsive tradersImg" id="topBan" src="/files/{{$banner->ban_file}}"  alt=""/>
                            </a>
                        </noindex>
                    </div>
                @endforeach
            @endif

            @for ($i = 0; $i < (3-$banners_top->count()); $i++)
                <div class="d-block d-sm-inline-block tradersImgBlock col-md-4 col-12">
                    <noindex>
                        <a class="topBanners" href="https://agrotender.com.ua/reklama" rel="nofollow">
                            <img
                                style="width: 100%"
                                id="topBan390" src="/files/pict/ad_buys.png"
                                class="header_banner img-responsive tradersImg" alt="">
                        </a>
                    </noindex>
                </div>
            @endfor
        </div>
    </div>
@endif
