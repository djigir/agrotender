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
    public function getCompaniesMeta($rubric = null, $region = null, $page = 1)
    {
        if (!is_null($region)) {
            $region = Regions::where('id', $region)->get()->toArray();
        }

        if (!is_null($rubric)) {
            $rubric = CompTopic::find($rubric)->toArray();
        }
        if ($region !== null) {
            $region = $region[0];
        }
        $h1 = '';
        $text = '';
        $topic_name = ($rubric['id'] == null) ? 'Все рубрики' : $rubric['title'];
        if ($rubric != null || $region != null && $region != '') {
            if (($rubric['page_title'] != "") && ($page == 1)) {
                $r = ($region['id'] != null) ? $region : null;
                $title = $this->parseSeoText($r, $rubric['page_title']);
                $keywords = $this->parseSeoText($r, $rubric['page_keywords']);
                $description = $this->parseSeoText($r, $rubric['page_descr']);
                $h1 = $this->parseSeoText($r, $rubric['page_h1']);
                $text = $this->parseSeoText($r, $rubric['descr']);
            }elseif (($rubric == null) && ($page == 1)) {
                // Only region selected
                $title = "Каталог аграрных компаний ".($region['id'] == null ? "Украины" : $region['city_parental']." и ".$region['parental'])." области от Агротендер.";
                $keywords = "Каталог аграрных компаний ".($region['id'] == null ? "Украины" : $region['city_parental']." и ".$region['parental'])." области от Агротендер. Аграрная, АПК.";
                $description = "В каталога аграрных компаний ".($region['id'] == null ? "Украины" : $region['city_parental']." и ".$region['parental'])." области Вы сможете разместить объявления о купле/продаже интересующей вас с/х продукции.";
            }else {
                $t3words = [
                    1 => "культуры",
                    2 => "культуры",
                    16 => "культуры",
                    18 => "продукты"
                ];

                $t3seo = "";
                if (($rubric['parent_id'] != 0)) {
                    $t3seo = " (".$rubric['name'].") ";
                } else {
                    if( isset($t3words[$rubric['id']]) ) {
                        $t3seo = " ".$t3words[$rubric['id']];
                    }
                }

                $page_ptit = "";

                $title = $page_ptit.": ".$topic_name.$t3seo." в ".($region == null) ? "Украине" : $region['parental'].". Компании на сайте Agrotender.com.ua.";
                $keywords = $topic_name.$t3seo." в ".($region == null) ? "Украине" : $region['parental'];
                $description = $topic_name.$t3seo." в ".($region == null) ? "Украине" : $region['parental'].". Каталог агропромышленных компаний на Агротендер.";
            }
        }else {
            $title = 'Каталог компаний аграрного сектора Украины';
            $keywords = 'каталог компаний';
            $description = 'Сайт Агротендер представляет вашему вниманию каталог компаний аграрного сектора Украины.';
        }

        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
    }

    public function getTradersMeta()
    {

    }

    public function getAnaliticMeta()
    {

    }

    public function parseSeoText($region, $str)
    {
        $obl1 = ($region['name'] != null) ? $region['name'] . ' область' : 'Украина';
        $obl2 = ($region['parental'] != null) ?  $region['parental']. ' области' : '';
        $city1 = $region['city'] ?? '';
        $city2 = $region['city_adverb'] ?? 'Украине';
        $city3 = $region['city_parental'] ?? 'Украины';
        $seostr = $str;
        $seostr = str_replace("__oblname__", $obl1, $seostr);
        $seostr = str_replace("__oblname2__", $obl2, $seostr);
        $seostr = str_replace("__cityname__", $city1, $seostr);
        $seostr = str_replace("__cityname2__", $city2, $seostr);
        $seostr = str_replace("__cityname3__", $city3, $seostr);

        $year = date("Y", time());

        $seostr = str_replace("__year__", $year, $seostr);

        return $seostr;
    }
}
