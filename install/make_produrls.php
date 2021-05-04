<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////

	////////////////////////////////////////////////////////////////////////////////
	// Create database structure

	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/utils-inc.php";
	//include "../inc/catutils-inc.php";

	setlocale(LC_ALL, "ru_RU");
	error_reporting(E_ALL);


	$query = "SELECT n1.*, n2.title FROM $TABLE_NEWS n1
		INNER JOIN $TABLE_NEWS_LANGS n2 ON n1.id=n2.news_id AND n2.lang_id='$LangId'
	";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object($res ) )
		{
			$nurl = $row->id."-".strtolower(TranslitEncode(str_replace("'", "", stripslashes($row->title))));

			$query1 = "UPDATE $TABLE_NEWS SET url='".addslashes($nurl)."' WHERE id=".$row->id;
			if( !mysqli_query($upd_link_db, $query1 ) )
			{
				echo mysqli_error($upd_link_db);
			}
		}
		mysqli_free_result($res );
	}


	$query = "SELECT n1.*, n2.title FROM $TABLE_FAQ n1
		INNER JOIN $TABLE_FAQ_LANGS n2 ON n1.id=n2.item_id AND n2.lang_id='$LangId'
	";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$nurl = $row->id."-".strtolower(TranslitEncode(str_replace("'", "", stripslashes($row->title))));

			$query1 = "UPDATE $TABLE_FAQ SET url='".addslashes($nurl)."' WHERE id=".$row->id;
			if( !mysqli_query($upd_link_db, $query1 ) )
			{
				echo mysqli_error($upd_link_db);
			}
		}
		mysqli_free_result($res );
	}

	$query = "SELECT n1.*, n2.name FROM $TABLE_TORG_ELEV n1
		INNER JOIN $TABLE_TORG_ELEV_LANGS n2 ON n1.id=n2.item_id AND n2.lang_id='$LangId'
	";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object($res ) )
		{
			$nurl = $row->id."-".strtolower(TranslitEncode(str_replace("'", "", stripslashes($row->name))));

			$query1 = "UPDATE $TABLE_TORG_ELEV SET elev_url='".addslashes($nurl)."' WHERE id=".$row->id;
			if( !mysqli_query($upd_link_db, $query1 ) )
			{
				echo mysqli_error($upd_link_db);
			}
		}
		mysqli_free_result( $res );
	}

	/*
 	$query = "SELECT i1.*, i2.descr, m1.url as make_url FROM $TABLE_CAT_ITEMS i1
 		INNER JOIN $TABLE_CAT_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
 		INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id";
 	echo $query."<br />";
	if( $res = mysqli_query( $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			//$model_name = mb_strtolower( Product_GenerateUrl( $LangId, $row->id, stripslashes($row->model), stripslashes($row->make_url) ), "UTF-8" );
			$model_name = strtolower( Product_GenerateUrl( $LangId, $row->id, stripslashes($row->model), stripslashes($row->make_url) ) );

			echo $model_name."<Br />";

			$query1 = "UPDATE $TABLE_CAT_ITEMS SET url='".mysqli_real_escape_string($model_name)."' WHERE id=".$row->id;
			if( !mysqli_query( $query1 ) )
			{
				echo mysqli_error();
			}
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error();
	*/


	include	"../inc/close-inc.php";
?>



SELECT
table_name AS `Table`,
round(((data_length + index_length) / 1024), 2) `Size in KB`
FROM information_schema.TABLES
WHERE table_schema = "agrocenter";