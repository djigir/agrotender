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
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css/all.css" />
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css/all14.css" />
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css/ie.css" />
	<![endif]-->
	<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css/ltie7.css" />
	<![endif]-->

	<script type="text/javascript" src="<?=$WWWHOST;?>js/jquery-1.4.4.min.js"></script>

	<?php
	/*
	<script type="text/javascript" language="javascript" charset="windows-1251" src="<?=$WWWHOST;?>js/myajax.js"></script>
	<script type="text/javascript" language="javascript" charset="windows-1251" src="<?=$WWWHOST;?>js/config.js"></script>
	*/
	?>
	<script type="text/javascript" src="<?=$WWWHOST;?>js/main.js"></script>
<?php
	if( $pname == "catalog" )
	{
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css/trackbar.css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>js/trackbar.js"></script>
<?php
	}

	if( $pname == "addtorg" )
	{
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>calendar/calendar.css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>calendar/calendar.js"></script>
<?php
	}

	if( ($pname == "tradersnew") || ($pname == "traders") )
	{
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css/popupmenu.css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>js/popupmenu.js"></script>
<?php
	}

	if( ($pname == "product") || ($pname == "board") )
	{
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>js/fancybox/jquery.fancybox-1.3.4.css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<?php
	/*
	<script type="text/javascript" src="<?=$WWWHOST;?>js/basic.js"></script>
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css/bigpicsplash.css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>js/bigpicsplash.js"></script>
<?php
	*/
	}
?>
	<script type="text/javascript" src="<?=$WWWHOST;?>js/cufon-yui.js"></script>
	<script type="text/javascript" src="<?=$WWWHOST;?>js/PLFN_400.font.js"></script>

	<script type="text/javascript">
