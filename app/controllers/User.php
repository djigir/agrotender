<?php
namespace App\controllers;

class User extends \Core\Controller {

  public function __construct() {
    // get user model
    $this->user  = $this->model('user');
    // get super utils ;)
    $this->utils = $this->model('utils');
    // get seo model
    $this->seo   = $this->model('seo');
    // components
    $this->view
         ->setData($this->data + $this->model('utils')->getMenu($this->data['page']) + $this->model('utils')->getProfileMenu($this->data['page']) + ['detect' => new \Core\MobileDetect, 'user' => $this->user])
         ->setHeader([
           ['bootstrap.min.css', 'noty.css', 'noty/nest.css', 'fontawesome.min.css'],
           ['styles.css']
         ])->setFooter([
           ['jquery-3.3.1.min.js', 'popper.min.js', 'bootstrap.min.js', 'noty.min.js'],
           'user/payBalance' => ['jquery.mask.min.js', 'jquery.validate.min.js'],
           'user/pricesContacts' => ['jquery.mask.min.js', 'jquery.validate.min.js'],
           'user/home' => ['jquery.mask.min.js', 'jquery.validate.min.js'],
           'user/contacts' => ['jquery.mask.min.js', 'jquery.validate.min.js'],
           'user/company' => ['jquery.validate.min.js'],
           ['app.js','sides.js']
         ]);
    // only authorized zone :)
    if (!$this->user->auth) {
      $this->response->redirect('/');
    }
  }

  public function index() {
    if ($this->action == 'change-password') {
      $oldPassword = $this->request->post['oldPassword'];
      $password    = $this->request->post['password'];
      $this->user->changePassword($oldPassword, $password);
    }
    if ($this->action == 'change-login') {
      $email = $this->request->post['email'];
      $this->user->changeEmail($email);
    }
    // display page
    $this->view
         ->setTitle('Личный кабинет – Агротендер')
         ->setData([
         ])
         ->display('user/home');
  }

  public function contacts() {
    // selected departament
    $dep = $this->request->get['dep'] ?? 0;
    if ( ($dep < 0 or $dep > 3) and $dep != 999 ) {
      $this->response->redirect('/u/contacts');
    }
    // send confirm code to sms
    if ($this->action == 'change-phone') {
      $phone = $this->request->post['phone'];
      $checkPhone = $this->db->query("select id from agt_torg_buyer where phone = $phone && smschecked = 1")[0]['id'] ?? null;
      if ($checkPhone == null) {
        $this->user->sendConfirmCode($phone);
      } else {
        $this->response->json(['code' => 0, 'text' => 'Номер уже кем-то используется.']);
      }
    }
    // check confirm code
    if ($this->action == 'check-code') {
      $code = $this->request->post['code'];
      if ($code == $this->session->get('code')) {
        $this->db->update('agt_torg_buyer', ['phone' => $this->session->get('phone'), 'smschecked' => 1], ['id' => $this->user->id]);
        $this->response->json(['code' => 1, 'text' => 'Номер изменён.']);
      } else {
        $this->response->json(['code' => 0, 'text' => 'Неверный код подтверждения.']);
      }
    }
    // repeat confirm sms
    if ($this->action == 'repeat-code') {
      $phone = $this->request->post['phone'];
      $code  = $this->session->get('code');
      $this->user->sendConfirmCode($phone, $code);
    }
    if ($this->action == 'main-dep') {
      $name        = $this->request->post['name'];
      $name2       = $this->request->post['name2'];
      $name3       = $this->request->post['name3'];
      $phone2      = $this->request->post['phone2'];
      $phone3      = $this->request->post['phone3'];
      $publicEmail = $this->request->post['publicEmail'];
      $region      = $this->request->post['region'];
      $city        = $this->request->post['city'];
      $this->user->saveMainContacts($name, $name2, $name3, $phone2, $phone3, $publicEmail, $region, $city);
    }
    if ( 'im-dep' === $this->action ) {
      $this->user->saveIm(
        trim($this->request->post['telegram']),
        trim($this->request->post['viber'])
      );
    }
    // departaments list
    $deps = ['Главный офис', 'Отдел закупок', 'Отдел продаж', 'Отдел услуг', 999 => 'Telegram/Viber'];
    // departament name
    $depName = $deps[$dep];
    // regions list
    $regions = $this->model('traders')->getRegions();
    // company id
    $companyId = ($this->user->company != null) ? $this->user->company['id'] : 0;
    // contacts list
    $contacts = $this->user->getContacts($companyId, $dep);
    // add trader contact
    if ($this->action == 'addContact') {
      $post = $this->request->post['post'];
      $name = $this->request->post['name'];
      $phone = $this->request->post['phone'];
      $email = $this->request->post['email'];
      $this->user->addContact($dep, $post, $name, $phone, $email);
    }
    // edit trader contact
    if ($this->action == 'editContact') {
      $contact = $this->request->post['contact'];
      $post = $this->request->post['post'];
      $name = $this->request->post['name'];
      $phone = $this->request->post['phone'];
      $email = $this->request->post['email'];
      $this->user->editContact($contact, $post, $name, $phone, $email);
    }
    // remove trader contact
    if ($this->action == 'removeContact') {
      $contact = $this->request->post['contact'];
      $this->user->removeContact($contact);
    }
    // display page
    $this->view
         ->setTitle('Контакты – Личный кабинет – Агротендер')
         ->setData([
           'dep' => $dep,
           'contacts' => $contacts,
           'depName' => $depName,
           'regions' => $regions
         ])
         ->display('user/contacts');
  }

