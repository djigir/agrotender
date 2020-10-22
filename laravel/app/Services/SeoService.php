<?php

namespace App\Services;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopic;
use App\Models\Regions\Regions;

use App\Models\Pages\Pages;
use App\Models\Seo\SeoTitles;
use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersPortsLang;
use App\Models\Traders\TradersProductGroupLanguage;
use Carbon\Carbon;


class SeoService
{
    public function getPageInfo($page)
    {
        $info = Pages::join('pages_lang', 'pages.id', '=', 'pages_lang.item_id')
                ->where('pages.page_name', [isset($page) ? $page : null])
                ->get()
                ->toArray();
        return $info;
    }

    public function getBoardMeta()
    {

    }
    public function getCompaniesMeta($data)
    {
        $t3seo = '';
        $h1 = '';
        $text = '';
        $region_name_parental = "Украине";
        $t3words = [
            1 => "культуры",
            2 => "культуры",
            16 => "культуры",
            18 => "продукты"
        ];
        $topic_name = 'Все рубрики';
        $title = 'Каталог компаний аграрного сектора Украины';
        $keywords = 'каталог компаний';
        $description = 'Сайт Агротендер представляет вашему вниманию каталог компаний аграрного сектора Украины.';

        $rubric = CompTopic::where('id', $data['rubric'])->get()->toArray();
        $rubric = !empty($rubric) ? $rubric[0] : $data['rubric'];

        $region = Regions::where('id', $data['region'])->get()->toArray();
        $region = !empty($region) ? $region[0] : $data['region'];

        if(!empty($rubric['id'])){
            $topic_name =  $rubric['page_title'];
        }

        if(!empty($data['rubric']) || !empty($region)){
            if($data['page'] == 1) {
                $title = "Каталог аграрных компаний ".$region['city_parental']." и ".$region['parental']." области от Агротендер.";
                $keywords = "Каталог аграрных компаний ".$region['city_parental']." и ".$region['parental']." области от Агротендер. Аграрная, АПК.";
                $description = "В каталога аграрных компаний ".$region['city_parental']." и ".$region['parental']." области Вы сможете разместить объявления о купле/продаже интересующей вас с/х продукции.";

            }elseif(is_array($rubric) && $rubric['page_title'] != "" && $data['page'] == 1) {
                $title = $this->parseSeoText($region, $rubric['page_title']);
                $keywords = $this->parseSeoText($region, $rubric['page_keywords']);
                $description = $this->parseSeoText($region, $rubric['page_descr']);
                $h1 = $this->parseSeoText($region, $rubric['page_h1']);
                $text = $this->parseSeoText($region, $rubric['page_descr']);

            }else{

                if(is_array($rubric) && isset($t3words[$rubric['id']])) {
                    $t3seo = " ".$t3words[$data['rubric']['id']];
                }
                if (isset($data['rubric']['parent_id']) && $data['rubric']['parent_id'] != 0)
                {
                    $t3seo = " (".$data['rubric']['name'].") ";
                }

                if(!empty($region)){
                    $region_name_parental = $region['parental'];
                }

                $title = ' : '.$topic_name.$t3seo." в ".$region_name_parental.". Компании на сайте Agrotender.com.ua.";
                $keywords = $topic_name.$t3seo." в ".$region_name_parental;
                $description = $topic_name.$t3seo." в ".$region_name_parental.". Каталог агропромышленных компаний на Агротендер.";
            }
        }

        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
    }


