<?php
namespace App\controllers;
class Main extends \Core\Controller {

    public function __construct() {
        // get user model
        $this->user  = $this->model('user');
        // get super utils ;)
        $this->utils = $this->model('utils');
        // get seo model
        $this->seo   = $this->model('seo');
        // set components
        // print_r($this->user->balance);die();
        $this->view
            ->setData($this->data + $this->utils->getMenu($this->data['page']) + ['detect' => new \Core\MobileDetect, 'user' => $this->user, 'banners' => $this->utils->getBanners()])
            ->setHeader([
                ['bootstrap.min.css', 'noty.css', 'noty/nest.css', 'fontawesome.min.css'],
                'main/home' => ['swiper.min.css'],
                'main/(traders_analitic|traders_analitic-s)' => ['bootstrap-datepicker.min.css'],
                'main/(traders|traders-s|traders_dev)' => ['swiper.min.css'],
                'main/addTrader' => ['swiper.min.css', 'landing.css'],
                'main/reklama' => ['swiper.min.css'],
                ['styles.css']
            ])
            ->setFooter([
                ['jquery-3.3.1.min.js', 'popper.min.js', 'bootstrap.min.js', 'noty.min.js', 'jquery.validate.min.js', 'jquery.mask.min.js', 'html2canvas.js', 'color-thief.min.js'],
                'main/home' => ['swiper.min.js', 'clamp.min.js'],
                'main/(traders_analitic|traders_analitic-s)' => ['bootstrap-datepicker.min.js', 'bootstrap-datepicker.ru.min.js', 'highcharts.js'],
                'main/(traders|traders-s|traders_dev)' => ['jquery.dataTables.min.js', 'stringMonthYear.js', 'swiper.min.js'],
                'main/addTrader' => ['swiper.min.js'],
                'main/reklama' => ['swiper.min.js'],
                ['app.js','sides.js']
            ]);
        if ($this->user->ip != '109.86.1.55') {
            // exit;
        }
        $this->cache = new \Memcached;
        $this->cache->addServer('127.0.0.1', 11211);
    }
    public function api() {
        header('Access-Control-Allow-Origin: *');
        // api model
        $api = $this->model('api');
        // get request token
        $token = $this->request->get['token'] ?? null;
        if ($token == null) {
            $this->response->json(['error' => 'token not found']);
        }
        $accesss = $api->getAccess($token);
        if ($api->access == 0) {
            $this->response->json(['error' => 'accesss denied']);
        }
        if ($api->method == 'getTraders') {
            $region  = $this->request->get['region'] ?? null;
            $rubric  = $this->request->get['rubric'] ?? null;
            $port    = $this->request->get['port'] ?? null;
            $currency = $this->request->get['currency'] ?? null;
            $today    = $this->request->get['today'] ?? null;
            $onlyPorts = ($port == null) ? null : ($port == 'all') ? 'yes' : $port;
            // tradets list
            $traders = $api->getTraders($region, $port, $rubric, $onlyPorts, $currency, $today);
            $this->response->json($traders);
        }
        if ($api->method == 'getTradersUsers') {
            $type  = $this->request->get['type'] ?? 1;
            $trader_id  = $this->request->get['trader_id'] ?? null;
            $trader = $api->getTradersUsers($trader_id, $type);
            $this->response->json($trader);
        }
        if ($api->method == 'getTradersPrices') {
            $region  = $this->request->get['region'] ?? null;
            $rubric  = $this->request->get['rubric'] ?? null;
            $port    = $this->request->get['port'] ?? null;
            $currency = $this->request->get['currency'] ?? null;
            $today    = $this->request->get['today'] ?? null;
            $onlyPorts = ($port == null) ? null : ($port == 'all') ? 'yes' : $port;
            // tradets list
            $traders = $api->getTradersPrices($region, $port, $rubric, $onlyPorts, $currency, $today);
            $this->response->json($traders);
        }
        if ($api->method == 'getRegions') {
            $regions = $api->getRegions();
            $this->response->json($regions);
        }
        if ($api->method == 'getPorts') {
            $ports = $api->getPorts();
            $this->response->json($ports);
        }
        if ($api->method == 'getRubrics') {
            $rubrics = $api->getRubrics();
            $this->response->json($rubrics);
        }
    }


    public function error404() {

        $this->view
            ->setTitle('404')
            ->setDescription('404')
            ->setKeywords('404')
            ->display('main/404');
    }

    public function sitemap() {
        $type = $this->data['type'] ?? null;
        if ($type != null && !in_array($type, ['traders', 'adverts'])) {
            $this->response->redirect('/notfound', 404);
        }
        $rubric = $this->data['rubric'] ?? null;
        $rubrics = null;
        $regions = null;
        $rubricName = null;
        $rubricInfo = null;
        if ($type == 'traders') {
            if ($rubric == null) {
                $rubrics = $this->model('traders')->getRubrics(0);
            } else {
                $rubricInfo = $this->model('traders')->getRubric($rubric);
                if ($rubricInfo == null) {
                    $this->response->redirect('/sitemap/traders');
                }
                $regions = $this->model('traders')->getRegions($rubric, 1);
                if ($regions == null) {
                    $this->response->redirect('/sitemap/traders');
                }
            }
        }
        if ($type == 'adverts') {
            if ($rubric == null) {
                $rubrics = $this->model('board')->getRubrics(null, null, 1)['data'];
            } else {
                $rubricName = $this->model('board')->getRubric($rubric)['title'];
                if ($rubricName == null) {
                    $this->response->redirect('/sitemap/adverts');
                }
                $regions = $this->model('board')->getRegions($rubric, 1);
                if ($regions == null) {
                    $this->response->redirect('/sitemap/adverts');
                }
            }
        }
        $this->view
            ->setTitle('Карта сайта')
            ->setDescription('Карта сайта')
            ->setKeywords('Карта сайта')
            ->setData([
                'type'       => $type,
                'rubrics'    => $rubrics,
                'regions'    => $regions,
                'rubricName' => $rubricName,
                'rubricInfo' => $rubricInfo
            ])->display('main/sitemap');
    }


    public function news() {
        $meta = $this->model('seo')->getPageInfo('news');
        $pageNumber = $this->data['pageNumber'] ?? 1;
        $news = $this->model('info')->getNews(15, $pageNumber);
        $title = ($pageNumber == 1) ? $meta['title'] : "Страница $pageNumber - новости на сайте АгроТендер";
        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->setData([
                'news' => $news['news'],
                'totalPages' => $news['totalPages'],
                'pageNumber' => $pageNumber
            ])->display('main/news');
    }

    public function newsItem() {
        $item = $this->model('info')->getNewsItem($this->data['month'], $this->data['year'], urldecode($this->data['url']));
        if ($item == null) {
            $this->response->redirect('/news');
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
        $posImg = strpos($item["content"],'<img')+4;
        $item["content"] = substr($item["content"],0,$posImg).' class="img-fluid" '.substr($item["content"],$posImg+1);
//    $item["content"] = str_replace('alt=" ','class="img-fluid" alt="',$item["content"]);
//	  var_dump($item["content"]);
        $this->view
            ->setTitle($item['title'].' - Агротендер')
            ->setDescription($description)
            ->setKeywords($item['title'])
            ->setData([
                'item' => $item,
            ])->display('main/newsItem');
    }

    public function faq() {
        $meta = $this->model('seo')->getPageInfo('faq');
        $pageNumber = $this->data['pageNumber'] ?? 1;
        $rubric = $this->data['rubric'] ?? null;
        $faq = $this->model('info')->getFaq(15, $pageNumber, $rubric);
        $title = ($pageNumber == 1) ? $meta['title'] : "Страница $pageNumber - новости на сайте АгроТендер";
        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->setData([
                'faq' => $faq['faq'],
                'totalPages' => $faq['totalPages'],
                'pageNumber' => $pageNumber
            ])->display('main/faq');
    }

    public function faqItem() {
        $item = $this->model('info')->getFaqItem($this->data['url']);
        if ($item == null) {
            $this->response->redirect('/faq');
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
            ])->display('main/faqItem');
    }

