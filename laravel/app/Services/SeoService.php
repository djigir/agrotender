<?php

namespace App\Services;



use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;

use App\Models\Pages\Pages;


class SeoService
{
    public function getPageInfo($page)
    {
        dd(Pages::where('page_name', $page)->get()->toArray());
        return Pages::where('page_name', $page)->get()->toArray();
    }

    public function getBoardMeta()
    {

    }
    public function getCompaniesMeta($rubric = null, $region = null, $page = null)
    {

        if (!is_null($region)) {
            $region = Regions::where('translit', $region)->get()->toArray();
        }

        if (!is_null($rubric)) {
            $rubric = CompTopic::find($rubric)->toArray();
        }

        dd($rubric, $region, $page);
    }
    public function getTradersMeta()
    {

    }
    public function getAnaliticMeta()
    {

    }
    public function parseSeoText()
    {

    }
}
