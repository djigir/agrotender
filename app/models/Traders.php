<?php
namespace App\models;
/**
 *
 */
class Traders extends \Core\Model {

  public $forwardPriceType = 3;
  public $countDaysExpiredDiff = '-7 day'; // количество дней для отображения разниц diff изменения цен
  // months
  public $daysCount = [10, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  public $monthNames = ["", "Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"];

  public function saveColPrices($user, $rubric, $place_type, $acttype, $currency, $price, $dt = false) {
    $price = ($price[0] == '-') ? '- '.substr($price, 1) : '+ '.$price;
    $where_dt = $dt ? " && tp.dt = '$dt'" : '';
    $this->db->query("
      update agt_traders_prices as tp
        inner join agt_traders_places tpl
          on tp.place_id = tpl.id
      set tp.costval = tp.costval {$price}, tp.costval_old = tp.costval, tp.change_date = now()
      where tp.acttype = $acttype && tpl.type_id = $place_type && tp.cult_id = $rubric && tp.buyer_id = $user && tp.curtype = $currency $where_dt");
    $this->response->json(['code' => 1]);
  }

  public function getAvgPrices($rubric, $region, $currency, $type, $typeName, $dt = false) {
    $where_dt = $dt ? " && tp.dt = '$dt'" : '';
    $prices = $this->db->query("
      select ifnull(round(min(tp.costval)), 0) as minprice, ifnull(round(max(tp.costval)), 0) as maxprice
        from agt_traders_prices tp
        inner join agt_traders_places tpl
          on tpl.id = tp.place_id && tpl.obl_id = $region
        inner join agt_comp_items ci
          on ci.author_id = tp.buyer_id
        where ci.trader_price{$typeName}_avail = 1 && ci.trader_price{$typeName}_visible = 1 && tp.cult_id = $rubric && tp.curtype = $currency && tp.acttype = $type && tp.active = 1 && ci.visible = 1 $where_dt")[0] ?? null;
    return $prices;
  }

  public function getFeed($type) {
    $sell = ($type == $this->forwardPriceType ? '_forward' : ($type == 1 ? '_sell' : ''));
    $feed = $this->db->query("
      select ci.title as company, ci.id as company_id, group_concat(distinct concat(tpl.name, ':', ifnull(f.change_price, 3)) order by f.change_price separator ', ') as rubrics, group_concat(distinct ifnull(f.change_price, 3) separator ', ') as change_price, date_format(f.change_date, '%H:%i') as change_time
        from agt_traders_feed f
        inner join agt_traders_products_lang tpl
          on tpl.id = f.rubric
        inner join agt_traders_places tp
          on tp.id = f.place
        inner join agt_comp_items ci
          on ci.author_id = f.user
      where tp.acttype = $type && date(f.change_date) = curdate() && ci.trader_price{$sell}_avail = 1 && ci.trader_price{$sell}_visible = 1 && tp.type_id != 1 && ci.visible = 1
      group by f.user
      order by f.change_date desc");

    foreach ($feed as $key => $value) {
      $feed[$key]['onchange'] = 'Подтвердил цены';
      $feed[$key]['onchange_class'] = 'approve';
      foreach (explode(', ', $value['rubrics']) as $key2 => $value2) {
        $explode = explode(':', $value2);
        if ($explode[1] == '2') {
          $explode[1] = 4;
        }
        if ($explode[1] != '4') {
          $feed[$key]['onchange'] = 'Изменил цены';
          $feed[$key]['onchange_class'] = 'change';
        }
        if (!isset($feed[$key]['r'][$explode[0]]['change'])) {
          $feed[$key]['r'][$explode[0]]['change'] = [];
        }
        // array_push($feed[$key]['r'][$explode[0]]['change'], $explode[1]);
        $feed[$key]['r'][$explode[0]]['change'][] = $explode[1];
      }
    }
    return $feed;
  }

  public function getRandomTraders() {
    return $this->db->query("
      select ci.id, ci.logo_file
        from agt_comp_items ci
      where ci.trader_price_avail = 1 && ci.trader_price_visible = 1 && ci.visible = 1
      order by rand()
      limit 10");
  }

  public function sendTraderForm($company, $name, $phone, $email) {
    $text = "Компания: $company<br>Имя: $name<br>Телефон: $phone<br>Email: $email";
    $this->model('utils')->mail('trader@agrotender.com.ua', 'Новый трейдер!', $text);
    $this->response->json(['code' => 1, 'text' => 'Заявка отправлена.']);
  }

  public function sendProposed($user, $company, $rubric, $name, $region, $phone, $price, $currency, $email, $bulk, $description, $companies) {
    $this->db->insert('agt_messenger', ['from_id' => $user, 'to_id' => 0, 'cult_id' => $rubric, 'obl_id' => $region, 'company' => $company, 'fio' => $name, 'phone' => $phone, 'email' => $email, 'cost' => $price.$currency, 'amount' => $bulk, 'add_date' => 'now()', 'comment' => $description]);
    $messageId = $this->db->getLastId();
    foreach ($companies as $comp) {
      $this->db->insert('agt_messenger_p2p', ['item_id' => $messageId, 'from_id' => $user, 'to_id' => $comp, 'add_date' => 'now()', 'view_date' => '']);
    }
    $this->response->json(['code' => 1, 'text' => 'Предложение отправлено.']);
  }
  public function getTradersByRubric($rubric) {
    $list = $this->db->query("
      select distinct ci.id, ci.title
        from agt_comp_items ci
        inner join agt_traders_prices tp
          on tp.buyer_id = ci.author_id && tp.acttype = '0'
        inner join agt_traders_places tpl
          on tpl.id = tp.place_id
      where tp.cult_id = $rubric && ci.trader_price_visible = 1 && ci.trader_price_avail = 1 && ci.visible = 1");
    $this->response->json(['code' => 1, 'list' => $list]);
  }

  public function getContact($id) {
    $contact = $this->db->select('agt_traders_contacts', '*', ['id' => $id])[0] ?? null;
    if ($contact == null) {
      $this->response->json(['code' => 0, 'text' => 'В Вашем списке нет такого контакта.']);
    } else {
      $this->response->json(['code' => 1, 'text' => '', 'contact' => $contact]);
    }
  }

  public function getContacts($company, $onlyFull = false) {
    $places = $this->db->select('agt_traders_contacts_regions', '*', ['comp_id' => $company]);
    foreach ($places as $key => $place) {
      $contacts = $this->db->select('agt_traders_contacts', '*', ['region_id' => $place['id']]) ?? null;
      if ($onlyFull == true) {
        if ($contacts == null) {
          unset($places[$key]);
        } else {
          $places[$key]['contacts'] = $contacts;
        }
      } else {
        $places[$key]['contacts'] = $contacts;
      }
    }
    return $places;
  }

  public function removeContact($user, $contact, $place) {
    $existContact = $this->db->select('agt_traders_contacts', '*', ['id' => $contact, 'buyer_id' => $user])[0] ?? null;
    if ($existContact != null) {
      $this->db->delete('agt_traders_contacts', ['id' => $contact, 'buyer_id' => $user]);
      $this->db->query("update traders_contacts set sort_num = sort_num - 1 where buyer_id = $user and region_id = $place and sort_num = {$existContact['sort_num']}");
      $this->response->json(['code' => 1]);
    } else {
      $this->response->json(['code' => 0, 'text' => 'В Вашем списке нет такого контакта.']);
    }
  }

  public function editContact($user, $contact, $post, $name, $phone, $email) {
    $existContact = $this->db->select('agt_traders_contacts', '*', ['id' => $contact, 'buyer_id' => $user])[0] ?? null;
    if ($existContact != null) {
      $this->db->update('agt_traders_contacts', ['email' => $email, 'dolg' => $post, 'fio' => $name, 'phone' => $phone], ['id' => $contact, 'buyer_id' => $user]);
      $this->response->json(['code' => 1]);
    } else {
      $this->response->json(['code' => 0, 'text' => 'В Вашем списке нет такого контакта.']);
    }
  }

  public function addContact($user, $place, $post, $name, $phone, $email) {
    $maxSort = $this->db->select('agt_traders_contacts', ['max(sort_num) as maxsort'], ['buyer_id' => $user, 'region_id' => $place])[0]['maxsort'] ?? 0;
    $this->db->insert('agt_traders_contacts', ['region_id' => $place, 'buyer_id' => $user, 'dolg' => $post, 'fio' => $name, 'phone' => $phone, 'fax' => '', 'email' => $email, 'sort_num' => $maxSort + 1]);
    $this->response->json(['code' => 1]);
  }

  public function editContactPlace($placeId, $company, $place) {
    $existPlace = $this->db->select('agt_traders_contacts_regions', '*', ['id' => $placeId, 'comp_id' => $company])[0] ?? null;
    if ($existPlace != null) {
      $this->db->update('agt_traders_contacts_regions', ['name' => $place], ['id' => $placeId, 'comp_id' => $company]);
      $this->response->json(['code' => 1]);
    } else {
      $this->response->json(['code' => 0, 'text' => 'В Вашем списке нет такого места.']);
    }
  }

  public function removeContactPlace($user, $company, $placeId) {
    $existPlace = $this->db->select('agt_traders_contacts_regions', '*', ['id' => $placeId, 'buyer_id' => $user, 'comp_id' => $company])[0] ?? null;
    if ($existPlace != null) {
      $this->db->delete('agt_traders_contacts', ['region_id' => $placeId, 'buyer_id' => $user]);
      $this->db->delete('agt_traders_contacts_regions', ['id' => $placeId, 'buyer_id' => $user]);
      $this->db->query("update agt_traders_contacts_regions set sort_num = sort_num - 1 where buyer_id = $user and sort_num = {$existPlace['sort_num']}");
    }
    $this->response->json(['code' => 1]);
  }

  public function addContactPlace($user, $company, $place) {
    if (mb_strlen($place) < 1) {
      $this->response->json(['code' => 0, 'text' => 'Необходимо указать место.']);
    }
    $maxSort = $this->db->select('agt_traders_contacts_regions', ['max(sort_num) as maxsort'], ['buyer_id' => $user])[0]['maxsort'] ?? 0;
    $this->db->insert('agt_traders_contacts_regions', ['comp_id' => $company, 'buyer_id' => $user, 'sort_num' => ($maxSort + 1), 'name' => $place]);
    $this->response->json(['code' => 1, 'text' => '']);
  }

  public function setVisible($company, $typeName, $visible) {
    $this->db->update('agt_comp_items', ['trader_price'.$typeName.'_visible' => $visible], ['id' => $company]);
    $this->response->json(['code' => 1, 'text' => '']);
  }

  public function savePrice($user, $type, $currency, $place, $rubric, $price, $comment) {
    if ($comment == null) {
      $comment = '';
    }
    if ($price == null || $price == '0') {
      $this->db->delete('agt_traders_prices', ['buyer_id' => $user, 'cult_id' => $rubric, 'place_id' => $place, 'curtype' => $currency, 'acttype' => $type]);
    } else {
      $existPrice = $this->db->select('agt_traders_prices', ['id','costval','costval_old','dt','comment'], ['buyer_id' => $user, 'cult_id' => $rubric, 'place_id' => $place, 'curtype' => $currency, 'acttype' => $type])[0] ?? null;
      $change = $existPrice === null ? 3 : ($existPrice['costval'] == $price ? 4 : ($existPrice['costval'] > $price ? 1 : "0"));
      if ($existPrice == null) {
        $this->db->insert('agt_traders_prices', ['buyer_id' => $user, 'cult_id' => $rubric, 'place_id' => $place, 'curtype' => $currency, 'acttype' => $type, 'active' => 1, 'costval' => $price, 'costval_old' => $price, 'comment' => $comment, 'dt' => 'curdate()', 'change_date' => 'now()', 'add_date' => 'now()']);
        $this->db->insert('agt_traders_feed', ['rubric' => $rubric, 'place' => $place, 'change_price' => $change, 'user' => $user]);
      // обновляем цены в случае первого сохранения цен за сутки или изменения цены
      } elseif ( $existPrice['dt'] != date('Y-m-d') || $existPrice['costval'] != $price ) {
        $this->db->update('agt_traders_prices', ['active' => 1, 'costval' => $price, 'costval_old' => $existPrice['costval'], 'comment' => $comment, 'dt' => 'curdate()', 'change_date' => 'now()'], ['id' => $existPrice['id']]);

        $existFeed = $this->db->query("select id,change_price from agt_traders_feed where rubric = $rubric && place = $place && date(change_date) = curdate()")[0] ?? null;
        if ($existFeed == null) {
          $this->db->insert('agt_traders_feed', ['rubric' => $rubric, 'place' => $place, 'change_price' => $change, 'user' => $user]);
        } elseif ( $existFeed['change_price'] != $change ) {
          $this->db->update('agt_traders_feed', ['change_price' => $change], ['id' => $existFeed['id']]);
        }
        $archId = $this->db->query("select id from agt_traders_prices_arc where buyer_id = $user && cult_id = $rubric && place_id = $place && curtype = $currency && acttype = $type && dt = curdate()")[0]['id'] ?? null;
        if ($archId == null) {
          $this->db->insert('agt_traders_prices_arc', ['buyer_id' => $user, 'cult_id' => $rubric, 'place_id' => $place, 'curtype' => $currency, 'acttype' => $type, 'active' => 1, 'costval' => $price, 'dt' => 'curdate()', 'add_date' => 'now()']);
        } else {
          $this->db->update('agt_traders_prices_arc', ['active' => 1, 'costval' => $price, 'dt' => 'curdate()'], ['id' => $archId]);
        }
      // обновляем только коментарий, если цена не изменилась
      } elseif ( $existPrice['comment'] != $comment ) {
        $this->db->update('agt_traders_prices', ['active' => 1, 'comment' => $comment], ['id' => $existPrice['id']]);
      }
    }
  }

  public function savePriceForward($user, $type, $currency, $place, $rubric, $price, $comment, $date) {
    if ($price == null || $price == '0') {
      $this->db->delete('agt_traders_prices', ['buyer_id' => $user, 'cult_id' => $rubric, 'place_id' => $place, 'curtype' => $currency, 'acttype' => $type, 'dt' => $date]);
    } else {
      $existPrice = $this->db->select('agt_traders_prices', ['id','costval','costval_old','comment','change_date'], ['buyer_id' => $user, 'cult_id' => $rubric, 'place_id' => $place, 'curtype' => $currency, 'acttype' => $type, 'dt' => $date])[0] ?? null;
      $change = $existPrice === null ? 3 : ($existPrice['costval'] == $price ? 4 : ($existPrice['costval'] > $price ? 1 : '0'));
      if ($existPrice == null) {
        $this->db->insert('agt_traders_prices', ['buyer_id' => $user, 'cult_id' => $rubric, 'place_id' => $place, 'curtype' => $currency, 'acttype' => $type, 'active' => 1, 'costval' => $price, 'costval_old' => $price, 'comment' => $comment ?: '', 'dt' => $date, 'change_date' => 'now()', 'add_date' => 'now()']);
        $this->db->insert('agt_traders_feed', ['rubric' => $rubric, 'place' => $place, 'change_price' => $change, 'user' => $user]);
      // обновляем цены в случае первого сохранения цен за сутки или изменения цены
      } elseif ( strtotime($existPrice['change_date']) < strtotime(date('Y-m-d')) || $existPrice['costval'] != $price ) {
        $this->db->update('agt_traders_prices', ['active' => 1, 'costval' => $price, 'costval_old' => $existPrice['costval'], 'comment' => $comment ?: '', 'dt' => $date, 'change_date' => 'now()'], ['id' => $existPrice['id']]);

        $existFeed = $this->db->query("select id,change_price from agt_traders_feed where rubric = $rubric && place = $place && date(change_date) = curdate()")[0] ?? null;
        if ($existFeed == null) {
          $this->db->insert('agt_traders_feed', ['rubric' => $rubric, 'place' => $place, 'change_price' => $change, 'user' => $user]);
        } elseif ( $existFeed['change_price'] != $change ) {
          $this->db->update('agt_traders_feed', ['change_price' => $change], ['id' => $existFeed['id']]);
        }
      // обновляем только коментарий, если цена не изменилась
      } elseif ( $existPrice['comment'] != $comment ) {
        $this->db->update('agt_traders_prices', ['active' => 1, 'comment' => $comment ?: ''], ['id' => $existPrice['id']]);
      }
    }
  }

  public function updatePricePlace($user, $placeId, $place) {
    $this->db->update('agt_traders_places', ['place' => $place], ['buyer_id' => $user, 'id' => $placeId]);
    $this->response->json(['code' => 1, 'text' => 'Место приёмки обновлено.']);
  }

  public function deletePricePlace($user, $placeId) {
    $place = $this->db->select('agt_traders_places', 'id', ['buyer_id' => $user, 'id' => $placeId])[0]['id'] ?? null;
    if ($place == null) {
      $this->response->json(['code' => 0, 'text' => 'Вы ещё не добавили такое место.']);
    }
    $this->db->delete('agt_traders_prices', ['buyer_id' => $user, 'place_id' => $placeId]);
    $this->db->delete('agt_traders_prices_arc', ['buyer_id' => $user, 'place_id' => $placeId]);
    $this->db->delete('agt_traders_places', ['id' => $placeId]);
    $this->response->json(['code' => 1, 'text' => 'Место приёмки удалено.']);
  }

  public function addPricePlace($user, $region, $place, $type) {
    $existPlace = $this->db->query("select id from agt_traders_places where buyer_id = $user and acttype = $type and obl_id = $region and type_id = 0 and place like '$place'")[0] ?? null;
    if ($existPlace != null) {
      $this->response->json(['code' => 0, 'text' => 'Вы уже добавили данное место.']);
    }
    $this->db->insert('agt_traders_places', ['buyer_id' => $user, 'acttype' => $type, 'obl_id' => $region, 'type_id' => 0, 'place' => $place]);
    $this->response->json(['code' => 1, 'text' => 'Место приёмки добавлено.']);
  }

  public function deletePriceRubric($user, $rubric, $type) {
    $existRubric = $this->db->select('agt_traders_products2buyer', 'id', ['buyer_id' => $user, 'cult_id' => $rubric, 'acttype' => $type])[0]['id'] ?? null;
    if ($existRubric != null) {
      $this->db->delete('agt_traders_prices', ['buyer_id' => $user, 'cult_id' => $rubric, 'acttype' => $type]);
      $this->db->delete('agt_traders_prices_arc', ['buyer_id' => $user, 'cult_id' => $rubric, 'acttype' => $type]);
      $this->db->delete('agt_traders_products2buyer', ['id' => $existRubric]);
      $this->response->json(['code' => 1, 'text' => 'Рубрика удалена.']);
    } else {
      $this->response->json(['code' => 0, 'text' => 'Вы ещё не добавили данную рубрику.']);
    }
  }

  public function addPriceRubric($user, $rubric, $type, $placeType) {
    $existRubric = $this->db->select('agt_traders_products2buyer', 'id', ['buyer_id' => $user, 'cult_id' => $rubric, 'type_id' => $placeType, 'acttype' => $type])[0]['id'] ?? null;
    if ($existRubric != null) {
      $this->response->json(['code' => 0, 'text' => 'Данная рубрика уже добавлена.']);
    }
    $this->db->insert('agt_traders_products2buyer', ['buyer_id' => $user, 'cult_id' => $rubric, 'type_id' => $placeType, 'acttype' => $type]);
    $this->response->json(['code' => 1, 'text' => 'Рубрика добавлена']);
  }

  public function getPlaces($user, $placeType, $type) {

    $places = $this->db->query("
      select tp.*, tpl.portname, r.name as region, r.id as region_id
        from agt_traders_places tp
        left join agt_traders_ports tpo
          on tpo.id = tp.port_id
        left join agt_traders_ports_lang tpl
          on tpl.port_id = tpo.id
        left join regions r
          on r.id = tp.obl_id
      where tp.buyer_id = $user and tp.acttype = $type and tp.type_id = $placeType
      order by tp.obl_id asc, tpl.portname asc");

    return $places;
  }

  public function getAvailRubrics($user, $placeType, $type, $priceType = false) {
    $priceType = $priceType ?: $type;
    $arr     = [];
    $groups  = $this->getRubricsGroup($type);
    $rubrics = $this->db->query("
      select distinct tp.id, tp.url as translit, tp.group_id, tpl.name
        from agt_traders_products tp
        inner join agt_traders_product_groups pg
          on tp.group_id = pg.id
        inner join agt_traders_product_groups_lang pgl
          on pg.id = pgl.item_id
        inner join agt_traders_products_lang tpl
          on tpl.item_id = tp.id
      where tp.id not in (select cult_id from agt_traders_products2buyer where buyer_id = $user && acttype = $priceType && type_id = $placeType) && tp.acttype = $type");
    foreach ($groups as $group) {
      foreach ($rubrics as $rubric) {
        if ($rubric['group_id'] == $group['id']) {
          $arr[$group['name']][] = $rubric;
        }
      }
    }
    return $arr;
  }

  public function getUserPricesRubrics($user, $placeType, $type) {

    $rubrics = $this->db->query("
      select distinct c2b.sort_ind, c2b.id as b2id, tp.*, tpl.name
        from agt_traders_products2buyer c2b
        inner join agt_traders_products tp on c2b.cult_id=tp.id
        inner join agt_traders_products_lang tpl on tp.id=tpl.item_id
      where c2b.buyer_id = $user and c2b.acttype = $type and c2b.type_id = $placeType
      order by tpl.name asc");

    return $rubrics;
  }

  public function getTraderPricesRubrics($user, $placeType, $type) {
    $rubrics = $this->db->query("
      select distinct c2b.sort_ind, c2b.id as b2id, tp.*, tpl.name
        from agt_traders_products2buyer c2b
        inner join agt_traders_products tp on c2b.cult_id=tp.id
        inner join agt_traders_products_lang tpl on tp.id=tpl.item_id
        inner join agt_traders_prices atp on atp.cult_id = tp.id && atp.acttype = $type && atp.buyer_id = $user
        inner join agt_traders_places pl on pl.id = atp.place_id && pl.buyer_id = c2b.buyer_id && pl.type_id = c2b.type_id
      where c2b.buyer_id = $user and c2b.acttype = $type and c2b.type_id = $placeType
      order by tpl.name asc");

    return $rubrics;
  }

  public function getPrices($user, $type) {
    $prices = $this->db->select('agt_traders_prices', '*', ['buyer_id' => $user, 'acttype' => $type]);
    $data = [];
    foreach ( $prices as $v ) {
      $data[$v['place_id']][$v['cult_id']][$v['curtype']] = $v;
    }
    return $data;
  }

  public function getTraderPrices($user, $places, $rubrics, $type) {
    $pricesArr = $places;
    $prices = $this->getPrices($user, $type);
    foreach ($places as $pKey => $place) {
      foreach ($rubrics as $rKey => $rubric) {
        $pricesArr[$pKey]['rubrics'][$rKey] = $rubric;
          $tmp_prices = $prices[$place['id']][$rubric['id']] ?? [];
        foreach ($tmp_prices as $price) {
          $pricesArr[$pKey]['rubrics'][$rKey]['price'][$price['curtype']] = [
            'cost' => ($price['costval'] != null) ? round($price['costval']) : null,
            'comment' => $price['comment'],
            'currency' => $price['curtype']
          ];
        }
      }
    }
    return $pricesArr;
  }
  public function getCompanyTraderPrices($user, $places, $rubrics, $type) {
    $pricesArr = $places;
    $date_expired_diff = date('Y-m-d', strtotime($this->countDaysExpiredDiff));
    $prices = $this->getPrices($user, $type);
    foreach ($places as $pKey => $place) {
      $is_avail = false;
      $tmp_rubrics = $rubrics;
      foreach ($rubrics as $rKey => $rubric) {
        $tmp_prices = $prices[$place['id']][$rubric['id']] ?? [];
        foreach ($tmp_prices as $price) {
          $is_avail = true;
          // diff отображать не позже 7 дней после сохранения цен
          $diff = $date_expired_diff <= $price['change_date'] ? round($price['costval'] - $price['costval_old']) : 0;
          $tmp_rubrics[$rKey]['price'][$price['curtype']] = [
            'cost'         => ($price['costval'] != null) ? round($price['costval']) : null,
            'comment'      => $price['comment'],
            'price_diff'   => $diff,
            'change_price' => !$price['costval_old'] || !$diff ? '' : ($diff < 0 ? 'down' : 'up'),
            'currency'     => $price['curtype']
          ];
        }
      }
      if ( $is_avail ) {
        $pricesArr[$pKey]['rubrics'] = $tmp_rubrics;
      }
    }
    return $pricesArr;
  }

  public function getPricesByCult($ids)
  {
    $rubrics = [];
    $date_expired_diff = date('Y-m-d', strtotime($this->countDaysExpiredDiff));
    foreach ($ids as $id) {
      $rubrics[] = $this->db->select('agt_traders_products_lang', ['id', 'name'], ['id' => $id])[0];
    }
    foreach ($rubrics as $key => $rubric) {
      $uah = $this->db->query("
        select tp.curtype, round(tp.costval) as price, round(tp.costval_old) as old_price, tp.change_date,
            tp.buyer_id, tpl.place, tports.portname, r.name as region, ci.title as company, ci.id as companyId
          from agt_traders_prices tp
          inner join agt_traders_places tpl on tpl.id = tp.place_id
          left join agt_traders_ports_lang as tports on tports.port_id = tpl.port_id
          inner join regions r on r.id = tpl.obl_id
          inner join agt_comp_items ci on ci.author_id = tp.buyer_id
          where tp.acttype = 0 && tp.curtype = 0 && tp.cult_id = {$rubric['id']} &&
            ci.trader_price_avail = 1 && ci.trader_price_visible = 1 && ci.visible = 1
          order by rand()
          limit 3");
      $usd = $this->db->query("
        select tp.curtype, round(tp.costval) as price, round(tp.costval_old) as old_price, tp.change_date,
            tp.buyer_id, tpl.place, tports.portname, r.name as region, ci.title as company, ci.id as companyId
          from agt_traders_prices tp
          inner join agt_traders_places tpl on tpl.id = tp.place_id
          left join agt_traders_ports_lang as tports on tports.port_id = tpl.port_id
          inner join regions r on r.id = tpl.obl_id
          inner join agt_comp_items ci on ci.author_id = tp.buyer_id
          where tp.acttype = 0 && tp.curtype = 1 && tp.cult_id = {$rubric['id']} &&
            ci.trader_price_avail = 1 && ci.trader_price_visible = 1 && ci.visible = 1
          order by rand()
          limit 3");
/*
      $uah = $this->db->query("
        select distinct tp.curtype, round(tp.costval) as price, round(tpa.costval) as old_price, round(tp.costval - tpa.costval) as price_diff, tp.buyer_id, tpl.place, tports.portname, r.name as region, ci.title as company, ci.id as companyId,
            case
              when round(tp.costval - tpa.costval) < 0 then 'down'
              when round(tp.costval - tpa.costval) > 0 then 'up'
              else ''
            end as change_price
          from agt_traders_prices tp
          inner join agt_traders_prices_arc tpa
            on tpa.buyer_id = tp.buyer_id
            && tpa.cult_id  = tp.cult_id
            && tpa.place_id = tp.place_id
            && tpa.curtype  = tp.curtype
            && tpa.dt       = date(tp.dt) - interval 1 day
          inner join agt_traders_places tpl
            on tpl.id = tp.place_id
          left join agt_traders_ports_lang as tports
            on tports.port_id = tpl.port_id
          inner join regions r
            on r.id = tpl.obl_id
          inner join agt_comp_items ci
            on ci.author_id = tp.buyer_id
          inner join (
            select distinct tp2.id
              from agt_traders_prices tp2
              inner join agt_comp_items ci2
                on ci2.author_id = tp2.buyer_id && ci2.trader_price_avail = 1 && ci2.trader_price_visible = 1 && ci2.visible = 1
              inner join agt_traders_places tpl2
                on tpl2.id = tp2.place_id
            where tp2.acttype = 0 && tp2.curtype = 0 && tp2.cult_id = {$rubric['id']} order by rand())
          as tp3 on tp3.id = tp.id
          limit 3");
      $usd = $this->db->query("
        select distinct tp.curtype, round(tp.costval) as price, round(tpa.costval) as old_price, round(tp.costval - tpa.costval) as price_diff, tp.buyer_id, tpl.place, tports.portname, r.name as region, ci.title as company, ci.id as companyId,
            case
              when round(tp.costval - tpa.costval) < 0 then 'down'
              when round(tp.costval - tpa.costval) > 0 then 'up'
              else ''
            end as change_price
          from agt_traders_prices tp
          inner join agt_traders_prices_arc tpa
            on tpa.buyer_id = tp.buyer_id
            && tpa.cult_id  = tp.cult_id
            && tpa.place_id = tp.place_id
            && tpa.curtype  = tp.curtype
            && tpa.dt       = date(tp.dt) - interval 1 day
          inner join agt_traders_places tpl
            on tpl.id = tp.place_id
          left join agt_traders_ports_lang as tports
            on tports.port_id = tpl.port_id
          inner join regions r
            on r.id = tpl.obl_id
          inner join agt_comp_items ci
            on ci.author_id = tp.buyer_id
          inner join (
            select tp2.id
              from agt_traders_prices tp2
              inner join agt_comp_items ci2
                on ci2.author_id = tp2.buyer_id && ci2.trader_price_avail = 1 && ci2.trader_price_visible = 1 && ci2.visible = 1
              inner join agt_traders_places tpl2
                on tpl2.id = tp2.place_id
            where tp2.acttype = 0 && tp2.curtype = 1 && tp2.cult_id = {$rubric['id']} order by rand())
          as tp3 on tp3.id = tp.id
          limit 3");
*/
      $prices = array_merge($uah ?: [], $usd ?: []);
      foreach ($prices as &$v) {
        $diff = $date_expired_diff <= $v['change_date'] ? round($v['price'] - $v['old_price']) : 0;
        $v['price_diff'] = $diff;
        $v['change_price'] = !$v['old_price'] || !$diff ? '' : ($diff < 0 ? 'down' : 'up');
      }
      unset($v);
      $rubrics[$key]['prices'] = $prices;
    }
    /* $this->db->query("set @num := 0, @curtype := '';");
      $result = $this->db->query("
        select tpl.name, tp.curtype, round(tp.costval) as costval, round(tp.costval - tpa.costval) as costval_diff, tp.buyer_id, tp2.place, tp3.url as port_url, tpl2.portname, tr.name as region, aci.title as company
          from agt_traders_prices tp
          left join agt_traders_products_lang as tpl
            on tpl.id = tp.cult_id
          left join agt_traders_prices_arc as tpa
            on tpa.buyer_id = tp.buyer_id
            && tpa.cult_id  = tp.cult_id
            && tpa.place_id = tp.place_id
            && tpa.curtype  = tp.curtype
            && tpa.dt       = date(tp.dt) - interval 1 day
          left join agt_traders_places as tp2
           on tp2.id = tp.place_id
          left join agt_traders_ports as tp3
            on tp3.obl_id = tp2.obl_id
            && tp3.id     = tp2.port_id
          left join agt_traders_ports_lang as tpl2
            on tpl2.port_id = tp2.port_id
          left join regions as tr
            on tr.id = tp2.obl_id
          left join agt_comp_items as aci
            on aci.author_id = tp.buyer_id
        where tp.cult_id = {$id} && tp.curtype = 0
        order by rand() desc limit 3");
      foreach ($result as $res) {
        if (!isset($prices[$res['name']])) {
          $prices[$res['name']] = [];
        }
        $prices[$res['name']][] = [
          'costval'      => $res['costval'],
          'costval_diff' => $res['costval_diff'],
          'buyer_id'     => $res['buyer_id'],
          'company'      => $res['company'],
          'place'        => $res['place'],
          'port_url'     => $res['port_url'],
          'portname'     => $res['portname'],
          'region'       => $res['region'],
          'curtype'      => $res['curtype']
        ];
      }
      */
    return $rubrics;
  }

  public function getPricesForwards($user, $type, $dtStart) {
    $prices = $this->db->query("select * from agt_traders_prices where buyer_id = $user && acttype = $type && dt >= '$dtStart'");
    $data = [];
    foreach ( $prices as $v ) {
      $data[$v['place_id']][$v['cult_id']][$v['dt']][$v['curtype']] = [
        'cost' => $v['costval'] != null ? round($v['costval']) : null,
        'comment' => $v['comment'],
        'currency' => $v['curtype'],
      ];
    }
    return $data;
  }

  public function getTraderPricesForwards($user, $places, $rubrics, $type, $forwardMonths) {
    $data = $places;
    $months_dt = array_column($forwardMonths, 'start'); // доступные даты цен
    $prices = $this->getPricesForwards($user, $type, reset($months_dt));
    foreach ($places as $pKey => $place) {
      foreach ($rubrics as $rKey => $rubric) {
        $data[$pKey]['rubrics'][$rKey] = $rubric;
        $data[$pKey]['rubrics'][$rKey]['price'] = $prices[$place['id']][$rubric['id']] ?? null;
      }
    }
    return $data;
  }

  public function getCompanyTraderPricesForwards($user, $places, $rubrics, $type, $forwardMonths) {
    $data = [];
    $months_dt = array_column($forwardMonths, 'start'); // доступные даты цен
    $prices = $this->getPricesForwards($user, $type, reset($months_dt));
    foreach ($forwardMonths as $month) {
      foreach ($places as $pKey => $place) {
        $is_avail = false; // неличие цен в месяце
        $tmp_rubrics = $rubrics;
        foreach ($rubrics as $rKey => $rubric) {
          if ( isset($prices[$place['id']][$rubric['id']][$month['start']]) ) {
            $tmp_rubrics[$rKey]['price'] = $prices[$place['id']][$rubric['id']][$month['start']];
            $is_avail = true;
          }
        }
        if ( $is_avail ) {
          $place['rubrics'] = $tmp_rubrics;
          $place['monthLabel'] = $month['label'];
          $data[] = $place;
        }
      }
    }
    return $data;
  }

  public function getCountByGroup($group) {
  	$traders = $this->db->query("
      select tp.url, tpl.name as product, count(distinct ci.id) as count
        from agt_comp_items ci
        inner join agt_traders_products tp
          on tp.group_id = $group
        inner join agt_traders_prices tpr
          on ci.author_id = tpr.buyer_id && tpr.cult_id = tp.id
        inner join agt_traders_places tplaces
          on tplaces.id = tpr.place_id
        inner join agt_traders_products_lang as tpl
          on tpl.id = tp.id
      where tpr.acttype = 0 && ci.trader_price_avail = 1 && ci.trader_price_visible = 1 && ci.visible = 1 group by tp.id");
  	return $traders;
  }

  public function getRegionsCompany($region) {
    $traders = $this->db->query("
      select tpl.name as product, (select count(buyer_id) as count from agt_traders_products2buyer where cult_id = tr.id) as count
        from regions tr
        left join agt_traders_products2buyer as tpb
          on tpb.cult_id = tp.id
      where tr.id = {$region} group by tr.name order by tr.name desc");
    return $traders;
  }

  public function getRating($company) {
    $review  = $this->db->query("select ifnull(round(avg(rate)), 0) as rating, ifnull(count(id), 0) as count from agt_comp_comment where item_id = $company && visible = 1 && reply_to_id = 0")[0];
    return ['rating' => $review['rating'], 'count' => $this->model('utils')->numDecline($review['count'], 'отзыв', 'отзыва', 'отзывов')];
  }

  public function getCommentsCount($company) {
    $comments = $this->db->query("select count(id) as comments from agt_comp_comment where item_id = $company && visible = 1 && reply_to_id = 0")[0]['comments'];
    return $comments;
  }

  public function getRegions($rubric = null, $sitemap = null) {
      $regions = $this->db->query("
      select *
        from regions
      group by id");
    if ($sitemap != null) {
      $total = 0;
      foreach ($regions as $key => $value) {
        $totalTraders = $this->getCountByRubric($rubric, 0, $value['id']);
        $total = ($total + $totalTraders);
        $regions[$key]['count'] = $totalTraders;
      }
      array_unshift($regions, ['id' => 0, 'name' => 'Украина', 'translit' => 'ukraine', 'count' => $total]);
    }
    return $regions;
  }
  public function getRegionPorts(){
    $ports = $this->db->query("
     SELECT r.id,r.city_parental,r.translit  FROM regions AS r INNER JOIN agt_traders_ports AS tp ON r.id = tp.obl_id WHERE tp.active = 1 ORDER BY r.id ASC
      ");

    $unique = array_unique($ports, SORT_REGULAR);
    return $unique;
  }
  public function getPorts() {
    $ports = $this->db->query("
      select tp.id, tp.url as translit, tpl.portname as name, tpl.p_title as title, tpl.p_h1 as h1, tpl.p_descr
        from agt_traders_ports tp
        inner join agt_traders_ports_lang tpl
          on tp.id = tpl.port_id
      where tp.active = 1
      order by tpl.portname asc");
    return $ports;
  }

  public function getRubrics($type, $region = null, $port = null, $onlyPorts = null, $currency = null) {
    $sell = ($type == 0) ? '' : '_sell';
    $rubrics = $this->db->query("
      select tp.id, tp.url as translit, tp.group_id, tpl.name, tpr.id as tprid
        from agt_traders_products tp
        inner join agt_traders_products_lang tpl
          on tpl.item_id = tp.id
        inner join agt_traders_prices tpr
          on tpr.cult_id = tp.id && tpr.active = 1
        inner join agt_traders_places plc
          on plc.id = tpr.place_id
        inner join agt_comp_items ci
          on ci.author_id = tpr.buyer_id
        where tp.acttype = $type && plc.type_id != 1 && ci.trader_price{$sell}_visible = 1 && ci.trader_price{$sell}_avail = 1 && ci.visible = 1
        group by tp.id
        order by tpl.name asc");
      /* foreach ($rubrics as $key => $rubric) {
        $rubrics[$key]['count'] = $this->getCountByRubric($rubric['id'], $type, $region, $port, $onlyPorts, $currency);
      } */
    return $rubrics;
  }

  public function getCountByRubric($rubric, $type = null, $region = null, $port = null, $onlyPorts = null, $currency = null, $obl_ports = null) {
    $typeInt         = ($type == 'buy') ? 0 : 1;
    $type            = ($type == 'buy') ? "" : "_sell";
    $currencySql     = ($currency !== null) ? "&& tpr.curtype = $currency" : "";
    $regionSql       = ($region != null) ? "&& tpl.obl_id = $region" : "";
    $portSql         = ($port != null) ? "&& tpl.port_id = $port" : "";
    $onlyPortsSql    = ($onlyPorts == 'yes') ? "&& tpl.port_id != 0" : "";
    $placeSql        = ($region != null || $port != null || $onlyPorts != null) ? "inner join agt_traders_places tpl on tpr.place_id = tpl.id $regionSql $portSql $onlyPortsSql" : "";

    $cost = $this->db->query("
      select count(distinct ci.id) as count
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' && tpr.cult_id = $rubric $currencySql
        $placeSql
      where ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && ci.visible = 1
    ")[0]['count'] ?? 0;
    return $cost;
  }
  public function getCountByRubric_dev($rubric, $type = null, $region = null, $port = null, $onlyPorts = null, $currency = null, $obl_ports = null) {
    $typeInt         = ($type == 'buy') ? 0 : 1;
    $type            = ($type == 'buy') ? "" : "_sell";
    $currencySql     = ($currency !== null) ? "&& tpr.curtype = $currency" : "";
    $regionSql       = ($region != null) ? "&& tpl.obl_id = $region" : "";
    $portSql         = ($port != null) ? "&& tpl.port_id = $port" : "";
    $onlyPortsSql    = ($onlyPorts == 'yes') ? "&& tpl.port_id != 0" : "";
    $placeSql        = ($region != null || $port != null || $onlyPorts != null) ? "inner join agt_traders_places tpl on tpr.place_id = tpl.id $regionSql $portSql $onlyPortsSql" : "";

    // Выбор портов по id региона 
    // return Array
    if(isset($obl_ports)){
      $port_stack = [];
      foreach ($obl_ports as $value) {
        $query = $this->db->query("SELECT id FROM agt_traders_ports WHERE id =" .$value['id']. "");
        array_push($port_stack, $query);
      }
      //print_r($port_stack);die();
      //Доработать рендер запоросов по множественному выбору постов для портов
      //2. Сделать доп маршруты и передавать порты в контроллер и представление.
    }

    $cost = $this->db->query("
      select count(distinct ci.id) as count
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' && tpr.cult_id = $rubric $currencySql
        $placeSql
      where ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && ci.visible = 1
    ")[0]['count'] ?? 0;
    return $cost;
  }
  public function getForwardRubrics($type, $priceType, $region = null, $port = null, $onlyPorts = null, $currency = null) {
    $rubrics = $this->db->query("
      select tp.id, tp.url as translit, tp.group_id, tpl.name, tpr.id as tprid
        from agt_traders_products tp
        inner join agt_traders_products_lang tpl
          on tpl.item_id = tp.id
        inner join agt_traders_prices tpr
          on tpr.cult_id = tp.id
        inner join agt_traders_places plc
          on plc.id = tpr.place_id
        inner join agt_comp_items ci
          on ci.author_id = tpr.buyer_id
        where tp.acttype = $type && plc.type_id != 1 &&
          ci.trader_price_forward_visible = 1 && ci.trader_price_forward_avail = 1 && ci.visible = 1 &&
          tpr.active = 1 && tpr.acttype = $priceType
        group by tp.id
        order by tpl.name asc");
    // get traders count from rubric list
    $counts = $this->getCountsForwardByRubric(array_column($rubrics, 'id'), $region, $port, $onlyPorts, $currency);
    foreach ($rubrics as &$v) {
      $v['count'] = $counts[$v['id']] ?? 0;
    }
    return $rubrics;
  }

  public function getCountsForwardByRubric($rubrics, $region = null, $port = null, $onlyPorts = null, $currency = null) {
    $join = $region || $port || $onlyPorts == 'yes' ? "inner join agt_traders_places tpl on tpr.place_id = tpl.id" : "";

    $where = "where ci.trader_price_forward_avail = 1 && ci.trader_price_forward_visible = 1 && ci.visible = 1 && tpr.acttype = {$this->forwardPriceType} && tpr.cult_id in (".implode(',', $rubrics).")";
    $where .= $region != null ? "&& tpl.obl_id = $region" : "";
    $where .= $port != null ? "&& tpl.port_id = $port" : "";
    $where .= $onlyPorts == 'yes' ? "&& tpl.port_id != 0" : "";
    $where .= $currency !== null ? "&& tpr.curtype = $currency" : "";

    $data = $this->db->query("select count(distinct ci.id) as count, tpr.cult_id as id from agt_comp_items ci
      inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id
      $join
      $where
      group by tpr.cult_id");
    return array_column($data, 'count', 'id');
  }

  public function getRubricsChunk($rubrics) {
    $result  = [];
    foreach ($rubrics as $r) {
      $result[$r['group_id']][] = $r;
    }
    foreach ($result as $key => $value) {
      $result[$key] = $this->model('utils')->fillChunk($value, 2);
    }
    return $result;
  }

  public function getRubric($id) {
    $groups = $this->db->query("
      select pgl.id, pgl.name, pg.url
        from agt_traders_products pg
        inner join agt_traders_products_lang pgl
          on pg.id = pgl.item_id
      where pg.id = $id")[0] ?? null;

    return $groups;
  }

  public function getRubricsGroup($type, $ids = null) {
    $groups = $this->db->query("
      select pgl.id, pgl.name
        from agt_traders_product_groups pg
        inner join agt_traders_product_groups_lang pgl
          on pg.id = pgl.item_id
      where pg.acttype = $type".($ids ? ' && pgl.id in ('.implode(',', $ids).')' : ''));
    return $groups;
  }

  public function getCurrencies() {
    $currencies  = [
      'uah' => [
        'id'   => 0,
        'name' => 'Гривна',
        'code' => 'uah'
      ],
      'usd' => [
        'id'   => 1,
        'name' => 'Доллар',
        'code' => 'usd'
      ]
    ];
    return $currencies;
  }

  public function getTableList($rubric, $type = null, $region = null, $port = null, $onlyPorts = false, $currency = null) {
    $typeInt         = ($type == 'buy') ? 0 : 1;
    $type            = ($type == 'buy') ? "" : "_sell";
    $currencySql     = ($currency !== null) ? "&& tpr.curtype = $currency" : "";
    $regionSql       = ($region != null) ? "&& tpl.obl_id = $region" : "";
    $portSql         = ($port != null) ? "&& tpl.port_id = $port" : "";
    $onlyPortsSql    = ($onlyPorts != false) ? "&& tpl.port_id != 0" : "";
    $placeSql        = ($region != null || $port != null || $onlyPorts != null) ? "$regionSql $portSql $onlyPortsSql" : "";

    // get traders list
    $tmp = $this->db->query("
      select ci.id, ci.title, ci.logo_file as logo, ci.author_id, ci.trader_premium{$type} as top, tpr.cult_id, tpr.place_id, tpl.port_id,
          round(tpr.costval) AS price, round(tpr.costval_old) as old_price, tpr.comment, tpr.curtype as currency,
          dt as date, date_format(dt, '%e %M') as date2, tpr.change_date,
          IF(tpl.port_id != 0, pl.portname, concat(r.name, ' обл.')) as location, tpl.place
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' && tpr.cult_id = $rubric $currencySql
        inner join agt_traders_places tpl on tpr.place_id = tpl.id $placeSql
        inner join regions r on r.id = tpl.obl_id
        inner join agt_traders_products2buyer p2b on p2b.buyer_id = ci.author_id && p2b.acttype = tpr.acttype and p2b.type_id = tpl.type_id and p2b.cult_id = tpr.cult_id
        left join agt_traders_ports_lang pl on pl.port_id = tpl.port_id
      where ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && tpr.active = 1 && tpl.type_id != 1 && ci.visible = 1
      order by ci.trader_premium{$type} desc,change_date desc, ci.rate_formula desc, ci.trader_sort{$type}, ci.title, tpr.dt");
    $traders = [];
    $date_expired_diff = date('Y-m-d', strtotime($this->countDaysExpiredDiff));
    foreach ($tmp as $v)
    {
      $curr = $v['currency'] ? 'usd' : 'uah';
      $diff = $date_expired_diff <= $v['change_date'] ? round($v['price'] - $v['old_price']) : 0;
      $price_data = [
        'price' => $v['price'],
        'old_price' => $v['old_price'],
        'price_diff' => $diff,
        'change_price' => !$v['old_price'] || !$diff ? '' : ($diff < 0 ? 'down' : 'up'),
        'currency' => $v['currency']
      ];
      if ( !isset($traders[$v['place_id']]) ) {
        // удаляем значения из елемента списка
        unset($v['price'], $v['old_price'], $v['currency']);
        $traders[$v['place_id']] = $v;
      }
      $traders[$v['place_id']]['prices'][$curr] = $price_data;


    }
    return $traders;
  }

  public function getTopList($count, $type = null, $rubric = null) {
    $rubricSql       = ($rubric != null) ? "&& tpr.cult_id = {$rubric['id']}" : "";
    $typeInt         = ($type == 'buy') ? 0 : 1;
    $type            = ($type == 'buy') ? "" : "_sell";


    // get traders list
    $traders = $this->db->query("
      select ci.id, ci.title, ci.logo_file as logo, ci.author_id, date_format(ci.trader_price{$type}_dtupdt, '%d %b.') as date, date_format(ci.trader_price{$type}_dtupdt, '%d.%m.%Y в %H:%i') as full_date, ci.trader_premium{$type} as top
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' $rubricSql
      where ci.trader_premium{$type} = 1 && ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && ci.visible = 1
      group by ci.id
      order by rand()
      limit $count");
    foreach ($traders as $key => $value) {
      $query = "
          select tp_l.name as rubric, tpr.id, round(tpr.costval) as price, round(tpr.costval - tpa.costval) as price_diff, round(tpa.costval) as old_price, tpr.place_id, tpr.curtype as currency, tp_l.name as title,
            case
              when round(tpr.costval - tpa.costval) < 0 then 'down'
              when round(tpr.costval - tpa.costval) > 0 then 'up'
              else ''
            end as change_price
            from agt_traders_prices tpr
            left join agt_traders_prices_arc tpa
              on tpa.buyer_id = tpr.buyer_id
              && tpa.cult_id  = tpr.cult_id
              && tpa.place_id = tpr.place_id
              && tpa.curtype  = tpr.curtype
              && tpa.dt       = date(tpr.dt) - interval 1 day
            inner join agt_traders_products_lang tp_l
              on tp_l.id = tpr.cult_id
            inner join agt_traders_places tpl on tpr.place_id = tpl.id
            left join agt_traders_ports_lang pl
              on pl.port_id = tpl.port_id
            left join regions r
              on r.id = tpl.obl_id
          where tpr.buyer_id = {$traders[$key]['author_id']} && tpl.type_id != 1 && tpr.acttype = $typeInt $rubricSql
          group by tpr.cult_id
          order by tpr.change_date
          limit 3
        ";
      $traders[$key]['prices'] = $this->db->query($query);
      $traders[$key]['date'] = $this->db->query("select date_format(dt, '%d.%m.%Y') as updateDate from agt_traders_prices where buyer_id = {$value['author_id']} && acttype = $typeInt order by dt desc")[0]['updateDate'] ?? null;
      $traders[$key]['date2'] = $this->db->query("select date_format(dt, '%d %b') as updateDate from agt_traders_prices where buyer_id = {$value['author_id']} && acttype = $typeInt order by dt desc")[0]['updateDate'] ?? null;
    }
      return $traders;
  }


  public function getList($count, $page = 1, $type = null, $region = null, $port = null, $rubric = null, $onlyPorts = false, $currency = null) {
    $typeInt         = ($type == 'buy') ? 0 : 1;
    $type            = ($type == 'buy') ? "" : "_sell";
    $currencySql     = ($currency !== null) ? "&& tpr.curtype = $currency" : "";
    $regionSql       = ($region != null) ? "&& tpl.obl_id = $region" : "";
    $portSql         = ($port != null) ? "&& tpl.port_id = $port" : "";
    $onlyPortsSql    = ($onlyPorts != false) ? "&& tpl.port_id != 0" : "";
    $placeSql        = ($region != null || $port != null || $onlyPorts != null) ? "inner join agt_traders_places tpl on tpr.place_id = tpl.id $regionSql $portSql $onlyPortsSql" : "";
    $rubricSql       = ($rubric != null) ? "&& tpr.cult_id = $rubric" : "";

    // get total traders count
    $totalTraders = $this->db->query("
      select count(distinct ci.id) as count
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' $currencySql $rubricSql
        $placeSql
      where ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && ci.visible = 1")[0]['count'];
      // find the total number of pages
    $totalPages = intval(($totalTraders - 1) / $count) + 1;
    // if the page number is empty or less than one, we return the first page
    if(empty($page) or $page < 1 or $page == null) {
      $page = 0;
    }
    // if the page number is greater than the last, return the last page
    if($page > $totalPages) {
      $page = $totalPages;
    }
    // which record to start
    $start = $page * $count - $count;

/* today,vip,order date
select ci.id, ci.title, ci.logo_file as logo, ci.author_id, ci.trader_premium{$type} as top, tpr.dt as date, date_format(MAX(tpr.dt), '%e %M') as date2
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' $currencySql $rubricSql
        $placeSql
      where ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && ci.visible = 1 && tpr.dt = CURDATE()
      group by ci.id 
    union
      (select ci.id, ci.title, ci.logo_file as logo, ci.author_id, ci.trader_premium{$type} as top, MAX(tpr.dt) as date, date_format(MAX(tpr.dt), '%e %M') as date2
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' $currencySql $rubricSql
        $placeSql
      where ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && ci.visible = 1
      group by ci.id
      order by ci.trader_premium{$type} desc,date desc,ci.trader_sort{$type}, ci.rate_formula desc, ci.title
      limit $start, $count)
*/
    // get traders list
    $traders = $this->db->query("
    select MAX(tpr.change_date) as ch_dt,ci.id, ci.title, ci.logo_file as logo, ci.author_id, ci.trader_premium{$type} as top, MAX(tpr.dt) as date, date_format(MAX(tpr.dt), '%e %M') as date2
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' $currencySql $rubricSql
        $placeSql
      where ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && ci.visible = 1
      group by ci.id
      order by ci.trader_premium{$type} desc,ch_dt desc,ci.trader_sort{$type}, ci.rate_formula desc, ci.title
      limit $start, $count");
      // group by
    $groupBy = 'tpr.cult_id';
    if ($rubric != null && $region != null) {
      $groupBy = 'tpl.obl_id';
    } else if ($rubric != null && $port != null) {
      $groupBy = 'tpl.port_id';
    } else if ($onlyPorts != false) {
      $groupBy = 'tpl.port_id';
    } else if ($rubric != null) {
      $groupBy = 'tpl.obl_id';
    }

    if ($groupBy == 'tpr.cult_id') {
      $title = "tp_l.name as title";
    } else if ($groupBy == 'tpl.port_id') {
      /*$title = "case
              when tpl.port_id != 0 then pl.portname
            end as title";*/
      $title = "IF(tpl.port_id != 0, pl.portname, '') as title";
    } else {
      /*$title = "case
              when tpl.obl_id != 0 then concat(r.name, ' обл.')
            end as title";*/
      $title = "IF(tpl.obl_id != 0, concat(r.name, ' обл.'), '') as title";
    }

    $date_expired_diff = date('Y-m-d', strtotime($this->countDaysExpiredDiff));
    foreach ($traders as $key => $value)
    {
    /*
      // запрос со старой ценой из другой таблицы agt_traders_prices_arc
      $query = "
          SELECT tp_l.name as rubric, tpr.id, round(tpr.costval) as price, round(tpr.costval - tpa.costval) as price_diff, round(tpa.costval) as old_price, tpr.place_id, tpr.curtype as currency,
            $title,
            case
              when round(tpr.costval - tpa.costval) < 0 then 'down'
              when round(tpr.costval - tpa.costval) > 0 then 'up'
              else ''
            end as change_price
            FROM agt_traders_prices tpr
            LEFT JOIN agt_traders_prices_arc tpa
              on tpa.buyer_id = tpr.buyer_id
              && tpa.cult_id  = tpr.cult_id
              && tpa.place_id = tpr.place_id
              && tpa.curtype  = tpr.curtype
              && tpa.dt       = date(tpr.dt) - interval 1 day
            inner join agt_traders_products_lang tp_l
              on tp_l.id = tpr.cult_id
            inner join agt_traders_places tpl on tpr.place_id = tpl.id $regionSql $portSql $onlyPortsSql
            left join agt_traders_ports_lang pl
              on pl.port_id = tpl.port_id
            left join regions r
              on r.id = tpl.obl_id
          WHERE tpr.buyer_id = {$traders[$key]['author_id']} && tpl.type_id != 1 && tpr.acttype = $typeInt $rubricSql $currencySql
          GROUP BY $groupBy
          ORDER BY tpr.change_date
          LIMIT 3
        ";*/
      $query = "
          SELECT tp_l.name as rubric, tpr.id, round(tpr.costval) as price, round(tpr.costval_old) as old_price, tpr.place_id, tpr.curtype as currency, tpr.change_date, $title
            FROM agt_traders_prices as tpr
            inner join agt_traders_products_lang  as tp_l on tp_l.id = tpr.cult_id
            inner join agt_traders_places         as tpl  on tpr.place_id = tpl.id $regionSql $portSql $onlyPortsSql
          WHERE tpr.buyer_id = {$value['author_id']} && tpl.type_id != 1 && tpr.acttype = $typeInt $rubricSql $currencySql
          GROUP BY $groupBy
          ORDER BY tpr.change_date DESC
          LIMIT 2
        ";
      $traders[$key]['review'] = $this->getRating($value['id']);
      $traders[$key]['prices'] = $this->db->query($query);
        /*echo '<pre>';
        var_dump($traders);
        echo '</pre>';die();*/
      /*  var_dump($traders[$key]['prices']);die(); !!!!! */
      if ( $traders[$key]['prices'] ) {
        foreach ($traders[$key]['prices'] as $k => $v) {
          $diff = $date_expired_diff <= $v['change_date'] ? round($v['price'] - $v['old_price']) : 0;
          $traders[$key]['prices'][$k]['price_diff'] = $diff;
          $traders[$key]['prices'][$k]['change_price'] = !$v['old_price'] || !$diff ? '' : ($diff < 0 ? 'down' : 'up');
        }
      }
    }


    return ['data' => $traders, 'totalPages' => $totalPages ?? 1, 'page' => $page];

  }
    // СПИСОК ТРЕЙДЕОРОВ ПО КУЛЬТУРЕ
  public function getList_dev($count, $page = 1, $type = null, $region = null, $port = null, $rubric = null, $onlyPorts = false, $currency = null, $obl_ports = null) {
    $typeInt         = ($type == 'buy') ? 0 : 1;
    $type            = ($type == 'buy') ? "" : "_sell";
    $currencySql     = ($currency !== null) ? "&& tpr.curtype = $currency" : "";
    $regionSql       = ($region != null) ? "&& tpl.obl_id = $region" : "";
    $portSql         = ($port != null) ? "&& tpl.port_id = $port" : "";
    $onlyPortsSql    = ($onlyPorts != false) ? "&& tpl.port_id != 0" : "";
    //Вывод портов по городам
    if($obl_ports != null){
      $query = $this->db->query("SELECT id FROM agt_traders_ports WHERE obl_id = $obl_ports");
      //Доп запросы портов
      $port_query = '';
      foreach ($query as $val) {
        $port_query .= "|| tpl.port_id = ".$val['id']." ";
      }
      // /print_r($port_query);die();
    }

    $placeSql        = ($region != null || $port != null || $onlyPorts != null || $obl_ports != null) ? "inner join agt_traders_places tpl on tpr.place_id = tpl.id $regionSql $portSql $obl_ports $onlyPortsSql" : "";
    $rubricSql       = ($rubric != null) ? "&& tpr.cult_id = $rubric" : "";


    // get total traders count
    $totalTraders = $this->db->query("
      select count(distinct ci.id) as count
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' $currencySql $rubricSql
        $placeSql
      where ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && ci.visible = 1")[0]['count'];
    // find the total number of pages
    $totalPages = intval(($totalTraders - 1) / $count) + 1;
    // if the page number is empty or less than one, we return the first page
    if(empty($page) or $page < 1 or $page == null) {
      $page = 0;
    }
    // if the page number is greater than the last, return the last page
    if($page > $totalPages) {
      $page = $totalPages;
    }
    // which record to start
    $start = $page * $count - $count;

$sql = "
    select MAX(tpr.change_date) as ch_dt,ci.id, ci.title, ci.logo_file as logo, ci.author_id, ci.trader_premium{$type} as top, MAX(tpr.dt) as date, date_format(MAX(tpr.dt), '%e %M') as date2
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' $currencySql $rubricSql
        $placeSql
      where ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && ci.visible = 1
      group by ci.id
      order by ci.trader_premium{$type} desc,ch_dt desc,ci.trader_sort{$type}, ci.rate_formula desc, ci.title
      limit $start, $count";
    // get traders list
    $traders = $this->db->query("
    select MAX(tpr.change_date) as ch_dt,ci.id, ci.title, ci.logo_file as logo, ci.author_id, ci.trader_premium{$type} as top, MAX(tpr.dt) as date, date_format(MAX(tpr.dt), '%e %M') as date2
        from agt_comp_items ci
        inner join agt_traders_prices tpr on ci.author_id = tpr.buyer_id && tpr.acttype = '$typeInt' $currencySql $rubricSql
        $placeSql
      where ci.trader_price{$type}_avail = 1 && ci.trader_price{$type}_visible = 1 && ci.visible = 1
      group by ci.id
      order by ci.trader_premium{$type} desc,ch_dt desc,ci.trader_sort{$type}, ci.rate_formula desc, ci.title
      limit $start, $count");
    // group by
    $groupBy = 'tpr.cult_id';
    if ($rubric != null && $region != null) {
      $groupBy = 'tpl.obl_id';
    } else if ($rubric != null && $port != null) {
      $groupBy = 'tpl.port_id';
    } else if ($onlyPorts != false) {
      $groupBy = 'tpl.port_id';
    } else if ($rubric != null) {
      $groupBy = 'tpl.obl_id';
    }

    if ($groupBy == 'tpr.cult_id') {
      $title = "tp_l.name as title";
    } else if ($groupBy == 'tpl.port_id') {

      $title = "IF(tpl.port_id != 0, pl.portname, '') as title";
    } else {
      
      $title = "IF(tpl.obl_id != 0, concat(r.name, ' обл.'), '') as title";
    }

    $date_expired_diff = date('Y-m-d', strtotime($this->countDaysExpiredDiff));
    foreach ($traders as $key => $value)
    {
      $query = "
          SELECT tp_l.name as rubric, tpr.id, round(tpr.costval) as price, round(tpr.costval_old) as old_price, tpr.place_id, tpr.curtype as currency, tpr.change_date, $title
            FROM agt_traders_prices as tpr
            inner join agt_traders_products_lang  as tp_l on tp_l.id = tpr.cult_id
            inner join agt_traders_places         as tpl  on tpr.place_id = tpl.id $regionSql $portSql $onlyPortsSql
            left join agt_traders_ports_lang      as pl   on pl.port_id = tpl.port_id
            left join regions                     as r    on r.id = tpl.obl_id
          WHERE tpr.buyer_id = {$value['author_id']} && tpl.type_id != 1 && tpr.acttype = $typeInt $rubricSql $currencySql
          GROUP BY $groupBy
          ORDER BY tpr.change_date DESC
          LIMIT 3
        ";
      $traders[$key]['review'] = $this->getRating($value['id']);
      $traders[$key]['prices'] = $this->db->query($query);
      if ( $traders[$key]['prices'] ) {
        foreach ($traders[$key]['prices'] as $k => $v) {
          $diff = $date_expired_diff <= $v['change_date'] ? round($v['price'] - $v['old_price']) : 0;
          $traders[$key]['prices'][$k]['price_diff'] = $diff;
          $traders[$key]['prices'][$k]['change_price'] = !$v['old_price'] || !$diff ? '' : ($diff < 0 ? 'down' : 'up');
        }
      }
    }
    return ['data' => $traders, 'totalPages' => $totalPages ?? 1, 'page' => $page];
  }

  public function getListForwards($count, $page = 1, $region = null, $port = null, $rubric = null, $onlyPorts = false, $currency = null, $dtStart = null) {
    $price_type = $this->forwardPriceType;

    $join_sql = "inner join agt_traders_prices as tpr on ci.author_id=tpr.buyer_id";
    $join_sql .= $region || $port || $onlyPorts ? " inner join agt_traders_places as tpl on tpr.place_id = tpl.id" : "";

    $where = "where ci.trader_price_forward_avail=1 && ci.trader_price_forward_visible=1 && ci.visible=1 && tpr.acttype=$price_type";
    $where .= $region ? " && tpl.obl_id=$region" : "";
    $where .= $port ? "&& tpl.port_id = $port" : "";
    $where .= $rubric ? " && tpr.cult_id=$rubric" : "";
    $where .= $onlyPorts ? "&& tpl.port_id != 0" : "";
    $where .= $currency ? " && tpr.curtype=$currency" : "";
    $where .= $dtStart ? " && tpr.dt>='$dtStart'" : "";

    // get total traders count
    $total = $this->db->query("select count(distinct ci.id) as count from agt_comp_items as ci $join_sql $where")[0]['count'];
    // find the total number of pages
    $pages = intval(($total - 1) / $count) + 1;
    // if the page number is empty or less than one, we return the first page
    if(empty($page) or $page < 1 or $page == null) {
      $page = 0;
    }
    // if the page number is greater than the last, return the last page
    if($page > $pages) {
      $page = $pages;
    }

    // which record to start
    $start = $page * $count - $count;
    // get traders list
    $traders = $this->db->query("select ci.id,ci.title,ci.logo_file as logo,ci.author_id,ci.trader_premium_forward as top, min(dt) as date
      from agt_comp_items as ci
      $join_sql
      $where
      group by ci.id
      order by ci.trader_sort_forward, ci.rate_formula desc, ci.title
      limit $start, $count");

    foreach ($traders as &$v)
    {
      // fixme кешировать рейтинг и кол. отзывов в таблице agt_comp_items
      $v['review'] = $this->getRating($v['id']);
      // ближайший месяц с форвардными ценами
      $v['date_show'] = $this->monthNames[date('n', strtotime($v['date']))].' '.date('Y', strtotime($v['date']));
    }

    return ['data' => $traders, 'totalPages' => $pages ?? 1, 'page' => $page];
  }

  public function getTableListForwards($rubric, $region = null, $port = null, $onlyPorts = false, $currency = null, $dtStart = null) {
    $price_type = $this->forwardPriceType;

    $where = "where ci.trader_price_forward_avail = 1 && ci.trader_price_forward_visible = 1 && tpr.active = 1 && tpl.type_id != 1 && ci.visible = 1 && tpr.acttype = $price_type && tpr.cult_id = $rubric";
    $where .= $region ? " && tpl.obl_id = $region" : '';
    $where .= $port ? "&& tpl.port_id = $port" : "";
    $where .= $onlyPorts ? "&& tpl.port_id != 0" : "";
    $where .= $currency ? " && tpr.curtype = $currency" : '';
    $where .= $dtStart ? " && tpr.dt >= '$dtStart'" : "";

    // get traders list
    $tmp = $this->db->query("
      select ci.id, ci.title, ci.logo_file as logo, ci.author_id, ci.trader_premium_forward as top,
        tpr.cult_id, tpr.place_id, tpr.costval, tpr.comment, tpr.curtype, tpr.dt as date, concat(r.name, ' обл.') as location, tpl.place
        from agt_comp_items ci
        inner join agt_traders_prices as tpr on ci.author_id = tpr.buyer_id
        inner join agt_traders_places as tpl on tpr.place_id = tpl.id
        inner join regions r on r.id = tpl.obl_id
        inner join agt_traders_products2buyer p2b on p2b.buyer_id = ci.author_id && p2b.acttype = tpr.acttype and p2b.type_id = tpl.type_id and p2b.cult_id = tpr.cult_id
      $where
      order by ci.trader_premium_forward desc, ci.rate_formula desc, ci.trader_sort_forward, ci.title, tpr.dt");

    $traders = [];
    foreach ($tmp as $v)
    {
      $key = $v['place_id'].':'.date('m:Y', strtotime($v['date']));
      $curr = $v['curtype'] ? 'usd' : 'uah';
      if ( !isset($traders[$key]) ) {
        $v['date_show'] = $this->monthNames[date('n', strtotime($v['date']))].' '.date('Y', strtotime($v['date']));
        $traders[$key] = $v;
      }
      $traders[$key]['prices'][$curr] = ['price' => floatval($v['costval']), 'currency' => $v['curtype']];
    }

    return $traders;
  }

  public function getAvgCostByRubric($rubric, $start, $end, $type = null, $region = null, $port = null, $onlyPorts = false, $currency = null) {
    $typeInt         = ($type == 'buy') ? 0 : 1;
    $type            = ($type == 'buy') ? "" : "_sell";
    $currencySql     = ($currency !== null) ? "&& tpr.curtype = $currency" : "";
    $regionSql       = ($region != null) ? "&& tpl.obl_id = $region" : "";
    $portSql         = ($port != null) ? "&& tpl.port_id = $port" : "";
    $onlyPortsSql    = ($onlyPorts != false) ? "&& tpl.port_id != 0" : "";
    $placeSql        = ($region != null || $port != null || $onlyPorts != null) ? "$regionSql $portSql $onlyPortsSql" : "";

    if ($start == $end) {
      $datesql = "&& tpr.dt = '$start'";
    } else {
      $datesql = "&& tpr.dt < '$end' && tpr.dt > '$start'";
    }

    $cost = $this->db->query("
      select round(avg(tpr.costval), 1) as cost
        from agt_traders_prices_arc tpr
        inner join agt_traders_places tpl
          on tpr.place_id = tpl.id $placeSql
      where tpr.cult_id = $rubric $currencySql $datesql
    ")[0]['cost'] ?? null;

    return $cost;
  }

  public function getAnalitic($rubric, $start, $end, $step, $type = null, $region = null, $port = null, $onlyPorts = false, $currency = null) {

    $cols = [];


    switch($step) {
      case "month":
        $cols = $this->makeYearPoints($start, $end);
        break;

      case "week":
        $cols = $this->makeWeekPoints($start, $end);
        break;

      case "day":
        $cols = $this->makeDayPoints($start, $end);
        break;
    }

    $categories = [];
    $data = [];
    $len = count($cols);
    for ($i = 0; $i < $len; $i++ ) {
      $categories[] = $cols[$i]['label'];
      $cost = $this->getAvgCostByRubric($rubric['id'], $cols[$i]['start'], $cols[$i]['end'], $type, $region, $port, $onlyPorts, $currency);

      $data[] = (int) $cost;
    }

    $data = ['name' => $rubric['name'], 'data' => $data];
    return ['data' => [$data], 'categories' => $categories];
  }

  public function makeYearPoints($start, $end) {

    $year = date("Y", $start);
    $month = date("n", $start);

    $cyy = $year;

    $points = [];

    $i = 0;

    while($i <= 24) {
    //echo $cyy.":".$cmm."<br>";
      $cmm = (($month+$i) % 12 == 0 ? 12 : (($month+$i) % 12));
      $points[] = [
        "label" => $this->monthNames[$cmm]." ".sprintf("%04d", $cyy, $cmm, 1),
        "start" => sprintf("%04d-%02d-%02d", $cyy, $cmm, 1),
        "end"   => sprintf("%04d-%02d-%02d", $cyy, $cmm, $this->daysCount[$cmm])
      ];
      if( mktime(0, 0, 0, $cmm, $this->daysCount[$cmm], $cyy) >= $end )
        break;
      $cyy = ( floor($month+$i)/12.0 > 0 ? ($year+floor(($month+$i)/12.0)) : $year );


      $i++;

    }

    return $points;
  }

  public function makeWeekPoints($start, $end) {

    $year = date("Y", $start);
    $month = date("n", $start);

    $curtm = $start;

    $sty = date("Y", $curtm);
    $stm = date("n", $curtm);
    $std = date("j", $curtm);


    $points = [];

    $i = 0;
    while($i < 50) {
      $ctm_st = $curtm + $i*(7*24*3600);
      $ctm_en = $curtm + ($i+1)*(7*24*3600);
      $cmm = date("n", $ctm_st);

      $points[] = [
        "label" => $this->monthNames[$cmm]." ".date("Y", $ctm_st),
        "start" => date("Y-m-d", $ctm_st),
        "end"   => date("Y-m-d", $ctm_en),
      ];

      if( $ctm_en > $end )
        break;

      $i++;
    }

    return $points;
  }

  public function makeDayPoints($start, $end) {
    $curtm = $start;

    $points = [];

    $i = 0;

    while($i < 90) {

      $ctm_st = $curtm + $i*(24*3600);
      $ctm_en = $ctm_st;
      $cmd = date("j", $ctm_st);

      $points[] = [
        "label" => $this->monthNames[date("n", $ctm_st)]." ".$cmd,
        "start" => date("Y-m-d", $ctm_st),
        "end"   => date("Y-m-d", $ctm_en),
      ];

      if( $ctm_en > $end )
        break;

      $i++;
    }

    return $points;
  }

  public function getForwardsMonths() {
    $curtm = time();
    $end = strtotime('+6 month');
    $data = [];
    $i = 0;

    while($i < 90) {
      $ctm_st =  strtotime("+$i month", $curtm);

      $data[] = [
        'label' => $this->monthNames[date('n', $ctm_st)].' '.date('Y', $ctm_st),
        'start' => date('Y-m-01', $ctm_st), // первое число месяца
        'end' => date('Y-m-t', $ctm_st), // последнее число месяца
      ];

      if( $ctm_st >= $end )
        break;

      $i++;
    }

    return $data;
  }
}