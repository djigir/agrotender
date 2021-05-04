<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////	

	$IS_TEST_MODE = false;

	//------------------- Extract contacts from database -----------------------
	$continfo = Contacts_Get( $LangId );

	//--------------------- Fill page information array ------------------------
	if( empty( $page['id'] ) )
	{
		$page = Array();
		$page['id'] = 0;
		$page['title'] = "";
		$page['header'] = "";
		$page['content'] = "";

		$page['seo_title'] = "";
		$page['seo_keywords'] = "";
		$page['seo_descr'] = "";

		$page00 = Page_GetInfo( $LangId, $pname );
		if( isset($page00['id']) && ($page00['id'] != 0) )
		{
			$page = $page00;
		}
	}

	//--------------------- GET SLIDES FOR SPLASH ------------------------------
	$slides = Sildes_Get($LangId);

	//------------------------ GET TEXT BLOCKS ---------------------------------
	$txt_res = Resources_Get($LangId);

	//------------------------- GET BANNERS ------------------------------------
	$ALLBANS = Banners_Place_Rotate( $LangId );

	//--------------------------------------------------------------------------
	// Now we should separate the country code and city code from telephone number
	

	//////////////////////////////////////////////////////////////////////////// width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=0
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="windows-1251">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<link href="<?=$WWWHOST;?>favicon.ico" type="image/x-icon" rel="shortcut icon">
	<title><?=( isset($PAGE_TITLE) ? $PAGE_TITLE : $page['seo_title']);?></title>
	<meta name="keywords" content="<?=( isset($PAGE_KEYWORD)  ? str_replace("\"", "", $PAGE_KEYWORD) : str_replace("\"", "", $page['seo_keywords']));?>" />
	<meta name="description" content="<?=( isset($PAGE_DESCR) ? str_replace("\"", "", $PAGE_DESCR) : str_replace("\"", "", $page['seo_descr']));?>" />
<?php
	if( (isset($IS_TEST_MODE) && $IS_TEST_MODE) || (isset($METANOINDEX) && $METANOINDEX) )
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
*/
	if( isset($CANONICAL_PAGE) && ($CANONICAL_PAGE != "") )
	{
?>
	<link rel="canonical" href="<?=$CANONICAL_PAGE;?>" />
<?php
	}	
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/all_new.css" />
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
<?php
	if (( $pname == "traders_analitic" ) || ( $pname == "traders_analitic_tst" ))
	{
		/*
?>
	<link rel="stylesheet" href="<?=$WWWHOST;?>js/datepicker/css/datepicker.css" type="text/css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>js/datepicker/js/datepicker_0.js"></script>
<?php
		*/
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/jquidtpick/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/jquidtpick/jquery-ui.theme.css">
<?php
	}
?>
	
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/slides.min.jquery.js"></script>
	
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/jquery.jcarousel.min.js"></script>
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/jcarousel-init.js"></script>

		
	<script type="text/javascript" src="<?=$WWWHOST;?>js/main_1.js"></script>
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/main15.js"></script>
<?php	
	if( $pname == "addtorg" )
	{
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>calendar/calendar.css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>calendar/calendar.js"></script>
<?php
	}

	if( ($pname == "product") || ($pname == "board") )
	{
?>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>js5/fancybox/jquery.fancybox.css" />
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/fancybox/jquery.fancybox.pack.js"></script>
		
	<?php
	/*
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/fupld/fine-uploader.core.min.js"></script>	
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/fupld/jquery.fine-uploader.min.js"></script>		
	*/
	?>	
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/fupld/fine-uploader.min.js"></script>	
	<script type="text/template" id="qq-template">
		<div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Перетащите фото сюда">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Загрузить фото</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Загрузка новой фотографии...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>
	
	<!--<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/fupld/fine-uploader.css" />-->
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/fupld/fine-uploader-gallery.css" />
	<!--<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/fupld/fine-uploader-new.css" />-->
<?php
	/*
	<script type="text/javascript" src="<?=$WWWHOST;?>/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?=$WWWHOST;?>/js/swfupld/swfupload.queue.js"></script>
<script type="text/javascript" src="<?=$WWWHOST;?>/js/swfupld/fileprogress.js"></script>
<script type="text/javascript" src="<?=$WWWHOST;?>/js/swfupld/handlers.js"></script>
	*/
?>
<?php	
	}
?>
<script type="text/javascript">
	var reqajxhost = '<?=$WWWHOST;?>';	
