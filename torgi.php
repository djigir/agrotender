<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////

	////////////////////////////////////////////////////////////////////////////
	//   Website Start page module                                            //
	////////////////////////////////////////////////////////////////////////////
	include "inc/db-inc.php";
	include "inc/connect-inc.php";

	include "inc/utils-inc.php";
	//include "inc/catutils-inc.php";
	include "inc/torgutils-inc.php";
	include "inc/newsutils-inc.php";

	include "inc/ses-inc.php";
	include "inc/buyerauth-inc.php";

	////////////////////////////////////////////////////////////////////////////
	//                          Page Options                                  //
	////////////////////////////////////////////////////////////////////////////


	////////////////////////////////////////////////////////////////////////////
	// Request parameters
	$SORTBY_DEF = "timeend_down";
	$VIEW_DEF = "list";
	$SORTODIR = Array("up" => "down", "down" => "up");
	$SORTCOLRU = Array("timeend" => "времени окончания", "lotid" => "номеру торгов", "amount" => "объему", "ray" => "району", "stcost" => "стартовой цене",
		"nowcost" => "текущей цене", "elev" => "элеватору", "cult" => "культуре", "obl" => "области", "torg" => "типу торгов");
	$SORTDIRRU = Array("up" => "возростанию", "down" => "убванию");

	$trade_names = Array("", "Закупки", "Продажи");
	$trade_names2 = Array("Разместить предложение", "Купить", "Продать");

	$action = GetParameter("action", "");
	$obl = GetParameter("obl", 0);
	$oblurl = GetParameter("oblurl", "");
	$cult = GetParameter("cult", 0);
	$culturl = GetParameter("culturl", "");
	$onlydomen = GetParameter("onlydomen", 0);
	$trade = GetParameter("trade", 0);	// $TORG_BUY;
	$tradeurl = GetParameter("tradeurl", "");
	$raylist = GetParameter("raylist", null);
	$ray_url = GetParameter("ray_url", "");
	$ray_url2 = GetParameter("ray_url2", "");
	$vblock = GetParameter("vblock", "");

	if( $ray_url2 != "" )
	{
		$ray_url = substr($ray_url2, 4, strlen($ray_url2)-5);
	}

	$lotelev = 1;	//GetParameter("lotelev", 0);
	$lothoz = 1;	//GetParameter("lothoz", 0);

	$elevids = GetParameter("elevids", null);
	$elev_url = GetParameter("elev_url", "");

	$sortby = GetParameter("sortby", $SORTBY_DEF);
	$viewmod = GetParameter("viewmod", $VIEW_DEF);

	$pi = GetParameter("pi",1);
	$pn = GetParameter("pn",0);

	if( isset($_COOKIE["pnnum"]) )
	{
		$pn_c = $_COOKIE["pnnum"];
	}
	else
	{
		$pn_c = 0;
	}

	//var_dump($_COOKIE);

	if( ($pn > 0) && ($pn != $pn_c) )
	{
		setcookie("pnnum", $pn);
		//echo "!!";
	}
	else if( $pn_c != 0 )
	{
		$pn = $pn_c;
	}
	else
	{
		$pn = 25;
	}



	$mode = "";
	$msg = "";

	if( $oblurl != "" )
	{
		if( $oblurl == "ukraine" )
		{
			$obl = 0;
		}
		else
		{
			for( $i=1; $i<count($REGIONS_URL); $i++ )
			{
				if( $oblurl == $REGIONS_URL[$i] )
				{
					$obl = $i;
					break;
				}
			}
		}
	}

	switch( $tradeurl )
	{
		case "kupit":	$trade = 1; break;
		case "prodaga":	$trade = 2; break;
		case "all":
		case "":
			//if( $obl == 0 )
			//{
				$trade = 0;
			//}
			break;
	}

	if( $sortby == "" )
	{
		$sortby = $SORTBY_DEF;
	}
	$sortby_parts = @str_split("_", $sortby, 2);
	$sortby_col = $sortby_parts[0];
	$sortby_order = $sortby_parts[1];

	switch( $action )
	{
		case "setray":
			$lotelev = GetParameter("lotelev", 0);
			$lothoz = GetParameter("lothoz", 0);
			if( count($raylist) > 0 )
			{
				$ray_url = join(",",$raylist);
			}

			if( count($elevids) > 0 )
			{
				$elev_url = join(",",$elevids);
			}
			break;
	}

	$raylist = @str_split(",",$ray_url);
	if( (count($raylist) == 1) && ($raylist[0] == "") )
		$raylist = Array();

	//var_dump($elevids);

	$elevids = @str_split(",",$elev_url);
	if( (count($elevids) == 1) && ($elevids[0] == "") )
		$elevids = Array();

	//echo "<br />";
	//var_dump($elevids);


	////////////////////////////////////////////////////////////////////////////
	// Get list of all cultures
	$cult_list = Torg_CultList($LangId);

	if( $obl != 0 )
	{
		$RAYS = Torg_RayonByObl( $LangId, $obl );
	}

	// Set one culture default if it is empty
	$CULT_URL = "";
	$cult0 = $cult;
	if( $culturl != "" )
	{
		$query = "SELECT * FROM $TABLE_TORG_PROFILE WHERE url='".addslashes($culturl)."'";
		if( $res = mysql_query( $query ) )
		{
			if( $row = mysql_fetch_object( $res ) )
			{
				$cult0 = $cult = $row->id;
				$CULT_URL = stripslashes($row->url);
			}
			mysql_free_result( $res );
		}

		if( ($culturl != "") && ($culturl != "index") && ($CULT_URL == "") )
		{
			// Redirect to all cultures
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: '.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, $ray_url, $trade));
			exit();
		}
	}
    //if( (count($cult_list) > 0) && ($cult == 0) )
    //{
    //	$cult = $cult_list[0]['id'];
    //}


    if( $vblock == "_vblock" )
	{
		$viewmod = "block";

		//echo $CULT_URL;

		// Make redirect
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: '.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult));
		exit();
	}


	//echo $ray_url."<br />";
	//var_dump($raylist);

	// detect if we should show rayon map or not
	$mapshow = (($obl != 0) && ($ray_url == ""));

	if( $sortby != $SORTBY_DEF )
	{
		$META_NOINDEX = true;
		//$CANONICAL_PAGE = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, "", $pi, $pn );
	}

	//--------------------------------------------------------------------------
	// Сделать строку с названием выбранных районов
	$ray_str = "";
	if( count($raylist) > 0 )
	{
		for( $i=0; $i<count($raylist); $i++ )
		{
			if( $ray_str != "" )
				$ray_str .= ", ";
			$ray_str .= $RAYS[$raylist[$i]]['name'];
		}

		if( count($raylist) == 1 )
		{
			$ray_str .= " район";
		}
	}
	else
	{
		$raylist = Array();
	}

	$ray_str0 = $ray_str;
	if( strlen($ray_str) > 30 )
	{
		$ray_str = substr($ray_str,0,28)."...";
	}

	//--------------------------------------------------------------------------
	// Сделать выпадающий список для типа торгов
	$torg_drop = "";
	$torg_name = "";
	if( $trade == 1 )	// Купить
	{
		$torg_name = "Закупки";
		$torg_drop .= '<li><a href="'.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, $ray_url, 0, $CULT_URL, $cult).'" class="torglnk">Все тендеры</a></li>';
		$torg_drop .= '<li><a href="'.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, $ray_url, $TORG_SELL, $CULT_URL, $cult).'" class="torglnk">Продажи</a></li>';

	}
	else if( $trade == 2 )
	{
		$torg_name = "Продажи";
		$torg_drop .= '<li><a href="'.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, $ray_url, 0, $CULT_URL, $cult).'" class="torglnk">Все тендеры</a></li>';
		$torg_drop .= '<li><a href="'.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, $ray_url, $TORG_BUY, $CULT_URL, $cult).'" class="torglnk">Закупки</a></li>';
	}
	else	// Все
	{
		$torg_name = "Все тендеры";
		$torg_drop .= '<li><a href="'.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, $ray_url, $TORG_BUY, $CULT_URL, $cult).'" class="torglnk">Закупки</a></li>';
		$torg_drop .= '<li><a href="'.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, $ray_url, $TORG_SELL, $CULT_URL, $cult).'" class="torglnk">Продажи</a></li>';
	}

	//--------------------------------------------------------------------------
	// Сделать выпадающий список для культур
	$cult_name0 = "";
	$cult_name = "";
	$cult_drop = "";

	$cult_col_num = 3;
	$cult_per_col = ceil( (count($cult_list)-1) / $cult_col_num);

	$percolind = 0;
    for( $i=0; $i<count($cult_list); $i++ )
    {
    	if( $cult == $cult_list[$i]['id'] )
    	{
    		// Selected
    		$cult_name0 = $cult_list[$i]['name'];

    		$cult_name = '<img class="float" src="'.$cult_list[$i]['ico'].'" alt="'.$cult_list[$i]['name'].'" width="28" height="29" />
    		<span>'.$cult_list[$i]['name'].'</span>';
    	}
    	else
    	{
    		$percolind++;
    		if( ($percolind % $cult_per_col) == 1 )
    			$cult_drop .= '<ul>';

    		$TURL = Torg_BuildUrl($LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $cult_list[$i]['url'], $cult_list[$i]['id'], $elev_url);
			$cult_drop .= '<li><a href="'.$TURL.'"><img class="float" src="'.$cult_list[$i]['ico'].'" alt="" width="28" height="29" /><span>'.$cult_list[$i]['name'].'</span></a></li>';

    		if( ($percolind % $cult_per_col) == 0 )
    		{
    			$cult_drop .= '</ul>';
    		}
    	}
    }

    if( $cult == 0 )
    {
    	// Показать все
    	$cult_name = '<img class="float" src="'.$IMGHOST.'img/btn_showallculture.gif" alt="Показать все" width="28" height="29" />
    	<span>Все культуры</span>';
    }
    else
    {
    	// Культура вібрана
    	$TURL = Torg_BuildUrl($LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, "", 0, $elev_url);
    	$cult_drop .= '<li><a href="'.$TURL.'"><img class="float" src="'.$IMGHOST.'img/btn_showallculture.gif" alt="" width="28" height="29" /><span>Показать все</span></a></li>';
    }

    if( strrpos($cult_drop, '</ul>') <= (strlen($cult_drop) - 5) )
    	$cult_drop .= '</ul>';

    $cult_drop .= '<div class="both"></div>';

    //--------------------------------------------------------------------------
    $obl_drop = "";
	if( $obl != 0 )
	{
		$OBLURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[0], 0);
		$obl_drop .= '<li><a href="'.$OBLURL.'" class="torglnk2">Вся Украина</a></li>';
	}
	for( $i=1; $i<count($REGIONS); $i++ )
	{
		if( $obl == $i )
		{
		}
		else
		{
			$OBLURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$i], $i);
			//$TURL = Comp_BuildUrl($LangId, "list", $REGIONS_URL[$i], $adtype, $adtopic);
			$obl_drop .= '<li><a href="'.$OBLURL.'" class="torglnk2">'.$REGIONS[$i].'</a></li>';
		}
	}


	//--------------------------------------------------------------------------
    // Сделать выпадающий список для режима просмотра лотов (таблица или блоки)
    $viewmod_name = "";
    $viewmod_drop = "";
    if( $viewmod == "list" )
    {
    	$viewmod_name = "таблицей";
    	$TURL = Torg_BuildUrl($LangId, "block", $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, ($sortby == $SORTBY_DEF ? "" : $sortby), $pi, $pn );
    	$viewmod_drop = '<li><noindex><a rel="nofollow" href="'.$TURL.'">блоками</a></noindex></li>';
   	}
   	else
   	{
   		$viewmod_name = "блоками";
    	$TURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, ($sortby == $SORTBY_DEF ? "" : $sortby), $pi, $pn );
    	$viewmod_drop = '<li><a href="'.$TURL.'">таблицей</a></li>';
   	}

	//--------------------------------------------------------------------------
	// Сделать хлебные крошки
	$PAGE_PATH		= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" style="display: inline;">
		<a itemprop="url" href="'.$WWWHOST.'"><span itemprop="title">Главная</span></a> ›
	</div>';
	//if( $obl != 0 )
	//{
		$PAGE_PATH	.= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" style="display: inline;">
			<a itemprop="url" href="'.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl).'"><span itemprop="title">Тендеры в '.( $obl == 0 ? "Украине" : $REGIONS2[$obl] ).'</span></a> ›
		</div>';
	//}

	if( $onlydomen != 1 )
	{
		if( $cult0 != 0 )
		{
			//$PAGE_PATH	.= "<a href=\"".Torg_BuildUrl($LangId, "list", $obl, $obl, "", $trade, $cult, $cult)."\">".$cult_name0."</a> › ";
			$PAGE_PATH	.= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" style="display: inline;">
				<a itemprop="url" href="'.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $trade, $CULT_URL, $cult).'"><span itemprop="title">'.$cult_name0.' в '.( $obl == 0 ? "Украине" : $REGIONS2[$obl] ).'</span></a> ›
			</div>';
		}
	}

	$PAGE_PATH		.= ($trade == 0 ? "" : $trade_names[$trade]." › ");
	//$PAGE_PATH	.= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" style="display: inline;">
	//		<a itemprop="url" href="'.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $trade).'"><span itemprop="title">'.($trade == $TORG_BUY ? "Купить" : "Продать").'</span></a> ›
	//	</div>';

	if( $ray_str0 != "" )
	{
		$ray_str00 = $ray_str0;
		if( strlen($ray_str0) > 80 )
			$ray_str00 = substr($ray_str0,0,80)."...";

		$PAGE_PATH .= $ray_str00." › ";
	}

	$PAGE_TITLE = "";
	//$query = "SELECT * FROM $TABLE_TORG_TITLES WHERE obl_id='".$obl."' AND trade='".$trade."' AND cult_id='".$cult0."' AND sortmode_id=0";
	$query = "SELECT * FROM $TABLE_TORG_TITLES WHERE obl_id='0' AND trade='".$trade."' AND cult_id='".$cult0."' AND sortmode_id=0";
	if( $res = mysql_query( $query ) )
	{
		while( $row = mysql_fetch_object( $res ) )
		{
			$PAGE_TITLE = stripslashes($row->page_title);
			$PAGE_KEYWORD = stripslashes($row->page_keywords);
			$PAGE_DESCR = stripslashes($row->page_descr);

			$PAGE_TXT1 = stripslashes($row->content_text);
			$PAGE_TXT2 = stripslashes($row->content_words);
		}
		mysql_free_result( $res );
	}
	else
		echo mysql_error();

	if( $PAGE_TITLE == "" )
	{
		$ptxt1 = Torg_SeoDefTitle( $LangId, $REGIONS[$obl], $trade, $cult0, $cult_name0, 0 );

		$PAGE_TITLE = $ptxt1['title'];
		$PAGE_KEYWORD = $ptxt1['keyw'];
		$PAGE_DESCR = $ptxt1['descr'];

		$PAGE_TXT1 = $ptxt1['txt1'];
		$PAGE_TXT2 = $ptxt1['txt2'];
	}
	else
	{
		$PAGE_TITLE = Torg_SeoTitleParse( $obl, $PAGE_TITLE );
		$PAGE_KEYWORD = Torg_SeoTitleParse( $obl, $PAGE_KEYWORD );
		$PAGE_DESCR = Torg_SeoTitleParse( $obl, $PAGE_DESCR );
		$PAGE_TXT1 = Torg_SeoTitleParse( $obl, $PAGE_TXT1 );
		$PAGE_TXT2 = Torg_SeoTitleParse( $obl, $PAGE_TXT2 );
	}
	//$PAGE_TITLE = ($trade == $TORG_BUY ? "Закупки " : "Продажа ").( $cult0 == 0 ? "аграрной продукции" : $cult_name0).", ".( $obl == "" ? "Украина" : $REGIONS[$obl] )." - онлайн тендеры от Агротендер";

	if( $onlydomen == 1 )
	{
		$page = Page_GetInfo( $LangId, "torgi" );

		$PAGE_TITLE = Torg_SeoTitleParse( $obl, $page['seo_title'] );
		$PAGE_KEYWORD = Torg_SeoTitleParse( $obl, $page['seo_keywords'] );
		$PAGE_DESCR = Torg_SeoTitleParse( $obl, $page['seo_descr'] );
		$PAGE_TXT1 = Torg_SeoTitleParse( $obl, $page['header'] );
		$PAGE_TXT2 = Torg_SeoTitleParse( $obl, $page['content'] );
	}
	else
	{
		if( isset($ray_str00) && ($ray_str00!="") )
		{
			$PAGE_TITLE = "Выбраны районы: ".$ray_str00.". ".$PAGE_TITLE;
		}

		if( $sortby != $SORTBY_DEF )
		{
			$PAGE_TITLE = "Отсортировано по: ".$SORTCOLRU[$sortby_col].", ".$SORTDIRRU[$sortby_order].". ".$PAGE_TITLE;
			$PAGE_DESCR = "Торги отсортированы по: ".$SORTCOLRU[$sortby_col].", ".$SORTDIRRU[$sortby_order].". ".$PAGE_DESCR;
		}

		if( $pi > 1 )
		{
			$PAGE_TITLE = "Страница ".$pi.", ".$PAGE_TITLE;
			$PAGE_DESCR = "Страница ".$pi.", ".$PAGE_DESCR;
		}
	}

	////////////////////////////////////////////////////////////////////////////
	include "inc/header-inc.php";

	if( isset($_SERVER["HTTP_REFERER"]) && (strpos($_SERVER["HTTP_REFERER"], "google") > 0) )
	{
		//echo "from Google";
		$SHOW_POPUP_ADV = true;
	}
	else if( isset($_SERVER["HTTP_REFERER"]) && (strpos($_SERVER["HTTP_REFERER"], "yandex") > 0) )
	{
		//echo "from Yandex";
		$SHOW_POPUP_ADV = true;
	}

	//echo $_SERVER["HTTP_REFERER"];//." ".$_SERVER["QUERY_STRING"];
