<?php
namespace App\models;

/**
 * 
 */
class Company extends \Core\Model {

  public function addReviewComment($review, $text) {
    $check = $this->db->select("review_comments", "review", ['review' => $review])[0]['review'] ?? null;
    if ($check != null) {
      $this->db->update('review_comments', ['text' => $text], ['review' => $review]);
      $this->response->json(['code' => 1]);
    } else {
      $this->db->query("insert review_comments(review, text) values ($review, '$text')");
      print_r("insert review_comments(review, text) values ($review, '$text')");
      //$this->response->json(['code' => 1]);
    }
  }

  public function updateRate($company, $ip) {
    // First check if this is allowed by ip once more this day
    $num_this_ip = 0;
    $id_this_ip = 0;
  
    $resrate = Array("today" => 0, "wasadd" => false, "total" => 0, "type" => 0, "func" => "comp");
  
    $res = $this->db->query("select * from agt_comp_rate_byday where item_id = $company and metrictype = 0 and dt = curdate() and ip like '$ip'")[0] ?? null;
    if ($res != null) {
      $id_this_ip = $res['id'];
      $num_this_ip = $res['amount'];
    }
  
    $resrate["today"] = $num_this_ip;
  
    if ($num_this_ip == 0) {
      $this->db->insert('agt_comp_rate_byday', ['item_id' => $company, 'metrictype' => 0, 'amount' => 1, 'dt' => 'curdate()', 'add_time' => 'now()', 'ip' => $ip]);
    } else {   
      $this->db->query("update metrictype set amount = amount + 1, add_time = now() where id = $company");
    }

    // Calculate daily item rate
    $daily_rate_id = 0;
    $daily_total = 0;
  
    if( $num_this_ip >= 2 ) {
      return $resrate; //($num_this_ip+1);
    }
    $resrate["wasadd"] = true;
  
    $res = $this->db->query("select * from agt_comp_rate where item_id = $company and metrictype = 0 and dt = curdate()")[0] ?? null;
    
    if ($res != null) {
      $daily_rate_id = $res['id'];
      $daily_total = $res['amount'];
    }
  
    $resrate["total"] = $daily_total;

    if ($daily_rate_id == 0) {
      $this->db->insert('agt_comp_rate', ['item_id' => $company, 'metrictype' => 0, 'dt' => 'curdate()', 'amount' => 1]);
    } else {
      $this->db->query("update agt_comp_rate set amount = amount + 1 where id = $daily_rate_id");
    }
  
    $resrate["today"]++;
    $resrate["total"] += 1;
  
    return $resrate;  //($num_this_ip+1);
  }

  public function getContacts($company, $dep = null) {
    $dep = ($dep != null) ? " && type_id = $dep" : '';
    $arr = [];
    $contacts = $this->db->query("select *, case when type_id = 1 then 'Отдел закупок' when type_id = 2 then 'Отдел продаж' when type_id = 3 then 'Отдел услуг' end as typeName from agt_comp_items_contact where comp_id = $company $dep");
      /*echo '<pre>';
      var_dump($contacts);
      echo '</pre>';die();*/
    foreach ($contacts as $contact) {
      $arr[$contact['typeName']][] = $contact;
    }
    return ($dep != null) ? $contacts : $arr;
  }

    /*  echo '<pre>';
          var_dump($company['contacts']);
          echo '</pre>';die();*/

  public function getItem($company) {
    $company = $this->db->select('agt_comp_items', '*', ['id' => $company])[0] ?? null;
    if ($company != null) {
      $company['contacts'] = $this->db->select('agt_comp_items_contact', '*', ['comp_id' => $company['id']]) ?? null;
      $company['creator'] = $this->db->select('agt_torg_buyer', '*', ['id' => $company['author_id']])[0] ?? null;
      $company['news'] = $this->db->select('agt_comp_news', '*', ['comp_id' => $company['id']]) ?? null;
      $company['vacancy'] = $this->db->select('agt_comp_vacancy', '*', ['comp_id' => $company['id']]) ?? null;
      $company['advertsCount'] = $this->db->query("select count(id) as count from agt_adv_torg_post where author_id = {$company['author_id']} && active = 1 && moderated = 1 && archive = 0")[0]['count'];
      $company['reviews'] = $this->model('user')->getReviews(1, $company['author_id'], $company['id']);
      return $company;
    } else {
      return null;
    }
  }

