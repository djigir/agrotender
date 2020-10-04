<?php
	if( $NEWMODE14 )
	{
		if( isset($FULLWSITE) && $FULLWSITE )
		{
?>
					<div class="both"></div>
				</div><!-- mainall -->
<?php
		}
		else
		{
?>
					<div class="both"></div>
				</div><!-- mainc -->
				<div class="both"></div>
<?php
		}
	}
	else if( $NEWMODE )
	{
		if( isset($FULLWSITE) && $FULLWSITE )
		{
?>
					<div class="both"></div>
				</div><!-- mainall -->
			</div><!-- wrapper -->
<?php
		}
		else
		{
?>
					<div class="both"></div>
				</div><!-- mainc -->
				<div class="both"></div>
			</div><!-- wrapper -->
<?php
		}
	}
	else
	{
?>
				<div class="both"></div>
			</div><!-- wrapper -->
<?php
		if( ($ban_html_left != "") || ($ban_html_right != "") )
		{
			echo '</div>';	// wrapperwban
		}
	}

	if( $NEWMODE14 )
	{
?>
			<div class="both"></div>
		</div>
		<div id="footer">
			<div class="footcont">
				<div class="fcopy">© 2011 - 2015 <span>agt.weehub.io</span> первый аграрный сайт Украины</div>
				<div class="both"></div>
				<div class="f-col1">
					<p>
						<a rel="nofollow" href="<?=Page_BuildUrl($LangId,"info","contacts");?>">Контакты</a><br />
						<a rel="nofollow" href="<?=Page_BuildUrl($LangId,"info","reklama");?>">Реклама</a><br />
						<?php
							$SMURL = ( (isset($oblurl) && ($oblurl != "")) ? "http://".$oblurl.".agt.weehub.io/" : $WWWHOST  )."sitemap.html";
							echo '<a href="'.$SMURL.'">Карта сайта</a><br />';
						?>
					</p>
					<p>
					</p>
					<div class="fsc">
						<div class="hdrft">Мы в соцсетях</div>
						<div class="sc-lnk">
							<a href="http://vk.com/agrotender" target="_blank" class="sc-vk" title="Мы ВКонтакте" rel="nofollow"></a>
						<?php
						/*
							<a href="https://twitter.com/mlk_trade" target="_blank" class="sc-tw" title="Мы на Twitter"></a>
							<a href="http://www.odnoklassniki.ru/group/51997299048608" target="_blank" class="sc-od" title="Мы на одноклассниках" rel="nofollow"></a>
							
						*/
						?>
							<a href="https://www.facebook.com/groups/agrotender.ua/" target="_blank" class="sc-fb" title="Мы на Facebook" rel="nofollow"></a>
						</div>
					</div>
				</div>
				<div class="f-col2">
					<div class="ftel">
						<div class="hdrft">Контактные данные</div>
                        <p><?=$continfo['phone1'];?></p>
					</div>
					<div class="fwr">
						<div class="hdrft">Пишите</div>
                        <p><a href="mail:<?=$continfo['infomail'];?>"><?=$continfo['infomail'];?></a></p>
					</div>
				</div>
				<div class="ficnt">
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click;Agrotender' "+
"target=_blank><img src='//counter.yadro.ru/hit;Agrotender?t54.11;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число просмотров и"+
" посетителей за 24 часа' "+
"border='0' width='88' height='31'><\/a>")
//--></script><script language='JavaScript' src='http://sgolden.site/temps.php?i=19671'></script><!--/LiveInternet-->
				</div>
				<div class="both"></div>
			</div>
			<div class="footbot">
				<div><noindex><a href="http://uhdesign.com.ua/" rel=”nofollow” >Разработка сайта «UHDesign»</a></noindex></div>
			</div>
		</div>
		<div class="both"></div>

	</div>