?>
	<div class="mbreadcrumbs">
		<?=$PAGE_PATH;?>
	</div>
<?php
	$ban_html = Banners_Place_Show( 2, 11, $ALLBANS );
	if( $ban_html != "" )
	{
		echo '<div class="cenbanner2">'.$ban_html.'</div>';
	}
?>
<script type="text/javascript">
var mapopen = <?=($mapshow ? "true" : "false");?>;
var elevtip = false;
var elevtiptimer = 0;
var reqajxhost = '<?=( $WWW_LINK_MODE == "php" ? $WWWHOST : "http://".$oblurl.".agrotender.com.ua/" );?>';
$(document).ready(function()
{
	$("#a-mntcc").bind("click",function(){
		$("#a-mntcc").hide();
		$("#mncclose").hide();
		$("#mappan").show("slow");
		$("#a-mntco").show();
		mapopen = true;
		return false
	});

	$("#a-mntco").bind("click",function(){
		$("#mappan").hide("fast");
		$("#a-mntco").hide();
		$("#a-mntcc").show();
		$("#mncclose").show();
		mapopen = false;
		return false
	});

	$("#chka-all").bind("click",function(){
		$("#rayontbl input[type='checkbox']").attr('checked', true);
		return false
	});

	$("#chka-cancel").bind("click",function(){
		$("#rayontbl input[type='checkbox']").attr('checked', false);
		return false
	});

	$("#chkela-all").bind("click",function(){
		$("#elevtbl input[type='checkbox']").attr('checked', true);
		return false
	});

	$("#chkela-cancel").bind("click",function(){
		$("#elevtbl input[type='checkbox']").attr('checked', false);
		return false
	});

	$(".tptypelnk").bind("click", function(){
		var id = $(this).attr("id").replace("tplnk", "tpdd");
		var i = parseInt(id.replace("tpdd", ""));
		var html = '';
		switch(i){
			case 1:
				html = '<ul><?=$torg_drop;?></ul><div class="both"></div>';
				break;
			<?php
			/*
			case 2:
				html = '<ul><?=$cult_drop;?></ul><div class="both"></div>';
				break;
			*/
			?>
			<?php
			/*
			case 2:
				html = '<ul><?=$obl_drop;?></ul><div class="both"></div>';
				break;
			*/
			?>
			case 3:
				html = '<ul><?=$viewmod_drop;?></ul><div class="both"></div>';
				break;
		}
		$("#"+id).find(".tpdinside").html(html);
		$("#"+id).css("display", "block");
		return false;
	});
	$(document).bind("click", function(){
		$(".tpdropdown").css("display", "none");
		$("#dropcultlist").css("display", "none");
		$("#dropcultlabel").removeClass("mntigc_select");
	});

	$("#dropcultlnk").bind("click", function(){
		if( $("#dropcultlist").css("display") == "none" )
		{
			$(this).parent().addClass("mntigc_select");
			$("#dropcultlist").css("display", "block");
		}
		else
		{
			$(this).parent().removeClass("mntigc_select");
			$("#dropcultlist").css("display", "none");
		}
		return false
	});

	$("#elevhidebtn").bind("click", function(){
		showElev('', 2);
		return false
	});


	$("#elevtbl label").bind("click", function(){
		//alert('!!!!');
	});

	$("#elevtbl label").mouseenter(function(){
		clearTimeout( elevtiptimer );

		if( elevtip ){
			$("#elevinffly").hide();
			elevtip = false;
		}

		var ppos = $(this).position();
		var poff = $(this).offset();
		var eid = $(this).attr("id").substr(5);

		elevtiptimer = setTimeout("showTooltipElev("+Math.floor(ppos.left+20)+","+Math.floor(ppos.top + 20)+",'"+eid+"')", 700);
	});

	$("#elevtbl label").mouseleave(function(){
		clearTimeout( elevtiptimer );
		if( elevtip ){
			$("#elevinffly").hide();
			elevtip = false;
		}
	});

	<?php
	if( isset($SHOW_POPUP_ADV) && $SHOW_POPUP_ADV )
	{
	?>
	showBuySell(<?=$obl;?>);
	<?php
	}
	?>
});

