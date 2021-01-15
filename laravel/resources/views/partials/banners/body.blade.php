@if(isset($banner_body) && $banner_body)
    <a href="{{$banner_body->ban_link}}" id="body{{$banner_body->id}}" class="sidesLink bodyBanners"
    style="background: url('https://agrotender.com.ua/files/{{$banner_body->ban_file}}'); display: inline-table; height: 0%; width: 471px;"
    rel="nofollow"
    @if(strpos($banner_body->ban_link, "agrotender.com.ua")===false)
        target="_blank"
    @endif
    >
        <img src="https://agrotender.com.ua/files/{{$banner_body->ban_file}}" alt="">
    </a>

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
