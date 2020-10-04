<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Edit product params";
   	$strings['tipdel']['en'] = "Delete this parameter";
	$strings['tipedit']['ru'] = "Редактировать фильтры товаров";
   	$strings['tipdel']['ru'] = "Удалить фильтр из списка";
	$PAGE_HEADER['ru'] = "Генерация размеров";
	$PAGE_HEADER['en'] = "Product Parameters Editing";

	include "inc/header-inc.php";
	$profid = GetParameter("profid", "0");
	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$min_l = GetParameter("min_l", "");
	$max_l = GetParameter("max_l", "");
	$dip_l = GetParameter("dip_l", "");
	$min_w = GetParameter("min_w", "");
	$max_w = GetParameter("max_w", "");
	$dip_w = GetParameter("dip_w", "");

	if($res=mysqli_query($upd_link_db,"SELECT * FROM neolux_cat_item_size WHERE profile_id='$profid'")){
		if(mysqli_num_rows($res)>0){
			$mode="edit";
		}
	}else{
		echo mysqli_error($upd_link_db);
	}

	switch( $action )
	{
    	case "add":

    		$query = "INSERT INTO neolux_cat_item_size ( profile_id, min_l, max_l, dip_l, min_w, max_w, dip_w)
    			VALUES ('".$profid."', '".$min_l."', '".$max_l."', '".$dip_l."', '".$min_w."', '".$max_w."', '".$dip_w."')";
			if(!mysqli_query($upd_link_db,$query))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

		$mode="edit";
	break;
	case "update":

		if(!mysqli_query($upd_link_db,"UPDATE neolux_cat_item_size
		SET min_l='".$min_l."', max_l='".$max_l."', dip_l='".$dip_l."', min_w='".$min_w."', max_w='".$max_w."', dip_w='".$dip_w."'
		WHERE profile_id='".$profid."'"))
		{
			echo "<b>".mysqli_error($upd_link_db)."</b>";
		}

	break;
	}
	if( $profid == 0 )
	{
?>
		<h3>Необходимо выбрать тип товаров</h3>
		<table align="center" cellspacing="2" cellpadding="0">
		<form action="<?=$PHP_SELF;?>" method=POST>
		<input type="hidden" name="action" value="typesel" />
		<tr>
			<td class="ff">Тип товаров:</td>
			<td class="fr">
				<select name="profid">
	<?php
			$query = "SELECT p1.*, p2.type_name, p2.descr
				FROM $TABLE_CAT_PROFILE p1, $TABLE_CAT_PROFILE_LANGS p2
				WHERE p1.id=p2.profile_id AND p2.lang_id='$LangId' ORDER BY p2.type_name";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object( $res ) )
			    {
				echo "<option value=\"".$row->id."\">".stripslashes($row->type_name)."</option>";
				}
				mysqli_free_result( $res );
			}
	?>
				</select>
			</td>
		</tr>
		<tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Выбрать "></td></tr>
		</form>
		</table>
<?php
	}else{
		if( $mode == "edit" )
		{

			$min_l = "";
			$max_l = "";
			$dip_l = "";
			$min_w = "";
			$max_w = "";
			$dip_w = "";
			if($res = mysqli_query($upd_link_db,"SELECT * FROM neolux_cat_item_size WHERE profile_id='$profid'"))
			{
				if($row = mysqli_fetch_object($res))
				{
					$min_l = $row->min_l;
					$max_l = $row->max_l;
					$dip_l = $row->dip_l;
					$min_w = $row->min_w;
					$max_w = $row->max_w;
					$dip_w = $row->dip_w;
				}
				mysqli_free_result($res);
			}
	?>
			<h3>Редактировать</h3>
		    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
		    <tr><td>
			<table width="100%" cellspacing="1" cellpadding="1" border="0">
			<form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="profid" value="<?=$profid;?>" />
			<tr><td class="ff">Минимальная длина:</td><td class="fr"><input type="text" size="10" name="min_l" value="<?=$min_l;?>" /></td></tr>
		        <tr><td class="ff">Максимальная длина:</td><td class="fr"><input type="text" size="10" name="max_l" value="<?=$max_l;?>" /></td></tr>
		        <tr><td class="ff">Диапозон длины:</td><td class="fr"><input type="text" size="10" name="dip_l" value="<?=$dip_l;?>" /></td></tr>
		        <tr><td class="ff">Минимальная ширина:</td><td class="fr"><input type="text" size="10" name="min_w" value="<?=$min_w;?>" /></td></tr>
		        <tr><td class="ff">Максимальная ширина:</td><td class="fr"><input type="text" size="10" name="max_w" value="<?=$max_w;?>" /></td></tr>
		        <tr><td class="ff">Диапозон ширины:</td><td class="fr"><input type="text" size="10" name="dip_w" value="<?=$dip_w;?>" /></td></tr>
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
		<br /><br />
		<h3>Сгенерировать Размер</h3>
		<table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
		<tr><td>
		    <table width="100%" cellspacing="1" cellpadding="1" border="0">
			    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
				<input type="hidden" name="profid" value="<?=$profid;?>" />
				<input type="hidden" name="action" value="add">
				<tr><td class="ff">Минимальная длина:</td><td class="fr"><input type="text" size="10" name="min_l" value="<?=$min_l;?>" /></td></tr>
				<tr><td class="ff">Максимальная длина:</td><td class="fr"><input type="text" size="10" name="max_l" value="<?=$max_l;?>" /></td></tr>
				<tr><td class="ff">Диапозон длины:</td><td class="fr"><input type="text" size="10" name="dip_l" value="<?=$dip_l;?>" /></td></tr>
				<tr><td class="ff">Минимальная ширина:</td><td class="fr"><input type="text" size="10" name="min_w" value="<?=$min_w;?>" /></td></tr>
				<tr><td class="ff">Максимальная ширина:</td><td class="fr"><input type="text" size="10" name="max_w" value="<?=$max_w;?>" /></td></tr>
				<tr><td class="ff">Диапозон ширины:</td><td class="fr"><input type="text" size="10" name="dip_w" value="<?=$dip_w;?>" /></td></tr>
				<tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Сгенерировать "></td></tr>
			    </form>
		    </table>
		    </td></tr>
		</table>
	<?php
	    }
	}

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
