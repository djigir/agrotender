<?php


namespace App\Services;


use App\Models\Regions\Regions;

class BaseServices
{
    public function getRegions($rubric = null, $sitemap = null)
    {
        $regions = Regions::get();
        return $regions;
    }
}