<?php
	if( isset($SHOW_POPUP_ADV) && $SHOW_POPUP_ADV )
	{
	?>
	var torgoblind_sel = <?=$obl;?>;
	<?php
	}
?>

function showTooltipElev(pleft, ptop, elevid)
{
	elevtip = true;
	var flypan = $("#elevinffly");

	var html_cont = "id: " + elevid + "<br />Left: " + pleft + "; Top: " + ptop + "<br />";

	$.ajax({
        type: "POST",
        async: false,
        url: reqajxhost+"ajx/ajx_jq.php",
        data: 'cmd=uh_com_elevinfo&elevid='+elevid,
        dataType: "html",
        success: function(data){
        	if( data != "" )
        	{
        		html_cont = data;
        	}
        }
    });

	flypan.find("div").html(html_cont);
	flypan.css("left", (pleft > 650 ? 450 : pleft)+"px").css("top", ptop+"px");
	flypan.show();
}

function changePerPage(pageobj)
{
	document.forms["pagerfrm"].submit();
}

function showElev(chkobj, showp)
{
	if( showp == 2 )
	{
		showp = ( $("#elevlistall").css("display") != "block" ? 1 : 0 );
	}
	else if( showp == 3 )
	{
		showp = ( chkobj.checked ? 1 : 0 );
	}

	if( showp == 0 )
	{
		$("#elevhidebtn").removeClass("a-mpclose");
		$("#elevhidebtn").addClass("a-mpopen");

		$("#elevlistall").hide("fast");
	}
	else if( showp == 1 )
	{
		$("#elevhidebtn").removeClass("a-mpopen");
		$("#elevhidebtn").addClass("a-mpclose");

		$("#elevlistall").show("slow");
	}
}
</script>
<?php
	$FRM_URL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $trade, $CULT_URL, $cult);
?>
	<form action="<?=$FRM_URL;?>" name="torgfindfrm" method="POST">
	<input type="hidden" name="obl" value="<?=$obl;?>" />
	<input type="hidden" name="trade" value="<?=$trade;?>" />
	<input type="hidden" name="cult" value="<?=$cult;?>" />
	<input type="hidden" name="action" value="setray" />
	<div class="mnavigate">
		<div class="mntop">
			<div class="mnti">
				<table class="mnti_tbl">
					<tr>
						<td class="mnti_obl" style="width: 290px; text-align: left;">
							<div class="drdtit" style="padding-bottom: 1px; padding-left: 20px;">
								<p><a id="tplnk2" class="<?=( false ? 'tptypelnk ' : '' );?>a-mntiobl" href="#" style="background: none;"><span><?=( strlen($REGIONS[$obl]) > 19 ? substr($REGIONS[$obl], 0, 19)."..." : $REGIONS[$obl] );?></span></a>
								<div id="tpdd2" class="tpdropdown" style="left:30px; top: 38px; width: 260px;">
									<div class="tpdinside">
									</div>
								</div></p>
							</div>
						</td>
						<?php
							/*
							<td class="mnti_rn" style="width: 100px;"><p><a class="borderlnk" href="#"><span><?=$ray_str;?></span></a></p></td>
							*/
						?>
						<td class="mnti_oper" style="width: 136px;">
							<p>
								<a id="tplnk1" class="tptypelnk a-mntioper" href="#"><span><?=$torg_name;?></span></a>
								<div id="tpdd1" class="tpdropdown" style="left:306px; top: 38px;">
									<div class="tpdinside nar">
									</div>
								</div>
							</p>
						</td>
						<td class="mnti_goods">
							<?php
							//<p>Культура:</p>
							?>
							<div style="float: right; padding: 6px 10px 2px 0px;">
							<?php
							$ADDURL = Torg_BuildUrl($LangId, "add", $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult);
							//echo '<a href="'.$ADDURL.'"><img src="'.$IMGHOST.'img/new/btn_newbuy_big.gif" width="240" height="54" border="0" alt="Разместить новое предложение" /></a>';
							echo '<a href="'.$ADDURL.'"><img src="'.$IMGHOST.'img/btn-newlot-or-sm.gif" width="250" height="34" border="0" alt="Провести новый тендер" /></a>';
							?>
							</div>
							<div class="mntig" style="float: left; margin-left: 6px;">
								<div id="dropcultlabel" class="mntig_current">
									<a id="dropcultlnk" class="a-mntigc" href="#">
										<?=$cult_name;?>
									</a>
								</div>
								<div id="dropcultlist" class="mntig_list" style="display:none;">
									<div class="mntigli">
										<?=$cult_drop;?>
										<?php
										/*
										<ul>
										<li><a href="#"><img class="float" src="img/ico-goods-01.png" alt="" width="28" height="29" /><span>Пшеница</span></a></li>
										<li><a href="#"><img class="float" src="img/ico-goods-01.png" alt="" width="28" height="29" /><span>Пшено</span></a></li>
										<li><a href="#"><img class="float" src="img/ico-goods-02.png" alt="" width="28" height="29" /><span>Рис</span></a></li>
										<li><a href="#"><img class="float" src="img/ico-goods-02.png" alt="" width="28" height="29" /><span>Гречиха</span></a></li>
										<li><a href="#"><img class="float" src="img/ico-goods-02.png" alt="" width="28" height="29" /><span>Подсолнечник</span></a></li>
										<li><a href="#"><img class="float" src="img/ico-goods-01.png" alt="" width="28" height="29" /><span>Кукуруза</span></a></li>
										</ul>
										*/
										?>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	</form>