  public function notify() {
    if ($this->action == 'saveAdvSub') {
      $up    = $this->request->post['up'] ?? 0;
      $deact = $this->request->post['deact'] ?? 0;
      $this->user->saveAdvSub($up, $deact);
    }
    if ($this->action == 'addPriceSub') {
      $rubric = $this->request->post['rubric'];
      $period = $this->request->post['period'];
      $this->user->addPriceSub($rubric, $period);
    }
    if ($this->action == 'removeSub') {
      $subId = $this->request->post['subId'];
      $this->user->removePriceSub($subId);
    }
    if ($this->action == 'upSub') {
      $subId = $this->request->post['subId'];
      $this->user->upPriceSub($subId);
    }
    $activeSub = $this->user->getActiveSub();
    $rubrics = $this->user->getRubrics();
    // display page
    $this->view
         ->setTitle('Уведомления – Личный кабинет – Агротендер')
         ->setData([
           'activeSub' => $activeSub,
           'rubrics' => $rubrics
         ])
         ->display('user/notify');
  }

  public function reviews() {
    // selected type
    $type = $this->request->get['type'] ?? 0;
    if ($type < 0 or $type > 1) {
      $this->response->redirect('/u/reviews');
    }
    // reviews list
    $reviews = $this->user->getReviews($type, $this->user->id, $this->user->company['id']);
    // display page
    $this->view
         ->setTitle('Отзывы – Личный кабинет – Агротендер')
         ->setData([
           'type' => $type,
           'reviews' => $reviews
         ])
         ->display('user/reviews');
  }

  public function proposeds() {
    if ($this->user->ip != '109.86.1.55') {
      // exit;
    }
    // selected type
    $type = $this->request->get['type'] ?? 0;
    if ($type < 0 or $type > 1) {
      $this->response->redirect('/u/proposeds');
    }
    if ($type == 0 && ($this->user->company == null or ($this->user->company['trader_price_avail'] == 0 && $this->user->company['trader_price_sell_avail'] == 0))) {
      $type = 1;
    }
    if ($this->user->company != null && ($this->user->company['trader_price_avail'] == 1 or $this->user->company['trader_price_sell_avail'] == 1) && $type == 0) {
      $this->user->viewedProposeds();
    }
    // selected status
    $status = $this->request->get['status'] ?? 0;
    if ($status != 0 && $status != -1 && $status != 1) {
      $this->response->redirect('/u/proposeds');
    }
    // cancel proposed
    if ($this->action == 'cancel') {
      $proposed = $this->request->post['proposed'] ?? null;
      $this->user->cancelProposed($proposed);
    }
    // remove proposed
    if ($this->action == 'remove') {
      $proposed = $this->request->post['proposed'] ?? null;
      $this->user->removeProposed($proposed);
    }
    // get proposed companies
    if ($this->action == 'getCompanies') {
      $proposed = $this->request->post['proposed'] ?? null;
      $this->user->getProposedCompanies($proposed);
    }
    // accept proposed
    if ($this->action == 'accept') {
      $proposed = $this->request->post['proposed'] ?? null;
      $companies = $this->request->post['companies'] ?? null;
      $this->user->acceptProposed($proposed, $companies);
    }
    // get current page number
    $pageNumber = $this->request->get['p'] ?? 1;
    // get proposeds count
    $count = $this->user->getProposedsCount();
    // get proposeds list
    $proposeds = ($type == 1) ? $this->user->getSendProposeds($status) : $this->user->getReceivedProposeds(15, $pageNumber, $status);
    // print_r($proposeds); exit;
    // display page
    $this->view
         ->setTitle('Предложения – Личный кабинет – Агротендер')
         ->setData([
           'count' => $count,
           'type' => $type,
           'status' => $status,
           'pageNumber'      => $pageNumber,
           'pagePagination'  => $proposeds['page'] ?? 1,
           'totalPages'      => $proposeds['totalPages'] ?? 1,
           'proposeds' => $proposeds['proposeds']
         ])
         ->display('user/proposeds');
  }

