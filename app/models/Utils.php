<?php
namespace App\models;
/**
 *
 */
class Utils extends \Core\Model {

  public function numDecline($number, $titles, $param2 = '', $param3 = '') {

    if( $param2 )
      $titles = [ $titles, $param2, $param3 ];

    if( is_string($titles) )
      $titles = preg_split( '/, */', $titles );

    if( empty($titles[2]) )
      $titles[2] = $titles[1]; // когда указано 2 элемента

    $cases = [ 2, 0, 1, 1, 1, 2 ];

    $intnum = abs( intval( strip_tags( $number ) ) );

    return "$number ". $titles[ ($intnum % 100 > 4 && $intnum % 100 < 20) ? 2 : $cases[min($intnum % 10, 5)] ];
  }

  public function getBanners() {
    $top = $this->db->query("select br.* from agt_banner_rotate br where dt_start <= now() and dt_end >= now() and archive = 0 and inrotate = 1 and place_id = 43 order by rand() limit 3");
    $bottom = $this->db->query("select br.* from agt_banner_rotate br where dt_start <= now() and dt_end >= now() and archive = 0 and inrotate = 1 and place_id = 10 order by rand() limit 1");
    $body = $this->db->query("select br.* from agt_banner_rotate br where dt_start <= now() and dt_end >= now() and archive = 0 and inrotate = 1 and place_id = 44 order by rand() limit 1");
    $header = $this->db->query("select br.* from agt_banner_rotate br where dt_start <= now() and dt_end >= now() and archive = 0 and inrotate = 1 and place_id = 45 order by rand() limit 1");
    $traders = $this->db->query("select br.* from agt_banner_rotate br where dt_start <= now() and dt_end >= now() and archive = 0 and inrotate = 1 and place_id = 46 order by rand() limit 1");
    $banners = [
      'top' => [],
      'bottom' => [],
      'body'   => [],
      'header' => [],
      'traders' => []
    ];

    foreach ($top as $banner) {
      $agropos = strpos($banner['ban_link'], "agrotender.com.ua");
      $blank = ($agropos === FALSE) ? ' target="_blank"' : '';
      $banners['top'][] = '<div class="d-block d-sm-inline-block tradersImgBlock" ><noindex><a class="topBanners" href="'.$banner['ban_link'].'" rel="nofollow"'.$blank.'><img style="width:310px; height:70px;" id="topBan'.$banner['id'].'" src="/files/'.$banner['ban_file'].'" class="img-responsive tradersImg" alt="" /></a></noindex></div>';
    }
    foreach ($bottom as $banner) {
      $agropos = strpos($banner['ban_link'], "agrotender.com.ua");
      $blank = ($agropos === FALSE) ? ' target="_blank"' : '';
      $banners['bottom'][] = '<div class="d-block d-sm-inline-block mx-2 position-relative" ><noindex><a class="bottomBanners" href="'.$banner['ban_link'].'" rel="nofollow"'.$blank.'><img style=" height:120px;" src="/files/'.$banner['ban_file'].'" class="tradersImgBottom" id="bottom-b"></a></noindex></div>';
    }
    foreach ($body as $banner) {
      $agropos = strpos($banner['ban_link'], "agrotender.com.ua");
      $blank = ($agropos === FALSE) ? ' target="_blank"' : '';
      $banners['body'][] = '<a href="'.$banner['ban_link'].'" id="body'.$banner['id'].'" class="sidesLink bodyBanners" style="background: url(\'/files/'.$banner['ban_file'].'\')" rel="nofollow"'.$blank.'> <img src="/files/'.$banner['ban_file'].'" alt=""> </a>';
    }
    foreach ($header as $banner) {
      $agropos = strpos($banner['ban_link'], "agrotender.com.ua");
      $blank = ($agropos === FALSE) ? ' target="_blank"' : '';
      $banners['header'][] = '<div class=""  style="z-index:2; width:100%;"><noindex><a class="" href="'.$banner['ban_link'].'" rel="nofollow"'.$blank.'><img style="height:30px;width:100%;" src="/files/'.$banner['ban_file'].'" class="" id=""></a></noindex></div>';
    }
        foreach ($traders as $banner) {
      $agropos = strpos($banner['ban_link'], "agrotender.com.ua");
      $blank = ($agropos === FALSE) ? ' target="_blank"' : '';
      $banners['traders'][] = '<div class="d-block d-sm-inline-block mx-2 position-relative"  ><noindex><a class="bottomBanners" href="'.$banner['ban_link'].'" rel="nofollow"'.$blank.'><img style="width:960px; height:120px;" src="/files/'.$banner['ban_file'].'" class="tradersImgBottom" id="bottom-b"></a></noindex></div>';
    }
    return $banners;
  }

