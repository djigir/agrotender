<?php
namespace App\models;

/**
 *
 */
class Seo extends \Core\Model {

  public function getPageInfo($page) {
    $info = $this->db->query("
      select p.*, pl.page_mean, pl.page_title as title, pl.page_keywords as keywords, pl.page_descr as description, pl.title page_title, pl.header, pl.content
        from agt_pages p
        inner join agt_pages_lang pl on p.id = pl.item_id
      where p.page_name = '$page'")[0] ?? null;
    return $info;
  }

  public function getBoardMeta($rubric = null, $region = null, $type = 0, $page = 1) {
    $h1 = '';
    $text = '';
    $regionId = ($region == null) ? 0 : $region['id'];
    if (($region != null) || ($rubric != null) || ($type != null) || ($page > 0)) {
    // Get seo data from Database
    //echo $adtopic." = ".$adobl." = ".$adtype."<br>";
      if (($rubric != null) && ($page == 1)) {
        $seo = $this->db->query("select * from agt_seo_titles where pagetype = 0 && sect_id = {$rubric['id']} && obl_id = {$regionId} && type_id = ".($type ?? 0))[0] ?? null;
      }
//var_dump($rubric);
//var_dump($type);
      if (isset($seo) && $seo != null) {
        $title = $this->parseSeoText($region, $seo['page_title']);
        $keywords = $this->parseSeoText($region, $seo['page_keywords']);
        $description = $this->parseSeoText($region, $seo['page_descr']);
        $h1 = $this->parseSeoText($region, $seo['page_h1']);
        $text = $this->parseSeoText($region, $seo['content_text']);
        if ($page > 1) {
          $title = "Стр. " . $page . ", " . $title;
        }
      } else {
        if (($rubric != null && $rubric['page_title'] != "") && ($type == null) && ($page == 1)) {
          $title = $this->parseSeoText($region, $rubric['page_title']);
          $keywords = $this->parseSeoText($region, $rubric['page_keywords']);
          $description = $this->parseSeoText($region, $rubric['page_descr']);
          $h1 = $this->parseSeoText($region, $rubric['page_h1']);
          $text = $this->parseSeoText($region, $rubric['descr']);
        } elseif (($rubric == null) && ($type == null) && ($page == 1)) {
          if ($region != null) {
            $h1 = "Агро доска объявлений {$region['city_parental']}";
          }
          $title = "Агро доска объявлений ".($region == null ? "Украины" : "{$region['city_parental']} и {$region['parental']} области").". Агро объявления от Агротендер. Аграрная, АПК.";
          $keywords = "Агро доска объявлений ".($region == null ? "Украины" : "{$region['city_parental']} и {$region['parental']} области").". Агро объявления от Агротендер. Аграрная, АПК.";
          $description = "На Агро доске объявлений ".($region == null ? "Украины" : "{$region['city_parental']} и {$region['parental']} области")." Вы сможете разместить объявления о купле/продаже интересующей вас с/х продукции.";
        } else {
          $t3words = [
            1 => "культуры",
            2 => "культуры",
            16 => "культуры",
            18 => "продукты"
          ];

          $t3seo = "";
          if (($rubric['parent_id'] != 0)) {
            $t3seo = " (".$rubric['title'].") ";
          } else {
            if (isset($t3words[$rubric['id']])) {
              $t3seo = " ".$t3words[$rubric['id']];
            }
          }

          $page_ptit = "";
          if($page > 1) {
            $page_ptit = "Стр. ".$page.", ";
          }

          if (($type == 1) && $rubric != null && ($rubric['seo_title_buy'] != "")) {
            $title = $page_ptit.$this->parseSeoText($region, $rubric['seo_title_buy']);
            $keywords = $this->parseSeoText($region, $rubric['seo_keyw_buy']);
            $description = $this->parseSeoText($region, $rubric['seo_descr_buy']);
            $h1 = $this->parseSeoText($region, $rubric['seo_h1_buy']);
          } elseif (($type == 2) && $rubric != null && ($rubric['seo_title_sell'] != "")) {
            $title = $page_ptit.$this->parseSeoText($region, $rubric['seo_title_sell']);
            $keywords = $this->parseSeoText($region, $rubric['seo_keyw_sell']);
            $description = $this->parseSeoText($region, $rubric['seo_descr_sell']);
            $h1 = $this->parseSeoText($region, $rubric['seo_h1_sell']);
          } else {
            switch ($type) {
              case 0:
                $typeName = 'Все объявления';
                break;

              case 1:
                $typeName = 'Закупки';
                break;

              case 2:
                $typeName = 'Продажи';
                break;

              case 3:
                $typeName = 'Услуги';
                break;
            }
            $title = $page_ptit." $typeName : ".($rubric == null ? "Все рубрики" : $rubric['title'].$t3seo)." в ".($region == null ? "Украине" : $region['parental']).". Объявления на сайте Agrotender.com.ua.";
            $keywords = $rubric['title'].$t3seo." в ".($region == null ? "Украине" : $region['parental']);
            $description = $rubric['title'].$t3seo." в ".($region == null ? "Украине" : $region['parental']).". Сайт агропромышленных объявлений на Агротендер.";
          }
        }
      }
      if (empty($text) or $h1 == '') {
        $text = $this->parseSeoText($region, $rubric['page_h1']);
      }
      if (empty($text) or $text == '') {
        $text = $this->parseSeoText($region, $rubric['descr']);
      }
    }
    return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
  }

  public function getCompaniesMeta($rubric = null, $region = null, $page = 0) {
    $h1 = '';
    $text = '';
    $topic_name = ($rubric['id'] == null) ? 'Все рубрики' : $rubric['title'];
    if ($rubric != null || $region['id'] != null) {
      if (($rubric['page_title'] != "") && ($page == 0)) {
        $r = ($region['id'] != null) ? $region : null;
        $title = $this->parseSeoText($r, $rubric['page_title']);
        $keywords = $this->parseSeoText($r, $rubric['page_keywords']);
        $description = $this->parseSeoText($r, $rubric['page_descr']);
        $h1 = $this->parseSeoText($r, $rubric['page_h1']);
        $text = $this->parseSeoText($r, $rubric['descr']);
      } elseif (($rubric == null) && ($page == 0)) {
        // Only region selected
        $title = "Каталог аграрных компаний ".($region['id'] == null ? "Украины" : $region['city_parental']." и ".$region['parental'])." области от Агротендер.";
        $keywords = "Каталог аграрных компаний ".($region['id'] == null ? "Украины" : $region['city_parental']." и ".$region['parental'])." области от Агротендер. Аграрная, АПК.";
        $description = "В каталога аграрных компаний ".($region['id'] == null ? "Украины" : $region['city_parental']." и ".$region['parental'])." области Вы сможете разместить объявления о купле/продаже интересующей вас с/х продукции.";
      } else {
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

        $title = $page_ptit.": ".$topic_name.$t3seo." в ".($region['id'] == null) ? "Украине" : $region['parental'].". Компании на сайте Agrotender.com.ua.";
        $keywords = $topic_name.$t3seo." в ".($region['id'] == null) ? "Украине" : $region['parental'];
        $description = $topic_name.$t3seo." в ".($region['id'] == null) ? "Украине" : $region['parental'].". Каталог агропромышленных компаний на Агротендер.";
      }
    } else {
      $title = 'Каталог компаний аграрного сектора Украины';
      $keywords = 'каталог компаний';
      $description = 'Сайт Агротендер представляет вашему вниманию каталог компаний аграрного сектора Украины.';
    }
    return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
  }
  public function getTradersMeta($rubric = null, $region = null, $port = null, $type = 0, $page = 1, $onlyPorts = null) {
      echo '<pre>';
      var_dump($rubric, $region, $port, $type, $page, $onlyPorts);
      echo '</pre>';die();
    $h1 = '';
    $text = '';
    $rubricText = ($rubric != null) ? $rubric['name'] : 'Аграрной продукции';
    $regionText = ($region != null) ? $region['parental'].' области' : 'Украине';
    $year = date('Y');
    $yearsText = $year.'-'.($year+1);

    if ($rubric != null || $region != null) {
      $seo = $this->db->query("select * from agt_seo_titles where pagetype = 2 && sect_id = 0 && obl_id = ".($region != null ? "{$region['id']}" : "0")." && cult_id = {$rubric['id']} && type_id = $type")[0] ?? null;
      if ($port != null) {
        if ($type == 1) {
          $h1 = $rubric['name']." - отпускная цена в ".$port['name'];
          $title = $rubric['name'].": отпускная цена в ".$port['name']." - Agrotender";
          $keywords = $rubric['name'].", отпускная, цена, ".$port['name'].", трейдеры, экспортеры";
          $description = "Самые свежие отпускные цены на ".$rubric['name']." от ведущих трейдеров в терминалах ".$port['name'].".";
        } elseif ($type == 0) {
          $h1 = "Цена ".$rubric['name']." ".$port['name'];
          $title = $rubric['name'].": закупочная цена ".$port['name']." - Agrotender";
          $keywords = $rubric['name'].", цена, ".$port['name'].", трейдеры, экспортеры";
          $description = "Актуальные закупочные цены на ".$rubric['name']." сегодня в терминалах ".$port['name'].". Экспортные цены за тонну и контакты крупнейших трейдеров.";
        } elseif ($type == 3) {
          $rubric_text = $rubric != null ? $rubric['name'] : 'аграрную продукцию';

          $h1 = "Форвардная цена ".$rubric['name']." ".$port['name'];
          $title = $rubric['name'].": форвардная цена ".$port['name'].' на '.$yearsText;
          $keywords = $rubric['name'].", форварды, цена, ".$port['name'].", трейдеры, экспортеры";
          $description = "Актуальные форвардные цены на ".$rubric['name']." в терминалах ".$port['name'].'. Стоимость '.$rubric['name']." в гривне и долларе на $yearsText.";
        }
      } elseif ($seo != null) {
        $title = $this->parseSeoText($region, $seo['page_title']);
        $keywords = $this->parseSeoText($region, $seo['page_keywords']);
        $description = $this->parseSeoText($region, $seo['page_descr']);
        $h1 = $this->parseSeoText($region, $seo['page_h1']);
        $text = $this->parseSeoText($region, $seo['content_text']);

        if ($page > 1) {
          $title = "Стр. " . $page . ", " . $title;
        }
      } elseif ($type == 1) {
        $h1 = ($rubric != null ? $rubric['name'] : 'Аграрная продукция').": предложения от трейдеров и переработчиков в $regionText";
        $title = ($rubric != null ? $rubric['name'] : 'Аграрная продукция').": реализация в $regionText. Цены от переработчиков и трейдеров.";
        $keywords = ($rubric != null ? $rubric['name'] : 'Аграрная продукция').", ".($region != null ? $region['name'].' область' : 'Украина').", реализация, сбыт";
        $description = "Реализация $rubricText переработчиками и трейдерами в $regionText. Найдите постоянных поставщиков без посредников по самой выгодной цене. Только актуальные предложения на Agrotender.";
      } elseif ($type == 0) {
        $h1 = "Цена $rubricText в $regionText";
        $title = "Цена $rubricText за тонну в $regionText сегодня. Закупочные цены трейдеров ".date('Y');
        $keywords = "Цена, стоимость, экспорт, ".($rubric != null ? $rubric['name'] : 'Аграрная продукция').", ".($region != null ? $region['name'].' область' : 'Украина');
        $description = "Стоимость $rubricText на портале Agrotender. Продажа $rubricText крупнейшим зернотрейдерам в $regionText без посредников за гривну и валюту.";
      } elseif ($type == 3) {
        $rubric_text = $rubric != null ? $rubric['name'] : 'аграрную продукцию';

        $h1 = 'Форвардная цена на '.$rubric_text.' в '.($region != null ? $region['name'].' области' : 'Украине');
        $title = 'Форвардная цена на '.$rubric_text.' в '.($region != null ? $region['name'].' области' : 'Украине').' на '.$yearsText;
        $description = 'Актуальные форвардные цены на '.$rubric_text.' от крупнейших зернотрейдеров '.($region != null ? $region['name'].' области' : 'Украины').'. Стоимость '.($rubric != null ? $rubric['name'] : 'аграрной продукции')." в гривне и долларе на $yearsText.";
        $keywords = "Форварды, цена, стоимость, экспорт, ".($rubric != null ? $rubric['name'] : 'Аграрная продукция').", ".($region != null ? $region['name'].' область' : 'Украина');
      }
    } elseif ($port != null) {
      $h1 = $port['h1'] ?? '';
      $title = $port['title'] ?? '123123';
      $keywords = "аграрная продукция, цена, ".$port['title'];
      $description = $port['p_descr'] ?? '';
    } elseif ($region == null && $rubric == null && $type == 1) {
      $h1 = "Продажи трейдеров";
      $title = "Отпускные цены трейдеров в Украине на аграрную продукцию";
      $keywords = "отпускная цена, Украина, агропродукция, трейдеры, экспортеры";
      $description = "Самые свежие отпускные цены на агарную продукцию от ведущих трейдеров Украины на портале Agrotender. Следите за изменением цен и читайте обновления от трейдеров.";
    } elseif ($region == null && $rubric == null && $type == 3) {
      $h1 = 'Форвардная цена на аграрную продукцию';
      $title = 'Форвардная цена на аграрную продукцию в Украине на '.$yearsText;
      $keywords = 'Форварды, цена, стоимость, экспорт, Аграрная продукция, Украина';
      $description = "Актуальные форвардные цены на аграрную продукцию от крупнейших зернотрейдеров Украины. Стоимость аграрной продукции в гривне и долларе на $yearsText.";
    } else {
      $pageInfo = $this->getPageInfo('traders');
      $title = $pageInfo['title'];
      $keywords = $pageInfo['keywords'];
      $description = $pageInfo['description'];
    }

    if ($onlyPorts != null && $type == 3) {
      $h1 = "Форвардная цена на ".($rubric != null ? $rubric['name'] : 'аграрную продукцию')." в ".($port != null ? $port['name'] : 'портах Украины');
      $title = "Форвардная цена ".($rubric != null ? $rubric['name'] : 'аграрной продукции')." в ".($port != null ? $port['name'] : 'портах Украины').' на '.$yearsText;
      $keywords = 'Форварды, цена, стоимость, экспорт, Аграрная продукция, Украина, '.($port != null ? $port['name'] : 'порты Украины');
      $description = "Актуальные форвардные цены на ".($rubric != null ? $rubric['name'] : 'аграрную продукцию')." в ".($port != null ? $port['name'] : 'портах Украины').". Стоимость аграрной продукции в гривне и долларе на $yearsText.";
    } elseif ($onlyPorts != null) {
      $title = "Цена ".($rubric != null ? $rubric['name'] : 'аграрной продукции')." в ".($port != null ? $port['name'] : 'портах Украины').". Закупочные цены на сегодня от Agrotender.";
      $description = "Закупочные цены трейдеров на ".($rubric != null ? $rubric['name'] : 'Аграрную продукцию')." в ".($port != null ? $port['name'] : 'портах Украины').". Контакты трейдеров и актуальные цены на сегодня. Стоимость в гривне и долларе.";
      $h1 = "Цена на ".($rubric != null ? $rubric['name'] : 'Аграрную продукцию')." в ".($port != null ? $port['name'] : 'портах Украины');
    }

    ///////////
    return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1, 'text' => $text];
  }

