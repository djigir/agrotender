<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////

	$IS_TEST_MODE = true;

	//------------------- Extract contacts from database -----------------------
	$continfo = Contacts_Get( $LangId );

	//--------------------- Fill page information array ------------------------
	if( empty( $page['id'] ) )
	{
		$page['id'] = 0;
		$page['title'] = "";
		$page['header'] = "";
		$page['content'] = "";

		$page['seo_title'] = "";
		$page['seo_keywords'] = "";
		$page['seo_descr'] = "";

		$page = Page_GetInfo( $LangId, $pname );
	}

	//--------------------- GET SLIDES FOR SPLASH ------------------------------
	//$slides = Sildes_Get($LangId);

	//------------------------ GET TEXT BLOCKS ---------------------------------
	$txt_res = Resources_Get($LangId);

	//------------------------- GET BANNERS ------------------------------------
	$ALLBANS = Banners_Place_Rotate( $LangId );

	if( $pname == "index1" )
	{
		//nl2br(var_dump($ALLBANS));
	}

	//--------------------------------------------------------------------------
	// Now we should separate the country code and city code from telephone number
	/*
	$phone_parts 	= explode(" ", $continfo['phone1'], 3);
	$phone_code 	= $phone_parts[0]." ".$phone_parts[1];
	$phone_number 	= $phone_parts[2];
	$phone_parts2 	= explode(" ", $continfo['phone2'], 3);
	$phone_code2 	= $phone_parts2[0]." ".$phone_parts2[1];
	$phone_number2 	= $phone_parts2[2];
	$phone_parts3 	= explode(" ", $continfo['fax'], 3);
	$phone_code3 	= $phone_parts2[0]." ".$phone_parts2[1];
	$phone_number3 	= $phone_parts2[2];
	*/

	////////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<link href="<?=$WWWHOST;?>favicon.ico" type="image/x-icon" rel="shortcut icon">
	<title><?=( isset($PAGE_TITLE) ? $PAGE_TITLE : $page['seo_title']);?></title>
	<meta name="keywords" content="<?=( isset($PAGE_KEYWORD)  ? str_replace("\"", "", $PAGE_KEYWORD) : str_replace("\"", "", $page['seo_keywords']));?>" />
	<meta name="description" content="<?=( isset($PAGE_DESCR) ? str_replace("\"", "", $PAGE_DESCR) : str_replace("\"", "", $page['seo_descr']));?>" />

<?php
	if( isset($IS_TEST_MODE) && $IS_TEST_MODE )
	{
?>
		<meta name="robots" content="noindex,nofollow" />
<?php
	}

	if( isset($META_SHOW_SITEMAP) && $META_SHOW_SITEMAP )
	{
?>
	<meta name="robots" content="index, follow, noarchive" />
<?php
	}

	if( isset($META_NOINDEX) && $META_NOINDEX )
	{
?>
<?php
	}

	if( isset($CANONICAL_PAGE) && ($CANONICAL_PAGE != "") )
	{
?>
	<link rel="canonical" href="<?=$CANONICAL_PAGE;?>" />
<?php
	}
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>compcss/all.css" />
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>compcss/ie.css" />
	<![endif]-->
	<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>compcss/ltie7.css" />
	<![endif]-->
<?php
	if( isset($submode) && ($submode == "pricetbl") )
	{
	/*
?>
	<link href="<?=$WWWHOST;?>jqui/jquery-ui.css" rel="stylesheet">
	<script type="text/javascript" src="<?=$WWWHOST;?>jqui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?=$WWWHOST;?>js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="<?=$WWWHOST;?>js/jquery-1.4.4.min.js"></script>
	<link rel="stylesheet" media="screen" type="text/css" href="<?=$WWWHOST;?>js/datepicker/css/layout.css" />
	*/
?>
	<script type="text/javascript" src="<?=$WWWHOST;?>js/jquery-1.9.1.min.js"></script>
	<link rel="stylesheet" href="<?=$WWWHOST;?>js/datepicker/css/datepicker.css" type="text/css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>js/datepicker/js/datepicker_0.js"></script>
    <script type="text/javascript" src="<?=$WWWHOST;?>js/datepicker/js/eye.js"></script>
    <script type="text/javascript" src="<?=$WWWHOST;?>js/datepicker/js/utils.js"></script>
<?php
	}
	else
	{
?>
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/jquery-1.11.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>js5/fancybox/jquery.fancybox.css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/fancybox/jquery.fancybox.pack.js"></script>
<?php
	}	
