<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }
	
	 include "../inc/utils-inc.php";

function checkDtFormat($dt)
{
	if( !(
		is_numeric(substr($dt, 0, 1)) &&
		is_numeric(substr($dt, 1, 1)) &&
		is_numeric(substr($dt, 3, 1)) &&
		is_numeric(substr($dt, 4, 1)) &&
		is_numeric(substr($dt, 6, 1)) &&
		is_numeric(substr($dt, 7, 1)) &&
		is_numeric(substr($dt, 8, 1)) &&
		is_numeric(substr($dt, 9, 1))
		) )
		return false;

	$starr = split("[.]", $dt);
	if( (count($starr) == 3) &&
		is_numeric($starr[1]) && is_numeric($starr[0]) && is_numeric($starr[2]) &&
	 	!checkdate( $starr[1], $starr[0], $starr[2] ) )
	{
		return false;
	}

	return true;
}

	$strings['tipedit']['en'] = "Edit This Comment";
   	$strings['tipdel']['en'] = "Delete This Comment";
   	$strings['hdrlist']['en'] = "Comment List";
   	$strings['hdradd']['en'] = "Add Comment";
   	$strings['hdredit']['en'] = "Edit Comment";
   	$strings['rowdate']['en'] = "Comment date";
   	$strings['rowtitle']['en'] = "Name";
   	$strings['rowfirst']['en'] = "Preview Page";
   	$strings['rowtext']['en'] = "Comment Text";
   	$strings['rowbrand']['en'] = "Company Source";
   	$strings['btnadd']['en'] = "Add";
   	$strings['btndel']['en'] = "Delete";
   	$strings['btnedit']['en'] = "Edit";
   	$strings['btnrefresh']['en'] = "Update";
   	$strings['nolist']['en'] = "No comments in database";
   	$strings['rowcont']['en'] = "Content";
   	$strings['rowfunc']['en'] = "Functions";
	$strings['product']['en'] ="Product";

    $strings['tipedit']['ru'] = "Редактировать";
   	$strings['tipdel']['ru'] = "Удалить";
   	$strings['hdrlist']['ru'] = "Список запросов";
   	$strings['hdradd']['ru'] = "Добавить отзыв";
   	$strings['hdredit']['ru'] = "Редакировать";
   	$strings['rowdate']['ru'] = "Дата";
   	$strings['rowtitle']['ru'] = "Имя";
   	$strings['rowfirst']['ru'] = "Показывать на сайте";
   	$strings['rowtext']['ru'] = "Текст";
   	$strings['rowbrand']['ru'] = "Компания";
    $strings['btnadd']['ru'] = "Добавить";
   	$strings['btndel']['ru'] = "Удалить";
   	$strings['btnedit']['ru'] = "Редактировать";
   	$strings['btnrefresh']['ru'] = "Обновить";
   	$strings['nolist']['ru'] = "В базе нет статистики запросов";
    $strings['rowcont']['ru'] = "Содержание записей";
   	$strings['rowfunc']['ru'] = "Функции";
	$strings['product']['ru']="Продукт";
	$strings['article']['ru']="Статья";

	$PAGE_HEADER['ru'] = "Ключевые слова подбора рубрик на доске объявлений";
	$PAGE_HEADER['en'] = "Board keyword links";



	/////////////////////////////////////////////////////////////////////
	//
	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	$datest = GetParameter("datest", date("d.m.Y", time()));

	$topicid0 = GetParameter("topicid0", 0);

	switch( $action )
	{
		case "delete":
			$com_id = GetParameter("com_id", "0");

			// Delete selected news
			for($i = 0; $i < count($com_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_ADV_WORDCROSS WHERE id=".$com_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_ADV_WORDCROSS WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
    		break;

		case "update":
			$item_id = GetParameter("item_id", "0");
			$newstitle = GetParameter("newstitle", "");
			$newstid = GetParameter("newstid", 0);
			//$newsauthor = GetParameter("newsauthor", "");
    		//$newscont = GetParameter("newscont", "", false);
    		$newsrate = GetParameter("newsrate", 0);
    		//$newsbrand = GetParameter("newsbrand", 0);
    		$myfile = GetParameter("myfile", "");			

			//if( $newstid == 0 )
			//	break;
		
			$newstid00 = explode(":", $newstid);
			if( count($newstid00) != 2 )
				break;
			
			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_ADV_WORDCROSS SET rtopic_id='".addslashes($newstid00[0])."', topic_id='".addslashes($newstid00[1])."', keyword='".addslashes($newstitle)."', rating='".addslashes($newsrate)."' WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;
			
		case "addword":
			$newstitle = GetParameter("newstitle", "");
			$newstid = GetParameter("newstid", 0);
			//$newsauthor = GetParameter("newsauthor", "");
    		//$newscont = GetParameter("newscont", "", false);
    		$newsrate = GetParameter("newsrate", 0);
			
			$newstid00 = explode(":", $newstid);
			if( count($newstid00) != 2 )
				break;
			
			//if( $newstid == 0 )
			//	break;
			
			$query = "INSERT INTO $TABLE_ADV_WORDCROSS (rtopic_id, topic_id, keyword, rating, add_date) VALUES ('".$newstid00[0]."', '".$newstid00[1]."','".addslashes($newstitle)."', '".addslashes($newsrate)."', NOW())";
			if(!mysqli_query($upd_link_db,$query))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;
	}
	
	
	///////////////////////////////////////////////
	//
	// Include Top Header HTML Style
	include "inc/header-inc.php";
	//
	///////////////////////////////////////////////


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$newstitle = "";
		$newstid = 0;
		$newsauthor = "";
		$newscont = "";
		$newsrate = 0;
		//$datest = date("d.m.Y", time());
		//$newsbrand = 0;
		$myfile = "";

		if($res = mysqli_query($upd_link_db,"SELECT * FROM $TABLE_ADV_WORDCROSS WHERE id='$item_id'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$newstitle= stripslashes($row->keyword);
				//$newsauthor= stripslashes($row->author);
				//$newscont = stripslashes($row->content);
				$newstid = $row->topic_id;
				$newsrate = $row->rating;
				//$newsbrand = $row->brand_id;
				//$datest = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);


			}
			mysqli_free_result($res);
		}

		//echo "ID: $item_id<br />";
?>

	<h3><?=$strings['hdredit'][$lang];?></h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST" name="advfrm">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />	
	<tr><td class="ff">Запрос:</td><td class="fr"><input type="text" size="70" name="newstitle" value="<?=$newstitle;?>" /></td></tr>
	<tr><td class="ff">Рейтинг:</td><td class="fr"><input type="text" size="5" name="newsrate" value="<?=$newsrate;?>" /></td></tr>
	
	
	<tr><td class="ff">Раздел:</td><td class="fr">
		<select name="topicid0" id="topicgroup" onchange="reloadSects(this, 'topicid')">
			<option value="0">--- Все разделы ---</option>
<?php
		$topics = Board_TopicLevel($LangId, 0, "bygroups");
		
		$grcurname = "";
		
		for( $i=0; $i<count($topics); $i++ )
		{
			if( $grcurname != $topics[$i]['group'] )
			{
				//echo '<option value="0:0">'.( $topics[$i]['group'] != "" ? $topics[$i]['group'] : 'Разное').'</option>';
				echo '<option value="0">'.( $topics[$i]['group'] != "" ? $topics[$i]['group'] : 'Разное').'</option>';
				$grcurname = $topics[$i]['group'];
			}
			//echo '<option value="0:'.$topics[$i]['id'].'"'.($topicsid == $topics[$i]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp;'.$topics[$i]['name'].'</option>';
			echo '<option value="'.$topics[$i]['id'].'"'.($topicid0 == $topics[$i]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp;'.$topics[$i]['name'].'</option>';
			/*
			$subtopics = Board_TopicLevel($LangId, $topics[$i]['id']);
			for( $j=0; $j<count($subtopics); $j++ )
			{
				echo '<option value="1:'.$subtopics[$j]['id'].'"'.($topicsid == $subtopics[$j]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;'.$subtopics[$j]['name'].'</option>';
			}
			*/
		}
?>
		</select>
	</td></tr>
	<tr><td class="ff">Секция:</td><td class="fr">
		<select name="newstid" id="topicid">
			<option value="0:0">--- Все секции ---</option>
		</select>
	</td></tr>
	
	<?php
	/*
	<tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea rows="14" cols="80" name="newscont"><?=$newscont;?></textarea></td></tr>
	<tr>
		<td class="ff"><?=$strings['rowfirst'][$lang];?>:</td>
		<td class="fr"><select name="newsfirst">
			<option value="0"<?=( $newsfirst == 0 ? " selected ": "" );?>>НЕТ</option>
			<option value="1"<?=( $newsfirst == 1 ? " selected ": "" );?>>ДА</option>
		</select></td></tr>
    <script language="javascript1.2">
    	editor_generate('newscont'); // field, width, height
	</script>
	*/
	?>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" <?=$strings['btnrefresh'][$lang];?> "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
<script type="text/javascript">
$(document).ready( function() {
	reloadSects( document.getElementById('topicgroup'), 'topicid');
});

function reloadSects(selobj, comboid)
{
	var tid = selobj.options[selobj.selectedIndex].value;
	
	if( tid == 0 )
		return;
	
	$.ajax({
        type: "GET",
        url: "/admin/ajx/ajx_jq.php",
        data: 'cmd=uh_com_topics&tid='+tid,
        dataType: "text",
        success: function(data){
			//alert(data);
			var res = $.parseJSON(data);
			//eval('var rays = '+data+';');
			
			//alert( res.tlist.length );

			var cobj = document.getElementById(comboid);
			cobj.options.length = 0; //new Array();
			cobj.options[0] = new Option("--- Все секции ---", 0);

			for(i=0;i<res.tlist.length;i++)
			{
				cobj.options[i+1] = new Option(res.tlist[i].tn, tid+":"+res.tlist[i].tid);
			}
        },
		error: function(){
			alert("error");
		}
	});
}
</script>
<?php
	}
	else
	{
?>

        <h3><?=$strings['hdradd'][$lang];?></h3>
        <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
            <tr><td>
                    <table width="100%" cellspacing="1" cellpadding="1" border="0">
                        <form action="<?=$PHP_SELF;?>" method="POST" name="advfrm">
                            <input type="hidden" name="action" value="addword" />
                            <input type="hidden" name="item_id" value="<?=$item_id;?>" />
                            <tr><td class="ff">Запрос:</td><td class="fr"><input type="text" size="70" name="newstitle" value="" /></td></tr>
                            <tr><td class="ff">Рейтинг:</td><td class="fr"><input type="text" size="5" name="newsrate" value="0" /></td></tr>


                            <tr><td class="ff">Раздел:</td><td class="fr">
                                    <select name="topicid0" id="topicgroup" onchange="reloadSects(this, 'topicid')">
                                        <option value="0">--- Все разделы ---</option>
                                        <?php
                                        $topics = Board_TopicLevel($LangId, 0, "bygroups");

                                        $grcurname = "";

                                        for( $i=0; $i<count($topics); $i++ )
                                        {
                                            if( $grcurname != $topics[$i]['group'] )
                                            {
                                                //echo '<option value="0:0">'.( $topics[$i]['group'] != "" ? $topics[$i]['group'] : 'Разное').'</option>';
                                                echo '<option value="0">'.( $topics[$i]['group'] != "" ? $topics[$i]['group'] : 'Разное').'</option>';
                                                $grcurname = $topics[$i]['group'];
                                            }
                                            //echo '<option value="0:'.$topics[$i]['id'].'"'.($topicsid == $topics[$i]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp;'.$topics[$i]['name'].'</option>';
                                            echo '<option value="'.$topics[$i]['id'].'"'.($topicid0 == $topics[$i]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp;'.$topics[$i]['name'].'</option>';
                                            /*
                                            $subtopics = Board_TopicLevel($LangId, $topics[$i]['id']);
                                            for( $j=0; $j<count($subtopics); $j++ )
                                            {
                                                echo '<option value="1:'.$subtopics[$j]['id'].'"'.($topicsid == $subtopics[$j]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;'.$subtopics[$j]['name'].'</option>';
                                            }
                                            */
                                        }
                                        ?>
                                    </select>
                                </td></tr>
                            <tr><td class="ff">Секция:</td><td class="fr">
                                    <select name="newstid" id="topicid">
                                        <option value="0:0">--- Все секции ---</option>
                                    </select>
                                </td></tr>

                            <?php
                            /*
                            <tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea rows="14" cols="80" name="newscont"><?=$newscont;?></textarea></td></tr>
                            <tr>
                                <td class="ff"><?=$strings['rowfirst'][$lang];?>:</td>
                                <td class="fr"><select name="newsfirst">
                                    <option value="0"<?=( $newsfirst == 0 ? " selected ": "" );?>>НЕТ</option>
                                    <option value="1"<?=( $newsfirst == 1 ? " selected ": "" );?>>ДА</option>
                                </select></td></tr>
                            <script language="javascript1.2">
                                editor_generate('newscont'); // field, width, height
                            </script>
                            */
                            ?>
                            <tr><td colspan="2" class="fr" align="center"><input type="submit" value=" <?=$strings['btnadd'][$lang];?> "></td></tr>
                        </form>
                    </table>
                </td></tr>
        </table>
    <h3><?=$strings['hdrlist'][$lang];?></h3>
<?php
/*
    <div style="padding: 10px 0px 10px 10px;">Группа новостей: &nbsp;
<?php
	for( $i=0; $i<count($ntype_arr); $i++ )
	{
		if( $i > 0 )
			echo ' &nbsp;::&nbsp; ';

		if( $ntype == $i )
			echo '<b>'.$ntype_arr[$i].'</b>';
		else
			echo '<a href="news.php?ntype='.$i.'">'.$ntype_arr[$i].'</a>';
	}
?>
    </div>
*/
?>

    <table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr>
    	<th>&nbsp;</th>
		<th style="padding: 1px 10px 1px 20px">Раздел</th>
    	<th style="padding: 1px 10px 1px 20px">Запрос</th>
    	<th>Дата создания</th>
    	<th>Рейтинг</th>
    	<th><?=$strings['rowfunc'][$lang];?></th>
    </tr>
<?php
    	$found_news = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT w1.*, t1.title as topictitle 
			FROM $TABLE_ADV_WORDCROSS w1 
			INNER JOIN $TABLE_ADV_TOPIC t1 ON w1.topic_id=t1.id 			
			ORDER BY t1.id, w1.keyword") )
		{
			while($row=mysqli_fetch_object($res))
			{
				$found_news++;

				echo "<tr>
					<td><input type=\"checkbox\" name='com_id[]' value=\"".$row->id."\" /></td>
					<td style=\"padding: 2px 10px 2px 10px;\"><b>".stripslashes($row->topictitle)."</b></td>
					<td style=\"padding: 2px 10px 2px 10px;\">".stripslashes($row->keyword)."</td>
					<td align=\"center\">".($row->add_date)."</td>
					<td align=\"center\">".($row->rating)."</td>
					<td align=\"center\">
						<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
						".( false ? "<a href=\"$PHP_SELF?mode=edit&item_id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp; " : "" )."
					</td>
				</tr>
				<tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";

			}
			mysqli_free_result($res);
		}

		if( $found_news == 0 )
		{
			echo "<tr><td colspan=\"6\" align=\"center\"><br />".$strings['nolist'][$lang]."<br /><br /></td></tr>
			<tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"6\"><input type=\"submit\" name=\"delete_but\" value=\" ".$strings['btndel'][$lang]." \" /> <input type=\"submit\" name=\"refresh_but\" value=\" ".$strings['btnrefresh'][$lang]." \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
	


<script type="text/javascript">
$(document).ready( function() {
	reloadSects( document.getElementById('topicgroup'), 'topicid');
});

function reloadSects(selobj, comboid)
{
	var tid = selobj.options[selobj.selectedIndex].value;
	
	if( tid == 0 )
		return;
	
	$.ajax({
        type: "GET",
        url: "/admin/ajx/ajx_jq.php",
        data: 'cmd=uh_com_topics&tid='+tid,
        dataType: "text",
        success: function(data){
			//alert(data);
			var res = $.parseJSON(data);
			//eval('var rays = '+data+';');
			
			//alert( res.tlist.length );

			var cobj = document.getElementById(comboid);
			cobj.options.length = 0; //new Array();
			cobj.options[0] = new Option("--- Все секции ---", 0);

			for(i=0;i<res.tlist.length;i++)
			{
				cobj.options[i+1] = new Option(res.tlist[i].tn, tid+":"+res.tlist[i].tid);
			}
        },
		error: function(){
			alert("error");
		}
	});
}
</script>

<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
