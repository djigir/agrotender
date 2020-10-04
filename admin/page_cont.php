<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/ses-inc.php";

	include "inc/authorize-inc.php";

	if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$PAGE_HEADER['ru'] = "Редактировать Контактную Информацию";
	$PAGE_HEADER['en'] = "Edit Contacts";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$action = GetParameter("action", "");

	switch($action)
	{
		case "contact":
			$tab_params = GetParameter("tab_params", null);
			$optids = GetParameter("optids", null);
			for($i=0; $i<count($tab_params); $i++)
				if(!mysqli_query($upd_link_db,"UPDATE $TABLE_SITE_OPTIONS SET value='".addslashes($tab_params[$i])."' WHERE id='".$optids[$i]."'"))
				{
					echo mysqli_error($upd_link_db);
				}
			break;
	}

	$arr_opt = Array();
	$arr_ids = Array();
	if($res = mysqli_query($upd_link_db,"SELECT * FROM $TABLE_SITE_OPTIONS WHERE lang_id='$LangId' ORDER BY id"))
	{
		$ic = 0;
		while($row=mysqli_fetch_object($res))
		{
    		$ic++;
	    	$arr_opt[$ic] = stripslashes($row->value);
	    	$arr_ids[$ic] = $row->id;
	    }
	    mysqli_free_result($res);
	}

?>

	<h3>Настройка Контактной Информации</h3>

    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="contact" />
	<tr>
		<th width="23%">Название</th>
		<th width="29%">Значение</th>
	</tr>
	<tr>
		<td class="ff">Контактный E-Mail:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[1];?>" />
			<input class="field" type="text" name="tab_params[]" size="30" value="<?=$arr_opt[1];?>" /></td>

	</tr>
    <tr>
		<td class="ff">E-Mail Службы Поддержки:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[2];?>" />
			<input class="field" type="text" name="tab_params[]" size="30" value="<?=$arr_opt[2];?>" /></td>

	</tr>
    <tr>
		<td class="ff">Телефон 1:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[3];?>" />
			<input class="field" type="text" name="tab_params[]" size="30" value="<?=$arr_opt[3];?>" /></td>

	</tr>
    <tr>
		<td class="ff">Телефон 2:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[4];?>" />
			<input class="field" type="text" name="tab_params[]" size="30" value="<?=$arr_opt[4];?>" /></td>

	</tr>
    <!--
	<tr>
		<td class="ff">Телефон 3:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[7];?>" />
			<input class="field" type="text" name="tab_params[]" size="30" value="<?=$arr_opt[7];?>" /></td>
		<td class="fr">Отдел сварочного оборудования и ремонта электродвигателей</td>
	</tr>
    <tr>
		<td class="ff">Телефон 4:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[8];?>" />
			<input class="field" type="text" name="tab_params[]" size="30" value="<?=$arr_opt[8];?>" /></td>
		<td class="fr">Отдел сварочного оборудования и ремонта электродвигателей</td>
	</tr>
    -->
    <tr>
		<td class="ff">Телефон 3:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[5];?>" />
			<input class="field" type="text" name="tab_params[]" size="30" value="<?=$arr_opt[5];?>" /></td>

	</tr>
    <tr>
		<td class="ff">Адрес:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[6];?>" />
			<textarea class="field" name="tab_params[]" cols="45" rows="2"><?=$arr_opt[6];?></textarea></td>

	</tr>
	<tr>
		<td class="ff">Skype:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[7];?>" />
			<input class="field" type="text" name="tab_params[]" size="32" value="<?=$arr_opt[7];?>" /></td>

	</tr>
	<tr>
		<td class="ff">ICQ:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[8];?>" />
			<input class="field" type="text" name="tab_params[]" size="32" value="<?=$arr_opt[8];?>" /></td>

	</tr>
<?php
/*
	<tr>
		<td class="ff">Телефон 1:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[7];?>" />
			<input class="field" type="text" name="tab_params[]" size="30" value="<?=$arr_opt[7];?>" /></td>
		<td class="fr">Отдел систем пожаротушения</td>
	</tr>
    <tr>
		<td class="ff">Телефон 2:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[8];?>" />
			<input class="field" type="text" name="tab_params[]" size="30" value="<?=$arr_opt[8];?>" /></td>
		<td class="fr">Отдел систем пожаротушения</td>
	</tr>
    <tr>
		<td class="ff">Факс:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[9];?>" />
			<input class="field" type="text" name="tab_params[]" size="30" value="<?=$arr_opt[9];?>" /></td>
		<td class="fr">Отдел систем пожаротушения</td>
	</tr>
	<tr>
		<td class="ff">Контактный E-Mail:</td>
		<td class="fr">
			<input type="hidden" name="optids[]" value="<?=$arr_ids[10];?>" />
			<input class="field" type="text" name="tab_params[]" size="30" value="<?=$arr_opt[10];?>" /></td>
		<td class="fr">&nbsp;Отдел систем пожаротушения</td>
	</tr>
*/
?>
	<tr><td class="fr" colspan="3" align="center"><br /><input type="submit" name="update" value=" Применить " /><br /><br /></td></tr>
	</form>
		</table>
		</td></tr>
	</table>

<?php
	include "inc/footer-inc.php";

	include "../inc/close-inc.php";
?>