?>
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/main15.js"></script>
<?php
	/*
	<script type="text/javascript" src="<?=$WWWHOST;?>js/cufon-yui.js"></script>
	<script type="text/javascript" src="<?=$WWWHOST;?>js/PLFN_400.font.js"></script>
	*/
?>
	<script type="text/javascript">
var reqajxhost = '<?=$WWWHOST;?>';
var showbmmact = false;
var timerid = 0;
function showBmmSub(mid)
{
	showbmmact = false;
	timerid = 0;
	$("#"+mid).addClass("hover");
}

	//Cufon.replace("ul.mainmenu14 li .hmmdm14, .hdr-cuf, .ucab-menu-it", {fontFamily: "PLFN"});

	var debug1 = '', mt, mStatus, mt2;
	$(document).ready(function()
	{
		$("ul.mainmenu li.hmm_li").bind("mouseover", function(){$(this).addClass("hover");});
		$("ul.mainmenu li.hmm_li").bind("mouseout", function(){$(this).removeClass("hover");});

	<?php
		if( isset($submode) && ($submode == "pricetbl") )
		{
		}
		else
		{
	?>

		$("a[rel=photo_group]").fancybox({
			overlayOpacity: 0.8,
			overlayColor: '#000',
			transitionIn: 'none',
			transitionOut: 'none',
			titlePosition: 'over',
			titleFormat: function(title, currentArray, currentIndex, currentOpts){
				return '<div id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</div>';
			}
		});
	<?php
		}
	?>
	});

var selected_oblast = 0;
var pich = '<?=$IMGHOST;?>';

var regurls = new Array("", "crimea",
	"vinnica",
	"volin",
	"dnepr",
	"donetsk",
	"zhitomir",
	"zakorpat",
	"zaporizh",
	"ivanofrank",
	"kyiv",
	"kirovograd",
	"lugansk",
	"lviv",
	"nikolaev",
	"odessa",
	"poltava",
	"rovno",
	"sumy",
	"ternopil",
	"kharkov",
	"kherson",
	"khmelnitsk",
	"cherkassi",
	"chernigov",
	"chernovci"
);

var curpic;
</script>
<script type="text/javascript">
<?php
	if( ($pname != "index1") && ($pname != "traders1") && ($pname != "news1") )
	{
		/*
?>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-33473390-1', 'agt.weehub.io');
  ga('send', 'pageview');
<?php
		*/
	}
?>
</script>
<?php


?>