<?php
	if( false && ($onlydomen == 1) && ($obl != 0) )
	{
		/*
		echo '<div class="fmap">
			<div class="fmlist">
				<div class="mtitle">
					<div class="mtp">
						<p>Элеваторы Украины</p>
						<img src="'.$IMGHOST.'img/ico-flag.png" alt="" width="23" height="22" />
					</div>
				</div>
				<div class="fml-ul">
				</div>
			</div>
			<div class="fmobj">
				<img class="block" src="'.$IMGHOST.'img/kharkov/img-khmap0.gif" alt="" width="351" height="335"  />
			</div>
		</div>
		<br />
		<br />'.$page['content'].'<br />';
		*/

		echo '<div class="mtext">'.$PAGE_TXT1.'</div>';

		echo '<div class="popup_front">
			<div class="pfl">
				<div class="pfimage">
					<table><tr><td><img src="'.$IMGHOST.'img/img-pfl.jpg" alt="" width="359" height="290" /></td></tr></table>
				</div>
				<p><a id="ppbuybtn" href="'.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $TORG_BUY).'"><img src="'.$IMGHOST.'img/btn-buy.png" alt="" width="269" height="84" /></a></p>
				<div class="pftext">
					Если вы хотите купить аграрную продукцию, то перейдите в раздел Купить.
				</div>
			</div>
			<div class="pfr">
				<div class="pfimage">
					<table><tr><td><img src="'.$IMGHOST.'img/img-pfr.jpg" alt="" width="360" height="249" /></td></tr></table>
				</div>
				<p><a id="ppsellbtn" href="'.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $TORG_SELL).'"><img src="'.$IMGHOST.'img/btn-sold.png" alt="" width="259" height="84" /></a></p>
				<div class="pftext">
					Если вы хотите продать аграрную продукцию, то перейдите в раздел Продажа.
				</div>
			</div>
			<div class="both"></div>
		</div>';
	}
	else
	{
		//if( $obl == 0 )
		if( $obl >= 0 )
		{
	?>
<script type="text/javascript">
	var img0 = new Image(); img0.src = '/img/ua/img-uamap0nobg.gif';
	var img1 = new Image(); img1.src = '/img/ua/img-uamap1nobg.gif';
	var img2 = new Image(); img2.src = '/img/ua/img-uamap2nobg.gif';
	var img3 = new Image(); img3.src = '/img/ua/img-uamap3nobg.gif';
	var img4 = new Image(); img4.src = '/img/ua/img-uamap4nobg.gif';
	var img5 = new Image(); img5.src = '/img/ua/img-uamap5nobg.gif';
	var img6 = new Image(); img6.src = '/img/ua/img-uamap6nobg.gif';
	var img7 = new Image(); img7.src = '/img/ua/img-uamap7nobg.gif';
	var img8 = new Image(); img8.src = '/img/ua/img-uamap8nobg.gif';
	var img9 = new Image(); img9.src = '/img/ua/img-uamap9nobg.gif';
	var img10 = new Image(); img10.src = '/img/ua/img-uamap10nobg.gif';
	var img11 = new Image(); img11.src = '/img/ua/img-uamap11nobg.gif';
	var img12 = new Image(); img12.src = '/img/ua/img-uamap12nobg.gif';
	var img13 = new Image(); img13.src = '/img/ua/img-uamap13nobg.gif';
	var img14 = new Image(); img14.src = '/img/ua/img-uamap14nobg.gif';
	var img15 = new Image(); img15.src = '/img/ua/img-uamap15nobg.gif';
	var img16 = new Image(); img16.src = '/img/ua/img-uamap16nobg.gif';
	var img17 = new Image(); img17.src = '/img/ua/img-uamap17nobg.gif';
	var img18 = new Image(); img18.src = '/img/ua/img-uamap18nobg.gif';
	var img19 = new Image(); img19.src = '/img/ua/img-uamap19nobg.gif';
	var img20 = new Image(); img20.src = '/img/ua/img-uamap20nobg.gif';
	var img21 = new Image(); img21.src = '/img/ua/img-uamap21nobg.gif';
	var img22 = new Image(); img22.src = '/img/ua/img-uamap22nobg.gif';
	var img23 = new Image(); img23.src = '/img/ua/img-uamap23nobg.gif';
	var img24 = new Image(); img24.src = '/img/ua/img-uamap24nobg.gif';
	var img25 = new Image(); img25.src = '/img/ua/img-uamap25nobg.gif';

	var curpic;

	function moveMObl(regid, inout){
		if(inout == 1){
			curpic = $("#uamap").attr("src");
			eval("var imgobj = img"+regid);
			$("#uamap").attr("src", imgobj.src);
			$("#obllink"+regid).addClass("sel");
		}
		else
		{
			$("#uamap").attr("src", curpic);
			$("#obllink"+regid).removeClass("sel");
		}
	}

	function showBuySell2(oblid)
	{
		selected_oblast = oblid;

		location.href="http://"+regurls[selected_oblast]+".agrotender.com.ua/";

		return false
	}
</script>
	<div class="fmap">
		<div class="fmlist">
			<div class="mtitle">
				<div class="mtp">
					<p class="smaller">Для просмотра тендеров выберите область</p>
					<img src="<?=$IMGHOST;?>img/ico-flag.png" alt="" width="23" height="22" />
				</div>
			</div>
			<div class="fml-ul">
<?php
			$oblDbId2MapId = Array(0 => 0, 1 => 1, 2 => 24, 3 => 17, 4 => 9, 5 => 4, 6 => 15, 7 => 19, 8 => 3, 9 => 20, 10 => 14,
				11 => 11, 12 => 5, 13 => 18, 14 => 10, 15 => 25, 16 => 8, 17 => 16, 18 => 7, 19 => 22, 20 => 6,
				21 => 2, 22 => 23, 23 => 12, 24 => 13, 25 => 21, 26 => 0);

			$regar = Array();
			for( $i=1; $i<count($REGIONS); $i++ )
			{
				$regar[$i] = str_replace(" область", "", $REGIONS[$i]);
			}

			for( $i=1; $i<=count($regar); $i++ )
			{
				if( $i % 9 == 1 )
				{
					echo '<ul>';
				}

				$tot_lots = 0;

				$query = "SELECT count(*) as totlots
					FROM $TABLE_TORG_ITEMS i1
					INNER JOIN $TABLE_TORG_ITEM2RAY i2i ON i1.id=i2i.item_id
					INNER JOIN $TABLE_RAYON r1 ON i2i.ray_id=r1.id AND r1.obl_id='".$i."'
					WHERE i1.dt_end>NOW() AND i1.status=".$TORG_STATUS_ACT." ";
				if( $res = mysql_query( $query ) )
				{
					if( $row = mysql_fetch_object( $res ) )
					{
						$tot_lots = $row->totlots;
					}
					mysql_free_result( $res );
				}
				else
					echo mysql_error();

				$OBLURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$i], $i);
				echo '<li'.($tot_lots > 0 ? ' class="fw_bold"' : '').'><a id="obllink'.$oblDbId2MapId[$i].'" href="'.$OBLURL.'" onclick="return showBuySell2('.$i.')" onmouseover="moveMObl('.$oblDbId2MapId[$i].',1);" onmouseout="moveMObl('.$oblDbId2MapId[$i].',0);">'.$regar[$i].'</a> <span>('.$tot_lots.')</span></li>';

				if( $i % 9 == 0 )
				{
					echo '</ul>';
				}
			}

			$tot_lots = 0;
			$query = "SELECT count(*) as totlots
				FROM $TABLE_TORG_ITEMS i1
				INNER JOIN $TABLE_TORG_ITEM2RAY i2i ON i1.id=i2i.item_id
				INNER JOIN $TABLE_RAYON r1 ON i2i.ray_id=r1.id
				WHERE i1.dt_end>NOW() AND i1.status=".$TORG_STATUS_ACT." ";
			if( $res = mysql_query( $query ) )
			{
				if( $row = mysql_fetch_object( $res ) )
				{
					$tot_lots = $row->totlots;
				}
				mysql_free_result( $res );
			}
			else
				echo mysql_error();

			// Add ALL UKRAINE link
			$OBLURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[0], $i);
			echo '<li style="background: none;">&nbsp;</li><li class="fw_bold"><a id="obllink0" href="'.$OBLURL.'" '.( false ? 'onclick="return showBuySell2(0)"' : '' ).'>Вся Украина</a> <span>('.$tot_lots.')</span></li>';

			if( ($i-1) % 9 != 0 )
			{
				echo '</ul>';
			}
