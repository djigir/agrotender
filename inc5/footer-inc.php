<?php
	if( $pname == "board" )
	{
?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php
		if( !$SHOW_COMPANY_TPL && ($mode == "item") )
		{
?>
<div id="wndpcomplain" class="wnd-popup">
	<div class="wnd-popup-box">			
		<div class="wnd-popup-in">
			<div class="wnd-popup-close"><a href="#" title="Закрыть"></a></div>
			<div class="wnd-popup-hdr"><span>Пожаловаться на объявление</span></div>
			<div class="wnd-frm">
				<form action="#" id="pcomplainfrm" method="post">				
				<input type="hidden" name="advcu" id="advcu" value="<?=$UserId;?>">
				<input type="hidden" name="advcp" id="advcp" value="<?=( isset($it['id']) ? $it['id'] : "0" );?>">
				<input type="hidden" name="advcguid" id="advcguid" value="<?=makeUuid();?>">
				<div id="wndmsngrerr" class="frm-errbox"></div>						
				<div class="frm-row" style="padding-left: 14px; padding-right: 14px;">
					<div class="frm-lbl-hor">Описание: </div>
					<div style="position:relative;"><textarea name="pmsgcmoplain" id="pmsgcompl" onfocus="showHelpTip(this, 'advabove22')" onblur="hideHelpTip(this, 'advabove22')"></textarea>
					<div id="advabove22" class="frmtipmsng">Опишите подробно суть проблемы и причину жалобы. <b>Только подробные жалобы будут рассматриваться администрацией.</b> </div>
					</div>
				</div>

				<div class="frm-row ta_center" style="padding-bottom: 14px;"><input type="submit" class="btn btn-light" value="Отправить жалобу"></div>
				</form>
				<div class="both"></div>
			</div>
		</div>
	</div>
</div>
<?php
		}
	}

	//////////////////////////////////////////////////////////////////////////////////

	if( $UserId != 0 )
	{
		//$buyerinfo = User_Info( $UserId );		
		$buyerinfo = Torg_BuyerInfo($LangId, $UserId);
		$COMP_ID = Comp_ItemByUser($LangId, $UserId);
		
		$reqtel = $buyerinfo['phone'];
		$reqmail = $buyerinfo['email'];
		
		$compinfo = Array("id" => 0);
		if( $COMP_ID != 0 )
		{
			$compinfo = Comp_ItemInfo( $LangId, $COMP_ID );	
		}
?>
<div id="wndmsg" class="wnd-popup">
	<div class="wnd-popup-box">			
		<div class="wnd-popup-in">
			<div class="wnd-popup-close"><a href="#" title="Закрыть"></a></div>
			<div class="wnd-popup-hdr"><span>Предложить объем трейдерам</span></div>
			<div class="wnd-frm">
				<form action="<?=$WWWHOST;?>bcab_msngr.php" id="msgfrm" method="post">
				<input type="hidden" name="action" value="doprop">
				<div id="wndmsngrerr" class="frm-errbox"></div>
		<?php
			$tot_prop_num = Msngr_PropNum($LangId, $UserId, $MSNGR_STATUS_NEW);
			if( $tot_prop_num >= $MSNGR_MAX_PROPOSALS )
			{
				echo '<div class="frm-errbox" style="display: block;">'.str_replace("{MAX_PROP}", $MSNGR_MAX_PROPOSALS, $MSNGR_MAX_ERROR).'</div>';
				//break;
			}
		?>
				<div class="frm-row">
					<div class="frm-col2">					
						<div class="frm-lbl">Компания: </div>
						<div class="frm-inp"><input type="text" id="compname" name="compname" value="<?=( $compinfo['id'] != 0 ? str_replace("\"", "&qout;", $compinfo['title']) : '' );?>"></div>
						<div id="compnameerrdiv" class="msnger-err">Пожалуйста, укажите название компании</div>
					</div>
					<div class="frm-col2">					
						<div class="frm-lbl">Продукция: </div>
						<div class="frm-inp"><select id="prodid" name="prodid" onchange="updtTraderList(this, <?=( $compinfo['id'] != 0 ? $compinfo['id'] : "0" );?>)"<?php /*onchange="updtOblList(this)"*/ ?>><option value="0">--- Загрузка вариантов ---</option></select></div>
						<div id="prodiderrdiv" class="msnger-err">Пожалуйста, выберите культуру </div>
					</div>					
				
				</div>
				<div class="frm-row">
					<div class="frm-col2">					
						<div class="frm-lbl">Ф.И.О.: </div>
						<div class="frm-inp"><input type="text" id="compfio" name="compfio" value="<?=( /*$compinfo['id'] != 0*/ false ? $compinfo['bname'] : $buyerinfo['name'] );?>"></div>
						<div id="compfioerrdiv" class="msnger-err">Пожалуйста, укажите свои Ф.И.О</div>
					</div>
					<div class="frm-col2">					
						<div class="frm-lbl">Регион: </div>
						<div class="frm-inp"><select name="prodobl" id="prodobl" <?php /*onchange="updtTraderList(this)"*/ ?>>
							<option value="0">--- Область не выбрана ---</option>
						<?php
							for( $i=1; $i<count($REGIONS); $i++ )
							{
								echo '<option value="'.$i.'"'.($buyerinfo['obl_id'] == $i ? ' selected' : '').'>'.$REGIONS[$i].'</option>';
							}
						?>
						</select></div>
						<div id="prodoblerrdiv" class="msnger-err">Пожалуйста, выберите область</div>
					</div>						
				
				</div>
				<div class="frm-row">
					<div class="frm-col2">					
						<div class="frm-lbl">Телефон: </div>
						<div class="frm-inp"><input type="text" id="comptel" name="comptel" value="<?=( /*$compinfo['id'] != 0*/ false ? $compinfo['bphone'] : $reqtel );?>"></div>
						<div id="comptelerrdiv" class="msnger-err">Пожалуйста, укажите свой контактный телефон</div>
					</div>
					<div class="frm-col2">					
						<div class="frm-lbl">Цена: </div>
						<div class="frm-inp"><input type="text" id="prodcost" class="inp-w75" name="prodcost" onfocus="showHelpTip(this, 'advprice')" onblur="hideHelpTip(this, 'advprice')"><select name="prodcostcur" class="inp-w25"><option value="grn">Грн.</option><option value="usd">USD</option><option value="eur">EUR</option></select>
							<div id="advprice" class="frmtip">Укажите реальную цену вашего товара. Все предложения с ценой, не отвечающей рыночной, будут удаляться. Например: «1 грн», «11», «111»  и т.д. <b>Пользователям, нарушающим данное правило,  доступ в Мессенджер будет заблокирован.</b></div>
						</div>
						<div id="prodcosterrdiv" class="msnger-err">Пожалуйста, укажите стоимость продукции </div>
					</div>
				
				</div>
				<div class="frm-row">
					<div class="frm-col2">					
						<div class="frm-lbl">E-mail: </div>
						<div class="frm-inp"><input type="text" id="compmail" name="compmail" value="<?=( /*$compinfo['id'] != 0*/ false ? $compinfo['bemail'] : $reqmail);?>"></div>
						<div id="compmailerrdiv" class="msnger-err">Пожалуйста, укажите Свой E-mail</div>
					</div>	
					<div class="frm-col2">					
						<div class="frm-lbl">Объем: </div>
						<div class="frm-inp"><input type="text" id="prodamount" name="prodamount" value="" onfocus="showHelpTip(this, 'advmass')" onblur="hideHelpTip(this, 'advmass')">
							<div id="advmass" class="frmtipmsng">Укажите примерный объем продаваемого товара. Предложение с указанным объемом, зернотрейдеры просматривают в 3 раза больше. <b>Не допускается указание объема, не соответствующее предлагаемому товару, например «1 т».</b> </div>
						</div>
						<div id="prodamounterrdiv" class="msnger-err">Пожалуйста, укажите объем</div>
					</div>
				</div>
				<div class="frm-row" style="padding-left: 14px; padding-right: 14px;">
					<div class="frm-lbl-hor">Описание: </div>
					<div style="position:relative;"><textarea name="prodmsg" id="prodmsg" onfocus="showHelpTip(this, 'advabove')" onblur="hideHelpTip(this, 'advabove')"></textarea>
						<div id="advabove" class="frmtipmsng">Добавьте описание предлагаемого товара, качественные характеристики. Местонахождение зерна, условия вывоза/доставки и пр. <b>Не допускается использование заглавных букв и указание контактных данных.</b> </div>
					</div>
				</div>
				<div class="frm-sect">
					<div class="frm-hdr">Перечень доступных трейдеров</div>
					<div id="msngr-trlist" class="frm-traders-list">
						<div class="ta_center">Перечень трейдеров будет доступен после выбора культуры и области</div>
					<?php
					/*
						<span><input type="checkbox" name="ddd" id="tr1" value="1"><label for="tr1">Нибулон</label></span>
						<span><input type="checkbox" name="ddd" id="tr2" value="2"><label for="tr1">Бунге</label></span>
					*/
					?>
					</div>
				</div>
				<div class="frm-row ta_center" style="padding-bottom: 14px;"><input type="submit" class="btn btn-light tgm-btn-11-1" onclick="yaCounter117048.reachGoal('MessendgerSend')" value="Отправить предложение"></div>
				</form>
				<div class="both"></div>
			</div>
		</div>
	</div>
