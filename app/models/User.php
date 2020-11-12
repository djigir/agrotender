<?php
namespace App\models;

/**
 *
 */
class User extends \Core\Model {

    public $auth = false;
    public $id = 0;
    public $name = 'Гость';
    public $company = null;
    public $balance = 0;
    public $active = 0;
    public $limits = [
        'avail'      => 0,
        'max'        => 50,
        'payedAvail' => 0
    ];

    public function __construct() {
        // user params
        $this->auth = $this->isAuth();
        $this->ip = $this->getIp();
        // get super utils ;)
        $this->utils = $this->model('utils');
    }

    public function getIp() {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }

    public function isAuth() {
        $id   = $this->session->get('id');
        $hash = $this->cookie->get('hash');
        if ($id != null) {
            $this->id = $id;
            $user = $this->db->query("select login, name, name2, name3, city, obl_id, email, subscr_adv_up, subscr_adv_deact, isactive_web, avail_adv_posts, max_adv_posts, phone, phone2, phone3, telegram, viber, smschecked from agt_torg_buyer where id = $id")[0] ?? null;
        } elseif ($hash != null) {
            $user = $this->db->select('agt_torg_buyer', ['id', 'login', 'name', 'name2', 'name3', 'city', 'obl_id', 'email', 'subscr_adv_up', 'subscr_adv_deact', 'isactive_web', 'avail_adv_posts', 'max_adv_posts', 'phone', 'phone2', 'phone3', 'telegram', 'viber', 'smschecked'], ['hash' => $hash])[0] ?? null;
            if ($user != null) {
                $this->id = $user['id'];
            }
        } else {
            $user = null;
        }
        if ($user != null) {
            $this->email        = $user['login'];
            $this->name         = $user['name'];
            $this->name2        = $user['name2'];
            $this->name3        = $user['name3'];
            $this->active       = $user['isactive_web'];
            $this->activePhone  = $user['smschecked'];
            $this->balance      = $this->db->query("select round(coalesce(sum(amount), 0)) as balance from agt_py_balance where buyer_id = {$this->id}")[0]['balance'];
            $this->company      = $this->db->select("agt_comp_items", '*', ['author_id' => $this->id])[0] ?? null;
            if ($this->company != null) {
                $this->company['topics'] = [];
                $topics = $this->db->select('agt_comp_item2topic', 'topic_id', ['item_id' => $this->company['id']]);
                foreach ($topics as $topic) {
                    array_push($this->company['topics'], $topic['topic_id']);
                }
            }
            $this->phone        = $user['phone'];
            $this->phone2       = $user['phone2'];
            $this->phone3       = $user['phone3'];
            $this->telegram     = $user['telegram'];
            $this->viber        = $user['viber'];
            $this->region       = $user['obl_id'];
            $this->publicEmail  = $user['email'];
            $this->city         = $user['city'];
            $this->sub          = ['up' => $user['subscr_adv_up'], 'deact' => $user['subscr_adv_deact']];
            // user limits
            $this->limits['avail'] += $user['avail_adv_posts'];
            // limits packs
            $packs = $this->model('paid')->getPayedPacks($this->id, 0, "onlyactive");
            foreach ($packs as $pack) {
                $this->limits['max'] += $pack['adv_num'];
                $this->limits['payedAvail'] += $pack['adv_avail'];
                $this->limits['avail'] += $pack['adv_avail'];
            }
            return true;
        } else {
            return false;
        }
    }

    public function viewedProposeds() {
        $this->db->query("update agt_messenger_p2p set viewed = 1, view_date = now() where to_id = {$this->company['id']}");
    }

    public function cancelProposed($id) {
        $this->db->update('agt_messenger_p2p', ['status' => '-1'], ['item_id' => $id, 'to_id' => $this->company['id']]);
        $this->response->json(['code' => 1, 'text' => 'Заявка отклонена.']);
    }

    public function removeProposed($id) {
        $proposed = $this->db->select('agt_messenger', 'id', ['id' => $id, 'from_id' => $this->id])[0]['id'] ?? null;
        if ($proposed == null) {
            $this->response->json(['code' => 0, 'text' => 'Такой заявки не существует.']);
        }
        $this->db->delete('agt_messenger', ['id' => $id]);
        $this->db->delete('agt_messenger_p2p', ['item_id' => $id]);
        $this->response->json(['code' => 1, 'text' => 'Заявка удалена.']);
    }

