<?php


namespace App\Services;


use App\Models\Regions\Regions;

class BaseServices
{

    public function getRegions()
    {
        $regions = Regions::get();

        return $regions;
    }
}
