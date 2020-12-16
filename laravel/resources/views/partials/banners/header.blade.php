@if($banner_header)
    <div   style="z-index:2; width:100%;">
        <noindex>
            <a  href="{{$banner_header->ban_link}}" rel="nofollow"
                @if(strpos($banner_header->ban_link, "agrotender.com.ua")===false)
                target="_blank"
                    @endif
            >
            <h1>GG</h1>
                <img style="height:30px;width:100%;" src="/files/{{$banner_body->ban_file}}" >
            </a>
        </noindex></div>
@endif