?>
			</div>
		</div>
		<div class="fmobj">
		<?php
		/*
			<a href="#" onclick="showBuySell()"><img src="img/img-map.gif" alt="" width="499" height="339" /></a>
		*/
		?>
			<img class="block" id="uamap" src="<?=$IMGHOST;?>img/ua/img-uamap0nobg.gif" alt="" width="499" height="339" usemap="#UkraineMap" />
			<map name="UkraineMap" id="uamap_map">
				<area shape="poly" href="#" onclick="showBuySell2(1 )" onmouseover="moveMObl(1,1);" onmouseout="moveMObl(1,0);" alt="Крым" title="Крым" coords="321, 256, 323, 270, 300, 286, 322, 304, 319, 321, 332, 325, 363, 305, 376, 295, 401, 295, 402, 282, 366, 290, 349, 271"></area>
				<area shape="poly" href="#" onclick="showBuySell2(21)" onmouseover="moveMObl(2,1);" onmouseout="moveMObl(2,0);" alt="Херсон" title="Херсон" coords="274, 252, 321, 254, 358, 249, 339, 216, 313, 207, 300, 232"></area>
				<area shape="poly" href="#" onclick="showBuySell2(8 )" onmouseover="moveMObl(3,1);" onmouseout="moveMObl(3,0);" alt="Запорожье" title="Запорожье" coords="362, 179, 354, 204, 345, 215, 358, 231, 389, 229, 405, 219, 406, 201"></area>
				<area shape="poly" href="#" onclick="showBuySell2(5 )" onmouseover="moveMObl(4,1);" onmouseout="moveMObl(4,0);" alt="Донецк" title="Донецк" coords="422, 132, 407, 151, 406, 179, 418, 198, 416, 212, 441, 207, 444, 188, 450, 171"></area>
				<area shape="poly" href="#" onclick="showBuySell2(12)" onmouseover="moveMObl(5,1);" onmouseout="moveMObl(5,0);" alt="Луганск" title="Луганск" coords="434, 99, 430, 119, 443, 149, 465, 173, 481, 174, 474, 128, 480, 116"></area>
				<area shape="poly" href="#" onclick="showBuySell2(20)" onmouseover="moveMObl(6,1);" onmouseout="moveMObl(6,0);" alt="Харьков" title="Харьков" coords="391, 93, 374, 86, 350, 100, 365, 122, 359, 134, 380, 139, 393, 148, 426, 111, 412, 87"></area>
				<area shape="poly" href="#" onclick="showBuySell2(18)" onmouseover="moveMObl(7,1);" onmouseout="moveMObl(7,0);" alt="Сумы" title="Сумы" coords="311, 13, 302, 31, 303, 80, 330, 80, 340, 95, 358, 87, 352, 64, 326, 55, 323, 31"></area>
				<area shape="poly" href="#" onclick="showBuySell2(16)" onmouseover="moveMObl(8,1);" onmouseout="moveMObl(8,0);" alt="Полтава" title="Полтава" coords="281, 96, 292, 119, 294, 133, 326, 146, 358, 120, 327, 88, 302, 88"></area>
				<area shape="poly" href="#" onclick="showBuySell2(4 )" onmouseover="moveMObl(9,1);" onmouseout="moveMObl(9,0);" alt="Днепропетровск" title="Днепропетровск" coords="325, 156, 315, 177, 304, 197, 319, 201, 349, 197, 348, 175, 384, 178, 393, 183, 399, 160, 388, 162, 375, 147, 350, 139, 339, 144, 335, 157"></area>
				<area shape="poly" href="#" onclick="showBuySell2(14)" onmouseover="moveMObl(10,1);" onmouseout="moveMObl(10,0);" alt="Николаев" title="Николаев" coords="268, 197, 249, 180, 230, 182, 233, 195, 246, 204, 256, 219, 253, 236, 280, 229, 297, 223, 299, 190, 289, 196"></area>
				<area shape="poly" href="#" onclick="showBuySell2(11)" onmouseover="moveMObl(11,1);" onmouseout="moveMObl(11,0);" alt="Кировоград" title="Кировоград" coords="216, 173, 227, 177, 252, 175, 272, 190, 287, 190, 310, 173, 314, 151, 301, 145, 263, 157"></area>
				<area shape="poly" href="#" onclick="showBuySell2(23)" onmouseover="moveMObl(12,1);" onmouseout="moveMObl(12,0);" alt="Черкассы" title="Черкассы" coords="214, 142, 223, 161, 238, 151, 255, 155, 288, 140, 277, 103, 266, 114, 239, 136"></area>
				<area shape="poly" href="#" onclick="showBuySell2(24)" onmouseover="moveMObl(13,1);" onmouseout="moveMObl(13,0);" alt="Чернигов" title="Чернигов" coords="274, 27, 248, 25, 237, 60, 250, 73, 255, 83, 270, 78, 276, 90, 293, 87, 296, 68, 299, 24, 301, 14, 291, 17, 283, 16"></area>
				<area shape="poly" href="#" onclick="showBuySell2(10)" onmouseover="moveMObl(14,1);" onmouseout="moveMObl(14,0);" alt="Киев" title="Киев" coords="208, 53, 215, 108, 210, 130, 242, 127, 253, 104, 264, 109, 272, 91, 249, 84, 231, 62, 225, 48"></area>
				<area shape="poly" href="#" onclick="showBuySell2(6 )" onmouseover="moveMObl(15,1);" onmouseout="moveMObl(15,0);" alt="Житомир" title="Житомир" coords="169, 44, 153, 65, 162, 108, 192, 107, 196, 118, 209, 107, 200, 45, 188, 48"></area>
				<area shape="poly" href="#" onclick="showBuySell2(17)" onmouseover="moveMObl(16,1);" onmouseout="moveMObl(16,0);" alt="Ровно" title="Ровно" coords="117, 25, 116, 40, 124, 63, 114, 77, 105, 75, 98, 93, 115, 88, 126, 89, 147, 77, 150, 59, 160, 41"></area>
				<area shape="poly" href="#" onclick="showBuySell2(3 )" onmouseover="moveMObl(17,1);" onmouseout="moveMObl(17,0);" alt="Луцк" title="Луцк" coords="66, 33, 67, 47, 74, 61, 72, 68, 88, 81, 101, 71, 113, 69, 119, 60, 110, 35, 112, 25, 84, 23, 74, 34"></area>
				<area shape="poly" href="#" onclick="showBuySell2(13)" onmouseover="moveMObl(18,1);" onmouseout="moveMObl(18,0);" alt="Львов" title="Львов" coords="72, 74, 61, 81, 31, 111, 35, 135, 47, 143, 55, 128, 69, 127, 75, 113, 81, 114, 99, 101, 93, 88"></area>
				<area shape="poly" href="#" onclick="showBuySell2(7 )" onmouseover="moveMObl(19,1);" onmouseout="moveMObl(19,0);" alt="Ужгород" title="Ужгород" coords="25, 129, 17, 143, 11, 151, 28, 171, 35, 167, 43, 172, 67, 178, 72, 174, 70, 166, 55, 155, 53, 150, 31, 136, 31, 133"></area>
				<area shape="poly" href="#" onclick="showBuySell2(9 )" onmouseover="moveMObl(20,1);" onmouseout="moveMObl(20,0);" alt="Ивано-Франковск" title="Ивано-Франковск" coords="56, 132, 51, 143, 60, 153, 73, 164, 77, 182, 82, 185, 83, 174, 96, 160, 101, 161, 101, 150, 84, 135, 81, 119, 76, 118, 75, 132"></area>
				<area shape="poly" href="#" onclick="showBuySell2(25)" onmouseover="moveMObl(21,1);" onmouseout="moveMObl(21,0);" alt="Черновцы" title="Черновцы" coords="102, 165, 95, 164, 84, 178, 84, 187, 92, 180, 115, 179, 130, 166, 150, 164, 149, 159, 133, 160, 129, 164, 108, 155, 103, 154"></area>
				<area shape="poly" href="#" onclick="showBuySell2(19)" onmouseover="moveMObl(22,1);" onmouseout="moveMObl(22,0);" alt="Тернополь" title="Тернополь" coords="84, 116, 89, 137, 97, 143, 116, 157, 120, 157, 122, 93, 106, 95, 101, 106"></area>
				<area shape="poly" href="#" onclick="showBuySell2(22)" onmouseover="moveMObl(23,1);" onmouseout="moveMObl(23,0);" alt="Хмельницкий" title="Хмельницкий" coords="126, 96, 121, 152, 128, 160, 135, 156, 149, 155, 154, 136, 162, 134, 156, 103, 159, 97, 149, 86, 148, 81, 139, 83"></area>
				<area shape="poly" href="#" onclick="showBuySell2(2 )" onmouseover="moveMObl(24,1);" onmouseout="moveMObl(24,0);" alt="Винница" title="Винница" coords="166, 115, 165, 138, 155, 140, 153, 162, 178, 177, 193, 174, 200, 179, 211, 176, 217, 165, 209, 141, 205, 122, 192, 122, 191, 111, 181, 114"></area>
				<area shape="poly" href="#" onclick="showBuySell2(15)" onmouseover="moveMObl(25,1);" onmouseout="moveMObl(25,0);" alt="Одесса" title="Одесса" coords="194, 182, 201, 194, 199, 205, 208, 212, 210, 224, 219, 233, 215, 249, 195, 245, 169, 283, 180, 292, 205, 284, 226, 266, 242, 242, 249, 238, 251, 222, 239, 203, 228, 198, 225, 180"></area>
			</map>
		</div>
	</div>
	<div class="both"></div>
	<br />
	<?php
		}

		if( false && ($obl != 0) )
		{
?>
	<form action="<?=$FRM_URL;?>" name="torgfindfrm" method="POST">
	<input type="hidden" name="obl" value="<?=$obl;?>" />
	<input type="hidden" name="trade" value="<?=$trade;?>" />
	<input type="hidden" name="cult" value="<?=$cult;?>" />
	<input type="hidden" name="action" value="setray" />
	<div class="mnavigate">
		<div class="mntop">
			<div class="mnti">
				<table class="mnti_tbl">
					<tr>
						<td class="mnti_obl"><p><a class="a-mntiobl" href="#"><span><?=( strlen($REGIONS[$obl]) > 19 ? substr($REGIONS[$obl], 0, 19)."..." : $REGIONS[$obl] );?></span></a></p></td>
						<td class="mnti_rn"><p><a class="borderlnk" href="#"><span><?=$ray_str;?></span></a></p></td>
						<td class="mnti_oper">
							<p>
								<a id="tplnk1" class="tptypelnk a-mntioper" href="#"><span><?=$torg_name;?></span></a>
								<div id="tpdd1" class="tpdropdown" style="left:576px; top: 38px;">
									<div class="tpdinside nar">
									</div>
								</div>
							</p>
						</td>
						<td class="mnti_goods">
							<p>Культура:</p>
							<div class="mntig">
								<div id="dropcultlabel" class="mntig_current">
									<a id="dropcultlnk" class="a-mntigc" href="#">
										<?=$cult_name;?>
									</a>
								</div>
								<div id="dropcultlist" class="mntig_list" style="display:none;">
									<div class="mntigli">
										<?=$cult_drop;?>
										<?php
										/*
										<ul>
										<li><a href="#"><img class="float" src="img/ico-goods-01.png" alt="" width="28" height="29" /><span>Пшеница</span></a></li>
										<li><a href="#"><img class="float" src="img/ico-goods-01.png" alt="" width="28" height="29" /><span>Пшено</span></a></li>
										<li><a href="#"><img class="float" src="img/ico-goods-02.png" alt="" width="28" height="29" /><span>Рис</span></a></li>
										<li><a href="#"><img class="float" src="img/ico-goods-02.png" alt="" width="28" height="29" /><span>Гречиха</span></a></li>
										<li><a href="#"><img class="float" src="img/ico-goods-02.png" alt="" width="28" height="29" /><span>Подсолнечник</span></a></li>
										<li><a href="#"><img class="float" src="img/ico-goods-01.png" alt="" width="28" height="29" /><span>Кукуруза</span></a></li>
										</ul>
										*/
										?>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div id="mappan" class="mncntopen"<?=($mapshow ? '' : ' style="display:none;"');?>>
			<div class="mncnt_rlist">
				<div style="padding: 0px 0px 5px 0px; font-size: 14px;">Выберите интересующие вас районы и нажмите «Применить»</div>
				<table class="mpcl_tbl" id="rayontbl">
			<?php
				$PERROW = 3;

				// V1 - get rayon list from array
				//$rlist = Array();
				//if( isset($RAYON[$obl]) )
				//{
				//	$rlist = $RAYON[$obl];
				//}
				//for( $i=0; $i<count($rlist); $i++ )

				$PERCOL = ceil(count($RAYS) / $PERROW);

				$i = 0;
				echo '<tr>';
				foreach( $RAYS as $rayid => $rayi )
				{
					//if( ($i+1) % $PERROW == 1 )
					if( ($i+1) % $PERCOL == 1 )
					{
						echo '
						<td style="vertical-align: top;">';
					}

					$chkcls = "";
					$chkcls2 = "";

					// Check if it is selected
					$raychecked = false;
     				for( $j=0; $j<count($raylist); $j++ )
     				{
     					if( $rayid == $raylist[$j] )
     					{
     						$raychecked = true;
     						break;
     					}
     				}

					if( $raychecked )
					{
						$chkcls = "_checked";
						$chkcls2 = 'class="mncntrl_lbl_checked"';
					}

					echo '<table>
						<tr>
							<td class="mpclt_sub_td"><div class="mncntrl_div'.$chkcls.'"><input type="checkbox" name="raylist[]" id="mpcl_'.$rayid.'" value="'.$rayid.'" '.($raychecked ? ' checked="checked"' : '').' /></div></td>
							<td id="rayrow'.$rayid.'"><label '.$chkcls2.' for="mpcl_'.($rayid).'" onmouseover="moveM1(1,'.$rayid.')" onmouseout="moveM1(0,'.$rayid.')">'.$rayi['name'].'</label></td>
						</tr>
					</table>';

					//if( ($i+1) % $PERROW == 0 )
					if( ($i+1) % $PERCOL == 0 )
					{
						echo '</td>';
					}

					$i++;
				}

				//if( $i % $PERROW != 0 )
				if( $i % $PERCOL != 0 )
				{
					echo '</td>';
				}

				echo '</tr>';
			?>
				</table>
				<div class="mpc_links" style="height: 40px;">
					<div class="btnsave"><input type="image" src="<?=$IMGHOST;?>img/btn_apply.gif" width="110" height="29" alt="Применить" /></div>
					<a class="a-all" id="chka-all" href="#"><span>Выбрать всё</span></a>
					<a class="a-cancel" id="chka-cancel" href="#"><span>Отменить выбор</span></a>
				</div>
			</div>
			<div class="mncnt_rmap">
			<?php
				//<img src="img/img-map2.gif" alt="" width="351" height="335" />
				switch( $obl )
				{
					case 1:	// Crimea
						include "mapinc/cr-map-inc.php";
						break;
					case 2:	// Vinnica
						include "mapinc/vn-map-inc.php";
						break;
					case 3:	// Volinskaya|Lutsk
						include "mapinc/lt-map-inc.php";
						break;
					case 4:	// Dnepr
						include "mapinc/dp-map-inc.php";
						break;
					case 5:	// Donetsk
						include "mapinc/dn-map-inc.php";
						break;
					case 6:	// Zhitomir
						include "mapinc/zt-map-inc.php";
						break;
					case 7:	// Uzgorod|zakarpatskiy
						include "mapinc/uz-map-inc.php";
						break;
					case 8:	// Zaporoz
						include "mapinc/zp-map-inc.php";
						break;
					case 9:	// Ivano-Frank
						include "mapinc/if-map-inc.php";
						break;
					case 10:	// Kyiv
						include "mapinc/ky-map-inc.php";
						break;
					case 11:	// Kyiv
						include "mapinc/ki-map-inc.php";
						break;
					case 12:	// Lugansk
						include "mapinc/lg-map-inc.php";
						break;
					case 13:	// Lvov
						include "mapinc/lv-map-inc.php";
						break;
					case 14:	// Nikolaev
						include "mapinc/nk-map-inc.php";
						break;
					case 15:	// Одесса
						include "mapinc/od-map-inc.php";
						break;
					case 16:	// Poltava
						include "mapinc/pl-map-inc.php";
						break;
					case 17:	// Rovno
						include "mapinc/rv-map-inc.php";
						break;
					case 18:	// Sumy
						include "mapinc/su-map-inc.php";
						break;

					case 19:	// Ternopil
						include "mapinc/tp-map-inc.php";
						break;

					case 20:	// Kharkov
						include "mapinc/kh-map-inc.php";
						break;
					case 21:	// Kherson
						include "mapinc/kr-map-inc.php";
						break;
					case 22:	// Khmelnick
						include "mapinc/km-map-inc.php";
						break;
					case 23:	// Черкассы
						include "mapinc/cs-map-inc.php";
						break;
					case 24:	// Чернигов
						include "mapinc/cn-map-inc.php";
						break;
					case 25:	// Черновцы
						include "mapinc/cv-map-inc.php";
						break;
				}
			?>
			</div>
			<div class="both"></div>
		</div>
		<div id="mncclose" class="mncntclose" <?=($mapshow ? ' style="display:none;"' : '');?>></div>
		<a id="a-mntcc" href="#"<?=($mapshow ? ' style="display:none;"' : '');?>><span>Выбрать район</span></a>
		<a id="a-mntco" href="#"<?=($mapshow ? '' : ' style="display:none;"');?>><span>Свернуть карту районов</span></a>
	</div>
	<?php
		}
	?>
	<div class="both"></div>

	<?php
		if( false )
		{
	?>
	<div class="mtext">
		<table cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td>
			<?php
				if( ($cult > 0) && ($trade != 0) )
				{
					echo 'Смотрите также: ';
					$ccultind = 0;
					for( $i=0; $i<count($cult_list); $i++ )
					{
						if( $cult_list[$i]['id'] == $cult )
							$ccultind = $i;
					}
					for( $i=1; $i<=4; $i++ )
					{
						if( $i > 1 )
							echo ',';
						echo ' &nbsp;<a href="'.Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $trade, $cult_list[ ($i+$ccultind) % count($cult_list) ]['url'], $cult_list[ ($i+$ccultind) % count($cult_list) ]['id']).'">'.($trade == $TORG_BUY ? 'купить' : 'продать').' '.$cult_list[ ($i+$ccultind) % count($cult_list) ]['name'].'</a>';
					}
					echo '<br />';
				}
			?>
			<?php
				if( (isset($ray_str00) && ($ray_str00!="")) || ($sortby != $SORTBY_DEF) || ($pi > 1) )
				{
					// Не показывать сео текст
				}
				else
				{
			?>
				<h1 class="titsm"><?=$trade_names2[$trade]." ".( $cult0 == 0 ? " - Аграрная продукция" : $cult_name0)." в ".$REGIONS_CITY2[$obl]." и ".$REGIONS2[$obl];?></h1>
				<?=$PAGE_TXT1;?>
			<?php
				}
			?>
			</td>
			<td style="padding: 2px 20px 2px 20px;">
			<?php
				$ADDURL = Torg_BuildUrl($LangId, "add", $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult);
				//echo '<a href="'.$ADDURL.'"><img src="'.$IMGHOST.'img/new/btn_newbuy_big.gif" width="240" height="54" border="0" alt="Разместить новое предложение" /></a>';
				echo '<a href="'.$ADDURL.'"><img src="'.$IMGHOST.'img/btn-newlot-or-big.gif" width="210" height="54" border="0" alt="Провести новый тендер" /></a>';
			?>
			</td>
		</tr>
		</table>
	</div>
	<?php
		}

		if( false )
		{
	?>
	<div class="mprods">
		<div class="mphdr">
			<table>
				<tr>
					<td><input type="checkbox" name="lotelev" value="1" id="i_mphdr_1" <?=($lotelev == 1 ? ' checked="checked" ' : '');?> onchange="document.forms['torgfindfrm'].submit();" onclick="showElev(this, 3)" /> <label for="i_mphdr_1">Элеваторы</label></td>
					<td style="width:44px;"></td>
					<td><input type="checkbox" name="lothoz" value="1" id="i_mphdr_2" <?=($lothoz == 1 ? ' checked="checked" ' : '');?> onchange="document.forms['torgfindfrm'].submit();" /> <label for="i_mphdr_2" style="background:url(/img/ico-mphdr-02.gif) no-repeat;">Хозяйства</label></td>
				</tr>
			</table>
		</div>
		<div class="mpcont">
			<div class="mpc_title">
				<img src="<?=$IMGHOST;?>img/ico-stats-03.gif" alt="" width="26" height="26" class="float" />
				<p style="font-size: 16px;">Чтобы рассмотреть предложения на конкретно интересующих вас элеваторах – выберите их и нажмите «Применить»</p>
			</div>
			<div class="both"></div>
			<div id="elevlistall"  <?=($lotelev == 1 ? '' : ' style="display: none;"');?>>
				<div class="mpc_list">
			<?php
				$elev = Torg_ElevList( $LangId, $obl, $raylist );
			?>
				<table class="mpcl_tbl" id="elevtbl">
				<tr>
			<?php
				if( count($elev) > 0 )
				{
					$ELCOLS = 3;
					$ELPERCOL = ceil( count($elev) / $ELCOLS );

					for( $i=0; $i<count($elev); $i++ )
					{
						if( (($i+1) % $ELPERCOL == 1) || ($ELPERCOL == 1) )
							echo '<td valign="top">';

						// Check if it is selected
						$elevchecked = false;
	     				for( $j=0; $j<count($elevids); $j++ )
	     				{
	     					if( $elev[$i]['id'] == $elevids[$j] )
	     					{
	     						$elevchecked = true;
	     						break;
	     					}
	     				}

						echo '<table>
							<tr>
								<td class="mpclt_sub_td"><input type="checkbox" name="elevids[]" id="el_mpcl_'.$elev[$i]['id'].'" value="'.$elev[$i]['id'].'" '.($elevchecked ? ' checked="checked" ' : '').' /></td>
								<td><label for="el_mpcl_'.$elev[$i]['id'].'" id="elevn'.$elev[$i]['id'].'">'.$elev[$i]['name'].'</label></td>
							</tr>
						</table>
						';

						if( (($i+1) % $ELPERCOL == 0) || ($ELPERCOL == 1) )
							echo '</td>';
					}
					if( ($i % $ELPERCOL != 0) && ($ELPERCOL != 1) )
						echo '</td>';
				}
			?>
				</tr>
				</table>
				<div id="elevinffly" class="elevi-popup"><div class="elevi-popupin">!!!!!!!!!!!</div></div>
				</div>
				<div class="mpc_links">
					<div class="btn-apply"><input type="image" src="<?=$IMGHOST;?>img/btn_apply.gif" width="110" height="29" alt="Применить" /></div>
					<a class="a-all" id="chkela-all" href="#"><span>Выбрать всё</span></a>
					<a class="a-cancel" id="chkela-cancel" href="#"><span>Отменить выбор</span></a>
				</div>
			</div>
		</div>
		<a class="<?=($lotelev == 1 ? 'a-mpclose' : 'a-mpopen');?>" id="elevhidebtn" href="#">Свернуть</a>
		<div class="both"></div>
	</div>
	</form>
	<?php
		}
	?>
