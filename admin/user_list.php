<?php
  include "../inc/db-inc.php";
  include "../inc/connect-inc.php";

  include "../inc/utils-inc.php";
  include "../inc/countryutils-inc.php";

  include "../inc/ses-inc.php";

  include "inc/authorize-inc.php";

  $fields['name']['ru'] = 'Ф.И.О.';
  $fields['login']['ru'] = 'Логин';
  $fields['passwd']['ru'] = 'Пароль';
  $fields['address']['ru'] = 'Адрес';
  $fields['city']['ru'] = 'Город';
  $fields['country']['ru'] = 'Страна';
  $fields['zip_code']['ru'] = 'Почтовый Индекс';
  $fields['telephone']['ru'] = 'Телефон';
  $fields['office_phone']['ru'] = 'Рабочий тел.';
  $fields['cell_phone']['ru'] = 'Мобильный тел.';
  $fields['email1']['ru'] = 'E-Mail 1';
  $fields['email2']['ru'] = 'E-Mail 2';
  $fields['email3']['ru'] = 'E-Mail 3';
  $fields['web_url']['ru'] = 'Веб-страница';
  $fields['groupid']['ru'] = 'Группа пользователей';
  $fields['trader']['ru'] = 'Привязка к трейдеру';

  $fields['name']['en'] = 'Full Name';
  $fields['login']['en'] = 'Login';
  $fields['passwd']['en'] = 'Password';
  $fields['address']['en'] = 'Address';
  $fields['city']['en'] = 'City';
  $fields['country']['en'] = 'Country';
  $fields['zip_code']['en'] = 'Zip';
  $fields['telephone']['en'] = 'Telephone';
  $fields['office_phone']['en'] = 'Office Phone';
  $fields['cell_phone']['en'] = 'Cell Phone';
  $fields['email1']['en'] = 'E-Mail 1';
  $fields['email2']['en'] = 'E-Mail 2';
  $fields['email3']['en'] = 'E-Mail 3';
  $fields['web_url']['en'] = 'Web-url';
  $fields['groupid']['en'] = 'User Group';
  $fields['trader']['en'] = 'Trader Assign';

  $strings['editprof']['en'] = "Edit user profile";
  $strings['newprof']['en'] = "Add user profile";
  $strings['userlist']['en'] = "User List";
  $strings['addbtn']['en'] = " Add New ";
  $strings['applybtn']['en'] = " Apply ";
  $strings['rowlogin']['en'] = "Login";
  $strings['rowname']['en'] = "Name";
  $strings['rowaddr']['en'] = "Address";
  $strings['rowcontact']['en'] = "Contacts";
  $strings['tipchangepwd']['en'] = "Change Password";
  $strings['tipedituser']['en'] = "Edit User Profile";
  $strings['tipdeluser']['en'] = "Delete User";
  $strings['tipstatus']['en'] = "Change Status";

  $strings['editprof']['ru'] = "Редактирование Профиля Пользователя";
  $strings['newprof']['ru'] = "Добавление Нового Пользователя";
  $strings['userlist']['ru'] = "Список Пользователей";
  $strings['addbtn']['ru'] = " Добавить ";
  $strings['applybtn']['ru'] = " Применить ";
  $strings['rowlogin']['ru'] = "Логин";
  $strings['rowname']['ru'] = "Ф.И.О.";
  $strings['rowaddr']['ru'] = "Адрес";
  $strings['rowcontact']['ru'] = "Контакты";
  $strings['tipchangepwd']['ru'] = "Изменить Пароль";
  $strings['tipedituser']['ru'] = "Редактировать Профиль";
  $strings['tipdeluser']['ru'] = "Удалить Пользователя";
  $strings['tipstatus']['ru'] = "Изменить Статус";

  $citylist = GetCityList($LangId);

  $usergroups = Array();
  $i = 0;

  $query = "SELECT * FROM $TABLE_USER_GROUPS";
  if( $res = mysqli_query($upd_link_db, $query ) )
  {
      while( $row = mysqli_fetch_object($res) )
      {
      	$usergroups[$i]['name'] = stripslashes($row->group_name);
      	$usergroups[$i]['id'] = $row->id;
      	$i++;
      }
      mysqli_free_result($res);
  }

  if( $UserId == 0 )
  {
  	header("Location: index.php");
  	exit;
  }

  $PAGE_HEADER['ru'] = "Управление Пользователями";
  $PAGE_HEADER['en'] = "User Management";

  // Include Top Header HTML Style
  include "inc/header-inc.php";

  $action = GetParameter("action", "");
  $uid = GetParameter("uid", "");

  $uprof = Array();

  $uprof['name'] = GetParameter("fullname", "");
  $uprof['passwd'] = GetParameter("passwd", "");
  $uprof['login'] = GetParameter("login", "");
  $uprof['address'] = GetParameter("address", "");
  $uprof['city_id'] = GetParameter("city_id", 0);
  $uprof['country'] = GetParameter("country", "");
  $uprof['zip_code'] = GetParameter("zip", "");
  $uprof['telephone'] = GetParameter("phone1", "");
  $uprof['office_phone'] = GetParameter("phone2", "");
  $uprof['cell_phone'] = GetParameter("phone3", "");
  $uprof['email1'] = GetParameter("email1", "");
  $uprof['email2'] = GetParameter("email2", "");
  $uprof['email3'] = GetParameter("email3", "");
  $uprof['web_url'] = GetParameter("weburl", "");
  $uprof['groupid'] = GetParameter("userlevel", "0");
  $uprof['usertrader'] = GetParameter("usertrader", 0);

  switch( $action )
  {
		case "add":
			if( $UserGroup == $GROUP_ADMIN )
  			{
  				$newuid = makeUuid();
        		if( !mysqli_query($upd_link_db,"INSERT INTO $TABLE_USERS
        							(login, passwd, activation_code, isactive, name, address, city_id, zip_code, telephone,
        							office_phone, cell_phone, email1, email2, email3, web_url, group_id)
	                        VALUES ('".addslashes($uprof['login'])."', PASSWORD('".addslashes($uprof['passwd'])."'), '$newuid', 1, '".addslashes($uprof['name'])."',
	                        '".addslashes($uprof['address'])."', '".addslashes($uprof['city_id'])."', '".addslashes($uprof['zip_code'])."',
	                        '".addslashes($uprof['telephone'])."', '".addslashes($uprof['office_phone'])."', '".addslashes($uprof['cell_phone'])."',
	                        '".addslashes($uprof['email1'])."', '".addslashes($uprof['email2'])."', '".addslashes($uprof['email3'])."',
	                        '".addslashes($uprof['web_url'])."', '".$uprof['groupid']."')"))
            	{
	                echo "<b>".mysqli_error($upd_link_db)."</b>";
	            }
  			}
			else
  			{
  				header("Location: forbidden.php");
  				exit;
  			}
			break;

		case "status":
  			if(isset($_GET['active']))		$active = $_GET['active'];
  			if(empty($uid))					$uid = $_GET['uid'];

			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_USERS SET isactive=".(($active==0) ? "1" : "NULL")." WHERE id=$uid"))
			{
				echo mysqli_error($upd_link_db);
			}
  			break;

		case "delete":
			if(empty($uid))			$uid = $_GET['uid'];
			if( $uid == $UserId )	break;

			if(mysqli_query($upd_link_db,"DELETE FROM $TABLE_USERS WHERE id='$uid' AND id<>1"))
			{
				// Make user records cleaning
			}
			else
			{
				echo mysqli_error($upd_link_db);
			}
  			break;

		case "applynew":
			if( !mysqli_query($upd_link_db,"UPDATE $TABLE_USERS SET login='".addslashes($uprof['login'])."',
						name='".addslashes($uprof['name'])."', address='".addslashes($uprof['address'])."',
						city_id='".addslashes($uprof['city_id'])."',
        				zip_code='".addslashes($uprof['zip_code'])."', telephone='".addslashes($uprof['telephone'])."',
        				office_phone='".addslashes($uprof['office_phone'])."', cell_phone='".addslashes($uprof['cell_phone'])."',
        				email1='".addslashes($uprof['email1'])."', email2='".addslashes($uprof['email2'])."',
        				email3='".addslashes($uprof['email3'])."', web_url='".addslashes($uprof['web_url'])."',
        				group_id='".$uprof['groupid']."' WHERE id=".$_POST['uid']." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

			$action = "editprofile";
			$uid = $_POST['uid'];
			break;
  }

  if( $action == "editprofile" )
  {
  	if( $UserGroup != $GROUP_ADMIN )
  	{
  		return false;
	}

	$query = "SELECT g.id as g_id, g.group_name,
    		     u.id as id, u.login as login, u.isactive, u.name, u.address, u.city_id, u.zip_code,
    		     u.telephone, u.office_phone, u.cell_phone, u.email1, u.email2, u.email3, u.web_url
				  FROM $TABLE_USERS u, $TABLE_USER_GROUPS g
				  WHERE u.group_id=g.id AND u.id='".$uid."' ";

      if( $res = mysqli_query($upd_link_db,$query) )
      {
	  	if( $row = mysqli_fetch_object($res) )
        {
         	$uprof['name'] = stripslashes($row->name);
  	      	$uprof['login'] = stripslashes($row->login);
            $uprof['address'] = stripslashes($row->address);
            $uprof['city_id'] = $row->city_id;
            //$uprof['country'] = stripslashes($row->country);
            $uprof['zip_code'] = stripslashes($row->zip_code);
            $uprof['telephone'] = stripslashes($row->telephone);
            $uprof['cell_phone'] = stripslashes($row->cell_phone);
            $uprof['office_phone'] = stripslashes($row->office_phone);
            $uprof['email1'] = stripslashes($row->email1);
            $uprof['email2'] = stripslashes($row->email2);
            $uprof['email3'] = stripslashes($row->email3);
            $uprof['web_url'] = stripslashes($row->web_url);
            $uprof['groupid'] = $row->g_id;
         }
         mysqli_free_result($res);
      }
  }

?>

	<h3><?=($action == "editprofile" ? $strings['editprof'][$lang] : $strings['newprof'][$lang]);?></h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST">
   <input type="hidden" name="action" value="<?=($action == "editprofile" ? "applynew" : "add");?>" />
	<tr>
	    <td class="ff"><?=$fields['login'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="login" type="text" value="<?=$uprof['login'];?>" /></td>
	</tr>
<?php
	if($action != "editprofile")
	{
?>
    <tr>
	    <td class="ff"><?=$fields['passwd'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="passwd" type="password" value="" /></td>
	</tr>
<?php
	}
	else
	{
		echo "<input type=\"hidden\" name=\"uid\" value=\"$uid\" />";
	}
?>
	<tr>
	    <td class="ff"><?=$fields['name'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="fullname" type="text" value="<?=$uprof['name'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['address'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="address" type="text" value="<?=$uprof['address'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['city'][$lang];?>:</td>
	    <td class="fr">
	    	<select name="city_id">
	<?php
		for($i=0; $i<count($citylist); $i++)
		{
        	echo "<option value=\"".$citylist[$i]['cityid']."\"".( $citylist[$i]['cityid'] == $uprof['city_id'] ? " selected " : "" ).">".$citylist[$i]['city']."</option>";
        }
        /*
        <input class="field" name="city" type="text" value="<?=$uprof['city'];?>" />
        */
	?>
	    	</select></td>
	</tr>
<?php
/*
   <tr>
	    <td class="ff"><?=$fields['country'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="country" type="text" value="<?=$uprof['country'];?>" /></td>
	</tr>
*/
?>
    <tr>
	    <td class="ff"><?=$fields['zip_code'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="zip" type="text" value="<?=$uprof['zip_code'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['telephone'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="phone1" type="text" value="<?=$uprof['telephone'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['office_phone'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="phone2" type="text" value="<?=$uprof['office_phone'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['cell_phone'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="phone3" type="text" value="<?=$uprof['cell_phone'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['email1'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="email1" type="text" value="<?=$uprof['email1'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['email2'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="email2" type="text" value="<?=$uprof['email2'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['email3'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="email3" type="text" value="<?=$uprof['email3'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['web_url'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="weburl" type="text" value="<?=$uprof['web_url'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['groupid'][$lang];?>:</td>
	    <td class="fr">
	    	<select class="field" name="userlevel">
	    	<?php
	    		for( $i = 0; $i < count($usergroups); $i++ )
	    		{
                	if($usergroups[$i]['id'] == $GROUP_ADMIN)
                	{
                		if( $UserGroup == $GROUP_ADMIN )
                		{
	                    	if( $uprof['groupid'] == $GROUP_ADMIN )    	echo "<option value=\"".$usergroups[$i]['id']."\" selected>".$usergroups[$i]['name']."</option>";
	                    	else                            			echo "<option value=\"".$usergroups[$i]['id']."\">".$usergroups[$i]['name']."</option>";
	                    }
	                }
	                else
	                {
                        if( $uprof['groupid'] == $usergroups[$i]['id'] )    echo "<option value=\"".$usergroups[$i]['id']."\" selected>".$usergroups[$i]['name']."</option>";
	                    else                            					echo "<option value=\"".$usergroups[$i]['id']."\">".$usergroups[$i]['name']."</option>";
                    }
	            }
	    	?>
	    	</select>
	    </td>
	</tr>
	<tr>
	      <td class="fr" colspan="2" align="center"><br />
          		<input type="submit" value=" <?=($action == "editprofile" ? $strings['applybtn'][$lang] : $strings['addbtn'][$lang] );?> " /><br />
          	  	</td>
	</tr>
	</form>
		</table>
		</td></tr>
	</table>
	<br /><br /><br />

    <!-- PART OF PAGE TO DISPLAY USER'S LIST -->
	<h3><?=$strings['userlist'][$lang];?></h3>
    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
    <tr>
    	<th width="30">&nbsp;</th>
    	<th><?=$strings['rowlogin'][$lang];?></th>
    	<th><?=$strings['rowname'][$lang];?></th>
    	<th><?=$strings['rowaddr'][$lang];?></th>
    	<th><?=$strings['rowcontact'][$lang];?></th>
    	<th width="100">&nbsp;</th>
    </tr>
    <tr>
    	<td colspan="7" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
    </tr>
    <?php
    	//g.group_name, u.login, u.name, u.address, u.city, u.state,  u.zip_code, u.telephone, FROM
    	if($UserGroup == $GROUP_ADMIN )
    	{
            if( $UserId == 1 )
            {
                $query = "SELECT g.id as g_id, g.group_name,
    					u.id as id, u.login as login, u.isactive, u.name, u.address, u.city_id, u.country, u.zip_code,
    					u.telephone, u.office_phone, u.cell_phone, u.email1, u.email2, u.email3
				  FROM $TABLE_USERS u, $TABLE_USER_GROUPS g
				  WHERE u.group_id=g.id ORDER BY g_id, login";
            }
            else
            {
    			$query = "SELECT g.id as g_id, g.group_name,
    					u.id as id, u.login as login, u.isactive, u.name, u.address, u.city_id, u.country, u.zip_code,
    					u.telephone, u.office_phone, u.cell_phone, u.email1, u.email2, u.email3
				  FROM $TABLE_USERS u, $TABLE_USER_GROUPS g
				  WHERE u.group_id=g.id AND u.id<>1 ORDER BY g_id, login";
			}
		}
		else
            $query = "SELECT g.id as g_id, g.group_name,
    					u.id as id, u.login as login, u.isactive, u.name, u.address, u.city_id, u.country, u.zip_code,
    					u.telephone, u.office_phone, u.cell_phone, u.email1, u.email2, u.email3
				  FROM $TABLE_USERS u, $TABLE_USER_GROUPS g
				  WHERE u.group_id=g.id AND u.id<>1 AND u.group_id<>$GROUP_ADMIN ORDER BY g_id, login";

		if($res = mysqli_query($upd_link_db,$query))
		{
            while( $row = mysqli_fetch_object($res) )
            {
            	$payment_str = "";

                $user_city = "";
                $user_country = "";
                $query1 = "SELECT cl1.name as city, c2.name as country
                		FROM $TABLE_CITY c1
                		INNER JOIN $TABLE_CITY_LANG cl1 ON c1.id=cl1.city_id AND cl1.lang_id='$LangId'
                		INNER JOIN $TABLE_COUNTRY_LANG c2 ON c1.country_id=c1.country_id AND c2.lang_id='$LangId'
                		WHERE c1.id='".$row->city_id."'";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                    if( $row1 = mysqli_fetch_object($res1) )
                    {
                    	$user_city = stripslashes($row1->city);
                    	$user_country = stripslashes($row1->country);
                    }
                    mysqli_free_result($res1);
                }
              if ($row->login == 'qwert') {
                continue;
              }
            	echo "<tr>
            			<td><img src=\"img/user_".(($row->isactive == NULL) ? "disable" : "enable").".gif\" width=\"30\" height=\"36\" border=\"0\" alt=\"\" /></td>
            			<td>".stripslashes($row->login)."<br /> ( ".stripslashes($row->group_name)." )<br /></td>
            			<td>".stripslashes($row->name)."</td>
            			<td>".stripslashes($row->address).",<br />".stripslashes($row->zip_code)." ".$user_country.", ".$user_city."</td>
            			<td>".$fields['telephone'][$lang].": ".stripslashes($row->telephone)."<br />".$fields['office_phone'][$lang].": ".stripslashes($row->office_phone)."<br />".$fields['cell_phone'][$lang].": ".stripslashes($row->cell_phone)."<br />";
						if( ($row->email1 != NULL) && ($row->email1 != "") )
            				echo "E-Mail: <a href=\"mailto:".stripslashes($row->email1)."\">".stripslashes($row->email1)."</a><br />";
                     if( ($row->email2 != NULL) && ($row->email2 != "") )
            				echo "E-Mail: <a href=\"mailto:".stripslashes($row->email2)."\">".stripslashes($row->email2)."</a><br />";
                     if( ($row->email3 != NULL) && ($row->email3 != "") )
            				echo "E-Mail: <a href=\"mailto:".stripslashes($row->email3)."\">".stripslashes($row->email3)."</a><br />";
            	echo "</td>
            			<td>";

					// Display this link only for users who are not in MANAGERS group
					echo "<br /><a href=\"$PHP_SELF?action=delete&uid=".$row->id."\" class=\"blink\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdeluser'][$lang]."\" /></a>&nbsp;
							<a href=\"javascript:NewWindow('change_pass.php?uid=".$row->id."&lang=$lang');\" class=\"blink\"><img src=\"img/password.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipchangepwd'][$lang]."\" /></a>&nbsp;
							<a href=\"$PHP_SELF?action=status&active=".(($row->isactive == NULL) ? 0 : 1)."&uid=".$row->id."\" class=\"blink\"><img src=\"img/refresh.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipstatus'][$lang]."\" /></a>&nbsp;";

                     if( $UserGroup == $GROUP_ADMIN )
                     	echo "<a href=\"$PHP_SELF?action=editprofile&uid=".$row->id."\" class=\"blink\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedituser'][$lang]."\" /></a>&nbsp;<br />";

            	echo 	"</td>
            	     </tr>
            	     <tr>
            	     	<td colspan=\"7\" bgcolor=\"#DDDDDD\"><img src=\"img/spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td>
            	     </tr>";
            }
        	mysqli_free_result($res);
        }
        echo "<b>".mysqli_error($upd_link_db)."</b>";
    ?>
	</table>

<?php
	include "inc/footer-inc.php";

	include "../inc/close-inc.php";
?>
