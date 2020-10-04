<?php

chdir(__DIR__);

	////////////////////////////////////////////////////////////////////////////
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";
	include "../inc/utils-inc.php";

	//include "../inc/torgutils-inc.php";
	
	include "../inc5/trader-utils-inc.php";

	$continfo = Contacts_Get($LangId);
	$txt_res = Resources_Get($LangId);

	//$BOARD_PERONCE = 50;
	//$BOARD_MONTHOLD = 5;
	//$BOARD_NOTIFYDAYS = 7;
	
	$period_mode = GetParameter("period", 24);
	//if( $period_mode != 24 )
	//	$period_mode = 1;
	
	$BOARD_DEACT_DAY_PERIOD = intval($PREFS['BOARD_DEACTPERIOD']);
	
	echo "Go<br>";
	
	////////////////////////////////////////////////////////////////////////////
	$recvlist = Array();
	
	echo "!";
	
	$query = "SELECT c1.id as cult_id, c1.url as cult_url, c2.name as cult_name, tr1.id as traderid, tr1.name as trader, f1.title as compname, b1.name as uname, b1.login as uemail, b1.guid_deact  
		FROM $TABLE_BUYER_SUBSCR_TRPR sub1 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON sub1.buyer_id=b1.id 
		INNER JOIN $TABLE_TRADER_PR_CULTS c1 ON sub1.cult_id=c1.id 
		INNER JOIN $TABLE_TRADER_PR_CULTS_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId' 
		INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON sub1.cult_id=pr1.cult_id AND pr1.active=1 AND pr1.change_date>DATE_SUB(NOW(), INTERVAL $period_mode HOUR) 
		INNER JOIN $TABLE_TORG_BUYERS tr1 ON pr1.buyer_id=tr1.id 
		INNER JOIN $TABLE_COMPANY_ITEMS f1 ON tr1.id=f1.author_id 
		WHERE sub1.period='".($period_mode)."' AND sub1.is_active=1 and (f1.trader_price_avail or f1.trader_price_sell_avail)
		GROUP BY c1.id, b1.id, tr1.id";



	
	
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$semail = stripslashes($row->uemail);

			if( $semail == "" )	continue;
			
			//if( $row->subscr_adv_deact == 0 )
			//	continue;

			if( empty($recvlist[$semail]) )
			{
				$recvlist[$semail] = Array("isregged" => true, "email" => $semail, "author" => stripslashes($row->uname), "guid_deact" => stripslashes($row->guid_deact), "cults" => Array());
			}
			
			if( empty($recvlist[$semail]['cults'][$row->cult_id]) )
				$recvlist[$semail]['cults'][$row->cult_id] = Array("cult_id" => $row->cult_id, "url" => stripslashes($row->cult_url), "name" => stripslashes($row->cult_name), "traders" => Array());
			
			$recvlist[$semail]['cults'][$row->cult_id]['traders'][] = Array("title" => stripslashes($row->compname));
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);	
	
	
	include "../uhlibs/unisend/inc/unisender-init.php";
	
	
	echo "!!!<br>";
	
	
	echo "<pre>";
	
	echo "Start Send<br>";

	// Make sending
	foreach($recvlist as $se => $binf)
	{
		$cults = $binf['cults'];

		echo "send to ".$binf['email']." - ".count($cults)." культур<br />";
		
		$dt_send_all = ( $period_mode == 24 ? date("d.m.Y", time()) : date("H:i d.m.Y", time()) );
		
		///////////////////////////////////////////////////////////////////
		// Send mail through unisender
			
		$body_data = array(
			"{FULL_NAME}" => $binf['author'],
			"{PERIOD}" => $BOARD_DEACT_DAY_PERIOD." дней",
			"{DATE_TIME}" => $dt_send_all,
			"{URL_UNSUBSCRIBE}" => $WWWHOST."u/notify",	// !!!!!!!!!!!!!!!!!! //"http://example.com",
			"{ARR_TPL_ITEMS_LIST}" => Array(),
			/*
			"{ARR_TPL_ADS}" => array(
				array(
					"{AD_NAME}" => "РљСѓРїР»СЋ Р·РµСЂРЅРѕСЂСѓР±РѕС‡РЅС‹Р№ РєРѕРјР±Р°Р№РЅ Р±Сѓ СЃ Р“РµСЂРјР°РЅРёРё",
					"{URL_ACTIVATE}" => "http://example.com",
				),
				array(
					"{AD_NAME}" => "РџСЂРѕРґР°С‚СЊ РїС€РµРЅРёС†Сѓ 6 РєР»Р°СЃСЃР° РЅР° СЌР»РµРІР°С‚РѕСЂРµ",
					"{URL_ACTIVATE}" => "http://example.com",
				),
			),
			*/
		);
		
		//for( $i=0; $i<count($cults); $i++ )
		foreach( $cults as $cultid => $cultitem )
		{
			echo $cultitem['name']." == ".$cultitem['url']."<br />";
			
			$tr_names = "";
			for( $j=0; $j<count($cultitem['traders']); $j++ )
			{
				$tr_names .= ($tr_names != "" ? ", " : "").'<b>'.$cultitem['traders'][$j]['title'].'</b>';				
			}
			
			$URL = Trader_BuildUrl(0, "", "", $cultitem['url'], "", "", "", -2, true );
			$URL = $URL.( strpos($URL, "?") > 0 ? "&" : "?" )."viewmod=tbl";
			
			$body_data["{ARR_TPL_ITEMS_LIST}"][] = array(
				"{ITEM_NAME}" 		=> $cultitem['name'],
				"{URL_TRAIDER}"		=> $URL,
				"{TRAIDERS_LIST}"	=> $tr_names,
			);

			/*
			$body_data["{ARR_TPL_ITEMS_LIST}"][] = array(
				"{ITEM_NAME}" => $cultitem['name'],
				"{ARR_TPL_TRAIDERS_LIST}" => array(),				
			);
			
			$URL = Trader_BuildUrl(0, "", "", $cultitem['url'], "", "", "", -2, true );
			$URL = $URL.( strpos($URL, "?") > 0 ? "&" : "?" )."viewmod=tbl";
			
			for( $j=0; $j<count($cultitem['traders']); $j++ )
			{
				$body_data["{ARR_TPL_ITEMS_LIST}"][count($body_data["{ARR_TPL_ITEMS_LIST}"])-1]["{ARR_TPL_TRAIDERS_LIST}"][] = array(
						"{TRAIDER_NAME}"    => $cultitem['traders'][$j]['title'],
						"{URL_TRAIDER}"       => $URL,
				);
			}
			*/
		}
		
		//echo "<br>";
		//var_dump($body_data);
		//echo "<br><br>";
        Send_UniSenderMail($binf['email'], $binf['author'], "Изменения цен трейдеров за ".$dt_send_all, MAIL_TPL_TRADER_SUBSCRIBE, $body_data);
		////////////////////////////////////////////////////////////////////
	
	}
	
	echo "Done All<br>";
	

	////////////////////////////////////////////////////////////////////////////
	include "../inc/close-inc.php";

?>