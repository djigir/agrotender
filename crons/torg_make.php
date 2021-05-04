<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////

chdir(__DIR__);

	////////////////////////////////////////////////////////////////////////////
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";
	include "../inc/utils-inc.php";

	include "../inc/torgutils-inc.php";

	$continfo = Contacts_Get($LangId);

	////////////////////////////////////////////////////////////////////////////
	// Select all currently ended torgs and find winner
	$its = Array();

	$query = "SELECT i1.*, i2.descr, p1.icon_filename, p2.type_name, r1.id as rayon_id, r1.obl_id, r2.name as rayon,
			DATE_FORMAT(dt_start,'%d.%m.%Y') as dtst, DATE_FORMAT(dt_end,'%d.%m.%Y') as dten
		FROM $TABLE_TORG_ITEMS i1
		INNER JOIN $TABLE_TORG_ITEM2RAY i2i ON i1.id=i2i.item_id
		INNER JOIN $TABLE_TORG_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
		INNER JOIN $TABLE_TORG_PROFILE p1 ON i1.profile_id=p1.id
		INNER JOIN $TABLE_TORG_PROFILE_LANGS p2 ON p1.id=p2.profile_id AND p2.lang_id='$LangId'
		INNER JOIN $TABLE_RAYON r1 ON i2i.ray_id=r1.id
		INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		WHERE i1.dt_end<NOW() AND i1.status=0
		";

	//echo $query."<br />";

	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['status'] = $row->status;
			$it['torg_type'] = $row->torg_type;
			$it['amount'] = $row->amount;
			$it['cost'] = $row->cost;
			$it['st'] = $row->dt_start;
			$it['en'] = $row->dt_end;
			$it['dtst'] = $row->dtst;
			$it['dten'] = $row->dten;
			$it['descr'] = stripslashes($row->descr);
			$it['cultname'] = stripslashes($row->type_name);
			$it['cultico'] = ( stripslashes($row->icon_filename) != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->icon_filename) : '' );
			$it['cultico_rel'] = stripslashes($row->icon_filename);
			$it['rayon'] = stripslashes($row->rayon);
			$it['ray_id'] = $row->rayon_id;
			$it['obl_id'] = $row->obl_id;

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	//-------------------------------
	for( $bi=0; $bi<count($its); $bi++ )
	{
		echo "ID: ".$its[$bi]['id']." - ".$REGIONS[$its[$bi]['obl_id']].", ".$its[$bi]['rayon']." - ".$its[$bi]['cultname'].", с ".$its[$bi]['dtst']." по ".$its[$bi]['dten']."<br />";

		// Now we should find winners
		$bids = TorgItem_Bids( $LangId, $its[$bi]['id'] );

		// Find different buyer indexes
		$buyerindex = Array();
		$bindex = 0;
		for( $i=0; $i<count($bids); $i++ )
		{
			// Check if there is bid from this buyer earlier
			if( empty($buyerindex[$bids[$i]['buyer_id']]) )
			{
				$bindex++;
				$buyerindex[$bids[$i]['buyer_id']] = $bindex;
			}
		}

		// Find the bids, which could win this lot
		$amount_ost_tmp = $its[$bi]['amount'];
		$win_bids = Array();
		$win_num = 0;

		$winner_cont_msg = "";

		$LOT_URL = TorgItem_BuildUrl( $LangId, $its[$bi]['id'], $its[$bi]['id'], $REGIONS_URL[$its[$bi]['obl_id']] );
		$CUR_TORG = Torg_LotInfo($LangId, $its[$bi]['id'], "buyer");

		for( $i=(count($bids)-1); $i>=0; $i-- )
		{
			if( $amount_ost_tmp > 0 )
			{
				$win_bids[$bids[$i]['id']] = true;
				$win_amount = ( $amount_ost_tmp >= $bids[$i]['amount'] ? $bids[$i]['amount'] : $amount_ost_tmp );
				$amount_ost_tmp -= $bids[$i]['amount'];

				// One winner found, so check if it full win or partly win
				$query = "UPDATE $TABLE_TORG_BIDS SET win_amount='$win_amount', bid_status='".$BID_STATUS_WIN."', win_date=NOW() WHERE id='".$bids[$i]['id']."'";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}

            	// Send email to torg publisher if he get new proposal
            	//$CUR_TORG = $its[$bi];
            	$binfo = Torg_BuyerInfo($LangId, $bids[$i]['buyer_id']);
            	sendMail_YouWin($binfo['login'], "", $bids[$i]['price'], $win_amount, $CUR_TORG, $LOT_URL);

            	$winner_cont_msg .= "«".$CUR_TORG['cult_name']."» объёмом – «".$win_amount."» т. по «".$bids[$i]['price']."» грн.
Название: «".$binfo['orgname']."»
Контактное лицо: «".$binfo['name']."»
Телефон: «".$binfo['phone']."»
E-mail адрес: «".$binfo['email']."»

";

				$win_num++;
			}
			else
			{
				$win_bids[$bids[$i]['id']] = false;
			}
		}

		// The winners are found, so close the torg and set the winners
		$query = "UPDATE $TABLE_TORG_ITEMS SET status='".( $win_num > 0 ? $TORG_STATUS_FINISH : $TORG_STATUS_CLOSE)."' WHERE id='".$its[$bi]['id']."'";
		if( !mysqli_query($upd_link_db, $query ) )
		{
			echo mysqli_error($upd_link_db);
		}

		sendMail_EndTorgForOwner($CUR_TORG['buyer']['login'], "", $CUR_TORG, $LOT_URL, $winner_cont_msg);
	}

	////////////////////////////////////////////////////////////////////////////


	include "../inc/close-inc.php";

?>