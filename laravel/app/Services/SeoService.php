<?php

namespace App\Services;


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
    public function getCompaniesMeta()
    {

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