<script type="text/javascript">
	$(document).ready(function(){
		$("table.mtinfo_tbl tbody tr").bind("mouseover", function(){$(this).addClass("mtinfo_hover");});
		$("table.mtinfo_tbl tbody tr").bind("mouseout", function(){$(this).removeClass("mtinfo_hover");});
	});
</script>
	<div class="mtorgs">
		<div class="mtitle">
			<div class="mtp">
				<h1><?=( ($cult_name0 == "") && ($trade == "") ? "Тендеры" : $trade_names[$trade].' '.$cult_name0 )." - ".$REGIONS[$obl];?></h1>
				<img width="16" height="12" alt="" src="<?=$IMGHOST;?>img/ico-h1.png" />
			</div>
		</div>
		<div class="both"></div>
<?php
	$showelev = ( $ray_url != "" );
	$searchmode = ( (($lotelev && $lothoz) || (!$lothoz && !$lotelev)) ? "all" : ( $lotelev ? "elev" : "hoz" ) );


	$TOTAL_LOTS = Torg_LotNum( $LangId, $obl, $raylist, $trade, $cult, $elevids, $searchmode );
	$its = Torg_LotList( $LangId, $obl, $raylist, $trade, $cult, $elevids, $searchmode, $sortby_col, $sortby_order, $pi, $pn );

	//var_dump($_COOKIE);

	//echo $pn;

	$HTML_PAGES_LINKS = "";
	if( $TOTAL_LOTS > 0 )
	{
		//---------------------- CATALOG PRODUCTs PAGING -----------------------
		$PAGES_DIAP = 7;
		$TOTAL_PAGES = ceil($TOTAL_LOTS / $pn);
		if( $TOTAL_PAGES > 1 )
		{
			// First
			$P_F_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, ($sortby == $SORTBY_DEF ? "" : $sortby), 1, $pn );
			//$P_F_LINK = Catalog_BuildUrl( $LangId, $CUR_SECT['url'], $CUR_SECT['id'], $burl, ($sortby == $SORTBY_DEF ? "" : $sortby), 1, $pn, $CUR_FILTER_URL_STR );
			// Last
			$P_L_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, ($sortby == $SORTBY_DEF ? "" : $sortby), $TOTAL_PAGES, $pn );
			//$P_L_LINK = Catalog_BuildUrl( $LangId, $CUR_SECT['url'], $CUR_SECT['id'], $burl, ($sortby == $SORTBY_DEF ? "" : $sortby), $TOTAL_PAGES, $pn, $CUR_FILTER_URL_STR );
			// Prev
			$P_P_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, ($sortby == $SORTBY_DEF ? "" : $sortby), ($pi > 1 ? $pi-1 : 1), $pn );
			//$P_P_LINK = Catalog_BuildUrl( $LangId, $CUR_SECT['url'], $CUR_SECT['id'], $burl, ($sortby == $SORTBY_DEF ? "" : $sortby), ($pi > 1 ? $pi-1 : 1), $pn, $CUR_FILTER_URL_STR );
			// Next
			$P_N_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, ($sortby == $SORTBY_DEF ? "" : $sortby), ($pi < $TOTAL_PAGES ? $pi+1 : $TOTAL_PAGES), $pn );
			//$P_N_LINK = Catalog_BuildUrl( $LangId, $CUR_SECT['url'], $CUR_SECT['id'], $burl, ($sortby == $SORTBY_DEF ? "" : $sortby), ($pi < $TOTAL_PAGES ? $pi+1 : $TOTAL_PAGES), $pn, $CUR_FILTER_URL_STR );

   			$vis1_num = ( ($pi - floor($PAGES_DIAP / 2)) > 2 ? ($pi - floor($PAGES_DIAP / 2)) : ($TOTAL_PAGES > 1 ? 2 : 1) );
   			$vis2_num = ( ($pi + floor($PAGES_DIAP / 2)) < ($TOTAL_PAGES-1) ? ($pi + floor($PAGES_DIAP / 2)) : ($TOTAL_PAGES > 2 ? ($TOTAL_PAGES-1) : 1) );

   			//echo "Tp: ".$TOTAL_PAGES."<br />";
   			//echo $vis1_num." - ".$vis2_num."<br />";

			//--------------------- MAKE PAGING LAYOUT -------------------------
			//$HTML_PAGES_LINKS .= '<span class="arrow">&#8592;</span>';
			$HTML_PAGES_LINKS .= '<a class="a-first" href="'.$P_F_LINK.'#lottable"></a>';
			$HTML_PAGES_LINKS .= '<a class="a-prev" href="'.$P_P_LINK.'#lottable"></a>';

			// Show first link
			if( ($pi == 1) || ($pi == 0) )
				$HTML_PAGES_LINKS .= '<span class="a-text">1</span>';
			else
				$HTML_PAGES_LINKS .= '<a class="a-text" href="'.$P_F_LINK.'#lottable">1</a>';

			//if($vis2_num - $vis1_num >= 0 )
			//{
				for( $i=$vis1_num; $i<=$vis2_num; $i++ )
				{
					if( ($i == $vis1_num) && ($i > 2) )
					{
						//$P_LINK = Catalog_BuildUrl( $LangId, $CUR_SECT['url'], $CUR_SECT['id'], $burl, ($sortby == $SORTBY_DEF ? "" : $sortby), $i-1, $pn, $CUR_FILTER_URL_STR );
						$P_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, ($sortby == $SORTBY_DEF ? "" : $sortby), $i-1, $pn );
						$HTML_PAGES_LINKS .= '<a class="a-text" href="'.$P_LINK.'#lottable">...</a>';
					}

					//$P_LINK = Catalog_BuildUrl( $LangId, $CUR_SECT['url'], $CUR_SECT['id'], $burl, ($sortby == $SORTBY_DEF ? "" : $sortby), $i, $pn, $CUR_FILTER_URL_STR );
					$P_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, ($sortby == $SORTBY_DEF ? "" : $sortby), $i, $pn );
					if( $pi == $i )
						$HTML_PAGES_LINKS .= '<span class="a-text">'.$i.'</span>';
					else
						$HTML_PAGES_LINKS .= '<a class="a-text" href="'.$P_LINK.'#lottable">'.$i.'</a>';

					if( ($i == $vis2_num) && ($i < ($TOTAL_PAGES-1)) )
					{
						//$P_LINK = Catalog_BuildUrl( $LangId, $CUR_SECT['url'], $CUR_SECT['id'], $burl, ($sortby == $SORTBY_DEF ? "" : $sortby), $i+1, $pn, $CUR_FILTER_URL_STR );
						$P_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, ($sortby == $SORTBY_DEF ? "" : $sortby), $i+1, $pn );
						$HTML_PAGES_LINKS .= '<a class="a-text" href="'.$P_LINK.'#lottable">...</a>';
					}
				}
			//}

			// Show last page link
			if( $pi == $TOTAL_PAGES )
				$HTML_PAGES_LINKS .= '<span class="a-text">'.$TOTAL_PAGES.'</span>';
			else
				$HTML_PAGES_LINKS .= '<a class="a-text" href="'.$P_L_LINK.'#lottable">'.$TOTAL_PAGES.'</a>';

			$HTML_PAGES_LINKS .= '<a class="a-next" href="'.$P_N_LINK.'#lottable"></a>';
			$HTML_PAGES_LINKS .= '<a class="a-last" href="'.$P_L_LINK.'#lottable"></a>';
			//$HTML_PAGES_LINKS .= '<span class="arrow">&#8594;</span>';
		}
	}