  public function getAnaliticMeta($rubric = null, $region = null, $port = null, $type = 0, $onlyPorts = null) {
    $h1 = '';
    $rubricText = ($rubric != null) ? $rubric['name'] : 'Аграрная продукция';
    $regionText = ($region != null) ? $region['parental'].' области' : 'Украине';
    if ($type == 0) {
      $title = "Динамика цены на ".($rubric != null ? $rubric['name'] : 'Аграрную продукцию')." в $regionText ".date('Y').". История цен трейдеров на Agrotender.";
      $keywords = "$rubricText, ".($region != null ? $region['name'].' область' : 'Украина').", динамика, аналитика, статистика, история.";
      $description = "История изменения закупочных цен трейдеров на $rubricText в $regionText. Динамика за ".date('Y')." и предыдущие годы. Данные собраны на основе цен публикуемых на сайте Agrotender.";
      $h1 = "Динамика цен на $rubricText в $regionText";
    } else {
      $title = "Аналитика цен переработчиков на ".($rubric != null ? $rubric['name'] : 'Аграрную продукцию')." в $regionText ".date('Y').". История цен на Agrotender.";
      $keywords = "$rubricText, ".($region != null ? $region['name'].' область' : 'Украина').", динамика, аналитика, статистика, история.";
      $description = "Статистика изменения закупочных цен переработчиков на $rubricText в $regionText. Динамика за ".date('Y')." и предыдущие годы. Данные собраны на основе цен публикуемых на сайте Agrotender.";
      $h1 = "Динамика цен на $rubricText в $regionText";
    }
    return ['title' => $title, 'keywords' => $keywords, 'description' => $description, 'h1' => $h1];
  }

  public function parseSeoText($region, $str) {
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