  public function addReview($companyAuthor, $user, $email, $userName, $company, $good, $bad, $rate, $comment = null) {
    if ($user == 0 or $user == null) {
      $this->response->json(['code' => 0, 'text' => 'Нужно авторизоватся.']);
    }
    if ($companyAuthor == $user) {
      $this->response->json(['code' => 0, 'text' => 'Вы не можете оставить отзыв для своей компании.']);
    }
    if ($good == null or $bad == null) {
      $this->response->json(['code' => 0, 'text' => 'Укажите достоинства и недостатки компании.']);
    }
    $this->db->insert('agt_comp_comment', ['item_id' => $company, 'visible' => 1, 'rate' => $rate, 'add_date' => 'curdate()', 'author' => $userName, 'author_email' => $email, 'ddchk_guid' => '', 'author_id' => $user]);
    $reviewId = $this->db->getLastId();
    $this->db->insert('agt_comp_comment_lang', ['item_id' => $reviewId, 'lang_id' => 1, 'content' => $comment, 'content_plus' => $good, 'content_minus' => $bad]);
    $this->response->json(['code' => 1, 'text' => 'Отзыв добавлен.']); 
  }

  public function getNewsItem($newId, $company) {
    return $this->db->select('agt_comp_news', '*', ['id' => $newId, 'comp_id' => $company])[0] ?? null;
  }

  public function getNews($company) {
    return $this->db->query("select * from agt_comp_news where comp_id = $company order by id desc");
  }

  public function addNews($company, $title, $image, $description) {
    if ($title == null) {
      $this->response->json(['code' => 0, 'text' => 'Введите заголовок.']);
    }
    if ($description == null) {
      $this->response->json(['code' => 0, 'text' => 'Введите описание.']);
    }
    if ($image != null && $image['error'] == 0) {
      $tmp      = $image['tmp_name'];
      $type     = explode('/', $image['type'])[0];
      if ($type != 'image') {
        $this->response->json(['code' => 0, 'text' => 'Только картинка может быть логотипом.']);
      }
      $filename = $this->model('utils')->getHash(12).'.'.pathinfo($image['name'])['extension'];
      move_uploaded_file($tmp, PATH['root'].'/pics/n/'.$filename);
      $filename = 'pics/n/'.$filename;
    } else {
      $filename = '';
    }
    $this->db->insert('agt_comp_news', ['title' => $title, 'pic_src' => $filename, 'content' => $description, 'add_date' => 'now()', 'visible' => 1, 'comp_id' => $company]);
    $this->response->json(['code' => 1, 'text' => '']);
  }

  public function editNews($company, $newsId, $title, $image, $description) {
    if ($title == null) {
      $this->response->json(['code' => 0, 'text' => 'Введите заголовок.']);
    }
    if ($description == null) {
      $this->response->json(['code' => 0, 'text' => 'Введите описание.']);
    }
    $newsItem = $this->getNewsItem($newsId, $company);
    if ($newsItem == null) {
      $this->response->json(['code' => 0, 'text' => 'Новость ещё не создана.']);
    }
    if ($image != null && $image['error'] == 0) {
      $tmp      = $image['tmp_name'];
      $type     = explode('/', $image['type'])[0];
      if ($type != 'image') {
        $this->response->json(['code' => 0, 'text' => 'Только картинка может быть логотипом.']);
      }
      $filename = $this->model('utils')->getHash(12).'.'.pathinfo($image['name'])['extension'];
      move_uploaded_file($tmp, PATH['root'].'/pics/n/'.$filename);
      if ($newsItem['pic_src'] != '') {
        unlink(PATH['root'].'/'.$newsItem['pic_src']);
      }
      $filename = 'pics/n/'.$filename;
    } else {
      $filename = $newsItem['pic_src'];
    }
    $this->db->update('agt_comp_news', ['title' => $title, 'pic_src' => $filename, 'content' => $description], ['id' => $newsId, 'comp_id' => $company]);
    $this->response->json(['code' => 1, 'text' => '']);
  }

