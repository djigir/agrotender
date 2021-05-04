<?php
namespace App\models;

/**
 * 
 */
class Elev extends \Core\Model {

  public function getItem($url) {
    $elev = $this->db->query("
      select e.id, e.phone, e.email, el.name, el.addr, el.orgname, el.orgaddr, el.holdcond, 
      el.descr_podr, el.descr_qual, el.director, r.name as region, r.parental as region_parental, r.translit as region_translit, rl.name as ray
        from agt_torg_elevator e
        inner join agt_torg_elevator_lang el
          on el.item_id = e.id
        inner join agt_regions r
          on r.id = e.obl_id
        inner join agt_rayon_lang rl
          on rl.ray_id = e.ray_id
      where e.elev_url = '$url'")[0] ?? null;
    return $elev;
  }

  public function getList($region = null, $start = 0) {
    // region condition
    $region = ($region != null) ? "where e.obl_id = {$region['id']}" : "";
    // get list
    $list = $this->db->query("
      select e.id, e.elev_url as url, e.phone, e.email, el.name, el.addr, el.orgname, el.orgaddr, el.holdcond, el.descr_podr, el.descr_qual, el.director, r.name as region, r.parental as region_parental, r.translit as region_translit, rl.name as ray
        from agt_torg_elevator e
        inner join agt_torg_elevator_lang el
          on el.item_id = e.id
        inner join agt_regions r
          on r.id = e.obl_id
        inner join agt_rayon_lang rl
          on rl.ray_id = e.ray_id
      $region
      order by id desc
      limit $start, 24");
    return ['elev' => $list, 'more' => count($list) > 0 ];
  }

  public function getRegions() {
    $regions = $this->db->query("select * from agt_regions group by id");
    return $regions;
  }

}