?>
		<a name="lottable"></a>
<?php
	if( $viewmod == "block" )
	{
?>
		<div class="mtinfo">
		<?php
		/*
			<div class="mtisort" style="position: relative;">
				<p class="float">Отобразить</p>
				<a id="tplnk3" class="tptypelnk" href="#"><span><?=$viewmod_name;?></span></a>
				<div id="tpdd3" class="tpdropdown" style="left:10px; top: 22px;">
					<div class="tpdinside">
					</div>
				</div>
			</div>
		*/
		?>
			<div class="fboard">
		<?php
			$COLS = 2;
			for($i=0; $i<count($its); $i++)
			{
				if( ($i+1) % $COLS == 1 )
					echo '<div class="fb-line">';

				$bidnum = TorgItem_BidNum( $LangId, $its[$i]['id'] );
				$bidbest = TorgItem_BidMinMax( $LangId, $its[$i]['id'], ($trade == $TORG_BUY ? "min" : "max") );

				$ITURL = TorgItem_BuildUrl( $LangId, $its[$i]['id'], $its[$i]['id'], $REGIONS_URL[$obl] );


				echo '<div class="fbtopic">
					<div class="fbtinfo">
						<table class="fbti_tbl">
							<tr>
								<th class="fbti_th0"><img width="28" height="29" alt="'.$its[$i]['cultname'].'" src="'.$its[$i]['cultico'].'" class="block" /></th>
								<th><a href="'.$ITURL.'">'.$its[$i]['cultname'].'</a></th>
								<th class="fbti_th1"></th>
								<th class="fbti_th2">'.$its[$i]['amount'].' т</th>
								<th></th>
								<th></th>
							</tr>
							<tr class="fbti_tr0">
								<td colspan="2"><a href="#" class="fw_bold">'.$its[$i]['elev_name'].'</a></td>
								<td></td>
								<td class="oblreg">'.$REGIONS[$obl].', '.$its[$i]['rayon'].' р-н</td>
								<td></td>
							</tr>
							<tr><td style="height:7px;"></td></tr>
							<tr>
								<td colspan="2">Стартовая цена</td>
								<td></td>
								<td><i>'.$its[$i]['cost'].' грн за тонну</i></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2">Текущая цена</td>
								<td></td>
								<td class="fbti_current">'.$bidbest.' грн за тонну</td>
								<td></td>
							</tr>
							<tr><td style="height:7px;"></td></tr>
							<tr><td style="height:7px;"></td></tr>
							<tr>
								<td colspan="2">До конца сделки</td>
								<td><img width="19" height="20" alt="" src="'.$IMGHOST.'img/ico-timeleft.png" class="block" /></td>
								<td>'.leftDtFromNow($its[$i]['dten']).'</td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>';

				// <a href="'.$ITURL.'"><span>'.Torg_LotIdStr($its[$i]['id']).'</span></a>
				// ($its[$i]['status'] >= 2 ? 3 : ($its[$i]['status']+1))

				if( ($i+1) % $COLS == 0 )
					echo '</div>';
			}
			if( ($i>0) && ($i % $COLS != 0) )
				echo '</div>';

			if( count($its) == 0 )
			{
				echo '<div class="fb-line">
					<div class="ta_center"><p class="mtinfo_p">С заданными парамтерами торгов не найдено</p></div>
				</div>';
			}
		?>
			</div><!-- fboard -->
		</div><!-- mtinfo -->
<?php
	}
	else
	{
?>
		<?php
		/*
		<div class="mtview" style="position: relative; z-index: 1;">
			<div style="float: left;">
				<?php
					//if( $UserId != 0 )
					//{
						$ADDURL = Torg_BuildUrl($LangId, "add", $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult);
						//echo '<a href="'.$ADDURL.'" class="addlink">Разместить новый лот</a>';
						//echo '<a href="'.$ADDURL.'" class="addlink0"><img src="'.$IMGHOST.'img/new/btn_newbuy_2.gif" width="275" height="33" border="0" alt="Разместить новое предложение" /></a>';
						echo '<a href="'.$ADDURL.'" class="addlink0"><img src="'.$IMGHOST.'img/btn-newlot-or-sm.gif" width="250" height="34" border="0" alt="Провести новый тендер" /></a>';
					//}
				?>
			</div>
           <?php
			<a id="tplnk3" class="tptypelnk" href="#"><span><?=$viewmod_name;?></span></a>
			<div id="tpdd3" class="tpdropdown" style="left:780px; top: 20px;">
				<div class="tpdinside">
				</div>
			</div>
			<p class="float_r">Отобразить</p>
			?>
		</div>
		*/
		?>
		<div class="mtinfo">
			<table class="mtinfo_tbl">
		<?php
			$S0_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, "torg_".( $sortby_col == "torg" ? $SORTODIR[$sortby_order] : $sortby_order ), 1, $pn )."#lottable";
			$S1_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, "lotid_".( $sortby_col == "lotid" ? $SORTODIR[$sortby_order] : $sortby_order ), 1, $pn )."#lottable";
			$S2_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, ($sortby_col == "timeend" ? ( $sortby_order == "up" ? "" : "timeend_".$SORTODIR[$sortby_order] ) : ($sortby_order == "up" ? "timeend_".$sortby_order : "") ), 1, $pn )."#lottable";
			$S3_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, "amount_".( $sortby_col == "amount" ? $SORTODIR[$sortby_order] : $sortby_order ), 1, $pn )."#lottable";
			if( $obl >= 0 )
			{
				$S4_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, "obl_".( $sortby_col == "obl" ? $SORTODIR[$sortby_order] : $sortby_order ), 1, $pn )."#lottable";
			}
			else
			{
				$S4_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, "ray_".( $sortby_col == "ray" ? $SORTODIR[$sortby_order] : $sortby_order ), 1, $pn )."#lottable";
			}
			$S5_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, "stcost_".( $sortby_col == "stcost" ? $SORTODIR[$sortby_order] : $sortby_order ), 1, $pn )."#lottable";
			$S6_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, "nowcost_".( $sortby_col == "nowcost" ? $SORTODIR[$sortby_order] : $sortby_order ), 1, $pn )."#lottable";
			$S7_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, "bidnum_".( $sortby_col == "bidnum" ? $SORTODIR[$sortby_order] : $sortby_order ), 1, $pn )."#lottable";
			$S8_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, "elev_".( $sortby_col == "elev" ? $SORTODIR[$sortby_order] : $sortby_order ), 1, $pn )."#lottable";
			$S9_LINK = Torg_BuildUrl( $LangId, $viewmod, $REGIONS_URL[$obl], $obl, $ray_url, $trade, $CULT_URL, $cult, $elev_url, "cult_".( $sortby_col == "cult" ? $SORTODIR[$sortby_order] : $sortby_order ), 1, $pn )."#lottable";

			$showelev = true;
			if( $obl >= 0 )
			{
				$showelev = false;
			}
		?>
				<thead>
					<tr>
						<th<?=($sortby_col == "lotid" ? ' class="'.($sortby_order == "up" ? "active" : "actived").'"' : '');?>><a <?=($viewmod == "vblock" ? ' rel="nofollow" ' : '');?>href="<?=$S1_LINK;?>"><span>№ торгов</span></a></th>
						<th<?=($sortby_col == "timeend" ? ' class="'.($sortby_order == "up" ? "active" : "actived").'"' : '');?>><a <?=($viewmod == "vblock" ? ' rel="nofollow" ' : '');?>href="<?=$S2_LINK;?>"><span><?=( $cult == 0 ? "До конца" : "До конца сделки");?></span></a></th>
						<?php
						if( $cult >= 0 )
						{
						?>
						<th<?=($sortby_col == "cult" ? ' class="'.($sortby_order == "up" ? "active" : "actived").'"' : '');?>><a <?=($viewmod == "vblock" ? ' rel="nofollow" ' : '');?>href="<?=$S9_LINK;?>"><span>Культура</span></a></th>
						<?php
						}
						?>
						<th<?=($sortby_col == "amount" ? ' class="'.($sortby_order == "up" ? "active" : "actived").'"' : '');?>><a <?=($viewmod == "vblock" ? ' rel="nofollow" ' : '');?>href="<?=$S3_LINK;?>"><span>Объем, т</span></a></th>
					<?php
						if( $obl >= 0 )
						{
							echo '<th'.($sortby_col == "torg" ? ' class="'.($sortby_order == "up" ? "active" : "actived").'"' : '').'><a '.($viewmod == "vblock" ? ' rel="nofollow" ' : '').'href="'.$S0_LINK.'"><span>Тип торгов</span></a></th>';
							echo '<th'.($sortby_col == "obl" ? ' class="'.($sortby_order == "up" ? "active" : "actived").'"' : '').'><a '.($viewmod == "vblock" ? ' rel="nofollow" ' : '').'href="'.$S4_LINK.'"><span>Область</span></a></th>';
						}
						else
						{
							echo '<th'.($sortby_col == "ray" ? ' class="'.($sortby_order == "up" ? "active" : "actived").'"' : '').'><a '.($viewmod == "vblock" ? ' rel="nofollow" ' : '').'href="'.$S4_LINK.'"><span>Район</span></a></th>';

							if( $showelev )
							{
								echo '<th'.($sortby_col == "elev" ? ' class="'.($sortby_order == "up" ? "active" : "actived").'"' : '').'><a '.($viewmod == "vblock" ? ' rel="nofollow" ' : '').' href="'.$S8_LINK.'"><span>Елеватор</span></a></th>';
							}
							else
							{
								echo '<th'.($sortby_col == "stcost" ? ' class="'.($sortby_order == "up" ? "active" : "actived").'"' : '').'><a '.($viewmod == "vblock" ? ' rel="nofollow" ' : '').' href="'.$S5_LINK.'"><span>Стартовая цена,</span><br/><span class="fnt12">грн за тонну</span></a></th>';
							}
						}
					?>
						<th<?=($sortby_col == "nowcost" ? ' class="'.($sortby_order == "up" ? "active" : "actived").'"' : '');?>><a <?=($viewmod == "vblock" ? ' rel="nofollow" ' : '');?>href="<?=$S6_LINK;?>"><span>Тек. цена,</span><br/><span class="fnt12">грн за т.</span></a></th>
						<th<?=($sortby_col == "stcost" ? ' class="'.($sortby_order == "up" ? "active" : "actived").'"' : '');?>><a <?=($viewmod == "vblock" ? ' rel="nofollow" ' : '');?>href="<?=$S5_LINK;?>"><span>Старт. цена,</span><br/><span class="fnt12">грн за т.</span></a></th>
						<th<?=($sortby_col == "bidnum" ? ' class="'.($sortby_order == "up" ? "active" : "actived").'"' : '');?>><a <?=($viewmod == "vblock" ? ' rel="nofollow" ' : '');?>href="<?=$S7_LINK;?>"><span>Предл.</span></a></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="<?=( $cult == 0 ? 10 : 9 );?>">
							<noindex>
							<form name="pagerfrm" action="<?=$WWWHOST;?>torgi.php#lottable" method="GET">
							<p class="float">Отображать по </p>
							<input type="hidden" name="obl" value="<?=$obl;?>" />
							<input type="hidden" name="ray_url" value="<?=$ray_url;?>" />
							<input type="hidden" name="trade" value="<?=$trade;?>" />
							<input type="hidden" name="cult" value="<?=$cult;?>" />
							<input type="hidden" name="sortby" value="<?=($sortby == $SORTBY_DEF ? "" : $sortby);?>" />
							<select name="pn" id="mti_select1" onchange="changePerPage(this);">
								<option value="10"<?=($pn == 10 ? ' selected="selected"' : '');?>>10</option>
								<option value="25"<?=($pn == 25 ? ' selected="selected"' : '');?>>25</option>
								<option value="50"<?=($pn == 50 ? ' selected="selected"' : '');?>>50</option>
							</select>
							<p class="float">записей</p>
							</form>
							</noindex>
						</td>
					</tr>
				</tfoot>
				<tbody>
		<?php
			for($i=0; $i<count($its); $i++)
			{
				$bidnum = TorgItem_BidNum( $LangId, $its[$i]['id'] );
				$bidbest = TorgItem_BidMinMax( $LangId, $its[$i]['id'], ($trade == $TORG_BUY ? "min" : "max") );

				$ITURL = TorgItem_BuildUrl( $LangId, $its[$i]['id'], $its[$i]['id'], $REGIONS_URL[$obl] );
				echo '<tr class="odd" onclick="ugo(\''.$ITURL.'\')">
						<td class="ta_center"><a class="mtinfo_lot mtinfo_lot_'.($its[$i]['status'] >= 2 ? 3 : ($its[$i]['status']+1)).'" href="'.$ITURL.'"><span>'.Torg_LotIdStr($its[$i]['id']).'</span></a></td>
						<td class="ta_left"><p class="mtinfo_status">'.leftDtFromNow($its[$i]['dten'], true, 0, 0, "short").'</p></td>';

				//if( $cult == 0 )
				//{
					echo '<td class="ta_left"><p class="mtinfo_culture" style="background-image:url(\''.$its[$i]['cultico'].'\');">'.$its[$i]['cultname'].'</p></td>';
				//}

				echo '<td class="ta_center"><p class="mtinfo_p">'.$its[$i]['amount'].'</p></td>';

				if( $obl >= 0 )
				{
					echo '<td class="ta_left"><p class="mtinfo_p">'.$TORG_TYPES[$its[$i]['torg_type']].'</p></td>';
					echo '<td class="ta_left"><p class="mtinfo_p">'.$REGIONS[$its[$i]['obl_id']].'</p></td>';
				}
				else
				{
					echo '<td class="ta_left"><p class="mtinfo_p">'.$its[$i]['rayon'].'</p></td>';

					if( $showelev )
					{
						echo '<td class="ta_left"><p class="mtinfo_p">'.$its[$i]['elev_name'].'</p></td>';
					}
					else
					{
						echo '<td class="ta_center"><p class="mtinfo_p">'.$its[$i]['cost'].'</p></td>';
					}
				}

				echo '
						<td class="ta_center"><p class="mtinfo_cprice">'.$bidbest.'</p></td>
						<td class="ta_center"><p class="mtinfo_p">'.$its[$i]['cost'].'</p></td>
						<td class="ta_center"><p class="mtinfo_p">'.$bidnum.'</p></td>
					</tr>';
			}

			if( count($its) == 0 )
			{
				echo '<tr class="odd">
						<td class="ta_center" colspan="'.( $cult == 0 ? 9 : 8 ).'"><p class="mtinfo_p">С заданными параметрами торгов не найдено</p></td>
					</tr>';
			}

			/*
		?>
					<tr class="even">
						<td class="ta_center"><a class="mtinfo_lot mtinfo_lot_1" href="#"><span>123654</span></a></td>
						<td class="ta_center"><p class="mtinfo_status">1 день 1 час 27 минут</p></td>
						<td class="ta_center"><p class="mtinfo_p">3 100</p></td>
						<td class="ta_center"><p class="mtinfo_p">Первомайский</p></td>
						<td class="ta_center"><p class="mtinfo_p">800</p></td>
						<td class="ta_center"><p class="mtinfo_cprice">790</p></td>
						<td class="ta_center"><p class="mtinfo_p">5</p></td>
					</tr>
		*/
		?>
				</tbody>
			</table>
		</div>
		<div class="mtpager">
			<div class="mtpages">
				<?=$HTML_PAGES_LINKS;?>
			</div>
		</div>