    public function getTradersMeta($rubric = null, $region = null, $port = null, $type = 0, $page = 1, $onlyPorts = null)
    {
        $region = Regions::where('translit', $region)->get()->toArray();
        if ($rubric !== null) {
            $rubric = Traders_Products_Lang::where('name', $rubric)->get()->toArray();
        }
        if ($port !== null) {
            $port = TradersPortsLang::where('portname', $port)->get()->toArray();
        }
        $h1 = '';
        $text = '';
        $rubricText = ($rubric != null) ? $rubric[0]['name'] : 'Аграрной продукции';

        if (!empty($region) && !is_null($region)) {
            $regionText = (!empty($region[0])) ? $region[0]['parental'].' области' : 'Украине';
        }else{
            $regionText = ($region != null) ? $region['parental'].' области' : 'Украине';
        }

        $year = date('Y');
        $yearsText = $year . '-' . ($year + 1);
        if ($rubric != null || !empty($region) && $region[0] != null) {
            $seo = SeoTitles::where('pagetype', 2)
                ->where('sect_id', 0)
                ->where('obl_id', [!empty($region[0]['id']) ? $region[0]['id'] : 0])
                ->where('cult_id', $rubric[0]['id'])
                ->where('type_id', $type)
                ->get()
                ->toArray();
            if (!empty($port)) {

                if ($type == 1) {
                    $h1 = $rubric[0]['name'] . " - отпускная цена в " . $port[0]['portname'];
                    $title = $rubric[0]['name'] . ": отпускная цена в " . $port[0]['portname'] . " - Agrotender";
                    $keywords = $rubric[0]['name'] . ", отпускная, цена, " . $port[0]['portname'] . ", трейдеры, экспортеры";
                    $description = "Самые свежие отпускные цены на " . $rubric[0]['name'] . " от ведущих трейдеров в терминалах " . $port[0]['portname'] . ".";
                } elseif ($type == 0) {
                    $h1 = "Цена " . $rubric['name'] . " " . $port['name'];
                    $title = $rubric['name'] . ": закупочная цена " . $port['name'] . " - Agrotender";
                    $keywords = $rubric['name'] . ", цена, " . $port['name'] . ", трейдеры, экспортеры";
                    $description = "Актуальные закупочные цены на " . $rubric['name'] . " сегодня в терминалах " . $port['name'] . ". Экспортные цены за тонну и контакты крупнейших трейдеров.";
                } elseif ($type == 3) {
                    $rubric_text = $rubric != null ? $rubric['name'] : 'аграрную продукцию';

                    $h1 = "Форвардная цена " . $rubric['name'] . " " . $port['name'];
                    $title = $rubric['name'] . ": форвардная цена " . $port['name'] . ' на ' . $yearsText;
                    $keywords = $rubric['name'] . ", форварды, цена, " . $port['name'] . ", трейдеры, экспортеры";
                    $description = "Актуальные форвардные цены на " . $rubric['name'] . " в терминалах " . $port['name'] . '. Стоимость ' . $rubric['name'] . " в гривне и долларе на $yearsText.";
                }
            } elseif ($seo != null) {
                if (isset($seo[0])) {
                    $title = $this->parseSeoText($region, $seo[0]['page_title']);
                    $keywords = $this->parseSeoText($region, $seo[0]['page_keywords']);
                    $description = $this->parseSeoText($region, $seo[0]['page_descr']);
                    $h1 = $this->parseSeoText($region, $seo[0]['page_h1']);
                    $text = $this->parseSeoText($region, $seo[0]['content_text']);
                } else {
                    $title = $this->parseSeoText($region, $seo['page_title']);
                    $keywords = $this->parseSeoText($region, $seo['page_keywords']);
                    $description = $this->parseSeoText($region, $seo['page_descr']);
                    $h1 = $this->parseSeoText($region, $seo['page_h1']);
                    $text = $this->parseSeoText($region, $seo['content_text']);
                }

                if ($page > 1) {
                    $title = "Стр. " . $page . ", " . $title;
                }
            } elseif ($type == 1) {
                $h1 = ($rubric != null ? $rubric['name'] : 'Аграрная продукция') . ": предложения от трейдеров и переработчиков в $regionText";
                $title = ($rubric != null ? $rubric['name'] : 'Аграрная продукция') . ": реализация в $regionText. Цены от переработчиков и трейдеров.";
                $keywords = ($rubric != null ? $rubric['name'] : 'Аграрная продукция') . ", " . ($region != null ? $region['name'] . ' область' : 'Украина') . ", реализация, сбыт";
                $description = "Реализация $rubricText переработчиками и трейдерами в $regionText. Найдите постоянных поставщиков без посредников по самой выгодной цене. Только актуальные предложения на Agrotender.";
            } elseif ($type == 0) {
                $h1 = "Цена $rubricText в $regionText";
                $title = "Цена $rubricText за тонну в $regionText сегодня. Закупочные цены трейдеров " . date('Y');
                $keywords = "Цена, стоимость, экспорт, " . ($rubric != null ? $rubric[0]['name'] : 'Аграрная продукция') . ", " . ($region != null ? $region[0]['name'] . ' область' : 'Украина');
                $description = "Стоимость $rubricText на портале Agrotender. Продажа $rubricText крупнейшим зернотрейдерам в $regionText без посредников за гривну и валюту.";
            } elseif ($type == 3) {
                $rubric_text = $rubric != null ? $rubric['name'] : 'аграрную продукцию';

                $h1 = 'Форвардная цена на ' . $rubric_text . ' в ' . ($region != null ? $region['name'] . ' области' : 'Украине');
                $title = 'Форвардная цена на ' . $rubric_text . ' в ' . ($region != null ? $region['name'] . ' области' : 'Украине') . ' на ' . $yearsText;
                $description = 'Актуальные форвардные цены на ' . $rubric_text . ' от крупнейших зернотрейдеров ' . ($region != null ? $region['name'] . ' области' : 'Украины') . '. Стоимость ' . ($rubric != null ? $rubric['name'] : 'аграрной продукции') . " в гривне и долларе на $yearsText.";
                $keywords = "Форварды, цена, стоимость, экспорт, " . ($rubric != null ? $rubric['name'] : 'Аграрная продукция') . ", " . ($region != null ? $region['name'] . ' область' : 'Украина');
            }
        } elseif (!empty($port)) {
            $h1 = $port[0]['h1'] ?? '';
            $title = $port[0]['p_title'] ?? '123123';
            $keywords = "аграрная продукция, цена, " . $port[0]['p_title'];
            $description = $port[0]['p_descr'] ?? '';
        } elseif ($region == null && $rubric == null && $type == 1) {
            $h1 = "Продажи трейдеров";
            $title = "Отпускные цены трейдеров в Украине на аграрную продукцию";
            $keywords = "отпускная цена, Украина, агропродукция, трейдеры, экспортеры";
            $description = "Самые свежие отпускные цены на агарную продукцию от ведущих трейдеров Украины на портале Agrotender. Следите за изменением цен и читайте обновления от трейдеров.";
        } elseif ($region == null && $rubric == null && $type == 3) {
            $h1 = 'Форвардная цена на аграрную продукцию';
            $title = 'Форвардная цена на аграрную продукцию в Украине на ' . $yearsText;
            $keywords = 'Форварды, цена, стоимость, экспорт, Аграрная продукция, Украина';
            $description = "Актуальные форвардные цены на аграрную продукцию от крупнейших зернотрейдеров Украины. Стоимость аграрной продукции в гривне и долларе на $yearsText.";
        } else {
            $pageInfo = $this->getPageInfo('traders');
            $title = $pageInfo[0]['page_title'];
            $keywords = $pageInfo[0]['page_keywords'];
            $description = $pageInfo[0]['page_descr'];
        }
        if ($onlyPorts != null && $type == 3) {
            $h1 = "Форвардная цена на " . ($rubric != null ? $rubric['name'] : 'аграрную продукцию') . " в " . (!empty($port) ? $port['name'] : 'портах Украины');
            $title = "Форвардная цена " . ($rubric != null ? $rubric['name'] : 'аграрной продукции') . " в " . (!empty($port) ? $port['name'] : 'портах Украины') . ' на ' . $yearsText;
            $keywords = 'Форварды, цена, стоимость, экспорт, Аграрная продукция, Украина, ' . ($port != null ? $port['name'] : 'порты Украины');
            $description = "Актуальные форвардные цены на " . ($rubric != null ? $rubric['name'] : 'аграрную продукцию') . " в " . (!empty($port) ? $port['name'] : 'портах Украины') . ". Стоимость аграрной продукции в гривне и долларе на $yearsText.";
        } elseif ($onlyPorts != null) {
            $title = "Цена ".($rubric != null ? $rubric[0]['name'] : 'аграрной продукции')." в ".($port != null ? $port[0]['portname'] : 'портах Украины').". Закупочные цены на сегодня от Agrotender.";
            $description = "Закупочные цены трейдеров на ".($rubric != null ? $rubric[0]['name'] : 'Аграрную продукцию')." в ".($port != null ? $port[0]['portname'] : 'портах Украины').". Контакты трейдеров и актуальные цены на сегодня. Стоимость в гривне и долларе.";
            $h1 = "Цена на ".($rubric != null ? $rubric[0]['name'] : 'Аграрную продукцию')." в ".($port != null ? $port[0]['portname'] : 'портах Украины');
        }

        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
    }

