<?php
namespace App\controllers;

class Company extends \Core\Controller {

  public function __construct() {
    // get user model
    $this->user  = $this->model('user');
    // get super utils ;)
    $this->utils = $this->model('utils');
    // get seo model
    $this->seo   = $this->model('seo');
    // company model
    $this->company = $this->model('company');
    $this->companyItem = $this->company->getItem($this->data['companyId']);
    if ($this->companyItem == null) {
      $this->response->redirect('/kompanii');
    }
    // components
    $this->view
         ->setData($this->data + $this->model('utils')->getCompanyMenu($this->data['page'], $this->companyItem) + $this->model('utils')->getMenu($this->data['page']) + ['detect' => new \Core\MobileDetect, 'user' => $this->user, 'company' => $this->companyItem])
         ->setHeader([
           ['bootstrap.min.css', 'noty.css', 'noty/nest.css', 'fontawesome.min.css'],
           ['styles.css']
         ])->setFooter([
           ['jquery-3.3.1.min.js', 'popper.min.js', 'bootstrap.min.js', 'noty.min.js'],
           ['app.js','sides.js']
         ]);
    $this->company->updateRate($this->companyItem['id'], $this->user->ip);
  }

  public function index() {
    $traderContacts = $this->model('traders')->getContacts($this->companyItem['id'], true) ?? null;
    $adverts = $this->model('board')->getAdverts(9999, 1, null, null, null, null, $this->companyItem['author_id'])['data'];
    // prices
    $traders = $this->model('traders');
    $type     = (($this->request->get['type'] ?? 0) == 0) ? 0 : 1;
    $trader   = 0;
    $issetT1 = $this->db->query("select id from agt_traders_prices where buyer_id = {$this->companyItem['author_id']} and acttype = 0")[0] ?? null;
    $issetT2 = $this->db->query("select id from agt_traders_prices where buyer_id = {$this->companyItem['author_id']} and acttype = 1")[0] ?? null;
    $updateDateSql = $this->db->query("select date_format(change_date, '%d.%m.%Y') as updateDate, date_format(dt, '%d.%m.%Y') as updateDate2 from agt_traders_prices where buyer_id = {$this->companyItem['author_id']} && acttype = $type order by dt desc limit 1")[0] ?? null;
    $updateDate = ($updateDateSql != null) ? $updateDateSql['updateDate2'] ?? $updateDateSql['updateDate'] : null;
    if ($issetT2 != null && $this->companyItem['trader_price_sell_avail'] == 1 && $this->companyItem['trader_price_sell_visible'] == 1) {
      $type = 1;
      $trader = 1;
    }
    if ($issetT1 != null && $this->companyItem['trader_price_avail'] == 1 && $this->companyItem['trader_price_visible'] == 1) {
      $type = 0;
      $trader = 1;
    }
    $pricesPorts   = $traders->getPlaces($this->companyItem['author_id'], 2, $type);
    $pricesRegions = $traders->getPlaces($this->companyItem['author_id'], 0, $type);
    // prices regions rubrics
    $traderRegionsPricesRubrics = $traders->getTraderPricesRubrics($this->companyItem['author_id'], 0, $type);
    // prices ports rubrics
    $traderPortsPricesRubrics = $traders->getTraderPricesRubrics($this->companyItem['author_id'], 2, $type);
    // prices with ports

    $portsPrices   = ($pricesPorts != null) ? $traders->getCompanyTraderPrices($this->companyItem['author_id'], $pricesPorts, $traderPortsPricesRubrics, $type) : null;
    // prices with regions
    $regionsPrices = $traders->getCompanyTraderPrices($this->companyItem['author_id'], $pricesRegions, $traderRegionsPricesRubrics, $type);

    $issetUahPort = $issetUsdPort = 0;
    if ( $portsPrices )
        foreach ( $portsPrices as $r )
            if ( isset($r['rubrics']) )
            {
                foreach ( $r['rubrics'] as $rb )
                    if ( !empty($rb['price']) )
                        foreach ( $rb['price'] as $rbp )
                            if ( $rbp['currency'] == 0 ) $issetUahPort = 1;
                            elseif ( $rbp['currency'] == 1 ) $issetUsdPort = 1;
                if ( $issetUahPort && $issetUsdPort ) break;
            }

/*
    $issetUahPort = $this->db->query("
      select tp.id
        from agt_traders_prices tp
        inner join agt_traders_places tpl
          on tpl.id = tp.place_id && tpl.is_port = 1
        where tp.buyer_id = {$this->companyItem['author_id']} and tp.curtype = 0 and tp.acttype = $type")[0] ?? null;
    $issetUsdPort = $this->db->query("
      select tp.id
        from agt_traders_prices tp
        inner join agt_traders_places tpl
          on tpl.id = tp.place_id && tpl.is_port = 1
        where tp.buyer_id = {$this->companyItem['author_id']} and tp.curtype = 1 and tp.acttype = $type")[0] ?? null;
*/
    $issetUahRegion = $this->db->query("
      select tp.id
        from agt_traders_prices tp
        inner join agt_traders_places tpl
          on tpl.id = tp.place_id && tpl.is_port = 0
        where tp.buyer_id = {$this->companyItem['author_id']} and tp.curtype = 0 and tp.acttype = $type")[0] ?? null;
    $issetUsdRegion = $this->db->query("
      select tp.id
        from agt_traders_prices tp
        inner join agt_traders_places tpl
          on tpl.id = tp.place_id && tpl.is_port = 0
        where tp.buyer_id = {$this->companyItem['author_id']} and tp.curtype = 1 and tp.acttype = $type")[0] ?? null;
    // display page
    if ($trader == 0) {
      $title = $this->companyItem['title'].": цены, контакты, отзывы";
    } else {
      if ($this->companyItem['trader_price_avail'] == 1 && $this->companyItem['trader_price_visible'] == 1) {
        $title = "Закупочные цены {$this->companyItem['title']} на сегодня: контакты, отзывы";
      } else {
        $title = $this->companyItem['title'].": цены, контакты, отзывы";
      }
    }

    $this->view
         ->setTitle($title)
         ->setKeywords($this->companyItem['title'])
         ->setDescription(substr(strip_tags($this->companyItem['content']), 0, 200))
         ->setData([
           'trader' => $trader,
           'type' => $type,
           'traderContacts' => $traderContacts,
           'adverts' => $adverts,
           'issetT1' => $issetT1,
           'issetT2' => $issetT2,
           'updateDate' => $updateDate,
           'issetUahPort' => $issetUahPort,
           'issetUsdPort' => $issetUsdPort,
           'issetUahRegion' => $issetUahRegion,
           'issetUsdRegion' => $issetUsdRegion,
           'traderRegionsPricesRubrics' => $traderRegionsPricesRubrics,
           'traderPortsPricesRubrics' => $traderPortsPricesRubrics,
           'portsPrices' => $portsPrices,
           'regionsPrices' => $regionsPrices
         ])
         ->display('company/home');

  }

  public function adverts() {
    $type = $this->request->get['type'] ?? null;
    $ads = $this->model('board')->getAdverts(9999, 1, $type, null, null, null, $this->companyItem['author_id']);
    $adverts = $ads['data'];
    $totalAdverts = $ads['totalAdverts'];
    // display page
    $this->view
         ->setTitle($this->companyItem['title'])
         ->setKeywords($this->companyItem['title'])
         ->setDescription('Сайт компании '.$this->companyItem['title'])
         ->setData([
           'type' => $type,
           'adverts' => $adverts,
           'totalAdverts' => $totalAdverts
         ])
         ->display('company/adverts');

  }

  public function contacts() {
    $contacts = $this->company->getContacts($this->companyItem['id']);
    // display page
    $this->view
         ->setTitle($this->companyItem['title'])
         ->setKeywords($this->companyItem['title'])
         ->setDescription('Сайт компании '.$this->companyItem['title'])
         ->setData([
           'contacts' => $contacts
         ])
         ->display('company/contacts');

  }

  public function traderContacts() {
    $issetT1 = $this->db->query("select id from agt_traders_prices where buyer_id = {$this->companyItem['author_id']} and acttype = 0")[0] ?? null;
    $issetT2 = $this->db->query("select id from agt_traders_prices where buyer_id = {$this->companyItem['author_id']} and acttype = 1")[0] ?? null;
    $traderContacts = $this->model('traders')->getContacts($this->companyItem['id'], true) ?? null;
    // display page
    $this->view
         ->setTitle($this->companyItem['title'])
         ->setKeywords($this->companyItem['title'])
         ->setDescription('Сайт компании '.$this->companyItem['title'])
         ->setData([
           'issetT1' => $issetT1,
           'issetT2' => $issetT2,
           'traderContacts' => $traderContacts
         ])
         ->display('company/traderContacts');

  }

  public function reviews() {
    // add review
    if ($this->action == 'addReview') {
      $comment = $this->request->post['comment'] ?? null;
      $good = $this->request->post['good'] ?? null;
      $bad = $this->request->post['bad'] ?? null;
      $rate = $this->request->post['rate'];
      $this->company->addReview($this->companyItem['author_id'], $this->user->id, $this->user->email, $this->user->name, $this->companyItem['id'], $good, $bad, $rate, $comment);
    }
    // add comment
    if ($this->action == 'reviewComment') {
      $text = $this->request->post['text'] ?? null;
      $review = $this->request->post['review'] ?? null;
      if ($this->user->company['id'] != $this->companyItem['id']) {
        $this->response->json(['code' => 0, 'text' => 'Оставить комментарий к отзыву может только владелец компании.']);
      } else {
        $this->company->addReviewComment($review, $text);
      }
    }
    // get reviews list
    $reviews = $this->user->getReviews(1, null, $this->companyItem['id']);
    // display page
    $this->view
         ->setTitle("Отзывы о {$this->companyItem['title']} на сайте Agrotender")
         ->setKeywords($this->companyItem['title'])
         ->setDescription("Свежие и актуальные отзывы о компании {$this->companyItem['title']}. Почитать или оставить отзыв о компании {$this->companyItem['title']}")
         ->setData([
           'reviews' => $reviews
         ])
         ->display('company/reviews');

  }

  public function prices() {
    $traders = $this->model('traders');
    $type    = $this->request->get['type'] ?? 0;
    if (($this->companyItem['trader_price_avail'] == 0 or $this->companyItem['trader_price_visible'] == 0) && ($this->companyItem['trader_price_sell_avail'] == 0 or $this->companyItem['trader_price_sell_visible'] == 0)) {
      $this->response->redirect('/kompanii/comp-'.$this->companyItem['id'].'');
    }
    if ($type == 0 && ($this->companyItem['trader_price_avail'] == 0 or $this->companyItem['trader_price_visible'] == 0)) {
      $type = 1;
    }
    $issetT1 = $this->db->query("select id from agt_traders_prices where buyer_id = {$this->companyItem['author_id']} and acttype = 0")[0] ?? null;
    $issetT2 = $this->db->query("select id from agt_traders_prices where buyer_id = {$this->companyItem['author_id']} and acttype = 1")[0] ?? null;
    if ($type == 0 && $issetT1 == null) {
      $this->response->redirect("/kompanii/comp-{$this->companyItem['id']}-prices?type=1");
    }
    if ($type == 1 && $issetT2 == null) {
      $this->response->redirect("/kompanii/comp-{$this->companyItem['id']}");
    }
    $updateDateSql = $this->db->query("select date_format(change_date, '%d.%m.%Y') as updateDate, date_format(dt, '%d.%m.%Y') as updateDate2 from agt_traders_prices where buyer_id = {$this->companyItem['author_id']} && acttype = $type order by dt desc limit 1")[0] ?? null;
    $updateDate = ($updateDateSql != null) ? $updateDateSql['updateDate2'] ?? $updateDateSql['updateDate'] : null;
    $typeName = ($type == 0) ? '' : '_sell';
    $pricesPorts   = $traders->getPlaces($this->companyItem['author_id'], 2, $type);
    $pricesRegions = $traders->getPlaces($this->companyItem['author_id'], 0, $type);
    // prices regions rubrics
    $traderRegionsPricesRubrics = $traders->getTraderPricesRubrics($this->companyItem['author_id'], 0, $type);
    // prices ports rubrics
    $traderPortsPricesRubrics = $traders->getTraderPricesRubrics($this->companyItem['author_id'], 2, $type);
    // prices with ports
    $portsPrices   = ($pricesPorts != null) ? $traders->getCompanyTraderPrices($this->companyItem['author_id'], $pricesPorts, $traderPortsPricesRubrics, $type) : null;
    // prices with regions
    $regionsPrices = $traders->getCompanyTraderPrices($this->companyItem['author_id'], $pricesRegions, $traderRegionsPricesRubrics, $type);

    $issetUahPort = $this->db->query("
      select tp.id
        from agt_traders_prices tp
        inner join agt_traders_places tpl
          on tpl.id = tp.place_id && tpl.is_port = 1
        where tp.buyer_id = {$this->companyItem['author_id']} and tp.curtype = 0 and tp.acttype = $type")[0] ?? null;
    $issetUsdPort = $this->db->query("
      select tp.id
        from agt_traders_prices tp
        inner join agt_traders_places tpl
          on tpl.id = tp.place_id && tpl.is_port = 1
        where tp.buyer_id = {$this->companyItem['author_id']} and tp.curtype = 1 and tp.acttype = $type")[0] ?? null;
    $issetUahRegion = $this->db->query("
      select tp.id
        from agt_traders_prices tp
        inner join agt_traders_places tpl
          on tpl.id = tp.place_id && tpl.is_port = 0
        where tp.buyer_id = {$this->companyItem['author_id']} and tp.curtype = 0 and tp.acttype = $type")[0] ?? null;
    $issetUsdRegion = $this->db->query("
      select tp.id
        from agt_traders_prices tp
        inner join agt_traders_places tpl
          on tpl.id = tp.place_id && tpl.is_port = 0
        where tp.buyer_id = {$this->companyItem['author_id']} and tp.curtype = 1 and tp.acttype = $type")[0] ?? null;

    // display page
    $this->view
         ->setTitle($this->companyItem['title'])
         ->setKeywords($this->companyItem['title'])
         ->setDescription('Сайт компании '.$this->companyItem['title'])
         ->setData([
           'updateDate' => $updateDate,
           'issetT1' => $issetT1,
           'issetT2' => $issetT2,
           'issetUahPort' => $issetUahPort,
           'issetUsdPort' => $issetUsdPort,
           'issetUahRegion' => $issetUahRegion,
           'issetUsdRegion' => $issetUsdRegion,
           'type' => $type,
           'traderRegionsPricesRubrics' => $traderRegionsPricesRubrics,
           'traderPortsPricesRubrics' => $traderPortsPricesRubrics,
           'portsPrices' => $portsPrices,
           'regionsPrices' => $regionsPrices
         ])
         ->display('company/prices');

  }

  public function forwards() {
    if ($this->companyItem['trader_price_forward_avail'] == 0 || $this->companyItem['trader_price_forward_visible'] == 0) {
      $this->response->redirect('/kompanii/comp-'.$this->companyItem['id'].'');
    }
    $type = 0;
    $traders = $this->model('traders');
    $price_type = $traders->forwardPriceType;
    $is_avail = $this->db->query("select 1 from agt_traders_prices where buyer_id = {$this->companyItem['author_id']} and acttype = $price_type limit 1") ? true : false;
    if ( !$is_avail ) {
      $this->response->redirect("/kompanii/comp-{$this->companyItem['id']}");
    }
    $forward_months = $traders->getForwardsMonths();
    $pricesPorts   = $traders->getPlaces($this->companyItem['author_id'], 2, $type);
    $pricesRegions = $traders->getPlaces($this->companyItem['author_id'], 0, $price_type);
    // prices regions rubrics
    $traderRegionsPricesRubrics = $traders->getTraderPricesRubrics($this->companyItem['author_id'], 0, $price_type);
    // prices ports rubrics
    $traderPortsPricesRubrics   = $traders->getTraderPricesRubrics($this->companyItem['author_id'], 2, $price_type);
     // prices with ports
    $portsPrices   = $traders->getCompanyTraderPricesForwards($this->companyItem['author_id'], $pricesPorts, $traderPortsPricesRubrics, $price_type, $forward_months);
    // prices with regions
    $regionsPrices = $traders->getCompanyTraderPricesForwards($this->companyItem['author_id'], $pricesRegions, $traderRegionsPricesRubrics, $price_type, $forward_months);
    $traderContacts = $this->model('traders')->getContacts($this->companyItem['id'], true) ?? false;

    $updateDateSql = $this->db->query("select date_format(change_date, '%d.%m.%Y') as updateDate from agt_traders_prices where buyer_id = {$this->companyItem['author_id']} && acttype = $price_type order by change_date desc limit 1")[0] ?? null;
    $updateDate = $updateDateSql['updateDate'] ?? null;
    $tmp = $this->db->query("select COUNT(*) as qnt,SUM(tp.curtype) as usd, tpl.is_port
        from agt_traders_prices tp
        inner join agt_traders_places tpl on tpl.id = tp.place_id
        where tp.buyer_id = {$this->companyItem['author_id']} and tp.acttype = $price_type
        group by tpl.is_port") ?? null;
    $is_avail_region_uah = $is_avail_region_usd = $is_avail_port_uah = $is_avail_port_usd = true;
    foreach ( $tmp as $v ) {
      if ( $v['is_port'] ) {
        $is_avail_port_uah = $v['qnt'] > $v['usd'];
        $is_avail_port_usd = $v['usd'] > 0;
      } else {
        $is_avail_region_uah = $v['qnt'] > $v['usd'];
        $is_avail_region_usd = $v['usd'] > 0;
      }
    }

    // display page
    $this->view
         ->setTitle($this->companyItem['title'])
         ->setKeywords($this->companyItem['title'])
         ->setDescription('Сайт компании '.$this->companyItem['title'])
         ->setData([
           'updateDate' => $updateDate,
           'isAvailPortUah' => $is_avail_port_uah,
           'isAvailPortUsd' => $is_avail_port_usd,
           'isAvailRegionUah' => $is_avail_region_uah,
           'isAvailRegionUsd' => $is_avail_region_usd,
           'type' => $price_type,
           'traderRegionsPricesRubrics' => $traderRegionsPricesRubrics,
           'traderPortsPricesRubrics' => $traderPortsPricesRubrics,
           'portsPrices' => $portsPrices,
           'regionsPrices' => $regionsPrices,
           'traderContacts' => $traderContacts,
         ])
         ->display('company/forwards');

  }

  public function news() {
    $news = $this->company->getNews($this->companyItem['id']);
    // display page
    $this->view
         ->setTitle("Тайтл. Новости компании {$this->companyItem['title']} на сайте Agrotender")
         ->setKeywords("Свежие и актуальные новости компании {$this->companyItem['title']}. Почитать последние новости о компании {$this->companyItem['title']}")
         ->setDescription('Сайт компании '.$this->companyItem['title'])
         ->setData([
           'news' => $news
         ])
         ->display('company/news');

  }

  public function vacancy() {
    $vacancy = $this->company->getVacancy($this->companyItem['id']);
    // display page
    $this->view
         ->setTitle("Тайтл. Вакансии компании {$this->companyItem['title']} на сайте Agrotender")
         ->setKeywords($this->companyItem['title'])
         ->setDescription("Свежие и актуальные вакансии компании {$this->companyItem['title']}. Найти работу в компании {$this->companyItem['title']}")
         ->setData([
           'vacancy' => $vacancy
         ])
         ->display('company/vacancy');

  }
  public function newsItem() {
    $item = $this->company->getNewsItem($this->data['id'], $this->companyItem['id']);
    if ($item == null) {
      $this->response->redirect("/kompanii/comp-{$this->companyItem['id']}-news");
    }
    $description = strip_tags(stripslashes($item['content']), "");
    $ppos = strpos($description, ". ");
    if( $ppos > 0 ) {
      $ppos1 = $ppos;
      $ppos = strpos($description, ". ", $ppos+1);
      if( $ppos > 0 ) {
        $ppos1 = $ppos;
      }
      $description = substr($description, 0, $ppos1+1);
    }
    $this->view
         ->setTitle($item['title'].' - Агротендер')
         ->setDescription($description)
         ->setKeywords($item['title'])
         ->setData([
           'item' => $item
         ])->display('company/newsItem');
  }

  public function vacancyItem() {
    $item = $this->company->getVacancyItem($this->data['id'], $this->companyItem['id']);
    if ($item == null) {
      $this->response->redirect("/kompanii/comp-{$this->companyItem['id']}-vacancy");
    }
    $description = strip_tags(stripslashes($item['content']), "");
    $ppos = strpos($description, ". ");
    if( $ppos > 0 ) {
      $ppos1 = $ppos;
      $ppos = strpos($description, ". ", $ppos+1);
      if( $ppos > 0 ) {
        $ppos1 = $ppos;
      }
      $description = substr($description, 0, $ppos1+1);
    }
    $this->view
         ->setTitle($item['title'].' - Агротендер')
         ->setDescription($description)
         ->setKeywords($item['title'])
         ->setData([
           'item' => $item
         ])->display('company/vacancyItem');

  }

}