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

    public function getCompaniesMeta($data)
    {
        $rubric = CompTopic::where('id', $data['rubric'])->get()->toArray();
        $rubric = !$rubric ? null : $rubric[0];
        $region = !$data['region'] ? $data['region'] : Regions::where('id', $data['region'])->get()->toArray()[0];

        $h1 = '';
        $text = '';
        $t3seo = "";
        $title = !$region ? 'Каталог компаний аграрного сектора Украины' : "Каталог аграрных компаний {$region['city_parental']} и {$region['parental']} области от Агротендер";
        $keywords = !$region ? 'каталог компаний' : "Каталог аграрных компаний {$region['city_parental']} в {$region['parental']} области от Агротендер. Аграрная, АПК";
        $description = !$region ? 'Сайт Агротендер представляет вашему вниманию каталог компаний аграрного сектора Украины.' :
            "В каталога аграрных компаний {$region['city_parental']} и {$region['parental']} области Вы сможете разместить объявления о купле/продаже интересующей вас с/х продукции";
        if ($rubric != null) {
            $title = !$region? $this->parseSeoText($region, $rubric['page_title']) : "{$rubric['title']} хозяйства {$region['city_parental']} {$region['parental']} области. Каталог компаний от Агротендер";
            $keywords = !$region != null ? $this->parseSeoText($region, $rubric['page_keywords']) : "Каталог, {$rubric['title']} хозяйства, {$region['city_parental']}, {$region['parental']} области";
            $description = !$region ? $this->parseSeoText($region, $rubric['page_descr']) : "В каталоге компаний от Агротендер Вы всегда сможете найти информацию про {$rubric['title']} хозяйствам {$region['city_parental']} {$region['parental']} области, а так же их актуальные закупки и продажи.";
            $h1 = !$region ? $this->parseSeoText($region, $rubric['page_h1']) : '';
            $text = !$region ? $this->parseSeoText($region, $rubric['page_descr']) : '';
        }
        if ($region != null && !empty($rubric)) {
            $title = $this->parseSeoText($region, $rubric['page_title']);
            $keywords = $this->parseSeoText($region, $rubric['page_keywords']);
            $description = $this->parseSeoText($region, $rubric['page_descr']);
            $h1 = $this->parseSeoText($region, $rubric['page_h1']);
            $text = $this->parseSeoText($region, $rubric['page_descr']);
        }

        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
    }


    public function getTradersMetaRegion($region, $culture)
    {
        if(empty($region)){
            return false;
        }

        $year = date('Y');
        $yearsText = $year . '-' . ($year + 1);

        $h1 =  $region == 'ukraine' ? "Цены трейдеров в Украине" : "Цена Аграрной продукции в {$region['parental']} области";
        $title =  $region == 'ukraine' ?  "Закупочные цены зернотрейдеров Украины на сегодня - Agrotender.ua"
            : "Цена Аграрной продукции за тонну в {$region['parental']} области сегодня. Закупочные цены трейдеров {$year}";
        $keywords = $region == 'ukraine' ?  "Закупочные, цены, трейдеры, Украина" : "Цена, стоимость, экспорт, Аграрная продукция, {$region['name']} область";
        $description = $region == 'ukraine' ?  "Продажа аграрной продукции крупнейшим трейдерам и переработчикам Украины. Только свежие и актуальные закупки без посредников. Динамика закупочных цен на сегодня."
            : "Стоимость Аграрной продукции на портале Agrotender. Продажа Аграрной продукции крупнейшим зернотрейдерам в {$region['parental']} области без посредников за гривну и валюту.";
        $text = '';

        if ($culture) {
            $h1 = $region != 'ukraine' ? "Цена {$culture['name']} в {$region['parental']} области" : "Цена {$culture['name']} в Украине";
            $title = $region != 'ukraine' ? "Цена {$culture['name']} за тонну в {$region['parental']} области сегодня. Закупочные цены трейдеров {$year}" : "Цена {$culture['name']} за тонну в Украине сегодня. Закупочные цены трейдеров {$year}";
            $keywords = $region != 'ukraine' ? "Цена, стоимость, экспорт, {$culture['name']}, {$region['name']} область" : "Цена, стоимость, экспорт, {$culture['name']}, Украина";
            $description = $region != 'ukraine' ? "Стоимость {$culture['name']} на портале Agrotender. Продажа {$culture['name']} крупнейшим зернотрейдерам в {$region['parental']} области без посредников за гривну и валюту."
                : "Стоимость {$culture['name']} на портале Agrotender. Продажа {$culture['name']} крупнейшим зернотрейдерам в Украине без посредников за гривну и валюту.";
            $text = '';
        }

        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
    }

    public function getTradersMetaPort($port, $culture)
    {
        if(empty($port)){
            return false;
        }

        $h1 = $port == "all" ? "Цена на Аграрную продукцию в портах Украины" : $port['p_h1'];
        $title = $port == "all" ?  "Цена аграрной продукции в портах Украины. Закупочные цены на сегодня от Agrotender." : $port['p_title'];
        $keywords = $port == "all" ?  "Закупочные, цены, трейдеры, Украина" : $port['p_title'];
        $description = $port == "all" ?  "Закупочные цены трейдеров на Аграрную продукцию в портах Украины. Контакты трейдеров и актуальные цены на сегодня. Стоимость в гривне и долларе." : $port['p_descr'];
        $text = $port == "all" ? '' : $port['p_content'];

        if ($culture) {
            $h1 =  $port != "all" ? "Цена на {$culture['name']} в {$port['portname']}" : "'Цена на {$culture['name']} в портах Украины'";
            $title = $port != "all" ? "Цена на {$culture['name']} в {$port['portname']}."  : "Цена на {$culture['name']} в портах Украины";
            $title .= " Закупочные цены на сегодня от Agrotender.";
            $keywords = $port != "all" ? "{$culture['name']}, цена, {$port['portname']}, трейдеры, экспортеры" : '';
            $description = $port != "all" ? "Закупочные цены трейдеров на {$culture['name']} в {$port['portname']}. " : "Закупочные цены трейдеров на {$culture['name']} в портах Украины";
            $description .= 'Контакты трейдеров и актуальные цены на сегодня. Стоимость в гривне и долларе.';
            $text = $port != "all" ? $port['p_content'] : '';
        }

        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
    }

    public function getTradersMetaForward($region, $culture, $port)
    {
        if(empty($region)){
            return false;
        }
        $year = date('Y');
        $yearsText = $year . '-' . ($year + 1);

        $h1 =  $region == "ukraine" ? "Форвардная цена на {$culture['name']} в Украине" : "Форвардная цена на {$culture['name']} в {$culture['name']} области";
        $title = $region == "ukraine" ? "Форвардная цена на {$culture['name']} в Украине на {$yearsText}" : "Форвардная цена на {$culture['name']} в {$region['parental']} области на {$yearsText}";
        $keywords = $region == "ukraine" ? "Форварды, цена, стоимость, экспорт, {$culture['name']}, Украина" : "Форварды, цена, стоимость, экспорт, {$culture['name']}, {$region['name']} область";
        $description = $region == "ukraine" ? "Актуальные форвардные цены на {$culture['name']} от крупнейших зернотрейдеров Украины. Стоимость {$culture['name']} в гривне и долларе на {$yearsText}." : "Актуальные форвардные цены на {$culture['name']} от крупнейших зернотрейдеров {$region['name']} области. Стоимость {$culture['name']} в гривне и долларе на {$yearsText}.";
        $text = '';
        if ($port != null) {
            dd('f port');
        }


        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
    }

    public function getTradersMetaSell($region, $culture)
    {
        if(empty($region)){
            return false;
        }
        $year = date('Y');
        $yearsText = $year . '-' . ($year + 1);

        $h1 =  '';
        $title = "";
        $keywords = '';
        $description = '';
        $text = '';

        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
    }

    public function getTradersMeta($data)
    {
        $meta_region = $this->getTradersMetaRegion($data['region'], $data['rubric']);
        $meta_port = $this->getTradersMetaPort($data['port'], $data['rubric']);
        $meta_forward = $this->getTradersMetaForward($data['region'], $data['rubric'], $data['port']);
        $meta_sell = $this->getTradersMetaSell($data['region'], $data['rubric']);
        if ($meta_forward && $data['type'] == 1) {
            return $meta_forward;
        }
        if($meta_sell && $data['type'] == 2) {
            return $meta_sell;
        }

        if ($meta_region) {
            return $meta_region;
        }

        if ($meta_port) {
            return $meta_port;
        }

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

        return ['title' => "Контакты трейдера {$company->title} - узнать на Agrotender",
            'keywords' => $company->title,
            'description' => "На этой странице Вы сможете ознакомиться с контактной информацией трейдера {$company->title}. Агрорынок №1 для покупки и сбыта сельскохозяйственной продукции. У нас выгодно!"];
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