    public function acceptProposed($id, $companies) {
        $proposed = $this->db->select('agt_messenger', 'id', ['id' => $id, 'from_id' => $this->id])[0]['id'] ?? null;
        if ($proposed == null) {
            $this->response->json(['code' => 0, 'text' => 'Такой заявки не существует.']);
        }
        foreach ($companies as $key => $company) {
            $this->db->update('agt_messenger_p2p', ['status' => 1], ['to_id' => $company, 'item_id' => $id]);
        }
        $this->db->update('agt_messenger', ['status' => 1], ['id' => $id]);
        $this->response->json(['code' => 1, 'text' => 'Продажа подтверждена.']);
    }

    public function getProposedsCount() {
        $count = [
            'send' => $this->db->query("select count(id) as count from agt_messenger where from_id = {$this->id}")[0]['count'] ?? 0,
            'rec'  => $this->db->query("select count(id) as count from agt_messenger_p2p where to_id = {$this->company['id']}")[0]['count'] ?? 0
        ];
        return $count;
    }

    public function getNewProposeds() {
        $count = $this->db->query("select count(id) as count from agt_messenger_p2p where to_id = {$this->company['id']} && viewed = 0")[0]['count'] ?? 0;
        return $count;
    }

    public function getReceivedProposeds($count, $page = 1, $status) {
        $status = ($status != 0) ? ($status == '-1') ? '&& (p2p.status = -1 or p2p.status = 1)' : '&& p2p.status = 0' : '';
        $totalProposeds = $this->db->query("
      select count(id) as count
        from agt_messenger_p2p p2p
      where to_id = {$this->company['id']} $status")[0]['count'] ?? 0;
        // find the total number of pages
        $totalPages = intval(($totalProposeds - 1) / $count) + 1;
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
        $proposeds = $this->db->query("
      select m.*, date_format(m.add_date, '%d.%m.%Y в %H:%i') as add_date, tpl.name as rubric, r.name as region, ci.id as company_id, p2p.status as p_status, p2p.viewed
        from agt_messenger_p2p p2p
        inner join agt_messenger m
          on m.id = p2p.item_id
        inner join agt_traders_products tp
          on m.cult_id = tp.id
        inner join agt_traders_products_lang tpl
          on tp.id = tpl.item_id
        inner join agt_torg_buyer tb
          on tb.id = m.from_id
        inner join regions r
          on r.id = m.obl_id
        left join agt_comp_items ci
          on ci.author_id = tb.id
      where p2p.to_id = {$this->company['id']} $status
      order by p2p.add_date desc
      limit $start, $count");
        return ['proposeds' => $proposeds, 'totalPages' => $totalPages ?? 1];
    }

    public function getProposedCompanies($id) {
        $proposed = $this->db->select('agt_messenger', 'id', ['id' => $id, 'from_id' => $this->id])[0]['id'] ?? null;
        if ($proposed == null) {
            $this->response->json(['code' => 0, 'text' => 'Такой заявки не существует.']);
        }
        $companies = $this->db->query("
      select p2p.to_id as company_id, case when p2p.viewed = 0 then 'Не просмотрено' when p2p.viewed = 1 then concat('<a href=\"#\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"', p2p.view_date, '\">Просмотрено</a>') when p2p.status = '-1' then 'Отклонено' end as status, p2p.view_date, ci.title as company
        from agt_messenger_p2p p2p
        inner join agt_comp_items ci
          on ci.id = p2p.to_id
      where p2p.item_id = $id");
        $this->response->json(['code' => 1, 'text' => 'Список компаний получен.', 'companies' => $companies]);
    }

    public function getSendProposeds($status) {
        $status = ($status != 0) ? ($status == '-1') ? '&& m.status = 1' : '&& m.status = 0' : '';
        $query = "
      select m.*, date_format(m.add_date, '%d.%m.%Y в %H:%i') as add_date, tpl.name as rubric, r.name as region
        from agt_messenger m
        inner join agt_traders_products tp
          on m.cult_id = tp.id
        inner join agt_traders_products_lang tpl
          on tp.id = tpl.item_id
        inner join regions r
          on r.id = m.obl_id
      where m.from_id = {$this->id} $status
      order by m.add_date desc";
        $proposeds = $this->db->query($query);
        return ['proposeds' => $proposeds];
    }

    public function getRegions() {
        return $this->db->select('regions');
    }

    public function saveCompany($title, $logo, $content, $zipcode, $region, $city, $addr, $rubrics) {
        if ($title == null) {
            $this->response->json(['code' => 0, 'text' => 'Введите название компании.']);
        }
        if ($content == null) {
            $this->response->json(['code' => 0, 'text' => 'Введите описание компании.']);
        }
        if (count($rubrics) == 0) {
            $this->response->json(['code' => 0, 'text' => 'Необходимо обязательно выбрать хотя бы один вид деятельности для компании.']);
        }
        if (count($rubrics) > 5) {
            $this->response->json(['code' => 0, 'text' => 'Вы не можете выбрать более 5 видов деятельности для компании.']);
        }
        $compshort = $content;
        if (mb_strlen($content) > 210) {
            $strpos = strpos($compshort, " ", 200);
            if ($strpos > 0) {
                $compshort = substr($compshort, 0, $strpos);
            } else {
                $compshort = substr($compshort, 0, 200);
            }
        }

        if ($this->company == null) {
            if ($logo['error'] == 0) {
                $tmp      = $logo['tmp_name'];
                $type     = explode('/', $logo['type'])[0];
                if ($type != 'image') {
                    $this->response->json(['code' => 0, 'text' => 'Только картинка может быть логотипом.']);
                }
                $filename = $this->model('utils')->getHash(12).'.'.pathinfo($logo['name'])['extension'];
                move_uploaded_file($tmp, PATH['root'].'/pics/c/'.$filename);
                $filename = 'pics/c/'.$filename;
            } else {
                $filename = '';
            }

            $this->db->insert('agt_comp_items', ['author_id' => $this->id, 'topic_id' => 0, 'type_id' => 0, 'obl_id' => $region, 'ray_id' => 0, 'title' => $title, 'title_full' => '', 'city' => $city, 'phone' => '', 'phone2' => '', 'phone3' => '', 'email' => '', 'www' => '', 'zipcode' => $zipcode, 'addr' => $addr, 'add_date' => 'now()', 'content' => $content, 'short' => $compshort, 'contacts' => '', 'logo_file' => $filename]);
            $compId = $this->db->getLastId();
            foreach ($rubrics as $rubric) {
                $this->db->insert('agt_comp_item2topic', ['topic_id' => $rubric, 'item_id' => $compId, 'add_date' => 'now()']);
            }
            $mailTemplate = $this->view->setData(['id' => $compId])->fetch('email/createCompany');
            $this->model('utils')->mail($this->email, 'Ваша компания создана', $mailTemplate);
            $this->response->json(['code' => 1, 'text' => 'Компания успешно создана.']);
        } else {
            if ($logo['error'] == 0) {
                $tmp      = $logo['tmp_name'];
                $type     = explode('/', $logo['type'])[0];
                if ($type != 'image') {
                    $this->response->json(['code' => 0, 'text' => 'Только картинка может быть логотипом.']);
                }
                $filename = $this->model('utils')->getHash(12).'.'.pathinfo($logo['name'])['extension'];
                move_uploaded_file($tmp, PATH['root'].'/pics/c/'.$filename);
                if ($this->company['logo_file'] != null) {
                    unlink(PATH['root'].'/'.$this->company['logo_file']);
                }
                $filename = 'pics/c/'.$filename;
            } else {
                $filename = $this->company['logo_file'];
            }
            $this->db->update('agt_comp_items', ['obl_id' => $region, 'title' => $title, 'city' => $city, 'zipcode' => $zipcode, 'addr' => $addr, 'content' => $content, 'short' => $compshort, 'logo_file' => $filename], ['id' => $this->company['id']]);
            $this->db->delete('agt_comp_item2topic', ['item_id' => $this->company['id']]);
            foreach ($rubrics as $rubric) {
                $this->db->insert('agt_comp_item2topic', ['topic_id' => $rubric, 'item_id' => $this->company['id'], 'add_date' => 'now()']);
            }
            $this->response->json(['code' => 1, 'text' => 'Компания обновлена.']);
        }
    }

    public function setCompanyVisible($visible) {
        $this->db->update('agt_comp_items', ['visible' => $visible], ['id' => $this->company['id']]);
        $this->response->json(['code' => 1]);
    }

    public function getReviews($type, $author = null, $company = null) {
        if ($type == 0) {
            $query = "
        select cc.add_date, cc.rate, cc.author, datediff(now(), cc.add_date) as daydiff, ccl.content, ccl.content_plus, ccl.content_minus, ci.title, ci.logo_file, ci.id as compId
          from agt_comp_comment cc
          inner join agt_comp_comment_lang ccl
            on ccl.item_id = cc.id
          inner join agt_comp_items ci
            on ci.id = cc.item_id
        where cc.author_id = $author && cc.visible = 1 && cc.reply_to_id = 0
        order by cc.add_date desc";
        } else {
            $query = "
      select cc.id, cc.add_date, cc.rate, cc.author, datediff(now(), cc.add_date) as daydiff, ccl.content, ccl.content_plus, ccl.content_minus, ci.title, ci.logo_file, ci.id as compId, rc.text as comment
        from agt_comp_comment cc
        inner join agt_comp_comment_lang ccl
          on ccl.item_id = cc.id
        left join agt_comp_items ci
          on ci.author_id = cc.author_id
        left join review_comments rc
          on rc.review = cc.id
      where cc.item_id = $company && cc.visible = 1 && cc.reply_to_id = 0
      order by cc.add_date desc";
        }
        $reviews = $this->db->query($query);
        return $reviews;
    }

    public function removePriceSub($id) {
        $this->db->delete('agt_traders_subscr', ['id' => $id, 'buyer_id' => $this->id]);
        $this->response->json(['code' => 1, 'text' => 'Подписка удалена.']);
    }

    public function upPriceSub($id) {
        $this->db->update('agt_traders_subscr', ['until_date' => 'date_add(now(), interval 90 day)', 'is_active' => 1], ['id' => $id, 'buyer_id' => $this->id]);
        $this->response->json(['code' => 1, 'text' => 'Подписка обновлена.']);
    }

    public function addPriceSub($rubric, $period) {
        $this->db->insert('agt_traders_subscr', ['buyer_id' => $this->id, 'cult_id' => $rubric, 'add_date' => 'now()', 'until_date' => 'date_add(now(), interval 90 day)', 'is_active' => 1, 'period' => $period]);
        $this->response->json(['code' => 1, 'text' => 'Рубрика добавлена.']);
    }

    public function getActiveSub() {
        $list = $this->db->query("
      SELECT sub1.id as subid, sub1.is_active as active, sub1.period, DATE_FORMAT(sub1.until_date, '%d.%m.%Y') as untildt, c1.*, c2.name as cultname, g2.name as gname
        FROM agt_traders_subscr sub1
        INNER JOIN agt_traders_products c1 ON sub1.cult_id=c1.id
        INNER JOIN agt_traders_products_lang c2 ON c1.id=c2.item_id
        INNER JOIN agt_traders_product_groups g1 ON c1.group_id=g1.id
        INNER JOIN agt_traders_product_groups_lang g2 ON g1.id=g2.item_id
      WHERE sub1.buyer_id= {$this->id}
      ORDER BY g1.sort_num, c2.name");
        return $list;
    }

    public function getCompanyRubrics() {
        $groups = $this->db->select('agt_comp_tgroups');
        $rubrics = $this->db->select('agt_comp_topic');
        foreach ($groups as $key => $group) {
            foreach ($rubrics as $rubric) {
                if ($rubric['menu_group_id'] == $group['id']) {
                    $groups[$key]['rubrics'][] = $rubric;
                }
            }
        }
        return $groups;
    }

    public function getRubrics() {
        $traders = $this->model('traders');
        $groups = $traders->getRubricsGroup(0);
        $rubrics = $traders->getRubrics(0);
        foreach ($groups as $key => $group) {
            foreach ($rubrics as $rubric) {
                if ($rubric['group_id'] == $group['id']) {
                    $groups[$key]['rubrics'][] = $rubric;
                }
            }
        }
        return $groups;
    }

    public function saveAdvSub($up, $deact) {
        $this->db->update('agt_torg_buyer', ['subscr_adv_up' => $up, 'subscr_adv_deact' => $deact], ['id' => $this->id]);
        $this->response->json(['code' => 1, 'text' => 'Изменения сохранены.']);
    }

    public function removeContact($contact) {
        $existContact = $this->db->select('agt_comp_items_contact', '*', ['id' => $contact, 'buyer_id' => $this->id])[0] ?? null;
        if ($existContact != null) {
            $this->db->delete('agt_comp_items_contact', ['id' => $contact, 'buyer_id' => $this->id]);
            $this->db->query("update agt_comp_items_contact set sort_num = sort_num - 1 where buyer_id = {$this->id} and sort_num = {$existContact['sort_num']}");
            $this->response->json(['code' => 1]);
        } else {
            $this->response->json(['code' => 0, 'text' => 'В Вашем списке нет такого контакта.']);
        }
    }

    public function editContact($contact, $post, $name, $phone, $email) {
        $existContact = $this->db->select('agt_comp_items_contact', '*', ['id' => $contact, 'buyer_id' => $this->id])[0] ?? null;
        if ($existContact != null) {
            $this->db->update('agt_comp_items_contact', ['email' => $email, 'dolg' => $post, 'fio' => $name, 'phone' => $phone, 'comp_id' => ($this->company == null) ? 0 : $this->company['id']], ['id' => $contact, 'buyer_id' => $this->id]);
            $this->response->json(['code' => 1]);
        } else {
            $this->response->json(['code' => 0, 'text' => 'В Вашем списке нет такого контакта.']);
        }
    }

    public function addContact($type, $post, $name, $phone, $email) {
        $maxSort = $this->db->select('agt_comp_items_contact', ['max(sort_num) as maxsort'], ['buyer_id' => $this->id])[0]['maxsort'] ?? 0;
        $this->db->insert('agt_comp_items_contact', ['type_id' => $type, 'comp_id' => ($this->company == null) ? 0 : $this->company['id'], 'buyer_id' => $this->id, 'dolg' => $post, 'fio' => $name, 'phone' => $phone, 'fax' => '', 'email' => $email, 'sort_num' => $maxSort + 1]);
        $this->response->json(['code' => 1]);
    }

    public function getContacts($company, $type) {
        $contacts = $this->db->query("select * from agt_comp_items_contact where (buyer_id = {$this->id} && comp_id = $company or buyer_id = {$this->id} && comp_id = 0) && type_id = $type");
        return $contacts;
    }

    public function saveMainContacts($name, $name2, $name3, $phone2, $phone3, $publicEmail, $region, $city) {
        if ($name == null) {
            $this->response->json(['code' => 0, 'text' => 'Укажите Ваше имя.']);
        }
        $checkEmail = $this->db->query("select id from agr_torg_buyer where (login = '$publicEmail' or email = '$publicEmail') and id != {$this->id}")[0] ?? null;
        if ($checkEmail != null) {
            $this->response->json(['code' => 0, 'text' => 'Данный Email уже кем-то используется.']);
        }
        $this->db->update('agt_torg_buyer', ['name' => $name, 'name2' => $name2, 'name3' => $name3, 'phone2' => $phone2, 'phone3' => $phone3, 'email' => $publicEmail, 'obl_id' => $region, 'city' => $city], ['id' => $this->id]);
        $this->response->json(['code' => 1, 'text' => 'Данные сохранены.']);
    }

    public function saveIm($telegram, $viber) {
        $this->db->update('agt_torg_buyer', ['telegram' => $telegram, 'viber' => $viber], ['id' => $this->id]);
        $this->response->json(['code' => 1, 'text' => 'Данные сохранены.']);
    }

    public function activate($hash) {
        $user = $this->db->select('agt_torg_buyer', ['id', 'login'], ['hash' => $hash])[0] ?? null;
        if ($user != null) {
            $this->session->set('id', $user['id']);
            $newHash = $this->utils->getHash(12);
            $this->db->update('agt_torg_buyer', ['isactive_web' => 1, 'hash' => $newHash], ['id' => $user['id']]);
            $this->cookie->set('hash', $newHash);
            $this->response->redirect('/');
        } else {
            $this->session->set('error', 'Неверный ключ активации.<br>Пожалуйста, попробуйте снова.');
            $this->response->redirect('/error');
        }
    }

    public function restore($email) {
        if ($email == null) {
            $this->response->json(['code' => 0, 'text' => 'Введите email.']);
        }
        if (!$this->utils->emailValidate($email)) {
            $this->response->json(['code' => 0, 'text' => 'Email указан с ошибками.']);
        }
        $checkEmail = $this->db->select('agt_torg_buyer', 'hash', ['login' => $email])[0] ?? null;
        if ($checkEmail == null) {
            $this->response->json(['code' => 0, 'text' => 'Данный email не зарегистрирован.']);
        } else {
            // new password
            $password = $this->utils->getHash(8);
            // get hash from password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $this->db->update('agt_torg_buyer', ['new_password' => $passwordHash], ['login' => $email]);
            $this->session->set('info', 'Мы отправили новые данные для входа на Ваш email.');
            // fetch email template
            $emailTemplate = $this->view->setData(['password' => $password])->fetch('email/restore');
            $this->utils->mail($email, 'Восстановление пароля', $emailTemplate);
            $this->response->json(['code' => 1, 'text' => '']);
        }
    }

    public function register($email, $password, $rePassword, $name, $phone) { //// without region
        if ($email == null) {
            $this->response->json(['code' => 0, 'text' => 'Введите email.']);
        }
        if (!$this->utils->emailValidate($email)) {
            $this->response->json(['code' => 0, 'text' => 'Email указан с ошибками.']);
        }
        if ($password == null) {
            $this->response->json(['code' => 0, 'text' => 'Введите пароль.']);
        }
        if (mb_strlen($password) < 6 && mb_strlen($password) > 20) {
            $this->response->json(['code' => 0, 'text' => 'Пароль должен быть от 6 до 20 символов.']);
        }
        // if ($rePassword == null) {
        //   $this->response->json(['code' => 0, 'text' => 'Повторите пароль.']);
        // }
        // if ($password !== $rePassword) {
        //   $this->response->json(['code' => 0, 'text' => 'Пароли не совпадают.']);
        // }
        // if ($password !== $rePassword) {
        //   $this->response->json(['code' => 0, 'text' => 'Пароли не совпадают.']);
        // }
        if ($name == null) {
            $this->response->json(['code' => 0, 'text' => 'Укажите контактное лицо.']);
        }
        if ($phone == null) {
            $this->response->json(['code' => 0, 'text' => 'Введите Ваш номер телефона.']);
        }
        // if ($region == null) {
        //   $this->response->json(['code' => 0, 'text' => 'Выберите регион.']);
        // }

        // check if user exist from database
        $check = $this->get($this->id, ['login', 'phone']);

        if ($check['login'] == $email) {
            $this->response->json(['code' => 0, 'text' => 'Данный email уже используется на сайте другим пользователем.']);
        }
        if ($check['phone'] == $phone) {
            $this->response->json(['code' => 0, 'text' => 'Такой номер телефона уже используется одним из клиентов нашего сайта.']);
        }

        // get hash from password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        // get random string hash
        $hash         = $this->utils->getHash(12);
        // add user to database
        $this->db->insert('agt_torg_buyer', ['add_date' => 'NOW()', 'login' => $email, 'passwd' => $passwordHash, 'obl_id' => null, 'avail_adv_posts' => 50, 'name' => $name, 'phone' => $phone, 'email' => $email, 'hash' => $hash, 'smschecked' => 1]);
        // fetch email template
        $emailTemplate = $this->view->setData(['hash' => $hash])->fetch('email/activateEmail');
        $this->utils->mail($email, 'Подтверждение регистрации на Агротендере', $emailTemplate);
        $this->session->set('thankyou', 1);
        $this->response->json(['code' => 1]);
    }

    public function login($email, $password, $admin = null) {
        if ($email == null) {
            $this->response->json(['code' => 0, 'text' => 'Введите email.']);
        }
        if (!$this->utils->emailValidate($email)) {
            $this->response->json(['code' => 0, 'text' => 'Email указан с ошибками.']);
        }
        if ($password == null) {
            $this->response->json(['code' => 0, 'text' => 'Введите пароль.']);
        }
        if (mb_strlen($password) < 6) {
            $this->response->json(['code' => 0, 'text' => 'Пароль должен быть от 6 символов.']);
        }
        // check if user exist
        $checkUser = $this->db->select('agt_torg_buyer', ['id', 'passwd', 'new_password', 'isactive_web', 'hash'], ['login' => $email])[0] ?? null;
        $hash = $checkUser['hash'];
        if ($checkUser == null) {
            $this->response->json(['code' => 0, 'text' => 'Неверный логин/пароль.']);
        }
        if ($checkUser['passwd'] != $password) {
            if (!password_verify($password, $checkUser['passwd'])) {
                if (!password_verify($password, $checkUser['new_password'])) {
                    $this->response->json(['code' => 0, 'text' => 'Неверный логин/пароль.']);
                } else {
                    $hash = $this->utils->getHash(12);
                    $this->db->update('agt_torg_buyer', ['passwd' => $checkUser['new_password'], 'new_password' => null, 'isactive_web' => '1', 'hash' => $hash], ['id' => $checkUser['id']]);
                }
            }
        }

        if ($hash == null) {
            $hash = $this->utils->getHash(12);
            $this->db->update('agt_torg_buyer', ['hash' => $hash], ['id' => $checkUser['id']]);
        }
        $this->session->set('id', $checkUser['id']);
        $this->cookie->set('hash', $hash);
        if ($admin == null) {
            $this->response->json(['code' => 1, 'text' => '']);
        } else {
            $this->response->redirect('/');
        }
    }

    public function sendConfirmCode($phone, $code = null) {
        if (!$this->getNumSmsSending($phone)) {
            $code = $code ?? mt_rand(1000, 9999);
            $this->session->set('code', $code);
            $this->session->set('phone', $phone);
            $this->utils->sendSms($phone, $code, $this->ip);
            $this->response->json(['code' => 1, 'text' => 'Код отправлен.']);
        } else {
            $this->response->json(['code' => 0, 'text' => 'Слишком много попыток.<br>Попробуйте завтра.']);
        }
    }

    public function getNumSmsSending($phone) {
        $smsLog = $this->db->query("select count(id) as count from agt_sms_log where phone = '$phone' && date = date(add_date) = curdate()")[0]['count'];
        return (($this->cookie->get('smsNum') >= 3 && $this->cookie->get('lastSmsDate') == date('d.m.Y')) || ($this->session->get('smsNum') >= 3 && $this->session->get('lastSmsDate') == date('d.m.Y')) || $smsLog >= 3);
    }

    public function activatePhone($phone, $code) {
        $check = $this->get($this->id, ['phone']);

    }

    public function changePassword($old, $new) {
        if ($old == null) {
            $this->response->json(['code' => 0, 'text' => 'Введите старый пароль.']);
        }
        $password = $this->get($this->id, 'passwd')['passwd'];
        if (!password_verify($old, $password)) {
            $this->response->json(['code' => 0, 'text' => 'Старый пароль указан неправильно.']);
        }
        if ($new == null) {
            $this->response->json(['code' => 0, 'text' => 'Введите новый пароль.']);
        }
        if (mb_strlen($new) < 6 && mb_strlen($new) > 20) {
            $this->response->json(['code' => 0, 'text' => 'Новый пароль должен быть от 6 до 20 символов.']);
        }
        // get hash from new password
        $passwordHash = password_hash($new, PASSWORD_DEFAULT);
        // add new password to database
        $this->db->update('agt_torg_buyer', ['passwd' => $passwordHash], ['id' => $this->id]);
        $this->response->json(['code' => 1, 'text' => 'Пароль изменён.']);
    }

    public function changeEmail($email) {
        if ($email == null) {
            $this->response->json(['code' => 0, 'text' => 'Введите email.']);
        }
        if (!$this->utils->emailValidate($email)) {
            $this->response->json(['code' => 0, 'text' => 'Email указан с ошибками.']);
        }
        $checkExist = $this->checkExist('login', $email);
        if ($checkExist != null) {
            $this->response->json(['code' => 0, 'text' => 'Данный Email адрес уже зарегистрирован на сайте.']);
        } else {
            $this->db->update('agt_torg_buyer', ['new_login' => $email], ['id' => $this->id]);
            $this->session->set('info', 'Мы отправили Вам письмо с ссылкой для подтверждения изменения логина..');
            // fetch email template
            $emailTemplate = $this->view->setData(['email' => $email, 'id' => $this->id, 'emailHash' => base64_encode(password_hash($email, PASSWORD_DEFAULT))])->fetch('email/changeEmail');
            $this->utils->mail($this->email, 'Изменение логина', $emailTemplate);
            $this->response->json(['code' => 1, 'text' => '']);
        }
    }

    public function checkExist($field, $value) {
        return $this->db->query("select id, passwd, hash, isactive_web from agt_torg_buyer where $field = '$value'")[0] ?? null;
    }


    public function get($id, $select = '*') {
        $user = $this->db->select('agt_torg_buyer', $select, ['id' => $id])[0] ?? null;
        return $user;
    }

}
