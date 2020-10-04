<?php
namespace App\models;

/**
 * 
 */
class Paid extends \Core\Model {

  public function getDocs($user) {
    $docs = $this->db->query("
      select d.*, bf.otitle,
        case
          when b.status = -1
            then 'Отменён'
          when b.status = 0
            then 'Новый'
          when b.status = 1
            then 'Приостановлен'
          when b.status = 2
            then 'В обработке'
          when b.status = 3
            then 'Выполнен'
      end as billstatus, b.amount,
        case 
          when d.doc_type = 0
            then 'Счёт' 
          when d.doc_type = 1
            then 'Акт' 
          when d.doc_type = 2
            then 'Скан-копия' 
      end as docType
        from agt_py_bill_doc d
        left join agt_py_bill b
          on d.bill_id = b.id
        inner join agt_py_bill_firm bf
          on b.payer_ooo_id = bf.id
      where d.buyer_id = $user
      order by d.add_date desc");
    return $docs;
  }

  public function getPayedPacks($user, $type = -1, $mode = "", $sortby = "") {

    $condition = "";
    
    if ($mode == "onlyactive") {
      $condition .= " and ( (bpo.stdt <= now()) && (bpo.endt >= now()) ) ";
    } 
    if (is_array($type) && (count($type) > 1)) {
      $condition .= " and bpo.pack_type IN (".implode(",", $type).") ";
    } elseif ($type != -1) {
      $condition .= " and bpo.pack_type = '$type'";
    }

    $sort = "bpo.endt desc";

    $query = "
      select bpo.*, btp.active, btp.title, btp.cost, btp.adv_num, case when ( (bpo.stdt <= NOW()) && (bpo.endt >= NOW()) ) then 1 else 0 end as nowactive 
        from agt_buyer_packs_orders bpo
        left join agt_buyer_tarif_packs btp
          on bpo.pack_id = btp.id 
      where bpo.user_id = '$user' $condition 
      order by $sort";

    return $this->db->query($query) ?? null;
  }

  public function getPacks($type = -1, $active = true) { 

    $condition = "";
    if (is_array($type) && (count($type) > 1)) {
      $condition .= ($condition != "" ? " and " : " where ")." p.pack_type in (".implode(",", $type).") ";
    } elseif ($type != -1) {
      $condition .= ($condition != "" ? " and " : " where ")." p.pack_type = '$type'";
    }
  
    if ($active) {
      $condition .= ($condition != "" ? " and " : " where ")." p.active = 1";
    }
    
    $result = $this->db->query("select p.* from agt_buyer_tarif_packs p $condition order by p.sort_num");
  
    return $result;
  }

  public function getPack($id) {
    return $this->db->select('agt_buyer_tarif_packs', '*', ['id' => $id])[0] ?? null;
  }

  public function getHistory($user) {
    $payTypes = ['1' => 'Приват 24', '2' => 'Картой', '3' => 'По счету'];
    $list = $this->db->query("
      select pb.*, bpo.post_id, bpo.pack_id, DATE_FORMAT(bpo.stdt, '%d.%m.%Y') as stdtstr, DATE_FORMAT(bpo.endt, '%d.%m.%Y') as endtstr, bpo.comments, atp.title as advtitle, pbd.filename as file
        from agt_py_balance pb
        left join agt_buyer_packs_orders bpo on pb.order_id = bpo.id 
        left join agt_adv_torg_post atp on bpo.post_id = atp.id
        left join agt_py_bill_doc pbd on pbd.bill_id = pb.bill_id
      where pb.buyer_id = $user
      order by pb.add_date desc, pb.amount asc");

    foreach ($list as $key => $value) {
      $list[$key]['purpose'] = '';
      if ($value['oper_debkred'] == 1) {
        $list[$key]['purpose'] = 'Пополнение счета: '.$payTypes[$value['kredit_type']];
      } else {
        if ($value['debit_type'] != 0) {
          $pack = $this->getPack($value['debit_type']);
          if ($pack != null) {
            $list[$key]['purpose'] = $pack['title'];
          }
          if ($value['post_id'] != null) {
            $list[$key]['purpose'] .= ' - <a href="/board/post-'.$value['post_id'].'" target="_blank">'.$value['advtitle'].'</a>';
          }
        }
      }
    }
    return $list;
  }

  public function getPayForm($user, $type, $amount, $packs = null, $advId = 0) {
    $publicKey = 'i7275757847';
    $privateKey = '1hvBdcxiPFKghFS4QuvwRx3BTdWOk4NAYNPGroOy';
    $liqPay = new \Core\LiqPay($publicKey, $privateKey);
    $typeNum = ($type == 'privat24') ? 0 : 1;

    $data = [
      'advId' => $advId,
      'packs' => $packs
    ];
    $json = json_encode($data);
    
    $this->db->insert('agt_py_actions', ['buyer_id' => $user, 'type_id' => ($packs != null) ? 1 : 0, 'serv_id' => 0, 'pack_id' => 0, 'invoice_id' => 0, 'sum_tot' => $amount.'.00', 'sum_pay' => 0, 'add_date' => 'now()', 'paydescr' => $json]);
    $orderId = $this->db->getlastId();

    $data = [
      'version' => 3,
      'action' => 'pay',
      'public_key' => $publicKey,
      'amount' => $amount,
      'currency' => 'UAH',
      'description' => 'Оплата заказа #'.$orderId,
      'order_id' => $orderId,
      'paytypes' => $type,
      'result_url' => 'https://agrotender.com.ua/u/balance/history',
      'server_url' => 'https://agrotender.com.ua/pay'
    ];
    
    $this->response->json(['code' => 1, 'form' => $liqPay->cnb_form($data)]);
  }

  public function makeInvoice($user, $email, $amount, $company, $name, $phone, $entityAddr, $code, $inn, $region, $city, $zip, $addr, $docAddrCheck) {
    if ($company == null) {
      $this->db->insert('agt_py_bill_firm', ['buyer_id' => $user, 'payer_type' => 0, 'add_date' => 'now()', 'bill_addr_id' => 0, 'otitle' => $name]);
      $payerId = $this->db->getlastId();
      $this->db->insert('agt_py_bill', ['buyer_id' => $user, 'paymeth_type' => 3, 'orgtype' => 0, 'add_date' => 'now()', 'amount' => $amount.'.00', 'serv_id' => 0, 'payer_ooo_id' => $payerId, 'payer_addr_id' => 0]);
      $billId = $this->db->getlastId();
    } else {
      if ($docAddrCheck != null) {
        $this->db->insert('agt_py_bill_addr', ['buyer_id' => $user, 'addr_type' => 0, 'add_date' => 'now()', 'obl_id' => $region, 'city' => $city, 'zip' => $zip, 'address' => $addr]);
        $addrId = $this->db->getlastId();
        $this->db->insert('agt_py_bill_firm', ['buyer_id' => $user, 'payer_type' => 1, 'add_date' => 'now()', 'bill_addr_id' => $addrId, 'otitle' => $company, 'oipn' => $inn, 'okode' => $code, 'address' => $entityAddr, 'obl_id' => $region, 'city' => $city, 'zip' => $zip]);
        $payerId = $this->db->getlastId();
      } else {
        $this->db->insert('agt_py_bill_firm', ['buyer_id' => $user, 'payer_type' => 1, 'add_date' => 'now()', 'bill_addr_id' => 0, 'otitle' => $company, 'oipn' => $inn, 'okode' => $code, 'address' => $entityAddr, 'obl_id' => '', 'city' => '', 'zip' => '']);
        $payerId = $this->db->getlastId();
      }
      $this->db->insert('agt_py_bill', ['buyer_id' => $user, 'paymeth_type' => 3, 'orgtype' => 1, 'add_date' => 'now()', 'amount' => $amount.'.00', 'serv_id' => 0, 'payer_ooo_id' => $payerId, 'payer_addr_id' => $payerId]);
      $billId = $this->db->getlastId();
    }
    $invoiceTpl = $this->view->setData(['id' => $billId, 'name' => $name, 'amount' => $amount])->fetch('user/invoice');
    $randNum = rand(1001,9999);     
        
    $dateFolder = date('Y')."_".date('m')."/";
        
    if (!file_exists(PATH['invoices'].$dateFolder)) {
      mkdir(PATH['invoices'].$dateFolder, 0755);
    }
    $file = PATH['invoices'].$dateFolder."bill_{$billId}_".date('Y_m_d')."_$randNum.pdf";
    // Make PDF
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($invoiceTpl);
    $mpdf->Output($file,'F');
    // add file to database
    $this->db->insert('agt_py_bill_doc', ['buyer_id' => $user, 'bill_id' => $billId, 'doc_type' => 0, 'sum_tot' => $amount.".00", 'filename' => "billdocs/{$dateFolder}bill_{$billId}_".date('Y_m_d')."_$randNum.pdf", 'add_date' => 'now()']);
    // send email notififcation
    $emailTemplate = $this->view->setData(['amount' => $amount, 'id' => $billId, 'file' => $dateFolder."bill_{$billId}_".date('Y_m_d')."_$randNum.pdf"])->fetch('email/invoice');
    $this->model('utils')->mail($email, 'Счёт на оплату услуг', $emailTemplate);

    $this->response->json(['file' => "billdocs/{$dateFolder}bill_{$billId}_".date('Y_m_d')."_$randNum.pdf", 'id' => $billId]);
  }

  public function payBalance($data, $sign) {
    $this->session->delete('id');
    $privateKey = '1hvBdcxiPFKghFS4QuvwRx3BTdWOk4NAYNPGroOy';
    if ($sign != base64_encode(sha1($privateKey .  $data . $privateKey, 1))) {
      $this->response->json(['code' => 0, 'text' => 'incorrect signature']);
    }

    $data = json_decode(base64_decode($data), true);

    $order    = $this->db->select('agt_py_actions', '*', ['id' => $data['order_id']])[0];
    $jsonData = json_decode(htmlspecialchars_decode($order['paydescr']), true);

    if ($data['status'] == 'success') {
      $this->db->insert('agt_py_bill', ['buyer_id' => $order['buyer_id'], 'paymeth_type' => ($data['paytype'] == 'privat24') ? 1 : 2, 'orgtype' => 0, 'add_date' => 'now()', 'amount' => $order['sum_tot'], 'serv_id' => 0, 'payer_ooo_id' => 0, 'payer_addr_id' => 0, 'status' => 3]);
      $orderId = $this->db->getlastId();

      $this->db->insert('agt_py_balance', ['buyer_id' => $order['buyer_id'], 'bill_id' => $orderId, 'oper_by' => 0, 'oper_debkred' => 1, 'kredit_type' => ($data['paytype'] == 'privat24') ? 1 : 2, 'debit_type' => 0, 'amount' => $order['sum_tot'], 'add_date' => 'now()']);

      $packs = explode(',', $jsonData['packs']);
       if ($packs != null) {
        $this->session->set('id', $order['buyer_id']);
        $this->payPacks($packs, $jsonData['advId'], 1);
      }
    }
    
  }

  public function payPacks($packs, $advId = 0, $card = null) {

    $user = $this->model('user');

    if ($advId != 0) {
      $advert = $this->model('board')->getAdvert($advId);
      if ($advert == null) {
        $this->response->json(['code' => 0, 'text' => "Объявления #{$advId} не существует."]);
      } 
      if ($advert['author_id'] != $user->id) {
        $this->response->json(['code' => 0, 'text' => 'Платные услуги доступны только для своих объявлений.']);
      }
      if (count($packs) == 1 && $packs[0] == 13 && strtotime($advert['updt']) <= strtotime("-7 days")) {
        $this->db->update('agt_adv_torg_post', ['up_dt' => 'now()', 'upnotif_dt' => null], ['id' => $advId]);
        $this->response->json(['code' => 1, 'text' => '']);
        exit;
      }
    } 
    
    $packsNumbers = [];
    $total = 0;
    foreach ($packs as $key => $pack) {
      $packsNumbers[] = $pack;
      $pack = $this->getPack($pack);
      if ($pack != null) {
        $total += round($pack['cost']);
        $packs[$key] = $pack;
      }
    }
    if ($total == 0) {
      $this->response->json(['code' => 0, 'text' => 'Ошибка. Попробуйте снова.']);
    }
    $emailData = [];
    if ($user->balance >= $total) {

      foreach ($packs as $key => $pack) {
        // dates
        $startDate = date("Y-m-d H:i:s", time());
        $intervals = [0 => "day", 1 => "month", 2 => "year"];
        $interval = $intervals[$pack['period_type']];
        $endDate  = date('Y-m-d H:i:s', strtotime($startDate . " +{$pack['period']} $interval"));
        // email data
        $emailData[$key]['title'] = $pack['title'];
        $emailData[$key]['date'] = $endDate;

        // comment 
        $comment = ($card == null) ? 'Оплата с внутреннего счета' : 'Оплата с внутреннего счета при оплате картой';
        // add order to database
        $this->db->insert('agt_buyer_packs_orders', ['user_id' => $user->id, 'post_id' => $advId, 'pack_type' => $pack['pack_type'], 'pack_id' => $pack['id'], 'add_date' => 'now()', 'comments' => $comment, 'stdt' => $startDate, 'endt' => $endDate, 'adv_avail' => ($pack['adv_num'] == 1) ? 0 : $pack['adv_num']]);
        $orderId = $this->db->getlastId();
        $this->db->insert('agt_py_balance', ['buyer_id' => $user->id, 'bill_id' => 0, 'oper_by' => 0, 'oper_debkred' => 0, 'kredit_type' => 0, 'debit_type' => $pack['id'], 'amount' => "-{$pack['cost']}", 'add_date' => 'now()', 'order_id' => $orderId]);
        // activate pack
        switch ($pack['pack_type']) {
          case '1':
            $this->db->update('agt_adv_torg_post', ['targeting' => 1], ['id' => $advId]);
            break;
          
          case '2':
            $this->db->update('agt_adv_torg_post', ['up_dt' => 'now()', 'upnotif_dt' => null], ['id' => $advId]);
            break;

          case '3':
            $this->db->update('agt_adv_torg_post', ['colored' => 1], ['id' => $advId]);
            break;
        }
      }
      $mailTemplate = $this->view->setData(['emailData' => $emailData])->fetch('email/activatePaid');
      $this->model('utils')->mail($user->email, 'Активация платных услуг выполнена', $mailTemplate);
      $this->response->json(['code' => 1, 'text' => '']);
    } else {
      $needle = abs(intval($user->balance - $total));
      $this->response->json(['code' => 2, 'text' => '', 'payAdv' => $advId, 'payPacks' => implode(',', $packsNumbers), 'payAmount' => $needle]);
    }
  }

}