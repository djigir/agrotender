<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////

	$PAGE_PATH		= "<a href=\"".$WWWHOST."\">Главная</a> › ";

	if( $UserId != 0 )
	{
		////////////////////////////////////////////////////////////////////////////
		// Check if this user has companies
		$complist = Comp_Items( $LangId, 0, 0, 0, 0, -1, 20, $UserId, true );

		$compinfo = Comp_ItemInfo( $LangId, (count($complist) > 0 ? $complist[0]['id'] : 0) );			
		////////////////////////////////////////////////////////////////////////////		
		
		//echo $PHP_SELF."<br>";
		
		$ppos = strrpos($PHP_SELF, ".");
		$module_name = substr($PHP_SELF, 1, $ppos-1);
		
		//echo $ppos."<br>";		
		//echo $module_name."<br>";
		
		$tab1 = "pers";
		$tab2 = "";
		
		if( empty($submode) )
			$submode = "";
		
		switch($module_name)
		{
			case "bcab_personal":
				if( ( isset($compinfo['id']) && ($compinfo['id'] != 0) ) )
				{
					$tab1 = "comp";
					$tab2 = "pers";
				}
				else
				{
					$tab1 = "pers";
					$tab2 = "pers";
				}
				break;
				
			case "bcab_personal_cont":
				$tab1 = "pers";
				$tab2 = "pers_cont";
				break;
				
			case "bcab_posts":
				$tab1 = "board";
				break;
				
			case "bcab_prices":
				$tab1 = "trader";
				$tab2 = "tr_prices";
				break;
				
			case "bcab_index":
				$tab1 = "comp";
				$tab2 = "comp_index";
				break;
				
			case "bcab_news":
				$tab1 = "comp";
				$tab2 = "comp_news";
				break;
				
			case "bcab_vac":
				$tab1 = "comp";
				$tab2 = "comp_vacs";
				break;
				
			case "bcab_comp":
				if( ($mode == "editcont") && ($submode == "trader") )
				{
					$tab1 = "trader";
					$tab2 = "tr_cont";
				}
				else if( $mode == "editcont" )
				{
					$tab1 = "comp";
					$tab2 = "comp_cont";
					//switch($submode)
					//{
					//	//
					//}						
				}
				else if( $mode == "editabout" )
				{
					$tab1 = "comp";
					$tab2 = "comp_about";
				}
				else
				{
					$tab1 = "comp";
					$tab2 = "comp_opts";
				}
				break;
		}
		
		if( isset($compinfo['id']) && ($compinfo['id'] != 0) )
		{
			$compname = $compinfo['title'];
		
			//+++++++++++++++++++ MENU FOR COMPANY ++++++++++++++++++++++++++
		
			/*
			$LEFT_CAB_MENU = '<div class="ucab-nav">
				<ul class="ucab-menu">
				<li class="ucab-menu-inf"><div><a href="'.$WWWHOST.'bcab_personal.php">Информация</a></div></li>
				<li class="ucab-menu-board"><div><a href="'.$WWWHOST.'bcab_posts.php">Объявления</a></div></li>
				<li class="ucab-menu-sel ucab-menu-comp"><div><a href="'.$WWWHOST.'bcab_comp.php">Компания</a></div></li>
				</ul>
				<ul class="ucab-menu-sub">
				<li><a href="'.$WWWHOST.'bcab_index.php">Конструктор</a></li>
				<li'.( $mode == "" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php">Настройки</a></li>
				<li'.( ($mode == "editcont") && ($submode != "trader") ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcont">Контакты</a></li>
				<li'.( $mode == "editabout" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editabout">О компании</a></li>
				<li><a href="'.$WWWHOST.'bcab_news.php">Новости</a></li>
				<li><a href="'.$WWWHOST.'bcab_vac.php">Вакансии</a></li>';
				if( isset($compinfo['id']) && ($compinfo['trader'] != 0) )
				{
					$LEFT_CAB_MENU .= '<li><a href="'.$WWWHOST.'bcab_prices.php">Таблица цен</a></li>';
					$LEFT_CAB_MENU .= '<li'.( ($mode == "editcont") && ($submode == "trader") ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editconttrader">Контакты трейдера</a></li>';			
				}
				
				//for( $i=1; $i<count($COMP_ADV_TYPES); $i++ )
				//{
				//	$LEFT_CAB_MENU .= '<li><a href="bcab_posts.php?viewcomp=1&viewtype='.$i.'">'.$COMP_ADV_TYPES[$i].'</a></li>';
				//}
					
			$LEFT_CAB_MENU .= '</ul>
			</div>';
			*/
			
			
			//////////////////////////////////////////
			$yand="yaCounter117048.reachGoal('Marketplace');";
			$LEFT_CAB_MENU = '<div class="ucab-nav">
				<ul class="ucab-menu">
				<li class="'.( $tab1 == "board" ? 'ucab-menu-sel ' : '' ).'ucab-menu-board"><div><a href="'.$WWWHOST.'bcab_posts.php?viewcomp=1" onclick="'.$yand.'">Торговая площадка</a></div></li>				
				<li class="'.( $tab1 == "comp" ? 'ucab-menu-sel ' : '' ).'ucab-menu-comp"><div><a href="'.$WWWHOST.'bcab_comp.php">Компания</a></div></li>
				'.( isset($compinfo['id']) && ($compinfo['trader'] != 0) ? '<li class="'.( $tab1 == "trader" ? 'ucab-menu-sel ' : '' ).'ucab-menu-inf"><div><a href="'.$WWWHOST.'bcab_prices.php">Цены трейдера</a></div></li>' : '' ).'
				</ul>';

			if( $tab1 == "pers" )
			{			
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">
				<li'.( $tab2 == "pers" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal.php">Регистрационные данные</a></li>
				<li'.( $tab2 == "pers_cont" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal_cont.php">Контакты</a></li>
				</ul>';
			}
			else if( $tab1 == "board" )
			{
				$postnum_all = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ) );
				//$postnum_buy = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_BUY );
				//$postnum_sell = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SELL );
				//$postnum_serv = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SERV );
				$postnum_buy = Board_PostsNumByAuthor($UserId, "", $viewcomp, 0, $BOARD_PTYPE_BUY );
				$postnum_sell = Board_PostsNumByAuthor($UserId, "", $viewcomp, 0, $BOARD_PTYPE_SELL );
				$postnum_serv = Board_PostsNumByAuthor($UserId, "", $viewcomp, 0, $BOARD_PTYPE_SERV );
				
				$postnum_bytype = Array($postnum_all, $postnum_buy, $postnum_sell, $postnum_serv);
				
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">'.( $tab1 == "board" ? '{BOARD_SUMMARY}' : '' );
				//$LEFT_CAB_MENU .= '<li'.($viewtype == 0 ? ' class="sel"' : '').'><a href="bcab_posts.php?viewarc='.$viewarc.'&viewtype=0&viewcomp=1&sortby='.$sortby_col.'_'.$sortby_order.'">Все </a> ('.$postnum_bytype[0].')</li>';
				for( $i=1; $i<count($COMP_ADV_TYPES); $i++ )
				{
					$LEFT_CAB_MENU .= '<li'.($i == $viewtype ? ' class="sel"' : '').'><a href="bcab_posts.php?viewarc='.$viewarc.'&viewtype='.$i.'&viewcomp=1&sortby='.$sortby_col.'_'.$sortby_order.'">'.$COMP_ADV_TYPES[$i].'</a>  ('.$postnum_bytype[$i].')</li>';
				}
				$LEFT_CAB_MENU .= '</ul>';
			}
			else if( $tab1 == "comp" )
			{
				
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">
				<li'.( $tab2 == "pers" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal.php" title="Перейти к смене пароля">Смена пароля</a></li>
				<li'.( $tab2 == "comp_index" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_index.php" title="Перейти к конструктору стартовой страницы компании">Конструктор</a></li>
				<li'.( $tab2 == "comp_opts" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php" title="Перейти к настройкам">Настройки</a></li>
				'.( false ? '<li'.( ($tab2 == "comp_cont") && ($submode == "") ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcont" title="Перейти к контактам">Контакты</a></li>' : '' ).'
				<li'.( ($tab2 == "comp_cont") && ($submode != "") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontbuy" title="Перейти к контактам отделов">Контакты отделов</a></li>
				'.( false ? '
				<li'.( ($tab2 == "comp_cont") && ($submode == "buy") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontbuy" title="Контакты отдела закупок">Отдел закупок</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "sell") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontsell" title="Контакты отдела продаж">Отдел продаж</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "serv") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontserv" title="Контакты отдела услуг">Отдел услуг</a></li>' : '' ).'
				'.( false ? '<li'.( $tab2 == "comp_about" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editabout" title="К разделу о компании">О компании</a></li>' : '' ).'
				<li'.( $tab2 == "comp_news" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_news.php" title="Перейти к разделу новости">Новости</a></li>
				<li'.( $tab2 == "comp_vacs" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_vac.php" title="Перейти к разделу вакансии">Вакансии</a></li>
				</ul>';
			}
			else if( $tab1 == "trader" && isset($compinfo['id']) && ($compinfo['trader'] != 0) )
			{
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">
				<li'.( $tab2 == "tr_prices" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_prices.php" title="Перейти к таблицам цен трейдеров">Таблицы цен</a></li>
				<li'.( $tab2 == "tr_cont" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editconttrader" title="Перейти к редактированию контактов трейдера">Контакты трейдера</a></li>
				</ul>';
			}
			else
			{
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub"><li>&nbsp;</li></ul>';
			}
			
			$LEFT_CAB_MENU .= '</div>';
			
			if( ($tab1 == "comp") && ($tab2 == "comp_cont") && ($submode != "") )
			{
				$LEFT_CAB_MENU .= '<div class="ucab-dopmenu">
				<ul>
				<li'.( ($tab2 == "comp_cont") && ($submode == "buy") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontbuy">Отдел закупок</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "sell") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontsell">Отдел продаж</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "serv") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontserv">Отдел услуг</a></li>
				</ul>
				<div class="both"></div>
				</div>';
			}
		}
		else
		{
			//+++++++++++++++++++ MENU FOR PERSON ++++++++++++++++++++++++++			
			
			$LEFT_CAB_MENU = '<div class="ucab-nav">
				<ul class="ucab-menu">
				<li class="'.( $tab1 == "pers" ? 'ucab-menu-sel ' : '' ).'ucab-menu-inf"><div><a href="'.$WWWHOST.'bcab_personal.php">Информация</a></div></li>
				<li class="'.( $tab1 == "board" ? 'ucab-menu-sel ' : '' ).'ucab-menu-board"><div><a href="'.$WWWHOST.'bcab_posts.php">Объявления</a></div></li>
				<li class="'.( $tab1 == "newcomp" ? 'ucab-menu-sel ' : '' ).'ucab-menu-comp-pers"><div><a href="'.$WWWHOST.'bcab_comp.php">Компания</a></div></li>
				</ul>';

			if( $tab1 == "pers" )
			{			
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">
				<li'.( $tab2 == "pers" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal.php">Регистрационные данные</a></li>
				<li'.( $tab2 == "pers_cont" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal_cont.php">Контакты</a></li>
				</ul>';
			}
			else if( $tab1 == "board" )
			{
				$postnum_all = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ) );
				$postnum_buy = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_BUY );
				$postnum_sell = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SELL );
				$postnum_serv = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SERV );
				
				$postnum_bytype = Array($postnum_all, $postnum_buy, $postnum_sell, $postnum_serv);
				
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">';
				//$LEFT_CAB_MENU .= '<li'.($viewtype == 0 ? ' class="sel"' : '').'><a href="bcab_posts.php?viewarc='.$viewarc.'&viewtype=0&viewcomp=0&sortby='.$sortby_col.'_'.$sortby_order.'">Все </a> ('.$postnum_bytype[0].')</li>';
				for( $i=1; $i<count($COMP_ADV_TYPES); $i++ )
				{
					$LEFT_CAB_MENU .= '<li'.($i == $viewtype ? ' class="sel"' : '').'><a href="bcab_posts.php?viewarc='.$viewarc.'&viewtype='.$i.'&viewcomp=0&sortby='.$sortby_col.'_'.$sortby_order.'">'.$COMP_ADV_TYPES[$i].'</a>  ('.$postnum_bytype[$i].')</li>';
				}
				$LEFT_CAB_MENU .= '</ul>';				
			}
			
			$LEFT_CAB_MENU .= '</div>';
		}
	}
?>