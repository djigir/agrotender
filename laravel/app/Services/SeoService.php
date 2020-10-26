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
        if ($region != null) {
            $title = $this->parseSeoText($region, $rubric['page_title']);
            $keywords = $this->parseSeoText($region, $rubric['page_keywords']);
            $description = $this->parseSeoText($region, $rubric['page_descr']);
            $h1 = $this->parseSeoText($region, $rubric['page_h1']);
            $text = $this->parseSeoText($region, $rubric['page_descr']);
        }

        $t3words = [
            1 => "культуры",
            2 => "культуры",
            16 => "культуры",
            18 => "продукты"
        ];
        $topic_name = (empty($rubric['id'])) ? 'Все рубрики' : $rubric['page_title'];


        /*if (($data['rubric']) != null || $region!= null && $region != '') {
            if ((!empty($rubric['page_title'])) && ($data['page'] == 1)) {
                $r = ($region != null) ? $region : null;
                $title = $this->parseSeoText($r, $rubric['page_title']);
                $keywords = $this->parseSeoText($r, $rubric['page_keywords']);
                $description = $this->parseSeoText($r, $rubric['page_descr']);
                $h1 = $this->parseSeoText($r, $rubric['page_h1']);
                $text = $this->parseSeoText($r, $rubric['page_descr']);
            }elseif (($data['rubric'] == null) && ($data['page'] == 1)) {
                // Only region selected
                $title = "Каталог аграрных компаний ".($region['id'] == null ? "Украины" : $region['city_parental']." и ".$region['parental'])." области от Агротендер.";
                $keywords = "Каталог аграрных компаний ".($region['id'] == null ? "Украины" : $region['city_parental']." и ".$region['parental'])." области от Агротендер. Аграрная, АПК.";
                $description = "В каталога аграрных компаний ".($region['id'] == null ? "Украины" : $region['city_parental']." и ".$region['parental'])." области Вы сможете разместить объявления о купле/продаже интересующей вас с/х продукции.";
            }else {



                if ((!empty($data['rubric']['parent_id']) && $data['rubric']['parent_id'] != 0)) {
                    $t3seo = " (".$data['rubric']['name'].") ";
                } else {
                    if(!isset($t3words[$data['rubric']])) {
                        $title = "Каталог аграрных компаний {$region['city_parental']} и {$region['parental']} области от Агротендер.";
                        $keywords = "Каталог аграрных компаний {$region['city_parental']} и {$region['parental']} от Агротендер. Аграрная, АПК.";
                        $description = "В каталога аграрных компаний {$region['city_parental']} и {$region['parental']} области Вы сможете разместить объявления о купле/продаже интересующей вас с/х продукции.";
                        return ['title' => $title, 'keywords' => $keywords, 'description' => $description];
//                        $t3seo = " ".$t3words[$data['rubric']['id']];
                    }
                }

                $page_ptit = "";

                $title = $page_ptit.": ".$topic_name.$t3seo." в ".($region == null) ? "Украине" : $region['parental'].". Компании на сайте Agrotender.com.ua.";
                $keywords = $topic_name.$t3seo." в ".($region == null) ? "Украине" : $region['parental'];
                $description = $topic_name.$t3seo." в ".($region == null) ? "Украине" : $region['parental'].". Каталог агропромышленных компаний на Агротендер.";
            }
        }

        if (empty($rubric)) {
            $title = "Каталог аграрных компаний ".($region['id'] == null ? "Украины" : $region['city_parental']." и ".$region['parental'])." области от Агротендер.";
            $keywords = "Каталог аграрных компаний ".($region['id'] == null ? "Украины" : $region['city_parental']." и ".$region['parental'])." области от Агротендер. Аграрная, АПК.";
            $description = "В каталога аграрных компаний ".($region['id'] == null ? "Украины" : $region['city_parental']." и ".$region['parental'])." области Вы сможете разместить объявления о купле/продаже интересующей вас с/х продукции.";
            return ['title' => $title, 'keywords' => $keywords, 'description' => $description];
        }*/

        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
    }


    public function getTradersMetaRegion($region, $culture, $type)
    {
        if(empty($region)){
            return false;
        }

        $year = date('Y');
        $yearsText = $year . '-' . ($year + 1);

        $seo = SeoTitles::where([['pagetype', 2], ['sect_id', 0], [function($query){
            if(isset($region['id'])){
                $query->where('obl_id',$region['id']);
            }
        }],[function($query){
            if(isset($culture['id'])){
                $query->where('cult_id', $culture['id']);
            }
        }], ['type_id', $type]])->get()->toArray();

        if ($region != null && is_array($region)) {
            $h1 =  "Цена Аграрной продукции в {$region['parental']} области";
            $title = "Цена Аграрной продукции за тонну в {$region['parental']} области сегодня. Закупочные цены трейдеров {$year}";
            $keywords = "Цена, стоимость, экспорт, Аграрная продукция, {$region['name']} область";
            $description = "Стоимость Аграрной продукции на портале Agrotender. Продажа Аграрной продукции крупнейшим зернотрейдерам в {$region['parental']} области без посредников за гривну и валюту.";
            $text = '';
        }elseif ($region === 'ukraine') {
            $h1 =  "Цены трейдеров в Украине";
            $title = "Закупочные цены зернотрейдеров Украины на сегодня - Agrotender.ua";
            $keywords = "Закупочные, цены, трейдеры, Украина";
            $description = "Продажа аграрной продукции крупнейшим трейдерам и переработчикам Украины. Только свежие и актуальные закупки без посредников. Динамика закупочных цен на сегодня.";
            $text = '';
        }else {
            if ($seo != null) {
                $title = $this->parseSeoText($region, $seo[0]['page_title']);
                $keywords = $this->parseSeoText($region, $seo[0]['page_keywords']);
                $description = $this->parseSeoText($region, $seo[0]['page_descr']);
                $h1 = $this->parseSeoText($region, $seo[0]['page_h1']);
                $text = $this->parseSeoText($region, $seo[0]['content_text']);
            }
        }

        if ($region !== null && $culture !== null) {
            $h1 =  "Цена {$culture['name']} в {$region['parental']} области";
            $title = "Цена Кукуруза за тонну в {$region['parental']} области сегодня. Закупочные цены трейдеров {$year}";
            $keywords = "Цена, стоимость, экспорт, {$culture['name']}, {$region['name']} область";
            $description = "Стоимость {$culture['name']} на портале Agrotender. Продажа {$culture['name']} крупнейшим зернотрейдерам в {$region['parental']} области без посредников за гривну и валюту.";
            $text = '';
        }
        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
    }

    public function getTradersMetaPort($port, $culture, $type)
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

    public function getTradersMetaForward($region, $culture, $type)
    {
        if(empty($region) && $type != 3){
            return false;
        }

        $h1 =  '';
        $title = '';
        $keywords = '';
        $description = '';
        $text = '';


        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
    }

    public function getTradersMetaSell($region, $culture, $type)
    {
        if(empty($region) && $type != 2){
            return false;
        }

        $h1 =  '';
        $title = '';
        $keywords = '';
        $description = '';
        $text = '';


        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
    }

    public function getTradersMeta($data)
    {
        $meta_region = $this->getTradersMetaRegion($data['region'], $data['rubric'], $data['type']);
        $meta_port= $this->getTradersMetaPort($data['port'], $data['rubric'], $data['type']);
        $meta_forward = $this->getTradersMetaForward($data['region'], $data['rubric'], $data['type']);
        $meta_sell = $this->getTradersMetaSell($data['region'], $data['rubric'], $data['type']);

        if ($meta_region) {
            return $meta_region;
        }

        if ($meta_port) {
            return $meta_port;
        }


        if ($meta_forward) {
            return $meta_forward;
        }

        if($meta_sell) {
            return $meta_sell;
        }

       /* $region = $data['region'];
        $rubric = $data['rubric'];
        $port = $data['port'];

        $h1 = '';
        $text = '';
        $rubricText = ($rubric != null) ? $rubric['name'] : 'Аграрной продукции';

        $regionText = is_array($region) ? $region['parental'].' области' : 'Украине';

        $year = date('Y');
        $yearsText = $year . '-' . ($year + 1);
        if (!empty($rubric) || !empty($region)) {
            $seo = SeoTitles::where('pagetype', 2)
                ->where('sect_id', 0)
                ->where('obl_id', [!empty($region['id']) ? $region['id'] : 0])
                ->where('cult_id', $rubric['id'])
                ->where('type_id', $data['type'])
                ->get()
                ->toArray();

            if (!empty($port)) {

                if ($data['type'] == 1) {
                    $h1 = $rubric['name'] . " - отпускная цена в " . $port[0]['portname'];
                    $title = $rubric['name'] . ": отпускная цена в " . $port[0]['portname'] . " - Agrotender";
                    $keywords = $rubric['name'] . ", отпускная, цена, " . $port[0]['portname'] . ", трейдеры, экспортеры";
                    $description = "Самые свежие отпускные цены на " . $rubric[0]['name'] . " от ведущих трейдеров в терминалах " . $port[0]['portname'] . ".";
                } elseif ($data['type'] == 0) {
                    $h1 = "Цена" . $rubric[0]['name'] . " " . $port[0]['portname'];
                    $title = "Цена " . $rubric[0]['name']  . " в " .$port[0]['portname'].". Закупочные цены на сегодня от Agrotender.";
                    $keywords = $rubric[0]['name'] . ", цена, " . $port[0]['portname'] . ", трейдеры, экспортеры";
                    $description = "Закупочные цены трейдеров на {$rubric[0]['name']} в {$port[0]['portname']}. Контакты трейдеров и актуальные цены на сегодня. Стоимость в гривне и долларе.";
                } elseif ($data['type'] == 3) {
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

                if ($data['page'] > 1) {
                    $title = "Стр. " . $data['page'] . ", " . $title;
                }
            } elseif ($data['type'] == 1) {
                $h1 = ($rubric != null ? $rubric['name'] : 'Аграрная продукция') . ": предложения от трейдеров и переработчиков в $regionText";
                $title = ($rubric != null ? $rubric['name'] : 'Аграрная продукция') . ": реализация в $regionText. Цены от переработчиков и трейдеров.";
                $keywords = ($rubric != null ? $rubric['name'] : 'Аграрная продукция') . ", " . ($region != null ? $region['name'] . ' область' : 'Украина') . ", реализация, сбыт";
                $description = "Реализация $rubricText переработчиками и трейдерами в $regionText. Найдите постоянных поставщиков без посредников по самой выгодной цене. Только актуальные предложения на Agrotender.";
            } elseif ($data['type'] == 0) {
                $h1 = "Цена $rubricText в $regionText";
                $title = "Цена $rubricText за тонну в $regionText сегодня. Закупочные цены трейдеров " . date('Y');
                $keywords = "Цена, стоимость, экспорт, " . ($rubric != null ? $rubric['name'] : 'Аграрная продукция') . ", " . ($region != null ? $region['name'] . ' область' : 'Украина');
                $description = "Стоимость $rubricText на портале Agrotender. Продажа $rubricText крупнейшим зернотрейдерам в $regionText без посредников за гривну и валюту.";
            } elseif ($data['type'] == 3) {
                $rubric_text = $rubric != null ? $rubric['name'] : 'аграрную продукцию';

                $h1 = 'Форвардная цена на ' . $rubric_text . ' в ' . ($region != null ? $region['name'] . ' области' : 'Украине');
                $title = 'Форвардная цена на ' . $rubric_text . ' в ' . ($region != null ? $region['name'] . ' области' : 'Украине') . ' на ' . $yearsText;
                $description = 'Актуальные форвардные цены на ' . $rubric_text . ' от крупнейших зернотрейдеров ' . ($region != null ? $region['name'] . ' области' : 'Украины') . '. Стоимость ' . ($rubric != null ? $rubric['name'] : 'аграрной продукции') . " в гривне и долларе на $yearsText.";
                $keywords = "Форварды, цена, стоимость, экспорт, " . ($rubric != null ? $rubric['name'] : 'Аграрная продукция') . ", " . ($region != null ? $region['name'] . ' область' : 'Украина');
            }
        } elseif (!empty($port)) {
            $h1 = $port[0]['h1'] ?? '';
            $title = "Цена аграрной продукции в {$port[0]['portname']}. Закупочные цены на сегодня от Agrotender.";
            $keywords = "аграрная продукция, цена, Закупочные цены трейдеров на сегодня в порту {$port[0]['portname']}: Agrotender";
            $description = "Закупочные цены трейдеров на Аграрную продукцию в {$port[0]['portname']}. Контакты трейдеров и актуальные цены на сегодня. Стоимость в гривне и долларе.";
        } elseif ($region == null && $rubric == null && $data['type'] == 1) {
            $h1 = "Продажи трейдеров";
            $title = "Отпускные цены трейдеров в Украине на аграрную продукцию";
            $keywords = "отпускная цена, Украина, агропродукция, трейдеры, экспортеры";
            $description = "Самые свежие отпускные цены на агарную продукцию от ведущих трейдеров Украины на портале Agrotender. Следите за изменением цен и читайте обновления от трейдеров.";
        } elseif ($region == null && $rubric == null && $data['type'] == 3) {
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
        if ($data['onlyPorts'] != null && $data['type'] == 3) {
            $h1 = "Форвардная цена на " . ($rubric != null ? $rubric['name'] : 'аграрную продукцию') . " в " . (!empty($port) ? $port['name'] : 'портах Украины');
            $title = "Форвардная цена " . ($rubric != null ? $rubric['name'] : 'аграрной продукции') . " в " . (!empty($port) ? $port['name'] : 'портах Украины') . ' на ' . $yearsText;
            $keywords = 'Форварды, цена, стоимость, экспорт, Аграрная продукция, Украина, ' . ($port != null ? $port['name'] : 'порты Украины');
            $description = "Актуальные форвардные цены на " . ($rubric != null ? $rubric['name'] : 'аграрную продукцию') . " в " . (!empty($port) ? $port['name'] : 'портах Украины') . ". Стоимость аграрной продукции в гривне и долларе на $yearsText.";
        } elseif ($data['onlyPorts'] != null) {
            $title = "Цена ".($rubric != null ? $rubric[0]['name'] : 'аграрной продукции')." в ".($port != null ? $port[0]['portname'] : 'портах Украины').". Закупочные цены на сегодня от Agrotender.";
            $description = "Закупочные цены трейдеров на ".($rubric != null ? $rubric[0]['name'] : 'Аграрную продукцию')." в ".($port != null ? $port[0]['portname'] : 'портах Украины').". Контакты трейдеров и актуальные цены на сегодня. Стоимость в гривне и долларе.";
            $h1 = "Цена на ".($rubric != null ? $rubric[0]['name'] : 'Аграрную продукцию')." в ".($port != null ? $port[0]['portname'] : 'портах Украины');
        }

        return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];*/
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
