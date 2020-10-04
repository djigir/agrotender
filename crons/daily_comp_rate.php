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

	$DAYS_HISTORY = 7;
	$DAYS_HISTORY_TRADER = 183;

	$DAYS_HISTORY_COMPANY = 365;

	////////////////////////////////////////////////////////////////////////////
	// Delete all old statistics
	$query = "DELETE FROM $TABLE_COMPANY_RATE_DATETMP WHERE dt < DATE_SUB(NOW(), INTERVAL 30 DAY)";
	if( !mysqli_query($upd_link_db,  $query ) )
	{
		echo mysqli_error($upd_link_db);
	}
	
	//$query = "DELETE FROM $TABLE_COMPANY_RATE WHERE dt < DATE_SUB(NOW(), INTERVAL ".$DAYS_HISTORY_COMPANY." DAY)";
	//if( !mysqli_query($upd_link_db,  $query ) )
	//{
	//	echo mysqli_error($upd_link_db);
	//}

	////////////////////////////////////////////////////////////////////////////
	// Update Product Views Rating
	$query = "SELECT c1.*, count(n1.id) as totnews, count(v1.id) as totvac, count(pr1.id) as totprs, count(ct1.id) as totcont, count(p1.id) as totadvs, DATEDIFF(NOW(), c1.add_date) as daysexist
		FROM $TABLE_COMPANY_ITEMS c1 
		LEFT JOIN $TABLE_COMPANY_NEWS n1 ON c1.id=n1.comp_id AND n1.visible=1 
		LEFT JOIN $TABLE_COMPANY_VACANCY v1 ON c1.id=v1.comp_id AND v1.visible=1 
		LEFT JOIN $TABLE_TRADER_PR_PRICES pr1 ON c1.author_id=pr1.buyer_id 
		LEFT JOIN $TABLE_COMPANY_CONTACTS ct1 ON c1.id=ct1.comp_id  
		LEFT JOIN $TABLE_ADV_POST p1 ON c1.id=p1.company_id AND p1.active=1 
		GROUP BY c1.id 
	";
	if( $res = mysqli_query($upd_link_db,  $query ) )	{

		while( $row = mysqli_fetch_object( $res ) )
		{
			$item_id = $row->id;
			
			$C_RATE = 0;
			$query1 = "SELECT sum(amount) as total_rate FROM $TABLE_COMPANY_RATE WHERE item_id=".$item_id." AND metrictype='$VIEWSTAT_COMP' AND dt > DATE_SUB(NOW(), INTERVAL 7 DAY)";
			if( $res1 = mysqli_query($upd_link_db,  $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$C_RATE = $row1->total_rate;
				}
				mysqli_free_result( $res1 );
			}			
			
			//$C_RATE = $row->rate;
			$C_TZU = $row->totadvs;
			$C_NEWS = $row->totnews;
			$C_VAC = $row->totvac;
			$C_PR = $row->totprs;
			$C_CONT = $row->totcont;
			
			$C_DAYS = ($row->daysexist > 7 ? 7.0 : ($row->daysexist > 1 ? $row->daysexist : 1));
			
			$C_RATE = $C_RATE / $C_DAYS;
			
			$C_ADM1 = $row->rate_admin1;
			$C_ADM2 = $row->rate_admin2;
			
			/*
			$CALC_RATE = $C_RATE * 
				( $C_NEWS > 0 ? $PREFS['CK_NEWS'] : 1 ) * 
				( $C_VAC > 0 ? $PREFS['CK_VAC'] : 1 ) * 
				( $C_CONT > 0 ? $PREFS['CK_CONT'] : 1 ) * 
				( $C_PR > 0 ? $PREFS['CK_PR'] : 1 ) * 
				( $C_RATE * $PREFS['CK_PM'] ) * 						// Тут надо было срок жизни компании прописать
				( stripslashes($row->logo_file) != "" ? $PREFS['CK_LOGO'] : 1 ) * 
				( strlen(stripslashes($row->content)) > 1000 ? $PREFS['CK_DESCR'] : 1 ) * 
				( $C_TZU > 0 ? $PREFS['CK_TZU'] : 1 ) * ($C_ADM1 / 30.0) + $C_ADM2;
			*/
			echo "<b>".$row->title."</b><br>";
			echo 'rate + news + vac + contact + prices + logo + descr + tzu + (adm1/days) + adm2<br>';
			echo $C_RATE.":".$PREFS['CK_PM']."(".($C_RATE * $PREFS['CK_PM']).") + ".$C_NEWS.":".$PREFS['CK_NEWS'].' + '.$C_VAC.':'.$PREFS['CK_VAC'].' + '.$C_CONT.':'.$PREFS['CK_CONT'].' + '.$C_PR.':'.$PREFS['CK_PR'].' + '.(stripslashes($row->logo_file) != "" ? 1 : 0).':'.$PREFS['CK_LOGO'].' + '.(strlen(stripslashes($row->content)) > 1000 ? 1 : 0).':'.$PREFS['CK_DESCR'].' + '.$C_TZU.':'.$PREFS['CK_TZU'].' + ('.$C_ADM1.'/'.$C_DAYS.') + '.$C_ADM2.' = ';
				
			$CALC_RATE = ($C_RATE * $PREFS['CK_PM']) + 
				( $C_NEWS > 0 ? $PREFS['CK_NEWS'] : 0 ) + 
				( $C_VAC > 0 ? $PREFS['CK_VAC'] : 0 ) + 
				( $C_CONT > 0 ? $PREFS['CK_CONT'] : 0 ) + 
				( $C_PR > 0 ? $PREFS['CK_PR'] : 0 ) + 
				( stripslashes($row->logo_file) != "" ? $PREFS['CK_LOGO'] : 0 ) + 
				( (strlen(stripslashes($row->content)) > 1000) ? $PREFS['CK_DESCR'] : 0 ) +  
				( $C_TZU > 0 ? $PREFS['CK_TZU'] : 0 ) + 
				$C_ADM2;
				//($C_ADM1 / $C_DAYS) + $C_ADM2;
				
			echo $CALC_RATE."<br><br>";
			

			$query1 = "UPDATE $TABLE_COMPANY_ITEMS SET rate_formula='".number_format($CALC_RATE, 2, ".", "")."' WHERE id=".$item_id;
			if( !mysqli_query($upd_link_db,  $query1 ) )
			{
				echo mysqli_error($upd_link_db);
			}
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);


	////////////////////////////////////////////////////////////////////////////

	include "../inc/close-inc.php";

?>