</head>
<body>
<?php
	if( isset($IS_TEST_MODE) && $IS_TEST_MODE )
	{
		//
		
?>		
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter117048 = new Ya.Metrika({id:117048,
                    webvisor:true,
                    clickmap:true,type:1});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/117048?cnt-class=1" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<?php		
	}
	else
	{
?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter117048 = new Ya.Metrika({id:117048,
                    webvisor:true,
                    clickmap:true,type:1});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/117048?cnt-class=1" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<?php
	}

	$ban_html_right = "";
	$ban_html_right2 = "";
	$ban_html_right3 = "";
	$ban_html_right4 = "";
	$ban_html_right5 = "";
	$ban_html_left = "";
	$ban_html_left2 = "";
	$ban_html_left3 = "";
	$ban_html_left4 = "";
	$ban_html_left5 = "";
	if( ($pname == "index") || ($pname == "index1") )
	{
		$ban_html_left = Banners_Place_Show( 1, 1, $ALLBANS );
		$ban_html_left2 = Banners_Place_Show( 1, 2, $ALLBANS );
		$ban_html_left3 = Banners_Place_Show( 1, 3, $ALLBANS );
		$ban_html_left4 = Banners_Place_Show( 1, 4, $ALLBANS );
		$ban_html_left5 = Banners_Place_Show( 1, 5, $ALLBANS );
		//if( $pname == "index1" )
		//{
			//echo "<pre>Left".$ban_html_left."</pre>";
		//}
		$ban_html_right = Banners_Place_Show( 1, 6, $ALLBANS );
		$ban_html_right2 = Banners_Place_Show( 1, 7, $ALLBANS );
		$ban_html_right3 = Banners_Place_Show( 1, 8, $ALLBANS );
		$ban_html_right4 = Banners_Place_Show( 1, 9, $ALLBANS );
		$ban_html_right5 = Banners_Place_Show( 1, 10, $ALLBANS );
	}
	else if( ($pname == "torgi") || ($pname == "iteminfo") || ($pname == "addtorg" ) )
	{
		$ban_html_left = Banners_Place_Show( 2, 1, $ALLBANS );
		$ban_html_left2 = Banners_Place_Show( 2, 2, $ALLBANS );
		$ban_html_left3 = Banners_Place_Show( 2, 3, $ALLBANS );
		$ban_html_left4 = Banners_Place_Show( 2, 4, $ALLBANS );
		$ban_html_left5 = Banners_Place_Show( 2, 5, $ALLBANS );

		$ban_html_right = Banners_Place_Show( 2, 6, $ALLBANS );
		$ban_html_right2 = Banners_Place_Show( 2, 7, $ALLBANS );
		$ban_html_right3 = Banners_Place_Show( 2, 8, $ALLBANS );
		$ban_html_right4 = Banners_Place_Show( 2, 9, $ALLBANS );
		$ban_html_right5 = Banners_Place_Show( 2, 10, $ALLBANS );
	}
	else
	{
		$ban_html_left = Banners_Place_Show( 3, 1, $ALLBANS );
		$ban_html_left2 = Banners_Place_Show( 3, 2, $ALLBANS );
		$ban_html_left3 = Banners_Place_Show( 3, 3, $ALLBANS );
		$ban_html_left4 = Banners_Place_Show( 3, 4, $ALLBANS );
		$ban_html_left5 = Banners_Place_Show( 3, 5, $ALLBANS );

		$ban_html_right = Banners_Place_Show( 3, 6, $ALLBANS );
		$ban_html_right2 = Banners_Place_Show( 3, 7, $ALLBANS );
		$ban_html_right3 = Banners_Place_Show( 3, 8, $ALLBANS );
		$ban_html_right4 = Banners_Place_Show( 3, 9, $ALLBANS );
		$ban_html_right5 = Banners_Place_Show( 3, 10, $ALLBANS );
	}

	$ban_left_show = ( ($ban_html_left != "") || ($ban_html_left2 != "") || ($ban_html_left3 != "") || ($ban_html_left4 != "") || ($ban_html_left5 != "") );
	$ban_right_show = ( ($ban_html_right != "") || ($ban_html_right2 != "") || ($ban_html_right3 != "") || ($ban_html_right4 != "") || ($ban_html_right5 != "") );


	////////////////////////////////////////////////////////////////////////////
	// Get availiable sections for menu
	$COMP_ID = ( isset($compid) ? $compid : 0 );

	$BuyerCompId = Comp_UserByItem($LangId,$COMP_ID);

	//$COMPURL_TRANSLATE = Array(0, 4, 3, 5, 6, 7, 1, 2, 0);
	$COMPURL_TRANSLATE = Array(0, 6, 7, 2, 1, 3, 4, 5, 9, 9);

	$COMP_PAGES_CFG = Array(
		$CCAB_BLK_CONTACTS => Array("url" => "contacts", "name" => "Контакты", "urlid" => $COMPURL_TRANSLATE[$CCAB_BLK_CONTACTS]),
		$CCAB_BLK_ABOUT => Array("url" => "about", "name" => "О компании", "urlid" => $COMPURL_TRANSLATE[$CCAB_BLK_ABOUT]),
		$CCAB_BLK_NEWS => Array("url" => "news", "name" => "Новости", "urlid" => $COMPURL_TRANSLATE[$CCAB_BLK_NEWS]),
		$CCAB_BLK_VAC => Array("url" => "vacancy", "name" => "Вакансии", "urlid" => $COMPURL_TRANSLATE[$CCAB_BLK_VAC]),
		$CCAB_BLK_COMMENT => Array("url" => "comment", "name" => "Отзывы", "urlid" => $COMPURL_TRANSLATE[$CCAB_BLK_COMMENT]),
		$CCAB_BLK_ALLADVS => Array("url" => "publ", "name" => "Объявления", "urlid" => -1)
	);
	$COMP_PAGES = Array();
	$COMP_PAGES[] = Array("url" => "", "name" => "Главная", "urlid" => 0);

	$ADV_TABS_POST_NUM = Array();

	$advlnk_added = false;

	$blks = Array();

	$query = "SELECT b1.*, c1.id as spid, c1.sort_num as sort, c1.visible, c1.pic_ico,
		case when c1.id IS NOT NULL then 0 else 1 end as sortstart,
		case when c1.sort_num IS NOT NULL then c1.sort_num else 1000 end as realsort
		FROM $TABLE_COMPANY_STARTPAGE_BLKLIST b1
		LEFT JOIN $TABLE_COMPANY_STARTPAGE c1 ON b1.id=c1.blk_type_id AND c1.comp_id='$COMP_ID'
		ORDER BY sortstart, realsort, b1.sort_num";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$bi = Array();
			$bi['id'] = $row->id;
			$bi['name'] = stripslashes($row->name);

			$bi['rid'] = 0;
			$bi['rvis'] = 0;
			$bi['rsort'] = 0;
			$bi['rname'] = "";
			$bi['rico'] = "";

			$bi['show'] = false;

			if( $row->spid != null )
			{
				$bi['rid'] = $row->spid;
				$bi['rvis'] = $row->visible;
				$bi['rsort'] = $row->sort;
				$bi['rname'] = "";
				$bi['rico'] = stripslashes($row->pic_ico);

				$bi['show'] = false;

				switch($bi['id'])
				{
					case $CCAB_BLK_CONTACTS:
						$COMP_PAGES[] = $COMP_PAGES_CFG[$CCAB_BLK_CONTACTS];
						$bi['show'] = true;
						break;

					case $CCAB_BLK_ABOUT:
						$COMP_PAGES[] = $COMP_PAGES_CFG[$CCAB_BLK_ABOUT];
						$bi['show'] = true;
						break;

					case $CCAB_BLK_NEWS:
						$newsnum = Comp_News_Num($COMP_ID);
						if( $newsnum > 0 )
						{
							$COMP_PAGES[] = $COMP_PAGES_CFG[$CCAB_BLK_NEWS];
							$bi['show'] = true;
						}
						break;

					case $CCAB_BLK_VAC:
						$vacnum = Comp_Vac_Num($COMP_ID);
						if( $vacnum > 0 )
						{
							$COMP_PAGES[] = $COMP_PAGES_CFG[$CCAB_BLK_VAC];
							$bi['show'] = true;
						}
						break;
						
					//case $CCAB_BLK_COMMENT:
					//	$COMP_PAGES[] = $COMP_PAGES_CFG[$CCAB_BLK_COMMENT];
					//	//$bi['show'] = true;
					//	break;

					case $CCAB_BLK_GOODS:
						$viewarc = 0;
						$postnum_sell = Board_PostsNumByAuthor($BuyerCompId, "", 1, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SELL );
						if( $postnum_sell > 0 )
						{
							if( !$advlnk_added )
							{
								if( $COMP_PAGES_CFG[$CCAB_BLK_ALLADVS]['urlid'] == -1 )
									$COMP_PAGES_CFG[$CCAB_BLK_ALLADVS]['urlid'] = $COMPURL_TRANSLATE[$CCAB_BLK_GOODS];

								$COMP_PAGES[] = $COMP_PAGES_CFG[$CCAB_BLK_ALLADVS];
								$advlnk_added = true;
							}
							$bi['show'] = true;
						}
						//echo $postnum_sell."<br>";
						$ADV_TABS_POST_NUM[$BOARD_PTYPE_SELL] = $postnum_sell;
						break;

					case $CCAB_BLK_BUYS:
						$viewarc = 0;
						$postnum_buy = Board_PostsNumByAuthor($BuyerCompId, "", 1, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_BUY );
						if( $postnum_buy > 0 )
						{
							if( !$advlnk_added )
							{
								if( $COMP_PAGES_CFG[$CCAB_BLK_ALLADVS]['urlid'] == -1 )
									$COMP_PAGES_CFG[$CCAB_BLK_ALLADVS]['urlid'] = $COMPURL_TRANSLATE[$CCAB_BLK_BUYS];

								$COMP_PAGES[] = $COMP_PAGES_CFG[$CCAB_BLK_ALLADVS];
								$advlnk_added = true;
							}
							$bi['show'] = true;
						}
						$ADV_TABS_POST_NUM[$BOARD_PTYPE_BUY] = $postnum_buy;
						break;

					case $CCAB_BLK_SERV:
						$viewarc = 0;
						$postnum_serv = Board_PostsNumByAuthor($BuyerCompId, "", 1, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SERV );
						if( $postnum_serv > 0 )
						{
							if( !$advlnk_added )
							{
								if( $COMP_PAGES_CFG[$CCAB_BLK_ALLADVS]['urlid'] == -1 )
									$COMP_PAGES_CFG[$CCAB_BLK_ALLADVS]['urlid'] = $COMPURL_TRANSLATE[$CCAB_BLK_SERV];

								$COMP_PAGES[] = $COMP_PAGES_CFG[$CCAB_BLK_ALLADVS];
								$advlnk_added = true;
							}
							$bi['show'] = true;
						}
						$ADV_TABS_POST_NUM[$BOARD_PTYPE_SERV] = $postnum_serv;
						break;
				}
			}

			$blks[] = $bi;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);


	if( isset($COMP_FULLINFO) )
	{
		$COMP_PAGES[] = $COMP_PAGES_CFG[$CCAB_BLK_COMMENT];
		
		if( $COMP_FULLINFO['trader'] && $COMP_FULLINFO['trader_vis'] )
		{
			$COMP_PAGES[] = Array("trader_link" => true, "name" => "Цены трейдера");
		}
	}



	$FOOTER_MENU = "";

	$COMPURL0 = Comp_BuildUrl($LangId, "item", $REGIONS_URL[$it['obl_id']], 0, 0, $COMP_ID);
	
	// Get company comment rating
	$COMMENT_NUM = Comp_CommentNum( $COMP_ID );
	$COMMENT_AVG_RATE = Comp_CommentAvgRate( $COMP_ID );
