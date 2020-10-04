<?php
	$HTMLAREA=true;

	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

    $PAGE_HEADER['ru'] = "Выбрать язык сайта";
   	$PAGE_HEADER['en'] = "Select website layout language";

	//Include Top Header HTML Style
	include "inc/header-inc.php";

    $strings["hdrsel"]["ru"] = "Выберете язык ресурсов для редактирования";
    $strings["hdredit"]["ru"] = "Редактировать страницу";
    $strings["rowedit"]["ru"] = "Язык ресурсов";
    $strings["btnapply"]["ru"] = "Применить";

	$strings["hdrsel"]["en"] = "Select resource language for editing";
	$strings["hdredit"]["en"] = "Editing page";
	$strings["rowedit"]["en"] = "Edit page";
	$strings["btnapply"]["en"] = "Apply";

?>

<h3><?=$strings["hdrsel"][$lang];?></h3>

<center>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="post" name="frm">
	<tr>
		<td class="ff"><?=$strings["rowedit"][$lang];?>: </td>
		<td class="fr">
			<select name="newlangid">
<?php
				if( $result = mysqli_query($upd_link_db,"SELECT * FROM ".$TABLE_LANGS." ORDER BY id") )
				{
					while( $row = mysqli_fetch_array($result) )
					{
						echo "<option value=\"".$row['id']."\"".(($row['id']==$LangId)?" selected":"").">".$row['lang_name']."</option>\r\n";
					}
				}
?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="fr" align="center"><input type="submit" value="<?=$strings["btnapply"][$lang];?>"></td>
	</tr>
	</form>
	</table>
	</td></tr>
	</table>
</center>

<?php
	include ("inc/footer-inc.php");

	include ("../inc/close-inc.php");
?>
