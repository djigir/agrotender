<?php
error_reporting(E_ALL);
	include	"../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/ses-inc.php";

	////////////////////////////////////////////////////////////////////////////
	//		Interface Language
    $lang = "ru";

    //	Trying to check if the user input correct login and password
    $action = GetParameter("action", "");

    $error_msg = "";

    if( $action == "logout" )
    {
        if( !mysqli_query($upd_link_db,  "DELETE FROM $TABLE_USER_AUTH WHERE ses_id='".session_id()."'" ) )
        {
           echo mysqli_error($upd_link_db);
        }
    }

    if( $action == "makelogin" )
    {
    
        $UserId = 0;
        $UserName = "";
    	$UserGroup = 0;

    	$user_login = GetParameter("login", "");
    	$user_passwd = GetParameter("passwd", "");

//    	if ($user_login == 'hsfbhwjs' && $user_passwd == 'dfjKSDFDKFSDKLJF') {
//    		$user_login = 'admatend';
//    		$user_passwd = 'ASHUD&Q*&T@';
//    	} else {
//    	  die('сасать писос!!!!!!');
//    	}


        $query = "SELECT * FROM $TABLE_USERS
        		WHERE login='".addslashes($user_login)."' AND passwd=PASSWORD('".addslashes($user_passwd)."')";


        if( $res = mysqli_query($upd_link_db,  $query ) ) {

            if( $row = mysqli_fetch_object($res) )
            {
            	$already_signedin = false;

            	//echo "wrlk gjwelkjrjglkwjerlkgj wlkejrglkwe<br /><br />";

                $query = "SELECT * FROM $TABLE_USER_AUTH
                	WHERE ses_id='".session_id()."' AND user_login='".addslashes($user_login)."'
                	AND user_passwd='".addslashes($user_passwd)."'";
                if( $res1 = mysqli_query($upd_link_db,  $query ) )
                {
                    if( $row1 = mysqli_fetch_object($res1) )
                    {
                    	$already_signedin = true;

                        $UserId = $row->id;
	                    $UserName = $user_login;
	                    $UserGroup = $row->group_id;
	                    $LangId = 1;	// Set Russion layout language by default
	                    setcookie("LangId", $LangId);
                    }
                    mysqli_free_result($res1);
                }
                echo mysqli_error($upd_link_db);

                if( !$already_signedin )
                {
                	// The login and password correct, so perform login
	                $query = "INSERT INTO $TABLE_USER_AUTH (ses_id, user_login, user_passwd, time_added)
	                    VALUES ('".session_id()."', '".addslashes($user_login)."', PASSWORD('".addslashes($user_passwd)."'), NOW() )";
	                if( !mysqli_query($upd_link_db,  $query ) )
	                {
	                    echo mysqli_error($upd_link_db);
	                }
	                else
	                {
	                    $UserId = $row->id;
	                    $UserName = $user_login;
	                    $UserGroup = $row->group_id;
	                    $LangId = 1;	// Set Russion layout language by default
	                    setcookie("LangId", $LangId);
	                }
	            }

	            //echo "$UserId<br />";
            }
            else
            {
            	$error_msg = "Неправильно введен логин или пароль";
            }
            mysqli_free_result($res);
        }
    }
    else
    {
    	include "inc/authorize-inc.php";
    }

    ////////////////////////////////////////////////////////////////////////////
    //	Display page layout
    if( $UserId == 0 )
    {
?>
<html>
<head>
	<title>Управление Сайтом - Админ Панель</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="css/style.css" />
</head>
<body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0">
	<table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
	<tr height="70"><td colspan="2" valign="top" class="panel">
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td width="1"><img src="img/spacer.gif" width="1" height="70" alt="" /></td>
			<td width="180" align="right"><img src="<?=( $lang == "en" ? "img/adminpanel.gif" : "img/adminpanel_ru.gif");?>" width="150" height="38" alt="<?=( $lang == "en" ? "Admin Panel" : "Админ Панель");?>" border="0" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
	</td></tr>
	<tr><td>
		<table align="center" cellspacing="0" cellpadding="0" border="0" width="200">
		<tr><td>
			<form action="<?=$PHP_SELF;?>" method="POST">
			<input type="hidden" name="action" value="makelogin" />
			<div class="maindiv">
				<h3><?=( $lang == "en" ? "Sign In" : "Вход" );?></h3>

                <b><?=( $lang == "en" ? "Login" : "Логин" );?>:</b><br />
                <input type="text" name="login" value="" style="width: 160px;" /><br />
                <b><?=( $lang == "en" ? "Password" : "Пароль" );?>:</b><br />
				<input type="password" name="passwd" value="" style="width: 160px;" /><br /><br />
				<input type="submit" value=" <?=( $lang == "en" ? "Submit" : "Войти" );?> " />
				<?php
					if( $error_msg != "" )
						echo "<br /><br />$error_msg<br />";
				?>
			</div>
			</form>
		</td></tr>
		</table>
	</td></tr>
    <tr height="70"><td colspan="2" valign="bottom" class="panel">
        <table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td width="1"><img src="img/spacer.gif" width="1" height="70" alt="" /></td>
			<td align="right"><img src="<?=( $lang == "en" ? "img/adminpanel.gif" : "img/adminpanel_ru.gif" );?>" width="150" height="38" alt="Admin Panel" border="0" /></td>
		</tr>
		</table>
	</td></tr>
	</table>
</body>
</html>
<?php
	}
	else
	{
		header("Location: main.php");
		exit;
	}

	include "../inc/close-inc.php";

$log_file="counter.log";  
$f=fopen($log_file,"a+"); 
$ip=getenv("REMOTE_ADDR");  
fputs($f, $ip.' '.date("Y-m-d H:i:s")."\r\n"); 
 fclose($f);  


?>
