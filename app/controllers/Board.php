<?php
namespace App\controllers;

function cl_print_r ($var, $label = '')
{
  $str = json_encode(print_r ($var, true));
  echo "<script>console.group('".$label."');console.log('".$str."');console.groupEnd();</script>";
}

class Board extends \Core\Controller {

  public function __construct() {
    // get user model
    $this->user  = $this->model('user');
    // get super utils ;)
    $this->utils = $this->model('utils');
    // get seo model
    $this->seo   = $this->model('seo');
    // components
    $this->view
         ->setData($this->data + $this->model('utils')->getMenu($this->data['page']) + ['detect' => new \Core\MobileDetect, 'user' => $this->user, 'banners' => $this->utils->getBanners()])
         ->setHeader([
           ['bootstrap.min.css', 'noty.css', 'noty/nest.css', 'fontawesome.min.css'],
           'board/advert' => ['swiper.min.css', 'imagelightbox.css'],
           'board/add' => ['multiple-select.css'],
           'board/edit' => ['multiple-select.css'],
           ['styles.css']
         ])->setFooter([
           ['jquery-3.3.1.min.js', 'popper.min.js', 'bootstrap.min.js', 'noty.min.js', 'jquery.validate.min.js', 'html2canvas.js', 'color-thief.min.js'],
           'board/index' => ['jquery.ellipsis.js'],
           'board/advert' => ['swiper.min.js', 'imagelightbox.js','jquery.ellipsis.js'],
           'board/add' => ['multiple-select.js', 'jquery.mask.min.js'],
           'board/edit' => ['multiple-select.js', 'jquery.mask.min.js'],
           ['app.js','sides.js']
         ]);
    // board model
    $this->board = $this->model('board');
  }

  public function index() {
    // decode search query
    $query        = urldecode($this->data['query'] ?? null);
    // get all adverts types
    $types        = $this->board->getTypes();
    $type = $this->data['type'] ?? null; 
    // adverts type
    $type         = ($type != 'all' && $type != null) ? $types[$type] : null;
    $typeInt      = ($type == null) ? null : $type['id'];
    // get current page number
    $pageNumber   = $this->data['pageNumber'] ?? null;
    // traders model
    $traders      = $this->model("traders");
    // current rubric
    $rubric       = $this->board->getRubric($this->data['rubric'] ?? null);
    // get regions list for dropdown menu
    $regions      = $this->board->getRegions();
    // regions_list
    $regions_list = $regions;
    unset($regions_list[0]);
    // current region 
    $region       = $regions[array_keys(array_combine(array_keys($regions), array_column($regions, 'translit')), $this->data['region'] ?? null)[0] ?? null] ?? null;
    // get adverts count 
    if ($this->action == 'getRCount') {
      $rubrics = $this->request->post['rubrics'];
      $res = [];
      foreach ($rubrics as $rubric) {
        $rubricParent = explode('.', $rubric);
        $count = (isset($rubricParent[1]) && $rubricParent[1] == 'p1') ? $this->board->getCountByRubric(['id' => $rubricParent[0], 'parent_id' => 0], $region, $typeInt) : $this->board->getCountByRubric(['id' => $rubricParent[0], 'parent_id' => 1], $region, $typeInt);
        $res[] = [
          'id' => $rubricParent[0],
          'count' => $count
        ];
      }
      $this->response->json(['rubrics' => $res]);
    }
    // rubrics
    $rubrics      = $this->board->getRubrics($region, $type);
    // get top adverts
    $topAdverts   = $this->board->getTopAdverts(4, $type['id'], $region['id'], $rubric['id'], $rubric['parent_id'], $query);
    // get all adverts
    $adverts      = $this->board->getAdverts(15, $pageNumber, $type['id'], $region['id'], $rubric['id'], $rubric['parent_id'], null, null, $query);
    // get meta data
    $p            = ($pageNumber == null) ? 1 : $pageNumber;
    $meta         = $this->seo->getBoardMeta($rubric, $region, $typeInt, $p);
//     foreach ($regions_list as $region) {
//         foreach ($rubrics as $allrubrics) {
//           foreach ($allrubrics as $rubrick) {
//             print_r("RewriteRule ^(.*)/board/regoin_".$region['translit']."/all_t".$rubrick['id']."_p1 /board/regoin_".$region['translit']."/all_t".$rubrick['id']."$1 [R=301,L] \n");
//           }
//         }
//     }
// die();
    $this->view
         ->setTitle($meta['title'])
         ->setDescription($meta['description'])
         ->setKeywords($meta['keywords'])
         ->setData([
           'h1'              => $meta['h1'],
           'type'            => $type,
           'types'           => $types,
           'region'          => $region,
           'regions'         => $regions, 
           'regions_list'    => array_chunk($regions_list, 8), 
           'rubric'          => $rubric,
           'rubrics'         => $rubrics,
           'topAdverts'      => $topAdverts,
           'adverts'         => $adverts['data'],
           'query'           => $query,
           'pageNumber'      => $pageNumber,
           'pagePagination'  => $adverts['page'],
           'totalPages'      => $adverts['totalPages'],
           'text'            => $meta['text']
         ])->display('main/board');
  } 