<?php
	if( ($pname == "product") || ($pname == "board") )
	{
		$ses_id = session_id();
		/*
?>
		var swfu;

		window.onload = function() {
			var settings = {
				//flash_url : "../swfupload/swfupload.swf",
				flash_url : "/swfupload/swfupload.swf",
				upload_url: "/upload.php",
				file_post_name : "Filedataoc24",
				post_params: {"PHPSESSID" : "<?=$ses_id;?>"},
				file_size_limit : "100 MB",
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : 100,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel",
					sesId : "<?=$ses_id;?>"
				},
				debug: false,

				// Button settings
				button_image_url: "/img/btn-load-new.png",
				button_width: "110",
				button_height: "22",
				button_placeholder_id: "spanButtonPlaceHolder",
				//button_text: '<span class="theFont">Загрузить</span>',
				//button_text_style: ".theFont { font-size: 16; }",
				//button_text_left_padding: 12,
				//button_text_top_padding: 3,

				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };
<?php
		*/
	}
?>

	var debug1 = '', mt, mStatus, mt2;
	$(document).ready(function(){
		$("#lnk-toggle-menu").bind("click", function(){
			var pp = $(this).offset();
			$(this).toggleClass("mpan-btn-open");
			$(".mpan-norm").css("top", Math.round(pp.top + 48)+"px");
			( $(".mpan-norm").css("display") == "block" ? $(".mpan-norm").hide() : $(".mpan-norm").show() );
			$(".mpan-norm").toggleClass("mpan-norm-open");
			return false
		});
		
		//$("#ilenta-list").jcarousel({ scroll:1 }).jcarouselAutoscroll({autostart: true, interval: 3000, target: '+=3'});
		$("#ilenta-list").jcarousel({ scroll:3 });
		<?php
		if( $pname == "board" )
		{
		?>
		$("#aloadswitch").bind("click", function(e){
			$(".iinp-files-new, .iinp-files-new2").hide();
			$(".iinp-files-simple").show();
			$(this).parent().hide();
			e.preventDefault();
		});
		
		$("#targ-list").jcarousel({ scroll:2 });
		
		$("#prod-pic-list").jcarousel({ scroll:1 });
		<?php
		}
		?>

		initJCarouselControls();
		
		<?php
		if( ($pname == "product") || ($pname == "board") )
		{
		?>
		if( $(window).width() > 800 )
		{
			$("#menu").menu();
		}
		else
		{
			$(".l-cat-list #menu>li>span").bind("click", function(e){
				//$(this).find("ul").eq(0).toggleClass("menu-li0-open");
				$(this).parent().toggleClass("menu-li0-open");
				e.preventDefault();
			});
			
			$(".l-cat-list #menu>li>ul>li>a").bind("click", function(e){
				//$(this).find("ul").eq(0).toggleClass("menu-li0-open");
				$(this).parent().toggleClass("menu-li1-open");
				e.preventDefault();
			});
		}
		
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
		
		$("a[rel=photo_group2]").fancybox({
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
		if( $(window).width() > 800 )
		{
			$("#menu").menu();
		}
		else
		{
			$(".l-cat-list #menu>li>span").bind("click", function(e){
				//$(this).find("ul").eq(0).toggleClass("menu-li0-open");
				$(this).parent().toggleClass("menu-li0-open");
				e.preventDefault();
			});
			
			//$(".l-cat-list #menu>li>ul>li>a").bind("click", function(e){
			//	$(this).parent().toggleClass("menu-li1-open");
			//	e.preventDefault();
			//});
		}
		<?php
		}

		if( ($pname == "tradersnew") || ($pname == "traders") || ($pname == "traders_analitic") || ($pname == "traders_analitic_tst") )
		{
		?>
		$("#menu").menu();
		$("#accordion").accordion({heightStyle: "content"});
		
		$(".flt-opts input[type=checkbox]").bind("click", function(){			
			//if( $(this).is(":checked") )
			location.href= $(this).parent().find("a").attr("href");			
		});
		
		<?php
		}

		if( ($pname == "board") || ($pname == "board2013") || ($pname == "kompanii") )
		{		
			//
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
<body class="dtarea">
<?php
	if(isset($IS_TEST_MODE) && $IS_TEST_MODE)
	{
		//
	}
	else
	{
/*
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
*/
	}
?>
	<header>	
		<div class="wrapper">
			<div id="logo">
				<a href="<?=$WWWHOST;?>"><img src="<?=$IMGHOST;?>img5/agrotender-logo.png" alt="Агротендер - продажа аграрной продукции" /></a>
			</div>
			
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
							<a href="'.$menus[$i]['link'].'">'.$menus[$i]['name'].'</a>										
					</li>';
				}
				else
				{
					echo '<li class="hmm_li" id="m'.($i+1).'">
							<a href="'.$menus[$i]['link'].'">'.$menus[$i]['name'].'</a>
					</li>';
				}
			}

		?>
				</ul>			
			</div>
			
			<div class="header-right">
				<div class="hbtns">
				<?php

					if( $UserId > 0 )
					{
						$complist = Comp_Items( $LangId, 0, 0, 0, 0, -1, 20, $UserId, true );
						$query = "SELECT trader_price_avail AS Buyer, trader_price_sell_avail AS Seller FROM $TABLE_COMPANY_ITEMS WHERE author_id = $UserId";
						$Res = mysqli_query($upd_link_db,$query);
						$BuySell = mysqli_fetch_array($Res);

						$Buyer = $BuySell['Buyer'];
						$Seller = $BuySell['Seller'];
					}
					echo '<a '.( $UserId != 0 ? ' href="#" id="msngrreq"' : ' id="logotherlnk1" href="'.Page_BuildUrl($LangId, "buyerlog", "").'" ' ).' class="btn btn-light btn-mes">Продать трейдеру</a>';
					echo '<a href="'.Page_BuildUrl($LangId, "board", (( ($UserId>0) && (count($complist)>0) ) ? "addcpost" : "addpost")).'" class="btn btn-light btn-iadv"><span>Объявление</span></a>';
				
					if( $UserId == 0 )
					{
						echo '<a href="'.Page_BuildUrl($LangId,"buyerlog","").'" class="btn btn-dark btn-ilog"><span>Вход</span></a>';
						//echo '<div><a id="loginlnk" href="'.Page_BuildUrl($LangId,"buyerlog","").'"><span>Вход</span></a></div>';
					}
					else
					{
						
						$COMP_ID = Comp_ItemByUser($LangId, $UserId);
						$msngr_new_num = 0;
						if( $COMP_ID != 0 )							
							$msngr_new_num = Msngr_ReqNum($LangId, $COMP_ID, 0, 0 );	// Show only new
						
						/*
						$yand = "yaCounter117048.reachGoal('MsngrCircle')";
						echo '<noindex><a rel="nofollow" href="'.$WWWHOST.'bcab_posts.php'.(( ($UserId>0) && (count($complist)>0) ) ? "?viewcomp=1" : "").'" class="btn btn-dark btn-ilog"><span>Мой кабинет</span></a>'.($msngr_new_num > 0 ? ' <a class="btn-ilog" style="padding:0" href="'.$WWWHOST.'bcab_msngr.php?viewdir=1" onclick="'.$yand.'"><b title = "Просмотрите новые 
поступившие предложения 
сырья в разделе Мессенджер">'.$msngr_new_num.'</b></a>' : '').'
						<a rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout" class="btn btn-dark btn-ilog"><span>Выйти</span></a> </noindex>';
						*/
						
						echo '<noindex>
						<div class="drop_menu_holder">'.( $msngr_new_num > 0 ? '<span id="blink" class="drop_menu-bubble0">'.$msngr_new_num.'</span>' : '' ).'
						<span>Мой кабинет</span>
						<div class="drop_menu">
						<ul>
							<li><a href="'.$WWWHOST.'bcab_posts.php'.(( ($UserId>0) && (count($complist)>0) ) ? "?viewcomp=1" : "").'">Объявления</a></li>'. ( ($Buyer) ? ' 
							<li><a href="'.$WWWHOST.'bcab_prices.php">Таблица закупок</a></li>' : "" ).
							( ($Seller) ? ' 
							<li><a href="'.$WWWHOST.'bcab_prices.php?acttype=1">Таблица продаж</a></li>' : "" ).' 
							<li><a href="'.$WWWHOST.'bcab_msngr.php'.( ($Buyer) ? '?viewdir=1"' : '"').'>Мессенджер </a>'.( $msngr_new_num > 0 ? '<span class="drop_menu-bubble">'.$msngr_new_num.'</span>' : '' ).'</li> 
							<li><a rel="nofollow" href="'.Page_BuildUrl($LangId, "buyerlog", "").'?action=dologout">Выход</a></li> 
						</ul>
						</div>
						</div>
						</noindex>';
																		
						//echo '<div class="ta_center">Здраствуйте <b>'.$UserName.'</b></div>';											
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
				
	
	<div class="wrapper fixed-top">
<?php
	// Banners_Place_Show( page_type, place, banners )
	//		page_type:
	//			1 - index
	//			2 - торги по регионам
	//			3 - all pages
	
	if( $ban_top_show )
	{
		echo '<section id="toprekl">		
			'.$banc1_html.'

			<div class="both"></div>
		</section>';
	}
	
	
	
	if( $pname != "index" )
	{
		//$news = News_Items($LangId, $NEWS_ALL, "anons", 130, 0, 12);
		
		$seltype_id = Array($LENTA_TNEWCOST, $LENTA_TNEWCOSTSELL, $LENTA_TNEWNEWS);
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

	/////////////////////////////////////////////////////////////////

?>