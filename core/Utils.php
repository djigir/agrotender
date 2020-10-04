<?php
namespace Core;

class Utils {


  public static function getCaller($offset = 0) {
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

  public function getMenu($page) {
    $params = [
      [['board/index', 'board/advert'], '/board.html', 'Объявления'],
      [['main/companies', 'main/companies-r', 'main/companies-s'], '/kompanii.html', 'Компании'],
      [['main/traders', 'main/traders-s', 'main/analitic', 'main/analitic-s'], ' /traders/region_ukraine.html', 'ЦеныТрейдеров'],
      // [['main/traders-f'], '/traders_forwards.html', 'Форварды'],
      [['main/elev', 'main/elev-item'], '/elev.html', 'Элеваторы']
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

  public function mail($to, $subject, $message, $attach = null) {

    require PATH['core'] . 'PHPMailer.php';

    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->SMTPAuth    = true;
    $mail->SMTPSecure  = "ssl";
    $mail->SMTPAutoTLS = false;
    $mail->Host        = "mail.weelinc.com";
    $mail->Port        = 465;
    $mail->Username    = "test@weelinc.com";
    $mail->Password    = "Qiwi224300";
    $mail->SetFrom("test@weelinc.com",'АгроТендер');
    $mail->FromName    = "АгроТендер";
    $mail->CharSet     = 'UTF-8';
    $mail->IsHTML(true);
    $mail->Body        = $message;
    $mail->AltBody     = strip_tags(str_replace("<br/>", "\n", $mail->Body));
    $mail->Subject     = $subject;

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
    return (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str));
  }

  public function getRegions() {

    $regions = $this->db->query("select * from regions group by id");
    return $regions;
  }

}