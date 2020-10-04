<?php
	//
?>
			</div>
			<div class="both"></div>
		</div>

		<div id="right">
			<div class="lbl">
				<div class="lbl-hdr"><div>Обновления компании</div></div>
				<div class="lbl-mid">
		<?php
			$its = Array();
			$any_type_id = -1;
			if( $COMP_ID != 0 )
			{
				$uid = Comp_UserByItem($LangId, $COMP_ID);

                $its = Lenta_GetItems($LENTA_ALL, $uid, $COMP_ID, 0, 0, 0, 5);

                for( $i=0; $i<count($its); $i++ )
                {
                	$css_type_class = "";
                	switch($its[$i]['type_id'])
                	{
                		case $BOARD_PTYPE_BUY:
                			$css_type_class = "rit-buy";
                			break;
                		case $BOARD_PTYPE_SELL:
                			$css_type_class = "rit-prod";
                			break;
                		case $BOARD_PTYPE_SERV:
                			$css_type_class = "rit-serv";
                			break;
                		default:
                			$css_type_class = "rit-news";
                			break;
                	}

                	switch($its[$i]['type_id'])
                	{
                		case $LENTA_TPOSTBUY:
                		case $LENTA_TPOSTSELL:
                		case $LENTA_TPOSTSERV:
                			$GOURL = Board_BuildUrl($LangId, "itemcomp", "", $its[$i]['type_id'], $its[$i]['topic_id'], $its[$i]['post_id']);
                			break;
                		case $LENTA_TNEWCOMP:
                			$GOURL = Comp_BuildUrl($LangId, "item", "", 0, 0, $its[$i]['other_id']);
                			break;
                		case $LENTA_TNEWNEWS:
                			$GOURL = Comp_BuildUrl($LangId, "newsitem", "", 0, 0, $its[$i]['comp_id'], $its[$i]['other_id']);
                			break;
                		case $LENTA_TNEWVAC:
                			$GOURL = Comp_BuildUrl($LangId, "vacitem", "", 0, 0, $its[$i]['comp_id'], $its[$i]['other_id']);
                			break;
                		case $LENTA_TNEWCOST:
                			$GOURL = Comp_BuildUrl($LangId, "pricetbl", "", 0, 0, $its[$i]['comp_id'], $its[$i]['other_id']);
                			break;
                	}

                	$any_type_id = $its[$i]['type_id'];

                	//$POSTURL = Board_BuildUrl($LangId, "item", $REGIONS_URL[$its[$i]['obl_id']], $its[$i]['type_id'], $its[$i]['topic_id'], $its[$i]['id']);

                	echo '<div class="rit'.($i % 2 == 0 ? ' rit-even' : '').($css_type_class != "" ? ' '.$css_type_class : '').'"><a href="'.$GOURL.'">'.$its[$i]['title'].'</a><p>'.$its[$i]['difstr'].'</p></div>';
                }
			}

			/*
		?>
					<div class="rit rit-even rit-news"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-buy"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-even rit-prod"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-serv"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
			*/

			if( $any_type_id > 0 )
			{
				$CLNK = Comp_BuildUrl($LangId, "item", "", $any_type_id, 0, $COMP_ID);
				echo '<div class="more"><a href="'.$CLNK.'">посмотреть все</a></div>';
			}
		?>
				</div>
			</div>

			<div class="lbl">
				<div class="lbl-hdr"><div>Обновления других компаний</div></div>
				<div class="lbl-mid">
		<?php
			$seltype_id = ( isset($submode) && ($submode == "") && ($adtype > 0) ? $adtype : 0 );

			//echo $seltype_id." - ".$adtype." - ".$submode."<br />";

			switch($submode)
			{
				case "news":
				case "newsitem":
					$seltype_id = $LENTA_TNEWNEWS;
					break;

				case "vacancy":
				case "vacitem":
					$seltype_id = $LENTA_TNEWVAC;
					break;
			}

			$lentahtml = Lenta_BuildHtml($LangId, $seltype_id, (isset($submode_topic) ? $submode_topic : 0));

			echo $lentahtml;

			/*
   			$its = Lenta_GetItems(0, $seltype_id, (isset($submode_topic) ? $submode_topic : 0));

			for( $i=0; $i<count($its); $i++ )
			{
				$css_type_class = "";
				switch($its[$i]['type_id'])
				{
					case $BOARD_PTYPE_BUY:
						$css_type_class = "rit-buy";
						break;
					case $BOARD_PTYPE_SELL:
						$css_type_class = "rit-prod";
						break;
					case $BOARD_PTYPE_SERV:
						$css_type_class = "rit-serv";
						break;
					default:
						$css_type_class = "rit-news";
						break;
				}

				switch($its[$i]['type_id'])
               	{
               		case $LENTA_TPOSTBUY:
               		case $LENTA_TPOSTSELL:
               		case $LENTA_TPOSTSERV:
               			$GOURL = Board_BuildUrl($LangId, "item", "", $its[$i]['type_id'], $its[$i]['topic_id'], $its[$i]['post_id']);
               			break;
               		case $LENTA_TNEWCOMP:
               			$GOURL = Comp_BuildUrl($LangId, "item", "", 0, 0, $its[$i]['other_id']);
               			break;
               		case $LENTA_TNEWNEWS:
               			$GOURL = Comp_BuildUrl($LangId, "newsitem", "", 0, 0, $its[$i]['comp_id'], $its[$i]['other_id']);
               			break;
               		case $LENTA_TNEWVAC:
               			$GOURL = Comp_BuildUrl($LangId, "vacitem", "", 0, 0, $its[$i]['comp_id'], $its[$i]['other_id']);
               			break;
               	}

				$any_type_id = $its[$i]['type_id'];

				//$POSTURL = Board_BuildUrl($LangId, "item", $REGIONS_URL[$its[$i]['obl_id']], $its[$i]['type_id'], $its[$i]['topic_id'], $its[$i]['id']);
				//$POSTURL = Board_BuildUrl($LangId, "item", "", $its[$i]['type_id'], $its[$i]['topic_id'], $its[$i]['post_id']);

				echo '<div class="rit'.($i % 2 == 0 ? ' rit-even' : '').($css_type_class != "" ? ' '.$css_type_class : '').'">
					<div>'.$its[$i]['author'].'</div>
					<a href="'.$GOURL.'">'.$its[$i]['title'].'</a>
					<p>'.$its[$i]['difstr'].'</p>
				</div>';
			}
			*/

			/*
		?>
					<div class="rit rit-even rit-news"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-buy"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-even rit-prod"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-serv"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-even rit-news"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-buy"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-even rit-prod"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-serv"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-even rit-news"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-buy"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-even rit-prod"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
					<div class="rit rit-serv"><a href="#">В Украине из-за девальвации гривны выросли цены на семена</a></div>
			*/

			/*
		?>
					<div class="more"><a href="<?=Page_BuildUrl($LangId,"board","");?>">посмотреть все</a></div>
			*/
		?>
				</div>
			</div>

			<div class="both"></div>
		</div>


		<div class="both"></div>

		<div id="footer">
			<div class="footcont">
				<div class="f-col1">
					<div class="fcopy">© 2011-2016 Агротендер<br />Продажи аграрной продукции<br />по всей Украине</div>
				</div>
				
				<div class="f-col2">
					<?=$FOOTER_MENU;?>
					<?php
					/*
					<a href="#">Контакты и адреса</a> &nbsp;&nbsp;
					<a href="#">Безопасность магазина</a> &nbsp;&nbsp;
					<a href="#">Условия доставки и оплаты</a> &nbsp;&nbsp;
					<a href="#">Интертелеком</a> &nbsp;&nbsp;
					<a href="#">Пиплнет</a> &nbsp;&nbsp;
					<a href="#">Утел</a> &nbsp;&nbsp;
					<a href="#">МТС</a>
					*/
					?>
				</div>
				<div class="f-col3">
				<?php
					/*
					Просмотров <?=( isset($it['id']) && ($it['id'] == $COMP_ID) ? $it['rate'] : 0 );?>
					*/
					
				?>
				
					Просмотров <?=( isset($it['id']) && isset($it['rate']) ? 
						$it['rate'] : 
						( isset($COMP_FULLINFO) && isset($COMP_FULLINFO['rate']) ? $COMP_FULLINFO['rate'] : 0 ) 
					);?>
					
