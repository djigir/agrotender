<?php
namespace App\models;

class Api extends \Core\Model {

  protected $token = 't7FFxBKkLl0EDkDpvAEIMO5a78uIIGjMW';

  public function __construct() {
    $this->access = $this->session->get('access') ?? 0;
    $this->method = $this->request->get['method'] ?? null;
  }

  public function getAccess($token) {
    $access = ($token == $this->token) ? 1 : 0;
    $this->session->set('access', $access);
    $this->access = $access;
    return $access;
  }

  public function getTradersUsers($trader_id, $type = 1) {
    if ( !$trader_id ) return [];
    if ( !$traders = $this->db->query("SELECT agt_comp_items.author_id,telegram,viber FROM agt_torg_buyer
        LEFT JOIN agt_comp_items ON agt_comp_items.author_id=agt_torg_buyer.id
        where agt_comp_items.id=".intval($trader_id)." limit 1") ) return ['not found'];
    $trader = array_shift($traders);
    if ( $type == 1 ) return explode("\r\n", $trader['telegram']);
    if ( $type == 2 ) return explode("\r\n", $trader['viber']);
    return $trader;
  }

  public function getTraders($region = null, $port = null, $rubric = null, $onlyPorts = false, $currency = null, $today = null) {

    $currencySql     = ($currency !== null) ? "&& tpr.curtype = $currency" : "";
    $regionSql       = ($region != null) ? "&& tpl.obl_id = $region" : "";
    $portSql         = ($port != null) ? "&& tpl.port_id = $port" : "";
    $onlyPortsSql    = ($onlyPorts != false) ? "&& tpl.port_id != 0" : "";
    $placeSql        = ($region != null || $port != null || $onlyPorts != null) ? "inner join agt_traders_places tpl on tpr.place_id = tpl.id $regionSql $portSql $onlyPortsSql" : "";
    $rubricSql       = ($rubric != null) ? "&& tpr.cult_id = $rubric" : "";
    $date_sql         = ($today != null) ? "&& date(tpr.change_date) = curdate()" : "";
    // get traders list
    $traders = $this->db->query("
      select ci.id, ci.title, ci.logo_file as logo, ci.author_id, ci.trader_premium as top
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '0' $currencySql $rubricSql
        $placeSql
      where ci.trader_price_avail = 1 && ci.trader_price_visible = 1 && ci.visible = 1 $date_sql
      group by ci.id
      order by ci.trader_sort, ci.rate_formula desc, ci.title");
    return $traders;
  }

  public function getTradersPrices($region = null, $port = null, $rubric = null, $onlyPorts = false, $currency = null, $today = null) {
    $currencySql     = ($currency !== null) ? "&& tpr.curtype = $currency" : "";
    $regionSql       = ($region != null) ? "&& tpl.obl_id = $region" : "";
    $portSql         = ($port != null) ? ($port == 'all' ? "&& tpl.port_id>0" : "&& tpl.port_id = $port") : "";
    $onlyPortsSql    = ($onlyPorts != false) ? "&& tpl.port_id != 0" : "";
    $placeSql        = ($region != null || $port != null || $onlyPorts != null) ? "inner join agt_traders_places tpl on tpr.place_id = tpl.id $regionSql $portSql $onlyPortsSql" : "";
    $rubricSql       = ($rubric != null) ? "&& tpr.cult_id = $rubric" : "";
    switch ($today) {
      case "1":
        // за сегодня
        $date_sql = "&& date(tpr.change_date) = curdate()";
        break;
        // за вчера
      case "2":
        $date_sql = "&& date(tpr.change_date) = curdate() - interval 1 day";
        break;
      case "3":
        // за последний час
        $date_sql = "&& (tpr.change_date < now() && tpr.change_date > date_sub(now(), interval 2 hour))";
        break;
      default:
        $date_sql = '';
    }
//if ( $_SERVER['REMOTE_ADDR'] == '37.1.205.103' ) print_r($portSql);
    // get traders list
    $traders = $this->db->query("SELECT ci.id, ci.title, ci.logo_file as logo, ci.author_id, ci.trader_premium AS top
        FROM agt_comp_items ci
        INNER JOIN agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '0' $currencySql $rubricSql
        $placeSql
      WHERE ci.trader_price_avail = 1 && ci.trader_price_visible = 1 && ci.visible = 1 $date_sql
      GROUP BY ci.id
      ORDER BY ci.trader_sort, ci.rate_formula desc, ci.title");

    foreach ($traders as $key => $value)
    {
      $query = "
          SELECT tp_l.name as rubric, tpr.id as rubric_id, round(tpr.costval) as price, tpr.place_id, tpl.place as place_name, pl.portname, tpr.curtype as currency, r.name as region, r.id as region_id,
            tpr.change_date, ifnull(pl.id, null) as port_id,
            round(tpr.costval_old) AS old_price, round(tpr.costval - tpr.costval_old) as price_diff,
            IF(tpr.costval_old=0 OR tpr.costval=tpr.costval_old, 'no', IF(tpr.costval<tpr.costval_old, 'down', 'up')) AS change_price
            FROM agt_traders_prices tpr
            inner join agt_traders_products_lang tp_l ON tp_l.id = tpr.cult_id
            inner join agt_traders_places tpl ON tpr.place_id = tpl.id $regionSql $portSql $onlyPortsSql
            left join agt_traders_ports_lang pl ON pl.port_id = tpl.port_id
            left join regions r ON r.id = tpl.obl_id
          where tpr.buyer_id = {$traders[$key]['author_id']} && tpl.type_id != 1 && tpr.acttype = 0 $rubricSql $currencySql $date_sql
          order by tpr.change_date";
/*
      $query = "
          select tp_l.name as rubric, tpr.id as rubric_id, round(tpr.costval) as price, round(tpr.costval - tpa.costval) as price_diff, round(tpa.costval) as old_price, tpr.place_id, tpl.place as place_name, pl.portname, tpr.curtype as currency, r.name as region, r.id as region_id,
            case
              when round(tpr.costval - tpa.costval) < 0 then 'down'
              when round(tpr.costval - tpa.costval) > 0 then 'up'
              else 'no'
            end as change_price, tpr.change_date, ifnull(pl.id, null) as port_id
            from agt_traders_prices tpr
            left join agt_traders_prices_arc tpa
              on tpa.buyer_id = tpr.buyer_id
              && tpa.cult_id  = tpr.cult_id
              && tpa.place_id = tpr.place_id
              && tpa.curtype  = tpr.curtype
              && tpa.dt       = date(tpr.dt) - interval 1 day
            inner join agt_traders_products_lang tp_l ON tp_l.id = tpr.cult_id
            inner join agt_traders_places tpl ON tpr.place_id = tpl.id $regionSql $portSql $onlyPortsSql
            left join agt_traders_ports_lang pl ON pl.port_id = tpl.port_id
            left join regions r ON r.id = tpl.obl_id
          where tpr.buyer_id = {$traders[$key]['author_id']} && tpl.type_id != 1 && tpr.acttype = 0 $rubricSql $currencySql
          order by tpr.change_date
        ";
*/
      $traders[$key]['company_url'] = "https://agrotender.com.ua/kompanii/comp-{$value['id']}";
      $traders[$key]['prices'] = $this->db->query($query);
    }

    return $traders;
  }

  public function getRegions() {
    return $this->db->query("select * from regions");
  }
  public function getRubrics() {
    return $this->db->query("select tp.id, tpl.name, tp.url as translit from agt_traders_products tp inner join agt_traders_products_lang tpl on tp.id = tpl.item_id where tp.acttype = 0");
  }
  public function getPorts() {
    return $this->db->query("select tp.id, tpl.portname as name, tp.url as translit, tp.obl_id as region from agt_traders_ports tp inner join agt_traders_ports_lang tpl on tp.id = tpl.id where tp.active = 1");
  }
}