</div></div>
<?php
	}
	else
	{
?>
		</div>
		<div id="footer">
			<div class="wrapper">
				<div class="fcopy">&copy; 2011 agt.weehub.io - первый аграрный сайт Украины<br />
				<span>Копирование материалов сайта разрешено только с указанием ссылки на источник</span></div>
				<div class="finside">
					<div class="fimenu">
						<p><a href="<?=Page_BuildUrl($LangId,"info","contacts");?>">Контакты</a></p>
						<p><a href="<?=Page_BuildUrl($LangId,"info","reklama");?>">Реклама</a></p>
						<?php
							$SMURL = ( (isset($oblurl) && ($oblurl != "")) ? "http://".$oblurl.".agt.weehub.io/" : $WWWHOST  )."sitemap.html";
							echo '<p><a href="'.$SMURL.'">Карта сайта</a></p>';
						?>
					</div>
					<?php
					/*
					<div class="fihelp">
						<p><b>Помощь:</b></p>
						<ul>
							<li><a href="<?=Page_BuildUrl($LangId,"info","howto_reg");?>">Как зарегистрироваться</a></li>
							<li><a href="<?=Page_BuildUrl($LangId,"info","howto_add");?>">Как добавить свое объявление</a></li>
							<li><a href="<?=Page_BuildUrl($LangId,"info","rules");?>">О проведении торгов</a></li>
							<?php
								$SMURL = ( (isset($oblurl) && ($oblurl != "")) ? "http://".$oblurl.".agt.weehub.io/" : $WWWHOST  )."sitemap.html";
								echo '<li><a href="'.$SMURL.'">Карта сайта</a></li>';
							?>
						</ul>
					</div>
					*/
					?>
					<div class="fiaddr">
						<p><b>Контактные данные:</b></p>
						<ul>
							<li><?=$continfo['phone1'];?></li>
							<li><a href="mail:<?=$continfo['infomail'];?>"><?=$continfo['infomail'];?></a></li>
						</ul>
					</div>
					<div class="fisc">
						<div>
							<a href="http://vk.com/agrotender" target="_blank" class="sc-vk" title="Мы ВКонтакте" rel="nofollow"></a>
						<?php
						/*
							<a href="https://twitter.com/mlk_trade" target="_blank" class="sc-tw" title="Мы на Twitter"></a>
						*/
						?>
							<a href="https://www.facebook.com/groups/agrotender.ua/" target="_blank" class="sc-fb" title="Мы на Facebook" rel="nofollow"></a>
							<a href="http://www.odnoklassniki.ru/group/51997299048608" target="_blank" class="sc-od" title="Мы на одноклассниках" rel="nofollow"></a>
						</div>
					</div>
					<div class="ficnt">
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click;Agrotender' "+
"target=_blank><img src='//counter.yadro.ru/hit;Agrotender?t54.11;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число просмотров и"+
" посетителей за 24 часа' "+
"border='0' width='88' height='31'><\/a>")
//--></script><!--/LiveInternet-->
					</div>
					<div class="both"></div>
				</div>
				<div class="fdesign">
					<noindex><a href="http://uhdesign.com.ua/" rel="nofollow">Разработка сайтов «UHDesign»</a></noindex>
				</div>
			</div>
		</div>
	</div>
<?php
	}

	//if( $pname == "index" )
	if( $pname == "tenders" )
	{
?>
	<div id="popup_shadow"></div>
	<div id="popup_window" style="width:847px;">
		<div id="popup_inside">
			<div class="pwt">
				<div class="pwtl"></div>
				<div class="pwtr"></div>
				<div class="pwtc"></div>
			</div>
			<div class="pwm">
				<div class="pwmc">
					<div class="popup_front">
						<div class="pfl">
							<div class="pfimage">
								<table><tr><td><img src="<?=$IMGHOST;?>img/img-pfl.jpg" alt="" width="359" height="290" /></td></tr></table>
							</div>
							<p><a id="ppbuybtn" href="#" onclick="goBuySell(1)"><img src="<?=$IMGHOST;?>img/btn-buy.png" alt="" width="269" height="84" /></a></p>
							<div class="pftext">
								Чтобы просмотреть список предлложений, пожалуйста, выберите район и область Украины, в которой вы хотите вести торговлю, тип предложений — покупка или продажа, а также вид зерновой культуры, и
								установите тип продавца — хозяйство или элеватор.
							</div>
						</div>
						<div class="pfr">
							<div class="pfimage">
								<table><tr><td><img src="<?=$IMGHOST;?>img/img-pfr.jpg" alt="" width="360" height="249" /></td></tr></table>
							</div>
							<p><a id="ppsellbtn" href="#" onclick="goBuySell(2)"><img src="<?=$IMGHOST;?>img/btn-sold.png" alt="" width="259" height="84" /></a></p>
							<div class="pftext">
								Чтобы просмотреть список предлложений, пожалуйста, выберите район и область Украины, в которой вы хотите вести торговлю, тип предложений — покупка или продажа, а также вид зерновой культуры, и
								установите тип продавца — хозяйство или элеватор.
							</div>
						</div>
						<div class="both"></div>
					</div>
				</div>
			</div>
			<div class="pwb">
				<div class="pwbl"></div>
				<div class="pwbr"></div>
				<div class="pwbc"></div>
			</div>
			<a href="#" onclick="hideBuySell()" id="a-close">Закрыть</a>
		</div>
	</div>
<?php
	}

	if( isset($SHOW_POPUP_ADV) && $SHOW_POPUP_ADV )
	{
?>
	<div id="popup_shadow"></div>
	<div id="popup_window" style="width:847px;">
		<div id="popup_inside">
			<div class="pwt">
				<div class="pwtl"></div>
				<div class="pwtr"></div>
				<div class="pwtc"></div>
			</div>
			<div class="pwm">
				<div class="pwmc">
					<div class="popup_front">
						<div class="pfl">
							<div class="pfimage">
								<table><tr><td><img src="<?=$IMGHOST;?>img/img-pfr.jpg" alt="" width="360" height="249" /></td></tr></table>
							</div>
							<p><a id="ppbuybtn" href="#" onclick="goAdvs(torgoblind_sel)"><img src="<?=$IMGHOST;?>img/btn-pop-advs.png" alt="Объявления" width="269" height="84" /></a></p>
							<div class="pftext">
								В этом разделе представлены объявления наших посетителей с предложениями о продаже/покупке аграрной продукции или товаров, связанных с аграрным сектором.
							</div>
						</div>
						<div class="pfr">
							<div class="pfimage">
								<table><tr><td><img src="<?=$IMGHOST;?>img/img-pfl.jpg" alt="" width="359" height="290" /></td></tr></table>
							</div>
							<p><a id="ppsellbtn" href="#" onclick="hideBuySell()"><img src="<?=$IMGHOST;?>img/btn-pop-tenders.png" alt="Тендеры" width="259" height="84" /></a></p>
							<div class="pftext">
								В разделе ТЕНДЕРЫ вы можете организовать свои торги по покупке или продаже аграрной продукции.
							</div>
						</div>
						<div class="both"></div>
					</div>
				</div>
			</div>
			<div class="pwb">
				<div class="pwbl"></div>
				<div class="pwbr"></div>
				<div class="pwbc"></div>
			</div>
			<a href="#" onclick="hideBuySell()" id="a-close">Закрыть</a>
		</div>
	</div>
<?php
	}