  public function removeNews($company, $newsId) {
    $newsItem = $this->getNewsItem($newsId, $company);
    if ($newsItem == null) {
      $this->response->json(['code' => 0, 'text' => 'Новость ещё не создана.']);
    }
    unlink(PATH['root'].'/'.$newsItem['pic_src']);
    $this->db->delete('agt_comp_news', ['id' => $newsId]);
    $this->response->json(['code' => 1, 'text' => '']);
  }

  public function getVacancyItem($vacancyId, $company) {
    return $this->db->query("select * from agt_comp_vacancy where id = $vacancyId and comp_id = $company")[0] ?? null;
  }

  public function getVacancy($company) {
    return $this->db->select('agt_comp_vacancy', '*', ['comp_id' => $company]);
  }

  public function addVacancy($company, $title, $description) {
    if ($title == null) {
      $this->response->json(['code' => 0, 'text' => 'Введите заголовок.']);
    }
    if ($description == null) {
      $this->response->json(['code' => 0, 'text' => 'Введите описание.']);
    }
    $this->db->insert('agt_comp_vacancy', ['title' => $title, 'content' => $description, 'add_date' => 'now()', 'comp_id' => $company, 'visible' => 1]);
    $this->response->json(['code' => 1, 'text' => '']);
  }

  public function editVacancy($company, $vacancyId, $title, $description) {
    if ($title == null) {
      $this->response->json(['code' => 0, 'text' => 'Введите заголовок.']);
    }
    if ($description == null) {
      $this->response->json(['code' => 0, 'text' => 'Введите описание.']);
    }
    $vacancyItem = $this->getVacancyItem($vacancyId, $company);
    if ($vacancyItem == null) {
      $this->response->json(['code' => 0, 'text' => 'Вакансия ещё не создана.']);
    }
    $this->db->update('agt_comp_vacancy', ['title' => $title, 'content' => $description], ['id' => $vacancyId, 'comp_id' => $company]);
    $this->response->json(['code' => 1, 'text' => '']);
  }

  public function removeVacancy($company, $vacancyId) {
    $vacancyItem = $this->getVacancyItem($vacancyId, $company);
    if ($vacancyItem == null) {
      $this->response->json(['code' => 0, 'text' => 'Вакансия ещё не создана.']);
    }
    $this->db->delete('agt_comp_vacancy', ['id' => $vacancyId, 'comp_id' => $company]);
    $this->response->json(['code' => 1, 'text' => '']);
  }

