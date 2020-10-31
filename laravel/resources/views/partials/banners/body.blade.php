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

 {{--   <div style="position: absolute; opacity: 1; height: 100%; padding-left: 7rem;">
        <div class="img_explode" style="margin-left: 4rem;">
            <div id="left_banner" style="position:fixed;"></div>
        </div>
    </div>

    <div style="position: absolute; opacity: 1; height: 100%; left: 73.4%">
        <div class="img_explode2" style="margin-left: 4rem;">
            <div id="right_banner" style="position:fixed;"></div>
        </div>
    </div>--}}
@endif




<style>

    {{--/*    left    */--}}
    {{--.img_explode {--}}
    {{--    width: 400px;--}}
    {{--    height: 500px;--}}
    {{--    margin: 50px auto;--}}
    {{--    letter-spacing: -.36em;--}}
    {{--}--}}
    {{--.img_explode div {--}}
    {{--    display: inline-block;--}}
    {{--    width: 15%;--}}
    {{--    height: 80%;--}}
    {{--    background-image: url(https://agrotender.com.ua/files/{{$banner_body->ban_file}});--}}
    {{--    background-repeat: no-repeat;--}}
    {{--    vertical-align: top;--}}
    {{--    border: 2px solid red;--}}
    {{--    -webkit-box-sizing: border-box;--}}
    {{--    -moz-box-sizing: border-box;--}}
    {{--    box-sizing: border-box;--}}
    {{--}--}}
    {{--.img_explode div:nth-of-type(1) {--}}
    {{--    background-position: 28% 69%;--}}
    {{--}--}}

    {{--/*    right     */--}}
    {{--.img_explode2 {--}}
    {{--    width: 400px;--}}
    {{--    height: 500px;--}}
    {{--    margin: 50px auto;--}}
    {{--    letter-spacing: -.36em;--}}
    {{--}--}}
    {{--.img_explode2 div {--}}
    {{--    display: inline-block;--}}
    {{--    width: 15%;--}}
    {{--    height: 80%;--}}
    {{--    background-image: url(https://agrotender.com.ua/files/{{$banner_body->ban_file}});--}}
    {{--    background-repeat: no-repeat;--}}
    {{--    vertical-align: top;--}}
    {{--    border: 2px solid blue;--}}
    {{--    -webkit-box-sizing: border-box;--}}
    {{--    -moz-box-sizing: border-box;--}}
    {{--    box-sizing: border-box;--}}
    {{--}--}}
    {{--.img_explode2 div:nth-of-type(1) {--}}
    {{--    background-position: 73% 69%;--}}
    {{--}--}}

</style>