  public function company() {
    // rubrics list
    $rubrics = $this->user->getCompanyRubrics();
    // regions list
    $regions = $this->model('traders')->getRegions();
    if ($this->action == 'save-company') {
      $title = $this->request->post['title'] ?? null;
      $logo = $this->request->files['logo'];
      $content = $this->request->post['content'] ?? null;
      $zipcode = $this->request->post['zipcode'] ?? null;
      $region = $this->request->post['region'] ?? null;
      $city = $this->request->post['city'] ?? null;;
      $addr = $this->request->post['addr'] ?? null;;
      $rubrics = $this->request->post['rubrics'] ?? null;;
      $this->user->saveCompany($title, $logo, $content, $zipcode, $region, $city, $addr, $rubrics);
    }
    if ($this->action == 'setVisible') {
      $visible = $this->request->post['visible'] ?? null;
      $this->user->setCompanyVisible($visible);
    }
    // display page
    $this->view
         ->setTitle('Компания – Личный кабинет – Агротендер')
         ->setData([
           'regions' => $regions,
           'rubrics' => $rubrics
         ])
         ->display('user/company');
  }

  public function news() {
    if ($this->user->company == null) {
      $this->response->redirect('/u/');
    }
    $company = $this->model('company');
    $news = $company->getNews($this->user->company['id']);
    if ($this->action == 'getNewsItem') {
      $newsId = $this->request->post['newsId'];
      $this->response->json($company->getNewsItem($newsId, $this->user->company['id']));
    }
    if ($this->action == 'editNews') {
      $newsId = $this->request->post['newsId'];
      $title = $this->request->post['title'];
      $image = $this->request->files['image'];
      $description = $this->request->post['description'];
      $company->editNews($this->user->company['id'], $newsId, $title, $image, $description);
    }
    if ($this->action == 'addNews') {
      $title = $this->request->post['title'];
      $image = $this->request->files['image'];
      $description = $this->request->post['description'];
      $company->addNews($this->user->company['id'], $title, $image, $description);
    }
    if ($this->action == 'removeNews') {
      $newsId = $this->request->post['newsId'];
      $company->removeNews($this->user->company['id'], $newsId);
    }

    // display page
    $this->view
         ->setTitle('Нововсти – Личный кабинет – Агротендер')
         ->setData([
           'news' => $news
         ])
         ->display('user/news');
  }

  public function vacancy() {
    $company = $this->model('company');
    $vacancy = $company->getVacancy($this->user->company['id']);
    if ($this->action == 'getVacancyItem') {
      $vacancyId = $this->request->post['vacancyId'];
      $this->response->json($company->getVacancyItem($vacancyId, $this->user->company['id']));
    }
    if ($this->action == 'editVacancy') {
      $vacancyId = $this->request->post['vacancyId'];
      $title = $this->request->post['title'];
      $description = $this->request->post['description'];
      $company->editVacancy($this->user->company['id'], $vacancyId, $title, $description);
    }
    if ($this->action == 'addVacancy') {
      $title = $this->request->post['title'];
      $description = $this->request->post['description'];
      $company->addVacancy($this->user->company['id'], $title, $description);
    }
    if ($this->action == 'removeVacancy') {
      $vacancyId = $this->request->post['vacancyId'];
      $company->removeVacancy($this->user->company['id'], $vacancyId);
    }

    // display page
    $this->view
         ->setTitle('Вакансии – Личный кабинет – Агротендер')
         ->setData([
           'vacancy' => $vacancy
         ])
         ->display('user/vacancy');
  }

