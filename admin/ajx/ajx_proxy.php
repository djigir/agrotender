<?php
	$MSSQL_MAKE_CONNECT = true;
	$MSSQL_MAKE_CONNECT2 = true;

	include "../../inc/db-inc.php";
	include "../../inc/connect-inc.php";
	
	include "../../inc/ses-inc.php";
	include "../inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
		exit();
    }

	//include "../inc/galery_utils-inc.php";

	//include "phpws_inc/ws_utils-inc.php";

	$AJX_COMMAND_PRODUCTLIST = "uh_com_prodlist";
	$AJX_COMMAND_PRODUCTLISTREAL = "uh_com_prodlistreal";
	$AJX_COMMAND_FINDBYID = "uh_com_findbyid";

    $command_line = "";

    if( $_SERVER["REQUEST_METHOD"] == "GET" )
    {
    	$command_line = $_GET["rcom"];
    }
    else
    {
    	$post_string_req = "";

    	$post_string_req = $_POST["datacmd"];
    	$virt_len = strlen($post_string_req);
    	$real_len = $_SERVER["CONTENT_LENGTH"] - strlen("datacmd=");

    	$command_line = base64_decode($post_string_req);

    	$pars = @split("&", $command_line);
   		$post_data = Array();
   		for($i=0; $i<count($pars); $i++)
   		{
   			$dat = @split("=", $pars[$i], 2);
   			$post_data[$dat[0]] = $dat[1];
   		}

   		$command_line = $post_data["rcom"];
    }

	$content_text = "";

	//echo $post_data["swstart"];

    switch( $command_line )
    {
    	case $AJX_COMMAND_PRODUCTLIST:
   			$content_text = GetProdList($_GET["tid"], $_GET["lngid"]);
   			break;

   		case "getvars":
   			phpinfo();
   			break;

   		default:
   			RunTest();
   			break;
    }

    header("Content-Type: text/plain; charset=windows-1251");
    //header("Content-Encoding: windows-1251");
	echo $content_text;

function Image_RecalcSize($w, $h, $dw, $dh)
{
	$ow = 0;
	$oh = 0;
	if( ($w <= $dw) && ($h<=$dh) )
	{
		$ow = $w;
		$oh = $h;
	}
	else
	{
		if( ($w/$dw) > ($h/$dh) )
		{
			$oh = floor( ($dw*$h)/$w );
			$ow = $dw;
		}
		else
		{
			$ow = floor( ($dh*$w)/$h );
			$oh = $dh;
		}
	}

	return Array("w" => $ow, "h" => $oh);
}

function GetProdList($type, $langid)
{
	global $TABLE_CAT_ITEMS, $TABLE_CAT_ITEMS_LANGS, $TABLE_CAT_MAKE_LANGS, $TABLE_CAT_PRICES;

	$list_html = "";

	$products = Array();

	$query = "SELECT i1.*, m1.make_name as producer, pr1.price, pr1.price2, pr1.availiable_now
    	FROM $TABLE_CAT_ITEMS i1
    	INNER JOIN $TABLE_CAT_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$langid'
    	INNER JOIN $TABLE_CAT_MAKE_LANGS m1 ON i1.make_id=m1.make_id AND m1.lang_id='$langid'
    	INNER JOIN $TABLE_CAT_PRICES pr1 ON i1.id=pr1.item_id AND pr1.availiable_now=1
    	WHERE i1.profile_id='".$type."'
    	ORDER BY m1.make_name, i1.model";

 	//$list_html .= ' =====\r\n'.$query.' ======\r\n';

    if( $res = mysqli_query($upd_link_db, $query ) )
    {
        while( $row = mysqli_fetch_object( $res ) )
        {
        	$it = Array();

        	$it['id'] = $row->id;
        	$it['url'] = stripslashes($row->url);
        	$it['model'] = stripslashes($row->model);
        	$it['articul'] = stripslashes($row->articul);
        	$it['make'] = stripslashes($row->producer);

			$it['show'] = $row->availiable_now;
			//$it['status'] = $row->status;
        	$it['cost'] = ( $row->price != null ? $row->price : 0 );
        	$it['cost2'] = (($row->price2 != null) && ($row->price2 != 0) ? $row->price2 : "");

        	$products[] = $it;
        }
        mysqli_free_result( $res );
    }
    else
    	$list_html .= mysql_error($upd_link_db);

  	$list_html .= "{ prodlist: [ \r\n";

  	for( $i=0; $i<count($products); $i++ )
  	{
  		if( $i != 0 )
  			$list_html .= ", ";

  		$list_html .= "{ id: \"".$products[$i]['id']."\", name: \"".addslashes($products[$i]['make'])." ".addslashes($products[$i]['model'])."\", cost: \"".$products[$i]['cost']."\" }";
  	}

  	//$list_html .= "test: \"response\", ";

	//$list_html .= "src: \"".$curphoto['pic']."\", ";
    //$list_html .= "w: \"".$curphoto['pic_w']."\", ";
    //$list_html .= "h: \"".$curphoto['pic_h']."\", ";
    //$list_html .= "alt: \"".iconv("UTF-8", "CP1251", $curphoto['alt'])."\", ";
    //$list_html .= "descr: \"".iconv("UTF-8", "CP1251", $curphoto['descr'])."\" ";
    //$list_html .= "alt: \"".$curphoto['alt']."\", ";
    //$list_html .= "descr: \"".$curphoto['descr']."\" ";

	$list_html .= "\r\n] };";

	return $list_html;
}

function RunTest()
{
	global $WS_HOST, $WS_PATH, $WS_LOGIN, $WS_PASS;

	$list_html = "";

	$aws = new WsAPI($WS_HOST, $WS_PATH, $WS_LOGIN, $WS_PASS);

	$req = '<'.'?'.'xml version="1.0" encoding="utf-8"'.'?'.'>'.
		'<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">'.
		'<soap:Body>'.
			'<uhTestMethod xmlns="http://ws.buy-fly.com/" />'.
		'</soap:Body>'.
		'</soap:Envelope>';

	//$req_utf8 = utf8_encode($req);//iconv("UTF-8", "CP1251", $req);

	$cmd = "uhTestMethod";

	$list_html = $aws->sendRequest($cmd, $req);

	return $list_html;
}



?>