?>
<div id="page">
	<div id="wrapper">
		<div id="top">
			<div id="topumenu">
	<?php
		//echo $UserId."<br>";
	
		if( $UserId == 0 )
		{
			echo '<a href="'.Page_BuildUrl($LangId,"buyerlog","").'"><span>Войти</span></a>';
		}
		else
		{
			$complist = Comp_Items( $LangId, 0, 0, 0, 0, -1, 20, $UserId, true );
			
			//echo $UserId.":".count($complist)."<Br>";
			
			echo '<noindex>
				<a rel="nofollow" href="'.$WWWHOST.'bcab_posts.php'.(( ($UserId>0) && (count($complist)>0) ) ? "?viewcomp=1" : "").'">Мой кабинет</a> &nbsp;|&nbsp; <a rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout">Выйти</a>
			</noindex>';
		}
	?>
			</div>
			<a href="<?=Comp_BuildUrl($LangId);?>">Все компании</a>
		</div>
		<div id="left">
			<div id="header"<?=( $COMP_HEADPIC != "" ? ' style="background-image: url('.$PICHOST.$COMP_HEADPIC.');"' : '' );?>>
				<div id="logo">
					<a href="<?=$COMPURL0;?>"><img src="<?=( isset($COMP_LOGO) ? $COMP_LOGO : '/compimg/logo-sample.jpg' );?>" alt="<?=( isset($COMP_NAME) ? $COMP_NAME : 'Компания на Агротендер' );?>" width="150" height="150" /></a>
				</div>
				<div id="comptitle"><span><?=( isset($COMP_NAME) ? $COMP_NAME : 'Компания на Агротендер' );?></span></div>

				<div id="compcomrate">
					<a href="comp-<?=$COMP_ID;?>-comment.html">
					Отзывов <?=$COMMENT_NUM;?> &nbsp; <img width="70" height="13" alt="Оценка отзыва <?=$COMMENT_AVG_RATE;?>" src="<?=$WWWHOST;?>img5/rate-<?=round($COMMENT_AVG_RATE);?>.png">
					</a>
				</div>
			</div>

			<div class="mpan">
				<ul class="mainmenu">
	<?php
		foreach($COMP_PAGES as $mmlnk)
		{
			if( isset($mmlnk['trader_link']) && $mmlnk['trader_link'] )
			{
				$COMPURL = Comp_BuildUrl($LangId, "pricetbl", $REGIONS_URL[$it['obl_id']], 0, 0, $COMP_ID);
			}
			else
			{
				$COMPURL = Comp_BuildUrl($LangId, "item", $REGIONS_URL[$it['obl_id']], $mmlnk['urlid'], 0, $COMP_ID);
			}

			echo '<li class="hmm_li">
				<div class="hmm_div">
					<div class="hmmdl"></div>
					<div class="hmmdm"><a href="'.$COMPURL.'">'.$mmlnk['name'].'</a></div>
					<div class="hmmdr"></div>
				</div>
			</li>';

			$FOOTER_MENU .= ($FOOTER_MENU != "" ? " &nbsp;&nbsp; " : "").'<a href="'.$COMPURL.'">'.$mmlnk['name'].'</a>';
		}

		/*
	?>
					<li class="hmm_li">
						<div class="hmm_div">
							<div class="hmmdl"></div>
							<div class="hmmdm"><a href="#">3G-комплекты</a></div>
							<div class="hmmdr"></div>
						</div>
						<div class="submenu" style="width:220px;">
							<div class="subcoll">
								<p class="subm_title">О нас</p>
								<ul class="subm_list">
									<li><a href="#">О магазине</a></li>
									<li><a href="#">Помощь при покупке</a></li>
									<li><a href="#">Контактная информация</a></li>
								</ul>
								<p class="subm_title">К сотрудничеству</p>
								<ul class="subm_list">
									<li><a href="#">Оптовым клиентам</a></li>
									<li><a href="#">Система скидок</a></li>
								</ul>
							</div>
							<div class="both"></div>
						</div>
					</li>
					<li class="hmm_li">
						<div class="hmm_div">
							<div class="hmmdl"></div>
							<div class="hmmdm"><a href="#">Каталог брендов</a></div>
							<div class="hmmdr"></div>
						</div>
					</li>
					<li class="hmm_li"><div class="hmm_div">
							<div class="hmmdl"></div>
							<div class="hmmdm"><a href="#">Цели тренировок</a></div>
							<div class="hmmdr"></div>
						</div>
					</li>
		*/
	?>
				</ul>
			</div>

			<div id="main">
<?php
	/*
	if( $UserId == 0 )
	{
		//echo '<div class="hlognew"><noindex><a rel="nofollow" href="'.Page_BuildUrl($LangId,"buyerlog","").'">Войти</a></noindex></div>';
		echo '<div><a id="loginlnk" href="'.Page_BuildUrl($LangId,"buyerlog","").'"><span>Вход для посетителей</span></a></div>';
	}
	else
	{
		echo '<div><noindex>
			'.( false ? '<div class="mycab"><a rel="nofollow" href="'.$WWWHOST.'bcab_cabinet.php">Мой кабинет</a></div>
			<div class="mypers"><a rel="nofollow" href="'.$WWWHOST.'bcab_personal.php">Мои данные</a></div>' :
			'<a rel="nofollow" href="'.$WWWHOST.'bcab_posts.php">Мой кабинет</a><br />' ).'
			<a rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout">Выйти</a>
		</noindex></div>';
	}
	*/
?>
