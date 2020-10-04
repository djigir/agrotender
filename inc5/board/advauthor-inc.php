<?php
	// board.php includes
	//
	// Adv list in catalog
?>
<section id="content">			
<script type="text/javascript">
$(document).ready(function(){
	$("#srchbtn1").bind("click", function(){
		$("#srchfrm1").submit();
		return false;
	});		
});
</script>
<?php
	$yand="yaCounter117048.reachGoal('SrchAd')";
	$yand1="yaCounter117048.reachGoal('Messendger')";
	echo '<div class="srch-form srch-form-a" onclick="'.$yand.'">
		<form id="srchfrm1" action="'.$WWWHOST.'search.php" method="GET">
		<input type="hidden" name="action" value="searchboard">
		<input type="hidden" name="adtype" value="'.$adtype.'">
		<input type="hidden" name="adtopic" value="'.$adtopic.'">
		<input type="hidden" name="adobl" value="'.$adobl.'">
		<input type="hidden" name="adauthorid" value="'.$authorinf['id'].'">
		<div><input type="text" name="srchword" id="srchword" /><a id="srchbtn1" href="#" class="srch-bckgrnd" title="Искать"></a>		
		</div>
		<div class="srch-options"><input type="checkbox" id="srchchk" name="srchchk" value="1" /><label for="srchchk">Искать в заголовке и описании</label></div>				
		</form>
	</div>
	

	
	<div class="both"></div>';


	//echo "!!!";

	//$TOTAL_POSTS = Board_PostsNum( $LangId, $adtype, $adtopic, ($toptopic == $adtopic), $adobl );
	$TOTAL_POSTS = Board_PostsNumByAuthor( $authorinf['id'], "", -10, 2); 
	
	//echo "222";

	$HTML_PAGES_LINKS = "";
	if( $TOTAL_POSTS > 0 )
	{
		//---------------------- CATALOG PRODUCTs PAGING -----------------------
		$PAGES_DIAP = 7;
		$TOTAL_PAGES = ceil($TOTAL_POSTS / $pn);
		if( $TOTAL_PAGES > 1 )
		{
			if( $pi == 0 )
				$pi = 1;

			// First
			$P_F_LINK = Board_BuildUrl( $LangId, "author", $REGIONS_URL[$adobl], $adtype, $authorinf['id'], 1, $pn );
			// Last
			$P_L_LINK = Board_BuildUrl( $LangId, "author", $REGIONS_URL[$adobl], $adtype, $authorinf['id'], $TOTAL_PAGES, $pn );
			// Prev
			$P_P_LINK = Board_BuildUrl( $LangId, "author", $REGIONS_URL[$adobl], $adtype, $authorinf['id'], ($pi > 1 ? $pi-1 : 1), $pn );
			// Next
			$P_N_LINK = Board_BuildUrl( $LangId, "author", $REGIONS_URL[$adobl], $adtype, $authorinf['id'], ($pi < $TOTAL_PAGES ? $pi+1 : $TOTAL_PAGES), $pn );

			$vis1_num = ( ($pi - floor($PAGES_DIAP / 2)) > 2 ? ($pi - floor($PAGES_DIAP / 2)) : ($TOTAL_PAGES > 1 ? 2 : 1) );
			$vis2_num = ( ($pi + floor($PAGES_DIAP / 2)) < ($TOTAL_PAGES-1) ? ($pi + floor($PAGES_DIAP / 2)) : ($TOTAL_PAGES > 2 ? ($TOTAL_PAGES-1) : 1) );

			//echo "Tp: ".$TOTAL_PAGES."<br />";
			//echo $vis1_num." - ".$vis2_num."<br />";

			//--------------------- MAKE PAGING LAYOUT -------------------------
			//$HTML_PAGES_LINKS .= '<span class="arrow">&#8592;</span>';
			//$HTML_PAGES_LINKS .= '<a class="a-first" href="'.$P_F_LINK.'"></a>';
			$HTML_PAGES_LINKS .= '<a class="a-prev" href="'.$P_P_LINK.'"></a>';

			// Show first link
			if( ($pi == 1) || ($pi == 0) )
				$HTML_PAGES_LINKS .= '<span>1</span>';
			else
				$HTML_PAGES_LINKS .= '<a class="a-page" href="'.$P_F_LINK.'">1</a>';

			//if($vis2_num - $vis1_num >= 0 )
			//{
				for( $i=$vis1_num; $i<=$vis2_num; $i++ )
				{
					if( ($i == $vis1_num) && ($i > 2) )
					{
						$P_LINK = Board_BuildUrl( $LangId, "author", $REGIONS_URL[$adobl], $adtype, $authorinf['id'], $i-1, $pn );
						$HTML_PAGES_LINKS .= '<a class="a-page" href="'.$P_LINK.'">...</a>';
					}

					$P_LINK = Board_BuildUrl( $LangId, "author", $REGIONS_URL[$adobl], $adtype, $authorinf['id'], $i, $pn );
					if( $pi == $i )
						$HTML_PAGES_LINKS .= '<span'.($i>999 ? ' class="a-page-w"' : '').'>'.$i.'</span>';
					else
						$HTML_PAGES_LINKS .= '<a class="a-page'.($i>999 ? ' a-page-w' : '').'" href="'.$P_LINK.'">'.$i.'</a>';

					if( ($i == $vis2_num) && ($i < ($TOTAL_PAGES-1)) )
					{
						$P_LINK = Board_BuildUrl( $LangId, "author", $REGIONS_URL[$adobl], $adtype, $authorinf['id'], $i+1, $pn );
						$HTML_PAGES_LINKS .= '<a class="a-page" href="'.$P_LINK.'">...</a>';
					}
				}
			//}

			// Show last page link
			if( $pi == $TOTAL_PAGES )
				$HTML_PAGES_LINKS .= '<span'.($TOTAL_PAGES>999 ? ' class="a-page-w"' : '').'>'.$TOTAL_PAGES.'</span>';
			else
				$HTML_PAGES_LINKS .= '<a class="a-page'.($TOTAL_PAGES>999 ? ' a-page-w' : '').'" href="'.$P_L_LINK.'">'.$TOTAL_PAGES.'</a>';

			$HTML_PAGES_LINKS .= '<a class="a-next" href="'.$P_N_LINK.'"></a>';
			//$HTML_PAGES_LINKS .= '<a class="a-last" href="'.$P_L_LINK.'"></a>';				
		}
	}

	/*
	if( $HTML_PAGES_LINKS != "" )
	{
		echo '<div class="cpages-row">
			<div class="cpages">
				'.$HTML_PAGES_LINKS.'
			</div>
		</div>';
	}
	*/			
	
	///////////////////////////////////////////////////////////////////////////////////////////
	// Targeting products
	//echo "255";
	//$itst = Board_Posts( $LangId, $adtype, $adtopic, ($toptopic == $adtopic), $adobl, 0, 16, 0, 0, 0, 0, "", "", "", "", "", 0, "rand", "up", false, 0, false, "", false, true);
	$itst = Board_Posts( $LangId, 0, 0, false, 0, 0, 16, 0, $authorinf['id'], 0, 0, "", "", "", "", "", 0, "rand", "up", false, 0, false, "", false, true);
	
	//echo "333";
	$yand="yaCounter117048.reachGoal('targetAdvert')";
	/*
	if( count($itst) > 0 )
	{
		echo '<div class="target-advs">
		<div class="hdr hdr-sm">Рекомендуемые товары</div>
		<div class="jcarousel-skin-targ">

			<!-- Carousel -->
			<div id="targ-list" class="jcarousel" onclick='.$yand.'>
			<ul>
		';
		
		for($i=0; $i<count($itst) && $i<10 ; $i++)
		{
			$POSTURL = Board_BuildUrl($LangId, "item", $REGIONS_URL[$itst[$i]['obl_id']], $itst[$i]['type_id'], $itst[$i]['topic_id'], $itst[$i]['id']);

            $targ_tit = ( strlen($itst[$i]['title']) < 35 ? $itst[$i]['title'] : substr($itst[$i]['title'], 0, 100)."" );

			$pics = Board_PostPhotos( $LangId, $itst[$i]['id'], 1 );
			$pic_html = '';
			if( count($pics) > 0 )
			{
				$pic_html .= '<img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="105" alt="'.$targ_tit.'" />';
			}
			else
			{
				$pic_html .= '<img src="/img/Noimg.jpg" width="140" height="105" alt="Нет фото" />';
			}
			
			$author = ( ($itst[$i]['utype'] == 2) && ($itst[$i]['company_id']!=0) ? $itst[$i]['company'] : "" );				
			//string <div class="targ-it-comp">'.$author.'</div>
				$sz_txt='';
			if ($itst[$i]['cost']!='')
						 //  $its[$i]['cost'].' '.$CURRENCY_NAMES[$CURRENCY_BYID[$its[$i]['cost_cur']]]
				$sz_txt = $itst[$i]['cost'].' '.$CURRENCY_NAMES[$CURRENCY_BYID[$itst[$i]['cost_cur']]];
			
			echo '<li>
				<div class="targ-it"><div class="targ-it-in"><a href="'.$POSTURL.'">
					<div class="targ-it-pic"><table><tr><td>'.$pic_html.'</td></tr></table></div>
					<div class="targ-it-tit">'.$targ_tit.'</div>
					<div class="targ-it-price">'.$sz_txt.'</div>
					<div class="targ-btn"><a href="'.$POSTURL.'" class="btn btn-light">Смотреть</a></div>
				</a></div></div>
			</li>';
		}
		
		echo '</ul>
			</div>

			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev"></a>
			<a href="#" class="jcarousel-control-next"></a>

		</div>		
		<div class="both"></div>
		</div>';
	}
	*/
	
	///////////////////////////////////////////////////////////////////////////////////////////
	// Main product layout
	
	if( count($itst)>0 )
	{
		echo '<div class="target-advs">
		<div class="hdr hdr-sm">Топ объявления</div>
		<div class="adv-list">';
	
		$itst_byid = Array();
		for($i=0; $i<count($itst) && $i<10 ; $i++)
		{
			$itst_byid[$itst[$i]['id']] = true;
			
			$POSTURL = Board_BuildUrl($LangId, "item", $REGIONS_URL[$itst[$i]['obl_id']], $itst[$i]['type_id'], $itst[$i]['topic_id'], $itst[$i]['id']);

			$targ_tit = ( strlen($itst[$i]['title']) < 35 ? $itst[$i]['title'] : substr($itst[$i]['title'], 0, 100)."" );

			$pics = Board_PostPhotos( $LangId, $itst[$i]['id'], 1 );
			$pic_html = '';
			if( count($pics) > 0 )
			{
				$pic_html .= '<img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="105" alt="'.$targ_tit.'" />';
			}
			else
			{
				$pic_html .= '<img src="/img/Noimg.jpg" width="140" height="105" alt="Нет фото" />';
			}
			
			$author = ( ($itst[$i]['utype'] == 2) && ($itst[$i]['company_id']!=0) ? $itst[$i]['company'] : "" );				
			//string <div class="targ-it-comp">'.$author.'</div>
			$sz_txt='';
			$am_txt = '';//mass
			$amsz_txt = '';
			
			if( ($itst[$i]['amount'] != "") || ($itst[$i]['cost'] != "") )
			{
				if( $itst[$i]['cdog'] != 0 )
				{
					$sz_txt = 'договорная';
				}
				else if( $itst[$i]['cost'] != "" )
				{
					//$amsz_txt .= 'Цена <span>'.$its[$i]['cost'].' грн.</span> '.($its[$i]['cizm'] != "" ? ' за <span>'.$its[$i]['cizm'].'</span> &nbsp;&nbsp;' : '');
					$sz_txt = $itst[$i]['cost'].' '.$CURRENCY_NAMES[$CURRENCY_BYID[$itst[$i]['cost_cur']]];
				}

				if( $itst[$i]['amount'] != "" )
				{
					$amsz_txt .= ' Объем <span>'.$itst[$i]['amount'].' '.$itst[$i]['izm'].'</span>';
					$am_txt = $itst[$i]['amount'].' '.$itst[$i]['izm'];
				}					
			}
		
			//if ($itst[$i]['cost']!='')
			//	//  $its[$i]['cost'].' '.$CURRENCY_NAMES[$CURRENCY_BYID[$its[$i]['cost_cur']]]
			//	$sz_txt = $itst[$i]['cost'].' '.$CURRENCY_NAMES[$CURRENCY_BYID[$itst[$i]['cost_cur']]];
		
			$tm_parts = explode(" ",$itst[$i]['dt']);
			
			$rate_html = '';
			if( ($itst[$i]['utype'] == 2) && ($itst[$i]['company_id']!=0) )
			{
				// если єто компания то проверить отзывы
				$COMMENT_NUM = Comp_CommentNum( $itst[$i]['company_id'] );
				if( $COMMENT_NUM > 0 )
				{
					$COMMENT_AVG_RATE = Comp_CommentAvgRate( $itst[$i]['company_id'] );
					$COMMENT_LINK = Comp_BuildUrl($LangId, "item", "", 9, 0, $itst[$i]['company_id']);
					
					$rate_html = ' <div class="adv-rate"><a href="'.$COMMENT_LINK.'"><img width="70" height="13" alt="Оценка отзыва '.$COMMENT_AVG_RATE.'" src="'.$WWWHOST.'img5/rate-'.round($COMMENT_AVG_RATE).'.png"> Отзывов '.$COMMENT_NUM.'</a></div>';
				}
			}
			
			/*
			echo '<li>
				<div class="targ-it"><div class="targ-it-in"><a href="'.$POSTURL.'">
					<div class="targ-it-pic"><table><tr><td>'.$pic_html.'</td></tr></table></div>
					<div class="targ-it-tit">'.$targ_tit.'</div>
					<div class="targ-it-price">'.$sz_txt.'</div>
					<div class="targ-btn"><span class="btn btn-light">Смотреть</span></div>
				</a></div></div>
			</li>';
			*/
			
			echo '<div class="adv-it adv-it-prem" onclick="'.$yand.'">
				<div class="adv-pic"><table><tr><td><a href="'.$POSTURL.'">'.$pic_html.'</a></td></tr></table></div>
				<div class="adv-i">								
					<div class="adv-tit"><a href="'.$POSTURL.'">'.$itst[$i]['title'].'</a>						
					<div class="adv-dir">'.$itst[$i]['ptopic'].' &gt; '.$itst[$i]['topic'].' &gt; '.$ADVTYPE[$itst[$i]['type_id']].'</div></div>
				
					<div class="adv-who">'.$author.$rate_html.'</div>
					<span class="add_city"><p>'.( false ? $itst[$i]['obl'].', '.$itst[$i]['bcity'] : $itst[$i]['bcity'] ).'</p></span>
					<span class="add_data"><p>'.( $itst[$i]['today'] ? 'Сегодня '.$tm_parts[1] : $itst[$i]['dt'] ).'</p></span>

					
				</div>
				<div class="adv-sum">
					<span><p>'.$sz_txt.'</p></span>
					<span><p class="adv-vol">'.$am_txt.'</p></span>	
				</div>
			</div>';
		}
		
		echo '</div>
		</div>';
	}
	
	
	//$its = Board_Posts( $LangId, $adtype, $adtopic, ($toptopic == $adtopic), $adobl, $pi, $pn );
	$its = Board_Posts( $LangId, 0, 0, false, 0, $pi, $pn, 0, $authorinf['id'] );
	$RandArr = array();
	for ( $i=0; $i<4; $i++)
		$RandArr[$i]= rand(0,5)+$i*5;
	
	echo '<div class="hdr hdr-sm">Обычные объявления</div>
	<div class="adv-list">';
	
	
	for( $i=0; $i<count($its); $i++ )
	{
		if( isset($itst_byid[$its[$i]['id']]) )
		{
			// This adv shown in best proposal block (higher on page)
			continue;
		}
		
		$postobl_number = Board_PostOblNum($its[$i]['id']);

		$POSTURL = Board_BuildUrl($LangId, "item", $REGIONS_URL[$its[$i]['obl_id']], $its[$i]['type_id'], $its[$i]['topic_id'], $its[$i]['id']);

		$amsz_txt = '';
		$am_txt = '';//mass
		$sz_txt = '';//price
		if( ($its[$i]['amount'] != "") || ($its[$i]['cost'] != "") )
		{
			if( $its[$i]['cdog'] != 0 )
			{
				$sz_txt = 'договорная';
			}
			else if( $its[$i]['cost'] != "" )
			{
				//$amsz_txt .= 'Цена <span>'.$its[$i]['cost'].' грн.</span> '.($its[$i]['cizm'] != "" ? ' за <span>'.$its[$i]['cizm'].'</span> &nbsp;&nbsp;' : '');
				$sz_txt = $its[$i]['cost'].' '.$CURRENCY_NAMES[$CURRENCY_BYID[$its[$i]['cost_cur']]];
			}

			if( $its[$i]['amount'] != "" )
			{
				$amsz_txt .= ' Объем <span>'.$its[$i]['amount'].' '.$its[$i]['izm'].'</span>';
				$am_txt = $its[$i]['amount'].' '.$its[$i]['izm'];
			}					
		}

		if( strlen($its[$i]['title']) > 77 )
		{
			$sppos = strpos($its[$i]['title'], " ", 76);
			if( $sppos > 0 )
			{
				$its[$i]['title'] = substr($its[$i]['title'], 0, $sppos)."...";
			}
			else
			{
				$its[$i]['title'] = substr($its[$i]['title'], 0, 76)."...";
			}
		}
		//$its[$i]['title'] = ucfirst( strtolower($its[$i]['title']) );

		$pics = Board_PostPhotos( $LangId, $its[$i]['id'], 1 );
		$pic_html = '';

		if( count($pics) > 0 )
		{
			$pic_html .= '<img src="'.$pics[0]['ico'].'" width="'.$pics[0]['ico_w'].'" height="105" alt="'.$its[$i]['title'].'" />';
		}
		else
		{
			$pic_html .= '<img src="/img/Noimg.jpg" width="140" height="105" alt="Нет фото" />';
		}

		$anons = ( strlen($its[$i]['text']) > 65 ? substr($its[$i]['text'], 0, 65)."..." : $its[$i]['text'] );
		
		//if( ($its[$i]['utype'] == 2) && empty($its[$i]['company']) )
		//{
		//	echo "!!!".$its[$i]['id'].":".$its[$i]['company_id'].":<br>";
		//}

		$author = ( ($its[$i]['utype'] == 2) && ($its[$i]['company_id']!=0) ? $its[$i]['company'] : ($its[$i]['bname'] != "" ? $its[$i]['bname'] : ($its[$i]['bname2'] != "" ? $its[$i]['bname2'] : $its[$i]['bname3'])) );				
						
		$tm_parts = explode(" ",$its[$i]['dt']);
		
		$rate_html = '';
		if( ($its[$i]['utype'] == 2) && ($its[$i]['company_id']!=0) )
		{
			// если єто компания то проверить отзывы
			$COMMENT_NUM = Comp_CommentNum( $its[$i]['company_id'] );
			if( $COMMENT_NUM > 0 )
			{
				$COMMENT_AVG_RATE = Comp_CommentAvgRate( $its[$i]['company_id'] );
				$COMMENT_LINK = Comp_BuildUrl($LangId, "item", "", 9, 0, $its[$i]['company_id']);
				
				$rate_html = ' <div class="adv-rate"><a href="'.$COMMENT_LINK.'"><img width="70" height="13" alt="Оценка отзыва '.$COMMENT_AVG_RATE.'" src="'.$WWWHOST.'img5/rate-'.round($COMMENT_AVG_RATE).'.png"> Отзывов '.$COMMENT_NUM.'</a></div>';
			}
		}
		$yand="yaCounter117048.reachGoal('Obvl')";
		echo '<div class="adv-it" onclick="'.$yand.'">
			<div class="adv-pic"><table><tr><td><a href="'.$POSTURL.'">'.$pic_html.'</a></td></tr></table></div>
			<div class="adv-i">								
				<div class="adv-tit"><a href="'.$POSTURL.'">'.$its[$i]['title'].'</a>						
				<div class="adv-dir">'.$its[$i]['ptopic'].' &gt; '.$its[$i]['topic'].' &gt; '.$ADVTYPE[$its[$i]['type_id']].'</div></div>
			
				<div class="adv-who">'.$author.$rate_html.'</div>
				<span class="add_city"><p>'.( false ? $its[$i]['obl'].', '.$its[$i]['bcity'] : $its[$i]['bcity'] ).'</p></span>
				<span class="add_data"><p>'.( $its[$i]['today'] ? 'Сегодня '.$tm_parts[1] : $its[$i]['dt'] ).'</p></span>

				
			</div>
			<div class="adv-sum">
				<span><p>'.$sz_txt.'</p></span>
				<span><p class="adv-vol">'.$am_txt.'</p></span>	
			</div>
		</div>';

		/*<span><p>'.$am_txt.'</p></span>
		
		echo '<div class="adv14">
			<div class="adv14-dir">'.$its[$i]['ptopic'].' &gt; '.$its[$i]['topic'].' &gt; '.$ADVTYPE[$its[$i]['type_id']].'</div>
			<div class="adv14-tm">'.( $its[$i]['today'] ? 'Сегодня' : $its[$i]['dt'] ).'</div>
			<div class="adv14-tit"><a href="'.$POSTURL.'">'.$its[$i]['title'].'</a></div>
			<div class="adv14-pic">'.$pic_html.'</div>
			<div class="adv14-i">
				<div class="adv14-obem">'.$amsz_txt.'</div>
				<div class="adv14-txt">'.$anons.'</div>
				<div class="adv14-place">'.$its[$i]['obl'].', '.$its[$i]['bcity'].($postobl_number > 1 ? ' <span>+'.($postobl_number-1).' обл.</span>' : '').'</div>
				<div class="adv14-who">'.$author.'</div>
			</div>
			<div class="both"></div>
		</div>';
		*/


		//--------------------------------------------------------------------------------
		//Яндекс директ в разных местах

	}
	for ($y=1;$y <= 1;$y++)
		{
		print'
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
		</div>';
		}
		//--------------------------------------------------------------------------------
		


	echo '<div class="both"></div>
	</div>';
	$yand="yaCounter117048.reachGoal('Pagination')";
	if( $HTML_PAGES_LINKS != "" )
	{
	
		echo '<div class="cpages-row" onclick="'.$yand.'">
			<div class="cpages">
				'.$HTML_PAGES_LINKS.'
			</div>
		</div>';			
	}

	if( $PAGE_CONT != "" )
	{
		echo '<div class="txt-blk" onclick="'.$yand.'">'.$PAGE_CONT.'</div>';
	}
?>
		
</section><!-- content -->	