  public function getRubrics($region = null) {

    $rubrics   = $this->db->query("
      select t.menu_group_id as group_id, t.title, count(i2t.id) as count, i2t.topic_id
        from agt_comp_topic as t
        left join agt_comp_item2topic i2t
          on i2t.topic_id = t.id
        ".($region != null ? "left join agt_comp_items i on i.id = i2t.item_id" : "")."
      ".($region != null ? "where i.obl_id = $region" : "")."
        group by t.id
        order by t.menu_group_id, t.sort_num, t.title");
    return $rubrics;
  }

  public function getRubricsChunk($region = null) {
      var_dump($region);
    $rubrics = $this->getRubrics($region);
    $result  = [];
    foreach ($rubrics as $r) {
      $result[$r['group_id']][] = $r;
    }
    foreach ($result as $key => $value) {
      $result[$key] = array_chunk($value, 7);
    }
    return $result;
  }

  public function getRubricsGroup() {
    $groups = $this->db->query("
      select distinct g.id, g.title, g.sort_num
        from agt_comp_topic t
        left join agt_comp_tgroups g
          on t.menu_group_id = g.id
      where t.parent_id = 0
        order by g.sort_num, g.title");
    return $groups;
  }

    public function getRubric($id) {
    $rubric = $this->db->query("select * from agt_comp_topic where id = $id")[0] ?? null;
    return $rubric;
  }



  public function getRegion($region) {
    $region = $this->db->query("
      select * from regions where ".(is_int($region) ? "id = '$region' or " : "")."name = '$region' or translit = '$region'
    ")[0] ?? [
      "name"     => "Украина",
      "r"        => "Украине",
      "translit" => "ukraine",
      "id"       => null
    ];
    return $region;
  }

  public function getRegions($rubric = null) {
    $regions = $this->db->query("
      select tr.*, count(i.id) as count
        from regions tr
        left join agt_comp_items i
          on i.obl_id = tr.id
        ".($rubric != null ? "left join agt_comp_item2topic i2t on i2t.item_id = i.id" : "")."
      ".($rubric != null ? "  where i2t.topic_id = $rubric" : "")."
        group by tr.id");
    return $regions;
  }

  public function getCompanies($count, $page = 1, $region = null, $rubric = null, $query = null) {
    $rubric = ($rubric != null) ? "inner join agt_comp_item2topic i2t on i2t.item_id = i.id && i2t.topic_id = $rubric" : "";
    $region = ($region != null) ? "&& i.obl_id = $region" : "";
    $query  = ($query != null) ?  "&& (i.title like '%$query%' or i.content like '%$query%')" : "";

    $totalCount =  $this->db->query("
      select count(i.id) as count
        from agt_comp_items i
        $rubric
      where i.visible = 1 $region $query")[0]['count'] ?? 0;


    // find the total number of pages
    $totalPages = intval(($totalCount - 1) / $count) + 1;
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


    $companies = $this->db->query("
      select i.id, i.author_id, i.trader_premium as top, i.obl_id, i.logo_file, i.short, i.visible, date_format(i.add_date, '%b. %Y') as add_date, i.title, i.trader_price_avail, i.trader_price_visible, b.phone, b.phone2, b.phone3
        from agt_comp_items i
        $rubric
        inner join agt_torg_buyer b
          on b.id = i.author_id
      where i.visible = 1 $region $query
        group by i.id
        order by top desc, i.rate_formula desc
        limit $start, $count");
    
    $i = 0;
    foreach ($companies as $company) {
      $companies[$i]['activities'] = $this->db->query("
        select group_concat(t.title separator ', ') as activities
          from agt_comp_topic t
          left join agt_comp_item2topic i2t
            on t.id = i2t.topic_id
        where i2t.item_id = ".$company['id']
      )[0]['activities'];
      $companies[$i]['purchases']  = $this->db->query("select count(id) as count from agt_adv_torg_post where active = 1 && archive = 0 && moderated = 1 && author_id = ".$company['author_id']." && type_id = 1")[0]['count']; 
      $companies[$i]['sales']      = $this->db->query("select count(id) as count from agt_adv_torg_post where active = 1 && archive = 0 && moderated = 1 && author_id = ".$company['author_id']." && type_id = 2")[0]['count'];
      $companies[$i]['services']   = $this->db->query("select count(id) as count from agt_adv_torg_post where active = 1 && archive = 0 && moderated = 1 && author_id = ".$company['author_id']." && type_id = 3")[0]['count'];
      $i++;
    }

    return ['data' => $companies, 'totalPages' => $totalPages ?? 1, 'page' => $page, 'totalCount' => $totalCount];
  }
}