  public function advert() {
    // traders model
    $traders      = $this->model("traders");
    // decode search query
    $query        = urldecode($this->data['query'] ?? null);
    // get advert from id
    $advert = $this->board->getAdvert($this->data['id']); 
    if ($advert == null) {
      $this->response->redirect('/board');
    }
    $this->board->updateViews($this->data['id'], $this->user->ip);
    // send complain
    if ($this->action == 'complain') {
      $text = $this->request->post['text'] ?? null;
      $this->board->sendComplain($text, $this->data['id']);
    }
    // get all adverts types
    $types        = $this->board->getTypes();
    // adverts type
    $type         = $types[array_keys(array_combine(array_keys($types), array_column($types, 'id')), $advert['type_id'])[0]];
    // advert rubric
    $rubric       = $this->board->getRubric($advert['topic_id']);
    // get regions list for dropdown menu
    $regions      = $this->board->getRegions();
    // advert region
    $region       = $regions[array_keys(array_combine(array_keys($regions), array_column($regions, 'id')), $advert['obl_id'])[0]];
        // regions_list
    $regions_list = $regions;
    unset($regions_list[0]);
    // rubrics
    $rubrics      = $this->board->getRubrics($region, $type);
    // other adverts
    $other  = $this->board->getAdverts(3, 1, null, null, null, 0, $advert['author_id'], $advert['id'])['data'];
    // similar adverts
    $similar = $this->board->getAdverts(3, 0, $advert['type_id'], $advert['obl_id'], $advert['subrubric_id'], $advert['rubric_id'], $advert['id'])['data'];
    if (count($similar) < 3) {
      $similar = $this->board->getAdverts(3, 0, $advert['type_id'], null, $advert['rubric_id'], 0, null, $advert['id'])['data'];
    }
    // get advert photos
    $photos = $this->board->getAdvertPhoto($advert['id']);
    if ($advert['cost_dog'] == 1) {
      $price = 'договорная';
    } elseif ($advert['cost_dog'] == 0 && $advert['cost'] == null) {
      $price = 'договорная';
    } else {
      $price = $advert['cost'];
      if ($advert['cost_cur'] == 1) {
        $price .= ' грн.';
      } elseif ($advert['cost_cur'] == 2) {
        $price .= ' $';
      } elseif ($advert['cost_cur'] == 3) {
        $price .= ' €';
      } elseif ($advert['cost_cur'] == 0) {
        $price .= ' грн.';
      }
    }
    $title = $advert['title'].", Цена ".$price." - ".$advert['city'].". Объявления на agrotender.com.ua.";
    $contacts = ($advert['company_id'] != null) ? $this->model('company')->getContacts($advert['company_id'], $advert['type_id']) : null;
    $this->view
         ->setTitle($title)
         ->setKeywords($advert['title'])
         ->setDescription(substr($advert['content'], 0, 160))
         ->setData([
           'contacts' => $contacts,
           'advert'  => $advert,
           'regions_list'    => array_chunk($regions_list, 8), 
           'rubrics'         => $rubrics,
           'photos'  => $photos,
           'other'   => $other,
           'similar' => $similar,
           'region'  => $region,
           'rubric'  => $rubric,
           'regions' => array_chunk($this->board->getRegions(), 8),
           'type'    => $type,
           'types'   => $types,
           'query'   => $query
         ])->display('main/advert');
  }

