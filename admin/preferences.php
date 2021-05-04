<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/ses-inc.php";

	include "inc/authorize-inc.php";

	if( $UserId == 0 )
    {
    	header("Location: index.php");
		exit();
    }

	$PAGE_HEADER['ru'] = "Редактировать Общие Настройки";
	$PAGE_HEADER['en'] = "Edit Contacts";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$action = GetParameter("action", "");

	switch($action)
	{
		case "apply":
			$optid = GetParameter("optid", 0);
			$optval = GetParameter("optval", 1);
			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_PREFERENCES SET value='".$optval."' WHERE id='".$optid."'"))
			{
				echo mysqli_error($upd_link_db);
			}
			break;
	}

	$opts = Array();
	if($res = mysqli_query($upd_link_db,"SELECT * FROM $TABLE_PREFERENCES"))
	{
		while($row=mysqli_fetch_object($res))
		{
	    	$opts[$row->id] = $row->value;
	    }
	    mysqli_free_result($res);
	}

?>

	<h3>Установка базовых настроек</h3>

    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<tr>
		<th width="35%">Название</th>
		<th width="45%">Значения</th>
      	<th width="20%"> &nbsp; </th>
	</tr>
<?php
/*
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Номер кошелька WebMoney (USD):</td>
		<td class="fr">
			<input type="hidden" name="optid" value="1" />
			<input class="field" type="text" name="optval" value="<?=$opts[1];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Номер кошелька WebMoney (GRN):</td>
		<td class="fr">
			<input type="hidden" name="optid" value="2" />
			<input class="field" type="text" name="optval" value="<?=$opts[2];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
*/
?>
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Курс доллара:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="1" />
			<input class="field" type="text" name="optval" value="<?=$opts[1];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Курс евро:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="2" />
			<input class="field" type="text" name="optval" value="<?=$opts[2];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Период обновления ленты:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="3" />
			<input class="field" type="text" name="optval" value="<?=$opts[3];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Период жизни ленты:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="4" />
			<input class="field" type="text" name="optval" value="<?=$opts[4];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	<tr>
		<td class="ff" colspan="3" style="text-align: center; padding: 14px 0px 2px 0px;"><b>Параметры рейтинга компаний</b></td>
	</tr>
	
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">PM_K - коєффициент для посещений:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="5" />
			<input class="field" type="text" name="optval" value="<?=$opts[5];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">C_TZU - Наличие ТЗУ:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="6" />
			<input class="field" type="text" name="optval" value="<?=$opts[6];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">C_VAC - Наличие вакансий:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="7" />
			<input class="field" type="text" name="optval" value="<?=$opts[7];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">C_NEWS - Наличие новостей:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="8" />
			<input class="field" type="text" name="optval" value="<?=$opts[8];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">C_PR - Наличие цен:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="9" />
			<input class="field" type="text" name="optval" value="<?=$opts[9];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">C_LOGO - Наличие логотипа:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="10" />
			<input class="field" type="text" name="optval" value="<?=$opts[10];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">C_DESCR - Наличие описания > 1000 знаков:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="11" />
			<input class="field" type="text" name="optval" value="<?=$opts[11];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">C_CONT - Наличие контактов для отделений:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="12" />
			<input class="field" type="text" name="optval" value="<?=$opts[12];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	
	<tr>
		<td class="ff" colspan="3" style="text-align: center; padding: 14px 0px 2px 0px;"><b>Параметры мессенджера</b></td>
	</tr>
	
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Макс. кол-во предложений:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="13" />
			<input class="field" type="text" name="optval" value="<?=$opts[13];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	
	<tr>
		<td class="ff" colspan="3" style="text-align: center; padding: 14px 0px 2px 0px;"><b>Параметры пользователя</b></td>
	</tr>
	
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Макс. кол-во объявлений:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="14" />
			<input class="field" type="text" name="optval" value="<?=$opts[14];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Публиковать объяв. без премодер.:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="15" />
			<select name="optval">
				<option value="0" <?=($opts[15] == 0 ? " selected" : "");?>>Нет, только после модерации</option>
				<option value="1" <?=($opts[15] == 1 ? " selected" : "");?>>Да, публиковать сразу на доске</option>
			</select>
		</td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	
	
	<tr>
		<td class="ff" colspan="3" style="text-align: center; padding: 14px 0px 2px 0px;"><b>Пополенение счета/биллинг</b></td>
	</tr>
	
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Мин. сумма пополнения:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="16" />
			<input class="field" type="text" name="optval" value="<?=$opts[16];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	
	<tr>
		<td class="ff" colspan="3" style="text-align: center; padding: 14px 0px 2px 0px;"><b>Настройка доски объявлений</b></td>
	</tr>
	
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Время между беспл. апом:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="17" />
			<input class="field" type="text" name="optval" value="<?=$opts[17];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Время до деактивации объявл.:</td>
		<td class="fr">
			<input type="hidden" name="optid" value="18" />
			<input class="field" type="text" name="optval" value="<?=$opts[18];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	
	<tr>
		<td class="ff" colspan="3" style="text-align: center; padding: 14px 0px 2px 0px;"><b>Подписки</b></td>
	</tr>
	
	<form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
	<tr>
		<td class="ff">Время подписки на цены (дней):</td>
		<td class="fr">
			<input type="hidden" name="optid" value="19" />
			<input class="field" type="text" name="optval" value="<?=$opts[19];?>" /></td>
		<td class="fr"><input type="submit" value=" Применить " /></td>
	</tr>
	</form>
	
		</table>
		</td></tr>
	</table>

<?php
	include "inc/footer-inc.php";

	include "../inc/close-inc.php";
?>
