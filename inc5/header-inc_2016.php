<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////	


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
	$slides = Sildes_Get($LangId);

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
<!DOCTYPE html>
<html>
<head>
	<meta charset="windows-1251">
	<link href="<?=$WWWHOST;?>favicon.ico" type="image/x-icon" rel="shortcut icon">
	<title><?=( isset($PAGE_TITLE) ? $PAGE_TITLE : $page['seo_title']);?></title>
	<meta name="keywords" content="<?=( isset($PAGE_KEYWORD)  ? str_replace("\"", "", $PAGE_KEYWORD) : str_replace("\"", "", $page['seo_keywords']));?>" />
	<meta name="description" content="<?=( isset($PAGE_DESCR) ? str_replace("\"", "", $PAGE_DESCR) : str_replace("\"", "", $page['seo_descr']));?>" />
<?php
	if( isset($METANOINDEX) && $METANOINDEX )
	{
		echo '
	<meta name="robots" content="noindex,nofollow" />
';
	}

	/*
	if( isset($META_SHOW_SITEMAP) && $META_SHOW_SITEMAP )
	{
?>
	<meta name="robots" content="index, follow, noarchive" />
<?php
	}

	if( isset($META_NOINDEX) && $META_NOINDEX )
	{
?>
	<meta name="robots" content="noindex,nofollow" />
<?php
	}

	if( isset($CANONICAL_PAGE) && ($CANONICAL_PAGE != "") )
	{
?>
	<link rel="canonical" href="<?=$CANONICAL_PAGE;?>" />
<?php
	}
	*/
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/all.css" />
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/carousel.css">
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/ie.css" />
	<![endif]-->
	<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/ltie7.css" />
	<![endif]-->
	
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/jquery-ui.css" />
	<?php
	/*
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/jquery-ui.theme.css" />
	*/
	?>
	
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/jquery-ui.js"></script>
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/slides.min.jquery.js"></script>
	
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/jquery.jcarousel.min.js"></script>
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/jcarousel-init.js"></script>

		
	<script type="text/javascript" src="<?=$WWWHOST;?>js/main.js"></script>
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/main15.js"></script>
<?php	
	if( $pname == "addtorg" )
	{
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>calendar/calendar.css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>calendar/calendar.js"></script>
<?php
	}

	/*
	if( ($pname == "tradersnew") || ($pname == "traders") )
	{
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css/popupmenu.css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>js/popupmenu.js"></script>
<?php
	}
	*/

	if( ($pname == "product") || ($pname == "board") )
	{
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>js5/fancybox/jquery.fancybox.css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/fancybox/jquery.fancybox.pack.js"></script>
<?php	
	}