  public static function getHash($length = 24) {

    $characters = '0123456789';
    $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    $charactersLength = strlen($characters)-1;
    $token = '';

    for ($i = 0; $i < $length; $i++) {
      $token .= $characters[mt_rand(0, $charactersLength)];
    }

    return $token;
  }

  public function getCaller($offset = 0) {
    $baseOffset = 2;
    $offset += $baseOffset;
    $backtrace = debug_backtrace();
    $caller = array();
    if(isset($backtrace[$offset])) {
        $backtrace = $backtrace[$offset];
        if(isset($backtrace['class'])) {
            $caller['class'] = $backtrace['class'];
        }
        if(isset($backtrace['function'])) {
            $caller['function'] = $backtrace['function'];
        }
    }
    return $caller;
  }

  public function fillChunk($array, $parts) {
    $t = 0;
    $result = array_fill(0, $parts - 1, []);
    $max = ceil(count($array) / $parts);
    foreach($array as $v) {
      count($result[$t]) >= $max and $t ++;
      $result[$t][] = $v;
    }
    return $result;
  }

  public function getCompanyMenu($page, $company) {
    $user = $this->model('user');
    $params = [
      ['company/main', '/kompanii/comp-'.$company['id'], 'Главная'],
      ['company/prices', '/kompanii/comp-'.$company['id'].'-prices', 'Цены трейдера'],
      ['company/forwards', '/kompanii/comp-'.$company['id'].'-forwards', 'Форварды'],
      ['company/reviews', '/kompanii/comp-'.$company['id'].'-reviews', 'Отзывы'],
      [['company/news', 'company/newsItem'], '/kompanii/comp-'.$company['id'].'-news', 'Новости'],
      ['company/contacts', '/kompanii/comp-'.$company['id'].'-cont', 'Контакты'],
      ['company/adverts', '/kompanii/comp-'.$company['id'].'-adverts', 'Объявления'],
      ['company/vacancy', '/kompanii/comp-'.$company['id'].'-vacancy', 'Вакансии']
    ];

    $html       = '';

    foreach ($params as $param) {
      if ($param[0] == ['company/news', 'company/newsItem'] && ($company['news'] == null or count($company['news']) == 0)) {
        continue;
      }
      if ($param[0] == 'company/vacancy' && ($company['vacancy'] == null or count($company['vacancy']) == 0)) {
        continue;
      }
      if ($param[0] == 'company/prices' && (($company['trader_price_avail'] == 0 or $company['trader_price_visible'] == 0) && ($company['trader_price_sell_avail'] == 0 or $company['trader_price_sell_visible'] == 0))) {
        continue;
      }
      if ($param[0] == 'company/forwards' && ($company['trader_price_forward_avail'] == 0 || $company['trader_price_forward_visible'] == 0)) {
        continue;
      }
      if ($param[0] == 'company/adverts' && $company['advertsCount'] == 0) {
        continue;
      }
      $url = $param[1];
      /*if ($param[0] == ['user/prices', 'user/pricesContacts']) {
        if ($user->company['trader_price_avail'] == 0) {
          $url = $param[1].'?type=1';
        }
      } */
      $active      = (is_array($param[0])) ? (in_array($page, $param[0])) ? " active" : "" : ($param[0] == $page) ? " active" : "";
      $html .= '<a href="'.$url.'" class="'.$active.'">'.$param[2].'</a>';
    }

    return ['menu' => $html];
  }

  public function getProfileMenu($page) {
    $user = $this->model('user');
    $params = [
      [['user/main', 'user/contacts', 'user/notify', 'user/reviews', 'user/company', 'user/news', 'user/vacancy'], '/u/', 'Профиль'],
      ['user/posts', '/u/posts', 'Объявления'],
      ['user/proposeds', '/u/proposeds', 'Заявки'],
      [['user/prices', 'user/pricesContacts', 'user/pricesForward'], '/u/prices', 'Цены трейдера'],
      [['user/limits', 'user/upgrade', 'user/payBalance', 'user/historyBalance', 'user/docsBalance'], '/u/posts/limits', 'Тарифы']
    ];

    $html       = '';
    $mobileHtml = '';

    foreach ($params as $param) {
      if ($param[1] == '/u/prices' && ($user->company == null or ($user->company['trader_price_avail'] == 0 && $user->company['trader_price_sell_avail'] == 0 && $user->company['trader_price_forward_avail'] == 0))) {
        continue;
      }
      $url = $param[1];
      if ($param[1] == '/u/prices' && $user->company['trader_price_avail'] == 0) {
        $url .= '?type=1';
      }
      $active      = (is_array($param[0])) ? (in_array($page, $param[0])) ? " active" : "" : ($param[0] == $page) ? " active" : "";
      if ($param[0] == 'user/proposeds') {
        $html .= '<a href="'.$url.'" class="position-relative'.$active.'">'.$param[2].' <span class="notification-badge top-badge"></span></a>';
      } else {
        $html .= '<a href="'.$url.'" class="'.$active.'">'.$param[2].'</a>';
      }
    }

    return ['menu' => $html];
  }

