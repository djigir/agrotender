<?php

namespace App\Http\Controllers;

use App\Models\Banner\BannerRotate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
       $this->setBanners();
    }

    private function setBanners() {

        $top = BannerRotate::where('dt_start' ,'<=', Carbon::now())
            ->where('dt_end', '>=' ,Carbon::now())
            ->where('archive', '=' ,'0')
            ->where('inrotate', '=' ,'1')
            ->where('place_id', '=' ,BannerRotate::TYPE_TOP)
            ->orderByRaw('RAND()')
            ->limit(3)
            ->get();


        $banner_bottom = BannerRotate::where('dt_start' ,'<=', Carbon::now())
            ->where('dt_end', '>=' ,Carbon::now())
            ->where('archive', '=' ,'0')
            ->where('inrotate', '=' ,'1')
            ->where('place_id', '=' ,BannerRotate::TYPE_FOOTER)
            ->orderByRaw('RAND()')
            ->first();

        $banner_body = BannerRotate::where('dt_start' ,'<=', Carbon::now())
            ->where('dt_end', '>=' ,Carbon::now()->addDay(-10))
            ->where('archive', '=' ,'0')
            ->where('inrotate', '=' ,'1')
            ->where('place_id', '=' ,BannerRotate::TYPE_BODY)
            ->orderByRaw('RAND()')
            ->first();

        $banner_header = BannerRotate::where('dt_start' ,'<=', Carbon::now())
            ->where('dt_end', '>=' ,Carbon::now())
            ->where('archive', '=' ,'0')
            ->where('inrotate', '=' ,'1')
            ->where('place_id', '=' ,BannerRotate::TYPE_HEADER)
            ->orderByRaw('RAND()')
            ->first();

        $banner_traders = BannerRotate::where('dt_start' ,'<=', Carbon::now())
            ->where('dt_end', '>=' ,Carbon::now())
            ->where('archive', '=' ,'0')
            ->where('inrotate', '=' ,'1')
            ->where('place_id', '=' ,BannerRotate::TYPE_INSTEAD_BUTTON)
            ->orderByRaw('RAND()')
            ->first();

        \View::share('banners_top', $top);
        \View::share('banner_bottom', $banner_bottom);
        \View::share('banner_body', $banner_body);
        \View::share('banner_header', $banner_header);
        \View::share('banner_traders', $banner_traders);

    }


}
