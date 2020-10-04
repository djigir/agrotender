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

	$query1 = "SELECT * FROM $TABLE_TORG_BUYERS";
	if( $res1 = mysqli_query($upd_link_db,  $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$user_id = $row1->id;
			
			$complist = Comp_Items( $LangId, 0, 0, 0, 0, -1, 20, $user_id, true );
			
			if( count($complist)>0 )
			{
				$company_id = $complist[0]['id'];
				
				/*
				$query1 = "SELECT count(*) as totnum FROM $TABLE_ADV_POST WHERE (company_id='0' OR publish_utype<>2) AND author_id=$user_id";
				if( $res = mysqli_query($upd_link_db,  $query1 ) )
				{
					while( $row = mysqli_fetch_object($res) )
					{
						echo $complist[0]['id'].": ".$complist[0]['title']." - adv num = ".$row->totnum."<br>";
					}				
					mysqli_free_result($res);
				}
				else
					echo mysqli_error($upd_link_db);
				*/
				
				$query1 = "UPDATE $TABLE_ADV_POST SET company_id='$company_id', publish_utype=2 WHERE author_id=$user_id";
				if( !mysqli_query($upd_link_db,  $query1 ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
		}
		mysqli_free_result( $res1 );
	}


	////////////////////////////////////////////////////////////////////////////

	include "../inc/close-inc.php";

?>