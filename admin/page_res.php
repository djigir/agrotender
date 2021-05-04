<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/ses-inc.php";

	include "inc/authorize-inc.php";

	if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$PAGE_HEADER['ru'] = "Редактировать Текстовые Блоки Сайта";
	$PAGE_HEADER['en'] = "Edit Text Blocks";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$action = GetParameter("action", "");

	switch($action)
	{
		case "apply":
			$id = GetParameter("id", "");
			$content = GetParameter("content", "", false);
			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_RESOURCE_LANGS SET content='".addslashes($content)."' WHERE id='$id'"))
			{
				echo mysqli_error($upd_link_db);
			}
			break;
	}

	$arr_val = Array();
	if($res = mysqli_query($upd_link_db,"SELECT r1.*, r2.id as id1, r2.content FROM $TABLE_RESOURCE r1
		INNER JOIN $TABLE_RESOURCE_LANGS r2 ON r1.id=r2.item_id AND r2.lang_id='$LangId'
		ORDER BY r1.id"))
	{
		while($row=mysqli_fetch_object($res))
		{
    		$ai = Array();
	    	$ai['id'] = stripslashes($row->id1);
	    	$ai['name'] = stripslashes($row->name);
	    	$ai['title'] = stripslashes($row->title);
	    	$ai['content'] = stripslashes($row->content);
			$arr_val[] = $ai;
	    }
	    mysqli_free_result($res);
	}
?>

	<h3>Установка контента</h3>

<?php
	for($i=0; $i<count($arr_val); $i++)
	{
?>
    <table align="center" width="90%" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="apply" />
    <input type="hidden" name="id" value="<?=$arr_val[$i]['id'];?>" />
	<tr>
		<th width="35%">Название</th>
		<th width="65%">Значение</th>
	</tr>
	<tr>
		<td class="ff"><?=$arr_val[$i]['title'];?>:</td>
		<td class="fr"><textarea class="field" id="content<?=$arr_val[$i]['id'];?>" name="content" cols="70" rows="8"><?=$arr_val[$i]['content'];?></textarea></td>
	</tr>
<script language="javascript1.2">
    editor_generate('content<?=$arr_val[$i]['id'];?>'); // field, width, height
</script>
	<tr><td class="fr" colspan="2" align="center"><br /><input type="submit" name="update" value=" Применить " /><br /><br /></td></tr>
	</form>
		</table>
		</td></tr>
	</table>
	<br />
<?php
	}
?>

<?php
	include "inc/footer-inc.php";

	include "../inc/close-inc.php";
?>