  public function author() {
    $author = $this->db->query("select b.id, b.name, c.title as company from agt_torg_buyer b left join agt_comp_items c on c.author_id = b.id where b.id = ".$this->data['id'])[0] ?? null;
    if ($author == null) {
      $this->response->redirect('/board');
    }
    // get current page number
    $pageNumber   = $this->request->get['p'] ?? null;
    // get all adverts
    $adverts      = $this->board->getAdverts(15, $pageNumber, null, null, null, null, $author['id'], null, null);
    $this->view
         ->setTitle("Все объявления автора {$author['name']}: Объявления на Agrotender.com.ua.")
         ->setDescription("Все объявления автора {$author['name']} на аграрном портале Agrotender.com.ua. Актуальные объявления о закупках и продаже агротоваров от {$author['name']}.")
         ->setKeywords('Доска объявлений, '.$author['name'])
         ->setData([
           'adverts'         => $adverts['data'],
           'author'          => $author,
           'pageNumber'      => $pageNumber,
           'pagePagination'  => $adverts['page'],
           'totalPages'      => $adverts['totalPages']
         ])->display('main/authorAdverts');
  }

  public function add() {
    if (!$this->user->auth) {
      $this->response->redirect('/buyerlog');
    }

    // check limits
    $boardPosts = $this->board->getCountByAuthor($this->user->id);
    if ($boardPosts >= $this->user->limits['max']) {
      $this->session->set('advError', 1); 
      $this->response->redirect('/u/posts');
    }
    if ($this->user->limits['avail'] <= 0) {
      $this->session->set('advError', 2); 
      $this->response->redirect('/u/posts');
    }

    if ($this->action == 'getProposed') {
      $title = $this->request->post['title'];
      $this->board->getProposedRubrics($title);
    }

    if ($this->action == 'addPost') {
      $checkPhone = $this->db->query("select id from agt_torg_buyer where id = {$this->user->id} && phone = {$this->user->phone} && smschecked = 1")[0]['id'] ?? null;
      if ($checkPhone == null) {
        $this->response->json(['code' => 0, 'text' => 'Нужно подтвердить номер телефона.']);
      }
      $title = $this->request->post['title'];
      $rubric = $this->request->post['rubric'];
      $type = $this->request->post['type'];
      $description = $this->request->post['description'];
      $price = $this->request->post['price'];
      $currency = $this->request->post['currency'];
      $count = $this->request->post['count'];
      $unit = $this->request->post['unit'] ?? '';
      $regions = $this->request->post['regions'];
      $city = $this->request->post['city'];
      $images = $this->request->files['images'] ?? null;
      $cover = $this->request->post['cover'];
      $agree = $this->request->post['agree'] ?? 0;
      $this->board->addPost($title, $rubric, $type, $description, $price, $currency, $agree, $count, $unit, $images, $cover, $regions, $city);
    }
    // get regions list for dropown menu
    $regions = $this->board->getRegions();
    
    $first_elem = array_shift($regions);
    array_push($regions, $first_elem);
    // rubrics 
    $rubrics = $this->board->getRubrics();
    $this->view
         ->setTitle('Агро доска объявлений Украины на Агротендер. Агро объявления, Аграрная, АПК')
         ->setDescription('На Агро доске объявлений портала Агротендер Вы сможете разместить объявления о купле/продаже интересующей вас с/х продукции.')
         ->setKeywords('Агро доска объявлений, Аграрная, АПК доска, сельхоз продукция, продать, купить пшеницу, кукурузу, ячмень, подсолнечник, зерновые, бобовые, масличные, овощи, фрукты, ягоды, мясо, молоко, яйца, полуфабрикаты, муку, крупы, морепродукты, рыбу, соки, мучные изделия, агро объявления')
         ->setData([ 
           'regions' => $regions,
           'rubrics' => $rubrics
         ])
         ->display('main/addAdvert');
  }

