<?php
	// board.php includes
	//
	// Form to add or edit adv	
?>
<?php
if( isset($reg_ok) && $reg_ok )
{
	echo ($page['content'] != "" ? "<br />".$page['content']."<br />" : "");

	if( $UserId != 0 )
	{
		//echo '<div class="iform-okdop">Вы можете просмотреть и отредактировать свое объявление в <a href="'.$WWWHOST.'bcab_posts.php'.(false && ($publish_utype == 2) ? '?viewcomp=1' : '').'">Личном кабинете</a>.</div>';
		
		echo '<div class="page-notify2">
			<div class="page-notify2-main">
				<span>Cпасибо, что опубликовали своё объявление!</span>
			</div>
			<div class="page-notify2-txt">
				Вы можете просмотреть и отредактировать его в <span><a href="'.$WWWHOST.'bcab_posts.php?viewarc=0&viewtype=0&sortby=postid_down'.(false && ($publish_utype == 2) ? '?viewcomp=1' : '').'">Личном кабинете</a></span>
			</div>
		</div>
		<div class="page-post-rekl">
			<div class="page-post-rekl-tit">Рекламируйте ваше объявление и получайте больше откликов!</div>';
		
		$pack_flags = Array($BILLING_PACK_POSTUP, $BILLING_PACK_POSTCOLOR);
				
		$packstop = Pack_List($BILLING_PACK_POSTTOP);		
		$packs = Pack_List($pack_flags);
		
		/*
		echo '<div style="display: none" class="pay-balance'.($buyer_bal <= 0 ? ' pay-balance-zero' : '').'">
			Ваш текущий баланс на счету: <span id="curbalance" data-balance="'.number_format($buyer_bal, 2, ".", " ").'">'.number_format($buyer_bal, 2, ".", " ").' '.$CURRENCY_NAME.'</span>
		</div>';
		
		echo '<div class="pay-post-info">
			<span>Объявление: </span> '.$advpostinf['title'].'
		</div>';
		*/
		
		$sel_cost = 0;
		
		echo '<div class="page-post-rekl-frm">
		<a class="help_post" href="'.$WWWHOST.'/info/limit_adv.html#p3" target="_blank">Как это работает?</a>
		<br><br>
		'.( false ? '<form id="buypackfrm" action="'.$PHP_SELF.'" method="POST">
		<input type="hidden" name="action" value="payforpost">
		<input type="hidden" name="postid" value="'.$advpostid.'">' : '' );
		
		echo '<div class="pay-rpack-it">
			<div class="pay-rpack-go"><a href="'.$WWWHOST.'bcab_tarif_prekl.php?action=advreklama&postid='.$postid.'&advrekladdtop=1" class="btn btn-green-light btn-go"><span>Рекламировать</span></a></div>
			<span>от '.$packstop[0]['cost'].' '.$CURRENCY_NAME.'</span>
			<div class="pay-rpack-tit pay-rpack-tmeg">'.( false ? '<input type="checkbox" id="advpackid00" class="checkpack" name="advpackid00" value="9999">' : '' ).'<label for="advpackid00"><span>Поднять в топ</span></label></div>
		</div>';
		/*			
			<div class="pay-rpack-sublist">';
		for( $i=0; $i<count($packstop); $i++ )
		{
			echo '<div class="pay-rpack-sub'.($i == 0 ? ' pay-rpack-sub-sel' : '').'">
				<span>'.$packstop[$i]['cost'].' '.$CURRENCY_NAME.'</span>
				<div><input type="radio" id="advpackid'.$packstop[$i]['id'].'" name="advpacktid" value="'.$packstop[$i]['id'].'" data-cost="'.$packstop[$i]['cost'].'" '.($i == 0 ? ' checked' : '').'><label for="advpackid'.$packstop[$i]['id'].'">'.$packstop[$i]['title'].'</label></div>
			</div>';
		}
		echo '</div>
		</div>';	
		*/

		for( $i=0; $i<count($packs); $i++ )
		{
			$upchecked = false;
			
			//if( ($REKL_UP_DBID == $packs[$i]['id']) && ($advrekladdup == 1) )
			//{
			//	$upchecked = true;
			//}
			
			$pack_icos = Array("trock", "tcup");
			
			echo '<div class="pay-rpack-it">
				<div class="pay-rpack-go"><a href="'.$WWWHOST.'bcab_tarif_prekl.php?action=advreklama&postid='.$postid.'&'.($REKL_UP_DBID == $packs[$i]['id'] ? 'advrekladdup=1' : 'advrekladdcolor=1').'" class="btn btn-green-light btn-go"><span>Рекламировать</span></a></div>
				<span>'.$packs[$i]['cost'].' '.$CURRENCY_NAME.'</span>
				<div class="pay-rpack-tit pay-rpack-'.$pack_icos[$i].'">'.( false ? '<input type="checkbox" id="advpackid'.$packs[$i]['id'].'" class="checkpack" name="advpackid[]" value="'.$packs[$i]['id'].'" '.($upchecked ? 'checked' : '').' data-cost="'.$packs[$i]['cost'].'">' : '' ).'<label for="advpackid'.$packs[$i]['id'].'"><span>'.$packs[$i]['title'].'</span></label></div>
			</div>';
		}		
		
		echo '</div>
		
		</div>';
		
		/*
		echo '<div class="page-notify">
			<div class="page-notify-main">
				<span>Cпасибо, что опубликовали своё объявление!</span>
			</div>
			<div class="page-notify-txt">
				Вы можете просмотреть и отредактировать его в <span class="white-box"><a href="'.$WWWHOST.'bcab_posts.php?viewarc=0&viewtype=0&sortby=postid_down'.(false && ($publish_utype == 2) ? '?viewcomp=1' : '').'">Личном кабинете</a></span>
			</div>
		</div>';
		*/
	}
	else
	{
		echo '<div class="page-notify">
			<div class="page-notify-main">
				<span>Cпасибо, что опубликовали своё объявление!</span>
			</div>
			<div class="page-notify-txt">
				Ваше объявление сохранено, но ещё не опубликовано. Вам было <b>отправлено письмо</b> на адрес <a class="comp-tit" style="padding:0;">'.$buyerlog.'</a> <br> <b>со ссылкой для активации</b>, пожалуйста, проверьте вашу почту. Если вы не видите письма, проверьте папку <strong>Спам</strong>,<br> а также правильность написания вашего адреса.
			</div>
		</div>';
		
		//echo '<div class="iform-okdop"><div style="padding:10px; color:#528425; background:#e8f4de;">Ваше объявление сохранено, но ещё не опубликовано. Вам было отправлено письмо на адрес <a class="comp-tit" style="padding:0;">'.$buyerlog.'</a> <br> со ссылкой для активации, пожалуйста, проверьте вашу почту. Если вы не видите письма, проверьте папку <strong>Спам</strong>,<br> а также правильность написания вашего адреса.</div></div>';
	}
	
	/*
		<div class="page-notify">
			<div class="page-notify-main">
				<span>Cпасибо, что опубликовали своё объявление!</span>
			</div>
			<div class="page-notify-txt">
				Вы можете просмотреть и отредактировать его в <span class="white-box"><a href="#">Личном кабинете</a></span>
			</div>
		</div>
	*/
		
	
	if( $advtype == $BOARD_PTYPE_SELL )
	{
		// 150 - зерновые
		// 16 - маслиничніе
		// 2 - бобовые
		if( ($advsect0 == 150) || ($advsect0 == 16) || ($advsect0 == 2) )
		{
			echo '<div class="prop-trader2">
				<div class="prop-trader2-arr"></div>
				<div class="prop-trader2-act">
					<div class="prop-trader-act2-l">
						Предложите свою продукцию трейдерам напрямую!
						<div><span>В 10 раз больше</span> откликов</div>
					</div>
					<div class="prop-trader-act2-btn">
						<a '.( $UserId != 0 ? ' href="#" id="msngrreq2"' : ' id="logotherlnk1" href="'.Page_BuildUrl($LangId, "buyerlog", "").'" ' ).' class="btn btn-blue btn-go"><span>Предложить трейдеру</span></a>
					</div>
				</div>
			</div>';
			
			/*
			echo '<div class="prop-trader">
				<div class="prop-trader-inf">
					<div class="prop-trader-arr">
						<h3><span>Предложите свою продукцию трейдерам напрямую!<i></i></span></h3>
						<div>
							Вы продаете зерновые, масличные или бобовые культуры, а также продукты их переработки? 
							<br><br>
							<b>Предложите</b> вашу продукцию в один клик <b>напрямую крупнейшим зернотрейдерам</b>!
						</div>
					</div>
				</div>
				<div class="prop-trader-act">
					<div class="prop-trader-act-l">
						<span>Чтобы отправить своё предложение трейдеру просто нажмите на кнопку:</span>
					</div>
					<div class="prop-trader-act-btn">
						<a '.( $UserId != 0 ? ' href="#" id="msngrreq2"' : ' id="logotherlnk1" href="'.Page_BuildUrl($LangId, "buyerlog", "").'" ' ).' class="btn btn-light btn-big2">Предложить трейдеру</a>
					</div>
				</div>
			</div>';
			*/
		}
	}
		
	echo '<div style="padding: 20px 0; text-align: center;"><a href="'.Board_BuildUrl($LangId).'">Вернуться к просмотру объявлений</a></div>';

	/*
	echo '<div class="basic-ceninfo"><p style="text-align:left;">Если Вы продаете зерновые, масличные либо бобовые, а так же продукты их переработки - <b>предложите вашу продукцию напрямую крупнейшим зернотрейдерам!</b><br><br></p><br><center>
		<div class="msngr-btn-new-adv"><img src="'.$WWWHOST.'img/OfferGrain.png"/><a '.( $UserId != 0 ? ' href="#" id="msngrreq2"' : ' id="logotherlnk1" href="'.Page_BuildUrl($LangId, "buyerlog", "").'" ' ).' class="btn btn-light" onclick="">Продать объем трейдеру</a></div></center><br><br>
	<a href="'.Board_BuildUrl($LangId).'">Вернуться к просмотру объявлений</a></div>';
	*/
}
else
{
	echo ($page['header'] != "" ? '<div class="txt-blk>'.$page['header'].'</div>' : '');
	
	if( $UserId != 0 )
	{
		if( ($mode != "editadv") && ($msg == "") )
		{
			$query = "SELECT * FROM $TABLE_TORG_BUYERS WHERE id='".$CompUserId."'";
			$query = "SELECT buy.*, comp.city AS compcity FROM $TABLE_TORG_BUYERS AS buy LEFT JOIN $TABLE_COMPANY_ITEMS AS comp ON (buy.id = comp.author_id) WHERE buy.id='".$CompUserId."'";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object( $res ) )
				{
					$buyername = stripslashes($row->name);
					$buyerorgname = stripslashes($row->name);
					$buyerorgname2 = stripslashes($row->name2);
					$buyerorgname3 = stripslashes($row->name3);
					$buyerphone = stripslashes($row->phone);
					$buyerphone2 = stripslashes($row->phone2);
					$buyerphone3 = stripslashes($row->phone3);
					$compcity = stripslashes($row->compcity);
					$buyercity1 = stripslashes($row->city);
					$buyercity = ($compcity !='' ? $compcity : $buyercity1);
					$buyerobl = $row->obl_id;
				}
				mysqli_free_result( $res );
			}
		}
	}

	// Make new control code
	srand((double) microtime() * 1000000);
	$newcode = Array();
	$cryptcode = "";
	for( $i=0; $i<7; $i++ )
	{
		$newcode[$i] = rand(0, 21);
		$cryptcode .= $coding_table[$newcode[$i]];
	}