  public function getMenu($page) {
    $params = [
      [['board/index', 'board/advert'], '/board', 'Объявления'],
      [['main/companies', 'main/companies-r', 'main/companies-s'], '/kompanii', 'Компании'],
      [['main/traders', 'main/traders-s', 'main/analitic', 'main/analitic-s'], '/traders', 'Цены Трейдеров'],
      // [['main/traders-f'], '/traders_forwards', 'Форварды'],
      [['main/elev', 'main/elev-item'], '/elev', 'Элеваторы']
    ];

    $html       = '';
    $mobileHtml = '';

    foreach ($params as $param) {
      $active      = (is_array($param[0])) ? (in_array($page, $param[0])) ? " active" : "" : ($param[0] == $page) ? " active" : "";
      $html       .= '<li><a href="'.$param[1].'" class="menu-link'.$active.'">'.$param[2].'</a></li>';
      $mobileHtml .= '<a href="'.$param[1].'" class="'.$active.'">'.$param[2].'</a></li>';
    }

    return ['mobile' => $mobileHtml, 'desktop' => $html];
  }


  public function sendSms($phone, $message, $ip) {
    $sms_sender = "Agrotender";
    $sms_host = "atompark.com";
    $sms_login = "id.agrotender@gmail.com";
    $sms_pass = "Kpc-tB8-D37-rjj";

    $sms_path = "members/sms/xml.php";
    $sms = new \Core\SmsAPI($sms_host, $sms_login, $sms_pass, $sms_path);
    // send sms
      // убрать комменты для работы смс
//    $sms->sendRequest("send", ['phones' => [$phone], 'sender' => $sms_sender, 'msg' => $message]);
      if ($sms->request_status > 0) {
      // add to logs
//      $this->db->insert('agt_sms_log', ['phone' => $phone, 'msg' => $message, 'ip' => $ip]);
      return true;
    } else {
          return true;
//      $this->response->json(['code' => 0, 'text' => 'Ошибка при отправке смс. <br>Попробуйте снова.']);
    }

  }

  public function mail($to, $subject, $message, $attach = null) {

    $mail = new \Core\PHPMailer(true);
    $mail->IsSMTP();
    $mail->SMTPAuth    = true;
    $mail->SMTPSecure  = "ssl";
    $mail->SMTPAutoTLS = true;
/*
    $mail->Host        = "hqua0089301.online-vm.com";
//    $mail->Host        = "31.131.24.195";
    $mail->Port        = 465;
    $mail->Username    = "info@agrotender.com.ua";
//    $mail->Password    = "dfh74QE56jhP";
    $mail->Password    = "XzoG9WL]yCpu";
*/
    $mail->Host        = "mail.agrotender.com.ua";
    $mail->Port        = 465;
    $mail->Username    = "info@agrotender.com.ua";
    $mail->Password    = "fxIxuZwOhv";

    $mail->SetFrom("info@agrotender.com.ua",'АгроТендер');
    $mail->From = "info@agrotender.com.ua";
    $mail->FromName    = "АгроТендер";
    $mail->CharSet     = 'UTF-8';
    $mail->IsHTML(true);
    $mail->Body        = $message;
    $mail->AltBody     = strip_tags(str_replace("<br/>", "\n", $mail->Body));
    $mail->Subject     = $subject;
    $mail->Debug = true;
//$mail->SMTPDebug = 2;

    $emails = array_map('trim',explode(',',$to));

    foreach ($emails as $email) {
      $mail->AddAddress($email);
    }

    if ($attach != null) {
      foreach ($attach as $a) {
        $mail->AddAttachment($a);
      }
    }

    $sent = $mail->Send();
    return $sent;
  }

  public function emailValidate($str) {
    return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,7})$^", $str);
  }

  public function getRegions() {
    $regions = $this->db->query("select * from regions group by id");
    return $regions;
  }

}
