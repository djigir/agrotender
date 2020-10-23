@if(isset($banner_body))

    <div style="position: absolute; opacity: 1; height: 100%;">

        <a href="{{$banner_body->ban_link}}" id="body{{$banner_body->id}}" class="sidesLink bodyBanners"
           style="background: url('https://agrotender.com.ua/files/{{$banner_body->ban_file}}'); display: inline-table; height: 0%; width: 471px;"
        rel="nofollow"
        @if(strpos($banner_body->ban_link, "agrotender.com.ua")===false)
            target="_blank"
        @endif
        >

            <img src="https://agrotender.com.ua/files/{{$banner_body->ban_file}}" alt="" style="">
            <canvas width="471" height="1059"
                    style="right: calc((100vw - 978px) / 1.92 + 958px); position: fixed; height: 100%; top: 0px; cursor: pointer; z-index: 1;"></canvas>

        </a>
    </div>

    <div style="position: absolute; opacity: 1; height: 100%;">

        <a href="{{$banner_body->ban_link}}" id="body{{$banner_body->id}}" class="sidesLink bodyBanners"
           style="background: url('https://agrotender.com.ua/files/{{$banner_body->ban_file}}') right center; display: inline-table; height: 0%; width: 471px;"
        rel="nofollow"
        @if(strpos($banner_body->ban_link, "agrotender.com.ua")===false)
            target="_blank"
        @endif
        >

            <img src="https://agrotender.com.ua/files/{{$banner_body->ban_file}}" alt="" style="">
            <canvas width="471" height="1059" style="left: calc((100vw - 978px) / 1.92 + 958px); position: fixed; height: 100%; top: 0px; cursor: pointer; z-index: 1;"></canvas>

        </a>
    </div>
@endif