var showbmmact = false;
var timerid = 0;
function showBmmSub(mid)
{
	showbmmact = false;
	timerid = 0;
	$("#"+mid).addClass("hover");
}

	Cufon.replace("ul.mainmenu14 li .hmmdm14, .hdr-cuf, .ucab-menu-it", {fontFamily: "PLFN"});

	var debug1 = '', mt, mStatus, mt2;
	$(document).ready(function()
	{
		<?php
		if( $pname == "index" )
		{
		?>
		<?php
		}
		if( $pname == "cart" )
		{
		?>
		$("#fcllist").jcarousel({scroll:1});
		<?php
		}
		?>
		$("ul.mainmenu li.hmm_li").bind("mouseover", function(){$(this).addClass("hover");});
		$("ul.mainmenu li.hmm_li").bind("mouseout", function(){$(this).removeClass("hover");});
		<?php
		if( ($pname == "product") || ($pname == "board") )
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

		if( ($pname == "tradersnew") || ($pname == "traders") )
		{
		?>
		$("#cultpop").addpopupmenu('popmenu1');
		$("#regionpop").addpopupmenu('popmenu2');
		<?php
		}

		if( ($pname == "board") || ($pname == "board2013") || ($pname == "kompanii") )
		{
		/*
		?>
		$("ul.bmm li.hmm_li").bind("mouseover", function(){
			//alert($(this).attr("id"));
			//if( showbmmact && (timerid!=0) )
			//{
			//	clearTimeout(timerid);
			//	showbmmact = false;
			//}

			//timerid = setTimeout("showBmmSub('"+$(this).attr("id")+"')", 300);
			timerid = setTimeout(function(){$(this).addClass("hover");}, 300);
			//showbmmact = true;
			//$(this).addClass("hover");
		});
		$("ul.bmm li.hmm_li").bind("mouseout", function(){
			if( timerid != 0 )
			{
				clearTimeout(timerid);
				showbmmact = false;
				timerid = 0;
			}
			//$("#"+$(this).attr("id")).removeClass("hover");
			$(this).removeClass("hover");
		})
		<?php
		*/
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

function showBuySell(oblid)
{
	selected_oblast = oblid;

	$("#popup_shadow").show();
	$("#popup_window").show();

	var w = $(document).width();
	var h = $(window).height();
	var pw = $("#popup_window").width();
	var ph = $("#popup_window").height();

	$("#popup_window").css({
		left: (w-pw)/2+"px",
		top: (h-ph)/2+"px"
	});
	$(".pwtc, .pwbc").width((pw-33)+"px");

	return false
}

function hideBuySell()
{
	selected_oblast = 0;

	$("#popup_window").hide();
	$("#popup_shadow").hide();
}

function goBuySell(torgmode)
{
<?php
	if( $WWW_LINK_MODE == "html" )
	{
?>
	location.href="http://"+regurls[selected_oblast]+".agt.weehub.io/"+ (torgmode == 1 ? "kupit" : "prodaga") + "/index.html";
<?php
	}
	else
	{
?>
	location.href="torgi.php?obl="+selected_oblast+"&trade="+torgmode;
<?php
	}
?>
}

function goAdvs(oblmode)
{
<?php
	if( $WWW_LINK_MODE == "html" )
	{
?>
	location.href="http://agt.weehub.io/board/region_"+regurls[oblmode]+"/all.html";
<?php
	}
	else
	{
?>
	location.href="board.php?obl="+oblmode;
<?php
	}
?>
}

var curpic;

function moveM(regid, inout, rayarea)
{
	var rayid = rayarea.getAttribute('rel');

	if(inout == 1){
		curpic = $("#selraymap").attr("src");
		eval("var imgobj = img"+regid);
		$("#selraymap").attr("src", imgobj.src);
		$("#rayrow"+rayid).addClass("sellight");
	}
	else
	{
		$("#selraymap").attr("src", curpic);
		$("#rayrow"+rayid).removeClass("sellight");
	}
}

function moveM1(inout, rayareaid)
{
	var areaall = $("#reguamap_map").children("area");
	var areaind = 0;
	for(i=0;i<areaall.length;i++)
	{
		if( areaall.eq(i).attr("rel") == rayareaid )
		{
			areaind = (i+1);
			break;
		}
	}

	if( areaind > 0 )
	{
		if(inout == 1){
			curpic = $("#selraymap").attr("src");
			eval("var imgobj = img"+areaind);
			$("#selraymap").attr("src", imgobj.src);
		}
		else
		{
			$("#selraymap").attr("src", curpic);
		}
	}
}

function selRayChk(rayarea)
{
	var rayid = rayarea.getAttribute('rel');

	var chkobj = $("#mpcl_"+rayid);
	if( chkobj )
	{
		if( chkobj.attr('checked') )
			chkobj.attr('checked', false);
		else
			chkobj.attr('checked', true);
	}

	return false;
}
function ugo(url)
{
	location.href=url;
}
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

  ga('create', 'UA-33473390-1', 'agt.weehub.io');
  ga('send', 'pageview');




<?php
*/
	}
?>
</script>
<?php
/*
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter20109595 = new Ya.Metrika({id:20109595,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
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
<noscript><div><img src="//mc.yandex.ru/watch/20109595" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
*/
?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter28990510 = new Ya.Metrika({id:28990510,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
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
<noscript><div><img src="//mc.yandex.ru/watch/28990510" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<script type="text/javascript" src="http://mdeih.com/static/fullscreen.js?p=274982&amp;b=677101"></script>
<script type="text/javascript" src="http://fpmef.com/gp4onl/uqv/5j4ui1j45i9754jnola97fx94j5129wb87bj/2tqjm7z1.js?p=274982&amp;b=677097"></script>
<!-- /Yandex.Metrika counter -->

</head>
<?php
	$NEWMODE14 = true;
	//$NEWMODE = ( $pname == "index2013" );
	$NEWMODE = true;

	$body_cls = "";
	if( ($pname == "index") || ($pname == "index1") )
		$body_cls = ' class="body_front"';
	if( $pname == "index2013" )
		$body_cls = ' class="body_new"';

	if( $NEWMODE )
		$body_cls = ' class="body_new"';


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

		/*
		if( $pname == "index1" )
		{
			//echo "<pre>Right".$ban_html_right."</pre>";

			$bans = $ALLBANS;
			$pagetype = 1;
			$placepos = 2;
			if( isset($bans[$pagetype]) )
			{
				echo "!! ".count($bans[$pagetype])." !!";
				//var_dump($bans[$pagetype]);
				if( isset($bans[$pagetype]['places'][$placepos]) )
				{
					echo "!! ".count($bans[$pagetype]['places'][$placepos])." !!";
					var_dump($bans[$pagetype]['places'][$placepos][0]);
					//if( count($bans[$pagetype]['places'][$placepos]) > 0 )
					//{
					//	$banner = $bans[$pagetype]['places'][$placepos][0];
					//}
				}
			}
		}
		*/
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


	if( isset($NEWMODE14) && $NEWMODE14 )
	{
?>
<body class="body14">
<?php
/*
<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=Fhn8r0pAf*d6pIE1KJkksoIthZGRaxThcCxhjemO21PP3Fyqosce2h0iwyIzYR/dXP00JGylA70j1GiStB*2uuCg0FPDJa21YxIpEjuwsEnrcInnr2gt385*NLOjhJ3WlvjT3zmAyqZoLIgPgdsGLLyDq/*7iYSjxfcIcbgOVRw-';</script>
<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=IVuGWvBW1Whn*KSE8JQb3AQhh2CMWhT0gbl*bXmj1bKPFFmQ8ExSTplvmjmGWkgs5aY*4AeMBbipBJp5D6u64efpZiFEJx5TNYfkUlsx/YqaHb*iaPhq96RzKvI3hh/O*1zkPzxEIpSHQikQaYrPIW7fajMZjexvrqAUfhCi6Pc-';</script>
<script type="text/javascript">id='a8f58bc5d08a907f';document.write('<sc'+'ript type="text/javascript" src="'+location.protocol+'//s.targetp.ru/vk.js?rnd='+Math.round(Math.random()*100000)+'"></sc'+'ript>');</script>
*/
?>
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter32347765 = new Ya.Metrika({id:32347765, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/32347765" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->

<div id="page14"><div id="page14in">
	<div id="wrapper">
		<div id="header">
			<div id="logo14">
				<a href="<?=$WWWHOST;?>"><img src="<?=$IMGHOST;?>img/agrotender-logo3.png" alt="Агротендер - продажа аграрной продукции" width="387" height="60" /></a>
			</div>
			<div class="logmenu">
		<?php
			if( $UserId == 0 )
			{
				//echo '<a class="a-cabinet" rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'">Войти</a>';
				//echo '<a href="'.Page_BuildUrl($LangId, "buyerreg", "").'">Регистрация</a>';

				//echo '<div class="hlognew"><noindex><a rel="nofollow" href="'.Page_BuildUrl($LangId,"buyerlog","").'">Войти</a></noindex></div>';
				echo '<div><a id="loginlnk" href="'.Page_BuildUrl($LangId,"buyerlog","").'"><span>Вход для посетителей</span></a></div>';
			}
			else
			{
				//echo '<a class="a-login" rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout"><span>Выйти</span></a>';
				//echo '<a class="a-cabinet" href="'.$WWWHOST.'bcab_cabinet.php">Мой кабинет</a>';
				//echo '<div class="hlogbox">
				//<div class="boxin">';

				echo '<div><noindex>
					'.( false ? '<div class="mycab"><a rel="nofollow" href="'.$WWWHOST.'bcab_cabinet.php">Мой кабинет</a></div>
					<div class="mypers"><a rel="nofollow" href="'.$WWWHOST.'bcab_personal.php">Мои данные</a></div>' :
					'<a rel="nofollow" href="'.$WWWHOST.'bcab_posts.php">Мой кабинет</a><br />' ).'
					<a rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout">Выйти</a>
				</noindex></div>';

				/*echo '<div class="hlogboxnew"><noindex>
					'.( false ? '<div class="mycab"><a rel="nofollow" href="'.$WWWHOST.'bcab_cabinet.php">Мой кабинет</a></div>
					<div class="mypers"><a rel="nofollow" href="'.$WWWHOST.'bcab_personal.php">Мои данные</a></div>' :
					'<div class="mycab"><a rel="nofollow" href="'.$WWWHOST.'bcab_posts.php">Мой кабинет</a></div>' ).'
					<div class="myexit"><a rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout">Выйти</a></div>
				</noindex></div>';
				*/

				//echo '</div>
				//</div>';

				/*
				echo '<div class="ta_center">Здраствуйте <b>'.$UserName.'</b></div>';
				*/
			}
		?>
			</div>
		</div>
		<div class="mpan14">
			<ul class="mainmenu14">
		<?php
			$MAIN_MENU = $menus = Menu_GetLevel( 0, 1, $pname, $LangId );
			for($i=0; $i<(count($menus)-1); $i++)
			{
				//if( $i == 6 )
				//{
				//	echo '</ul>
				//	<ul class="mainmenu line2">';
				//}

				if( $menus[$i]['selected'] )
				{
					echo '<li class="hmm14_li active">
					<div class="hmm14_div">
						<div class="hmmdl14"></div>
						<div class="hmmdm14"><a href="'.$menus[$i]['link'].'">'.$menus[$i]['name'].'</a></div>
						<div class="hmmdr14"></div>
					</div>
					</li>';
				}
				else
				{
					echo '<li class="hmm14_li">
					<div class="hmm14_div">
						<div class="hmmdl14"></div>
						<div class="hmmdm14"><a href="'.$menus[$i]['link'].'">'.$menus[$i]['name'].'</a></div>
						<div class="hmmdr14"></div>
					</div>
					</li>';
				}
			}
		?>
			</ul>
		</div>
		<div id="main">
		<?php
			if( ($pname == "index") || ($pname == "index1") )
			{
				$banc1_html = Banners_Place_Show( 1, 13, $ALLBANS );
				$banc2_html = Banners_Place_Show( 1, 14, $ALLBANS );
				$banc3_html = Banners_Place_Show( 1, 15, $ALLBANS );
				if( ($banc1_html != "") || ($banc2_html != "") || ($banc3_html != "") )
				{
					echo '<div class="rowbcen">
						<div class="rowbit">'.$banc1_html.'</div>
						<div class="rowbit">'.$banc2_html.'</div>
						<div class="rowbit" style="margin-right: 0px;">'.$banc3_html.'</div>
					</div>';
				}
			}
			else if( ($pname == "torgi") || ($pname == "iteminfo") || ($pname == "addtorg" ) )
			{
				$banc1_html = Banners_Place_Show( 2, 13, $ALLBANS );
				$banc2_html = Banners_Place_Show( 2, 14, $ALLBANS );
				$banc3_html = Banners_Place_Show( 2, 15, $ALLBANS );
				if( ($banc1_html != "") || ($banc2_html != "") || ($banc3_html != "") )
				{
					echo '<div class="rowbcen">
						<div class="rowbit">'.$banc1_html.'</div>
						<div class="rowbit">'.$banc2_html.'</div>
						<div class="rowbit" style="margin-right: 0px;">'.$banc3_html.'</div>
					</div>';
				}
			}
			//if( $pname == "board" )
			else
			{
				$banc1_html = Banners_Place_Show( 3, 13, $ALLBANS );
				$banc2_html = Banners_Place_Show( 3, 14, $ALLBANS );
				$banc3_html = Banners_Place_Show( 3, 15, $ALLBANS );
				if( ($banc1_html != "") || ($banc2_html != "") || ($banc3_html != "") )
				{
					echo '<div class="rowbcen">
						<div class="rowbit">'.$banc1_html.'</div>
						<div class="rowbit">'.$banc2_html.'</div>
						<div class="rowbit" style="margin-right: 0px;">'.$banc3_html.'</div>
					</div>';
				}
			}

			if( isset($FULLWSITE) && $FULLWSITE )
			{
				//$FULLWSITE = true;
		?>
			<div class="mainall">
		<?php
			}
			else
			{
		?>
			<div class="bancols">
		<?php
				if( isset($LEFT_CAB_MENU) && ($LEFT_CAB_MENU != "") )
				{
					echo $LEFT_CAB_MENU;
				}

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
		?>
			</div>
			<div class="mainc">
		<?php
			}
	}
	else
	{
?>
<body <?=$body_cls;?>>
<div id="searchdrop" style="visibility: hidden; display: none;">
	<div class="searchdropcont">
		<div id="searchdrop_btn"><a href="javascript:hideTooltip('searchdrop')" class="closebut">X</a></div>
		<div id="searchdrop_body"></div>
</div><!--[if lte IE 6.5]><iframe></iframe><![endif]--></div>
<div id="popuptooltip" style="visibility: hidden; display: none;">
	<div class="tooltipwndcont">
		<div id="popuptooltip_btn"><a href="javascript:hideTooltip('popuptooltip')" class="closebut">X</a></div>
		<div id="popuptooltip_body"></div>
</div><!--[if lte IE 6.5]><iframe></iframe><![endif]--></div>
<?php
		if( $NEWMODE )
		{
?>
	<div id="page">
		<div id="header">
			<div class="wrapper">
				<div class="hleft">
					<div id="logo">
						<a href="<?=$WWWHOST;?>"><img src="<?=$IMGHOST;?>img/agro-logo.png" alt="Агротендер - продажа аграрной продукции" width="241" height="40" /></a>
					</div>
					<?php
						/*
						<div class="hslogan">Продажи аграрной продукции по всей Украине</div>
						*/
					?>
				</div>
				<div class="hmiddle"<?=( $UserId != 0 ? ' style="width: 475px;"' : '');?>>
					<div class="hsearch" style="background: none;">
				<?php
				/*
						<noindex>
						<form action="<?=$WWWHOST;?>search.php">
							<div>
								<input type="text" autocomplete="off" name="searchsw" id="searchsw" style="position: relative;" value="<?=( isset($sw) && ($sw!="") ? $sw : 'Что вы хотите найти?');?>" onclick="(this.value == 'Что вы хотите найти?' ? this.value='' : this.value)" onkeyup="javascript:fillSearchList(this.value, 'searchdrop', 'searchsw');" />
								<input type="submit" name="i_hs_submit" id="i_hs_submit" value="Найти" />
							</div>
						</form>
						</noindex>
				*/
				?>
					</div>
				</div>
				<?php
					if( $UserId == 0 )
					{
						//echo '<a class="a-cabinet" rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'">Войти</a>';
						//echo '<a href="'.Page_BuildUrl($LangId, "buyerreg", "").'">Регистрация</a>';

						echo '<div class="hlognew"><noindex><a rel="nofollow" href="'.Page_BuildUrl($LangId,"buyerlog","").'">Войти</a></noindex></div>';
						/*
						echo '<div class="hlogbox">
						<div class="boxin">
							<div class="loghdr">Вход на сайт</div>
							<noindex>
							<form action="'.Page_BuildUrl($LangId,"buyerlog","").'" method="post">
							<input type="hidden" name="action" value="dologin" />
							<table cellspacing="0" cellpadding="1" border="0">
							<tr>
								<td>Логин: </td>
								<td><input class="lfield" type="text" name="buyerlog" value="Ваша почта" onclick="javascript:this.value=(this.value==\'Ваша почта\' ? \'\' : this.value )" /></td>
							</tr>
							<tr>
								<td>Пароль: </td>
								<td><input class="lfield" type="password" name="buyerpass" value="Ваш пароль" onclick="this.value=\'\'" /></td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: right; padding-right: 0px;">
									<div style="float: left; width: 75px; text-align: left;"><noindex><a rel="nofollow" href="'.Page_BuildUrl($LangId,"buyerreg","").'">Регистрация</a></noindex></div>
									<input type="image" src="'.$IMGHOST.'img/btn-logsm.gif" width="71" height="18" alt="войти" />
								</td>
							</tr>
							</table>
							<div class="logprest"><a href="'.Page_BuildUrl($LangId,"buyerpassrest","").'" rel="nofollow">Забыли пароль?</a></div>
							</form>
							</noindex>
						</div>
						</div>';
						*/
					}
					else
					{
						//echo '<a class="a-login" rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout"><span>Выйти</span></a>';
						//echo '<a class="a-cabinet" href="'.$WWWHOST.'bcab_cabinet.php">Мой кабинет</a>';
						//echo '<div class="hlogbox">
						//<div class="boxin">';
						echo '<div class="hlogboxnew"><noindex>
							'.( false ? '<div class="mycab"><a rel="nofollow" href="'.$WWWHOST.'bcab_cabinet.php">Мой кабинет</a></div>
							<div class="mypers"><a rel="nofollow" href="'.$WWWHOST.'bcab_personal.php">Мои данные</a></div>' :
							'<div class="mycab"><a rel="nofollow" href="'.$WWWHOST.'bcab_posts.php">Мой кабинет</a></div>' ).'
							<div class="myexit"><a rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout">Выйти</a></div>
						</noindex></div>';
						//echo '</div>
						//</div>';

						/*
						echo '<div class="ta_center">Здраствуйте <b>'.$UserName.'</b></div>';
						*/
					}
				?>
				<div class="both"></div>
				<div class="hmm">
					<ul class="mainmenu">
				<?php
					$MAIN_MENU = $menus = Menu_GetLevel( 0, 1, $pname, $LangId );
					for($i=0; $i<(count($menus)-1); $i++)
					{
						//if( $i == 6 )
						//{
						//	echo '</ul>
						//	<ul class="mainmenu line2">';
						//}

						if( $menus[$i]['selected'] )
						{
							echo '<li class="active">
								<div class="hmm_l"></div>
								<div class="hmm_t"><a href="'.$menus[$i]['link'].'" style="color:white;"><span>'.$menus[$i]['name'].'</span></a></div>
								<div class="hmm_r"></div>
							</li>';
						}
						else
						{
							echo '<li>
								<div class="hmm_l"></div>
								<div class="hmm_t"><a href="'.$menus[$i]['link'].'" style="color:white;">'.$menus[$i]['name'].'</a></div>
								<div class="hmm_r"></div>
							</li>';
						}
					}

					//if( $UserId != 0 )
					//{
					//	echo '<li>
					//			<div class="hmm_l"></div>
					//			<div class="hmm_t"><noindex><a rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout">Выйти</a></noindex></div>
					//			<div class="hmm_r"></div>
					//		</li>';
					//}
				?>
					</ul>
				</div>
			</div>
		</div>
		<div id="main">
			<div class="wrapper">
			<?php
				if( ($pname == "index") || ($pname == "index1") )
				{
					$banc1_html = Banners_Place_Show( 1, 13, $ALLBANS );
					$banc2_html = Banners_Place_Show( 1, 14, $ALLBANS );
					$banc3_html = Banners_Place_Show( 1, 15, $ALLBANS );
					if( ($banc1_html != "") || ($banc2_html != "") || ($banc3_html != "") )
					{
						echo '<div class="rowbcen">
							<div class="rowbit">'.$banc1_html.'</div>
							<div class="rowbit">'.$banc2_html.'</div>
							<div class="rowbit" style="margin-right: 0px;">'.$banc3_html.'</div>
						</div>';
					}
				}
				else if( ($pname == "torgi") || ($pname == "iteminfo") || ($pname == "addtorg" ) )
				{
					$banc1_html = Banners_Place_Show( 2, 13, $ALLBANS );
					$banc2_html = Banners_Place_Show( 2, 14, $ALLBANS );
					$banc3_html = Banners_Place_Show( 2, 15, $ALLBANS );
					if( ($banc1_html != "") || ($banc2_html != "") || ($banc3_html != "") )
					{
						echo '<div class="rowbcen">
							<div class="rowbit">'.$banc1_html.'</div>
							<div class="rowbit">'.$banc2_html.'</div>
							<div class="rowbit" style="margin-right: 0px;">'.$banc3_html.'</div>
						</div>';
					}
				}
				//if( $pname == "board" )
				else
				{
					$banc1_html = Banners_Place_Show( 3, 13, $ALLBANS );
					$banc2_html = Banners_Place_Show( 3, 14, $ALLBANS );
					$banc3_html = Banners_Place_Show( 3, 15, $ALLBANS );
					if( ($banc1_html != "") || ($banc2_html != "") || ($banc3_html != "") )
					{
						echo '<div class="rowbcen">
							<div class="rowbit">'.$banc1_html.'</div>
							<div class="rowbit">'.$banc2_html.'</div>
							<div class="rowbit" style="margin-right: 0px;">'.$banc3_html.'</div>
						</div>';
					}
				}
				/*
				else
				{
					$banc1_html = Banners_Place_Show( 0, 13, $ALLBANS );
					$banc2_html = Banners_Place_Show( 0, 14, $ALLBANS );
					$banc3_html = Banners_Place_Show( 0, 15, $ALLBANS );
					if( ($banc1_html != "") || ($banc2_html != "") || ($banc3_html != "") )
					{
						echo '<div class="rowbcen">
							<div class="rowbit">'.$banc1_html.'</div>
							<div class="rowbit">'.$banc2_html.'</div>
							<div class="rowbit" style="margin-right: 0px;">'.$banc3_html.'</div>
						</div>';
					}
				}
				*/

				//if( ($pname != "news1") && ($pname != "news") )
				if( isset($FULLWSITE) && $FULLWSITE )
				{
					//$FULLWSITE = true;
			?>
				<div class="mainall">
			<?php
				}
				else
				{
			?>
				<div class="bancols">
			<?php
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
			?>
				</div>
				<div class="mainc">
			<?php
				/*
					<div class="banner">
						<a href="#"><img src="img/ban-820x95.gif" alt="" /></a>
					</div>
				*/
				}
			?>
<?php
		}
		else
		{
?>
	<div id="page"<?=($ban_left_show || $ban_right_show ? ' style="width: 1300px"' : '' );?>>
		<div id="header">
			<div class="wrapper">
				<div class="hleft">
					<div id="logo">
						<a href="<?=$WWWHOST;?>"><img src="<?=$IMGHOST;?>img/logo.gif" alt="Агротендер - продажа аграрной продукции" width="288" height="44" /></a>
					</div>
					<div class="hslogan">Продажи аграрной продукции по всей Украине</div>
				</div>
				<div class="hmiddle"<?=( $UserId != 0 ? ' style="width: 475px;"' : '');?>>
					<div class="hmainmenu">
						<ul class="mainmenu">
					<?php
						$MAIN_MENU = $menus = Menu_GetLevel( 0, 1, $pname, $LangId );
						for($i=0; $i<count($menus); $i++)
						{
							if( $i == 6 )
							{
								echo '</ul>
								<ul class="mainmenu line2">';
							}

							if( $menus[$i]['selected'] )
							{
								echo '<li class="active">
									<div class="hmm_l"></div>
									<div class="hmm_t"><a href="'.$menus[$i]['link'].'">'.$menus[$i]['name'].'</a></div>
									<div class="hmm_r"></div>
								</li>';
							}
							else
							{
								echo '<li>
									<div class="hmm_l"></div>
									<div class="hmm_t"><a href="'.$menus[$i]['link'].'">'.$menus[$i]['name'].'</a></div>
									<div class="hmm_r"></div>
								</li>';
							}
						}

						//if( $UserId != 0 )
						//{
						//	echo '<li>
						//			<div class="hmm_l"></div>
						//			<div class="hmm_t"><noindex><a rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout">Выйти</a></noindex></div>
						//			<div class="hmm_r"></div>
						//		</li>';
						//}
					?>
						</ul>
					</div>
					<div class="hsearch">
						<noindex>
						<form action="<?=$WWWHOST;?>search.php">
							<div>
								<input type="text" autocomplete="off" name="searchsw" id="searchsw" style="position: relative;" value="<?=( isset($sw) && ($sw!="") ? $sw : 'Что вы хотите найти?');?>" onclick="(this.value == 'Что вы хотите найти?' ? this.value='' : this.value)" onkeyup="javascript:fillSearchList(this.value, 'searchdrop', 'searchsw');" />
								<input type="submit" name="i_hs_submit" id="i_hs_submit" value="Найти" />
							</div>
						</form>
						</noindex>
					</div>
				</div>
				<?php
					if( $UserId == 0 )
					{
						//echo '<a class="a-cabinet" rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'">Войти</a>';
						//echo '<a href="'.Page_BuildUrl($LangId, "buyerreg", "").'">Регистрация</a>';

						echo '<div class="hlogbox">
						<div class="boxin">
							<div class="loghdr">Вход на сайт</div>
							<noindex>
							<form action="'.Page_BuildUrl($LangId,"buyerlog","").'" method="post">
							<input type="hidden" name="action" value="dologin" />
							<table cellspacing="0" cellpadding="1" border="0">
							<tr>
								<td>Логин: </td>
								<td><input class="lfield" type="text" name="buyerlog" value="Ваша почта" onclick="javascript:this.value=(this.value==\'Ваша почта\' ? \'\' : this.value )" /></td>
							</tr>
							<tr>
								<td>Пароль: </td>
								<td><input class="lfield" type="password" name="buyerpass" value="Ваш пароль" onclick="this.value=\'\'" /></td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: right; padding-right: 0px;">
									<div style="float: left; width: 75px; text-align: left;"><noindex><a rel="nofollow" href="'.Page_BuildUrl($LangId,"buyerreg","").'">Регистрация</a></noindex></div>
									<input type="image" src="'.$IMGHOST.'img/btn-logsm.gif" width="71" height="18" alt="войти" />
								</td>
							</tr>
							</table>
							</form>
							</noindex>
						</div>
						</div>';
					}
					else
					{
						//echo '<a class="a-login" rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout"><span>Выйти</span></a>';
						//echo '<a class="a-cabinet" href="'.$WWWHOST.'bcab_cabinet.php">Мой кабинет</a>';
						echo '<div class="hlogbox">
						<div class="boxin"><noindex>
							<div class="mycab"><a rel="nofollow" href="'.$WWWHOST.'bcab_cabinet.php">Мой кабинет</a></div>
							<div class="mypers"><a rel="nofollow" href="'.$WWWHOST.'bcab_personal.php">Мои данные</a></div>
							<div class="myexit"><a rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout">Выйти</a></div>
						</noindex></div>
						</div>';

						/*
						echo '<div class="ta_center">Здраствуйте <b>'.$UserName.'</b></div>';
						*/
					}
				?>
				<div class="both"></div>
			</div>
		</div>
		<div id="main">
<?php
			if( $ban_left_show || $ban_right_show )
			{
				echo '<div class="wrapperwban">
					<div class="wcolleft">';

				if( $ban_html_left != "" )
					echo '<div class="leftbanner">'.$ban_html_left.'</div>';

				if( $ban_html_left2 != "" )
					echo '<div class="leftbanner">'.$ban_html_left2.'</div>';

				if( $ban_html_left3 != "" )
					echo '<div class="leftbanner">'.$ban_html_left3.'</div>';

				if( $ban_html_left4 != "" )
					echo '<div class="leftbanner">'.$ban_html_left4.'</div>';

				if( $ban_html_left5 != "" )
					echo '<div class="leftbanner">'.$ban_html_left5.'</div>';

				echo '</div>
					<div class="wcolright">';

				if( $ban_html_right != "" )
					echo '<div class="rightbanner">'.$ban_html_right.'</div>';

				if( $ban_html_right2 != "" )
					echo '<div class="rightbanner">'.$ban_html_right2.'</div>';

				if( $ban_html_right3 != "" )
					echo '<div class="rightbanner">'.$ban_html_right3.'</div>';

				if( $ban_html_right4 != "" )
					echo '<div class="rightbanner">'.$ban_html_right4.'</div>';

				if( $ban_html_right5 != "" )
					echo '<div class="rightbanner">'.$ban_html_right5.'</div>';

				echo '</div>';
			}
?>
			<div class="wrapper">
<?php
		}
	}




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