?>
<script type="text/javascript">
var numoblcombo = 1;
var numcont = 1;

$(document).ready(function(){
	$("#oblmorelnk").bind("click",function(){
		numoblcombo++;

		var combohtml = '<div class="cmbo"><select id="oblcombo'+numoblcombo+'" name="buyerobla[]"></select></div>';
		$("#oblmore").append(combohtml);

		var combo = document.getElementById('oblcombo1');	//$("#oblcombo1").

		$('#oblcombo'+numoblcombo).append($('<option>', {
	        value: '0',
	        text : '-- Область не выбрана --'
	    }));

		for( var i=0; i<combo.options.length; i++ )
		{
		    $('#oblcombo'+numoblcombo).append($('<option>', {
		        value: combo.options[i].value,
		        text : combo.options[i].text
		    }));
		}
		return false
	});

	$("#userrules").bind("click", function(){		
		var chkstat = $(this).is(":checked");
		if( !chkstat )
			$("#postbtn1").attr("disabled", "disabled");
		else
			$("#postbtn1").removeAttr("disabled");
	});

	$("#advcost").bind("change keyup input click", function() {
	    if (this.value.match(/[^0-9,.]/g)) {
	        this.value = this.value.replace(/[^0-9,.]/g, '');
	    }
	});
	$("#advamount").bind("change keyup input click", function() {
	    if (this.value.match(/[^0-9,.]/g)) {
	        this.value = this.value.replace(/[^0-9,.]/g, '');
	    }
	});

	$(".frmcondadd a").bind("click",function(){
		if( $("#frmcont2").css("display") == "none" )
		{
			$("#frmcont2").show();
			numcont++;
		}
		else if( $("#frmcont3").css("display") == "none" )
		{
			$("#frmcont3").show();
			numcont++;
		}

		if( numcont == 3 )
		{
			$(".frmcondadd").hide();
		}
		return false
	});

	$(".frmdel a").bind("click",function(){
		//var idblk = $(this).parent().parent().attr("id");
		var idblk = $(this).parent().attr("id");
		$("#"+idblk).hide();
		numcont--;
		$(".frmcondadd").show();
		return false
	});	
<?php
	if( $showlogwnd )
	{
?>
	_showLogBox();
<?php
	}
?>
});

