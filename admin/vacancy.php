<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Edit This Vanancy";
   	$strings['tipdel']['en'] = "Delete This Vacancy";

    $strings['tipedit']['ru'] = "Редактировать вакансию";
   	$strings['tipdel']['ru'] = "Удалить эту вакансию";

	$PAGE_HEADER['ru'] = "Редактировать Вакансии";
	$PAGE_HEADER['en'] = "Vacancy Editing";

	$currency_value = "грн.";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

?>

<?php

	switch( $action )
	{
    	case "add":
    		$vacname = GetParameter("vacname", "");
			$vacdescr = GetParameter("vacdescr", "");
			$vacduity = GetParameter("vacduity", "");
			$vacpayment = GetParameter("vacpayment", "");
			$vacstag = GetParameter("vacstag", "");

			$vacname = str_replace ("\"", "&quot;", $vacname);

    		$query = "INSERT INTO $TABLE_VACANCY ( name, descr, payment, stag, duity )
    			VALUES ('".addslashes($vacname)."', '".addslashes($vacdescr)."', '".addslashes($vacpayment)."',
    			'".addslashes($vacstag)."', '".addslashes($vacduity)."')";
			if(!mysqli_query($upd_link_db,$query))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;

		case "delete":
			// Delete selected news
			$items_id = GetParameter("items_id", "");
			for($i = 0; $i < count($items_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_VACANCY WHERE id=".$items_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_VACANCY WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
			break;

		case "update":
			$item_id = GetParameter("item_id", "0");
            $vacname = GetParameter("vacname", "");
			$vacdescr = GetParameter("vacdescr", "");
			$vacduity = GetParameter("vacduity", "");
			$vacpayment = GetParameter("vacpayment", "");
			$vacstag = GetParameter("vacstag", "");

			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_VACANCY
                        SET name='".addslashes($vacname)."', descr='".addslashes($vacdescr)."',
                        payment='".addslashes($vacpayment)."', stag='".addslashes($vacstag)."',
                        duity='".addslashes($vacduity)."'
                        WHERE id=".$item_id." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$vacname = "";
		$vacdescr = "";

		if($res = mysqli_query($upd_link_db,"SELECT * FROM $TABLE_VACANCY WHERE id=$item_id"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$vacname = stripslashes($row->name);
				$vacdescr = stripslashes($row->descr);
				$vacduity = stripslashes($row->duity);
			}
			mysqli_free_result($res);
		}

		//echo "ID: $item_id<br />";
?>

	<h3>Редактировать</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
    <tr><td class="ff">Должность:</td><td class="fr"><input type="text" size="70" name="vacname" value="<?=$vacname;?>" /></td></tr>
    <tr><td class="ff">Опыт Работы:</td><td class="fr">
    	<select name="vacstag">
    		<option value="Не имеет значения">Не требуется</option>
    		<option value="до 1 года">до 1го года</option>
    		<option value="до 2 лет">до 2х лет</option>
    		<option value="более 2 лет">более 2х лет</option>
    		<option value="более 5 лет">более 5и лет</option>
    	</select>
    </td></tr>
    <tr><td class="ff">Требования:</td><td class="fr"><textarea rows="7" cols="70" name="vacdescr"><?=$vacdescr;?></textarea></td></tr>
<script language="javascript1.2">
    //editor_generate('newscont'); // field, width, height
</script>
    <tr><td class="ff">Задачи и Обязанности:</td><td class="fr"><textarea rows="7" cols="70" name="vacduity"><?=$vacduity;?></textarea></td></tr>
<script language="javascript1.2">
    //editor_generate('newscont'); // field, width, height
</script>
<?php
/*
	<tr><td class="ff">Зарплата:</td><td class="fr">
		<select name="vacpayment">
			<option value="до 750">до 750 <?=$currency_value;?></option>
			<option value="750-1000">750-1000 <?=$currency_value;?></option>
			<option value="1000-1500">1000-1500 <?=$currency_value;?></option>
			<option value="1500-2000">1500-2000 <?=$currency_value;?></option>
			<option value="2000-3000">2000-3000 <?=$currency_value;?></option>
			<option value="более 3000">более 3000 <?=$currency_value;?></option>
		</select>
	</td></tr>
*/
?>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Обновить "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
<?php
	}
	else
	{
?>
    <h3>Список Вакансий</h3>
    <table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr><th>&nbsp;</th><th style="padding: 1px 10px 1px 20px" width="75%">Содержание записи</th><th>Функции</th></tr>
    <?
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT * FROM $TABLE_VACANCY") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

            	echo "<tr>
                               <td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
                               <td style=\"padding: 2px 10px 2px 10px\">
                                   <b>".stripslashes($row->name)."</b>
                                   <br /><b>Требования</b><br />".nl2br(stripslashes($row->descr))."<br />
                                   <br /><b>Обязанности</b><br />".nl2br(stripslashes($row->duity))."<br />
                                   <b>Опыт Работы: </b> - ".stripslashes($row->stag)."<br />
                                   <b>Зарплата: </b> - ".stripslashes($row->payment)."<br /></td>
                               <td align=\"center\">
                               	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                               	<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>
                </tr>
                <tr><td colspan=\"3\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"3\" align=\"center\"><br />В базе нет вакансий<br /><br /></td></tr>
			<tr><td colspan=\"3\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"3\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /> <input type=\"submit\" name=\"refresh_but\" value=\" Обновить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить Вакансию</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Должность:</td><td class="fr"><input type="text" size="70" name="vacname"></td></tr>
    <tr><td class="ff">Опыт Работы:</td><td class="fr">
    	<select name="vacstag">
    		<option value="Не имеет значения">Не требуется</option>
    		<option value="до 2 лет">до 2х лет</option>
    		<option value="более 2 лет">более 2х лет</option>
    		<option value="более 5 лет">более 5и лет</option>
    	</select>
    </td></tr>
    <tr><td class="ff">Требования:</td><td class="fr"><textarea rows="7" cols="70" name="vacdescr"></textarea></td></tr>
<script language="javascript1.2">
    //editor_generate('newscont'); // field, width, height
</script>
<tr><td class="ff">Задачи и Обязанности:</td><td class="fr"><textarea rows="7" cols="70" name="vacduity"></textarea></td></tr>
<script language="javascript1.2">
    //editor_generate('newscont'); // field, width, height
</script>
<?php
/*
	<tr><td class="ff">Зарплата:</td><td class="fr">
		<select name="vacpayment">
			<option value="до 750">до 750 <?=$currency_value;?></option>
			<option value="750-1000">750-1000 <?=$currency_value;?></option>
			<option value="1000-1500">1000-1500 <?=$currency_value;?></option>
			<option value="1500-2000">1500-2000 <?=$currency_value;?></option>
			<option value="2000-3000">2000-3000 <?=$currency_value;?></option>
			<option value="более 3000">более 3000 <?=$currency_value;?></option>
		</select>
	</td></tr>
	*/
?>
    <tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Добавить "></td></tr>
    </form>
    	</table>
    	</td></tr>
    </table>

<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