  public function ads() {
    // board model
    $board = $this->model('board');
    // call action from many adverts
    if ($this->action == 'callAction') {
      $ids = $this->request->post['ids'] ?? null;
      $action_id = $this->request->post['action_id'] ?? null;
      if ($ids == null) {
        $this->response->json(['code' => 0, 'text' => 'Вы не выбрали ни одного объявления.']);
      }
      if ($action_id == null) {
        $this->response->json(['code' => 0, 'text' => 'Выберите действие.']);
      }
      switch ($action_id) {
        case '1':
          $board->removePost($this->user->id, $ids);
          break;
        case '2':
          $board->setArchive($this->user->id, $ids, 0);
          break;
        case '3':
          $board->setArchive($this->user->id, $ids, 1);
          break;
      }
    }
    // set advert status (archive or no)
    if ($this->action == 'setArchive') {
      $archive = $this->request->post['archive'];
      $advert = $this->request->post['advert'];
      $board->setArchive($this->user, [$advert], $archive);
    }
    // selected type
    $archive = $this->request->get['archive'] ?? 0;
    if ($archive < 0 or $archive > 1) {
      $this->response->redirect('/u/ads');
    }
    // sort
    $sort = $this->request->get['sort'] ?? 'up_dt';
    if ($sort != 'up_dt' && $sort != 'title') {
      $this->response->redirect('/u/ads');
    }
    // error limits
    $advError = $this->session->getOnce('advError');
    // counts
    $activeCount  = $this->db->query("select coalesce(count(id), 0) as count from agt_adv_torg_post where author_id = {$this->user->id} && active = 1 && archive = 0")[0]['count'];
    $archiveCount = $this->db->query("select coalesce(count(id), 0) as count from agt_adv_torg_post where author_id = {$this->user->id} && active = 1 && archive = 1")[0]['count'];
    // get current page number
    $pageNumber   = $this->request->get['p'] ?? 1;
    // get user advers from type
    $adverts = $board->getAdverts(10, $pageNumber, null, null, null, null, $this->user->id, null, null, $archive, $sort);
    //get up advert price
    $upPrice = $this->model('paid')->getPack(13)['cost'] ?? 0;
    // display page
    $this->view
         ->setTitle('Объявления – Личный кабинет – Агротендер')
         ->setData([
           'advError' => $advError,
           'upPrice' => round($upPrice),
           'sort' => $sort,
           'archive' => $archive,
           'activeCount' => $activeCount,
           'archiveCount' => $archiveCount,
           'adverts' => $adverts['data'],
           'pageNumber'      => $pageNumber,
           'pagePagination'  => $adverts['page'],
           'totalPages'      => $adverts['totalPages']
         ])
         ->display('user/ads');
  }