function chkCombo(selobj){
	if( selobj.options[selobj.selectedIndex].value != 0 )
	{
		$(selobj).parent().removeClass("iinp-fld-error");
		$(selobj).parent().find(".iinp-msg-error").hide();
	}
}

function chkTxtinp(inpobj){
	var sval = inpobj.value;
	sval = sval.trim();
	if( sval.length > 0 ){
		$(inpobj).parent().parent().removeClass("iinp-fld-error");
		$(inpobj).parent().parent().find(".iinp-msg-error").hide();
	}
}
function chkTxtinp2(inpobj){
	var sval = inpobj.value;
	sval = sval.trim();
	if( sval.length > 0 ){
		$(inpobj).parent().removeClass("iinp-fld-error");
		$(inpobj).parent().find(".iinp-msg-error").hide();
	}
}

function topicLiveTip(inpobj, contid){
	var startstr = inpobj.value;
	startstr = startstr.trim();
	
	$('#'+contid).html( wait_html() );
	
	updtTopicLive(startstr, function(){
		$('#'+contid).html(this);
		
		$("a.live-topic-a").off("click");
		$("a.live-topic-a").on("click", function(e){
			e.preventDefault();
			var pid0 = $(this).attr("data-pid");
			var tid0 = $(this).attr("data-tid");
			//console.log( "clicked pid: " + pid0 + ", topic: " + tid0 );
			
			$("#advsect0sel option").prop("selected", false);
			$("#advsect0sel option[value='"+pid0+"']").prop("selected", true);
									
			var topiccmb0 = $("#advsect0sel").get(0);	//document.getElementById('advsect0sel');			
			//for( var i=0; i<topiccmb0.options.length; i++ )
			//{
				//if( $
			//}
			
			changeSubRubr(topiccmb0, tid0);
			
		});
	});
}
</script>


	<section class="iform iform-w">
	
		<div class="frmhdr141"><?=( ($mode == "addadv") && ($UserId != 0) && $cmode ? '' : '<span> </span>' );?></div>
		
	<?php
		if( isset($modermsgs) && count($modermsgs)>0 )
		{
			echo '<div class="iform-moder">';
			for( $j=0; $j<count($modermsgs); $j++ )
			{
				echo '<div class="iform-moder-it">
					'.$modermsgs[$j]['msg'].'
				</div>';
			}
			echo '</div>';
		}
	?>
	
		<form action="<?=Board_BuildUrl($LangId);?>" method="post" enctype="multipart/form-data" onsubmit="return checkFrmFmt(this)">
		<input type="hidden" name="action" value="<?=($mode == "editadv" ? "doupdt" : "doreg");?>" />
		<input type="hidden" name="controlcode" value="<?=$cryptcode;?>" />		
	<?php
		if( $addguid == "" )
			$addguid = makeUuid();
	
		if( $mode == "editadv" )	echo '<input type="hidden" name="postid" value="'.$postid.'" />';
		else						echo '<input type="hidden" name="dubguid" value="'.$addguid.'" />';
	
		if( $msg != "" )
		{
			echo '<div class="error">'.$msg.'</div>';

			// error message moved down to each field
		}

		//var_dump($flderr);
	?>
		
		<div class="frm_error"></div>
		<div class="row">
			<div class="ilbl"></div>
			<div class="iinp">
		<?php
			if( $UserId != 0 )
			{
				echo '<input name="buyername" type="hidden" value="'.$buyername.'" />
				';

				if( $cmode )	// post from comp
				{
					//echo '<td>';

					$complist = Comp_Items( $LangId, 0, 0, 0, 0, -1, 20, $CompUserId, true );
					if( count($complist) > 0 )
					{
						//echo '<div class="ichklbl"> <span>'.$complist[0]['title'].'</span><input type="hidden" name="utype" value="2" /><input type="hidden" name="buyercompid" value="'.$complist[0]['id'].'" /></div>';					
						//echo $complist[0]['title'].'<input type="hidden" name="utype" value="2" /><input type="hidden" name="buyercompid" value="'.$complist[0]['id'].'" />';
					}
					else
					{
						echo 'У вас нет зарегистрированной компании<br /><a href="'.$WWWHOST.'bcab_comp.php?action=addcomp">Зарегистрировать компанию</a>';
					}
					//echo '</td>';
				}
//				else
//				{
//					//echo '<td><input type="hidden" name="utype" value="1" /><div class="ichklbl">Частное лицо:<br /><span>'.$buyername.'</span></div></td>';
//					echo '<input type="hidden" name="utype" value="1" />'.$buyername.'';
//				}
				
			}
			else
			{
				echo '<div class="frmnewtit">Вы зашли как не зарегистрированный пользователь.<br />Для того, чтобы иметь возможность редактировать,<br /> удалять и повышать в рейтинге объявления <a href="'.Page_BuildUrl($LangId, "buyerreg", "").'">зарегистрируйтесь</a> на сайте.</div>';
			}
		?>
			
			</div>
		</div>
		
		<div class="row">
			<div class="ilbl">Заголовок<span>*</span>:</div>
			<div class="iinp<?=( $flderr['atitle'] ? ' iinp-fld-error' : '');?>"><div class="frmrel">
				<input name="advtitle" type="text" class="wid2" value="<?=$advtitle;?>" maxlength="70" onkeyup="updtCount(this,'ltcount',70);chkTxtinp(this);topicLiveTip(this,'livetopic')" onfocus="showHelpTip(this, 'advtitletip')" onblur="hideHelpTip(this, 'advtitletip')" />				
				<div id="advtitletip" class="frmtip"> <?=$ERROR_HINT['advTitleHint']?></div>
				<br>
				<span id="ltcount" class="ltcount"><b>70</b> знаков осталось</span>
				<div class="iinp-msg-error"><span><?=$flderr_str['atitle'];?></span></div>
				<div id="livetopic" class="iinp-livesrch">
				</div>
			</div></div>
		</div>
		
		
		<div class="row">
			<div class="ilbl">Рубрика<span>*</span>:</div>
			<div class="iinp">
				<select id="advsect0sel" name="advsect0" onchange="changeSubRubr(this,0)">
					<option value="0">Выберите рубрику</option>
				<?php				
					/*
					<option value="0">------ Выберите рубрику ------</option>
				<?php
					*/
					
					$topics = Board_TopicLevel($LangId, 0, "bygroups", 0, 0, 0, false);

					$grname = "";
					for( $i=0; $i<count($topics); $i++ )
					{
						if( $grname != $topics[$i]['group'] )
						{
							echo '<option disabled value="0" class="groption">'.$topics[$i]['group'].'</option>';
							$grname = $topics[$i]['group'];
						}
						echo '<option value="'.$topics[$i]['id'].'"'.( $advsect0 == $topics[$i]['id'] ? ' selected' : '' ).'>&nbsp;&nbsp;&nbsp;&nbsp;'.$topics[$i]['name'].'</option>';
					}
				?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="ilbl">Подрубрика<span>*</span>:</div>
			<div class="iinp<?=( $flderr['asect'] ? ' iinp-fld-error' : '');?>">
				<select name="advsect1" id="advsect1" onchange="chkCombo(this)">
				<?php
					if( $advsect0 != 0 )
					{
						$topics = Board_TopicLevel($LangId, $advsect0, "", 0, 0, 0, false);

						for( $i=0; $i<count($topics); $i++ )
						{
							echo '<option value="'.$topics[$i]['id'].'"'.( $advsect1 == $topics[$i]['id'] ? ' selected' : '' ).'>'.$topics[$i]['name'].'</option>';
						}
					}
					else
					{
						//echo '<option value="0">------ Выберите подрубрику ------</option>';
						echo '<option value="0">Выберите подрубрику</option>';
					}
				?>
				</select>
				<div class="iinp-msg-error"><span><?=$flderr_str['asect'];?></span></div>
			</div>
		</div>
	<?php
		//if( ($UserId != 0) && $cmode && (count($complist) > 0) )
		//{
			//echo '<input type="hidden" name="advtype" value="'.$advtype.'" />'; //.$TORG_TYPES_COMP[$advtype];
		//}
		//else
		//{
	?>
		<div class="row">
			<div class="ilbl">Тип<span>*</span>:</div>
			<div class="iinp<?=( $flderr['atype'] ? ' iinp-fld-error' : '');?>" onclick="yaCounter117048.reachGoal('TaipAd')">
				<select name="advtype" onchange="reloadCompSects(this);chkCombo(this)">
					<option value="0">Не выбрано</option>
			<?php
				/*
					<option value="0">---- Не выбрано ----</option>
			<?php
				*/
				
				if( ($UserModerateId == 0) || ( ($UserModerateId != 0) && ($UserModerateRules['pbuy']) ) )
				{			
					//echo '<span class="wid2"><input class="trradio" type="radio" name="advtype" value="'.$BOARD_PTYPE_BUY.'" '.($advtype == $BOARD_PTYPE_BUY ? ' checked="checked"' : '').' onclick="reloadForm();"><label>Купить</label></span>';
					echo '<option value="'.$BOARD_PTYPE_BUY.'"'.($advtype == $BOARD_PTYPE_BUY ? ' selected="selected"' : '').'>Купить</option>';
				}
				else if( $advtype == $BOARD_PTYPE_BUY )
				{
					//$advtype == $BOARD_PTYPE_SELL;
				}
				
				if( ($UserModerateId == 0) || ( ($UserModerateId != 0) && ($UserModerateRules['psell']) ) )
				{			
					//echo '<span class="wid2"><input class="trradio" type="radio" name="advtype" value="'.$BOARD_PTYPE_SELL.'" '.($advtype == $BOARD_PTYPE_SELL ? ' checked="checked"' : '').' onclick="reloadForm();"><label>Продать</label></span>';
					echo '<option value="'.$BOARD_PTYPE_SELL.'"'.($advtype == $BOARD_PTYPE_SELL ? ' selected="selected"' : '').'>Продать</option>';
				}
				else if( $advtype == $BOARD_PTYPE_SELL )
				{
					//$advtype == $BOARD_PTYPE_SERV;
				}
				
				if( ($UserModerateId == 0) || ( ($UserModerateId != 0) && ($UserModerateRules['pserv']) ) )
				{			
					//echo '<span class="wid2"><input class="trradio" type="radio" name="advtype" value="'.$BOARD_PTYPE_SERV.'" '.($advtype == $BOARD_PTYPE_SERV ? ' checked="checked"' : '').' onclick="reloadForm();"><label>Услуги</label></span>';
					echo '<option value="'.$BOARD_PTYPE_SERV.'"'.($advtype == $BOARD_PTYPE_SERV ? ' selected="selected"' : '').'>Услуги</option>';
				}
			?>
				</select>
				<div class="iinp-msg-error"><span><?=$flderr_str['atype'];?></span></div>
			</div>
		</div>