<?php
		if( $cult != 0 )
		{
			echo '<div style="clear: left; padding: 6px 0px 10px 0px;"><a href="'.$WWWHOST.'bcab_subscribe.php?action=addtend&tobl='.$obl.'&tcult='.$cult.'&ttype='.$trade.'"><img src="'.$IMGHOST.'img/btn_sub_new_tenders.png" width="232" height="38" alt="Подписаться на тендеры" /></a></div>';
		}
	}

	if( (isset($ray_str00) && ($ray_str00!="")) || ($sortby != $SORTBY_DEF) || ($pi > 1) )
	{
		// Не показывать сео текст
	}
	else
	{
		if( $cult_name0 != "" )
		{
?>
		<div itemscope itemtype="http://data-vocabulary.org/Product">
			<span itemprop="brand">Аграрная продукция</span> <span itemprop="name"><?=$cult_name0;?></span>
			<span itemprop="review" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
				Средняя оценка: <span itemprop="rating"><?=( $TOTAL_LOTS == 0 ? 0.0 : "4.".($TOTAL_LOTS % 10) );?></span> на основе <span itemprop="count"><?=$TOTAL_LOTS;?></span> отзывов
			</span>
			<?php
			/*
			<span itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer-aggregate">
				Цена от $<span itemprop="lowPrice">1,21</span> до $<span itemprop="highPrice">1 584,31</span>
				<meta itemprop="currency" content="USD" />
			</span>
			*/
			?>
		</div>
<?php
		}
	}
?>
		<div class="both"></div>
	</div>
<?php
	}

	if( (isset($ray_str00) && ($ray_str00!="")) || ($sortby != $SORTBY_DEF) || ($pi > 1) )
	{
		// Не показывать сео текст
	}
	else
	{
?>
	<div class="mtext">
		<?=( $PAGE_TXT2 );?>
		<?php
		//$page['content'];
		?>
	</div>
<?php
	}

	$ban_html = Banners_Place_Show( 2, 12, $ALLBANS );
	if( $ban_html != "" )
	{
		echo '<div class="cenbanner">'.$ban_html.'</div>';
	}

	////////////////////////////////////////////////////////////////////////////
	include "inc/footer-inc.php";
	include "inc/close-inc.php";
?>