  public function prices() {
    // echo $this->user->id;
    $type     = (($this->request->get['type'] ?? 0) == 0) ? 0 : 1;
    $typeName = ($type == 0) ? '' : '_sell';
    if ($this->user->company == null or $this->user->company['trader_price'.$typeName.'_avail'] == 0) {
      $this->response->redirect('/u/');
    }
    // traders model
    $traders  = $this->model('traders');
    // saveColPrices
    if ($this->action == 'saveColPrices') {
      $rubric     = $this->request->post['rubric'];
      $place_type = $this->request->post['place_type'];
      $acttype    = $this->request->post['acttype'];
      $price      = $this->request->post['price'];
      $currency   = $this->request->post['currency'];
      $traders->saveColPrices($this->user->id, $rubric, $place_type, $acttype, $currency, $price);
    }
    // getAvgPrices
    if ($this->action == 'getAvgPrices') {
      $rubric    = $this->request->post['rubric'];
      $region    = $this->request->post['region'];
      $currency  = $this->request->post['currency'];
      $avgPrices = $traders->getAvgPrices($rubric, $region, $currency, $type, $typeName);
      if ($avgPrices == null) {
        $this->response->json(['code' => 0]);
      } else {
        $this->response->json(['code' => 1, 'minPrice' => $avgPrices['minprice'], 'maxPrice' => $avgPrices['maxprice']]);
      }
    }
    // add rubric
    if ($this->action == 'addRubric') {
      $rubric    = $this->request->post['rubric'];
      $placeType = $this->request->post['placeType'];
      $traders->addPriceRubric($this->user->id, $rubric, $type, $placeType);
    }
    // delete rubric
    if ($this->action == 'deleteRubric') {
      $rubric    = $this->request->post['rubric'];
      $traders->deletePriceRubric($this->user->id, $rubric, $type);
    }
    // visible table
    if ($this->action == 'setVisible') {
      $visible    = $this->request->post['visible'];
      $traders->setVisible($this->user->company['id'], $typeName, $visible);
    }
    // add place
    if ($this->action == 'addPlace') {
      $region     = $this->request->post['region'];
      $place      = $this->request->post['place'];
      $traders->addPricePlace($this->user->id, $region, $place, $type);
    }
    // delete place
    if ($this->action == 'deletePlace') {
      $placeId    = $this->request->post['placeId'];
      $traders->deletePricePlace($this->user->id, $placeId);
    }
    // update place
    if ($this->action == 'updatePlace') {
      $placeId    = $this->request->post['placeId'];
      $place      = $this->request->post['place'];
      $traders->updatePricePlace($this->user->id, $placeId, $place);
    }
    // save prices
    if ($this->action == 'savePrices') {
      $prices = $this->request->post['prices'];
      foreach ($prices as $price) {
        $traders->savePrice($this->user->id, $type, $price['currency'], $price['place'], $price['rubric'], $price['cost'], $price['comment']);
      }
      $this->response->json(['code' => 1, 'text' => '']);
    }
    // prices
    $pricesPorts   = $traders->getPlaces($this->user->id, 2, $type);
    $pricesRegions = $traders->getPlaces($this->user->id, 0, $type);
    // echo "<div class=\"d-none\">".print_r($pricesRegions)."</div>";
    // prices regions rubrics
    $traderRegionsPricesRubrics = $traders->getUserPricesRubrics($this->user->id, 0, $type);
    // prices ports rubrics
    $traderPortsPricesRubrics = $traders->getUserPricesRubrics($this->user->id, 2, $type);
    // prices with ports
    $portsPrices   = ($pricesPorts != null) ? $traders->getTraderPrices($this->user->id, $pricesPorts, $traderPortsPricesRubrics, $type) : null;
    // prices with regions
    $regionsPrices = $traders->getTraderPrices($this->user->id, $pricesRegions, $traderRegionsPricesRubrics, $type);
    // get avail ports rubrics
    $availPortsRubrics  = $traders->getAvailRubrics($this->user->id, 2, $type);
    // get avail regions rubrics
    $availRegionsRubrics  = $traders->getAvailRubrics($this->user->id, 0, $type);
    // regions list
    $regions = $traders->getRegions();
    $first_region = array_shift($regions);
    array_push($regions,$first_region);
    // visible
    $visible = $this->user->company['trader_price'.$typeName.'_visible'];
    /* echo "<pre>";
    print_r($regionsPrices);
    exit;  */
    // display page
    $this->view
         ->setTitle('Цены трейдера – Личный кабинет – Агротендер')
         ->setData([
           'type' => $type,
           'visible' => $visible,
           'regions' => $regions,
           'availPortsRubrics' => $availPortsRubrics,
           'availRegionsRubrics' => $availRegionsRubrics,
           'traderRegionsPricesRubrics' => $traderRegionsPricesRubrics,
           'traderPortsPricesRubrics' => $traderPortsPricesRubrics,
           'portsPrices' => $portsPrices,
           'regionsPrices' => $regionsPrices
         ])
         ->display('user/prices');
  }