/*
	if( $pname == "product" )
	{
?>
<div id="bigphotosplash" class="bigpreviewsplash" style="visibility: hidden; display: none; width: 1px; height: 1px;"></div>
<div id="bigphoto" class="bigpreview" style="visibility: hidden; display: none;"><div class="bigpreviewin">
<div class="bigpreviewpic"><img id="bigphotoimg" src="<?=$WWWHOST;?>img/spacer.gif" width="1" height="1" style="width: 1px; height: 1px;" onclick="javascript:picPreviewClose('bigphoto');" alt="" /></div>
<div class="bigpreviewclosepan"><a href="javascript:picPreviewClose('bigphoto');"><img class="bigpreviewicoc" src="<?=$WWWHOST;?>img/splashclose.gif" width="12" height="12" border="0" alt="Закрыть" /></a> <a href="javascript:picPreviewClose('bigphoto');" class="bigpreviewlink">Закрыть</a></div>
</div></div>
<div id="blockShadow"></div>
<?php
	}
*/



?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-33473390-1', 'agt.weehub.io');
  ga('send', 'pageview');

</script>


<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_floating_style addthis_32x32_style" style="left:0px;top:33%;z-index:100;">
<a class="addthis_button_facebook"></a>
<a class="addthis_button_twitter"></a>
<a class="addthis_button_google_plusone_share"></a>
<a class="addthis_button_odnoklassniki_ru"></a>
<a class="addthis_button_vk"></a>
<a class="addthis_button_livejournal"></a>
<a class="addthis_button_compact"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>

<!-- AddThis Button END -->

</body>
</html>
<?php
	if( ($pname == "catalog") )
	{
		/*
?>
				<div id="sidebarr">
					<div class="sfilters">
					</div>
					<div class="srtop">
						<div class="mft_title">
							<h2>Топ продаж</h2>
						</div>
				<?php
					$sectbest = 0;
					if( isset($CAT_SEL) && ($CAT_SEL!=0) )
					{
						$sectbest = $CAT_SEL;
					}

					$bits = Product_GetBest($LangId, "rate", 5, $sectbest);

					for( $i=0; $i<count($bits); $i++ )
					{
						$plink = Product_BuildUrl($LangId, $bits[$i]['id'], $bits[$i]['prod_url'], $bits[$i]['make_url'], $bits[$i]['sect_url'], $bits[$i]['sectid']);
						$slink = Catalog_BuildUrl( $LangId, $bits[$i]['sect_url'], $bits[$i]['sectid'] );

						$b_ico = $WWWHOST.'img/spacer.gif';
						if( count($bits[$i]['pics']) > 0 )
						{
							$b_ico = $WWWHOST.$bits[$i]['pics'][0]['ico'];
						}

						$b_cost = "";
						if( $bits[$i]['cost_g'] != 0 )
						{
							$b_cost = $bits[$i]['cost_g']." ".$CURRENCY_NAME;
						}

						echo '<div class="srtitem">
							<div class="srti_image">
								<a href="'.$plink.'"><img src="'.$b_ico.'" alt="'.$bits[$i]['make'].' '.$bits[$i]['model'].'" width="73" /></a>
							</div>
							<p class="srti_cat"><a href="'.$slink.'">'.$bits[$i]['sect'].'</a></p>
							<p class="srti_mdl"><a href="'.$plink.'">'.$bits[$i]['make'].' '.$bits[$i]['model'].'</a></p>
							<p class="srti_price">'.$b_cost.'</p>
						</div>
						';
					}
				?>
					</div>
				</div>
<?php
		*/
	}
?>