    public function contacts() {
        $page = $this->model('seo')->getPageInfo('contacts');
        $this->view
            ->setTitle($page['title'])
            ->setDescription($page['description'])
            ->setKeywords($page['keywords'])
            ->setData([
                'content' => $page['header'],
                'banners' => array_diff_key($this->utils->getBanners(), ['top' => ''])
            ])->display('main/pageInfo');
    }

    public function orfeta() {
        $page = $this->model('seo')->getPageInfo('orfeta');
        $this->view
            ->setTitle($page['title'])
            ->setDescription($page['description'])
            ->setKeywords($page['keywords'])
            ->setData([
                'content' => $page['header'],
                'banners' => array_diff_key($this->utils->getBanners(), ['top' => ''])
            ])->display('main/pageInfo');
    }

    public function limit_adv() {
        $page = $this->model('seo')->getPageInfo('limit_adv');
        $this->view
            ->setTitle($page['title'])
            ->setDescription($page['description'])
            ->setKeywords($page['keywords'])
            ->setData([
                'content' => $page['content'],
                'banners' => array_diff_key($this->utils->getBanners(), ['top' => ''])
            ])->display('main/pageInfo');
    }

    public function chat_bots() {
        $page = $this->model('seo')->getPageInfo('chat_bots');
        $this->view
            ->setTitle($page['title'])
            ->setDescription($page['description'])
            ->setKeywords($page['keywords'])
            ->setData([
                'content' => $page['content'],
                'banners' => array_diff_key($this->utils->getBanners(), ['top' => ''])
            ])->display('main/pageInfo');
    }

    public function reklama() {
        if ($this->user->ip != '109.86.1.55') {
            // $this->response->redirect('/');
        }

        $this->view
            ->setTitle('Реклама')
            ->setDescription('Реклама')
            ->setKeywords('Реклама')
            ->setData([
            ])->display('main/reklama');
    }

    public function index() {
        if ($this->action == 'sendR') {
            $name = $this->request->post['name'];
            $phone = $this->request->post['phone'];
            $email = $this->request->post['email'];
            $selected = $this->request->post['selected'] ?? null;
            $selected = ($selected != null) ? "<br>$selected" : "";
            $message = "Имя: $name<br>Телефон: $phone<br>Email: $email{$selected}";
            $this->utils->mail('reklama@agrotender.com.ua', 'Реклама', $message);
            $this->response->json(['code' => 1, 'text' => 'Сообщение отправлено.']);
        }
        $modal = $this->model('info')->getModals($this->user->id);
        if ($this->action == 'getNotifications') {
            $proposedsCount = $this->user->getNewProposeds();
            $modal = $this->model('info')->getModals($this->user->id);
            $this->response->json(['code' => 1, 'modal' => $modal, 'proposeds' => $proposedsCount]);
        }
        if ($this->action == 'viewedModal') {
            $modalId = $this->request->post['modalId'] ?? null;
            $this->model('info')->viewModal($modalId, $this->user->id);
        }
        $traders = $this->model('traders');
        $meta    = $this->model('seo')->getPageInfo('index');
        // get traders count by product group
        if ($this->action == 'getTraders') {
            $group = $this->request->post['group'];
            $tradersCount = $traders->getCountByGroup($group);
            $this->response->json($tradersCount);
        }

        $cults = [8, 14, 27];
        $prices = $traders->getPricesByCult($cults);
        $topAdv = $this->model('board')->getTopAdverts(10);
        $topAdv = array_chunk($topAdv, 5);

        $randomTraders = $traders->getRandomTraders();

        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->setData([
                'randomTraders' => $randomTraders,
                'prices' => $prices,
                'topAdv' => $topAdv
            ])->display('main/home');
    }

    public function addTrader() {
        $meta    = $this->model('seo')->getPageInfo('addtrader');
        // get traders count by product group
        if ($this->action == 'send') {
            $company = $this->request->post['company'] ?? null;
            $name = $this->request->post['name'] ?? null;
            $phone = $this->request->post['phone'] ?? null;
            $email = $this->request->post['email'] ?? null;
            $this->model('traders')->sendTraderForm($company, $name, $phone, $email);
        }

        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->setData([

            ])->display('main/addTrader');
    }

    public function companies() {
        // decode search query
        $query = urldecode($this->data['query'] ?? null);
        // company model
        $company      = $this->model("company");
        // current region
        $region       = $company->getRegion($this->data['region'] ?? null);
        // current rubric
        $rubric       = $company->getRubric($this->data['rubric'] ?? null);
        if ($this->action == 'getCompanies') {
            $start         = $this->request->post['start'];
            $companiesList = $company->getCompanies($region['id'], $rubric['id'], $start, $query);
            $this->response->json($companiesList);
        }
        // get regions list for dropdown menu
        $regions      = $company->getRegions($rubric['id']);
        // regions_list
        $regions_list = $regions;
        unset($regions_list[0]);
        // rubrics group
        $rubricsGroup = $company->getRubricsGroup();
        // rubrics - (count companies)
        $rubrics      = $company->getRubricsChunk($region['id']);
        //print_r($rubrics); exit;
        $pageNumber   = $this->data['pageNumber1'] ?? null;
        $pageNumber   = ($pageNumber == null) ? $this->data['pageNumber2'] ?? 1 : $pageNumber;
        $companies    = $company->getCompanies(10, $pageNumber, $region['id'], $rubric['id'], $query);
        // get meta data
        $meta         = $this->seo->getCompaniesMeta($rubric, $region);
        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->setData([
                'text'            => $meta['text'],
                'h1'              => $meta['h1'],
                'region'          => $region,
                'regions'         => $regions,
                'regions_list'    => array_chunk($regions_list, 8),
                'rubric'          => $rubric,
                'rubricsGroup'    => $rubricsGroup,
                'rubrics'         => $rubrics,
                'companies'       => $companies['data'],
                'pageNumber'      => $pageNumber,
                'pagePagination'  => $companies['page'],
                'totalPages'      => $companies['totalPages'],
                'query'           => $query
            ])->display('main/companies');
    }