  public function pricesForward() {
    if ($this->user->company == null or $this->user->company['trader_price_forward_avail'] == 0) {
      $this->response->redirect('/u/');
    }
    $type = 0; // тип для получения рубрик
    // traders model
    $traders  = $this->model('traders');
    $price_type = $traders->forwardPriceType; // тип форвардных цен
    $type_name = '_forward';
    // saveColPrices
    if ($this->action == 'saveColPrices') {
      $rubric     = $this->request->post['rubric'];
      $place_type = $this->request->post['place_type'];
      // $acttype    = $this->request->post['acttype'];
      $acttype    = $price_type;
      $price      = $this->request->post['price'];
      $currency   = $this->request->post['currency'];
      $dt         = $this->request->post['date'];
      // validate params
      if ( !preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $dt) ) $this->response->json(['code' => 0]);

      $traders->saveColPrices($this->user->id, $rubric, $place_type, $acttype, $currency, $price, $dt);
    }
    // getAvgPrices - отображение максимальной и минимальной цены в регионе для выбраной рубрики
    elseif ($this->action == 'getAvgPrices') {
      $rubric    = $this->request->post['rubric'];
      $region    = $this->request->post['region'];
      $currency  = $this->request->post['currency'];
      $dt        = $this->request->post['date'];
      // validate params
      if ( !preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $dt) ) $this->response->json(['code' => 0]);

