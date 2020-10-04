<?php

chdir(__DIR__);

	////////////////////////////////////////////////////////////////////////////
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";
	include "../inc/utils-inc.php";

	include "../inc/torgutils-inc.php";

	$DAYS_HISTORY = 30;
	$DAYS_HISTORY_TRADER = 183;

	$DAYS_HISTORY_COMPANY = 365;

	////////////////////////////////////////////////////////////////////////////
	// Delete all old statistics
	$query = "DELETE FROM $TABLE_COMPANY_RATE WHERE dt < DATE_SUB(NOW(), INTERVAL ".$DAYS_HISTORY_COMPANY." DAY)";
	if( !mysqli_query($upd_link_db, $query ) )
	{
		echo mysqli_error($upd_link_db);
	}

	////////////////////////////////////////////////////////////////////////////
	// Update Product Views Rating
	$query = "SELECT * FROM $TABLE_COMPANY_ITEMS";
	if( $res = mysqli_query($upd_link_db, $query ) )	{

		while( $row = mysqli_fetch_object( $res ) )
		{
			$item_id = $row->id;

			// calculate week rate
			$new_rate = 0;
			$query1 = "SELECT sum(amount) as total_rate FROM $TABLE_COMPANY_RATE WHERE item_id=".$item_id." AND dt > DATE_SUB(NOW(), INTERVAL ".$DAYS_HISTORY_COMPANY." DAY)";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$new_rate = $row1->total_rate;
				}
				mysqli_free_result( $res1 );
			}

			$query1 = "UPDATE $TABLE_COMPANY_ITEMS SET rate='".$new_rate."' WHERE id=".$item_id;
			if( !mysqli_query($upd_link_db, $query1 ) )
			{
				echo mysqli_error($upd_link_db);
			}
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);


	////////////////////////////////////////////////////////////////////////////
	// Delete all old statistics
	$query = "DELETE FROM $TABLE_TRADER_RATE WHERE dt < DATE_SUB(NOW(), INTERVAL ".$DAYS_HISTORY_TRADER." DAY)";
	if( !mysqli_query($upd_link_db, $query ) )
	{
		echo mysqli_error($upd_link_db);
	}

	////////////////////////////////////////////////////////////////////////////
	// Update Product Views Rating
	$query = "SELECT * FROM $TABLE_TRADER";
	if( $res = mysqli_query($upd_link_db, $query ) )	{

		while( $row = mysqli_fetch_object( $res ) )
		{
			$item_id = $row->id;

			// calculate week rate
			$new_rate = 0;
			$query1 = "SELECT sum(amount) as total_rate FROM $TABLE_TRADER_RATE WHERE item_id=".$item_id." AND dt > DATE_SUB(NOW(), INTERVAL ".$DAYS_HISTORY_TRADER." DAY)";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$new_rate = $row1->total_rate;
				}
				mysqli_free_result( $res1 );
			}

			$query1 = "UPDATE $TABLE_TRADER SET rate='".$new_rate."' WHERE id=".$item_id;
			if( !mysqli_query($upd_link_db, $query1 ) )
			{
				echo mysqli_error($upd_link_db);
			}
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);



	////////////////////////////////////////////////////////////////////////////
	// Delete all old statistics
	$query = "DELETE FROM $TABLE_TORG_ITEMS_RATE WHERE dt < DATE_SUB(NOW(), INTERVAL ".$DAYS_HISTORY." DAY)";
	if( !mysqli_query($upd_link_db, $query ) )
	{
		echo mysqli_error($upd_link_db);
	}

	////////////////////////////////////////////////////////////////////////////
	// Update Product Views Rating
	$query = "SELECT * FROM $TABLE_TORG_ITEMS";
	if( $res = mysqli_query($upd_link_db, $query ) )	{

		while( $row = mysqli_fetch_object( $res ) )
		{
			$item_id = $row->id;

			// calculate week rate
			$new_rate = 0;
			$query1 = "SELECT sum(amount) as total_rate FROM $TABLE_TORG_ITEMS_RATE WHERE item_id=".$item_id." AND dt > DATE_SUB(NOW(), INTERVAL ".$DAYS_HISTORY." DAY)";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$new_rate = $row1->total_rate;
				}
				mysqli_free_result( $res1 );
			}

			$query1 = "UPDATE $TABLE_TORG_ITEMS SET item_rate='".$new_rate."' WHERE id=".$item_id;
			if( !mysqli_query($upd_link_db, $query1 ) )
			{
				echo mysqli_error($upd_link_db);
			}
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	////////////////////////////////////////////////////////////////////////////
	// Trader/Buyer rating
	$query = "UPDATE $TABLE_TORG_BUYERS SET rate=0 WHERE isactive=0 OR isactive_web=0";
	if( !mysqli_query($upd_link_db, $query ) )
	{
		echo mysqli_error($upd_link_db);
	}

	$query = "SELECT * FROM $TABLE_TORG_BUYERS WHERE isactive=1 AND isactive_web=1";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
   			$tot_torg_fin = Torg_LotsByOwnerNum($LangId, $row->id, 0, "finished");
   			$tot_torg_cur = Torg_LotsByOwnerNum($LangId, $row->id, 0, "current");
   			$tot_torg_latest = Torg_LotsByOwnerNum($LangId, $row->id, 0, "lastmonth");

   			$brate = ($tot_torg_fin + $tot_torg_cur*2 + $tot_torg_latest*3);

   			$query1 = "UPDATE $TABLE_TORG_BUYERS SET rate='".$brate."' WHERE id=".$row->id;
			if( !mysqli_query($upd_link_db, $query1 ) )
			{
				echo mysqli_error($upd_link_db);
			}
		}
		mysqli_free_result( $res );
	}

	////////////////////////////////////////////////////////////////////////////
	// Update elavator rating
	//   formala: rate = ( "all lots num" + "win lots num"*2 + "active lots num"*3 );
	$query = "SELECT * FROM $TABLE_TORG_ELEV";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$lot_tot = 0;
			$lot_win = 0;
			$lot_act = 0;

			// All lots
			$query1 = "SELECT count(*) as totlots FROM $TABLE_TORG_ITEM2ELEV i2e
				INNER JOIN $TABLE_TORG_ITEMS i1 ON i2e.item_id=i1.id AND i1.active=1
				WHERE i2e.elev_id=".$row->id;
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$lot_tot = $row1->totlots;
				}
				mysqli_free_result( $res1 );
			}

			// All win lots
			$query1 = "SELECT count(*) as totlots FROM $TABLE_TORG_ITEM2ELEV i2e
				INNER JOIN $TABLE_TORG_ITEMS i1 ON i2e.item_id=i1.id AND i1.active=1 AND i1.status=$TORG_STATUS_FINISH
				WHERE i2e.elev_id=".$row->id;
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$lot_win = $row1->totlots;
				}
				mysqli_free_result( $res1 );
			}

			// All act lots
			$query1 = "SELECT count(*) as totlots FROM $TABLE_TORG_ITEM2ELEV i2e
				INNER JOIN $TABLE_TORG_ITEMS i1 ON i2e.item_id=i1.id AND i1.active=1
					AND i1.status=$TORG_STATUS_ACT AND i1.dt_end>NOW() AND i1.dt_start<NOW()
				WHERE i2e.elev_id=".$row->id;
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$lot_act = $row1->totlots;
				}
				mysqli_free_result( $res1 );
			}

			$query1 = "UPDATE $TABLE_TORG_ELEV SET rate=".($lot_tot + $lot_win*2 + $lot_act*3)." WHERE id=".$row->id;
			if( !mysqli_query($upd_link_db, $query1 ) )
			{
				echo mysqli_error($upd_link_db);
			}
		}
		mysqli_free_result( $res );
	}


	include "../inc/close-inc.php";

?>