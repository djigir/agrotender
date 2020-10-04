<?php

chdir(__DIR__);

	////////////////////////////////////////////////////////////////////////////
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";
	include "../inc/utils-inc.php";

	include "../inc/torgutils-inc.php";

	$continfo = Contacts_Get($LangId);
	$txt_res = Resources_Get($LangId);

	$BOARD_PERONCE = 50;
	$BOARD_MONTHOLD = 5;
	$BOARD_NOTIFYDAYS = 3;

	$updt_ses_guid = makeUuid();

	// Get all trader list
	$cclist0 = Array();
	$ccbids0 = Array();
	$query = "SELECT * FROM $TABLE_COMPANY_ITEMS WHERE trader_price_avail=1";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ccit = Array();
			$ccit['id'] = $row->id;
			$ccit['buyer_id'] = $row->author_id;
			$ccit['name'] = stripslashes($row->title);

			$ccbids0[] = $row->author_id;

			$cclist0[] = $ccit;
		}
		mysqli_free_result($res);
	}

	$cclist1 = Array();
	$ccbids1 = Array();
	$query = "SELECT * FROM $TABLE_COMPANY_ITEMS WHERE trader_price_sell_avail=1";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ccit = Array();
			$ccit['id'] = $row->id;
			$ccit['buyer_id'] = $row->author_id;
			$ccit['name'] = stripslashes($row->title);

			$ccbids1[] = $row->author_id;

			$cclist1[] = $ccit;
		}
		mysqli_free_result($res);
	}

	//echo "<br><b>Р—РђРєСѓРїРєРё</b><br>";
	//var_dump($cclist0);
	//echo "<br><br>";

	//echo "<br><b>РџСЂРѕРґР°Р¶Рё</b><br>";
	//var_dump($cclist1);
	//echo "<br><br>";

	$query1 = "UPDATE $TABLE_TRADER_PR_PRICES SET active=1 WHERE buyer_id IN (".implode(",", $ccbids0).") AND acttype=0";
	if( !mysqli_query($upd_link_db, $query1 ) )
	{
		echo mysqli_error($upd_link_db);
	}
	$query1 = "UPDATE $TABLE_TRADER_PR_PRICES SET active=0 WHERE buyer_id NOT IN (".implode(",", $ccbids0).") AND acttype=0";
	if( !mysqli_query($upd_link_db, $query1 ) )
	{
		echo mysqli_error($upd_link_db);
	}

	$query1 = "UPDATE $TABLE_TRADER_PR_PRICES SET active=1 WHERE buyer_id IN (".implode(",", $ccbids1).") AND acttype=1";
	if( !mysqli_query($upd_link_db, $query1 ) )
	{
		echo mysqli_error($upd_link_db);
	}
	$query1 = "UPDATE $TABLE_TRADER_PR_PRICES SET active=0 WHERE buyer_id NOT IN (".implode(",", $ccbids1).") AND acttype=1";
	if( !mysqli_query($upd_link_db, $query1 ) )
	{
		echo mysqli_error($upd_link_db);
	}

	/*
	$numtoremove = 0;

	//$query = "SELECT * FROM $TABLE_TRADER_PR_PRICES
	//	WHERE active=1 AND acttype=0
	//	ORDER BY buyer_id, cult_id, curtype, place_id
	//	LIMIT 2000,500";
	$query = "SELECT * FROM $TABLE_TRADER_PR_PRICES
		ORDER BY buyer_id, cult_id, curtype, place_id
		LIMIT 5200,400";
	//$query = "SELECT * FROM $TABLE_TRADER_PR_PRICES WHERE id=9388
	//	ORDER BY buyer_id, cult_id, curtype, place_id";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$totrecords = 0;
			$query1 = "SELECT count(*) as totnum FROM $TABLE_TRADER_PR_PRICESARC WHERE buyer_id='".$row->buyer_id."' AND cult_id='".$row->cult_id."' AND curtype='".$row->curtype."' AND place_id='".$row->place_id."' AND acttype='".$row->acttype."'";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$totrecords = $row1->totnum;
				}
				mysqli_free_result( $res1 );
			}


			echo "<b>РќРѕРІР°СЏ С†РµРЅР°: ".$row->id."</b> - РІ Р±Р°Р·Рµ ".$totrecords." Р·Р°РїРёСЃРµР№<br>";
			$prevpr = 0;
			$prevprnum = 0;
			$totalpr = 0;
			$iind = 0;

			$ids_rem = Array();

			$query1 = "SELECT * FROM $TABLE_TRADER_PR_PRICESARC WHERE buyer_id='".$row->buyer_id."' AND cult_id='".$row->cult_id."' AND curtype='".$row->curtype."' AND place_id='".$row->place_id."' AND acttype='".$row->acttype."' ORDER BY dt";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				while( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$iind++;
					//echo $iind.",,";
					$pr_id = $row1->id;
					if( $prevpr != $row1->costval )
					{
						echo $prevprnum.": ".$prevpr.", ";
						$prevpr = $row1->costval;
						$totalpr++;

						$numtoremove += ( $prevprnum>5 ? ($prevprnum - 5) : 0 );

						//unset($ids_rem);
						//$ids_rem = Array();

						$prevprnum = 0;
					}
					$prevprnum++;
					if( $prevprnum > 5 )
					{
						$ids_rem[] = $row1->id;
					}
				}
				mysqli_free_result( $res1 );
			}

			echo $prevprnum.": ".$prevpr.", ";
			$numtoremove += ( $prevprnum>5 ? ($prevprnum - 5) : 0 );

			echo "<br>Р’СЃРµРіРѕ С†РµРЅ: ".$totalpr.", РЈРґР°Р»РёС‚СЊ Р·Р°РїРёСЃРµР№: ".count($ids_rem).", ";
			echo "ID СѓРґР°Р»РёС‚СЊ = ".implode(",", $ids_rem)."<br>";

			if( count($ids_rem) > 0 )
			{
				$query2 = "DELETE FROM $TABLE_TRADER_PR_PRICESARC WHERE id IN (".implode(",", $ids_rem).")";
				echo $query2."<br>";
				if( !mysqli_query($upd_link_db, $query2 ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
		}
	}

	echo "<br><br>РЈРґР°Р»РёС‚СЊ РІСЃРµРіРѕ ".$numtoremove." Р·Р°РїРёСЃРµР№<br><br>";

	exit();
	*/


	$query = "SELECT * FROM $TABLE_TRADER_PR_PRICES WHERE active=1";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$pr_id = 0;

			$query1 = "SELECT * FROM $TABLE_TRADER_PR_PRICESARC WHERE buyer_id='".$row->buyer_id."' AND cult_id='".$row->cult_id."' AND curtype='".$row->curtype."' AND place_id='".$row->place_id."' AND acttype='".$row->acttype."' AND dt=DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$pr_id = $row1->id;
				}
				mysqli_free_result( $res1 );
			}

			if( $pr_id == 0 )
			{
				//echo "!";
				$query1 = "INSERT INTO $TABLE_TRADER_PR_PRICESARC (buyer_id, cult_id, place_id, curtype, acttype, active, costval, add_date, dt)
					VALUES ('".$row->buyer_id."', '".$row->cult_id."', '".$row->place_id."', '".$row->curtype."', '".$row->acttype."', '1', '".str_replace(",", ".", $row->costval)."', '".$row->add_date."', DATE_SUB(CURDATE(), INTERVAL 1 DAY))";
				if( !mysqli_query($upd_link_db, $query1 ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
			else
			{
				$query1 = "UPDATE $TABLE_TRADER_PR_PRICESARC SET costval='".str_replace(",", ".", $row->costval)."', add_date='".$row->add_date."' WHERE id=".$pr_id;
				if( !mysqli_query($upd_link_db, $query1 ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}

			$pr2_id = 0;
			$query1 = "SELECT * FROM $TABLE_TRADER_PR_PRICESARC WHERE buyer_id='".$row->buyer_id."' AND cult_id='".$row->cult_id."' AND curtype='".$row->curtype."' AND place_id='".$row->place_id."' AND acttype='".$row->acttype."' AND dt=CURDATE()";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$pr2_id = $row1->id;
				}
				mysqli_free_result( $res1 );
			}


			if( $pr2_id == 0 )
			{
				//echo "!";
				$query1 = "INSERT INTO $TABLE_TRADER_PR_PRICESARC (buyer_id, cult_id, place_id, curtype, acttype, active, costval, add_date, dt)
					VALUES ('".$row->buyer_id."', '".$row->cult_id."', '".$row->place_id."', '".$row->curtype."', '".$row->acttype."', '1', '".str_replace(",", ".", $row->costval)."', '".$row->add_date."', CURDATE())";
				if( !mysqli_query($upd_link_db, $query1 ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
			else
			{
				$query1 = "UPDATE $TABLE_TRADER_PR_PRICESARC SET costval='".str_replace(",", ".", $row->costval)."', add_date='".$row->add_date."' WHERE id=".$pr2_id;
				if( !mysqli_query($upd_link_db, $query1 ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
		}
		mysqli_free_result( $res );
	}

	include "../inc/close-inc.php";

?>