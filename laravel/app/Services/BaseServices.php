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

    public function new_unique($array, $key)
    {
        $temp_array = [];

        foreach ($array as $v) {
            if (!isset($temp_array[$v[$key]]))
                $temp_array[$v[$key]] = $v;
        }

        $array = array_values($temp_array);

        return $array;

    }

    public function keywords()
    {

    }

    public function description()
    {

    }
}
