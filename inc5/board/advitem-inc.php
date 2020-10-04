<?php
	// board.php includes
	//
	// One adv item layout
?>
<script type="text/javascript">
var viewrun = false;
$(document).ready(function(){
	$("#btnshowcont").bind("click", function(){
		$("#advit14-tip").slideDown(400);
		$("#cadv-tip").slideDown(400);
		if( !viewrun )
		{
			viewrun = true;
			var compid = $(this).attr("data-cid");
			//if( compid != 0 )
			updtViewCount(compid,<?=$it['id'];?>,<?=$VIEWSTAT_CONT;?>);
		}
		return false
	});
	$("#advit14-tip p a").bind("click", function(){
		$("#advit14-tip").hide();
		return false
	});
	$("#cadv-tip p a").bind("click", function(){
		$("#cadv-tip").hide();
		return false
	});
	$(document).bind("click", function(){
		$("#cadv-tip").hide();
		$("#advit14-tip").hide();
	});
});
</script>
<?php
			
		if( $it['id'] == 0 )
		{
			echo '<div class="padding: 50px 50px; color: red;">Объявление было удалено администрацией сайта</div>';
		}
		else
		{
			Board_Post_UpdateView($LangId, $postid);
			Board_Post_UpdateRate($LangId, $VIEWSTAT_ADVS, $it['company_id'], $it['id'], $_SERVER['REMOTE_ADDR']);

			$postobl_number = Board_PostOblNum($postid);

			$it = Board_PostInfo( $LangId, $postid );

			$amsz_txt = '';
			$iam_txt = '';
			$ipr_txt = '';

			if( $SHOW_COMPANY_TPL )
			{
				if( $it['cost'] != "" )		$amsz_txt .= '<div class="advit14-cost"><p>Цена:<br /><span>'.$it['cost'].' '.$CURRENCY_NAMES[$CURRENCY_BYID[$it['cost_cur']]].'</span> '.( false ? ($it['cizm'] != "" ? ' за <span>'.$it['cizm'].'</span>' : '') : '' ).'</p></div>';
				if( $it['amount'] != "" )	$amsz_txt .= '<div class="advit14-vol"><p><br><br>Объем:<br /><span>'.$it['amount'].' '.$it['izm'].'</span></p></div>';
			}
			else
			{
				//if( ($it['amount'] != "") || ($it['cost'] != "") )
				//{
				if( $it['costdog'] != 0 )		
					$ipr_txt .= '<span>Цена: договорная</span>';
				else if( $it['cost'] != "" )		
					$ipr_txt .= '<span>Цена: '.$it['cost'].' '.$CURRENCY_NAMES[$CURRENCY_BYID[$it['cost_cur']]].' '.( false ? ($it['cizm'] != "" ? ' за '.$it['cizm'] : '') : '' ).'</span>';
				
				if( $it['amount'] != "" )	
					$iam_txt .= '<span>Объем: '.$it['amount'].' '.$it['izm'].'</span>';
				//}
				//if( $amsz_txt != '' )
				//{
				//	$amsz_txt = '<div class="advit14-cost">'.$amsz_txt.'</div>';
				//}
			}

			$pics = Board_PostPhotos( $LangId, $it['id'] );

			$COMPURL = '';
			if( $it['company_id'] != 0 )
			{
				$COMPURL = Comp_BuildUrl($LangId, "item", "", 0, 0, $it['company_id']);
			}

			if( $SHOW_COMPANY_TPL )
			{
				$COMPURL = Comp_BuildUrl($LangId, "item", $REGIONS_URL[$it['obl_id']], 0, 0, $it['company_id']);
				$COMPURL_CONT = Comp_BuildUrl($LangId, "item", $REGIONS_URL[$it['obl_id']], $COMPURL_TRANSLATE[$CCAB_BLK_CONTACTS], 0, $it['company_id']);

				$PAGE_PATH		= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
					<a itemprop="url" href="'.$WWWHOST.'"><span itemprop="title">Агротендер</span></a> ›
				</div>';
				$PAGE_PATH .= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
					<a itemprop="url" href="'.Comp_BuildUrl($LangId, "list", $REGIONS_URL[$compit['obl_id']]).'"><span itemprop="title">Компании '.( $compit['obl_id'] != 0 ? " в ".$REGIONS2[$compit['obl_id']] : " в Украине" ).'</span></a> ›
				</div>';
				$PAGE_PATH .= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
					<a itemprop="url" href="'.$COMPURL.'"><span itemprop="title">'.( isset($COMP_NAME) ? $COMP_NAME : 'Компания на Агротендер' ).'</span></a> ›
				</div>';
				$PAGE_PATH .= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
					<a itemprop="url" href="'.Comp_BuildUrl($LangId, "item", "", $it['type_id'], 0, $it['company_id']).'"><span itemprop="title">Торговая площадка</span></a> ›
				</div>';

				echo '<div class="cbreadcrumbs">'.$PAGE_PATH.'</div>';

				
				//$cont_str = '<div class="cadv-tip-who">'.( $it['utype'] == 2 ? $it['company'] : ($it['bname'] != "" ? $it['bname'] : ($it['bname2'] != "" ? $it['bname2'] : $it['bname3'])) ).'</div>';
				$cont_str = '<div class="cadv-tip-who">
					Телефоны: <span>'.$authorit['phone'].'</span>'.( $authorit['tel2'] != '' ? ', <span>'.$authorit['tel2'].'</span>' : '' ).''.( $authorit['tel3'] != '' ? ', <span>Факс: '.$compit['tel3'].'</span>' : '' ).'
				</div>';
				
				$conts = Comp_ItemContacts( $it['author_id'], $it['company_id'], $it['type_id'] );
				$conts_show_num = 3;
				if( count($conts) > 0 )
				{
					$cont_str = "";
					for( $j=0; $j<count($conts); $j++ )
					{
						if( $j >= $conts_show_num )
							break;
						//$cont_str .= '<div class="cadv-who">'.( $conts[$j]['region'] != "" ? "Регион: ".$conts[$j]['region'].'<br />' : '' ).( $conts[$j]['dolg'] != "" ? $conts[$j]['dolg'].': ' : '' ).$conts[$j]['fio'].'<br />тел. '.$conts[$j]['tel'].( $conts[$j]['fax'] != "" ? ', факс: '.$conts[$j]['fax'] : '' ).( $conts[$j]['email'] != "" ? '<br />E-mail: <a href="mailto:'.$conts[$j]['email'].'">'.$conts[$j]['email'].'</a>' : '' ).'</div>';
						$cont_str .= '<div class="cadv-tip-who">'.( $conts[$j]['dolg'] != "" ? '<div>'.$conts[$j]['dolg'].': </div>' : '' ).$conts[$j]['tel'].' - '.$conts[$j]['fio'].( $conts[$j]['fax'] != "" ? '<br />факс: '.$conts[$j]['fax'] : '' ).( $conts[$j]['email'] != "" ? '<br />E-mail: <a href="mailto:'.$conts[$j]['email'].'">'.$conts[$j]['email'].'</a>' : '' ).'</div>';
					}
				}
				else
				{
					//$cont_str .= '<div class="cadv-tip-who">
					//	Телефоны: <span>'.$compit['bphone'].'</span>'.( $compit['bphone2'] != '' ? ', <span>'.$compit['bphone2'].'</span>' : '' ).''.( $compit['bfax'] != '' ? ', <span>Факс: '.$compit['bfax'].'</span>' : '' ).'
					//</div>';
					
					//$cont_str .= '<div class="cadv-tip-who">
					//	Телефоны: <span>'.$authorit['phone'].'</span>'.( $authorit['tel2'] != '' ? ', <span>'.$authorit['tel2'].'</span>' : '' ).''.( $authorit['tel3'] != '' ? ', <span>Факс: '.$compit['tel3'].'</span>' : '' ).'
					//</div>';
				}

				echo '<div class="cadv-block">
					<div class="cadv-piccol">
						<div class="cadv-pics">
							<div class="cadv-pic-big">';
						for( $i=0; $i<count($pics); $i++ )
						{
							if( $i == 0 )
							{
								$dsz = Image_RecalcSize($pics[$i]['src_w'], $pics[$i]['src_h'], 260, 260);
								$psw = $dsz['w'];
								$psh = $dsz['h'];
								echo '<div class="cadv-pic-b"><a href="'.$pics[$i]['src'].'" rel="photo_group"><img src="'.$pics[$i]['src'].'" width="'.$psw.'" height="'.$psh.'" alt="" /></a></div>';

								echo '</div>
								<div class="cadv-pic-list">';

							}
							else
							{
								$dsz = Image_RecalcSize($pics[$i]['ico_w'], $pics[$i]['ico_h'], 120, 100);
								$psw = $dsz['w'];
								$psh = $dsz['h'];
								
								echo '<div class="cadv-pic-it"><a href="'.$pics[$i]['src'].'" rel="photo_group"><img src="'.$pics[$i]['ico'].'" width="'.$psw.'" height="'.$psh.'" alt="" /></a></div>';
							}
						}
						if( count($pics) == 0 )
						{
							echo '<img src="'.$WWWHOST.'img/no-thumb.gif" alt="Нет фото" />';
						}
						echo '<div class="both"></div>
							</div>
							<div class="both"></div>
						</div>
					</div>
					<div class="cadv-icol">
						<div class="cadv-type"><span>'.$COMP_ADV_TYPES[$it['type_id']].'</span></div>
						<div class="cadv-hdr">
							<h1>'.$it['title'].'</h1>
						</div>
						<div class="cadv-i">
							<div class="cadv-tm">Добавлено: '.$it['dt'].'</div>
							<div class="cadv-tm">Обновлено: '.$it['updt'].'</div>
							<div class="cadv-place">Украина, '.$it['obl'].', '.$it['bcity'].($postobl_number > 1 ? ' <span>+'.($postobl_number-1).' обл.</span>' : '').'</div>
							<div class="cadv-views">Просмотров: '.$it['views'].'</div>
							'.( false ? '<div class="advit14-obem">'.$amsz_txt.'</div>' : '' ).'
						</div>
						<div class="cadv-txt">'.nl2br($it['text']).'</div>
					</div>
					<div class="cadv-actblk">
						'.$amsz_txt.'
						<div class="cadv-btntip">
							<a href="#" id="btnshowcont" data-cid="'.$it['company_id'].'"><img src="'.$IMGHOST.'img/btn14-contacts.png" alt="Показать контакты" /></a>							
						</div>
					</div>
					<div class="cadv-tip-pan">
						<div id="cadv-tip">
							<p><a href="#" title="Закрыть окно"><img src="'.$IMGHOST.'compimg/a-close.png" width="12" height="13" alt="Закрыть окно" /></a></p>
							<div>
								'.$cont_str.'
							</div>
							<div class="cadv-tip-btn"><a href="'.$COMPURL_CONT.'"><img src="'.$IMGHOST.'compimg/btn-allcont.png" width="100" height="29" alt="Все контакты" /></a></div>
						</div>
					</div>
					<div class="both"></div>
				</div>';
			}
			else
			{
				
				//echo "!! =".$it['author_id']."=  =".$CompUserId."= !";
				
				//if( $it['id'] == 247886 )
				//{
				//	var_dump($authorit);
				//	echo "<br>";
				//}
				
				$cont_str = '';
				if( $authorit['id'] != 0 )
				{
					$cont_str = '<div class="cadv-tip-who">
						Телефоны <div>'.($authorit['name'] != "" ? $authorit['name'].": " : "").'<span>'.$authorit['phone'].'</span></div>
						'.( $authorit['tel2'] != '' ? '<div>'.($authorit['name2'] != "" ? $authorit['name2'].": " : "").' <span>'.$authorit['tel2'].'</span></div>' : '' ).'
						'.( $authorit['tel3'] != '' ? '<div>'.($authorit['name3'] != "" ? $authorit['name3'].": " : "").' <span>'.$authorit['tel3'].'</span></div>' : '' ).'
					</div>';
				}
				
				//echo "111<br>";
				//echo $cont_str."<br>";
				//echo "2222<br>";
						
				//if( ($it['company_id'] != 0) && isset($compit) )
				//{
					$conts = Comp_ItemContacts( $it['author_id'], $it['company_id'], $it['type_id'] );
					//if( $it['id'] == 247886 ) //238301 )
					//{
					//	echo $it['author_id'].' '.$it['company_id'].' '.$it['type_id']."<br>";
					//	echo count($conts);
					//}
					
					$conts_show_num = 3;
					if( count($conts) > 0 )
					{
						$cont_str = "";
						for( $j=0; $j<count($conts); $j++ )
						{
							if( $j >= $conts_show_num )
								break;
							//$cont_str .= '<div class="cadv-who">'.( $conts[$j]['region'] != "" ? "Регион: ".$conts[$j]['region'].'<br />' : '' ).( $conts[$j]['dolg'] != "" ? $conts[$j]['dolg'].': ' : '' ).$conts[$j]['fio'].'<br />тел. '.$conts[$j]['tel'].( $conts[$j]['fax'] != "" ? ', факс: '.$conts[$j]['fax'] : '' ).( $conts[$j]['email'] != "" ? '<br />E-mail: <a href="mailto:'.$conts[$j]['email'].'">'.$conts[$j]['email'].'</a>' : '' ).'</div>';
							$cont_str .= '<div class="cadv-tip-who">
								'.( $conts[$j]['dolg'] != "" ? '<div>'.$conts[$j]['dolg'].': </div>' : '' ).
									$conts[$j]['tel'].' - '.$conts[$j]['fio'].
									( $conts[$j]['fax'] != "" ? '<br />факс: '.$conts[$j]['fax'] : '' ).
									( $conts[$j]['email'] != "" ? '<br />E-mail: <a href="mailto:'.$conts[$j]['email'].'">'.$conts[$j]['email'].'</a>' : '' ).'
							</div>';
						}
					}
					else
					{		
						if( $cont_str == '' )
						{
							// no contacts, so get them from post record, possibly this is the old advs without author
							$cont_str .= '<div class="cadv-tip-who">
								Телефоны: <span>'.$it['btel1'].'</span>'.( $it['btel2'] != '' ? ', <span>'.$it['btel2'].'</span>' : '' ).''.( $it['btel3'] != '' ? ', <span>'.$compit['btel3'].'</span>' : '' ).'
							</div>';
						}
						//$cont_str .= '<div class="cadv-tip-who">
						//	Телефоны: <span>'.$compit['bphone'].'</span>'.( $compit['bphone2'] != '' ? ', <span>'.$compit['bphone2'].'</span>' : '' ).''.( $compit['bfax'] != '' ? ', <span>Факс: '.$compit['bfax'].'</span>' : '' ).'
						//</div>';
						
						//$cont_str .= '<div class="cadv-tip-who">
						//	Телефоны: <span>'.$authorit['phone'].'</span>'.( $authorit['tel2'] != '' ? ', <span>'.$authorit['tel2'].'</span>' : '' ).''.( $authorit['tel3'] != '' ? ', <span>Факс: '.$compit['tel3'].'</span>' : '' ).'
						//</div>';
					}
				//}
				
				$yand="yaCounter117048.reachGoal('KontactsAd')";
				//// Превращение окончаний месяцев везьде ...Ь = Я... март, август Т=ТА... май Й=Я
				function month_names_end($CurDat)
				{
					setlocale(LC_TIME, 'ru_RU');
					$str = mb_convert_encoding(strftime('%B', strtotime($CurDat)), "windows-1251", "ISO-8859-5");
					$day = date('d', strtotime($CurDat));
					$month = (($str[strlen($str)-1] == "ь") ? str_replace("ь", "я", $str) :  (($str[strlen($str)-1]) == "т" ? str_replace("т", "та", $str) : str_replace("й", "я", $str)));
					$year =	date('Y', strtotime($CurDat));
					return $day.' '.$month.' '.$year;;
				}
				
				
				//echo "!!!!<br>";
				//echo $cont_str;
				//echo "!!!!<br>";
				
				// post layout version 2016-07
				echo '<section id="content">
					<div class="advi-r-block">
						<div class="advi-r-pr">'.$ipr_txt.'</div>
						<div class="advi-r-am">'.$iam_txt.'</div>
						<div class="advi-btns">
							<a href="#" id="btnshowcont" data-cid="'.$it['company_id'].'" class="btn btn-dark btn-iphone" onclick="'.$yand.'">Контакты</a>
							<div class="advi-tip-pan">
								<div id="advit14-tip">
									'.( $cont_str != "" ? $cont_str	: '
									<div>
										<span>'.$it['btel1'].'</span> '.($it['bname'] != "" ? ' - '.$it['bname'] : '').'<br />
										'.( $it['btel2'] != '' ? '<span>'.$it['btel2'].'</span> '.($it['bname2'] != "" ? " - ".$it['bname2'] : '').'<br />' : '' ).'
										'.( $it['btel3'] != '' ? '<span>'.$it['btel3'].'</span> '.($it['bname3'] != "" ? " - ".$it['bname3'] : '').'<br />' : '' ).'
									</div>' ).'
									<p><a href="#"><span>Закрыть</span></a></p>
								</div>
							</div>
							'.( $it['company_id'] != 0 ? '<a href="'.Comp_BuildUrl($LangId, "item", "", 0, 0, $it['company_id']).'" class="btn btn-dark btn-iwww">Сайт</a>' : '' ).'							
							<div class="both"></div>
							<div class="advi-tip-allauthor"><a href="'.Board_BuildUrl($LangId, "author", "", 0, $it['author_id']).'">Все объявления автора</a></div>
							<div class="advi-tip-complain"><a href="#" id="padvcomplainlnk">Пожаловаться на объявление</a></div>';
							
							

			//////////ДРУГИЕ ОБЪЯВЛЕНИЯ КОМПАНИИ///////////////
			$it1 = $it;
			if( $it1['company_id'] != 0 )
			{
				$COMPURL = Comp_BuildUrl($LangId, "item", "", $it1['type_id'], 0, $it1['company_id']);
				//echo '<div><br /><a href="'.$COMPURL.'"><font size="3">Другие объявления этой компании</font></a></div>';

				$show_same_type = true;
				$its = Board_Posts( $LangId, $it1['type_id'], $it1['topic_id'], true, $it1['obl_id'], -10, 5, 0, 0, $it1['id'], $it1['company_id'] );
				if( count($its) <= 5 )
				{
					$show_same_type = false;
					$its = Board_Posts( $LangId, 0, 0, false, 0, -10, 5, 0, 0, $it1['id'], $it1['company_id'] );
				}

				if( count($its) > 0 )
				{
					if( $SHOW_COMPANY_TPL )
					{
						$TORG_TYPES_COMP33 = Array("", "закупки", "товары", "услуги");
						$wordtype = ( $show_same_type ? $TORG_TYPES_COMP33[$it1['type_id']] : "предложения" );
						$yand="yaCounter117048.reachGoal('OtherAdKomp')";
						echo '<div class="cadv-block" style="margin-top: 16px;" onclick="'.$yand.'">
							<div class="cadv-hdr"><div>Другие '.$wordtype.' компании</div></div>
							<div class="cadv-ilist">';
					}
					else
					{
						echo '<div class="both"></div>
						<br />
						<div class="adv-simil adv-simil-adaptiv">
							<div class="hdr hdr-right tgm-btn-12-1">Другие объявления компании</div>
								<div class="adv-simil-list tgm-btn-12-1">';
					}

					for( $i=0; $i<count($its); $i++ )
					{
						$POSTURL = Board_BuildUrl($LangId, ( $SHOW_COMPANY_TPL ? "itemcomp" : "item" ), $REGIONS_URL[$its[$i]['obl_id']], $its[$i]['type_id'], $its[$i]['topic_id'], $its[$i]['id']);

						if( strlen($its[$i]['title']) > 44 )
						{
							$sppos = strpos($its[$i]['title'], " ", 43);
							if( $sppos > 0 )
							{
								$its[$i]['title'] = substr($its[$i]['title'], 0, $sppos)."...";
							}
							else
							{
								$its[$i]['title'] = substr($its[$i]['title'], 0, 43)."...";
							}
						}
						//$its[$i]['title'] = ucfirst( strtolower($its[$i]['title']) );

						$pics = Board_PostPhotos( $LangId, $its[$i]['id'], 1 );
						$pic_html = '<div class="advico14-pic"><img src="'.$WWWHOST.'img/Noimg.jpg" alt="" /></div>';
						if( count($pics) > 0 )
						{
							/////////////////////
							//$pic_html .= '<div class="advpic"><img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="90" alt="" />		</div>';
							//<img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="'.$pics[0]['ico_h'].'" alt="" />		</div>';
							$pic_html = '<div class="advico14-pic"><img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="90" alt="" /></div>';
						}

						$anons = ( strlen($its[$i]['text']) > 120 ? substr($its[$i]['text'], 0, 120)."..." : $its[$i]['text'] );
						//$anons = ucfirst( strtolower($anons) );

						$anons = $REGIONS_SHORT2[$its[$i]['obl_id']];

						if( $SHOW_COMPANY_TPL )
						{
							echo '<div class="advico14">
								'.$pic_html.'
								<div class="advico14-tit"><a href="'.$POSTURL.'">'.$its[$i]['title'].'</a></div>
								<div class="advico14-place">'.$anons.'</div>
							</div>';
						}
						else
						{
							$pic_html = '<div class="simil-pic"><table><tr><td><img src="'.$WWWHOST.'img/Noimg.jpg" alt="" /></td></tr></table></div>';
							if( count($pics) > 0 )
							{
								/////////////////////
								$pic_html = '<div class="simil-pic"><table><tr><td><img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="90" alt="" /></td></tr></table></div>';
							}
						$yandx="yaCounter117048.reachGoal('SimilarAdKompRight')";
							echo '<div class="simil-it">
								'.$pic_html.'
								<div class="simil-holder-txt simil-holder-right" onclick="'.$yandx.'">
								    <div class="simil-tit SimilarAdKompRight"><a href="'.$POSTURL.'">'.$its[$i]['title'].'</a></div>
								    <div class="simil-txt"><a href="'.$POSTURL.'">'.$anons.'</a></div>
								</div>
							</div>';
						}
					}

					if( $SHOW_COMPANY_TPL )
					{
						echo '<div class="both"></div>
							</div>
							<div class="both"></div>
						</div>';
					}
					else
					{
						echo '<div class="both"></div>
							</div>
						</div>';

						//echo '<div class="both"></div>
						//</div>';
					}
				}
			}


							
							
						echo'	
						</div>						
					</div>
					
					<div class="advi-l-block">
						'.( false ? '<div class="advi-logo">
							<table><tr><td>'.( ($it['company_id'] != 0) && ($it['company_logo'] != '') ? '<img src="'.$WWWHOST.$it['company_logo'].'" width="100" />' : '&nbsp;' ).'</td></tr></table>
							<div class="both"></div>
						</div>' : '' ).'
						<div class="advi-l-inf">
							<div class="advi-addr"><p>Украина, '.$it['obl'].', '.$it['bcity'].($postobl_number > 1 ? ' <span>+'.($postobl_number-1).' обл.</span>' : '').'</p></div>
								<div><p>Обновлено: <span>'.month_names_end($it['updt']).'</span></p></div>
								<div><p>Номер объявления: <span>'.$it['id'].'</span></p></div>
								'.( isset($tinfo['id']) && ($tinfo['id'] != 0) ? '<div><p>Рубрика: <a href="'.Board_BuildUrl($LangId, "list", "", 0, $tinfo['id']).'">'.$tinfo['name'].'</a></p></div>' : '' ).'
							'.( false ? '<div><p>Просмотров: '.$it['views'].'</p></div>' : '' ).'
						</div>
						'.( false ? '
						<div class="advi-inf">
							<div class="advi-who">'.( $it['utype'] == 2 ? $it['company'] : ($it['bname'] != "" ? $it['bname'] : ($it['bname2'] != "" ? $it['bname2'] : $it['bname3'])) ).'</div>
							<p>Украина, '.$it['obl'].', '.$it['bcity'].($postobl_number > 1 ? ' <span>+'.($postobl_number-1).' обл.</span>' : '').'</p>
							<p>Добавлено: '.$it['dt'].'</p>
							<p>Обновлено: '.$it['updt'].'</p>
							<p>Просмотров: '.$it['views'].'</p>
							<div class="both"></div>
						</div>
						<div class="advi-btns">
							'.$ipr_txt.$iam_txt.'
							<a href="#" id="btnshowcont" class="btn btn-dark btn-iphone" onclick="'.$yand.'">Контакты</a>
							'.( $it['company_id'] != 0 ? '<a href="'.Comp_BuildUrl($LangId, "item", "", 0, 0, $it['company_id']).'" class="btn btn-dark btn-iwww">Сайт</a>' : '' ).'							
							<div class="both"></div>
						</div>
						<div class="advi-tip-pan">
							<div id="advit14-tip">
								'.( $cont_str != "" ? $cont_str	: '
								<div>
									<span>'.$it['btel1'].'</span> '.($it['bname'] != "" ? ' - '.$it['bname'] : '').'<br />
									'.( $it['btel2'] != '' ? '<span>'.$it['btel2'].'</span> '.($it['bname2'] != "" ? " - ".$it['bname2'] : '').'<br />' : '' ).'
									'.( $it['btel3'] != '' ? '<span>'.$it['btel3'].'</span> '.($it['bname3'] != "" ? " - ".$it['bname3'] : '').'<br />' : '' ).'
								</div>' ).'
								<p><a href="#"><span>Закрыть</span></a></p>
							</div>
						</div>
						' : '' ).'
					
						<div class="adv-gal">
				';
				$pics = Board_PostPhotos( $LangId, $it['id'] );
				if( count($pics) > 0 )
				{
					echo '<div class="adv-pic-main">
					<div class="jcarousel-skin-ppbig">
						<div id="prod-pic-list" class="jcarousel">
						<ul>';
					for( $i=0; $i<count($pics); $i++ )
					{
						echo '<li><table><tr><td><a href="'.$pics[$i]['src'].'" rel="photo_group"><img src="'.$pics[$i]['src'].'" alt="'.str_replace("\"", "&quot;", $it['title']).' - Изображение '.($i+1).'" /></a></td></tr></table></li>';
					}
					echo '</ul>
						</div>
						<!-- Prev/next controls -->
						<a href="#" class="jcarousel-control-prev"></a>
						<a href="#" class="jcarousel-control-next"></a>
					</div>
					
					</div>';
					
					echo '<div class="adv-pic-list">';
					for( $i=0; $i<count($pics); $i++ )
					{
						$dsz = Image_RecalcSize($pics[$i]['ico_w'], $pics[$i]['ico_h'], 120, 100);
						$psw = $dsz['w'];
						$psh = $dsz['h'];
						echo '<div class="adv-pic-it"><a href="'.$pics[$i]['src'].'" rel="photo_group2"><img src="'.$pics[$i]['ico'].'" width="'.$psw.'" height="'.$psh.'" alt="'.str_replace("\"", "&quot;", $it['title']).' - Превью изображения '.($i+1).'" /></a></div>';						
					}
					
					if( $i>0 )
					{
						echo '<div class="both"></div>
						</div>';
					}
						
				}	
				echo '</div>
					<div class="adv-descr">
						<h3>Описание</h3>
						<div class="adv-descr-txt">
							'.nl2br($it['text']).'
						</div>
					</div>
					<div><p>Просмотров: '.$it['views'].'</p></div>
					<div class="both" style="padding: 20px 0px 20px 0px;"><a href="javascript:history.back();">Вернуться к списку объявлений</a></div>';

			//////////ДРУГИЕ ОБЪЯВЛЕНИЯ КОМПАНИИ///////////////

			if( $it['company_id'] != 0 )
			{
				$COMPURL = Comp_BuildUrl($LangId, "item", "", $it['type_id'], 0, $it['company_id']);
				//echo '<div><br /><a href="'.$COMPURL.'"><font size="3">Другие объявления этой компании</font></a></div>';

				$show_same_type = true;
				$its = Board_Posts( $LangId, $it['type_id'], $it['topic_id'], true, $it['obl_id'], -10, 3, 0, 0, $it['id'], $it['company_id'] );
				if( count($its) <= 3 )
				{
					$show_same_type = false;
					$its = Board_Posts( $LangId, 0, 0, false, 0, -10, 3, 0, 0, $it['id'], $it['company_id'] );
				}

				if( count($its) > 0 )
				{
					if( $SHOW_COMPANY_TPL )
					{
						$TORG_TYPES_COMP33 = Array("", "закупки", "товары", "услуги");
						$wordtype = ( $show_same_type ? $TORG_TYPES_COMP33[$it['type_id']] : "предложения" );
						echo '<div class="cadv-block" style="margin-top: 16px;">
							<div class="cadv-hdr"><div>Другие '.$wordtype.' компании</div></div>
							<div class="cadv-ilist">';
					}
					else
					{
						echo '<div class="both"></div>
						<br />
						<div class="adv-simil">
							<div class="hdr">Другие объявления компании</div>
								<div class="adv-simil-list tgm-btn-12-1">';
					}

					for( $i=0; $i<count($its); $i++ )
					{
						$POSTURL = Board_BuildUrl($LangId, ( $SHOW_COMPANY_TPL ? "itemcomp" : "item" ), $REGIONS_URL[$its[$i]['obl_id']], $its[$i]['type_id'], $its[$i]['topic_id'], $its[$i]['id']);

						if( strlen($its[$i]['title']) > 44 )
						{
							$sppos = strpos($its[$i]['title'], " ", 43);
							if( $sppos > 0 )
							{
								$its[$i]['title'] = substr($its[$i]['title'], 0, $sppos)."...";
							}
							else
							{
								$its[$i]['title'] = substr($its[$i]['title'], 0, 43)."...";
							}
						}
						//$its[$i]['title'] = ucfirst( strtolower($its[$i]['title']) );

						$pics = Board_PostPhotos( $LangId, $its[$i]['id'], 1 );
						$pic_html = '<div class="advico14-pic"><img src="'.$WWWHOST.'img/Noimg.jpg" alt="" /></div>';
						if( count($pics) > 0 )
						{
							/////////////////////
							//$pic_html .= '<div class="advpic"><img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="90" alt="" />		</div>';
							//<img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="'.$pics[0]['ico_h'].'" alt="" />		</div>';
							$pic_html = '<div class="advico14-pic"><img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="90" alt="" /></div>';
						}

						$anons = ( strlen($its[$i]['text']) > 120 ? substr($its[$i]['text'], 0, 120)."..." : $its[$i]['text'] );
						//$anons = ucfirst( strtolower($anons) );

						$anons = $REGIONS_SHORT2[$its[$i]['obl_id']];

						if( $SHOW_COMPANY_TPL )
						{
							echo '<div class="advico14">
								'.$pic_html.'
								<div class="advico14-tit"><a href="'.$POSTURL.'">'.$its[$i]['title'].'</a></div>
								<div class="advico14-place">'.$anons.'</div>
							</div>';
						}
						else
						{
							$pic_html = '<div class="simil-pic"><table><tr><td><img src="'.$WWWHOST.'img/Noimg.jpg" alt="" /></td></tr></table></div>';
							if( count($pics) > 0 )
							{
								/////////////////////
								$pic_html = '<div class="simil-pic"><table><tr><td><img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="90" alt="" /></td></tr></table></div>';
							}

							echo '<div class="simil-it">
								'.$pic_html.'
								    <div class="simil-tit"><a href="'.$POSTURL.'">'.$its[$i]['title'].'</a></div>
								    <div class="simil-txt"><a href="'.$POSTURL.'">'.$anons.'</a></div>
							</div>';
						}
					}

					if( $SHOW_COMPANY_TPL )
					{
						echo '<div class="both"></div>
							</div>
							<div class="both"></div>
						</div>';
					}
					else
					{
						echo '<div class="both"></div>
							</div>
						</div>';

						//echo '<div class="both"></div>
						//</div>';
					}
				}
			}
			///////////////////////////////////////////////////////////////////////////////////////////////
			//
			// Похожие объявления других компаний
			//
			$DontShowRubricator = true;

			if( $SHOW_COMPANY_TPL )
			{
				echo '<div class="cadv-block" style="margin-top: 16px;">
					<div class="cadv-hdr"><div>Похожие объявления</div></div>
					<div class="cadv-ilist">';
			}
			else
			{
				echo '<div class="adv-simil">
					<div class="hdr">Похожие объявления</div>
					<div class="adv-simil-list tgm-btn-12-2">';
			}


			$its = Array();
			if( $SHOW_COMPANY_TPL )
			{
				/*
				$its0 = Board_Posts( $LangId, $it['type_id'], $it['topic_id'], false, $it['obl_id'], -10, 5, 0, $it['author_id'], $it['id'] );
				$its = array_merge($its, $its0);
				if( count($its)<5 )
				{
					$its1 = Board_Posts( $LangId, $it['type_id'], $it['topic_id'], false, (0-$it['obl_id']), -10, (5 - count($its)), 0, $it['author_id'], $it['id'] );
					$its = array_merge($its, $its1);
				}

				if( (count($its)<5) && ($it['ptopic_id'] != 0) )
				{
					$its2 = Board_Posts( $LangId, $it['type_id'], $it['ptopic_id'], true, 0, -10, (10 - count($its)), 0, $it['author_id'], $it['id'] );
					//$its = array_merge($its, $its2);

					$iids = Array();
					for( $i=0; $i<count($its); $i++ )
					{
						$iids[$its[$i]['id']] = $its[$i]['id'];
					}

					for( $i=0; $i<count($its2); $i++ )
					{
						if( empty($iids[$its2[$i]['id']]) )
						{
							$its[] = $its2[$i];
							$iids[$its2[$i]['id']] = $its2[$i]['id'];

							if( count($its) >= 5 )
								break;
						}
					}
				}
				*/
			}
			else
			{
				$its0 = Board_Posts( $LangId, $it['type_id'], $it['topic_id'], false, $it['obl_id'], -10, 5, 0, (0-$it['author_id']), $it['id'] );
				$its = array_merge($its, $its0);
				
				if( count($its)<4 )
				{
					$its1 = Board_Posts( $LangId, $it['type_id'], $it['topic_id'], false, (0-$it['obl_id']), -10, (4 - count($its)), 0, 0-$it['author_id'], $it['id'] );
					$its = array_merge($its, $its1);
				}

				if( (count($its)<5) && ($it['ptopic_id'] != 0) )
				{
					$its2 = Board_Posts( $LangId, $it['type_id'], $it['ptopic_id'], true, 0, -10, (10 - count($its)), 0, (0-$it['author_id']), $it['id'] );
					//$its = array_merge($its, $its2);

					$iids = Array();
					for( $i=0; $i<count($its); $i++ )
					{
						$iids[$its[$i]['id']] = $its[$i]['id'];
					}

					for( $i=0; $i<count($its2); $i++ )
					{
						if( empty($iids[$its2[$i]['id']]) )
						{
							$its[] = $its2[$i];
							$iids[$its2[$i]['id']] = $its2[$i]['id'];

							if( count($its) >= 5 )
								break;
						}
					}
				}
			}
			
			///////Удаление дубикатов в похожих объявлениях
			function delldouble ($checkArr)
			{
				$checkArr1 = array();
				$j = 0;
				for( $i=0; ( $i < (count($checkArr)-1)); $i++ )
				{
					if ($checkArr[$i]['id'] != $checkArr[$i + 1]['id'])
					{
						$checkArr1 [$j] = $checkArr[$i];
						$j++;
					}
				}
				return $checkArr1;
			}
			

			$its = delldouble( $its );
			//////////////////////////////////////////////////
			
			
			for( $i=0; (( $i < count ( $its )) xor ( $i == 3)); $i++ )
			{

				$POSTURL = Board_BuildUrl($LangId, "item", $REGIONS_URL[$its[$i]['obl_id']], $its[$i]['type_id'], $its[$i]['topic_id'], $its[$i]['id']);

				$amsz_txt = '';
				if( ($its[$i]['amount'] != "") || ($its[$i]['cost'] != "") )
				{
					$amsz_txt .= '<div class="advsize" style="padding:0px 0px 4px 0px;">';
					if( $its[$i]['cost'] != "" )
					{
						$amsz_txt .= 'Цена <span>'.$its[$i]['cost'].' '.$CURRENCY_NAMES[$CURRENCY_BYID[$its[$i]['cost_cur']]].'</span> '.($its[$i]['cizm'] != "" ? ' за <span>'.$its[$i]['cizm'].'</span> &nbsp;&nbsp;' : '');
					}

					if( $its[$i]['amount'] != "" )
					{
						$amsz_txt .= ' Объем <span>'.$its[$i]['amount'].' '.$its[$i]['izm'].'</span>';
					}
					$amsz_txt .= '</div>';
				}

				if( strlen($its[$i]['title']) > 44 )
				{
					$sppos = strpos($its[$i]['title'], " ", 43);
					if( $sppos > 0 )
					{
						$its[$i]['title'] = substr($its[$i]['title'], 0, $sppos)."...";
					}
					else
					{
						$its[$i]['title'] = substr($its[$i]['title'], 0, 43)."...";
					}
				}

				$pics = Board_PostPhotos( $LangId, $its[$i]['id'], 1 );

				$anons = ( strlen($its[$i]['text']) > 120 ? substr($its[$i]['text'], 0, 120)."..." : $its[$i]['text'] );

				if( $SHOW_COMPANY_TPL )
				{
					$pic_html = '<div class="advico14-pic"><img src="'.$WWWHOST.'img/Noimg.jpg" alt="" /></div>';
					if( count($pics) > 0 )
					{
						/////////////////////
						$pic_html = '<div class="advico14-pic"><img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="90" alt="" /></div>';
					}

					echo '<div class="advico14">
						'.$pic_html.'
						<div class="advico14-tit"><a href="'.$POSTURL.'">'.$its[$i]['title'].'</a></div>
						<div class="advico14-place">'.$anons.'</div>
					</div>';
				}
				else
				{
					$pic_html = '<div class="simil-pic"><table><tr><td><img src="'.$WWWHOST.'img/Noimg.jpg" alt="" /></td></tr></table></div>';
					if( count($pics) > 0 )
					{
						/////////////////////
						$pic_html = '<div class="simil-pic"><table><tr><td><img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="90" alt="" /></td></tr></table></div>';
					}
					$obladv = $REGIONS_SHORT2[$its[$i]['obl_id']];
					echo '<div class="simil-it">
						'.$pic_html.'
						<div class="simil-tit"><a href="'.$POSTURL.'">'.$its[$i]['title'].'</a></div>
						<div class="simil-txt"><a href="'.$POSTURL.'">'.$obladv.'</a></div>
						
					</div>';
				}

			
			}

				//Adsense внутри объявлений
				//echo '<center>';
				for($ForG=0;$ForG<1;$ForG++)
				{?>
				<div style="clear: both">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-format="fluid"
                    data-ad-layout="image-side"
                    data-ad-layout-key="-fj+w-2z-dy+10u"
                    data-ad-client="ca-pub-8444678913251553"
                    data-ad-slot="9754284228"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                </div>
				<?php
				}
				echo '</div>';
				
								
			}				


			//echo '<br /><div class="both"></div>';


			if( $SHOW_COMPANY_TPL )
			{
				echo '<div class="both"></div>
					</div>
					<div class="both"></div>
				</div>';
			}
			else
			{
				echo '<div class="both"></div>
						</div>
					</div>';
				
				echo '<div class="both"></div>
				</section>';
			}
		}