?>
<script type="text/javascript">
	//Cufon.replace("ul.mainmenu14 li .hmmdm14, .hdr-cuf, .ucab-menu-it", {fontFamily: "PLFN"});

	var debug1 = '', mt, mStatus, mt2;
	$(document).ready(function(){
		$("#lnk-toggle-menu").bind("click", function(){
			$(".mpan-norm").toggleClass("mpan-norm-open");
			return false
		});
		
		//$("#ilenta-list").jcarousel({ scroll:1 }).jcarouselAutoscroll({autostart: true, interval: 3000, target: '+=3'});
		$("#ilenta-list").jcarousel({ scroll:3 });

		initJCarouselControls();
		
		//$("ul.mainmenu li.hmm_li").bind("mouseover", function(){$(this).addClass("hover");});
		//$("ul.mainmenu li.hmm_li").bind("mouseout", function(){$(this).removeClass("hover");});
		<?php
		if( ($pname == "product") || ($pname == "board") )
		{
		?>
		$("#menu").menu();
		
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
		
		if( $pname == "kompanii" )
		{
		?>
		$("#menu").menu();
		<?php
		}

		if( ($pname == "tradersnew") || ($pname == "traders") )
		{
		?>
		$("#menu").menu();
		$("#accordion").accordion({heightStyle: "content"});
		//$("#cultpop").addpopupmenu('popmenu1');
		//$("#regionpop").addpopupmenu('popmenu2');
		
		$(".flt-opts input[type=checkbox]").bind("click", function(){			
			//if( $(this).is(":checked") )
			location.href= $(this).parent().find("a").attr("href");			
		});
		
		<?php
		}

		if( ($pname == "board") || ($pname == "board2013") || ($pname == "kompanii") )
		{
			/*
		?>
		var menu = $("ul.bmm14a li.hmm14a_li");
		for (var i=0; i<menu.length; i++){$(menu[i]).attr("id", "topm"+(i+1));};
		menu.hover(
			function(){
				var idx = $(this).attr("id").replace("topm", "");
				clearTimeout(mt);
				mt = setTimeout(function(){
					if (mStatus == 'show'){
						menu.each(function(){$(this).removeClass("hover");});
						$("#topm"+idx).addClass("hover");
					}
				}, 250);
				mStatus = 'show';
			},
			function(){
				var idx = $(this).attr("id").replace("topm", "");
				menu.each(function(){$(this).removeClass("hover");});
				mStatus = 'hide';
			}
		);
		<?php
			*/
		}
		
		if( $pname == "search" )
		{
		?>
		$("#menu").menu();
		<?php
		}
		?>
		
		$("ul.mainmenu li.hmm_li").bind("mouseover", function(){
			$(this).addClass("hover"); 
		});
		$("ul.mainmenu li.hmm_li").bind("mouseout", function(){
			$(this).removeClass("hover");
		});
	});
</script>
<script type="text/javascript">
<?php
/*
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30882697-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
*/

	if( ($pname != "index1") && ($pname != "traders1") && ($pname != "kompanii") && ($pname != "news1") )
	{
/*
?>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-33473390-1', 'agrotender.com.ua');
  ga('send', 'pageview');




<?php
*/
	}
?>
</script>
</head>
<?php
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	// Banners load
	//	
	
	$page_type = 3;	
	if( ($pname == "index") || ($pname == "index1") )
	{
		$page_type = 1;		
	}
	else if( ($pname == "torgi") || ($pname == "iteminfo") || ($pname == "addtorg" ) )
	{
		$page_type = 2;
	}	
	
	// Load banners for left col
	$ban_html_left = Banners_Place_Show( $page_type, 1, $ALLBANS );
	$ban_html_left2 = Banners_Place_Show( $page_type, 2, $ALLBANS );
	$ban_html_left3 = Banners_Place_Show( $page_type, 3, $ALLBANS );
	$ban_html_left4 = Banners_Place_Show( $page_type, 4, $ALLBANS );
	$ban_html_left5 = Banners_Place_Show( $page_type, 5, $ALLBANS );
	
	// Load banners for right col
	$ban_html_right = Banners_Place_Show( $page_type, 6, $ALLBANS );
	$ban_html_right2 = Banners_Place_Show( $page_type, 7, $ALLBANS );
	$ban_html_right3 = Banners_Place_Show( $page_type, 8, $ALLBANS );
	$ban_html_right4 = Banners_Place_Show( $page_type, 9, $ALLBANS );
	$ban_html_right5 = Banners_Place_Show( $page_type, 10, $ALLBANS );
	
	// Load banners for center
	$banc1_html = Banners_Place_Show( $page_type, 13, $ALLBANS );
	$banc2_html = Banners_Place_Show( $page_type, 14, $ALLBANS );
	$banc3_html = Banners_Place_Show( $page_type, 15, $ALLBANS );

	// Build banner show flag
	$ban_top_show	= ( ($banc1_html != "") || ($banc2_html != "") || ($banc3_html != "") );
	$ban_left_show 	= ( ($ban_html_left != "") || ($ban_html_left2 != "") || ($ban_html_left3 != "") || ($ban_html_left4 != "") || ($ban_html_left5 != "") );
	$ban_right_show = ( ($ban_html_right != "") || ($ban_html_right2 != "") || ($ban_html_right3 != "") || ($ban_html_right4 != "") || ($ban_html_right5 != "") );
	
	//if( $ban_left_show || $ban_right_show )
	
	$LEFT_BANNERS_HTML = '';
	
	if( $ban_left_show )
	{
		if( $ban_html_left != "" )
			$LEFT_BANNERS_HTML .= '<div>'.$ban_html_left.'</div>';

		if( $ban_html_left2 != "" )
			$LEFT_BANNERS_HTML .= '<div>'.$ban_html_left2.'</div>';

		if( $ban_html_left3 != "" )
			$LEFT_BANNERS_HTML .= '<div>'.$ban_html_left3.'</div>';

		if( $ban_html_left4 != "" )
			$LEFT_BANNERS_HTML .= '<div>'.$ban_html_left4.'</div>';

		if( $ban_html_left5 != "" )
			$LEFT_BANNERS_HTML .= '<div>'.$ban_html_left5.'</div>';
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<body>

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


	<header>	
		<div class="wrapper">
			<div id="logo">
				<a href="<?=$WWWHOST;?>"><img src="<?=$IMGHOST;?>img5/agrotender-logo.png" alt="Агротендер - продажа аграрной продукции" /></a>
			</div>
			<div class="header-right">
				<div class="hbtns">
				<?php
					if( $UserId > 0 )
					{
						$complist = Comp_Items( $LangId, 0, 0, 0, 0, -1, 20, $UserId, true );
					//echo count($complist)."<br>";
					}
					if( ($UserId>0) && (count($complist)>0) )
					{
						// Don't show
					}
					else
					{
				?>
					<a href="<?=( $UserId == 0 ? Page_BuildUrl($LangId, "buyerreg", "") : $WWWHOST.'bcab_comp.php?action=addcomp' );?>" class="btn btn-light btn-ireg" onclick="yaCounter117048.reachGoal('AddKompTop');"><span>Зарегистрировать компанию</span></a>
				<?php
					}
				?>
					<a href="<?=Page_BuildUrl($LangId, "board", (( ($UserId>0) && (count($complist)>0) ) ? "addcpost" : "addpost"));?>" onclick="yaCounter117048.reachGoal('AddAdTop');" class="btn btn-light btn-iadv"><span>Подать объявление</span></a>
				<?php
					if( $UserId == 0 )
					{
						echo '<a href="'.Page_BuildUrl($LangId,"buyerlog","").'" class="btn btn-dark btn-ilog"><span>Вход для посетителей</span></a>';
						//echo '<div><a id="loginlnk" href="'.Page_BuildUrl($LangId,"buyerlog","").'"><span>Вход для посетителей</span></a></div>';
					}
					else
					{
						echo '<noindex><a rel="nofollow" href="'.$WWWHOST.'bcab_posts.php'.(( ($UserId>0) && (count($complist)>0) ) ? "?viewcomp=1" : "").'" class="btn btn-dark btn-ilog"><span>Мой кабинет</span></a>
						<a rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout" class="btn btn-dark btn-ilog"><span>Выйти</span></a></noindex>';
						
						//echo '<div><noindex>
						//	'.( false ? '<div class="mycab"><a rel="nofollow" href="'.$WWWHOST.'bcab_cabinet.php">Мой кабинет</a></div>
						//	<div class="mypers"><a rel="nofollow" href="'.$WWWHOST.'bcab_personal.php">Мои данные</a></div>' :
						//	'<a rel="nofollow" href="'.$WWWHOST.'bcab_posts.php">Мой кабинет</a><br />' ).'
						//	<a rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout">Выйти</a>
						//</noindex></div>';

						/*
						echo '<div class="ta_center">Здраствуйте <b>'.$UserName.'</b></div>';
						*/
					}
				?>
				</div>	
				<?php
				/*
				<!--
				<div id="srchpan">
					<form action="#">
					<table>
					<tr>
						<td class="tdinp"><input type="text" id="searchsw" name="searchsw" value="например, Huawei ZX45" /></td>
						<td><input type="submit" class="btn btn-dark" id="searchbut" value=" Найти "></td>
					</tr>
					</table>
					</form>
				</div>-->
				*/
				?>
				<div class="both"></div>				
			</div>		
			<div class="both"></div>
		</div>
	</header>	
	<nav class="mpan">
		<div class="wrapper">			
			<div class="mpan-mob"><a id="lnk-toggle-menu" href="#"><span class="mmbtn-bar"></span><span class="mmbtn-bar"></span><span class="mmbtn-bar"></span></a></div>
			<div class="mpan-norm">
				<ul class="mainmenu">	
		<?php
			$MAIN_MENU = $menus = Menu_GetLevel( 0, 1, $pname, $LangId );
			for($i=0; $i<(count($menus)-1); $i++)
			{
				if( $menus[$i]['selected'] )
				{					
					echo '<li class="hmm_li  active" id="m'.($i+1).'">
						<div class="hmm_div">
							<div class="hmmdm"><a href="'.$menus[$i]['link'].'">'.$menus[$i]['name'].'</a></div>
						</div>										
					</li>';
				}
				else
				{
					echo '<li class="hmm_li" id="m'.($i+1).'">
						<div class="hmm_div">
							<div class="hmmdm"><a href="'.$menus[$i]['link'].'">'.$menus[$i]['name'].'</a></div>
						</div>										
					</li>';
				}
			}
			/*
		?>
					<li class="hmm_li" id="m1">
						<div class="hmm_div">
							<div class="hmmdm"><a href="#">Главная</a></div>
						</div>										
					</li>
					<li class="hmm_li" id="m2">
						<div class="hmm_div">
							<div class="hmmdm"><a href="#">Объявления</a></div>
						</div>		
					</li>	
					<li class="hmm_li" id="m3">
						<div class="hmm_div">
							<div class="hmmdm"><a href="#">Компании</a></div>
						</div>		
					</li>	
					<li class="hmm_li" id="m4">
						<div class="hmm_div">
							<div class="hmmdm"><a href="#">Цены трейдеров</a></div>
						</div>		
					</li>	
					<li class="hmm_li" id="m5">
						<div class="hmm_div">
							<div class="hmmdm"><a href="#">Статьи</a></div>
						</div>								
					</li>	
					<li class="hmm_li" id="m6">
						<div class="hmm_div">
							<div class="hmmdm"><a href="#">Контакты</a></div>
						</div>		
					</li>
			*/
		?>
				</ul>
			</div>
		</div>		
		<div class="mpan_sub"></div>		
	</nav>
	<div class="wrapper">
<?php
	// Banners_Place_Show( page_type, place, banners )
	//		page_type:
	//			1 - index
	//			2 - торги по регионам
	//			3 - all pages
	
	if( $ban_top_show )
	{
		echo '<section id="toprekl">		
			<div>'.$banc1_html.'</div>
			<div>'.$banc2_html.'</div>
			<div>'.$banc3_html.'</div>
			<div class="both"></div>
		</section>';
	}
	
	
	
	if( $pname != "index" )
	{
		//$news = News_Items($LangId, $NEWS_ALL, "anons", 130, 0, 12);
		
		$seltype_id = Array($LENTA_TNEWCOST, $LENTA_TNEWNEWS);
		$lentahtml = Lenta_BuildHtml($LangId, $LENTA_TRADER, $seltype_id, (isset($submode_topic) ? $submode_topic : 0), 40, 1515);
		
		if( $lentahtml != "" )
		{
			
			echo '<section id="ilenta">
				<div class="ilenta-clip">
				<div class="jcarousel-skin-ilenta">

					<!-- Carousel -->
					<div id="ilenta-list" class="jcarousel">
					<ul>
			';										
			
			echo $lentahtml;
			
			/*
			for( $i=0; $i<count($news); $i++ )
			{
				$NEWS_LINK = News_BuildUrl($LangId, 0, 0, ($WWW_LINK_MODE == "html" ? $news[$i]['url'] : $news[$i]['id']), "", $news[$i]['date_y'], $news[$i]['date_m']);

				$month_names = Array("", "января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
				$dt_str = sprintf("%02d %s %04d г.", $news[$i]['date_d'], $month_names[$news[$i]['date_m']], $news[$i]['date_y']);
				
				echo '<li>
					<div class="ilenta-it">
						<div class="ilenta-it-tm"><span>'.( false ? '17:09' : sprintf("%02d.%02d", $news[$i]['date_d'], $news[$i]['date_m']) ).'</span></div>
						<table>
						<tr>
							<td>'.($news[$i]['img_src'] != "" ? '<a href="'.$NEWS_LINK.'"><img src="'.$news[$i]['img_src'].'" alt="" width="50" /></a>' : '').'</td>
							<td><a href="'.$NEWS_LINK.'">'.( strlen($news[$i]['title']) > 57 ? substr($news[$i]['title'], 0, 56)."..." : $news[$i]['title'] ).'</a></td>
						</tr>
						</table>
					</div>
				</li>';			
			}
			*/
			
			echo '</ul>
					</div>

					<!-- Prev/next controls -->
					<a href="#" class="jcarousel-control-prev"></a>
					<a href="#" class="jcarousel-control-next"></a>

				</div>		
				<div class="both"></div>
				</div>
			</section>';
		}
	}
	

	
	if( isset($LEFT_CAB_MENU) && ($LEFT_CAB_MENU != "") )
	{
		//echo $LEFT_CAB_MENU;
	}

	/*
	if( $ban_left_show || $ban_right_show )
	{
		if( $ban_html_left != "" )
			echo '<div class="banner">'.$ban_html_left.'</div>';

		if( $ban_html_left2 != "" )
			echo '<div class="banner">'.$ban_html_left2.'</div>';

		if( $ban_html_left3 != "" )
			echo '<div class="banner">'.$ban_html_left3.'</div>';

		if( $ban_html_left4 != "" )
			echo '<div class="banner">'.$ban_html_left4.'</div>';

		if( $ban_html_left5 != "" )
			echo '<div class="banner">'.$ban_html_left5.'</div>';
	}
	*/


	/////////////////////////////////////////////////////////////////

	if( $pname == "index" )
	{
		/*
		echo '<div class="hbanners">
		<div id="hslides">';

		if( count($slides)>0 )
		{
			echo '<div class="slides_container">
			';
			for($i=0;$i<count($slides);$i++)
			{
				echo '<div class="hslide"><a href="'.($slides[$i]['url'] != "" ? $slides[$i]['url'] : $WWWHOST).'"><img src="'.$slides[$i]['filename'].'" alt="'.$slides[$i]['alt'].'" width="726" height="175" /></a></div>';
			}
			//echo '<a href="#"><img src="img/img-slides-01.jpg" alt="" width="726" height="175" /></a>
			//<a href="#"><img src="img/img-slides-02.jpg" alt="" width="726" height="175" /></a>';
			echo '</div>';
		}

		echo '</div>
		</div>';
		*/
	}
?>
<?php
	/*
	if( ($pname == "catalog") && isset($FILTERS_HTML) )
	{
		echo $FILTERS_HTML;
	}

	// Get links (partners)
	$plist = Partners_List($LangId);

	if( count($plist) > 0 )
	{
		for($i=0; $i<count($plist); $i++)
		{
			$PLINK = $plist[$i]['url'];
			echo '<div class="sltlitem">
					<div class="sltli_image">
						<a href="'.$PLINK.'"><img src="'.$plist[$i]['pic'].'" alt="" width="199" height="69" /></a>
					</div>
					<p class="sltli_link"><a href="'.$PLINK.'">'.$plist[$i]['name'].'</a></p>
				</div>';
		}
	}

	// Вопросы и ответы
	$faqs = Faq_Items( $LangId, 0, 0, 1, "rand" );

	$faq = $faqs[0];

	$faq_anons = $faq['text'];
	$faq_anons = ( mb_strlen($faq_anons) > 160 ? mb_substr($faq_anons, 0, 166) : $faq_anons );

	echo '<div class="sltlist sltl_choise">
		<div class="sltlitem">
			<p class="sltli_title"><a href="<?=Faq_BuildUrl($LangId, $faq['id']);?>"><?=$faq['title'];?></a></p>
			<div class="sltli_text"><?=$faq_anons;?>...</div>
		</div>
		<div class="mmore">
			<a href="<?=Faq_BuildUrl($LangId);?>">Все статьи</a>
		</div>
	</div>';
	*/
?>