<script type="text/javascript">
function reloadCompSects(selobj)
{
	var typeid = selobj.options[selobj.selectedIndex].value;
	
	if( typeid == <?=$BOARD_PTYPE_SELL;?> )
	{
		$("#oblmore").hide();
		$(".frmaddobl").hide();
	}
	else
	{
		$("#oblmore").show();
		$(".frmaddobl").show();
	}

<?php
	if( ($UserId != 0) && $cmode && (count($complist) > 0) )
	{
?>
	if( typeid != 0 )
	{
		_getCompTopics(<?=($complist[0]['id']);?>, typeid, 'advcsect');
	}
<?php
	}
?>
}
<?php
/*
$(document).ready(function(){
	$(".trradio").bind("click", function(){		
		//alert($(this).val());
		var typeid = $(this).val();		
		_getCompTopics(<?=($complist[0]['id']);?>, typeid, 'advcsect');
	});
});
*/
?>
</script>
<?php
		//}

		//echo $UserId."!".$cmode."!".count($complist)."<br>";
		if( ($UserId != 0) && $cmode && (count($complist) > 0) )
		{
			// показать локальные рубрики для компании, при публикации от компании
			$tlev_html = '';
			$compid = $complist[0]['id'];

			$tlev0 = Company_CabTopic_List($compid, 0, $advtype);
			//if( count($tlev0) > 0 )
			//{
				$tlev_html .= '<div class="row">
					<div class="ilbl">Секция компании:</div>
					<div class="iinp">
						<select name="advcsect" id="advcsect">
							<option value="0">--- Без раздела ---</option>
				';
				for( $j=0; $j<count($tlev0); $j++ )
				{
					$tlev1 = Company_CabTopic_List($compid, $tlev0[$j]['id'], $advtype);

					$tlev_html .= '<option value="'.$tlev0[$j]['id'].'"'.($advcsect == $tlev0[$j]['id'] ? ' selected' : '').'>'.$tlev0[$j]['name'].'</option>';
					for( $i=0; $i<count($tlev1); $i++ )
					{
						$tlev_html .= '<option value="'.$tlev1[$i]['id'].'"'.($advcsect == $tlev1[$i]['id'] ? ' selected' : '').'>&nbsp;&nbsp;&nbsp;&nbsp; '.$tlev1[$i]['name'].'</option>';
					}
				}
				$tlev_html .= '</select>
					</div>
				</div>';
			//}А
			echo $tlev_html;
		}
