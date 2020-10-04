<?php
namespace App\models;

/**
 * 
 */
class Info extends \Core\Model {

  public function viewModal($id, $user) {
    $this->db->insert('agt_popup_dlgs_views', ['user_id' => $user, 'item_id' => $id, 'add_date' => 'now()']);
  }

  public function getModals($user) {
    $modal = $this->db->query("
      select d.id, d.urlgo, dl.btntext, dl.title, dl.content
        from agt_popup_dlgs d
        inner join agt_popup_dlgs_lang dl
          on dl.item_id = d.id
        left join agt_popup_dlgs_views dv
          on dv.item_id = d.id && dv.user_id = $user
      where dv.id is null && d.end_date > now() && d.first_page = 1
      order by d.id asc")[0] ?? null;
    return $modal;
  }

  public function getNews($count, $page = 1) {
    $totalCount = $this->db->query("
      select count(n.id) as count
        from agt_news n
        inner join agt_news_lang nl
          on n.id = nl.news_id")[0]['count'] ?? 0;
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
    $news = $this->db->query("
      select n.*, nl.title, nl.content
        from agt_news n
        inner join agt_news_lang nl
          on n.id = nl.news_id
      order by n.dtime desc
      limit $start, $count");
    return ['news' => $news, 'totalPages' => $totalPages ?? 1];
  }

  public function getNewsItem($month, $year, $url) {
    return $this->db->query("
      select n.*, nl.title, nl.content
        from agt_news n
        inner join agt_news_lang nl
          on n.id = nl.news_id
      where n.url = '$url' && date_format(n.dtime, '%c') = $month && date_format(n.dtime, '%y') = $year")[0] ?? null;
  }

  public function getFaq($count, $page = 1, $rubric) {
    $rubric = ($rubric != null) ? "where f.group_id = $rubric" : "";
    $totalCount = $this->db->query("
      select count(f.id) as count
        from agt_faq f
        inner join agt_faq_lang fl
          on f.id = fl.item_id
       $rubric")[0]['count'] ?? 0;
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
    $faq = $this->db->query("
      select f.*, fl.title, fl.content
        from agt_faq f
        inner join agt_faq_lang fl
          on f.id = fl.item_id
      $rubric
      order by f.add_date desc
      limit $start, $count");
    return ['faq' => $faq, 'totalPages' => $totalPages ?? 1];
  }

  public function getFaqItem($url) {
    return $this->db->query("
      select f.*, fl.title, fl.content
        from agt_faq f
        inner join agt_faq_lang fl
          on f.id = fl.item_id
      where f.url = '$url'")[0] ?? null;
  }
  
}