</div>

<?php
	}
	
	//
	$pnamearr = Array("faq", "info", "sitemap", "news", "index", "buyerlog", "buyerreg", "buyerpassrest", "elevinfo", "ban_rekl");
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

						</div>
				<?php
					if( empty($IS_TEST_MODE) || !$IS_TEST_MODE )
					{
				?>
						<div>
<?php
		if( isset($IS_TEST_MODE) && $IS_TEST_MODE )
		{
			//	
		}
		else
		{
?>
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
<?php
		}
?>
						</div>
				<?php
					}
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
	</div>
<?php
	}
	
	$poplist = PopupDialog_GetList($LangId, $UserId);
		
	if( count($poplist)>0 )
	{
		$show_dlg = true;
		$show_dlg_ind = 0;
		
		if( $UserId == 0 )
		{
			// check in cookie, if it was viewed
			$poparrstr = ( ( isset($_COOKIE['popvdlgids']) && (trim($_COOKIE['popvdlgids']) != "") ) ? trim($_COOKIE['popvdlgids']) : "" );
			$poparrtmp = explode(",", $poparrstr);
			
			$show_dlg = false;
			for( $di=$show_dlg_ind; $di<count($poplist); $di++ )
			{
				$this_dlg_viewed = false;
				for($i=0; $i<count($poparrtmp); $i++)
				{
					$popid = (int)$poparrtmp[$i];
					if( $popid == $poplist[$di]['id'] )
					{						
						$this_dlg_viewed = true;
					}				
				}
				
				if( !$this_dlg_viewed )
				{
					$show_dlg_ind = $di;
					$show_dlg = true;
					break;
				}
			}
		}
		else
		{
			$show_dlg = true;
		}
		
		if( $show_dlg )
		{
?>
<script type="text/javascript">
$(document).ready(function(){
	create_DlgPopup('dlgwnd','popupdlg',<?=$poplist[$show_dlg_ind]['id'];?>);
});
</script>
<?php
		}
	}
?>
<div id="dlgwnd" class="wnd-popup">
	<div class="wnd-popup-box">			
		<div class="wnd-popup-in">
			<div class="wnd-popup-close"><a href="#" data-dlg="dlgwnd" title="Закрыть"></a></div>
			<div id="popupdlghdr" class="wnd-popup-hdr"><span>Информация от Agrotender</span></div>
			<div class="wnd-popup-info">
				<div id="dlgwnd-content">
				</div>
				<div class="both"></div>
			</div>
		</div>
	</div>
</div>
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
	
?>



<?php
	
	if( empty($IS_TEST_MODE) || !$IS_TEST_MODE )
	{	
?>

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'Yh9InrPD9I';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->

<?php
	}
?>
<script type="text/javascript">
    window._pt_lt = new Date().getTime();
    window._pt_sp_2 = [];
    _pt_sp_2.push('setAccount,2790a63c');
    var _protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    (function() {
        var atag = document.createElement('script'); atag.type = 'text/javascript'; atag.async = true;
        atag.src = _protocol + 'cjs.ptengine.com/pta_en.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(atag, s);
    })();
</script>
</body>
</html>