@if(isset($banner_body) && $banner_body)
{{--    <div style="position: absolute; opacity: 1; height: 100%;">--}}

{{--        <a href="{{$banner_body->ban_link}}" id="body{{$banner_body->id}}" class="sidesLink bodyBanners"--}}
{{--           style="background: url('https://agrotender.com.ua/files/{{$banner_body->ban_file}}'); display: inline-table; height: 0%; width: 471px;"--}}
{{--        rel="nofollow"--}}
{{--        @if(strpos($banner_body->ban_link, "agrotender.com.ua")===false)--}}
{{--            target="_blank"--}}
{{--        @endif--}}
{{--        >--}}

{{--            <img src="https://agrotender.com.ua/files/{{$banner_body->ban_file}}" alt="" style="">--}}
{{--            <canvas width="471" height="1059"--}}
{{--                    style="right: calc((100vw - 978px) / 1.92 + 958px); position: fixed; height: 92%; top: 0px; cursor: pointer; z-index: 1;"></canvas>--}}

{{--        </a>--}}
{{--    </div>--}}

{{--    <div style="position: absolute; opacity: 1; height: 100%;">--}}

{{--        <a href="{{$banner_body->ban_link}}" id="body{{$banner_body->id}}" class="sidesLink bodyBanners"--}}
{{--           style="background: url('https://agrotender.com.ua/files/{{$banner_body->ban_file}}') right center; display: inline-table; height: 0%; width: 471px;"--}}
{{--        rel="nofollow"--}}
{{--        @if(strpos($banner_body->ban_link, "agrotender.com.ua")===false)--}}
{{--            target="_blank"--}}
{{--        @endif--}}
{{--        >--}}

{{--            <img src="https://agrotender.com.ua/files/{{$banner_body->ban_file}}" alt="" style="">--}}
{{--            <canvas width="471" height="1059" style="left: calc((100vw - 978px) / 1.92 + 958px); position: fixed; height: 92%; top: 0px; cursor: pointer; z-index: 1;"></canvas>--}}

{{--        </a>--}}
{{--    </div>--}}

    <div style="position: absolute; bottom: 0;">
        <a href="{{$banner_body->ban_link}}" @if(strpos($banner_body->ban_link, "agrotender.com.ua")===false) target="_blank"@endif>
            <div id="left_banner" style="position:fixed; height: 92%;  z-index: 1;
            right: calc((100% - 978px) / 1.92 + 965px);
            top: 0;">
            </div>
        </a>
    </div>

    <div style="position: absolute; left: 76%; bottom: 0">
        <a href="{{$banner_body ? $banner_body->ban_link : '#'}}" @if(strpos($banner_body ? $banner_body->ban_link : '', "agrotender.com.ua")===false) target="_blank" @endif>
            <div id="right_banner" style="position:fixed; height: 92%; top: 0; z-index: 1;
            left: calc((100% - 978px) / 1.92 + 965px); "></div>
        </a>
    </div>

<style>
    #left_banner{
        display: inline-block;
        width: 300px;
        background: url(https://agrotender.com.ua/files/{{$banner_body->ban_file}}) 28% 50% no-repeat;
        box-sizing: border-box;
    }

    #right_banner{
        display: inline-block;
        width: 300px;
        background: url(https://agrotender.com.ua/files/{{$banner_body->ban_file}}) 73% 50% no-repeat;
        box-sizing: border-box;
    }

    @media (max-height: 768px) and  (max-width: 1400px){
        #left_banner, #right_banner{
            background-position-y: 30%;
        }

        #left_banner{
            background-size: auto 108%;
            background-position-x: 8%;
        }

        #right_banner{
            background-size: auto 108%;
            background-position-x: 90%;
        }
    }

    @media screen and (max-width: 1240px) {
        #right_banner,
        #left_banner {
            display: none
        }
    }
</style>
@endif