<?php					
	if( isset($IS_TEST_MODE) && $IS_TEST_MODE )
	{
		//
	}
	else
	{


								
	}

	?>
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
				
				
				

				
				<div class="both"></div>
			</div>
		</div>
	</div>
</div>

<div class="wnd-bg"></div>
<?php
	if( $UserId == 0 )
	{
?>	
	<div id="wndlog" class="wnd-popup">
		<div class="wnd-popup-box">			
			<div class="wnd-popup-in">
				<div class="wnd-popup-close"><a href="#" title="Закрыть"></a></div>
				<div class="wnd-popup-hdr"><span>Вход</span></div>
				<div class="log-frm">
					<form action="<?=Page_BuildUrl($LangId, "buyerlog", "");?>" id="logfrm" method="post">
					<input type="hidden" name="action" value="dologin">
					<div class="frm-row"><input type="text" id="buyerlog" name="buyerlog"></div>
					<div class="frm-row"><input type="password" id="buyerpass" name="buyerpass"></div>
					<div id="wndlogerr" class="frm-errbox"></div>
					<div class="frm-lnk"><a href="<?=Page_BuildUrl($LangId,"buyerpassrest", "");?>"><span onclick="yaCounter117048.reachGoal('Pop-up-forgot')">Забыли пароль?</span></a></div>
					<div class="wnd-popup-more"><a href="<?=Page_BuildUrl($LangId, "buyerreg", "");?>">Регистрация</a></div>
					<div class="frm-mem"><input type="checkbox" name="memme" id="memmechk"><label for="memmechk">Запоминить меня</label></div>
					<div class="frm-btn"><input type="submit" class="btn btn-light" value="Войти"></div>
					<div class="frm-cant-in"><a href="<?=Page_BuildUrl($LangId,"buyerlog", "");?>" onclick="yaCounter117048.reachGoal('Pop-up-cant-in')"><span>Не могу войти.</span></a></div>
					</form>
				</div>
		</div>
	</div>
<?php
	}


	if( isset($IS_TEST_MODE) && $IS_TEST_MODE )
	{
		//
	}
	else
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


<?php
	}
?>
</body>
</html>