?>		
		<div class="row">
			<div class="ilbl"> Описание объявления<span>*</span>:</div>
			<div class="iinp<?=( $flderr['atext'] ? ' iinp-fld-error' : '');?>"><div class="frmrel">
				<textarea name="advtext" rows="8" class="wid2" onkeyup="updtCount(this,'ltcount2',2000);chkTxtinp(this)" onfocus="showHelpTip(this, 'advtexttip')" onblur="hideHelpTip(this, 'advtexttip')"><?=$advtext;?></textarea>
				<div id="advtexttip" class="frmtip"> <?=$ERROR_HINT['advTextHint']?></div>
				<br />				
				<span id="ltcount2" class="ltcount"><b>2000</b> знаков осталось</span>
				<div class="iinp-msg-error"><span><?=$flderr_str['atext'];?></span></div>
			</div></div>
		</div>
		<div class="row">
			<div class="ilbl">Цена:</div>
			<div class="iinp"><div class="frmrel">
				<input type="text" id="advcost" name="advcost" class="wid0" maxlength="7" value="<?=$advcost;?>" onfocus="showHelpTip(this, 'advcosttip')" onblur="hideHelpTip(this, 'advcosttip')">
				<span><select name="advcostc" class="wid00">
		<?php
			foreach($CURRENCY_NAMES as $ck => $cnm)
			{
				echo '<option value="'.$CURRENCY_IDS[$ck].'"'.($advcostc == $CURRENCY_IDS[$ck] ? ' selected' : '').'>'.$cnm.'</option>';
			}
		?>
				</select></span>
				<input type="checkbox" name="advcostdog" value="1" <?=($advcostdog == 1 ? ' checked' : '');?>> Договорная
				<div id="advcosttip" class="frmtip"><?=$ERROR_HINT['advPriceHint']?></b></div>
			</div></div>
		</div>
		<div class="row">
			<div class="ilbl">Объем/кол-во:</div>
			<div class="iinp"><div class="frmrel">
				<input type="text" id="advamount" name="advamount" class="wid0" maxlength="7" value="<?=$advamount;?>"onfocus="showHelpTip(this, 'advamounttip')" onblur="hideHelpTip(this, 'advamounttip')" /><span>ед.изм.</span>
				<select class="wid0" name="advizm">
			<?php
				echo '<option value="">-- Выбрать --</option>';
				foreach($IZM as $gr=>$its)
				{
					echo '<option disabled class="groption" value="">'.$gr.'</option>';

					for( $i=0; $i<count($its); $i++ )
					{
						echo '<option value="'.$its[$i].'"'.($its[$i] == $advizm ? ' selected' : '').'>&nbsp;&nbsp;&nbsp;&nbsp; '.$its[$i].'</option>';
					}
				}		
			?>
				</select>
				<div id="advamounttip" class="frmtip"> <?=$ERROR_HINT['advAmountHint']?></div>
			</div></div>
		</div>
	<?php	
		if( $mode == "editadv" )
		{
	?>			
		<div class="row">
			<div class="ilbl">Картинки:</div>
			<div <?=( false ? ' class="iinp"' : ' class="iinp-fupld"' );?>>
				<div class="iinp-files-simple">
					<input name="advpic1" type="file" />
					<input name="advpic2" type="file" />
					<input name="advpic3" type="file" />
					<input name="advpic4" type="file" />
					<input name="advpic5" type="file" />
					<input name="advpic6" type="file" />
					<p style ="font-size:12px; color:#909090; padding-top:8px">Размер картинки не более <b>1.5</b>Мб</p>
				</div>
				<div class="iinp-files-new2">
			<?php
				$html = '';
			
				//$query = "SELECT * FROM $TABLE_ADV_POST_PICS WHERE item_id='".addslashes($postid)."' AND sesid='".addslashes($SESID)."'";
				$query = "SELECT * FROM $TABLE_ADV_POST_PICS WHERE item_id='".addslashes($postid)."'";
				//echo $query."<br>";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					while( $row = mysqli_fetch_object( $res ) )
					{
						
						$html .= '<div class="fupld-uhuloaded-it">
							<div class="fupld-uhuloaded-pic"><img src="'.$WWWHOST.stripslashes($row->filename_ico).'" alt=""></div>
							<div class="fupld-uhuloaded-lnk"><a id="pic0fupld'.$row->file_id.'" href="#" data-picuid="'.stripslashes($row->requid).'" data-picqquid="'.stripslashes($row->qquuid).'" data-picid="'.$row->file_id.'"></a></div>
						</div>';						
					}
					mysqli_free_result( $res );
				}
				
				if( $html != '' )
				{
					$html = '<div class="fupld-uhloaded-plist">'.$html.'</div>';
					
					echo $html;
				}
			?>
					<div id="uploader"></div>    
				</div>
				<div class="iinp-files-switchmode">Если у вас возникли проблемы, то переключитесь <a href="#" id="aloadswitch">на стандартную форму загрузки фото</a></div>
			</div>			
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
			$(".fupld-uhuloaded-lnk a").bind("click", function(e){
				e.preventDefault();
				var reqid = $(this).attr("data-picuid");
				var picid = $(this).attr("data-picid");
				//alert("sending");
				_delPicPostFupld(<?=$postid;?>, picid,<?=($UserModerateId != 0 ? $UserModerateId : $UserId);?>);
			});
		});
		
		///
				
		var uploader = new qq.FineUploader({
			element: document.getElementById("uploader"),
			template: 'qq-template',
            request: {
                endpoint: '/fupld/uploadedt'	
            },
			deleteFile: {
				enabled: true, // defaults to false				
				endpoint: '/fupld/delfile', 
				method: 'POST'
			}, 
            thumbnails: {
                placeholders: {
                    waitingPath: '/css5/fupld/placeholders/waiting-generic.png',
                    notAvailablePath: '/css5/fupld/placeholders/not_available-generic.png'
                }
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
				itemLimit: 6,
				sizeLimit: 3200000
            },
			callbacks: {
				onSubmit: function(id, fileName) {
					this.setParams({postid:"<?=$postid;?>",usid:<?=($UserModerateId != 0 ? $UserModerateId : $UserId);?>},id);
				}
			}
		});			
		</script>
	<?php
	
		}
		
		//echo "!!!!!!!!!!!!!!!!!!!!!!!!!";
		
		if( $mode != "editadv" )
		{
	?>
		<div class="row">
			<div class="ilbl">Картинки:</div>
			<div <?=( false ? ' class="iinp"' : ' class="iinp-fupld"' );?>>
				<div class="iinp-files-simple">
					<input name="advpic1" type="file" />
					<input name="advpic2" type="file" />
					<input name="advpic3" type="file" />
					<input name="advpic4" type="file" />
					<input name="advpic5" type="file" />
					<input name="advpic6" type="file" />
					<p style ="font-size:12px; color:#909090; padding-top:8px">Размер картинки не более <b>1.5</b>Мб</p>
				</div>			
				<div class="iinp-files-new2">
			<?php
				$html = '';
			
				$query = "SELECT * FROM $TABLE_ADV_POST_PICS WHERE requid='".addslashes($addguid)."' AND sesid='".addslashes($SESID)."'";
				//echo $query."<br>";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					while( $row = mysqli_fetch_object( $res ) )
					{
						
						$html .= '<div class="fupld-uhuloaded-it">
							<div class="fupld-uhuloaded-pic"><img src="'.$WWWHOST.stripslashes($row->filename_ico).'" alt=""></div>
							<div class="fupld-uhuloaded-lnk"><a id="pic0fupld'.$row->file_id.'" href="#" data-picuid="'.stripslashes($row->requid).'" data-picqquid="'.stripslashes($row->qquuid).'" data-picid="'.$row->file_id.'"></a></div>
						</div>';
							
						/*
						$pic_found = true;
						$photoid = $row->file_id;

						// Delete pics from disc
						if( @file_exists($THISPATH_STR.$row->filename) )
							@unlink($THISPATH_STR.$row->filename);
						if( @file_exists($THISPATH_STR.$row->filename_ico) )
							@unlink($THISPATH_STR.$row->filename_ico);
						*/
						
					}
					mysqli_free_result( $res );
				}
				
				if( $html != '' )
				{
					$html = '<div class="fupld-uhloaded-plist">'.$html.'</div>';
					
					echo $html;
				}
			?>
					<div id="uploader"></div>    
				</div>
				<div class="iinp-files-switchmode">Если у вас возникли проблемы, то переключитесь <a href="#" id="aloadswitch">на стандартную форму загрузки фото</a></div>
			</div>			
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
			$(".fupld-uhuloaded-lnk a").bind("click", function(e){
				e.preventDefault();
				var reqid = $(this).attr("data-picuid");
				var picid = $(this).attr("data-picid");
				//alert("sending");
				_delPicPostFupld(reqid, picid);
			});
		});
		<?php		
		/*
		$(document).ready(function(){
			// Some options to pass to the uploader are discussed on the next page
			$('#fine-uploader-gallery').fineUploader({
				template: 'qq-template-gallery',
				request: {
					endpoint: '/ajx/ajx_fupld.php'
				},
				thumbnails: {
					placeholders: {
						waitingPath: '/css5/fupld/placeholders/waiting-generic.png',
						notAvailablePath: '/css5/fupld/placeholders/not_available-generic.png'
					}
				},
				validation: {
					allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
				}
			});			
		});
		*/
		?>	
		
		var uploader = new qq.FineUploader({
			element: document.getElementById("uploader"),
			template: 'qq-template',
            request: {
                endpoint: '/fupld/upload'	//, //'/ajx/ajx_fupld.php?cmd=uhupload'
				//params: [{"raddguid":"<?=$addguid;?>"}]
            },
			deleteFile: {
				enabled: true, // defaults to false				
				endpoint: '/fupld/delfile', //'/ajx/ajx_fupld.php?cmd=uhdelete'
				method: 'POST'
			}, 
            thumbnails: {
                placeholders: {
                    waitingPath: '/css5/fupld/placeholders/waiting-generic.png',
                    notAvailablePath: '/css5/fupld/placeholders/not_available-generic.png'
                }
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
				itemLimit: 6,
				sizeLimit: 3200000
            },
			callbacks: {
				onSubmit: function(id, fileName) {
					this.setParams({raddguid:"<?=$addguid;?>"},id);
				}
			}
		});			
		</script>
	<?php
		}
		
		if( ($UserId != 0) && $cmode && (count($complist) > 0) )
		{
			// Не показывать заполнение контактов, когда пытаемся создать объявление из под компании. Контакты будут подтягиваться из компании.
		}
		//if( $UserId == 0 )
		else
		{
			/*
			
			if( $UserId == 0 )
			{
	?>
		<div class="row">
			<div class="ilbl">Ваш e-mail<span>*</span>:</div>
			<div class="iinp<?=( $flderr['umail'] ? ' iinp-fld-error' : '');?>"><div class="frmrel">
				<input name="buyerlog" type="text" value="<?=$buyerlog;?>" onkeyup = "chkTxtinp(this)" onfocus="showHelpTip(this, 'buyerlogtip')" onblur="hideHelpTip(this, 'buyerlogtip')"/>
				<div id="buyerlogtip" class="frmtip"><?=$ERROR_HINT['advEmailHint']?></div>
				<div class="iinp-msg-error"><span><?=$flderr_str['umail'];?></span></div>
			</div></div>
		</div>
	<?php
			} //<span class="iinp-msg-error"><?=$flderr_str['uname'];</span>		
	?>
		<div class="row">
			<div class="ilbl">Контактное лицо<span>*</span>:</div>
			<div class="iinp " style="position:relative">

				<div style="float: left;" class=" <?=($flderr['uname'] ? ' iinp-fld-error' : '');?>">
					<div class="frmrel">
						<input placeholder="Имя" class="wid1" type="text" id="buyerorgname" name="buyerorgname" value="<?=$buyerorgname;?>" onkeyup = "chkTxtinp(this)" onfocus="showHelpTip(this, 'buyernametip')" onblur="hideHelpTip(this, 'buyernametip')"/> &nbsp;
						<div id="buyernametip" class="frmtip"><?=$ERROR_HINT['nameHint']?></div>
						<div class="iinp-msg-error">
							<span><?=$flderr_str['uname'];?></span>
						</div>
					</div>
				</div>
				<div style="float: left;"  class="<?=($flderr['utel'] ? ' iinp-fld-error' : '');?>">
<!--					<span class="wid2">Контактный телефон: </span>-->
					<div class="frmrel">
						<input placeholder="Контактный телефон" class="wid1"  type="text" id="buyerphone" name="buyerphone" value="<?=$buyerphone;?>" onkeyup = "chkTxtinp(this)" onfocus="showHelpTip(this, 'buyerphonetip')" onblur="hideHelpTip(this, 'buyerphonetip')"/>
						<div id="buyerphonetip" class="frmtip"><?=$ERROR_HINT['phoneHint']?></div>
						<div class="iinp-msg-error">
							<span><?=$flderr_str['utel'];?></span>
						</div>
					</div>
				</div>

			<div style="clear: both"></div>

				<div class="frmdel" id="frmcont2" <?=(trim($buyerphone2) == "" ? ' style="display:none;"' : '');?>>
					<input style="float: left; margin-right: 9px;" placeholder="Имя" class="wid1" type="text" id="buyerorgname2" name="buyerorgname2" value="<?=$buyerorgname2;?>">
					<div style="float: left;" class="<?=($flderr['utel2'] ? ' iinp-fld-error' : '');?>" id="frmcont2">
						<div class="frmrel">
							<input placeholder="Контактный телефон" class="wid1" type="text" id="buyerphone2" name="buyerphone2" value="<?=$buyerphone2;?>" onkeyup = "chkTxtinp(this)" onfocus="showHelpTip(this, 'buyerphone2tip')" onblur="hideHelpTip(this, 'buyerphone2tip')"/>
							<div id="buyerphone2tip" class="frmtip"><?=$ERROR_HINT['phoneHint']?></div>
							<div class="iinp-msg-error">
								<span><?=$flderr_str['utel2'];?></span>
							</div>
						</div>
					</div>
					<a style="float: left;" href="#"><span>Скрыть</span></a>
				</div>
				<div class="frmdel" id="frmcont3" <?=(trim($buyerphone3) == "" ? ' style="display:none;"' : '');?>>
					<input style="float: left; margin-right: 9px;" placeholder="Имя" class="wid1" type="text" id="buyerorgname3" name="buyerorgname3" value="<?=$buyerorgname3;?>">
					<div style="float: left;" class="<?=($flderr['utel3'] ? ' iinp-fld-error' : '');?>" id="frmcont3">
						<div class="frmrel">
							<input placeholder="Контактный телефон" class="wid1" type="text" id="buyerphone3" name="buyerphone3" value="<?=$buyerphone3;?>" onkeyup = "chkTxtinp(this)" onfocus="showHelpTip(this, 'buyerphone3tip')" onblur="hideHelpTip(this, 'buyerphone3tip')"/>
							<div id="buyerphone3tip" class="frmtip"><?=$ERROR_HINT['phoneHint']?></div>
							<div class="iinp-msg-error">
								<span><?=$flderr_str['utel3'];?></span>
							</div>
						</div>
					</div>
					<a style="float: left;" href="#"><span>Скрыть</span></a>
				</div>

				<div class="add-more frmcondadd"><a href="#" class="add-more-cont"><span>Добавить еще один контакт</span></a></div>
			</div>
		</div>		
	<?php
		*/
	
		}		
	?>
		<div class="row">
			<div class="ilbl">Область<span>*</span>:</div>
			<div class="iinp">
				<div class="<?=( $flderr['uobl'] ? ' iinp-fld-error' : '');?>">
				<select id="oblcombo1" name="buyerobla[]" onchange="reloadCompSects(this);chkCombo(this)">
			<?php
				echo '<option value="0">-- Область не выбрана --</option>';
				for( $i=1; $i<count($REGIONS); $i++ )
					{
						echo '<option value="'.$i.'"'.( $buyerobla[0] == $i ? ' selected' : '' ).'>'.$REGIONS[$i].'</option>';
					}
			?>
				</select>
				<div class="iinp-msg-error"><span><?=$flderr_str['uobl'];?></span></div>
				</div>
			<?php
				for( $j=1; $j<count($buyerobla); $j++ )
				{
					echo '<div class="cmbo"><select id="oblcombo1" name="buyerobla[]">
					<option value="0">-- Область не выбрана --</option>';
					for( $i=1; $i<count($REGIONS); $i++ )
					{
						echo '<option value="'.$i.'"'.( $buyerobla[$j] == $i ? ' selected' : '' ).'>'.$REGIONS[$i].'</option>';
					}
					echo '</select></div>';
				}
			?>
				<div id="oblmore"<?=($advtype == $BOARD_PTYPE_SELL ? ' style="display: none;"' : '');?>></div>
				<div class="frmaddobl add-more"<?=($advtype == $BOARD_PTYPE_SELL ? ' style="display: none;"' : '');?>><a href="#" id="oblmorelnk" class="add-more-obl"><span>Добавить еще одну область</span></a></div>
			</div>
		</div>
		<div class="row">
			<div class="ilbl">Населенный пункт<span>*</span>:</div>
			<div class="iinp<?=( $flderr['ucity'] ? ' iinp-fld-error' : '');?>"><div class="frmrel">
				<input name="buyercity" type="text" maxlength="20" size="22" value="<?=$buyercity;?>" onkeyup="updtCount(this,'ltcount3',20); chkTxtinp(this)" onfocus="showHelpTip(this, 'buyercitytip')" onblur="hideHelpTip(this, 'buyercitytip')" />
				<div id="buyercitytip" class="frmtip"><?=$ERROR_HINT['advCityHint']?></div>
				<br /><span id="ltcount3" class="ltcount"><b>20</b> знаков осталось</span>
				<div class="iinp-msg-error"><span><?=$flderr_str['ucity'];?></span></div>
			</div></div>
		</div>
            <div class="row">
                <div class="ilbl">Контакты:</div>
                <div class="iinp"><a target="_blank" href="https://agrotender.com.ua/info/kak_izmenit_kontakti.html">Где изменить контактные данные?</a></div>
            </div>
		<div class="row">
			<div class="ilbl">Проверка:</div>

			<div class="iinp<?=( $flderr['ccode'] ? ' iinp-fld-error" style = "border: 2px dotted red"' : '');?>">
				<div class="cga-seccaptcha">
				<?php
					/*
					<img id="captcha" src="<?=$WWWHOST;?>securimage/securimage_show.php" alt="CAPTCHA Image">
					*/
				?>
					<div class="g-recaptcha" data-sitekey="<?=$RECAPTCHA_PUBLIC;?>"></div>
				</div>
				<div id="ccodetip" class="frmtip"><?=$ERROR_HINT['CCodeHint']?></div>
			</div>
		</div>
