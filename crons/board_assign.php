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
	$txt_res = Resources_Get($LangId);

	$BOARD_PERONCE = 50;
	$BOARD_MONTHOLD = 5;
	$BOARD_NOTIFYDAYS = 3;

	$authors = Array();

	////////////////////////////////////////////////////////////////////////////
	// Delete all old posts - older then 6 months
	$query = "SELECT * FROM $TABLE_ADV_POST WHERE author_id=0 AND email<>''";
	echo $query."<br />";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			//echo $row->id." - ".$row->add_date."<br />";
            if( isset($authors[stripslashes($row->email)]) )
            {
            	$query = "UPDATE $TABLE_ADV_POST SET author_id=".$authors[stripslashes($row->email)]." WHERE id=".$row->id;
				if( !mysqli_query($upd_link_db,  $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
            }
            else
            {
            	$query1 = "SELECT * FROM $TABLE_TORG_BUYERS WHERE login='".addslashes($row->email)."'";
				if( $res1 = mysqli_query($upd_link_db,  $query1 ) )
				{
					if( $row1 = mysqli_fetch_object( $res1 ) )
					{
						$authors[stripslashes($row->email)] = $row1->id;

						$query = "UPDATE $TABLE_ADV_POST SET author_id=".$authors[stripslashes($row->email)]." WHERE id=".$row->id;
						if( !mysqli_query($upd_link_db,  $query ) )
						{
							echo mysqli_error($upd_link_db);
						}
					}
					mysqli_free_result( $res1 );
				}
            }
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);



	include "../inc/close-inc.php";

?>