    public function getMetaForOneCompany($company)
    {
        $company = CompItems::find($company)->toArray();

        $title = $company['title'].": цены, контакты, отзывы";

        if ($company['trader_price_avail'] == 1 && $company['trader_price_visible'] == 1) {
            $title = "Закупочные цены {$company['title']} на сегодня: контакты, отзывы";
        }

        $keywords = $company['title'];
        $description = mb_substr(strip_tags($company['content']), 0, 200);

        return ['title' => $title, 'keywords' => $keywords, 'description' => $description];
    }

    public function getMetaCompanyContacts($id_company)
    {
        $company = CompItems::find($id_company);
        return ['title' => $company->title, 'keywords' => $company->title, 'description' => 'Сайт компании '.$company->title];
    }

    public function getMetaCompanyReviews($id_company)
    {
        $company = CompItems::find($id_company);

         return   ['title' => "Отзывы о {$company->title} на сайте Agrotender",
            'keywords' => $company->title,
            'description' => "Свежие и актуальные отзывы о компании {$company->title}. Почитать или оставить отзыв о компании {$company->title}"];
    }

    public function parseSeoText($region, $str)
    {
        $obl1 = (!empty($region['name'])) ? $region['name'] . ' область' : 'Украина';
        $obl2 = (!empty($region['parental'])) ?  $region['parental']. ' области' : '';
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
