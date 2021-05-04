<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    $uid = GetParameter( "uid", "" );
    $action = GetParameter( "action", "" );
    $lang = GetParameter( "lang", "en" );

    $strings['title']['ru'] = "Изменить пароль пользователя";
    $strings['hdrdone']['ru'] = "Установка пароля";
    $strings['hdrform']['ru'] = "Установить новый пароль";
    $strings['txtok']['ru'] = "Пароль был успешно установлен.";
    $strings['txterr']['ru'] = "Пароль не был установлен. Пожалуста, закройте окно и попробуйте еще раз.";
    $strings['fieldpwd']['ru'] = "Новый Пароль";
    $strings['fieldpwd1']['ru'] = "Подтвердить пароль";
    $strings['close']['ru'] = "Закрыть Окно";
    $strings['btn']['ru'] = " Применить ";

    $strings['title']['en'] = "Change User Password";
    $strings['hdrdone']['en'] = "Password Changing";
    $strings['hdrform']['en'] = "Set New Password";
    $strings['txtok']['en'] = "The password was changed successfully.";
    $strings['txterr']['en'] = "The password was not changed. PLease close the window and try again.";
    $strings['fieldpwd']['en'] = "New Password";
    $strings['fieldpwd1']['en'] = "Confirm Password";
    $strings['close']['en'] = "Close Window";
    $strings['btn']['en'] = " Apply ";


    $changed_ok = false;

    switch ($action)
    {
        case "change":
        	$passwd1 = GetParameter("passwd1", "");
			$passwd2 = GetParameter("passwd2", "");
			//echo $passwd1." - ".$passwd2."<br />";
        	if($passwd1 == $passwd2)
        	{
            	if( !mysqli_query($upd_link_db,"UPDATE $TABLE_USERS
            		SET passwd=PASSWORD('".addslashes($passwd1)."')
            		WHERE id='$uid'") )
	            {
	                echo mysqli_error($upd_link_db);
	            }
	            else
	            {
					$changed_ok = true;
                }
            }
	        break;

	    default:
	    	// We just load the page
	}


	include "inc/popup-header-inc.php";

		if($action == "change")
		{
	?>
		<h3><?=$strings['hdrdone'][$lang];?></h3>
		<br /><br /><br /><br /><br /><br />
		<center><?=($changed_ok ? $strings['txtok'][$lang] : $strings['txterr'][$lang]);?>.</center>
		<br /><br /><br /><br /><br /><br />
	<?php
        }
        else
        {
	?>
			<h3><?=$strings['hdrform'][$lang];?></h3>
            <table align="center" cellspacing="0" cellpadding="1" border="0" width="400" class="tableborder">
    		<tr><td>
    			<table width="100%" cellspacing="1" cellpadding="1" border="0">
    	    <form action="<?=$PHP_SELF;?>" method="POST">
	        <input type="hidden" name="action" value="change" />
	        <input type="hidden" name="uid" value="<?=$uid;?>" />
	        <input type="hidden" name="lang" value="<?=$lang;?>" />
	        <tr>
	            <td class="ff"><?=$strings['fieldpwd'][$lang];?>:</td>
	            <td class="fr">
                        <input type="password" name="passwd1" />
	            </td>
	        </tr>
            <tr>
	            <td class="ff"><?=$strings['fieldpwd1'][$lang];?>:</td>
	            <td class="fr">
                        <input type="password" name="passwd2" />
	            </td>
	        </tr>
            <tr>
	            <td colspan="2" class="fr" align="center"><input type="submit" value="<?=$strings['btn'][$lang];?>" /></td>
	        </tr>
	        </form>
	        	</table>
	        </td></tr>
	        </table>

	<?php
		}

	include "inc/popup-footer-inc.php";

	include "../inc/close-inc.php";
?>