      $avgPrices = $traders->getAvgPrices($rubric, $region, $currency, $price_type, $type_name, $dt);
      if ($avgPrices == null) {
        $this->response->json(['code' => 0]);
      } else {
        $this->response->json(['code' => 1, 'minPrice' => $avgPrices['minprice'], 'maxPrice' => $avgPrices['maxprice']]);
      }
    }
    // add rubric
    elseif ($this->action == 'addRubric') {
      $rubric    = $this->request->post['rubric'];
      $placeType = $this->request->post['placeType'];
      $traders->addPriceRubric($this->user->id, $rubric, $price_type, $placeType);
    }
    // delete rubric
    elseif ($this->action == 'deleteRubric') {
      $rubric    = $this->request->post['rubric'];
      $traders->deletePriceRubric($this->user->id, $rubric, $price_type);
    }
    // visible table
    elseif ($this->action == 'setVisible') {
      $visible    = $this->request->post['visible'];
      $traders->setVisible($this->user->company['id'], $type_name, $visible);
    }
    // add place
    elseif ($this->action == 'addPlace') {
      $region     = $this->request->post['region'];
      $place      = $this->request->post['place'];
      $traders->addPricePlace($this->user->id, $region, $place, $price_type);
    }
    // delete place
    elseif ($this->action == 'deletePlace') {
      $placeId    = $this->request->post['placeId'];
      $traders->deletePricePlace($this->user->id, $placeId);
    }
    // update place
    elseif ($this->action == 'updatePlace') {
      $placeId    = $this->request->post['placeId'];
      $place      = $this->request->post['place'];
      $traders->updatePricePlace($this->user->id, $placeId, $place);
    }
    // save prices
    elseif ($this->action == 'savePrices') {
      $prices = $this->request->post['prices'];
      foreach ($prices as $price) {
        $traders->savePriceForward($this->user->id, $price_type, $price['currency'], $price['place'], $price['rubric'], $price['cost'], $price['comment'], $price['date']);
      }
      $this->response->json(['code' => 1, 'text' => '']);
    }

    $forward_months = $traders->getForwardsMonths();
    // prices
    $pricesPorts   = $traders->getPlaces($this->user->id, 2, $type);
    $pricesRegions = $traders->getPlaces($this->user->id, 0, $price_type);
    // prices ports rubrics
    $traderPortsPricesRubrics   = $traders->getUserPricesRubrics($this->user->id, 2, $price_type);
    // prices regions rubrics
    $traderRegionsPricesRubrics = $traders->getUserPricesRubrics($this->user->id, 0, $price_type);
    // prices with ports
    $portsPrices   = $traders->getTraderPricesForwards($this->user->id, $pricesPorts, $traderPortsPricesRubrics, $price_type, $forward_months);
    // prices with regions
    $regionsPrices = $traders->getTraderPricesForwards($this->user->id, $pricesRegions, $traderRegionsPricesRubrics, $price_type, $forward_months);
    // get avail ports rubrics
    $availPortsRubrics   = $traders->getAvailRubrics($this->user->id, 2, $type, $price_type);
    // get avail regions rubrics
    $availRegionsRubrics = $traders->getAvailRubrics($this->user->id, 0, $type, $price_type);
    // regions list
    $regions = $traders->getRegions();
    // visible
    $visible = $this->user->company['trader_price'.$type_name.'_visible'];
    // display page
    $this->view
         ->setTitle('Форвардные цены трейдера – Личный кабинет – Агротендер')
         ->setData([
           'type' => $price_type,
           'visible' => $visible,
           'regions' => $regions,
           'availPortsRubrics' => $availPortsRubrics,
           'availRegionsRubrics' => $availRegionsRubrics,
           'traderPortsPricesRubrics' => $traderPortsPricesRubrics,
           'traderRegionsPricesRubrics' => $traderRegionsPricesRubrics,
           'portsPrices' => $portsPrices,
           'regionsPrices' => $regionsPrices,
           'forwardMonths' => $forward_months,
         ])
         ->display('user/pricesForward');
  }

  public function pricesContacts() {
    $traders = $this->model('traders');
    // add contact place
    if ($this->action == 'addContactPlace') {
      $place = $this->request->post['place'];
      $traders->addContactPlace($this->user->id, $this->user->company['id'], $place);
    }
    // delete contact place
    if ($this->action == 'removeContactPlace') {
      $place = $this->request->post['place'];
      $traders->removeContactPlace($this->user->id, $this->user->company['id'], $place);
    }
    // edit contact palce
    if ($this->action == 'editContactPlace') {
      $place = $this->request->post['place'];
      $placeId = $this->request->post['placeId'];
      $traders->editContactPlace($placeId, $this->user->company['id'], $place);
    }
    // add trader contact
    if ($this->action == 'addContact') {
      $place = $this->request->post['place'];
      $post = $this->request->post['post'];
      $name = $this->request->post['name'];
      $phone = $this->request->post['phone'];
      $email = $this->request->post['email'];
      $traders->addContact($this->user->id, $place, $post, $name, $phone, $email);
    }
    // edit trader contact
    if ($this->action == 'editContact') {
      $contact = $this->request->post['contact'];
      $post = $this->request->post['post'];
      $name = $this->request->post['name'];
      $phone = $this->request->post['phone'];
      $email = $this->request->post['email'];
      $traders->editContact($this->user->id, $contact, $post, $name, $phone, $email);
    }
    // remove trader contact
    if ($this->action == 'removeContact') {
      $place = $this->request->post['place'];
      $contact = $this->request->post['contact'];
      $traders->removeContact($this->user->id, $contact, $place);
    }
    // get contact
    if ($this->action == 'getContact') {
      $id = $this->request->post['id'];
      $traders->getContact($id);
    }
    // trader contacts list
    $contacts = $traders->getContacts($this->user->company['id']);
    // display page
    $this->view
         ->setTitle('Контакты трейдера – Личный кабинет – Агротендер')
         ->setData([
           'contacts' => $contacts
         ])
         ->display('user/pricesContacts');
  }

  public function limits() {
    $paid = $this->model('paid');
    $packs = $paid->getPacks(0);
    $activePacks = $paid->getPayedPacks($this->user->id, 0, 'onlyactive', 'end');
    // pay up limits
    if ($this->action == 'upLimits') {
      $packs = $this->request->post['packs'];
      $paid->payPacks($packs);
    }
    // display page
    $this->view
         ->setTitle('Лимит объявлений – Личный кабинет – Агротендер')
         ->setData([
           'packs' => $packs,
           'activePacks' => $activePacks
         ])
         ->display('user/limits');
  }

  public function upgrade() {
    // paid services model
    $paid = $this->model('paid');
    // ajax pay services
    if ($this->action == 'upgradeAdv') {
      $packs = $this->request->post['packs'];
      $advId = $this->request->post['advId'];
      $paid->payPacks($packs, $advId);
    }
    // pay packs with adv
    $advId = $this->request->get['adv'] ?? null;
    if ($advId != null) {
      // get advert info
      $advert = $this->model('board')->getAdvert($advId);
      // if not exists advert or advert author not you
      if (($advId != null && $advert == null) or ($advId != null && $advert != null && $advert['author_id'] != $this->user->id)) {
        $this->response->redirect('/u/ads/upgrade');
      }
      $advTitle = ($advId != null) ? $advert['title'] : null;
      // get packs list and resorting
      $packs = [];
      foreach ($paid->getPacks([1,2,3]) as $pack) {
        $packs[$pack['pack_type']][] = $pack;
      }
      foreach ($packs as $key => $value) {
        if (count($value) == 1) {
          $packs[$key] = $value[0];
        }
      }
    } else {
      // all payed packs from adv
      $payedPacks = $paid->getPayedPacks($this->user->id, [1, 2, 3], '', 'end');
      foreach ($payedPacks as $key => $value) {
        $payedPacks[$key]['advTitle'] = $this->model('board')->getAdvert($value['post_id'])['title'];
      }
    }
//    var_dump($packs);
    // display page
    $this->view
         ->setTitle('Улучшения объявлений – Личный кабинет – Агротендер')
         ->setData([
           'advId' => $advId,
           'advTitle' => $advTitle ?? null,
           'packs' => $packs ?? null,
           'payedPacks' => $payedPacks ?? null
         ])
         ->display('user/upgrade');
  }

  public function payBalance() {

    // paid services model
    $paid = $this->model('paid');
    // make billing docs
    if ($this->action == 'makeInvoice') {
      $company      = $this->request->post['company'] ?? null;
      $name         = $this->request->post['name'] ?? null;
      $phone        = $this->request->post['phone'] ?? null;
      $entityAddr   = $this->request->post['entityAddr'] ?? null;
      $code         = $this->request->post['code'] ?? null;
      $inn          = $this->request->post['inn'] ?? null;
      $region       = $this->request->post['region'] ?? null;
      $city         = $this->request->post['city'] ?? null;
      $zip          = $this->request->post['zip'] ?? null;
      $addr         = $this->request->post['addr'] ?? null;
      $docAddrCheck = $this->request->post['docAddrCheck'] ?? null;
      $amount       = $this->request->post['amount'] ?? null;
      $paid->makeInvoice($this->user->id, $this->user->email, $amount, $company, $name, $phone, $entityAddr, $code, $inn, $region, $city, $zip, $addr, $docAddrCheck);
    }



    $payAdv = $this->request->get['payAdv'] ?? null;
    $payPacks = $this->request->get['payPacks'] ?? null;
    $payAmount = $this->request->get['payAmount'] ?? null;

    if ($this->action == 'getPayForm') {
      $type = $this->request->post['type'];
      $amount = $this->request->post['amount'];
      $paid->getPayForm($this->user->id, $type, $amount, $payPacks, $payAdv);
    }

    $advert = $this->model('board')->getAdvert($payAdv);

    if (($payAdv != null && $advert == null) or ($payAdv != null && $advert != null && $advert['author_id'] != $this->user->id)) {
      $this->response->redirect('/u/ads/upgrade');
    }

    /*if ($payAdv != null) {
      $advTitle = $advert['title'];
      $packsTitle = [];
      foreach (imp as $pack) {
        $packsTitle[] = $paid->getPack($pack)['title'];
      }
    } */
    // get regions list for dropdown menu
    $regions = $this->model('board')->getRegions();
    // display page
    $this->view
         ->setTitle('Пополнение баланса – Личный кабинет – Агротендер')
         ->setData([
           'regions' => $regions,
           'payAdv' => $payAdv,
           'advTitle' => $advTitle ?? null,
           'payPacks' => $payPacks,
           'payAmount' => $payAmount,
           'packsTitle' => $packsTitle ?? null
         ])
         ->display('user/payBalance');
  }

  public function historyBalance() {
    // get balance history list
    $list = $this->model('paid')->getHistory($this->user->id);
    // display page
    $this->view
         ->setTitle('История платежей – Личный кабинет – Агротендер')
         ->setData([
           'list' => $list,
         ])
         ->display('user/historyBalance');
  }


  public function docsBalance() {
    $docs = $this->model('paid')->getDocs($this->user->id);
    // display page
    $this->view
         ->setTitle('Счета/акты – Личный кабинет – Агротендер')
         ->setData([
           'docs' => $docs
         ])
         ->display('user/docsBalance');
  }


}
