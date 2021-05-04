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
	
	$MenuUserId = $UserId;
	if( isset($CompUserId) && ($CompUserId != 0) )
	{
		$MenuUserId = $CompUserId;
	}
	
	//echo $UserId.":".$MenuUserId."<br>";

	if( $UserId != 0 )
	{
		////////////////////////////////////////////////////////////////////////////
		// Check if this user has companies
		$complist = Comp_Items( $LangId, 0, 0, 0, 0, -1, 20, $MenuUserId, true );

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
				/*
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
				*/
				$tab1 = "pers";
				$tab2 = "pers";
				break;
				
			case "bcab_personal_cont":
				$tab1 = "pers";
				$tab2 = "pers_cont";
				$submode = "main";
				break;
				
			case "bcab_modersel":
				$tab1 = "pers";
				$tab2 = "pers_moder";
				break;
				
			case "bcab_subscr":
				$tab1 = "pers";
				$tab2 = "pers_subscr";
				break;
				
			case "bcab_comment":
				/*
				if( ( isset($compinfo['id']) && ($compinfo['id'] != 0) ) )
				{
					$tab1 = "comp";
					$tab2 = "pers_comment";
				}
				else
				{
					$tab1 = "pers";
					$tab2 = "pers_comment";
				}
				*/
				$tab1 = "pers";
				$tab2 = "pers_comment";
				break;
								
			case "bcab_posts":
				$tab1 = "board";
				break;
				
			case "bcab_prices":
				$tab1 = "trader";
				$tab2 = "tr_prices";
				break;
				
			case "bcab_pricetbls":
				$tab1 = "trader";
				$tab2 = "tr_pricereport";
				break;
				
			case "bcab_index":
				//$tab1 = "comp";
				$tab1 = "pers";
				$tab2 = "comp_index";
				break;
				
			case "bcab_news":
				$tab1 = "pers";
				$tab2 = "comp_news";
				break;
				
			case "bcab_vac":
				//$tab1 = "comp";
				$tab1 = "pers";
				$tab2 = "comp_vacs";
				break;			
			
			case "bcab_moder":
				//$tab1 = "comp";
				$tab1 = "pers";
				$tab2 = "comp_moder";
				break;
				
			case "bcab_analytics":
				//$tab1 = "comp";
				$tab1 = "pers";
				$tab2 = "comp_analytics";
				break;
				
			case "bcab_msngr":
				/*
				if( isset($compinfo['id']) && ($compinfo['id'] != 0) && ($compinfo['trader'] != 0) )
				{
					//$tab1 = "comp";
					//$tab2 = "comp_msngr";
					$tab1 = "trader";
					$tab2 = "tr_msngr";
				}				
				else if( isset($compinfo['id']) && ($compinfo['id'] != 0) && ($compinfo['trader'] == 0) )
				{
					//$tab1 = "comp";
					//$tab2 = "comp_msngr";
					$tab1 = "comp";
					$tab2 = "comp_msngr";
				}				
				else
				{
					$tab1 = "pers";
					$tab2 = "pers_msngr";
				}
				*/				
				$tab1 = "pers";
				$tab2 = "pers_msngr";
				break;
				
			case "bcab_comp_opts":
				//$tab1 = "comp";
				$tab1 = "pers";
				$tab2 = "comp_opts";
				break;
				
			case "bcab_comp_main":
				//$tab1 = "comp";
				$tab1 = "pers";
				$tab2 = "comp_cont";
				$submode = "main";
				break;
				
			case "bcab_comp_otdel":
				//$tab1 = "comp";
				$tab1 = "pers";
				$tab2 = "comp_cont";
				//$submode = "main";
				break;
				
			case "bcab_comp":
				if( ($mode == "editcont") && ($submode == "trader") )
				{
					$tab1 = "trader";
					$tab2 = "tr_cont";
				}
				else if( $mode == "editcont" )
				{
					//$tab1 = "comp";
					$tab1 = "pers";
					$tab2 = "comp_cont";
					//switch($submode)
					//{
					//	//
					//}						
				}
				else
				{
					//$tab1 = "comp";
					$tab1 = "pers";
					$tab2 = "comp_opts";
				}
				/*
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
				*/
				break;
				
			case "bcab_comp_trcont":
				$tab1 = "trader";
				$tab2 = "tr_cont";
				break;
				
			case "bcab_tarif_hist":
				$tab1 = "payments";
				$tab2 = "payhist";
				break;
			
			case "bcab_tarif_docs":
				$tab1 = "payments";
				$tab2 = "paydocs";
				break;
				
			case "bcab_addfund":
				$tab1 = "payments";
				$tab2 = "addfunds";
				break;
				
			case "bcab_tarif_plimit":
				$tab1 = "payments";
				$tab2 = "postlimit";
				break;
				
			case "bcab_tarif_prekl":
				$tab1 = "payments";
				$tab2 = "postrekl";
				break;
		}
		
		
		
		/////////////////////////////////////////////////////////////////
		// New menu version - same for all
		
		$show_company = ( isset($compinfo['id']) && ($compinfo['id'] != 0) );
		$show_trader_price_tab = ( isset($compinfo['id']) && ($compinfo['id'] != 0) && (($compinfo['trader'] != 0) || ($compinfo['trader2'] != 0)) );	
		
		$moderexist = User_GetModerNum($UserId);
		
		$LEFT_CAB_MENU = '<div class="ucab-nav">
		<ul class="ucab-menu">
		<li class="'.( $tab1 == "pers" ? 'ucab-menu-sel ' : '' ).'ucab-menu-inf"><div><a href="'.$WWWHOST.'bcab_personal.php">Профиль</a></div></li>
		<li class="'.( $tab1 == "board" ? 'ucab-menu-sel ' : '' ).'ucab-menu-board"><div><a class="tgm-btn-8" href="'.$WWWHOST.'bcab_posts.php?viewarc=0&viewtype=0&sortby=postid_down">Объявления</a></div></li>
		'.( false ? '<li class="'.( $tab1 == "comp" ? 'ucab-menu-sel ' : '' ).'ucab-menu-comp"><div><a href="'.$WWWHOST.'bcab_comp.php">Компания</a></div></li>' : '' ).'
		'.( $show_trader_price_tab ? '<li class="'.( $tab1 == "trader" ? 'ucab-menu-sel ' : '' ).'ucab-menu-inf"><div><a href="'.$WWWHOST.'bcab_prices.php">Цены трейдера</a></div></li>' : '' ).'
		<li class="'.( $tab1 == "payments" ? 'ucab-menu-sel ' : '' ).'ucab-menu-pays"><div><a href="'.$WWWHOST.'bcab_tarif_plimit.php">Тарифы</a></div></li>
		</ul>';
		
		if( $tab1 == "payments" )
		{
			$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">';
			
			$LEFT_CAB_MENU .= '<li'.( $tab2 == "postlimit" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_tarif_plimit.php">Лимит объявлений</a></li>
			<li'.( $tab2 == "postrekl" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_tarif_prekl.php">Улучшения объявлений</a></li>
			<li'.( $tab2 == "addfunds" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_addfund.php">Пополнить баланс</a></li>
			<li'.( $tab2 == "payhist" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_tarif_hist.php">История платежей</a></li>
			<li'.( $tab2 == "paydocs" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_tarif_docs.php">Счета/акты</a></li>
			</ul>';
		}
		else if( $tab1 == "pers" )
		{
			$moderexist = User_GetModerNum($UserId);				
			//echo "!!!".$moderexist."<br>";
		
			$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">';
			
			$LEFT_CAB_MENU .= '<li'.( $tab2 == "pers" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal.php">Авторизация</a></li>
			<li'.( ($tab2 == "pers_cont") || ($tab2 == "comp_cont") ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal_cont.php">Контакты</a></li>
			<li'.( $tab2 == "pers_subscr" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_subscr.php" title="Найстройки уведомлений">Уведомления</a></li>
			'.( $moderexist > 0 ? '<li'.( $tab2 == "pers_moder" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_modersel.php">Модератор</a></li>' : '' ).'
			<li'.( $tab2 == "pers_comment" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comment.php" title="Перейти к разделу комментариев">Отзывы</a></li>
			<li'.( $tab2 == "pers_msngr" ? ' class="sel"' : '' ).'><a class="tgm-btn-8-5" href="'.$WWWHOST.'bcab_msngr.php" title="Перейти в мессенджер">Мессенджер</a></li>			
			';
			
			$LEFT_CAB_MENU .= '
			<li'.( $tab2 == "comp_opts" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp_opts.php" title="Профиль компании">Компания</a></li>';
			
			if( $show_company && ($compinfo['vis'] > 0) )
			{			
				$LEFT_CAB_MENU .= '<li'.( $tab2 == "comp_index" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_index.php" title="Перейти к конструктору стартовой страницы компании">Конструктор</a></li>			
				'.( false ? '<li'.( ($tab2 == "comp_cont") && ($submode == "") ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcont" title="Перейти к контактам">Контакты</a></li>' : '' ).'
				'.( false ? '<li'.( ($tab2 == "comp_cont") && ($submode != "") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontmain" title="Перейти к контактам">Контакты</a></li>' : '' ).'
				'.( false ? '<li'.( ($tab2 == "comp_cont") || ($tab2 == "comp_cont_main") || ($tab2 == "comp_cont_otdel") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp_main.php" title="Перейти к контактам">Контакты</a></li>' : '' ).'
				'.( false ? '
				<li'.( ($tab2 == "comp_cont") && ($submode == "buy") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontbuy" title="Контакты отдела закупок">Отдел закупок</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "sell") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontsell" title="Контакты отдела продаж">Отдел продаж</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "serv") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontserv" title="Контакты отдела услуг">Отдел услуг</a></li>' : '' ).'
				'.( false ? '<li'.( $tab2 == "comp_about" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editabout" title="К разделу о компании">О компании</a></li>' : '' ).'
				<li'.( $tab2 == "comp_news" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_news.php" title="Перейти к разделу новости">Новости</a></li>
				<li'.( $tab2 == "comp_vacs" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_vac.php" title="Перейти к разделу вакансии">Вакансии</a></li>			
				<li'.( $tab2 == "comp_moder" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_moder.php" title="Перейти к разделу модераторов">Модераторы</a></li>
				';
			}
			
			//'.( $compinfo['trader'] == 0 ? '<li'.( $tab2 == "comp_msngr" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_msngr.php" title="Перейти к разделу мессенджера">Мессенджер</a></li>' : '' ).'
			//';			
			
			$LEFT_CAB_MENU .= '</ul>';			
			
			//if( ($tab1 == "pers") && ($tab2 == "comp_cont") && $show_company && ($submode != "") )
			if( ($tab1 == "pers") && ( ($tab2 == "pers_cont") || ($tab2 == "comp_cont") ) )
			{
				$LEFT_CAB_MENU .= '<div class="ucab-dopmenu">
				<ul>
				'.( false ? '<li'.( ($tab2 == "comp_cont") && ($submode == "main") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontmain">Главный офис</a></li>' : '' ).'
				'.( false ? '<li'.( ($tab2 == "comp_cont") && ($submode == "main") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp_main.php">Главный офис</a></li>' : '' ).'
				<li'.( ($tab2 == "pers_cont") && ($submode == "main") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_personal_cont.php">Главный офис</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "buy") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp_otdel.php?action=editcontbuy">Отдел закупок</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "sell") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp_otdel.php?action=editcontsell">Отдел продаж</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "serv") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp_otdel.php?action=editcontserv">Отдел услуг</a></li>
				</ul>
				<div class="both"></div>
				</div>';
			}
		}
		else if( $tab1 == "board" )
		{
			//$postnum_all = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ) );
			//$postnum_all = Board_PostsNumByAuthor($MenuUserId, "", -1, ( $viewarc == 0 ? 1 : 2 ) );
			$postnum_all = Board_PostsNumByAuthor($MenuUserId, "", -1, -10 );
			
			//$postnum_buy = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_BUY );
			//$postnum_sell = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SELL );
			//$postnum_serv = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SERV );
			//$postnum_buy = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, 0, $BOARD_PTYPE_BUY );
			//$postnum_sell = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, 0, $BOARD_PTYPE_SELL );
			//$postnum_serv = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, 0, $BOARD_PTYPE_SERV );
			$postnum_buy = Board_PostsNumByAuthor($MenuUserId, "", -1, 1, $BOARD_PTYPE_BUY );
			$postnum_sell = Board_PostsNumByAuthor($MenuUserId, "", -1, 1, $BOARD_PTYPE_SELL );
			$postnum_serv = Board_PostsNumByAuthor($MenuUserId, "", -1, 1, $BOARD_PTYPE_SERV );
			
			$postnum_bytype = Array($postnum_all, $postnum_buy, $postnum_sell, $postnum_serv);
			
			$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">'.( $tab1 == "board" ? '{BOARD_SUMMARY}' : '' );
			//$LEFT_CAB_MENU .= '<li'.($viewtype == 0 ? ' class="sel"' : '').'><a href="bcab_posts.php?viewarc='.$viewarc.'&viewtype=0&viewcomp=1&sortby='.$sortby_col.'_'.$sortby_order.'">Все </a> ('.$postnum_bytype[0].')</li>';
//            $COMP_ADV_TYPES['0'] = 'Все объявления';
            for( $i=1; $i<count($COMP_ADV_TYPES); $i++ )
			{
                $LEFT_CAB_MENU .= '<li'.($i == $viewtype ? ' class="sel"' : '').'><a '.($COMP_ADV_TYPES[$i] == 'Закупки' ? ' class="tgm-btn-8-1"' : ($COMP_ADV_TYPES[$i] == 'Товары' ? ' class="tgm-btn-8-2"' : ' class="tgm-btn-8-3"')).' href="bcab_posts.php?viewarc='.$viewarc.'&viewtype='.$i.( false ? '&viewcomp=1' : '').'&sortby='.$sortby_col.'_'.$sortby_order.'">'.$COMP_ADV_TYPES[$i].'</a>  ('.$postnum_bytype[$i].')</li>';
			}
			$LEFT_CAB_MENU .= '</ul>';
		}
		/*
		else if( $tab1 == "comp" )
		{
			$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">
			<li'.( $tab2 == "comp_index" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_index.php" title="Перейти к конструктору стартовой страницы компании">Конструктор</a></li>
			<li'.( $tab2 == "comp_opts" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp_opts.php" title="Перейти к настройкам">Настройки</a></li>
			'.( false ? '<li'.( ($tab2 == "comp_cont") && ($submode == "") ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcont" title="Перейти к контактам">Контакты</a></li>' : '' ).'
			'.( false ? '<li'.( ($tab2 == "comp_cont") && ($submode != "") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontmain" title="Перейти к контактам">Контакты</a></li>' : '' ).'
			<li'.( ($tab2 == "comp_cont") || ($tab2 == "comp_cont_main") || ($tab2 == "comp_cont_otdel") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp_main.php" title="Перейти к контактам">Контакты</a></li>
			'.( false ? '
			<li'.( ($tab2 == "comp_cont") && ($submode == "buy") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontbuy" title="Контакты отдела закупок">Отдел закупок</a></li>
			<li'.( ($tab2 == "comp_cont") && ($submode == "sell") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontsell" title="Контакты отдела продаж">Отдел продаж</a></li>
			<li'.( ($tab2 == "comp_cont") && ($submode == "serv") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontserv" title="Контакты отдела услуг">Отдел услуг</a></li>' : '' ).'
			'.( false ? '<li'.( $tab2 == "comp_about" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editabout" title="К разделу о компании">О компании</a></li>' : '' ).'
			<li'.( $tab2 == "comp_news" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_news.php" title="Перейти к разделу новости">Новости</a></li>
			<li'.( $tab2 == "comp_vacs" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_vac.php" title="Перейти к разделу вакансии">Вакансии</a></li>			
			<li'.( $tab2 == "comp_moder" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_moder.php" title="Перейти к разделу модераторов">Модераторы</a></li>
			'.( $compinfo['trader'] == 0 ? '<li'.( $tab2 == "comp_msngr" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_msngr.php" title="Перейти к разделу мессенджера">Мессенджер</a></li>' : '' ).'
			</ul>';
			
			if( ($tab1 == "comp") && ($tab2 == "comp_cont") && ($submode != "") )
			{
				$LEFT_CAB_MENU .= '<div class="ucab-dopmenu">
				<ul>
				'.( false ? '<li'.( ($tab2 == "comp_cont") && ($submode == "main") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontmain">Главный офис</a></li>' : '' ).'
				<li'.( ($tab2 == "comp_cont") && ($submode == "main") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp_main.php">Главный офис</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "buy") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp_otdel.php?action=editcontbuy">Отдел закупок</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "sell") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp_otdel.php?action=editcontsell">Отдел продаж</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "serv") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp_otdel.php?action=editcontserv">Отдел услуг</a></li>
				</ul>
				<div class="both"></div>
				</div>';
			}
		}
		*/
		else if( $tab1 == "trader" && $show_company && $show_trader_price_tab )
		{
			$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">';
			
			if( $compinfo['trader'] != 0 )
				$LEFT_CAB_MENU .= '<li'.( ($tab2 == "tr_prices") && ($acttype == 0) ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_prices.php" title="Перейти к таблицам цен трейдеров">Таблица закупок</a></li>';
			
			if( $compinfo['trader2'] != 0 )
				$LEFT_CAB_MENU .= '<li'.( ($tab2 == "tr_prices") && ($acttype == 1) ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_prices.php?acttype=1" title="Перейти к таблицам продаж трейдера">Таблица продаж</a></li>';
			
			$LEFT_CAB_MENU .= '<li'.( $tab2 == "tr_pricereport" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_pricetbls.php" title="Перейти к сравнению цен трейдеров">Сводные таблицы цен</a></li>
			'.( false ? '<li'.( $tab2 == "tr_msngr" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_msngr.php?viewdir=1" title="Перейти к разделу мессенджера">Мессенджер</a></li>' : '' ).'
			<li'.( $tab2 == "tr_cont" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp_trcont.php?action=editconttrader" title="Перейти к редактированию контактов трейдера">Контакты трейдера</a></li>
			</ul>';
		}
		
		
		$LEFT_CAB_MENU_NEW = $LEFT_CAB_MENU;
		
		
		
		if( ($UserModerateId == 0) && isset($compinfo['id']) && ($compinfo['id'] != 0) )
		{
			$compname = $compinfo['title'];
		
			//+++++++++++++++++++ MENU FOR COMPANY ++++++++++++++++++++++++++						
			
			//////////////////////////////////////////
			
			$moderexist = User_GetModerNum($UserId);
			
			$show_trader_price_tab = ( isset($compinfo['id']) && (($compinfo['trader'] != 0) || ($compinfo['trader2'] != 0)) );			
			//if( ($MenuUserId != 0) && ($UserModerateRules["price"] == 0) )
			//{
			//	$show_trader_price_tab = false;
			//}
			
			$LEFT_CAB_MENU = '<div class="ucab-nav">
				<ul class="ucab-menu">
				<li class="'.( $tab1 == "board" ? 'ucab-menu-sel ' : '' ).'ucab-menu-board"><div><a href="'.$WWWHOST.'bcab_posts.php?viewcomp=1">Объявления</a></div></li>				
				<li class="'.( $tab1 == "comp" ? 'ucab-menu-sel ' : '' ).'ucab-menu-comp"><div><a href="'.$WWWHOST.'bcab_comp.php">Компания</a></div></li>
				'.( $show_trader_price_tab ? '<li class="'.( $tab1 == "trader" ? 'ucab-menu-sel ' : '' ).'ucab-menu-inf"><div><a href="'.$WWWHOST.'bcab_prices.php">Цены трейдера</a></div></li>' : '' ).'
				</ul>';

			if( $tab1 == "pers" )
			{			
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">
				<li'.( $tab2 == "pers" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal.php">Регистрационные данные</a></li>
				<li'.( $tab2 == "pers_cont" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal_cont.php">Контакты</a></li>
				'.( $moderexist > 0 ? '<li'.( $tab2 == "pers_moder" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_modersel.php">Модератор</a></li>' : '' ).'
				</ul>';
			}
			else if( $tab1 == "board" )
			{
				$postnum_all = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ) );
				//$postnum_buy = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_BUY );
				//$postnum_sell = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SELL );
				//$postnum_serv = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SERV );
				$postnum_buy = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, 0, $BOARD_PTYPE_BUY );
				$postnum_sell = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, 0, $BOARD_PTYPE_SELL );
				$postnum_serv = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, 0, $BOARD_PTYPE_SERV );
				
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
				<li'.( ($tab2 == "comp_cont") && ($submode != "") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontmain" title="Перейти к контактам">Контакты</a></li>
				'.( false ? '
				<li'.( ($tab2 == "comp_cont") && ($submode == "buy") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontbuy" title="Контакты отдела закупок">Отдел закупок</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "sell") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontsell" title="Контакты отдела продаж">Отдел продаж</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "serv") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontserv" title="Контакты отдела услуг">Отдел услуг</a></li>' : '' ).'
				'.( false ? '<li'.( $tab2 == "comp_about" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editabout" title="К разделу о компании">О компании</a></li>' : '' ).'
				<li'.( $tab2 == "comp_news" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_news.php" title="Перейти к разделу новости">Новости</a></li>
				<li'.( $tab2 == "comp_vacs" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_vac.php" title="Перейти к разделу вакансии">Вакансии</a></li>
				<li'.( $tab2 == "pers_comment" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comment.php" title="Перейти к разделу комментариев">Отзывы</a></li>
				<li'.( $tab2 == "comp_moder" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_moder.php" title="Перейти к разделу модераторов">Модераторы</a></li>
				'.( $compinfo['trader'] == 0 ? '<li'.( $tab2 == "comp_msngr" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_msngr.php" title="Перейти к разделу мессенджера">Мессенджер</a></li>' : '' ).'
				</ul>';
			}
			else if( $tab1 == "trader" && isset($compinfo['id']) && (($compinfo['trader'] != 0) || ($compinfo['trader2'] != 0)) )
			{
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">';
				
				if( $compinfo['trader'] != 0 )
					$LEFT_CAB_MENU .= '<li'.( ($tab2 == "tr_prices") && ($acttype == 0) ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_prices.php" title="Перейти к таблицам цен трейдеров">Таблица закупок</a></li>';
				
				if( $compinfo['trader2'] != 0 )
					$LEFT_CAB_MENU .= '<li'.( ($tab2 == "tr_prices") && ($acttype == 1) ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_prices.php?acttype=1" title="Перейти к таблицам продаж трейдера">Таблица продаж</a></li>';
				
				$LEFT_CAB_MENU .= '<li'.( $tab2 == "tr_pricereport" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_pricetbls.php" title="Перейти к сравнению цен трейдеров">Сводные таблицы цен</a></li>
				<li'.( $tab2 == "tr_msngr" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_msngr.php?viewdir=1" title="Перейти к разделу мессенджера">Мессенджер</a></li>
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
				<li'.( ($tab2 == "comp_cont") && ($submode == "main") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontmain">Главный офис</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "buy") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontbuy">Отдел закупок</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "sell") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontsell">Отдел продаж</a></li>
				<li'.( ($tab2 == "comp_cont") && ($submode == "serv") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontserv">Отдел услуг</a></li>
				</ul>
				<div class="both"></div>
				</div>';
			}
		}
		else if( $UserModerateId != 0 )
		{
			$compname = ( isset($compinfo['id']) && ($compinfo['trader'] != 0) ? $compinfo['title'] : "" );
		
			//+++++++++++++++++++ MENU FOR COMPANY ++++++++++++++++++++++++++						
			
			//////////////////////////////////////////
			
			$show_trader_price_tab = ( isset($compinfo['id']) && ($compinfo['trader'] != 0) );			
			if( ($MenuUserId != 0) && ($UserModerateRules["price"] == 0) )
			{
				$show_trader_price_tab = false;
			}
			
			
			$board_url = '';
			if( ($MenuUserId != 0) && ($UserModerateRules["pbuy"] != 0) )
			{
				// Same url
				$board_url = $WWWHOST.'bcab_posts.php?viewcomp=1';
			}
			else if( ($MenuUserId != 0) && ($UserModerateRules["psell"] != 0) )				
			{
				$board_url = $WWWHOST.'bcab_posts.php?viewcomp=1&viewtype='.$BOARD_PTYPE_SELL;
			}
			else if( ($MenuUserId != 0) && ($UserModerateRules["pserv"] != 0) )				
			{
				$board_url = $WWWHOST.'bcab_posts.php?viewcomp=1&viewtype='.$BOARD_PTYPE_SERV;
			}
			
			$LEFT_CAB_MENU = '<div class="ucab-nav">
				<ul class="ucab-menu">
				<li class="'.( $tab1 == "pers" ? 'ucab-menu-sel ' : '' ).'ucab-menu-inf"><div><a href="'.$WWWHOST.'bcab_personal.php">Информация</a></div></li>
				'.( $board_url != '' ? '<li class="'.( $tab1 == "board" ? 'ucab-menu-sel ' : '' ).'ucab-menu-board"><div><a href="'.$board_url.'">Объявления</a></div></li>' : '' ).'
				<li class="'.( $tab1 == "comp" ? 'ucab-menu-sel ' : '' ).'ucab-menu-comp"><div><a href="'.$WWWHOST.'bcab_comp.php">Компания</a></div></li>
				</ul>';
			/*
			$LEFT_CAB_MENU = '<div class="ucab-nav">
				<ul class="ucab-menu">
				<li class="'.( $tab1 == "board" ? 'ucab-menu-sel ' : '' ).'ucab-menu-board"><div><a href="'.$WWWHOST.'bcab_posts.php?viewcomp=1">Торговая площадка</a></div></li>				
				<li class="'.( $tab1 == "comp" ? 'ucab-menu-sel ' : '' ).'ucab-menu-comp"><div><a href="'.$WWWHOST.'bcab_comp.php">Компания</a></div></li>
				'.( $show_trader_price_tab ? '<li class="'.( $tab1 == "trader" ? 'ucab-menu-sel ' : '' ).'ucab-menu-inf"><div><a href="'.$WWWHOST.'bcab_prices.php">Цены трейдера</a></div></li>' : '' ).'
				</ul>';
			*/
			
			//echo $tab1." ".$tab2."  -- ".$UserId." - ".$UserModerateId."<br>";

			if( $tab1 == "pers" )
			{		
				$moderexist = User_GetModerNum($UserId);				
				
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">
				<li'.( $tab2 == "pers" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal.php">Регистрационные данные</a></li>
				<li'.( $tab2 == "pers_cont" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal_cont.php">Контакты</a></li>
				'.( $moderexist > 0 ? '<li'.( $tab2 == "pers_moder" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_modersel.php">Модератор</a></li>' : '' ).'
				<li'.( $tab2 == "pers_comment" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comment.php" title="Перейти к разделу комментариев">Отзывы</a></li>
				</ul>';
			}
			else if( $tab1 == "board" )
			{
				$postnum_all = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ) );
				//$postnum_buy = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_BUY );
				//$postnum_sell = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SELL );
				//$postnum_serv = Board_PostsNumByAuthor($UserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SERV );
				$postnum_buy = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, 0, $BOARD_PTYPE_BUY );
				$postnum_sell = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, 0, $BOARD_PTYPE_SELL );
				$postnum_serv = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, 0, $BOARD_PTYPE_SERV );
				
				$postnum_bytype = Array($postnum_all, $postnum_buy, $postnum_sell, $postnum_serv);
				
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">'.( $tab1 == "board" ? '{BOARD_SUMMARY}' : '' );
				//$LEFT_CAB_MENU .= '<li'.($viewtype == 0 ? ' class="sel"' : '').'><a href="bcab_posts.php?viewarc='.$viewarc.'&viewtype=0&viewcomp=1&sortby='.$sortby_col.'_'.$sortby_order.'">Все </a> ('.$postnum_bytype[0].')</li>';
				for( $i=1; $i<count($COMP_ADV_TYPES); $i++ )
				{
					if( ($MenuUserId != 0) && ($UserModerateRules["pbuy"] == 0) && ($i == $BOARD_PTYPE_BUY) )
						continue;
					else if( ($MenuUserId != 0) && ($UserModerateRules["psell"] == 0) && ($i == $BOARD_PTYPE_SELL) )
						continue;
					else if( ($MenuUserId != 0) && ($UserModerateRules["pserv"] == 0) && ($i == $BOARD_PTYPE_SERV) )
						continue;

					$LEFT_CAB_MENU .= '<li'.($i == $viewtype ? ' class="sel"' : '').'><a href="bcab_posts.php?viewarc='.$viewarc.'&viewtype='.$i.'&viewcomp=1&sortby='.$sortby_col.'_'.$sortby_order.'">'.$COMP_ADV_TYPES[$i].'</a>  ('.$postnum_bytype[$i].')</li>';
				}
				$LEFT_CAB_MENU .= '</ul>';
			}
			else if( ($tab1 == "comp") || ($tab1 == "trader") )
			{
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">
				'.( false ? '
				<li'.( ($tab2 == "comp_cont") && ($submode != "") ? ' class="sel"' : "" ).'><a href="'.$WWWHOST.'bcab_comp.php?action=editcontbuy" title="Перейти к контактам отделов">Контакты отделов</a></li>
				<li'.( $tab2 == "comp_index" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_index.php" title="Перейти к конструктору стартовой страницы компании">Конструктор</a></li>				
				<li'.( $tab2 == "comp_news" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_news.php" title="Перейти к разделу новости">Новости</a></li>
				<li'.( $tab2 == "comp_vacs" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_vac.php" title="Перейти к разделу вакансии">Вакансии</a></li>
				<li'.( $tab2 == "comp_msngr" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_msngr.php" title="Перейти в мессенджер">Мессенджер</a></li>' : '' ).'
				';
				
				if( isset($compinfo['id']) && ($compinfo['trader'] != 0) )
				{
					$LEFT_CAB_MENU .= '<li'.( $tab2 == "tr_prices" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_prices.php" title="Перейти к таблицам цен трейдеров">Таблицы цен</a></li>
					<li'.( $tab2 == "tr_pricereport" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_pricetbls.php" title="Перейти к сравнению цен трейдеров">Сводные таблицы закупок</a></li>';
				}
				
				if( $UserModerateRules["msngr"] != 0 )
				{
					$LEFT_CAB_MENU .= '<li'.( $tab2 == "comp_msngr" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_msngr.php" title="Перейти в мессенджер">Мессенджер</a></li>';
				}
				
				$LEFT_CAB_MENU .= '</ul>';
			}			
			else
			{
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub"><li>&nbsp;</li></ul>';
			}
			
			$LEFT_CAB_MENU .= '</div>';
			
			/*
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
			*/
		}
		else
		{
			//echo "334455 - Person<br>";
			
			//+++++++++++++++++++ MENU FOR PERSON ++++++++++++++++++++++++++			
			
			$LEFT_CAB_MENU = '<div class="ucab-nav">
				<ul class="ucab-menu">
				<li class="'.( $tab1 == "pers" ? 'ucab-menu-sel ' : '' ).'ucab-menu-inf"><div><a href="'.$WWWHOST.'bcab_personal.php">Информация</a></div></li>
				<li class="'.( $tab1 == "board" ? 'ucab-menu-sel ' : '' ).'ucab-menu-board"><div><a href="'.$WWWHOST.'bcab_posts.php">Объявления</a></div></li>
				<li class="'.( $tab1 == "newcomp" ? 'ucab-menu-sel ' : '' ).'ucab-menu-comp-pers"><div><a href="'.$WWWHOST.'bcab_comp.php">Компания</a></div></li>				
				</ul>';

			if( $tab1 == "pers" )
			{			
				$moderexist = User_GetModerNum($UserId);				
				//echo "!!!".$moderexist."<br>";
		
				$LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">
				<li'.( $tab2 == "pers" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal.php">Регистрационные данные</a></li>
				<li'.( $tab2 == "pers_cont" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_personal_cont.php">Контакты</a></li>
				'.( $moderexist > 0 ? '<li'.( $tab2 == "pers_moder" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_modersel.php">Модератор</a></li>' : '' ).'
				<li'.( $tab2 == "pers_comment" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_comment.php" title="Перейти к разделу комментариев">Отзывы</a></li>
				<li'.( $tab2 == "pers_msngr" ? ' class="sel"' : '' ).'><a href="'.$WWWHOST.'bcab_msngr.php" title="Перейти в мессенджер">Мессенджер</a></li>
				</ul>';
			}
			else if( $tab1 == "board" )
			{
				$postnum_all = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ) );
				$postnum_buy = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_BUY );
				$postnum_sell = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SELL );
				$postnum_serv = Board_PostsNumByAuthor($MenuUserId, "", $viewcomp, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SERV );
				
				$postnum_bytype = Array($postnum_all, $postnum_buy, $postnum_sell, $postnum_serv);

                $LEFT_CAB_MENU .= '<ul class="ucab-menu-sub">' .( $tab1 == "board" ? '{BOARD_SUMMARY}' : '' );
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
	
	if( $UserId != 0 )
	{
		$buyer_bal = Buyer_Balance($UserId);
		
		//echo '';

		$LEFT_CAB_MENU_NEW = '<div class="ucab-owner">
			<div class="ucab-owner-balance">Ваш баланс: '.number_format($buyer_bal, 2, ".", "").' '.$CURRENCY_NAME.'<div><a href="'.$WWWHOST.'bcab_addfund.php" class="btn btn-sm btn-green">Пополнить баланс</a></div></div><span>
			'.$ownername.( isset($compinfo['id']) && ($compinfo['id'] != 0) ? ' ID-'.$compinfo['id'] : '' ).'</span>
		</div>'.$LEFT_CAB_MENU_NEW;
	}
	
	
	//$LEFT_CAB_MENU = $LEFT_CAB_MENU_NEW."<br>".$LEFT_CAB_MENU;
	$LEFT_CAB_MENU = $LEFT_CAB_MENU_NEW;
		
	if( isset($compinfo['id']) && ($compinfo['id'] != 0) && ($compinfo['vis'] == 0) )
	{
		$LEFT_CAB_MENU .= '<div class="ucab-notif">У вас есть компания, но в данный момент она отключена и не показывается.</div>';
	}	
	
	$MSNGR_CAB_NOTIFY_HTML = '';
	if( ($UserId != 0) && isset($compinfo['id']) && ($compinfo['id'] != 0) && ($compinfo['trader'] != 0) )
	{
		$msngr_new_num = 0;
		if( $compinfo['id'] != 0 )							
			$msngr_new_num = Msngr_ReqNum($LangId, $compinfo['id'], 0, 0 );	// Show only new
		
		if( $msngr_new_num > 0 )
		{
			$MSNGR_CAB_NOTIFY_HTML = '<div class="ucab-notif">
				<div class="ucab-notif-in"><div class="ucab-notif-btn"><a href="'.$WWWHOST.'bcab_msngr.php?viewdir=1" class="btn btn-light">Посмотреть сейчас</a></div><p><b>Мессенджер:</b> Вам поступило <span><a href="'.$WWWHOST.'bcab_msngr.php?viewdir=1">'.$msngr_new_num.' '.( $msngr_new_num > 1 ? 'новых предложения' : 'новое предложение' ).'</a></span></p></div>
			</div>';
		}
	}
?>