    public function traders_new($section = 'buy') {

        $typeInt = ($section == 'buy') ? 0 : 1;
        // traders model
        $traders = $this->model("traders");
        // get traders from offer
        if ($this->action == 'getTraders') {
            $rubric = $this->request->post['rubric'] ?? null;
            $traders->getTradersByRubric($rubric);
        }
        // send proposed
        if ($this->action == 'send-proposed') {
            $company = $this->request->post['company'] ?? null;
            $description = $this->request->post['description'] ?? null;
            $rubric = $this->request->post['rubric'] ?? null;
            $name = $this->request->post['name'] ?? null;
            $region = $this->request->post['region'] ?? null;
            $phone = $this->request->post['phone'] ?? null;
            $price = $this->request->post['price'] ?? null;
            $currency = $this->request->post['currency'] ?? null;
            $email = $this->request->post['email'] ?? null;
            $bulk = $this->request->post['bulk'] ?? null;
            $companies = $this->request->post['companies'] ?? null;
            $traders->sendProposed($this->user->id, $company, $rubric, $name, $region, $phone, $price, $currency, $email, $bulk, $description, $companies);
        }
        // data rubric
        $rubric       = $this->data['rubric'] ?? null;
        // check if user select only ports
        $onlyPorts    = $this->data['port'] ?? null;
        $onlyPorts    = ($onlyPorts == null) ? null : ($onlyPorts == 'all') ? 'yes' : $onlyPorts;
        // get current page number
        $pageNumber   = $this->request->get['p'] ?? 1;
        // view mode
        $viewmod      = $this->request->get['viewmod'] ?? null;
        // currencies list(varname)
        $currencies   = $traders->getCurrencies();
        // selected currency
        $currency     = $currencies[$this->request->get['currency'] ?? null] ?? null;
        // get regions list for dropdown menu
        $regions      = $traders->getRegions();
        // regions_list
        $regions_list = $regions;
        unset($regions_list[0]);
        // current region
        $region       = $regions[array_keys(array_combine(array_keys($regions), array_column($regions, 'translit')), $this->data['region'] ?? null)[0] ?? null] ?? null;
        // ports list
        $ports        = $traders->getPorts();
        // current port
        $port         = $ports[array_keys(array_combine(array_keys($ports), array_column($ports, 'translit')), $this->data['port'] ?? null)[0] ?? null] ?? null;
        // rubrics list
        $rubrics      = $traders->getRubrics($typeInt, $region['id'], $port['id'], $onlyPorts, $currency['id']);
        $rubricsChunk = $traders->getRubricsChunk($rubrics);
        // current rubric
        $rubric       = $rubrics[array_keys(array_combine(array_keys($rubrics), array_column($rubrics, 'translit')), $rubric)[0] ?? null] ?? null;
        // get traders count from rubric list
        if ($this->action == 'getTradersCount') {
            $rubrics = $this->request->post['rubrics'];
            $res = [];
            foreach ($rubrics as $rubric) {
                $count = $traders->getCountByRubric($rubric, $section, $region['id'], $port['id'], $onlyPorts, $currency['id']);
                $res[] = [
                    'id' => $rubric,
                    'count' => $count
                ];
            }
            $this->response->json(['rubrics' => $res]);
        }
        // rubrics group
        $rubricsGroup = $traders->getRubricsGroup($typeInt);
        // tradets list
        // !!!! не нашел, где используется или выводится
        // $topList      = $traders->getTopList(4, $section, $rubric);
        // tradets list
        $list         = ($viewmod == 'nontbl' || $rubric == null) ? $traders->getList(100, $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id']) : null;
        //  get traders table
        $tableList    = ($rubric != null && $viewmod == null) ? $traders->getTableList($rubric['id'], $section, $region['id'], $port['id'], $onlyPorts, $currency['id']) : null;
        // get meta data
        $meta         = $this->seo->getTradersMeta($rubric, $region, $port, $typeInt, $pageNumber, $onlyPorts);
        // get feed items
        $feed         = $traders->getFeed($typeInt);
        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->setData([
                'h1'             => $meta['h1'],
                'text'           => $meta['text'],
                'section'        => $section,
                'currencies'     => $currencies,
                'currency'       => $currency,
                'regions'        => $regions,
                'regions_list'   => array_chunk($regions_list, 8),
                'region'         => $region,
                'ports'          => $this->utils->fillChunk($ports, 3),
                'port'           => $port,
                'rubricsGroup'   => $rubricsGroup,
                'rubrics'        => $rubricsChunk,
                'rubric'         => $rubric,
                'onlyPorts'      => $onlyPorts,
                'pageNumber'     => $pageNumber,
                'traders'        => ($viewmod == 'nontbl' || $rubric == null) ? array_chunk($list['data'], 6) : null,
                'pagePagination' => $list['page'],
                'totalPages'     => $list['totalPages'],
                'viewmod'        => $viewmod,
                'tableList'      => $tableList,
                'feed'           => $feed
            ])
            ->display('main/traders_new');
    }

    public function traders($section = 'buy') {
//if ( empty($this->data['region']) && empty($this->data['port']) && empty($this->data['rubric']) ) die("Ведутся технические работы, раздел скоро будет доступен");
//if ( $_SERVER['REMOTE_ADDR'] == '37.1.205.103' ) exit;
        $typeInt = ($section == 'buy') ? 0 : 1;
        // traders model
        $traders = $this->model("traders");
        // get traders from offer
        if ($this->action == 'getTraders') {
            $rubric = $this->request->post['rubric'] ?? null;
            $traders->getTradersByRubric($rubric);
        }

        // send proposed
        if ($this->action == 'send-proposed') {
            $company = $this->request->post['company'] ?? null;
            $description = $this->request->post['description'] ?? null;
            $rubric = $this->request->post['rubric'] ?? null;
            $name = $this->request->post['name'] ?? null;
            $region = $this->request->post['region'] ?? null;
            $phone = $this->request->post['phone'] ?? null;
            $price = $this->request->post['price'] ?? null;
            $currency = $this->request->post['currency'] ?? null;
            $email = $this->request->post['email'] ?? null;
            $bulk = $this->request->post['bulk'] ?? null;
            $companies = $this->request->post['companies'] ?? null;
            $traders->sendProposed($this->user->id, $company, $rubric, $name, $region, $phone, $price, $currency, $email, $bulk, $description, $companies);
        }
        // data rubric
        $rubric       = $this->data['rubric'] ?? null;
        // check if user select only ports
        $onlyPorts    = $this->data['port'] ?? null;
        $obl_ports    = $traders->getRegionPorts();
        $region_port = $this->data['region_port'] ?? null;


        $onlyPorts    = ($onlyPorts  == null) ? null : ($onlyPorts == 'all') ? 'yes' : $onlyPorts;
        // get current page number
        $pageNumber   = $this->request->get['p'] ?? 1;
        // view mode
        $viewmod      = $this->request->get['viewmod'] ?? null;

        // currencies list(varname)
        $currencies   = $traders->getCurrencies();
        // selected currency
        $currency     = $currencies[$this->request->get['currency'] ?? null] ?? null;
        // get regions list for dropdown menu
        $regions      = $traders->getRegions();
        // regions_list
        $regions_list = $regions;
        unset($regions_list[0]);
        // current region
        $region       = $regions[array_keys(array_combine(array_keys($regions), array_column($regions, 'translit')), $this->data['region'] ?? null)[0] ?? null] ?? null;
        // ports list
        $ports        = $traders->getPorts();
        // current port
        $port         = $ports[array_keys(array_combine(array_keys($ports), array_column($ports, 'translit')), $this->data['port'] ?? null)[0] ?? null] ?? null;
        // rubrics list
        $rubrics      = $traders->getRubrics($typeInt, $region['id'], $port['id'], $onlyPorts, $currency['id']);
        $rubricsChunk = $traders->getRubricsChunk($rubrics);
        // current rubric
        $rubric       = $rubrics[array_keys(array_combine(array_keys($rubrics), array_column($rubrics, 'translit')), $rubric)[0] ?? null] ?? null;

        //get traders ajax only firt page
        if ($this->action == 'getTradersMore' && $rubric == null && $region == null && $port == null) {
            if($viewmod=='nontbl') exit;
            $start         = $this->request->post['start'];
            $List          = $traders->getList_dev(18, ($start/18), $section, null, null, null, null, null, $region_port);
            $List['count'] = count($List['data']);
            $List['traders'] = array_chunk($List['data'], 6);
            unset($List['data']);
            if(($start/18) > $List['totalPages'] || $start>=132) {
                $List['more']=false;
            }
            //$this->response->json($List);
            echo json_encode($List);exit;
        }

        // get traders count from rubric list
        if ($this->action == 'getTradersCount') {
            $rubrics = $this->request->post['rubrics'];
            $res = [];
            foreach ($rubrics as $rubric) {
                $count = $traders->getCountByRubric($rubric, $section, $region['id'], $port['id'], $onlyPorts, $currency['id'], 1);
                $res[] = [
                    'id' => $rubric,
                    'count' => $count
                ];
            }
            $this->response->json(['rubrics' => $res]);
        }

        // rubrics group
        $rubricsGroup = $traders->getRubricsGroup($typeInt);


        if ( $viewmod == 'nontbl' || $rubric == null)
        {
            $ckey = 'traders_getList_page'.$pageNumber.'_s'.$section.'_r'.$region['id'].'_port'.$port['id'].'_r'.$rubric['id'].'_onlyPorts'.$onlyPorts.'_cur'.$currency['id'];
            if ( !$list = $this->cache->get($ckey) )
            {
                if($rubric == null && $port == null && $region == null ){
                    $list = $traders->getList_dev(18, $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id'],$region_port);
                }
                else
                    $list = $traders->getList_dev(999, $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id'],$region_port);
                $this->cache->set($ckey, $list, 300);
            }
        }else $list = null;

        //  get traders table
        $ckey = 'traders_getTableList_r'.$rubric['id'].'_s'.$section.'_r'.$region['id'].'_p'.$port['id'].'_op'.$onlyPorts.'_c'.$currency['id'];
//if ( $_SERVER['REMOTE_ADDR'] == '37.1.205.103' ) die($ckey);
        if ( !$tableList = $this->cache->get($ckey) )
        {
            $tableList    = ($rubric != null && $viewmod == null) ? $traders->getTableList($rubric['id'], $section, $region['id'], $port['id'], $onlyPorts, $currency['id']) : null;
            $this->cache->set($ckey, $tableList, 300);
        }
//    var_dump($rubric);exit;
        // get meta data
        // $list = $traders->getList(99, $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id']);
        $meta         = $this->seo->getTradersMeta($rubric, $region, $port, $typeInt, $pageNumber, $onlyPorts);

//if ( $_SERVER['REMOTE_ADDR'] == '37.1.205.103' ) { echo "<pre>"; print_r($meta); exit; }

        // get feed items
        $feed         = $traders->getFeed($typeInt);

        $vip = [];
        $usual = [];
        if($list['data']){
            foreach ($list['data'] as  $value) {
                if($value['top'] == 0 || $value['top'] == 1){
                    array_push($usual, $value);
                }
                if($value['top'] == 2){
                    array_push($vip, $value);
                }
            }
        }

        $countvip = count($vip);
        if($countvip ){
            $tradersdop = $traders->getList( 99 + count($vip), $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id']);
            $sdc = $tradersdop['data'][0];
            //print_r($sdc); die();
            array_push($usual, $tradersdop['data'][count($vip) + 1]);
        }

        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->setData([
                'h1'             => $meta['h1'],
                'text'           => $meta['text'],
                'section'        => $section,
                'currencies'     => $currencies,
                'currency'       => $currency,
                'regions'        => $regions,
                'regions_list'   => array_chunk($regions_list, 8),
                'region'         => $region,
                'ports'          => $this->utils->fillChunk($ports, 3),
                'port'           => $port,
                'rubricsGroup'   => $rubricsGroup,
                'rubrics'        => $rubricsChunk,
                'rubric'         => $rubric,
                'onlyPorts'      => $onlyPorts,
                'pageNumber'     => $pageNumber,
                // 'topTraders'     => array_chunk($topList, 2),
                'traders'        => ($viewmod == 'nontbl' || $rubric == null) ? array_chunk($usual, 6) : null,
                'pagePagination' => $list['page'],
                'totalPages'     => $list['totalPages'],
                'viewmod'        => $viewmod,
                'tableList'      => $tableList,
                'feed'           => $feed,
                'vipTraders' => ($viewmod == 'nontbl' || $rubric == null) ? array_chunk($vip, 6) : null])
            ->display('main/traders');
    }

    public function traders_devs($section = 'buy') {
//if ( empty($this->data['region']) && empty($this->data['port']) && empty($this->data['rubric']) ) die("Ведутся технические работы, раздел скоро будет доступен");
//if ( $_SERVER['REMOTE_ADDR'] == '37.1.205.103' ) exit;
        $typeInt = ($section == 'buy') ? 0 : 1;
        // traders model
        $traders = $this->model("traders");
        // get traders from offer
        if ($this->action == 'getTraders') {
            $rubric = $this->request->post['rubric'] ?? null;
            $traders->getTradersByRubric($rubric);
        }

        // send proposed
        if ($this->action == 'send-proposed') {
            $company = $this->request->post['company'] ?? null;
            $description = $this->request->post['description'] ?? null;
            $rubric = $this->request->post['rubric'] ?? null;
            $name = $this->request->post['name'] ?? null;
            $region = $this->request->post['region'] ?? null;
            $phone = $this->request->post['phone'] ?? null;
            $price = $this->request->post['price'] ?? null;
            $currency = $this->request->post['currency'] ?? null;
            $email = $this->request->post['email'] ?? null;
            $bulk = $this->request->post['bulk'] ?? null;
            $companies = $this->request->post['companies'] ?? null;
            $traders->sendProposed($this->user->id, $company, $rubric, $name, $region, $phone, $price, $currency, $email, $bulk, $description, $companies);
        }
        // data rubric
        $rubric       = $this->data['rubric'] ?? null;
        // check if user select only ports
        $onlyPorts    = $this->data['port'] ?? null;
        $onlyPorts    = ($onlyPorts  == null) ? null : ($onlyPorts == 'all') ? 'yes' : $onlyPorts;
        // get current page number
        $pageNumber   = $this->request->get['p'] ?? 1;
        // view mode
        $viewmod      = $this->request->get['viewmod'] ?? null;

        // currencies list(varname)
        $currencies   = $traders->getCurrencies();
        // selected currency
        $currency     = $currencies[$this->request->get['currency'] ?? null] ?? null;
        // get regions list for dropdown menu
        $regions      = $traders->getRegions();
        // regions_list
        $regions_list = $regions;
        unset($regions_list[0]);
        // current region
        $region       = $regions[array_keys(array_combine(array_keys($regions), array_column($regions, 'translit')), $this->data['region'] ?? null)[0] ?? null] ?? null;
        // ports list
        $ports        = $traders->getPorts();
        // current port
        $port         = $ports[array_keys(array_combine(array_keys($ports), array_column($ports, 'translit')), $this->data['port'] ?? null)[0] ?? null] ?? null;
        // rubrics list
        $rubrics      = $traders->getRubrics($typeInt, $region['id'], $port['id'], $onlyPorts, $currency['id']);
        $rubricsChunk = $traders->getRubricsChunk($rubrics);
        // current rubric
        $rubric       = $rubrics[array_keys(array_combine(array_keys($rubrics), array_column($rubrics, 'translit')), $rubric)[0] ?? null] ?? null;

        //get traders ajax only firt page
        // if ($this->action == 'getTradersMore' && $rubric == null && $region == null && $port == null) {
        //   if($viewmod=='nontbl') exit;
        //   $start         = $this->request->post['start'];
        //   $List          = $traders->getList(18, ($start/18), $section);
        //   $List['count'] = count($List['data']);
        //   $List['traders'] = array_chunk($List['data'], 6);
        //   unset($List['data']);
        //   if(($start/18) > $List['totalPages'] || $start>=132) {
        //     $List['more']=false;
        //   }
        //   //$this->response->json($List);
        //   echo json_encode($List);exit;
        // }

        // get traders count from rubric list
        if ($this->action == 'getTradersCount') {
            $rubrics = $this->request->post['rubrics'];
            $res = [];
            foreach ($rubrics as $rubric) {
                $count = $traders->getCountByRubric($rubric, $section, $region['id'], $port['id'], $onlyPorts, $currency['id']);
                $res[] = [
                    'id' => $rubric,
                    'count' => $count
                ];
            }
            $this->response->json(['rubrics' => $res]);
        }

        // rubrics group
        $rubricsGroup = $traders->getRubricsGroup($typeInt);


        if ( $viewmod == 'nontbl' || $rubric == null)
        {
            $ckey = 'traders_getList_page'.$pageNumber.'_s'.$section.'_r'.$region['id'].'_port'.$port['id'].'_r'.$rubric['id'].'_onlyPorts'.$onlyPorts.'_cur'.$currency['id'];
            if ( !$list = $this->cache->get($ckey) )
            {
                if($rubric == null && $port == null && $region == null ){
                    $list = $traders->getList(99, $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id']);
                }
                else
                    $list = $traders->getList(99, $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id']);
                //$this->cache->set($ckey, $list, 300);
            }
        }else $list = $traders->getList(99, $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id']);

        //  get traders table
        $ckey = 'traders_getTableList_r'.$rubric['id'].'_s'.$section.'_r'.$region['id'].'_p'.$port['id'].'_op'.$onlyPorts.'_c'.$currency['id'];
//if ( $_SERVER['REMOTE_ADDR'] == '37.1.205.103' ) die($ckey);
        if ( !$tableList = $this->cache->get($ckey) )
        {
            $tableList    = ($rubric != null && $viewmod == null) ? $traders->getTableList($rubric['id'], $section, $region['id'], $port['id'], $onlyPorts, $currency['id']) : null;
            $this->cache->set($ckey, $tableList, 300);
        }
//    var_dump($rubric);exit;
        // get meta data
        $meta         = $this->seo->getTradersMeta($rubric, $region, $port, $typeInt, $pageNumber, $onlyPorts);

//if ( $_SERVER['REMOTE_ADDR'] == '37.1.205.103' ) { echo "<pre>"; print_r($meta); exit; }

        // get feed items
        $feed         = $traders->getFeed($typeInt);

        $vip = [];
        $usual = [];
        if($list['data']){
            foreach ($list['data'] as  $value) {
                if($value['top'] == 0 || $value['top'] == 1){
                    array_push($usual, $value);
                }
                if($value['top'] == 2){
                    array_push($vip, $value);
                }
            }
        }

        $countvip = count($vip);
        if($countvip ){
            $tradersdop = $traders->getList( 99 + count($vip), $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id']);
            $sdc = $tradersdop['data'][0];
            //print_r($sdc); die();
            array_push($usual, $tradersdop['data'][count($vip) + 1]);
        }

        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->setData([
                'h1'             => $meta['h1'],
                'text'           => $meta['text'],
                'section'        => $section,
                'currencies'     => $currencies,
                'currency'       => $currency,
                'regions'        => $regions,
                'regions_list'   => array_chunk($regions_list, 8),
                'region'         => $region,
                'ports'          => $this->utils->fillChunk($ports, 3),
                'port'           => $port,
                'rubricsGroup'   => $rubricsGroup,
                'rubrics'        => $rubricsChunk,
                'rubric'         => $rubric,
                'onlyPorts'      => $onlyPorts,
                'pageNumber'     => $pageNumber,
                // 'topTraders'     => array_chunk($topList, 2),
                'traders'        => ($viewmod == 'nontbl' || $rubric == null) ? array_chunk($usual, 6) : null,
                'pagePagination' => $list['page'],
                'totalPages'     => $list['totalPages'],
                'viewmod'        => $viewmod,
                'tableList'      => $tableList,
                'feed'           => $feed,
                'vipTraders' => ($viewmod == 'nontbl' || $rubric == null) ? array_chunk($vip, 6) : null])
            ->display('main/traders_dev');
    }

//DEV
    public function traders_dev($section = 'buy') {
//if ( empty($this->data['region']) && empty($this->data['port']) && empty($this->data['rubric']) ) die("Ведутся технические работы, раздел скоро будет доступен");
//if ( $_SERVER['REMOTE_ADDR'] == '37.1.205.103' ) exit;
        $typeInt = ($section == 'buy') ? 0 : 1;
        // traders model
        $traders = $this->model("traders");
        // get traders from offer
        if ($this->action == 'getTraders') {
            $rubric = $this->request->post['rubric'] ?? null;
            $traders->getTradersByRubric($rubric);
        }

        // send proposed
        if ($this->action == 'send-proposed') {
            $company = $this->request->post['company'] ?? null;
            $description = $this->request->post['description'] ?? null;
            $rubric = $this->request->post['rubric'] ?? null;
            $name = $this->request->post['name'] ?? null;
            $region = $this->request->post['region'] ?? null;
            $phone = $this->request->post['phone'] ?? null;
            $price = $this->request->post['price'] ?? null;
            $currency = $this->request->post['currency'] ?? null;
            $email = $this->request->post['email'] ?? null;
            $bulk = $this->request->post['bulk'] ?? null;
            $companies = $this->request->post['companies'] ?? null;

            $traders->sendProposed($this->user->id, $company, $rubric, $name, $region, $phone, $price, $currency, $email, $bulk, $description, $companies);
        }
        // data rubric
        $rubric       = $this->data['rubric'] ?? null;
        // check if user select only ports
        $onlyPorts    = $this->data['port'] ?? null;
        $onlyPorts    = ($onlyPorts  == null) ? null : ($onlyPorts == 'all') ? 'yes' : $onlyPorts;
        // get current page number
        $pageNumber   = $this->request->get['p'] ?? 1;
        // view mode
        $viewmod      = $this->request->get['viewmod'] ?? null;

        //print_r($region_ports_id);die();
        //get traders ajax
        if ($this->action == 'getTradersMore') {
            if($viewmod=='nontbl') exit;
            $start         = $this->request->post['start'];
            $List          = $traders->getList(15, ($start/15), $section);

            foreach ($List['data'] as $key => $value) {
                foreach ($value['prices'] as $key2 => $val) {
                    $List['data'][$key]['prices'][$key2]['price'] =  number_format($val['price'], 0, '.', ' ');
                }
            }

            $List['count'] = count($List['data']);
            $List['traders'] = array_chunk($List['data'], 5);

            unset($List['data']);
            if(($start/16) > $List['totalPages'] || $start>=135) {
                $List['more']=false;
            }

            //$this->response->json($List);
            echo json_encode($List);exit;
        }

        // currencies list(varname)
        $currencies   = $traders->getCurrencies();
        // selected currency
        $currency     = $currencies[$this->request->get['currency'] ?? null] ?? null;
        // get regions list for dropdown menu
        $regions      = $traders->getRegions();
        // regions_list
        $regions_list = $regions;
        unset($regions_list[0]);
        // current region
        $region       = $regions[array_keys(array_combine(array_keys($regions), array_column($regions, 'translit')), $this->data['region'] ?? null)[0] ?? null] ?? null;
        //list of cities where situate ports


        // ports list
        $ports        = $traders->getPorts();
        // current port
        $port         = $ports[array_keys(array_combine(array_keys($ports), array_column($ports, 'translit')), $this->data['port'] ?? null)[0] ?? null] ?? null;
        // rubrics list
        $rubrics      = $traders->getRubrics($typeInt, $region['id'], $port['id'], $onlyPorts, $currency['id']);
        $rubricsChunk = $traders->getRubricsChunk($rubrics);
        // current rubric
        $rubric       = $rubrics[array_keys(array_combine(array_keys($rubrics), array_column($rubrics, 'translit')), $rubric)[0] ?? null] ?? null;
        // get traders count from rubric list
        if ($this->action == 'getTradersCount') {
            $rubrics = $this->request->post['rubrics'];
            $res = [];
            foreach ($rubrics as $rubric) {
                $count = $traders->getCountByRubric($rubric, $section, $region['id'], $port['id'], $onlyPorts, $currency['id']);
                //print_r($count);die();
                $res[] = [
                    'id' => $rubric,
                    'count' => $count
                ];
            }
            $this->response->json(['rubrics' => $res]);
        }
        $r_count = [];
        foreach ($rubrics as $rubricc) {
            $count = $traders->getCountByRubric_dev($rubricc['id'], $section, $region['id'], $port['id'], $onlyPorts, $currency['id']);
            //print_r($count);die();
            $r_count[] = [
                'id' => $rubricc['id'],
                'count' => $count
            ];
        }

        // rubrics group
        $rubricsGroup = $traders->getRubricsGroup($typeInt);

        if ( $viewmod == 'nontbl' || $rubric == null)
        {
            $ckey = 'traders_getList_page'.$pageNumber.'_s'.$section.'_r'.$region['id'].'_port'.$port['id'].'_r'.$rubric['id'].'_onlyPorts'.$onlyPorts.'_cur'.$currency['id'];
            if ( !$list = $this->cache->get($ckey) )
            {
                if($rubric == null)
                    $list = $traders->getList(20, $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id']);
                else
                    $list = $traders->getList(20, $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id']);
                $this->cache->set($ckey, $list, 300);
            }
        }else $list = null;

        //  get traders table
        $ckey = 'traders_getTableList_r'.$rubric['id'].'_s'.$section.'_r'.$region['id'].'_p'.$port['id'].'_op'.$onlyPorts.'_c'.$currency['id'];

        if ( !$tableList = $this->cache->get($ckey) )
        {
            $tableList    = ($rubric != null && $viewmod == null) ? $traders->getTableList($rubric['id'], $section, $region['id'], $port['id'], $onlyPorts, $currency['id']) : null;
            $this->cache->set($ckey, $tableList, 300);
        }
        //$list = $traders->getList(99, $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id']);
        // get meta data
        $meta         = $this->seo->getTradersMeta($rubric, $region, $port, $typeInt, $pageNumber, $onlyPorts);


        // get feed items
        $feed         = $traders->getFeed($typeInt);

        $vip = [];
        $usual = [];
        if($list['data']){
            foreach ($list['data'] as  $value) {
                if($value['top'] == 0 || $value['top'] == 1){
                    array_push($usual, $value);
                }
                if($value['top'] == 2){
                    array_push($vip, $value);
                }
            }
        }
        foreach ($vip as $key => $value) {
            foreach ($value['prices'] as $key2 => $val) {
                $vip[$key]['prices'][$key2]['price'] =  number_format($val['price'], 0, '.', ' ');
            }
        }
//print_r($usual);die();
        $countvip = count($vip);
        if($countvip ){
            $tradersdop = $traders->getList_dev( 99 + count($vip), $pageNumber, $section, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id']);
            $sdc = $tradersdop['data'][0];

            array_push($usual, $tradersdop['data'][count($vip) + 1]);
        }

        foreach ($usual as $key => $value) {
            foreach ($value['prices'] as $key2 => $val) {
                $usual[$key]['prices'][$key2]['price'] =  number_format($val['price'], 0, '.', ' ');
            }
        }
//print_r($usual);die();
        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->setData([
                'h1'             => $meta['h1'],
                'text'           => $meta['text'],
                'section'        => $section,
                'currencies'     => $currencies,
                'currency'       => $currency,
                'regions'        => $regions,
                'regions_list'   => array_chunk($regions_list, 8),
                'region'         => $region,
                'ports'          => $this->utils->fillChunk($ports, 3),
                'port'           => $port,
                'rubricsGroup'   => $rubricsGroup,
                'rubrics'        => $rubricsChunk,
                'rubric'         => $rubric,
                'onlyPorts'      => $onlyPorts,
                'pageNumber'     => $pageNumber,
                // 'topTraders'     => array_chunk($topList, 2),
                'traders'        => ($viewmod == 'nontbl' || $rubric == null) ? array_chunk($usual, 5) : null,
                'pagePagination' => $list['page'],
                'totalPages'     => $list['totalPages'],
                'viewmod'        => $viewmod,
                'tableList'      => $tableList,
                'feed'           => $feed,
                'r_count'        => $r_count,
                'vipTraders' => ($viewmod == 'nontbl' || $rubric == null) ? array_chunk($vip, 5) : null])
            ->display('main/traders_dev');
    }

    public function tradersForwards() {
        $typeInt = 0; // тип для получения рубрик
        // traders model
        $traders = $this->model("traders");
        $price_type = $traders->forwardPriceType;
        $forward_months = $traders->getForwardsMonths();
        $dt_start = $forward_months[0]['start']; // дата начала отображения форвардных цен
        // get traders from offer
        if ($this->action == 'getTraders') {
            $rubric = $this->request->post['rubric'] ?? null;
            $traders->getTradersByRubric($rubric);
        }
        // send proposed
        if ($this->action == 'send-proposed') {
            $company = $this->request->post['company'] ?? null;
            $description = $this->request->post['description'] ?? null;
            $rubric = $this->request->post['rubric'] ?? null;
            $name = $this->request->post['name'] ?? null;
            $region = $this->request->post['region'] ?? null;
            $phone = $this->request->post['phone'] ?? null;
            $price = $this->request->post['price'] ?? null;
            $currency = $this->request->post['currency'] ?? null;
            $email = $this->request->post['email'] ?? null;
            $bulk = $this->request->post['bulk'] ?? null;
            $companies = $this->request->post['companies'] ?? null;
            $traders->sendProposed($this->user->id, $company, $rubric, $name, $region, $phone, $price, $currency, $email, $bulk, $description, $companies);
        }
        // data rubric
        $rubric       = $this->data['rubric'] ?? null;
        // check if user select only ports
        $onlyPorts    = $this->data['port'] ?? null;
        $onlyPorts    = $onlyPorts == 'all' ? 'yes' : $onlyPorts;
        // get current page number
        $pageNumber   = $this->request->get['p'] ?? 1;
        // view mode
        $viewmod      = $this->request->get['viewmod'] ?? null;
        // currencies list(varname)
        $currencies   = $traders->getCurrencies();
        // selected currency
        $currency     = $currencies[$this->request->get['currency'] ?? null] ?? null;
        // get regions list for dropdown menu
        $regions      = $traders->getRegions();
        // regions_list
        $regions_list = $regions;
        unset($regions_list[0]);
        // current region
        $region       = $regions[array_keys(array_combine(array_keys($regions), array_column($regions, 'translit')), $this->data['region'] ?? null)[0] ?? null] ?? null;
        // ports list
        $ports        = $traders->getPorts();
        // current port
        $port         = $ports[array_keys(array_combine(array_keys($ports), array_column($ports, 'translit')), $this->data['port'] ?? null)[0] ?? null] ?? null;
        // rubrics list

        $rubrics      = $traders->getForwardRubrics($typeInt, $price_type, $region['id'], $port['id'], $onlyPorts, $currency['id']);
        $rubricsChunk = $traders->getRubricsChunk($rubrics);
        // current rubric
        $rubric       = $rubrics[array_keys(array_combine(array_keys($rubrics), array_column($rubrics, 'translit')), $rubric)[0] ?? null] ?? null;
        // avail rubrics group
        $group_ids    = array_unique(array_column($rubrics, 'group_id'));
        $rubricsGroup = $traders->getRubricsGroup($typeInt, $group_ids);

        // tradets list
        $list = null;
        $ckey = 'traders_getListForwards_page'.$pageNumber.'_r'.$region['id'].'_port'.$port['id'].'_r'.$rubric['id'].'_onlyPorts'.$onlyPorts.'_cur'.$currency['id'];
        if ( ($viewmod == 'nontbl' || $rubric == null) && !$list = $this->cache->get($ckey) )
        {
            $list = $traders->getListForwards(999, $pageNumber, $region['id'], $port['id'], $rubric['id'], $onlyPorts, $currency['id'], $dt_start);
            $this->cache->set($ckey, $list, 300);
        }
        //  get traders table
        $tableList = null;
        $ckey = 'traders_getTableListForwards_r'.$rubric['id'].'_r'.$region['id'].'_p'.$port['id'].'_op'.$onlyPorts.'_c'.$currency['id'];
        if ( ($rubric != null && $viewmod != 'nontbl') && !$tableList = $this->cache->get($ckey) )
        {
            $tableList = $traders->getTableListForwards($rubric['id'], $region['id'], $port['id'], $onlyPorts, $currency['id'], $dt_start);
            $this->cache->set($ckey, $tableList, 300);
        }

        // get meta data
        $meta = $this->seo->getTradersMeta($rubric, $region, $port, $price_type, $pageNumber, $onlyPorts);

        // get feed items
        $feed = $traders->getFeed($price_type);
        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->setData([
                'h1'             => $meta['h1'],
                'text'           => $meta['text'],
                'currencies'     => $currencies,
                'currency'       => $currency,
                'regions'        => $regions,
                'regions_list'   => array_chunk($regions_list, 8),
                'region'         => $region,
                'ports'          => $this->utils->fillChunk($ports, 3),
                'port'           => $port,
                'rubricsGroup'   => $rubricsGroup,
                'rubrics'        => $rubricsChunk,
                'rubric'         => $rubric,
                'onlyPorts'      => $onlyPorts,
                'pageNumber'     => $pageNumber,
                'traders'        => ($viewmod == 'nontbl' || $rubric == null) ? array_chunk($list['data'], 6) : null,
                'pagePagination' => $list['page'],
                'totalPages'     => $list['totalPages'],
                'viewmod'        => $viewmod,
                'tableList'      => $tableList,
                'feed'           => $feed,
                'forwardMonths'  => $forward_months,
            ])
            ->display('main/tradersForwards');
    }

    public function analitic($section = 'buy') {
        $typeInt = ($section == 'buy') ? 0 : 1;
        // traders model
        $traders      = $this->model("traders");
        // data rubric
        $rubric       = $this->data['rubric'] ?? null;
        // check if user select only ports
        $port         = $this->data['port'] ?? null;
        $onlyPorts    = ($port == null) ? null : ($port == 'all') ? 'yes' : $port;
        // get start date
        $start        = $this->request->get['start'] ?? date("d.m.Y", strtotime(date("d.m.Y") . "-1 month -1 days"));
        // get end date
        $end          = $this->request->get['end'] ?? date("d.m.Y", strtotime(date("d.m.Y") . "-1 days"));
        // step
        $step         = $this->request->get['step'] ?? 'week';
        // currencies list(varname)
        $currencies   = $traders->getCurrencies();
        // selected currency
        $currency     = $currencies[$this->request->get['currency'] ?? 'uah'] ?? null;
        // get regions list for dropdown menu
        $regions      = $traders->getRegions();
        // regions_list
        $regions_list = $regions;
        unset($regions_list[0]);
        // current region
        $region       = $regions[array_keys(array_combine(array_keys($regions), array_column($regions, 'translit')), $this->data['region'] ?? null)[0] ?? null] ?? null;
        // ports list
        $ports        = $traders->getPorts();
        // current port
        $port         = $ports[array_keys(array_combine(array_keys($ports), array_column($ports, 'translit')), $this->data['port'] ?? null)[0] ?? null] ?? null;
        // rubrics list
        $rubrics      = $traders->getRubrics($typeInt);
        $rubricsChunk = $traders->getRubricsChunk($rubrics);
        // current rubric
        $rubric       = $rubrics[array_keys(array_combine(array_keys($rubrics), array_column($rubrics, 'translit')), $rubric)[0] ?? null] ?? null;
        // rubrics group
        $rubricsGroup = $traders->getRubricsGroup($typeInt);

        if ($this->action == 'getAnalitic') {
            $analitic = $traders->getAnalitic($rubric, strtotime($start), strtotime($end), $step, $section, $region['id'], $port['id'], $onlyPorts, $currency['id']);
            $this->response->json(['categories' => $analitic['categories'], 'graph' => $analitic['data']]);
        }
        // get meta data
        $meta         = $this->seo->getAnaliticMeta($rubric, $region, $port, $typeInt, $onlyPorts);
        /* echo "<pre>";
        print_r($tableList);
        exit; */
        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'] ?? '')
            ->setKeywords($meta['keywords'])
            ->setData([
                'section'        => $section,
                'currencies'     => $currencies,
                'currency'       => $currency,
                'regions'        => $regions,
                'regions_list'   => array_chunk($regions_list, 8),
                'region'         => $region,
                'ports'          => $this->utils->fillChunk($ports, 3),
                'port'           => $port,
                'rubricsGroup'   => $rubricsGroup,
                'rubrics'        => $rubricsChunk,
                'rubric'         => $rubric,
                'onlyPorts'      => $onlyPorts,
                'start'          => $start,
                'end'            => $end,
                'step'           => $step,
                'h1'             => $meta['h1']
            ])
            ->display('main/analitic');
    }

    public function elevItem() {
        // elevator model
        $elev = $this->model('elev');
        // elevator url
        $url  = $this->data['id'].'-'.urldecode($this->data['url']);
        // get elevator info
        $item = $elev->getItem($url);
        // in not isset elevator
        if ($item == null) {
            $this->response->redirect('/elev', 302);
        }

        $this->view
            ->setTitle($item['name'].' в '.$item['region'].' области, '.$item['ray'].'. Тендерные торги Агротендер')
            ->setDescription($item['orgname'].', '.$item['region'].' области')
            ->setKeywords('элеватор, '.$item['name'].' в '.$item['region'].' области')
            ->setData([
                'elev' => $item
            ])
            ->display('main/elevItem');
    }

    public function elev() {
        // elevator model
        $elev        = $this->model('elev');
        // get regions list for dropdown menu
        $regions     = $elev->getRegions();
        // regions_list
        $regions_list = $regions;
        unset($regions_list[0]);
        // current region
        $region      = $regions[array_keys(array_combine(array_keys($regions), array_column($regions, 'translit')), $this->data['region'] ?? null)[0] ?? null] ?? null;

        if ($this->action == 'getElevs') {
            $start            = $this->request->post['start'];
            $elevList         = $elev->getList($region, $start);
            $elevList['elev'] = array_chunk($elevList['elev'], 2);
            $this->response->json($elevList);
        }
        $meta = $this->model('seo')->getPageInfo('elevinfo');
        if ($meta != null) {
            $title = $meta['title'];
            $keywords = $meta['keywords'];
            $description = $meta['description'];
        } else {
            // title
            $title       = ($region == null) ? 'Элеваторы в Украине - тендерные торги Агротендер' : 'Элеваторы - '.$region['name'].' область, Украина. Тендерные торги Агротендер';
            // description
            $description = ($region == null) ? 'Все элеваторы в Украине на сайте Агротендер. Полная база всех элеваторов во всех областях Украины с предложениями на реализацию продукции.' : 'Перечень элеваторов - '.$region['name'].' область. Предложения по реализации аграрной продукции с элеваторов, '.$region['name'].' область';
            // keywords
            $keywords    = ($region == null) ? 'элеватор, элеваторы, Украина' : 'элеватор, элеваторы, Украина, '.$region['name'].' область';
        }
        // elevators list
        $list        = $elev->getList($region);
        $this->view
            ->setTitle($title)
            ->setDescription($description)
            ->setKeywords($keywords)
            ->setData([
                'list'         => array_chunk($list['elev'], 2),
                'regions'      => $regions,
                'regions_list' => $this->utils->fillChunk($regions_list, 3),
                'region'       => $region
            ])
            ->display('main/elev');
    }

    public function logout() {
        $this->session->delete('id');
        $this->cookie->delete('hash');
        $this->response->redirect('/');
    }

    public function restore() {
        if ($this->user->auth) {
            $this->response->redirect('/');
        }
        if ($this->action == 'restore') {
            $email      = $this->request->post['email'];
            // restore password process
            $this->user->restore($email);
        }
        $meta = $this->seo->getPageInfo('buyerpassrest');
        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->display('main/restore');
    }

    public function signin() {
        if ($this->user->auth) {
            $this->response->redirect('/');
        }
        $buyerlog  = $this->request->get['buyerlog'] ?? null;
        $buyerpass = $this->request->get['buyerpass'] ?? null;
        if ($this->user->auth && $buyerlog == null) {
            $this->response->redirect('/');
        } else {
            $this->user->id = 0;
        }
        if ($buyerlog != null && $buyerpass != null) {
            // login process
            $this->user->login($buyerlog, $buyerpass, 1);
        }
        if ($this->action == 'sign-in') {

            $email      = $this->request->post['email'];
            $password   = $this->request->post['password'];
            // login process
            $this->user->login($email, $password);
        }
        $meta = $this->seo->getPageInfo('buyerlog');
        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->display('main/signin');
    }

    public function signup() {
        if ($this->user->auth) {
            $this->response->redirect('/');
        }
        // send confirm code to sms
        if ($this->action == 'send-code') {
            $phone = $this->request->post['phone'];
            $checkPhone = $this->db->query("select id from agt_torg_buyer where phone = $phone && smschecked = 1")[0]['id'] ?? null;
            if ($checkPhone == null) {
                $this->user->sendConfirmCode($phone);
            } else {
                $this->response->json(['code' => 0, 'text' => 'Номер уже кем-то используется.']);
            }
        }
        if ($this->action == 'sign-up') {
            $email      = $this->request->post['email'];
            $password   = $this->request->post['password'];
            //$rePassword = $this->request->post['rePassword'];
            $name       = $this->request->post['name'];
            $phone      = $this->request->post['phone'];

            //$region     = $this->request->post['region'];

            $code = $this->request->post['code'];
            // check if correct confirm code
//            if ($code == $this->session->get('code')) {
            if ($code == 1111) {
                // register process
                $this->user->register($email, $password, 0, $name, $phone); // without region
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
        // async validate
        if ($this->action == 'check-email') {
            $email = $this->request->post['email'];
            die($this->user->checkExist('login', $email) ? 'false' : 'true');
        }
        if ($this->action == 'check-phone') {
            $phone = $this->request->post['phone'];
            $checkPhone = $this->db->query("select id from agt_torg_buyer where phone = $phone && smschecked = 1")[0]['id'] ?? null;
            if ($checkPhone == null) {
                die('true');
            } else {
                die('false');
            }
        }
        $regions = $this->utils->getRegions();
        $meta    = $this->seo->getPageInfo('buyerreg');
        $this->view
            ->setTitle($meta['title'])
            ->setDescription($meta['description'])
            ->setKeywords($meta['keywords'])
            ->setData([
                'regions' => $regions
            ])
            ->display('main/signup');
    }

    public function changeEmail() {
        $id = $this->data['id'];
        $emailHash = base64_decode($this->data['email']);
        $checkExist = $this->db->select('agt_torg_buyer', ['id', 'new_login'], ['id' => $id])[0] ?? null;
        if ($checkExist == null) {
            $this->session->set('info', 'Что-то пошло не так. Попробуйте снова.');
            $this->response->redirect('/error');
        } else {
            if (password_verify($checkExist['new_login'], $emailHash)) {
                $this->db->update('agt_torg_buyer', ['login' => $checkExist['new_login'], 'new_login' => ''], ['id' => $id]);
                $this->session->set('info', 'Ваш Email успешно изменён.');
                $this->response->redirect('/success');
            } else {
                $this->session->set('info', 'Что-то пошло не так. Попробуйте снова.');
                $this->response->redirect('/error');
            }
        }
    }

    public function thankyou() {
        if ($this->user->auth) {
            $this->response->redirect('/');
        }
        $thankyou = $this->session->getOnce('thankyou');
        if ($thankyou == null) {
            $this->response->redirect('/');
        }
        $this->view
            ->setTitle('Спасибо за регистрацию!')
            ->display('main/thankyou');
    }

    public function act() {
        if ($this->user->auth) {
            $this->response->redirect('/');
        }
        $hash     = $this->data['hash'];
        $this->user->activate($hash);
    }

    public function info($type) {
        $text = $this->session->getOnce('info');
        if ($text == null) {
            $this->response->redirect('/');
        }
        $this->view
            ->setTitle('Аграрный сайт Украины №1')
            ->setData([
                'text' => $text,
                'type' => $type
            ])
            ->display('main/info');
    }

    public function pay() {
        $data = $this->request->post['data'] ?? null;
        $sign = $this->request->post['signature'] ?? null;
        if ($data == null && $sign == null) {
            $this->response->json(['code' => 0, 'text' => 'error request']);
        }
        $this->model('paid')->payBalance($data, $sign);
    }

    public function pageNotFound() {
        $this->view->setTitle('Страница не найдена')->display('main/404');
    }
}
