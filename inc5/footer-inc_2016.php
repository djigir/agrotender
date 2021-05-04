<?php
	//
	$pnamearr = Array("faq", "info", "sitemap", "news", "index", "buyerlog", "buyerreg", "buyerpassrest", "elevinfo");
	if( in_array($pname, $pnamearr) )
	{
		echo '<section id="leftrekl">
			'.$LEFT_BANNERS_HTML.'
			<div class="both"></div>
		</section>';
	}
?>
		<div class="both"></div>
	</div>
	<footer>		
		<div class="wrapper">					
			<div class="footcont">
				<div class="f-col1">
					<div class="flogo"><a href="<?=$WWWHOST;?>"><img src="<?=$IMGHOST;?>img5/agrotender-logo-sm.png" alt="Агротендер"></a></div>
					<div class="fcopy">© «Агротендер<sup>TM</sup>» 2011–<?=date("Y", time());?></div>
					<div class="fcopyp">ТМ используется на основании лицензии правообладателя</div>
					<?php
					/*
					<div class="fwork">График работы:<br>
В будние дни с 8 до 21<br>
Суббота с 9 до 20<br>
					</div>					
					*/
					?>
				</div>
				<?php
				echo $txt_res['footerlnks']['text'];
				/*
				<div class="f-col2">
					<p>						
						<a href="#">Как попасть в "Цены трейдеров"</a><br />
						<a href="#">Как попасть в ленту объявлений</a><br />
						<a href="#">Правила размещения объявлений</a><br />
						<a href="<?=$WWWHOST;?>faq/12/index.html">Госты</a><br />
					</p>					
					<p>		
						<?php
							$SMURL = ( (isset($oblurl) && ($oblurl != "")) ? "http://".$oblurl.".agrotender.com.ua/" : $WWWHOST  )."sitemap.html";
							echo '<a href="'.$SMURL.'">Карта сайта</a><br />';
						?>						
					</p>										
                </div>
				<div class="f-col3">	
					<p>						
						<a rel="nofollow" href="<?=Page_BuildUrl($LangId,"info","contacts");?>">Контакты</a><br />
						<a rel="nofollow" href="<?=Page_BuildUrl($LangId,"info","reklama");?>">Реклама</a><br />
						<a href="<?=$WWWHOST;?>news.html">Новости</a><br />
						<a href="<?=$WWWHOST;?>faq.html">Библиотека</a><br />
					</p>
				</div>
				*/
				?>
				<div class="f-col4">
					<div class="fsc">		
						<div class="hdrft">Агротендер в соцсетях:</div>
						<div class="fsc-lnk">
							<?php
							/*
								<a href="https://twitter.com/mlk_trade" target="_blank" class="sc-tw" title="Мы на Twitter"></a>
								<a href="http://www.odnoklassniki.ru/group/51997299048608" target="_blank" class="sc-od" title="Мы на одноклассниках" rel="nofollow"></a>
								
							*/
							?>
							<a href="http://vk.com/agrotender" class="fsc-vk" target="_blank" title="Мы ВКонтакте" rel="nofollow"></a>
							<a href="https://www.facebook.com/groups/agrotender.ua/" class="fsc-fb" target="_blank" title="Мы на Facebook" rel="nofollow"></a>							
							<a href="https://plus.google.com/u/0/111703607003523677770" class="fsc-gp" target="_blank" title="Мы в Google+" rel="nofollow"></a>
						</div>
				<?php
//					if( empty($IS_TEST_MODE) || !$IS_TEST_MODE )
//					{
				?>
						<div>
<div class="ficnt">
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='//www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t54.11;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число просмотров и"+
" посетителей за 24 часа' "+
"border='0' width='88' height='31'><\/a>")
//--></script><!--/LiveInternet-->
</div>
						</div>
				<?php
//					}
				?>
					</div>
					<div class="footbot">			
						<noindex><p rel="nofollow">Created by <a href="http://uhdesign.com.ua/">UHDesign</a></p></noindex>
					</div>	
				</div>
				<div class="both"></div>				
			</div>			
		</div>	
	</footer>
<?php
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
	
	if( empty($IS_TEST_MODE) || !$IS_TEST_MODE )
	{
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-33473390-1', 'agrotender.com.ua');
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
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51d67b953212f4c0"></script>
<!-- AddThis Button END -->
<?php
	}
?>

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'Yh9InrPD9I';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->


</body>
</html>