<?php
	/*
		<div class="row">
			<div class="ilbl">Контрольный код:</div>

			<div class="iinp">
			<?php
				echo "<img src=\"".$WWWHOST."img.php?inm=".$cryptcode."\" width=\"100\" height=\"30\" alt=\"\" />";
			?>
			</div>
		</div>
		<div class="row">
			<div class="ilbl">Ввести код<span>*</span>:</div>
			<div class="iinp <?=( $flderr['ccode'] ? ' iinp-fld-error' : '');?>" style = "position: relative;"><input type="text" class="wid0" size="4" name="usercode" value="" onkeyup="chkTxtinp2(this)"  onfocus="showHelpTip(this, 'ccodetip')" onblur="hideHelpTip(this, 'ccodetip')" /><div class="iinp-msg-error"><span><?=$flderr_str['ccode'];?></span></div>
			<div id="ccodetip" class="frmtip"><?=$ERROR_HINT['CCodeHint']?></div>			
			</div>
		</div>
	*/
?>
		
		<div class="iform-confirm"><label>Я обязуюсь соблюдать <a href="<?=Page_BuildUrl($LangId, "info", "orfeta");?>">Правила размещения объявлений</a></label></div>
		
		<?php
		/*
		<div class="iform-submit"><input id="postbtn1" type="submit" class="btn btn-light" onСlick="yaCounter28990510.reachGoal('addPostForm'); return true;" value=" <?=( $mode != "editadv" ? "Добавить объявление" : "Сохранить изменения" );?> " disabled></div>
		*/
		?>
		<div class="iform-submit"><input id="postbtn1" type="submit" class="btn btn-light <?=( $mode != "editadv" ? "tgm-btn-10" : "" );?>" value=" <?=( $mode != "editadv" ? "Добавить объявление" : "Сохранить изменения" );?> " enabled></div>
	
		</form>

		
	</section>
	
<?php
	if( $mode == "editadv" )
	{
		$pics = Board_PostPhotos( $LangId, $postid );
	}
} // END !$reg_ok
// End mode==addadv