  public function edit() {
    if (!$this->user->auth) {
      $this->response->redirect('/buyerlog');
      
    }
    // get advert from id
    $advert = $this->board->getAdvert($this->data['id']); 
    if ($advert == null) {
      $this->response->redirect('/u/ads');
    }
    if($this->user->id != $advert['author_id']){
      $this->response->redirect('/board');
    }
    if ($this->action == 'getProposed') {
      $title = $this->request->post['title'];
      $this->board->getProposedRubrics($title);
    }
    if ($this->action == 'removeImage') {
      $id = $this->request->post['image_id'];
      if ($this->user->id != $advert['author_id']) {
        $this->response->json(['code' => 0, 'text' => 'Вы не можете удалить чужое изображение.']);
      } else {
        $this->board->removeImage($id, $advert['id']);
      }
    }
    if ($this->action == 'editPost') {
      $title = $this->request->post['title'];
      $rubric = $this->request->post['rubric'];
      $type = $this->request->post['type'];
      $description = $this->request->post['description'];
      $price = $this->request->post['price'];
      $currency = $this->request->post['currency'];
      $count = $this->request->post['count'];
      $unit = $this->request->post['unit'] ?? '';
      $regions = $this->request->post['regions'];
      $city = $this->request->post['city'];
      $images = $this->request->files['images'];
      $cover = $this->request->post['cover'];
      $agree = $this->request->post['agree'] ?? 0;
      $this->board->editPost($advert['id'], $title, $rubric, $type, $description, $price, $currency, $agree, $count, $unit, $images, $cover, $regions, $city);
    }
    // get all adverts types
    $types        = $this->board->getTypes();
    // adverts type
    $type         = $types[array_keys(array_combine(array_keys($types), array_column($types, 'id')), $advert['type_id'])[0]];
    // get regions list for dropdown menu
    $regions      = $this->board->getRegions();
    // advert region
    $region       = $regions[array_keys(array_combine(array_keys($regions), array_column($regions, 'id')), $advert['obl_id'])[0]];
    // rubrics 
    $rubrics      = $this->board->getRubrics();
    // advert rubric
    $rubric       = $this->board->getRubric($advert['topic_id']);
    // get advert photos
    $photos        = $this->board->getAdvertPhoto($advert['id']);
    // get advert regions 
    $advertRegions = $this->board->getAdvertRegions($advert['id']);
    $this->view
         ->setTitle('Агро доска объявлений Украины на Агротендер. Агро объявления, Аграрная, АПК')
         ->setDescription('На Агро доске объявлений портала Агротендер Вы сможете разместить объявления о купле/продаже интересующей вас с/х продукции.')
         ->setKeywords('Агро доска объявлений, Аграрная, АПК доска, сельхоз продукция, продать, купить пшеницу, кукурузу, ячмень, подсолнечник, зерновые, бобовые, масличные, овощи, фрукты, ягоды, мясо, молоко, яйца, полуфабрикаты, муку, крупы, морепродукты, рыбу, соки, мучные изделия, агро объявления')
         ->setData([ 
           'advert'        => $advert,
           'advertRegions' => $advertRegions,
           'photos'        => $photos,
           'region'        => $region,
           'rubric'        => $rubric,
           'type'          => $type,
           'regions'       => $regions,
           'rubrics'       => $rubrics,
           'rubric'        => $rubric
         ])
         ->display('main/editAdvert');
  }

  public function success() {
    // added advert id
    $advId = $this->session->getOnce('advSuccess');
    if ($advId == null) {
      $this->response->redirect('/u/ads');
    }
    // paid services model
    $paid = $this->model('paid');
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
    // display page
    $this->view
         ->setTitle('Агро доска объявлений Украины на Агротендер. Агро объявления, Аграрная, АПК')
         ->setDescription('На Агро доске объявлений портала Агротендер Вы сможете разместить объявления о купле/продаже интересующей вас с/х продукции.')
         ->setKeywords('Агро доска объявлений, Аграрная, АПК доска, сельхоз продукция, продать, купить пшеницу, кукурузу, ячмень, подсолнечник, зерновые, бобовые, масличные, овощи, фрукты, ягоды, мясо, молоко, яйца, полуфабрикаты, муку, крупы, морепродукты, рыбу, соки, мучные изделия, агро объявления')
         ->setData([
           'advId' => $advId,
           'packs' => $packs
         ])
         ->display('main/addAdvertSuccess');
  }

}