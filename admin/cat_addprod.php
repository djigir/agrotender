<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";
    include "inc/authorize-inc.php";

    include "../inc/utils-inc.php";
    include "../inc/catutils-inc.php";
    include "inc/admin_catutils-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

    $strings['tipedit']['en'] = "Edit This Model";
    $strings['tipeditp']['en'] = "Edit Model's Photos";
    $strings['tipdel']['en'] = "Delete This Model";
    $strings['tipassign']['en'] = "Place product on first page";
    $strings['tipinfo']['en'] = "Product guide ad reference";

    $strings['tipedit']['ru'] = "Редактировать информацию";
    $strings['tipeditp']['ru'] = "Редактировать фотографии";
    $strings['tipdel']['ru'] = "Удалить модель из базы";
    $strings['tipassign']['ru'] = "Разместить на стартовую страницу";
    $strings['tipinfo']['ru'] = "Руководства пользователя и инструкции к продукту";

    $PAGE_HEADER['ru'] = "Товары";
	$PAGE_HEADER['en'] = "Products";

    // Include Top Header HTML Style
	include "inc/header-inc.php";

    // Extract all colors, allowed for the vehicle
    $makes = Array();
    $makes_num = 0;


    $query = "SELECT v1.*, v2.make_name FROM $TABLE_CAT_MAKE v1, $TABLE_CAT_MAKE_LANGS v2
        WHERE v1.id=v2.make_id AND v2.lang_id='$LangId' ORDER BY v2.make_name";
    if( $res = mysqli_query($upd_link_db, $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
            $makes[$makes_num]['id'] = $row->id;
            $makes[$makes_num]['name'] = stripslashes($row->make_name);

            $makes_num++;
        }
        mysqli_free_result($res);
    }
    else
        echo mysqli_error($upd_link_db);

	// Get the vehicle type first to know what parameters to display
	$catid = GetParameter("catid", 0);
	$action = GetParameter("action", "start");
	$car_make = GetParameter("car_make", 0);

	$pi = GetParameter("pi", 1);
	$pn = GetParameter("pn", 25);

	$mode = "category";

	switch( $action )
	{
		case "start":
			if( $catid == 0 )	$mode = "category";
			else				$mode = "addform";
			break;

		case "addplace":
		case "editplace":
   			$item_id = GetParameter("item_id", 0);
   			$sectids = GetParameter("sectids", null);
   			$query = "DELETE FROM $TABLE_CAT_CATITEMS WHERE item_id='$item_id'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			for($i=0; $i<count($sectids); $i++)
			{
    			$query = "INSERT INTO $TABLE_CAT_CATITEMS (sect_id, item_id) VALUES ('".$sectids[$i]."', '$item_id')";
    			if(!mysqli_query($upd_link_db, $query ))
    			{
    				echo mysqli_error($upd_link_db);
    			}
			}
			$mode = "notifyok";
   			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", 0);
			$car_make = GetParameter("car_make", 0);

            $query = "SELECT * FROM $TABLE_CAT_ITEMS_PICS WHERE item_id='$item_id'";
            if( $res = mysqli_query($upd_link_db, $query ) )
            {
                while( $row = mysqli_fetch_object($res) )
                {
                    if( file_exists("../".stripslashes($row->filename_ico)) )
                    	unlink( "../".stripslashes($row->filename_ico ) );

					if( file_exists("../".stripslashes($row->filename_thumb)) )
						unlink( "../".stripslashes($row->filename_thumb ) );

					if( file_exists("../".stripslashes($row->filename)) )
						unlink( "../".stripslashes($row->filename ) );

					//if( file_exists("../".stripslashes($row->filename_logo)) )
					//	unlink( "../".stripslashes($row->filename_logo ) );
                }
                mysqli_free_result($res);
            }

            $query = "DELETE FROM $TABLE_CAT_ITEMS_PICS WHERE item_id='$item_id'";
            if( !mysqli_query($upd_link_db, $query ) )
            {
               echo mysqli_error($upd_link_db);
            }

			//delete video
			$query = "SELECT id FROM $TABLE_CAT_ITEMS_VIDEO WHERE prod_id='$item_id'";
			if( $res=mysqli_query($upd_link_db,$query) )
			{
				while( $row = mysqli_fetch_object($res) )
				{
					$query1 = "DELETE FROM $TABLE_CAT_ITEMS_VIDEO_LANGS WHERE item_id='".$row->id."'";
					if( !mysqli_query($upd_link_db, $query1 ) )
					{
						echo mysqli_error($upd_link_db);
					}
				}
				mysqli_free_result($res);
			}
			else
				echo mysqli_error($upd_link_db);

			$query = "DELETE FROM $TABLE_CAT_ITEMS_VIDEO WHERE prod_id='$item_id'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

			// Delete filters
			$query = "SELECT * FROM $TABLE_CAT_FILTER_VALUES WHERE item_id='$item_id'";
            if( $res = mysqli_query($upd_link_db, $query ) )
            {
                while( $row = mysqli_fetch_object($res) )
                {
                    if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_CAT_FILTER_VALUES_OPTS WHERE param_value_id='".$row->id."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }
                }
                mysqli_free_result($res);
            }

			$query = "DELETE FROM $TABLE_CAT_FILTER_VALUES WHERE item_id='$item_id'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

			// Delete params
			$query = "SELECT * FROM $TABLE_CAT_PARAM_VALUES WHERE item_id='$item_id'";
            if( $res = mysqli_query($upd_link_db, $query ) )
            {
                while( $row = mysqli_fetch_object($res) )
                {
                    if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_CAT_PARAM_VALUES_OPTS WHERE param_value_id='".$row->id."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }
                }
                mysqli_free_result($res);
            }

			$query = "DELETE FROM $TABLE_CAT_PARAM_VALUES WHERE item_id='$item_id'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
			   echo mysqli_error($upd_link_db);
			}

			//$query = "DELETE FROM neolux_cat_techitem WHERE item_id='$item_id'";
			//if( !mysqli_query($upd_link_db, $query ) )
			//{
			//   echo mysqli_error($upd_link_db);
			//}


            $query = "DELETE FROM $TABLE_CAT_ITEMS_LANGS WHERE item_id='$item_id'";
            if( !mysqli_query($upd_link_db, $query ) )
            {
               echo mysqli_error($upd_link_db);
            }

			$query = "DELETE FROM $TABLE_CAT_ITEMS WHERE id='$item_id'";
            if( !mysqli_query($upd_link_db, $query ) )
            {
               echo mysqli_error($upd_link_db);
            }

            $query = "DELETE FROM $TABLE_CAT_CATITEMS WHERE item_id='$item_id'";
            if( !mysqli_query($upd_link_db, $query ) )
            {
               echo mysqli_error($upd_link_db);
            }

            $query = "DELETE FROM $TABLE_CAT_PRICES WHERE item_id='$item_id'";
            if( !mysqli_query($upd_link_db, $query ) )
            {
               echo mysqli_error($upd_link_db);
            }

            $query = "DELETE FROM $TABLE_CAT_BEST_ITEMS WHERE item_id='$item_id'";
            if( !mysqli_query($upd_link_db, $query ) )
            {
               echo mysqli_error($upd_link_db);
            }

            $query = "DELETE FROM $TABLE_CAT_ITEMS_RATE WHERE item_id='$item_id'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

			$query = "DELETE FROM $TABLE_CAT_ITEMS_RELATED WHERE item_id='".$item_id."'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

			$query = "DELETE FROM $TABLE_CAT_ITEMS_RELATED WHERE rel_id='".$item_id."'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

            $mode = "addform";
			break;

		case "addmodif":
			$newitemid = $iid = GetParameter("newitemid", 0);

			$relids = GetParameter("relids", null);

			$relids[] = $newitemid;

			$oldrelids = Array();
			$oldrelids[] = $newitemid;

			$query = "SELECT * FROM $TABLE_CAT_ITEMS_RELATED WHERE item_id=$newitemid AND reltype=0";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object( $res ) )
				{
					$oldrelids[] = $row->rel_id;
				}
				mysqli_free_result( $res );
			}

			// Delete old relations for all related products
			for( $i=0; $i<count($oldrelids); $i++ )
			{
				$query = "DELETE FROM $TABLE_CAT_ITEMS_RELATED WHERE item_id=".$oldrelids[$i]." AND reltype=0";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}

			// Add new releations
			for( $i=0; $i<count($relids); $i++ )
			{
				for( $j=0; $j<count($relids); $j++ )
				{
					if( $i != $j )
					{
						$query = "INSERT INTO $TABLE_CAT_ITEMS_RELATED (item_id, rel_id, reltype)
							VALUES ('".$relids[$i]."', '".$relids[$j]."', 0)";
						if( !mysqli_query($upd_link_db, $query ) )
						{
							echo mysqli_error($upd_link_db);
						}
					}
				}
			}

			$mode = "editform";
			break;

		case "editpics":
            $iid = GetParameter("item_id", 0);
			//$car_make = GetParameter("car_make", 0);
			$newitemid = $iid;
			//$mode = "editpicture";
			$mode = "editform";
			break;

		case "edititem":
            $iid = GetParameter("item_id", 0);
            $newitemid = $iid;
			$mode = "editform";
			break;

		case "usetpl":
			$iid = GetParameter("iid", 0);
			$mode = "addformtpl";
			break;

		case "updatecar":
			$item_id = GetParameter("item_id", 0);
			$catsect = GetParameter("catsect", 0);
			$car_model = GetParameter("car_model", "");
			$page_title = GetParameter("page_title", "");
			$page_descr = GetParameter("page_descr", "");

			$page_key = GetParameter("page_key", "");
			$car_descr = GetParameter("car_descr", "", false);
			$car_descr0 = GetParameter("car_descr0", "", false);

			$car_price = GetParameter("car_price", "0.00");
			//$tech = GetParameter("tech", null);
			//$count_tech = GetParameter("cth", 0);

			$car_art = GetParameter("car_art", "");
			$car_status = GetParameter("car_status", 0);


			$query = "UPDATE $TABLE_CAT_ITEMS SET model='".addslashes($car_model)."', make_id='$car_make', articul='".addslashes($car_art)."',
				status='".$car_status."'
				WHERE id='$item_id'";
			//$query = "UPDATE $TABLE_CAT_ITEMS SET make_id='$car_make' WHERE id='$item_id'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
			   echo mysqli_error($upd_link_db);
			}

			////////////////////////////////////////////////////////////////////
			// update price
			$price_row_id = 0;
			$query = "SELECT * FROM $TABLE_CAT_PRICES WHERE item_id='".$item_id."'";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				if( $row = mysqli_fetch_object( $res ) )
				{
					$price_row_id = $row->id;
				}
				mysqli_free_result( $res );
			}

			if( $price_row_id == 0 )
			{
				$query = "INSERT INTO $TABLE_CAT_PRICES (item_id, price, availiable_now, update_date)
					VALUES ('".$item_id."', '".str_replace(",",".", $car_price)."', 1, NOW())";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
			else
			{
				$query = "UPDATE $TABLE_CAT_PRICES SET price='".str_replace(",",".", $car_price)."' WHERE id=".$price_row_id;
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}

			//////////////////////////////FOR TECHNOLOGY //////////////////////////////////
			/*
			$query=mysqli_query($upd_link_db,"SELECT id FROM neolux_cat_techitem WHERE item_id='$item_id'");
			if(!mysqli_num_rows($query)>0){
			    for($i=0;$i<$count_tech;$i++){
				if(!$query=mysqli_query($upd_link_db,"INSERT INTO neolux_cat_techitem (item_id,tech_id) VALUES ('".$item_id."','0')")){
				    echo mysqli_error($upd_link_db);
				}
			    }
			}else{
			    if(!$query=mysqli_query($upd_link_db,"UPDATE neolux_cat_techitem set tech_id='0' WHERE item_id='".$item_id."'")){
				  echo mysqli_error($upd_link_db);
			    }
			}

			if($query=mysqli_query($upd_link_db,"SELECT id FROM neolux_cat_techitem WHERE item_id='".$item_id."'")){
			    $tech_id=Array();
			    while($row=mysqli_fetch_object($query)){
				$tech_id[]=$row->id;
			    }
			    mysqli_free_result($query);
			}else{
			    echo mysqli_error($upd_link_db);
			}
			if($tech!=null && count($tech)>0){
			    for($i=0;$i<count($tech);$i++){
				if(!$query=mysqli_query($upd_link_db,"UPDATE neolux_cat_techitem SET tech_id='".$tech[$i]."' WHERE id='".$tech_id[$i]."'")){
				    echo mysqli_error($upd_link_db);
				}
			    }
			}
			*/
			///////////////////////////////////////////////////////////////////////////////

            if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_ITEMS_LANGS SET descr='".addslashes($car_descr)."', descr0='".addslashes($car_descr0)."',
            	page_title='".addslashes($page_title)."',page_keywords='".addslashes($page_key)."', page_descr='".addslashes($page_descr)."'
            	WHERE item_id='$item_id' AND lang_id='$LangId'" ) )
            {
               echo mysqli_error($upd_link_db);
            }

			//------------------------    PARAMS   -----------------------------
            // Get parameters values and IDs
        	$param_ids = GetParameter("param_ids", null);
	        $param_types = GetParameter("param_types", null);

			// Process the params like: text box, drop down menu, checkox flag
	        for( $i=0; $i<count($param_ids); $i++ )
	        {
				switch( $param_types[$i] )
				{
					case $FIELD_TYPE_EDIT:		// Textbox - 1
						$paramval = GetParameter("param".$param_ids[$i], "");
						break;

					case $FIELD_TYPE_SELECT:	// Select - 2
						$paramval = GetParameter("param".$param_ids[$i], 0);
						break;

					//case $FIELD_TYPE_OPTIONS:	// Select - 3
					//	$paramval = GetParameter("param".$param_ids[$i], 0);
					//	break;

					case $FIELD_TYPE_FLAG:		// Flag - 4
						$paramval = GetParameter("param".$param_ids[$i], 0);
						break;

					case $FIELD_TYPE_TEXTAREA:	// Textarea - 5
						$paramval = GetParameter("param".$param_ids[$i], "");
						break;

					case $FIELD_TYPE_HTML:		// HTML Area - 6
						$paramval = GetParameter("param".$param_ids[$i], "", false);
						break;

					case $FIELD_TYPE_RADIO:		// Radiogroup - 7
						$paramval = GetParameter("param".$param_ids[$i], 0);
						break;

					case $FIELD_TYPE_FILE:		// File - 8
						$paramval = GetParameter("param".$param_ids[$i], "");
						break;
				}

			    $paramval = str_replace ("\"", "&quot;", $paramval);
			    // Check if we try to update the new param for this project, then add it to the item
			    $query = "SELECT * FROM $TABLE_CAT_PARAM_VALUES WHERE item_id='$item_id' AND param_id='".$param_ids[$i]."'";
			    if( $res = mysqli_query($upd_link_db, $query ) )
			    {
				    if( $row = mysqli_fetch_object($res) )
				    {
				    	// The param for product exists
					}
					else
					{
						// No param for product, add it
						for( $il=0; $il<count($langs); $il++ )
						{
							if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_PARAM_VALUES (item_id, param_id, value, lang_id)
							 VALUES ('$item_id', '".$param_ids[$i]."', '".addslashes($paramval)."', '".$langs[$il]."')" ) )
							{
							   echo mysqli_error($upd_link_db);
							}
						}
					}
					mysqli_free_result( $res );
				}

				if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_PARAM_VALUES SET value='".addslashes($paramval)."'
					WHERE item_id='$item_id' AND param_id='".$param_ids[$i]."' AND lang_id='$LangId'" ) )
				{
				   echo mysqli_error($upd_link_db);
				}
			}

			// Get parameters which is the options list
			$paramopt_ids = GetParameter("paramopt_ids", null);
			for( $i=0; $i<count($paramopt_ids); $i++ )
			{
				$parvalid = 0;
				$query = "SELECT * FROM $TABLE_CAT_PARAM_VALUES
					WHERE item_id='$item_id' AND param_id='".$paramopt_ids[$i]."' AND lang_id='0'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					if( $row = mysqli_fetch_object($res) )
					{
					    $parvalid = $row->id;
					}
					mysqli_free_result($res);
				}

				if( $parvalid == 0 )
				{
					$query = "INSERT INTO $TABLE_CAT_PARAM_VALUES (item_id, param_id, value, lang_id)
						VALUES ('$item_id', '".$paramopt_ids[$i]."', '', 0)";
					if( !mysqli_query($upd_link_db, $query ) )
					{
					   echo mysqli_error($upd_link_db);
					}
					else
					{
						$parvalid = mysqli_insert_id($upd_link_db);
					}
				}
				else
				{
					if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_CAT_PARAM_VALUES_OPTS WHERE param_value_id='$parvalid'" ) )
					{
					   echo mysqli_error($upd_link_db);
					}
				}

				if( $parvalid != 0 )
				{
					$curparam_opts = GetParameter("param".$paramopt_ids[$i]."_opts", null);
					for( $j=0; $j<count($curparam_opts); $j++ )
					{
						if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_PARAM_VALUES_OPTS (param_value_id, option_id)
						    VALUES ('".$parvalid."', '".$curparam_opts[$j]."')" ) )
						{
						   echo mysqli_error($upd_link_db);
						}
					}
				}
			}

			//--------------------------  FILTERS ------------------------------
			//update filter
			$filters_ids = GetParameter("filter_ids", null);
			$filters_types = GetParameter("filter_types", null);

	        // Process the params like: text box, drop down menu, checkox flag
			for( $i=0; $i<count($filters_ids); $i++ )
			{
				switch( $filters_types[$i] )
				{
					case $FIELD_TYPE_SELECT:	// Select - 2
						$filterval = GetParameter("filt".$filters_ids[$i], 0);
						break;

					case $FIELD_TYPE_FLAG:		// Flag	- 4
						$filterval = GetParameter("filt".$filters_ids[$i], 0);
						break;
				}

				//$filterval = str_replace ("\"", "&quot;", $filterval);
				//PROVERKA ESLI NEW FILTERS TO INSERT

				$query = "SELECT * FROM $TABLE_CAT_FILTER_VALUES WHERE item_id='$item_id' AND param_id='".$filters_ids[$i]."'";
			    if( $res = mysqli_query($upd_link_db, $query ) )
			    {
				    if( $row = mysqli_fetch_object($res) )
				    {
				    	// The filter for product exists
					}
					else
					{
						// No filter for product, add it
						if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_FILTER_VALUES (item_id, param_id, value)
						 VALUES ('$item_id', '".$filters_ids[$i]."', '".$filterval."')" ) )
						{
						   echo mysqli_error($upd_link_db);
						}
					}
					mysqli_free_result( $res );
				}

				if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_FILTER_VALUES SET value='".$filterval."'
					WHERE item_id='$item_id' AND param_id='".$filters_ids[$i]."'" ) )
				{
				   echo mysqli_error($upd_link_db);
				}
            }

            $filteropt_ids = GetParameter("filteropt_ids", null);
			for( $i=0; $i<count($filteropt_ids); $i++ )
			{
				$filtvalid = 0;
				$query = "SELECT * FROM $TABLE_CAT_FILTER_VALUES
					WHERE item_id='$item_id' AND param_id='".$filteropt_ids[$i]."'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					if( $row = mysqli_fetch_object($res) )
					{
					    $filtvalid = $row->id;
					}
					mysqli_free_result($res);
				}

				if( $filtvalid == 0 )
				{
					$query = "INSERT INTO $TABLE_CAT_FILTER_VALUES (item_id, param_id, value)
						VALUES ('$item_id', '".$filteropt_ids[$i]."', '0')";
					if( !mysqli_query($upd_link_db, $query ) )
					{
					   echo mysqli_error($upd_link_db);
					}
					else
					{
						$filtvalid = mysqli_insert_id($upd_link_db);
					}
				}
				else
				{
					if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_CAT_FILTER_VALUES_OPTS WHERE param_value_id='$filtvalid'" ) )
					{
					   echo mysqli_error($upd_link_db);
					}
				}

				if( $filtvalid != 0 )
				{
					$curflt_opts = GetParameter("filt".$filteropt_ids[$i]."_opts", null);
					for( $j=0; $j<count($curflt_opts); $j++ )
					{
						if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_FILTER_VALUES_OPTS (param_value_id, option_id)
						    VALUES ('".$filtvalid."', '".$curflt_opts[$j]."')" ) )
						{
						   echo mysqli_error($upd_link_db);
						}
					}
				}
			}

			{
				/*
				$query = "SELECT * FROM $TABLE_CAT_FILTER_VALUES WHERE item_id='$item_id' AND param_id='".$filters_ids[$i]."'";
				if( $res1=mysqli_query($upd_link_db,$query) )
				{
					if( $row1 = mysqli_fetch_object($res1) )
					{
						if($filt_type == true)
						{
							$query="SELECT id, param_id FROM tcdar_cat_filters_option WHERE param_id='".$filters_ids[$i]."'";
							if( $res = mysqli_query($upd_link_db, $query ) )
							{
								while( $row = mysqli_fetch_object($res) )
								{
									if( !mysqli_query($upd_link_db,"INSERT INTO $TABLE_CAT_FILTER_VALUES (item_id, param_id, value)
										VALUES ('$item_id', '".$filters_ids[$i]."', '0')" ) )
									{
										echo mysqli_error($upd_link_db);
									}
								}
								mysqli_free_result($res);
							}
						}
						else
						{
							for( $il=0; $il<count($langs); $il++ )
							{
								if( !mysqli_query($upd_link_db,"INSERT INTO $TABLE_CAT_FILTER_VALUES (item_id, param_id, value)
									VALUES ('$item_id', '".$filters_ids[$i]."', '".addslashes($filters)."')" ) )
								{
									echo mysqli_error($upd_link_db);
								}
							}
						}
					}
					mysqli_free_result($res1);
				}


				/////////
				if(is_string($filters)==true && $filters!=0)
				{
					if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_FILTER_VALUES SET value='".addslashes($filters)."'
						WHERE item_id='$item_id' AND param_id='".$filters_ids[$i]."'" ) )
					{
						echo mysqli_error($upd_link_db);
					}
				}
				else if( is_array($filters) == true )
				{
					mysqli_query($upd_link_db,"UPDATE $TABLE_CAT_FILTER_VALUES SET value='0' WHERE item_id='$item_id' AND param_id='".$filters_ids[$i]."'" );
					$query=mysqli_query($upd_link_db,"SELECT id FROM $TABLE_CAT_FILTER_VALUES WHERE item_id='$item_id' AND param_id='".$filters_ids[$i]."' limit ".count($filters)."");
					$filid=Array();
					while($row = mysqli_fetch_object($query))
					{
						$filid[]=$row->id;
					}
					mysqli_free_result($query);

					for($f=0; $f<count($filters); $f++)
					{
						if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_FILTER_VALUES SET value='".addslashes($filters[$f])."'
							WHERE item_id='$item_id' AND param_id='".$filters_ids[$i]."' AND id='".$filid[$f]."'" ) )
						{
							echo mysqli_error($upd_link_db);
						}
					}
				}
				else
				{
					$query=mysqli_query($upd_link_db,"SELECT id FROM $TABLE_CAT_FILTER_VALUES WHERE item_id='$item_id' AND param_id='".$filters_ids[$i]."'");
					while( $row = mysqli_fetch_object($query) )
					{
						mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_FILTER_VALUES SET value='0' WHERE id='".$row->id."'" );
					}
					mysqli_free_result($query);
				}
				*/
			}

			if( $catsect != 0 )
			{
				$query = "DELETE FROM $TABLE_CAT_CATITEMS WHERE item_id='$item_id'";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
				$query = "INSERT INTO $TABLE_CAT_CATITEMS (sect_id, item_id) VALUES ('$catsect', '$item_id')";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}

			/*
			$it2car = GetParameter( "it2car", null );
			{
				$query = "DELETE FROM $TABLE_CAR_MODELITEMS WHERE item_id=$item_id";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}

				for( $i=0; $i<count($it2car); $i++ )
				{
					$query = "INSERT INTO $TABLE_CAR_MODELITEMS (item_id, model_id) VALUES ($item_id,'".$it2car[$i]."')";
					if( !mysqli_query($upd_link_db, $query ) )
					{
						echo mysqli_error($upd_link_db);
					}
				}
			}
			*/

			$newitemid = $iid = $item_id;
			$mode = "editform";
			//$mode = "addform";
			break;

		case "addcar":
			$car_make = GetParameter("car_make", 0);
			$car_model = GetParameter("car_model", "");
			$car_descr = GetParameter("car_descr", "", false);
			$car_descr0 = GetParameter("car_descr0", "", false);
			$catsect = GetParameter("catsect", 0);
			//$tech = GetParameter("tech", null);
			//$count_tech = GetParameter("cth", 0);
			$car_art = GetParameter("car_art", "");
			$car_status = GetParameter("car_status", 0);

			$car_price = GetParameter("car_price", "0.00");

			$filltplbut = GetParameter("filltplbut", "");
			if( $filltplbut != "" )
			{
				// We would like to fill the new car model from existing in db car model
				$mode = "selecttpl";
				break;
			}
			$addnewbut = GetParameter("addnewbut", "");
			if( $addnewbut == "" )
			{
				// Possibly the user change make, so reload page with all models in database
				$mode = "addform";
				break;
			}
	        //if( is_numeric($car_prodyear) )
	        //    $car_prodate = "01-".$car_prodmonth."-".$car_prodyear;

	        //echo "Trying to add<br />";

	        // Add main record about the vehicle item

	        $model_url = mb_strtolower( Product_GenerateUrl( $LangId, $row->id, stripslashes($row->model) ), "UTF-8" );

			$query = "INSERT INTO $TABLE_CAT_ITEMS (publisher_id, profile_id, model, add_date, make_id, modify_date, articul, url, status)
			    VALUES ($UserId, '$catid', '".addslashes($car_model)."', NOW(), '$car_make', NOW(), '".addslashes($car_art)."',
			    '".mysqli_real_escape_string($model_url)."', '$car_status')";
			//echo $query."<br />";
			if( !mysqli_query($upd_link_db, $query ) )
			{
			    echo mysqli_error($upd_link_db);
			    break;
			}

			$newitemid = mysqli_insert_id($upd_link_db);
			if( $newitemid == 0 )
			{
				$mode = "addform";
				break;
			}

			////////////////////////////////////////////////////////////////////
			// update price
			$query = "INSERT INTO $TABLE_CAT_PRICES (item_id, price, availiable_now, update_date)
				VALUES ('".$newitemid."', '".str_replace(",",".", $car_price)."', 1, NOW())";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

			// if everything was ok and item added then get it's ID
			////////////////////FOR TECHNOLOGY//////////////////////////////////
			/*
			$tc=0;
			if( $tech!=null && count($tech)>0 )
			{
				for($i=0;$i<count($tech);$i++)
				{
					$tc++;
					if(!$query=mysqli_query($upd_link_db,"INSERT INTO neolux_cat_techitem (item_id,tech_id) VALUES ('".$newitemid."','".$tech[$i]."')"))
					{
						echo mysqli_error($upd_link_db);
					}
				}
			}

			$t_cnt = $count_tech-$tc;
			if($t_cnt > 0)
			{
				for($i=0; $i<$t_cnt; $i++)
				{
					if(!$query=mysqli_query($upd_link_db,"INSERT INTO neolux_cat_techitem (item_id,tech_id) VALUES ('".$newitemid."','0')"))
					{
						echo mysqli_error($upd_link_db);
					}
				}
			}
			*/

			///////////////////////////////////////////////////////////////////
			//VIDEO

			$phototitle = GetParameter("phototitle", "");
			$photoind = GetParameter("photoind", 0);
			$photodescr = GetParameter("photodescr", "");
			$photofile = GetParameter("photofile2", "");
			$photoyoutube = GetParameter("photoyoutube", "");

			if( (trim($photofile) != "") || (trim($photoyoutube) != "") )
			{
				$query = "INSERT INTO $TABLE_CAT_ITEMS_VIDEO (prod_id, add_date, filename, tube_code, filename_ico, src_w, src_h, ico_w, ico_h, sort_num)
					VALUES ('$newitemid', NOW(), '".addslashes($photofile)."', '".addslashes($photoyoutube)."', '', 0, 0, 0, 0, '$photoind')";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
				else
				{
					$videoid = mysqli_insert_id($upd_link_db);

					for( $i=0; $i<count($langs); $i++ )
					{
						$query = "INSERT INTO $TABLE_CAT_ITEMS_VIDEO_LANGS (item_id, lang_id, title, descr) VALUES ('$videoid', '".$langs[$i]."',
							'".addslashes($phototitle)."', '".addslashes($photodescr)."')";
						if( !mysqli_query($upd_link_db, $query ) )
						{
							echo mysqli_error($upd_link_db);
						}
					}
				}
			}



            //echo "Added: id=$newitemid<br />";

            //$query = "INSERT INTO $TABLE_CAT_ITEM_VIEWS (item_id, amount) VALUES ('$newitemid', 1)";
            //if( !mysqli_query($upd_link_db, $query ) )
            //{
            //   echo mysqli_error($upd_link_db);
            //}

			$car_descr = GetParameter("car_descr", "");
			$car_descr0 = GetParameter("car_descr0", "");
			$page_title = GetParameter("page_title", "");
			$page_descr = GetParameter("page_descr", "");
			$page_key = GetParameter("page_key", "");

			for( $i=0; $i<count($langs); $i++ )
			{
				if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_ITEMS_LANGS ( item_id, lang_id, descr, descr0, page_title, page_keywords, page_descr )
				    VALUES ('$newitemid', '".$langs[$i]."', '".addslashes($car_descr)."', '".addslashes($car_descr0)."',
				    '".addslashes($page_title)."', '".addslashes($page_key)."', '".addslashes($page_descr)."')" ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}

	        //echo "Langs: id=$newitemid<br />";
			//PARAM_ADD
			// Get parameters values and IDs
			$param_ids = GetParameter("param_ids", null);
			$param_types = GetParameter("param_types", null);

			// Process the params like: text box, drop down menu, checkox flag
			for( $i=0; $i<count($param_ids); $i++ )
			{
				switch( $param_types[$i] )
				{
					case $FIELD_TYPE_EDIT:		// Textbox - 1
						$paramval = GetParameter("param".$param_ids[$i], "");
						break;
					case $FIELD_TYPE_SELECT:	// Select - 2
						$paramval = GetParameter("param".$param_ids[$i], 0);
						break;
					//case $FIELD_TYPE_OPTIONS:           // -3
					//	$paramval = GetParameter("param".$param_ids[$i], 0);
					//	break;
					case $FIELD_TYPE_FLAG:		// Flag	- 4
						$paramval = GetParameter("param".$param_ids[$i], 0);
						break;
					case $FIELD_TYPE_TEXTAREA:	// Textarea - 5
						$paramval = GetParameter("param".$param_ids[$i], "");
						break;
					case $FIELD_TYPE_HTML:		// HTML Area - 6
						$paramval = GetParameter("param".$param_ids[$i], "", false);
						break;
					case $FIELD_TYPE_RADIO:		// Radiogroup - 7
						$paramval = GetParameter("param".$param_ids[$i], 0);
						break;
					case $FIELD_TYPE_FILE:		// File - 8
						$paramval = GetParameter("param".$param_ids[$i], "");
						break;
				}

				$paramval = str_replace ("\"", "&quot;", $paramval);
				for( $il=0; $il<count($langs); $il++ )
				{
				    if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_PARAM_VALUES (item_id, param_id, value, lang_id)
				    	VALUES ('$newitemid', '".$param_ids[$i]."', '".addslashes($paramval)."', '".$langs[$il]."')" ) )
				    {
				       echo mysqli_error($upd_link_db);
				    }
				}
			}

			// Get parameters which is the options list
			$paramopt_ids = GetParameter("paramopt_ids", null);
			for( $i=0; $i<count($paramopt_ids); $i++ )
			{
				//for( $il=0; $il<count($langs); $il++ )
				//{
					//$query = "INSERT INTO $TABLE_CAT_PARAM_VALUES (item_id, param_id, value, lang_id)
					//	VALUES ('$newitemid', '".$paramopt_ids[$i]."', '', '".$langs[$il]."')";
					$query = "INSERT INTO $TABLE_CAT_PARAM_VALUES (item_id, param_id, value, lang_id)
						VALUES ('$newitemid', '".$paramopt_ids[$i]."', '', 0)";
					if( !mysqli_query($upd_link_db, $query ) )
					{
					   echo mysqli_error($upd_link_db);
					}
					else
					{
						$newparvalid = mysqli_insert_id($upd_link_db);
						$curparam_opts = GetParameter("param".$paramopt_ids[$i]."_opts", null);
						for( $j=0; $j<count($curparam_opts); $j++ )
						{
							if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_PARAM_VALUES_OPTS (param_value_id, option_id)
							    VALUES ('".$newparvalid."', '".$curparam_opts[$j]."')" ) )
							{
							   echo mysqli_error($upd_link_db);
							}
						}
					}
				//}
			}

			//Filters ADD
			$filters_ids = GetParameter("filter_ids", null);
			$filters_types = GetParameter("filter_types", null);

			for( $i=0; $i<count($filters_ids); $i++ )
	        {
				switch( $filters_types[$i] )
				{
					case $FIELD_TYPE_SELECT:	// Select - 2
						$filterval = GetParameter("filt".$filters_ids[$i], 0);
						break;

					case $FIELD_TYPE_FLAG:		// Flag	- 4
						$filterval = GetParameter("filt".$filters_ids[$i], 0);
	                    break;
     			}

                if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_FILTER_VALUES (item_id, param_id, value)
                	VALUES ('$newitemid', '".$filters_ids[$i]."', '".$filterval."')" ) )
				{
				   echo mysqli_error($upd_link_db);
				}
			}

			// Get filters which is the options list
			$filteropt_ids = GetParameter("filteropt_ids", null);
			for( $i=0; $i<count($filteropt_ids); $i++ )
			{
				$query = "INSERT INTO $TABLE_CAT_FILTER_VALUES (item_id, param_id, value)
					VALUES ('$newitemid', '".$filteropt_ids[$i]."', 0)";
				if( !mysqli_query($upd_link_db, $query ) )
				{
				   echo mysqli_error($upd_link_db);
				}
				else
				{
					$newfltvalid = mysqli_insert_id($upd_link_db);
					$curflt_opts = GetParameter("filt".$filteropt_ids[$i]."_opts", null);
					for( $j=0; $j<count($curflt_opts); $j++ )
					{
						if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_FILTER_VALUES_OPTS (param_value_id, option_id)
						    VALUES ('".$newfltvalid."', '".$curflt_opts[$j]."')" ) )
						{
						   echo mysqli_error($upd_link_db);
						}
					}
				}
			}

			//echo "Params done<br />";
			if( $catsect != 0 )
			{
				$query = "INSERT INTO $TABLE_CAT_CATITEMS (sect_id, item_id) VALUES ('$catsect', '$newitemid')";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}

			/*
			$it2car = GetParameter( "it2car", null );
			{
				$query = "DELETE FROM $TABLE_CAR_MODELITEMS WHERE item_id=$newitemid";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}

				for( $i=0; $i<count($it2car); $i++ )
				{
					$query = "INSERT INTO $TABLE_CAR_MODELITEMS (item_id, model_id) VALUES ($newitemid,'".$it2car[$i]."')";
					if( !mysqli_query($upd_link_db, $query ) )
					{
						echo mysqli_error($upd_link_db);
					}
				}
			}
			*/

			//echo "Section<br />";

			if( isset($_FILES['photofile']) && ($_FILES['photofile']['name']) )
			{
				$phototitle = GetParameter("phototitle", "");
				$photoind = GetParameter("photoind", 0);
				$photofile = $_FILES['photofile'];

				echo $photofile['tmp_name']."<br />";

				// Fill name parts of the product to form the meaning name of file, ex: sony_dwf-120
				$src_model = $car_model;
				$src_make = "";
				for($i=0; $i<count($makes); $i++)
				{
					if( $makes[$i]['id'] == $car_make )
					{
						$src_make = $makes[$i]['name'];
						break;
					}
				}

				// Make meaning name of file
				//$imgnamestr = MakeLocalImage( $newitemid, $src_make, $src_model );
				$imgnamestr = $newitemid;

				$point_pos = strrpos($photofile['name'], ".");
				if( $point_pos == -1 )
					break;
				$newfileext = substr($photofile['name'], $point_pos );

				/// Make the name for new file
				srand( time() );
				$inum = 0;
				$newfilename = "";
				while($inum < 100)
				{
					$randval = rand(10000, 99999);
					$newfilename = $imgnamestr."_".$randval.$newfileext;

					echo $newfilename."<br />";

					if( !file_exists("../".$CAT_PHOTO_DIR.$newfilename) )
					{
						break;
					}
					$inum++;
				}
				if( $inum == 100 )
					break;

				//echo "Copy<br />";
				$finalname = $CAT_PHOTO_DIR.$newfilename;
				echo $photofile['tmp_name'];

				//$res = ResizeImage( $photofile['tmp_name'], "../".$finalname, strtolower($newfileext), ".jpg", $BIGPIC_W, $BIGPIC_H, false, $JPEG_COMPRESS_RATIO);
				//$res = ResizeImageWithCopy( $photofile['tmp_name'], "../".$finalname, strtolower($newfileext), ".jpg", $PICBIG_W, $PICBIG_H, false, $JPEG_COMPRESS_RATIO, 3);
				//if( !$res )
				//{
				if( !copy($photofile['tmp_name'], "../".$finalname) )
					break;
				chmod( "../".$finalname, 0644 );
				//}

				// Now we should try to get the size of the image
				$imgsz = GetImageSizeAll( "../".$finalname, $newfileext );

				$srcw = 0;
				$srch = 0;
				if( $imgsz != null )
				{
					$srcw = $imgsz['w'];
					$srch = $imgsz['h'];
				}

				if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_ITEMS_PICS (item_id, title, filename, sort_num, src_w, src_h) VALUES
					('$newitemid', '".addslashes($phototitle)."', '".addslashes($finalname)."', '1', $srcw, $srch )" ) )
				{
				   echo mysqli_error($upd_link_db);
				}
				else
				{
					// photo was added successfully, so make thumbs - one big for car view, other smaller for catalog view
					$newimgid = mysqli_insert_id($upd_link_db);

					//$destination_file = $newitemid."_".$newimgid.".jpg";
					$destination_file = $imgnamestr."_".$newimgid.".jpg";

					// Make big image
					$res = ResizeImage( "../".$finalname, "../".$CAT_BIG_DIR.$destination_file, strtolower($newfileext), ".jpg", $BIGPIC_W, $BIGPIC_H, false, $JPEG_COMPRESS_RATIO, true, true, $WATERMARK_BIG);

					if( !$res )
						echo trim($it['name']).", Произошла ошибка при создании большого пережатого изображения.<br />";
					else
					{
						$imgsz = GetImageSizeAll( "../".$CAT_BIG_DIR.$destination_file, ".jpg" );

			      		$thw = 0;
			      		$thh = 0;
			      		if( $imgsz != null )
			      		{
			      			$thw = $imgsz['w'];
			      			$thh = $imgsz['h'];
			      		}

	                    if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_ITEMS_PICS SET
	                    	filename_big='".addslashes($CAT_BIG_DIR.$destination_file)."',
	                    	big_w=$thw, big_h=$thh WHERE file_id='$newimgid'" ) )
	                    {
	                       echo mysqli_error($upd_link_db);
	                    }
	                }

					// Make bug thumb
					$res = ResizeImage( "../".$finalname, "../".$CAT_THUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $THUMB_W, $THUMB_H, false, $JPEG_COMPRESS_RATIO, true, true, $WATERMARK_THUMB);

					if( !$res )
						echo "Произошла ошибка при создании большого пережатого изображения.<br />";
					else
					{
						$imgsz = GetImageSizeAll( "../".$CAT_THUMB_DIR.$destination_file, ".jpg" );

						$thw = 0;
						$thh = 0;
						if( $imgsz != null )
						{
							$thw = $imgsz['w'];
							$thh = $imgsz['h'];
						}

						if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_ITEMS_PICS SET
							filename_thumb='".addslashes($CAT_THUMB_DIR.$destination_file)."',
							thumb_w=$thw, thumb_h=$thh WHERE file_id='$newimgid'" ) )
						{
						   echo mysqli_error($upd_link_db);
						}
					}

					// Make small thumb
					//$res = ResizeImageWithCopy( "../".$finalname, "../".$CAT_SMTHUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $SMTHUMB_W, $SMTHUMB_H, false, $JPEG_COMPRESS_RATIO);
					$res = ResizeImage( "../".$finalname, "../".$CAT_SMTHUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $SMTHUMB_W, $SMTHUMB_H, false, $JPEG_COMPRESS_RATIO);
					//$res = ResizeImageWithCopy( "../".$finalname, "../".$CAT_SMTHUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $SMTHUMB_W, $SMTHUMB_H, false, $JPEG_COMPRESS_RATIO, 1);
					if( !$res )
						echo "Произошла ошибка при создании малого пережатого изображения.<br />";
					else
					{
						$imgsz = GetImageSizeAll( "../".$CAT_SMTHUMB_DIR.$destination_file, ".jpg" );

						$icow = 0;
						$icoh = 0;
						if( $imgsz != null )
						{
							$icow = $imgsz['w'];
							$icoh = $imgsz['h'];
						}

						if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_ITEMS_PICS SET
							filename_ico='".addslashes($CAT_SMTHUMB_DIR.$destination_file)."',
							ico_w=$icow, ico_h=$icoh WHERE file_id='$newimgid'" ) )
						{
						   echo mysqli_error($upd_link_db);
						}
					}

					// Make logo thumb
					/*
					//$res = ResizeImageWithCopy( "../".$finalname, "../".$CAT_SMTHUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $SMTHUMB_W, $SMTHUMB_H, false, $JPEG_COMPRESS_RATIO);
					$res = ResizeImage( "../".$finalname, "../".$CAT_LOGO_DIR.$destination_file, strtolower($newfileext), ".jpg", $LOGOTHUMB_W, $LOGOTHUMB_H, false, $JPEG_COMPRESS_RATIO);
					//$res = ResizeImageWithCopy( "../".$finalname, "../".$CAT_SMTHUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $SMTHUMB_W, $SMTHUMB_H, false, $JPEG_COMPRESS_RATIO, 1);
					if( !$res )
						echo "Произошла ошибка при создании малого пережатого изображения.<br />";
					else
					{
						$imgsz = GetImageSizeAll( "../".$CAT_LOGO_DIR.$destination_file, ".jpg" );

						$logow = 0;
						$logoh = 0;
						if( $imgsz != null )
						{
						    $logow = $imgsz['w'];
						    $logoh = $imgsz['h'];
						}

						if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_ITEMS_PICS SET
							filename_logo='".addslashes($CAT_LOGO_DIR.$destination_file)."',
							logo_w=$logow, logo_h=$logoh WHERE file_id='$newimgid'" ) )
						{
						   echo mysqli_error($upd_link_db);
						}
					}*/
				}
			}

			//$mode = "addpicture";
			$mode = "editform";
			$newitemid = $iid = $newitemid;
			break;

		case "delphoto":
			$addphotobut = GetParameter("addphotobut", "");
			$finishbut = GetParameter("finishbut", "");
			$iid = $newitemid = GetParameter("newitemid", 0);
			$photoid = GetParameter("photoid", 0);
			if( $finishbut != "" )
			{
				$mode = "notifydone";
				break;
			}

			if( $photoid != 0 )
			{
				$query = "SELECT * FROM $TABLE_CAT_ITEMS_PICS WHERE file_id='$photoid'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
				    while( $row = mysqli_fetch_object($res) )
				    {
						if( file_exists("../".stripslashes($row->filename)) )
							unlink("../".stripslashes($row->filename));

						if( file_exists("../".stripslashes($row->filename_big)) )
							unlink("../".stripslashes($row->filename_big));

						if( file_exists("../".stripslashes($row->filename_thumb)) )
							unlink("../".stripslashes($row->filename_thumb));

						if( file_exists("../".stripslashes($row->filename_ico)) )
							unlink("../".stripslashes($row->filename_ico));

						//if( file_exists("../".stripslashes($row->filename_logo)) )
						//	unlink("../".stripslashes($row->filename_logo));
					}
					mysqli_free_result($res);
				}

				if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_CAT_ITEMS_PICS WHERE file_id='$photoid'" ) )
				{
				   echo mysqli_error($upd_link_db);
				}
			}

			$videoid = GetParameter("videoid", 0);
			if( $videoid != 0 )
			{
				$query = "DELETE FROM $TABLE_CAT_ITEMS_VIDEO WHERE id='$videoid'";
			    if( !mysqli_query($upd_link_db, $query ) )
			    {
				    echo mysqli_error($upd_link_db);
			    }
			    else
			    {
				    $query = "DELETE FROM $TABLE_CAT_ITEMS_VIDEO_LANGS WHERE item_id='$videoid'";
				    if( !mysqli_query($upd_link_db, $query ) )
				    {
					    echo mysqli_error($upd_link_db);
				    }
			    }
			}

			//$mode = "editpicture";
			$mode = "editform";
			break;

        case "addphoto":
			$phototitle = GetParameter("phototitle", "");
			$photoind = GetParameter("photoind", 0);
			$photodescr = GetParameter("photodescr", "");
			$photofile = GetParameter("photofile", "");
			$photoyoutube = GetParameter("photoyoutube", "");

			$addphotobut = GetParameter("addphotobut", "");
			$finishbut = GetParameter("finishbut", "");
			$iid = $newitemid = GetParameter("newitemid", 0);
			$car_make = GetParameter("car_make", 0);
			$catid = GetParameter("catid", 0);

			//$mode = "addpicture";
			$mode = "editform";
			if( $finishbut != "" )
			{
				$mode = "catalogplace";
				$item_id = $newitemid;
				break;
			}

			if( (trim($photofile) != "") || (trim($photoyoutube) != "") )
			{
				$query = "INSERT INTO $TABLE_CAT_ITEMS_VIDEO (prod_id, add_date, filename, tube_code, filename_ico, src_w, src_h, ico_w, ico_h, sort_num)
					VALUES ('$newitemid', NOW(), '".addslashes($photofile)."', '".addslashes($photoyoutube)."', '', 0, 0, 0, 0, '$photoind')";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
				else
				{
					$videoid = mysqli_insert_id($upd_link_db);

					for( $i=0; $i<count($langs); $i++ )
					{
						$query = "INSERT INTO $TABLE_CAT_ITEMS_VIDEO_LANGS (item_id, lang_id, title, descr) VALUES ('$videoid', '".$langs[$i]."',
							'".addslashes($phototitle)."', '".addslashes($photodescr)."')";
						if( !mysqli_query($upd_link_db, $query ) )
						{
							echo mysqli_error($upd_link_db);
						}
					}
				}
			}


			// Get image name string
			$srccar_model = "";
			$srccar_make = "";

			$query = "SELECT i1.*, ml1.make_name
				FROM $TABLE_CAT_ITEMS i1, $TABLE_CAT_MAKE m1, $TABLE_CAT_MAKE_LANGS ml1
				WHERE i1.id='$newitemid' AND i1.make_id=m1.id AND m1.id=ml1.make_id AND ml1.lang_id='$ENGLANGID'";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object($res) )
				{
					$srccar_model = trim(stripslashes($row->model));
					$srccar_make = trim(stripslashes($row->make_name));
				}
				mysqli_free_result($res);
			}

			//$imgnamestr = MakeLocalImage( $newitemid, $srccar_make, $srccar_model );
			$imgnamestr = $newitemid;

			// Add photo
			$phototitle = GetParameter("phototitle", "");
			$photoind = GetParameter("photoind", 0);

			$photofile = $_FILES['photofile'];
			//$photofile = GetParameter("photofile", "");
			//$photofiletmp = $photofile;
			//$photofile['name'] = $photofile_name;
			//$photofile['tmp_name'] = $photofiletmp;

			if( empty($photofile['name']) || ($photofile['name'] == "") )
				break;

			$point_pos = strrpos($photofile['name'], ".");
			if( $point_pos == -1 )
				break;

			$newfileext = substr($photofile['name'], $point_pos );

			/// Make the name for new file
			srand( time() );
			$inum = 0;
			$newfilename = "";
			while($inum < 100)
			{
				$randval = rand(10000, 99999);
				$newfilename = $imgnamestr."_".$randval.$newfileext;

				echo $newfilename."<br />";

				if( !file_exists("../".$CAT_PHOTO_DIR.$newfilename) )
				{
					break;
				}
				$inum++;
			}
			if( $inum == 100 )
				break;

			//echo "Copy<br />";
			$finalname = $CAT_PHOTO_DIR.$newfilename;

			//$res = ResizeImage( $photofile['tmp_name'], "../".$finalname, strtolower($newfileext), ".jpg", $BIGPIC_W, $BIGPIC_H, false, $JPEG_COMPRESS_RATIO);
			//$res = ResizeImageWithCopy( $photofile['tmp_name'], "../".$finalname, strtolower($newfileext), ".jpg", $PICBIG_W, $PICBIG_H, false, $JPEG_COMPRESS_RATIO, 3);
			//if( !$res )
			//{
			if( !copy($photofile['tmp_name'], "../".$finalname) )
				break;
			chmod( "../".$finalname, 0644 );
			//}

			// Now we should try to get the size of the image
			$imgsz = GetImageSizeAll( "../".$finalname, $newfileext );

			$srcw = 0;
			$srch = 0;
			if( $imgsz != null )
			{
				$srcw = $imgsz['w'];
				$srch = $imgsz['h'];
			}

			if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_ITEMS_PICS (item_id, title, filename, sort_num, src_w, src_h) VALUES
				('$newitemid', '".addslashes($phototitle)."', '".addslashes($finalname)."', '".$photoind."', $srcw, $srch )" ) )
			{
			   echo mysqli_error($upd_link_db);
			}
			else
			{
				// photo was added successfully, so make thumbs - one big for car view, other smaller for catalog view
				$newimgid = mysqli_insert_id($upd_link_db);

				//$destination_file = $newitemid."_".$newimgid.".jpg";
				$destination_file = $imgnamestr."_".$newimgid.".jpg";

				// Make big image
				$res = ResizeImage( "../".$finalname, "../".$CAT_BIG_DIR.$destination_file, strtolower($newfileext), ".jpg", $BIGPIC_W, $BIGPIC_H, false, $JPEG_COMPRESS_RATIO, true, true, $WATERMARK_BIG);

				if( !$res )
					echo trim($it['name']).", Произошла ошибка при создании большого пережатого изображения.<br />";
				else
				{
					$imgsz = GetImageSizeAll( "../".$CAT_BIG_DIR.$destination_file, ".jpg" );

		      		$thw = 0;
		      		$thh = 0;
		      		if( $imgsz != null )
		      		{
		      			$thw = $imgsz['w'];
		      			$thh = $imgsz['h'];
		      		}

                    if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_ITEMS_PICS SET
                    	filename_big='".addslashes($CAT_BIG_DIR.$destination_file)."',
                    	big_w=$thw, big_h=$thh WHERE file_id='$newimgid'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }
                }

				// Make bug thumb
				//$res = ResizeImageWithCopy( "../".$finalname, "../".$CAT_THUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $THUMB_W, $THUMB_H, false, $JPEG_COMPRESS_RATIO);
				$res = ResizeImage( "../".$finalname, "../".$CAT_THUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $THUMB_W, $THUMB_H, false, $JPEG_COMPRESS_RATIO, true, true, $WATERMARK_THUMB);
				//$res = ResizeImageWithCopy( "../".$finalname, "../".$CAT_THUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $THUMB_W, $THUMB_H, false, $JPEG_COMPRESS_RATIO, 2);

				if( !$res )
					echo "Произошла ошибка при создании большого пережатого изображения.<br />";
				else
				{
					$imgsz = GetImageSizeAll( "../".$CAT_THUMB_DIR.$destination_file, ".jpg" );

					$thw = 0;
					$thh = 0;
					if( $imgsz != null )
					{
						$thw = $imgsz['w'];
						$thh = $imgsz['h'];
					}

					if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_ITEMS_PICS SET
						filename_thumb='".addslashes($CAT_THUMB_DIR.$destination_file)."',
						thumb_w=$thw, thumb_h=$thh WHERE file_id='$newimgid'" ) )
					{
					   echo mysqli_error($upd_link_db);
					}
				}

				// Make small thumb
				//$res = ResizeImageWithCopy( "../".$finalname, "../".$CAT_SMTHUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $SMTHUMB_W, $SMTHUMB_H, false, $JPEG_COMPRESS_RATIO);
				$res = ResizeImage( "../".$finalname, "../".$CAT_SMTHUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $SMTHUMB_W, $SMTHUMB_H, false, $JPEG_COMPRESS_RATIO);
				//$res = ResizeImageWithCopy( "../".$finalname, "../".$CAT_SMTHUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $SMTHUMB_W, $SMTHUMB_H, false, $JPEG_COMPRESS_RATIO, 1);
				if( !$res )
					echo "Произошла ошибка при создании малого пережатого изображения.<br />";
				else
				{
					$imgsz = GetImageSizeAll( "../".$CAT_SMTHUMB_DIR.$destination_file, ".jpg" );

					$icow = 0;
					$icoh = 0;
					if( $imgsz != null )
					{
						$icow = $imgsz['w'];
						$icoh = $imgsz['h'];
					}

					if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_ITEMS_PICS SET
						filename_ico='".addslashes($CAT_SMTHUMB_DIR.$destination_file)."',
						ico_w=$icow, ico_h=$icoh WHERE file_id='$newimgid'" ) )
					{
					   echo mysqli_error($upd_link_db);
					}
				}

				// Make logo thumb
				/*
				//$res = ResizeImageWithCopy( "../".$finalname, "../".$CAT_SMTHUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $SMTHUMB_W, $SMTHUMB_H, false, $JPEG_COMPRESS_RATIO);
				$res = ResizeImage( "../".$finalname, "../".$CAT_LOGO_DIR.$destination_file, strtolower($newfileext), ".jpg", $LOGOTHUMB_W, $LOGOTHUMB_H, false, $JPEG_COMPRESS_RATIO);
				//$res = ResizeImageWithCopy( "../".$finalname, "../".$CAT_SMTHUMB_DIR.$destination_file, strtolower($newfileext), ".jpg", $SMTHUMB_W, $SMTHUMB_H, false, $JPEG_COMPRESS_RATIO, 1);
				if( !$res )
					echo "Произошла ошибка при создании малого пережатого изображения.<br />";
				else
				{
					$imgsz = GetImageSizeAll( "../".$CAT_LOGO_DIR.$destination_file, ".jpg" );

					$logow = 0;
					$logoh = 0;
					if( $imgsz != null )
					{
						$logow = $imgsz['w'];
						$logoh = $imgsz['h'];
					}

					if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_ITEMS_PICS SET
						filename_logo='".addslashes($CAT_LOGO_DIR.$destination_file)."',
						logo_w=$logow, logo_h=$logoh WHERE file_id='$newimgid'" ) )
					{
					   echo mysqli_error($upd_link_db);
					}
				}
				*/
			}

			//$mode = "addpicture";
			$mode = "editform";
			break;

		case "videodel":
			$id = GetParameter("id", 0);
			$videoid = GetParameter("videoid", 0);

			$query = "DELETE FROM $TABLE_CAT_ITEMS_VIDEO WHERE id='$videoid'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			else
			{
				$query = "DELETE FROM $TABLE_CAT_ITEMS_VIDEO_LANGS WHERE item_id='$videoid'";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
			$mode = "photos";
			break;

		case "videoed":
			$id = $iid = $item_id = GetParameter("id", 0);
			$videoid = GetParameter("videoid", 0);

			$mode = "editvideoinfo";
			break;

		case "videoupdt":
			$id = $iid = $item_id = GetParameter("id", 0);
			$videoid = GetParameter("videoid", 0);
			$phototitle = GetParameter("phototitle", "");
			$photoind = GetParameter("photoind", 0);
			$photodescr = GetParameter("photodescr", "");
			$photofile = GetParameter("photofile", "");
			$photoyoutube = GetParameter("photoyoutube", "");
			$newitemid = GetParameter("newitemid", "");
			$thismakeid = GetParameter("car_make", "");
			$pi = GetParameter("pi", "");
			$pn = GetParameter("pn", "");
			$catid = GetParameter("catid", "");

			$query = "UPDATE $TABLE_CAT_ITEMS_VIDEO SET sort_num='$photoind', filename='".addslashes($photofile)."',
				tube_code='".addslashes($photoyoutube)."' WHERE id=$videoid";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

			$query = "UPDATE $TABLE_CAT_ITEMS_VIDEO_LANGS SET title='".addslashes($phototitle)."', descr='".addslashes($photodescr)."'
				WHERE item_id=$videoid AND lang_id='$LangId'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

			$mode = "editform";
			break;
	}


	if( $car_make == 0 )
	{
		if( count($makes) > 0 )
		{
			$car_make = $makes[0]['id'];
		}
	}

	$prof_name = "";
?>
<script type='text/javascript' src='../swfobject.js'></script>
<?php
	if( $mode == "editvideoinfo" )
	{
		$newitemid=GetParameter("newitemid",0);
		$catid=GetParameter("catid",0);
		$thismakeid=GetParameter("car_make",0);

		$video = Array();

		$query = "SELECT p1.*, p2.title, p2.descr, YEAR(p1.add_date) as dy, MONTH (p1.add_date) as dm, DAYOFMONTH(p1.add_date) as dd
			FROM $TABLE_CAT_ITEMS_VIDEO p1
			INNER JOIN $TABLE_CAT_ITEMS_VIDEO_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			WHERE p1.id=$videoid";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$piv = Array();

				$piv['id'] = $row->id;
				$piv['alt'] = stripslashes($row->title);
				$piv['descr'] = stripslashes($row->descr);
				$piv['snum'] = $row->sort_num;

				$piv['clip'] = stripslashes($row->filename);
				$piv['clip_w'] = $row->src_w;
				$piv['clip_h'] = $row->src_h;

				$piv['ico'] = stripslashes($row->filename_ico);
				$piv['ico_w'] = $row->ico_w;
				$piv['ico_h'] = $row->ico_h;

				$piv['tubecode'] = stripslashes($row->tube_code);

				$piv['date'] = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);

				$video = $piv;
			}
			mysqli_free_result( $res );
		}
?>
		<br />
		<center><a href="<?=$PHP_SELF;?>?car_make=<?=$thismakeid;?>&item_id=<?=$newitemid;?>&action=edititem&catid=<?=$catid;?>&pn=<?=$pn;?>&pi=<?=$pi;?>">Вернуться назад</a></center>

		<h3>Редактировать информацию о видеоклипе</h3>
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm2" id="addfrm2" enctype="multipart/form-data">
		<input type="hidden" name="action" value="videoupdt" />
		<input type="hidden" name="catid" value="<?=$catid;?>" />
		<input type="hidden" name="videoid" value="<?=$videoid;?>" />
		<input type="hidden" name="car_make" value="<?=$thismakeid;?>" />
		<input type="hidden" name="newitemid" value="<?=$newitemid;?>" />
		<input type="hidden" name="pi" value="<?=$pi;?>" />
		<input type="hidden" name="pn" value="<?=$pn;?>" />
		<table align="center" width="550" cellspacing="0" cellpadding="1" border="0" class="tableborder">
		<tr><td>
	        <table width="100%" cellspacing="1" cellpadding="1" border="0">
	        <tr>
				<td colspan="2" class="fh">Информация о видео</td>
			</tr>
	        <tr>
				<td class="ff">Заголовок для видео:</td>
				<td class="fr">
	                <input type="text" name="phototitle" size="40" value="<?=$video['alt'];?>" />
				</td>
			</tr>
			<tr>
				<td class="ff">Описание видиео:</td>
				<td class="fr">
	                <textarea name="photodescr" cols="50" rows="5"><?=$video['descr'];?></textarea>
				</td>
			</tr>
			<tr>
				<td class="ff">Видео файл:</td>
				<td class="fr">
	                <input type="text" size="30" name="photofile" value="<?=$video['clip'];?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.addfrm2.photofile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" />
				</td>
			</tr>
			<tr>
				<td class="ff">Или youtube код:</td>
				<td class="fr">
					<textarea cols="60" rows="6" name="photoyoutube"><?=$video['tubecode'];?></textarea>
				</td>
			</tr>
			<tr>
				<td class="ff">Порядковый номер:</td>
				<td class="fr">
	                <input type="text" name="photoind" size="2" value="<?=$video['snum'];?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2" class="fr" align="center"><input type="submit" name="applybut" value="Сохранить" /></td>
			</tr>
			</table>
		</td></tr>
		</table>
		</form>
<?php
	}

    if( $mode == "category" )
	{
    	// Now vehicle type was selected so display the list of all types
    	$prod_types = Array();

        $query = "SELECT p1.*, p2.type_name, p2.descr, count(i1.id) as totitems
			FROM $TABLE_CAT_PROFILE p1
			INNER JOIN $TABLE_CAT_PROFILE_LANGS p2 ON p1.id=p2.profile_id AND p2.lang_id='$LangId'
			LEFT JOIN $TABLE_CAT_ITEMS i1 ON p1.id=i1.profile_id
			GROUP BY p1.id
			ORDER BY p2.type_name";
        if( $res = mysqli_query($upd_link_db, $query ) )
        {
            while( $row = mysqli_fetch_object($res) )
            {
				$pti = Array();
                $pti['id'] = $row->id;
                $pti['name'] = stripslashes($row->type_name);
                $pti['descr'] = stripslashes($row->descr);
                $pti['icon_filename'] = stripslashes($row->icon_filename);
                $pti['itnum'] = stripslashes($row->totitems);

            	$prod_types[] = $pti;
            }
            mysqli_free_result($res);
        }

        echo '<h3>Доступные группы товаров по типам</h3>
        <table align="center" cellspacing="2" cellpadding="0">
        <tr>
        	<th>&nbsp;</th>
        	<th>Название типа</th>
        	<th colspan="3">Функции</th>
        </tr>';

        // Output the list of allowed vehicles
        for($i=0; $i<count($prod_types); $i++)
        {
        	echo "<tr>
				<td>&nbsp;</td>
				<td style=\"padding: 1px 10px 1px 10px\"><b>".$prod_types[$i]['name']."</b></td>
				<td style=\"padding: 1px 10px 1px 10px\" align=\"center\"><a href=\"$PHP_SELF?catid=".$prod_types[$i]['id']."\">Редактировать товары</a></td>
				<td style=\"padding: 1px 10px 1px 10px\" align=\"center\"><a href=\"cat_profile_paramval.php?profile_id=".$prod_types[$i]['id']."\">Заполнить параметры товаров</a></td>
				<td style=\"padding: 1px 10px 1px 10px\" align=\"center\"><a href=\"cat_profile_filters.php?profile_id=".$prod_types[$i]['id']."\">Заполнить фильтры товаров</a></td>
			</tr>
			<tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }

        echo '</table><br /><br />';
    }
    else
    {
    	$query = "SELECT p1.*, p2.type_name, p2.descr
			FROM $TABLE_CAT_PROFILE p1, $TABLE_CAT_PROFILE_LANGS p2
			WHERE p1.id='$catid' AND p1.id=p2.profile_id AND p2.lang_id='$LangId'";
        if( $res = mysqli_query($upd_link_db, $query ) )
        {
            while( $row = mysqli_fetch_object($res) )
            {
                $prof_name = stripslashes($row->type_name);
            }
            mysqli_free_result($res);
        }
    }

    //if( ($mode == "addform") || ($mode == "selecttpl") || ($mode == "editformtpl") || ($mode == "addformtpl") || ($mode == "showmodels") )
    if( ($mode == "addformtpl") || ($mode == "addform") || ($mode == "editform") )
    {
    	$totitems = 0;
    	$query = "SELECT count(*) as totitems
	            FROM $TABLE_CAT_ITEMS i1
	            INNER JOIN $TABLE_CAT_PROFILE_LANGS p2 ON i1.profile_id=p2.profile_id AND p2.lang_id='$LangId'
	            INNER JOIN $TABLE_CAT_MAKE_LANGS m2 ON i1.make_id=m2.make_id AND m2.lang_id='$LangId'
	            WHERE i1.profile_id='$catid'";
	    if( $res = mysqli_query($upd_link_db, $query ) )
	    {
	        while( $row = mysqli_fetch_object($res) )
	        {
	        	$totitems = $row->totitems;
	        }
	        mysqli_free_result($res);
	    }
	    else
	    	echo mysqli_error($upd_link_db);

	    $pagesnum = ceil($totitems / $pn);
?>
        <h3>Сохраненные в базе данных товары типа &quot;<?=$prof_name;?>&quot;</h3>
    	<table align="center" cellspacing="2" cellpadding="0" width="800">
    	<tr>
    		<td colspan="2">
    			<form action="<?=$PHP_SELF;?>" name="pagenfrm" style="margin:0; padding:0;">
    			<input type="hidden" name="car_make" value="<?=$car_make;?>" />
    			<input type="hidden" name="catid" value="<?=$catid;?>" />
    			Показывать по: <select name="pn" onchange="javascript:document.forms['pagenfrm'].submit();">
    				<option value="25"<?=($pn == 25 ? " selected" : "");?>>25</option>
    				<option value="50"<?=($pn == 50 ? " selected" : "");?>>50</option>
    				<option value="100"<?=($pn == 100 ? " selected" : "");?>>100</option>
    				<option value="150"<?=($pn == 150 ? " selected" : "");?>>150</option>
    			</select>
    			</form>
    		</td>
    		<td colspan="3" align="right">Страницы:
    		<?php
    			for( $i=1; $i<=$pagesnum; $i++ )
    			{
    				if( $i != 1 )
    					echo " :: ";

    				if( $i == $pi )
    					echo "<b>$i</b>";
    				else
         				echo "<a href=\"$PHP_SELF?car_make=".$car_make."&catid=$catid&pi=$i&pn=".$pn."\">$i</a>";
    			}
    		?>
    		</td>
	    <tr>
	    	<th width="45%">Модель</th>
	    	<th width="10%">Фото</th>
	    	<th width="20%">&nbsp;</th>
	    	<th width="25%">&nbsp;</th>
	    </tr>
<?php

	    $found_items = 0;
	    $query = "SELECT i1.*, p2.type_name, m2.make_name
	            FROM $TABLE_CAT_ITEMS i1, $TABLE_CAT_ITEMS_LANGS i2, $TABLE_CAT_PROFILE p1, $TABLE_CAT_PROFILE_LANGS p2,
	            	$TABLE_CAT_MAKE m1, $TABLE_CAT_MAKE_LANGS m2
	            WHERE p1.id='$catid' AND i1.id=i2.item_id AND i2.lang_id='$LangId' AND i1.profile_id=p1.id AND p1.id=p2.profile_id
	            	AND p2.lang_id='$LangId' AND i1.make_id=m1.id AND m1.id=m2.make_id AND m2.lang_id='$LangId'
	            ORDER BY p2.type_name, m2.make_name, i1.model
	            LIMIT ".( ($pi-1)*$pn ).",$pn";
	    if( $res = mysqli_query($upd_link_db, $query ) )
	    {
	        while( $row = mysqli_fetch_object($res) )
	        {
	            //$engine_type = GetEngineName($row->id, true);
	            //$engine_volume = GetEngineVolume($row->id, true);
	            //$transmition = GetTransmitionType($row->id, true, $LangId);

	            $photocount = 0;

                $query1 = "SELECT count(*) as totitems FROM $TABLE_CAT_ITEMS_PICS WHERE item_id='".$row->id."'";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                    while( $row1 = mysqli_fetch_object($res1) )
                    {
                    	$photocount = $row1->totitems;
                    }
                    mysqli_free_result($res1);
                }

				$isonfirst = false;
                $query1 = "SELECT * FROM $TABLE_CAT_BEST_ITEMS WHERE item_id='".$row->id."'";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                    while( $row1 = mysqli_fetch_object( $res1 ) )
                    {
                    	$isonfirst = true;
                    }
                    mysqli_free_result( $res1 );
                }

                // Now we should extract at least on section
    			$sectname = "";
                $query1 = "SELECT c1.*, c2.name FROM $TABLE_CAT_CATITEMS c1
                	INNER JOIN $TABLE_CAT_CATALOG_LANGS c2 ON c1.sect_id=c2.sect_id AND c2.lang_id='$LangId'
                	WHERE c1.item_id='".$row->id."'";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                    while( $row1 = mysqli_fetch_object($res1) )
                    {
                    	$sectname = stripslashes($row1->name);
                    }
                    mysqli_free_result($res1);
                }

	            $found_items++;

	            echo "<tr>
	                 <td><b>".stripslashes($row->make_name)." ".stripslashes($row->model)."</b><br /><span style=\"font-size: 7pt;\">".$sectname."</span></td>
	                 <td align=\"center\">".$photocount." шт</td>
	                 <td><a href=\"$PHP_SELF?action=usetpl&car_make=$car_make&catid=$catid&pi=$pi&pn=$pn&iid=".$row->id."\">Использовать как шаблон</a></td>
	                 <td align=\"center\">
	                 	<a href=\"$PHP_SELF?car_make=".$car_make."&catid=$catid&action=edititem&pi=$pi&pn=$pn&item_id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;
	                 	<a href=\"$PHP_SELF?car_make=".$car_make."&catid=$catid&action=editpics&pi=$pi&pn=$pn&item_id=".$row->id."\"><img src=\"img/photo.gif\" width=\"24\" height=\"20\" border=\"0\" alt=\"".$strings['tipeditp'][$lang]."\" /></a>&nbsp;
	                 	<a href=\"$PHP_SELF?car_make=".$car_make."&catid=$catid&action=deleteitem&pi=$pi&pn=$pn&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;";
	            if( !$isonfirst )
	            {
	                 echo "<a href=\"cat_best.php?action=addto&car_make=".$car_make."&catid=$catid&item_id=".$row->id."\"><img src=\"img/assign.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipassign'][$lang]."\" /></a>&nbsp;";
	            }
	                 	echo "</td>
	                </tr>
	                <tr><td colspan=\"4\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
	        }
	        mysqli_free_result($res);
	    }
	    else
	        echo mysqli_error($upd_link_db);

        if( $found_items == 0 )
        {
            echo "<tr><td colspan=\"4\" align=\"center\"><br />В базе нет товаров<br /><br /></td></tr>
            <tr><td colspan=\"4\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
            //echo "<tr><td align=\"center\" colspan=\"4\"><input type=\"submit\" name=\"apply_but\" value=\" Применить \" /></td></tr>";
        }
	?>
	    </table>
<?php
    }

    //if( ($mode == "addform") || ($mode == "editformtpl")  || ($mode == "addformtpl") || ($mode == "showmodels") )
    if( ($mode == "addformtpl") || ($mode == "addform") || ($mode == "editform") )
    {
    	$vehicle_category = "Unknown";

		// The vehicle type is selected so now we should extract the name of selected vehicle type
        $query = "SELECT p1.*, p2.type_name, p2.descr
			FROM $TABLE_CAT_PROFILE p1, $TABLE_CAT_PROFILE_LANGS p2
			WHERE p1.id='$catid' AND p1.id=p2.profile_id AND p2.lang_id='$LangId'";
        if( $res = mysqli_query($upd_link_db, $query ) )
        {
            if( $row = mysqli_fetch_object($res) )
            {
            	$vehicle_category = stripslashes($row->type_name);
            }
            mysqli_free_result($res);
        }
        else
        	echo mysqli_error($upd_link_db);

        ////////////////////////////////////////////////////////////////////////
        // If we use template item to fill in the form, then get data
        //$tplitem = Array();

        if( ($mode == "addformtpl") || ($mode == "editform") )
        {
            $query = "SELECT i1.*, il1.item_id, il1.descr, il1.descr0, il1.page_title, il1.page_keywords, il1.page_descr FROM $TABLE_CAT_ITEMS i1, $TABLE_CAT_ITEMS_LANGS il1
            	WHERE i1.id='$iid' AND i1.id=il1.item_id AND il1.lang_id='$LangId'";

            if( $res = mysqli_query($upd_link_db, $query ) )
            {
                if( $row = mysqli_fetch_object($res) )
                {
                	//echo stripslashes($row->model)."<br />";
					$car_model = stripslashes($row->model);
					$car_profile = $row->profile_id;
					$car_make = $row->make_id;
					$car_art = stripslashes($row->articul);
					//$car_complect = stripslashes($row->make_style);
					$car_descr = stripslashes($row->descr);
					$car_descr0 = stripslashes($row->descr0);
					$page_title = stripslashes($row->page_title);
					$page_key = stripslashes($row->page_keywords);
					$page_descr = stripslashes($row->page_descr);

					$car_status = $row->status;


					// Now we should extract at least on section
     				$catsect = 0;
	                $query1 = "SELECT * FROM $TABLE_CAT_CATITEMS WHERE item_id='".$row->id."'";


	                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	                {
	                    while( $row1 = mysqli_fetch_object($res1) )
	                    {
	                    	$catsect = $row1->sect_id;
	                    }
	                    mysqli_free_result($res1);
	                }

	                $car_price = "0.00";
	                $query1 = "SELECT * FROM $TABLE_CAT_PRICES WHERE item_id='".$row->id."'";
					if( $res1 = mysqli_query($upd_link_db, $query1 ) )
					{
						while( $row1 = mysqli_fetch_object( $res1 ) )
						{
							$car_price = str_replace(",", ".", $row1->price);
						}
						mysqli_free_result( $res1 );
					}
                }
                mysqli_free_result($res);


            }

        }
        else
        {
			$car_model = "";
			$car_profile = 0;
			$car_make = ($mode == "showmodels" ? $car_make : 0);
			$car_art = "";
			$car_status = 0;
			//$car_body = 0;
			//$car_complect = "";
			$car_descr = "";
			$car_descr0 = "";
			$page_title="";
			$page_key="";
			$page_descr="";

			$car_price = "0.00";

        }

        ////////////////////////////////////////////////////////////////////////
        // Now we should build the table of all parameters

        ////////////////////////////////////////////////////////////////////////
        // Print table
        if( $mode == "editform" )
        {
			echo '<h3>Редактировать Товар</h3>';
        }
        else
        {
        	echo '<h3>Добавить Новый Товар</h3>';
        }
?>
    	<table align="center" width="750" cellspacing="0" cellpadding="1" border="0" class="tableborder">
	    <tr><td>
	        <table width="100%" cellspacing="1" cellpadding="1" border="0">
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm" id="addfrm" enctype="multipart/form-data">
		<input type="hidden" name="action" value="<?=($mode == "editform" ? "updatecar" : "addcar");?>" />
		<input type="hidden" name="pi" value="<?=$pi;?>" />
		<input type="hidden" name="pn" value="<?=$pn;?>" />
<?php
		if( $mode == "editform" )
		{
        	echo '<input type="hidden" name="item_id" value="'.$iid.'" />';
        }
?>
		<input type="hidden" name="catid" value="<?=$catid;?>" />
		<tr>
			<td colspan="2" class="fh">Основные Параметры</td>
		</tr>
        <tr>
			<td class="ff">Бренд товара:</td>
			<td class="fr">
				<select name="car_make">
<?php
/*
				<select name="car_make" <?=($mode != "editformtpl" ? "onchange=\"javascript:document.forms['addfrm'].submit();\"" : "");?>>
*/
?>
<?php
			for( $i=0; $i<count($makes); $i++ )
			{
            	echo "<option value=\"".$makes[$i]['id']."\"".($makes[$i]['id'] == $car_make ? " selected " : "").">".$makes[$i]['name']."</option>";
            }

            echo "</select>";

			/*
            if( $mode != "editformtpl" )
            {
?>
				<input type="submit" name="filltplbut" value="Заполнить из шаблона" />
<?php
			}
			*/
?>
			</td>
		</tr>
		<tr>
			<td class="ff">Раздел каталога:</td>
			<td class="fr">
				<select name="catsect">
				<option value="0">--- Корневой раздел ---</option>
<?php
			$THIS_TABLE = $TABLE_CAT_CATALOG;
			$THIS_TABLE_LANG = $TABLE_CAT_CATALOG_LANGS;
			$THIS_TABLE_P2P = $TABLE_CAT_CATITEMS;

			PrintWorkCatalog(0, $LangId, 1, "select", $catsect);
?>
				</select>
			</td>
		</tr>
        <tr>
			<td class="ff">Модель:</td>
			<td class="fr">
                <input type="text" name="car_model" size="50" value="<?=$car_model;?>" /> <span class="smalltext">Например: VWIC-2MFT-G.703</span>
			</td>
		</tr>
		<tr>
			<td class="ff">Артикул:</td>
			<td class="fr">
                <input type="text" name="car_art" size="30" value="<?=$car_art;?>" />
			</td>
		</tr>
		<tr>
			<td class="ff">Статус:</td>
			<td class="fr">
                <select name="car_status">
                	<option value="0"> ------- </option>
                	<option value="1" <?=($car_status == 1 ? " selected" : "");?>> Новинка </option>
                	<option value="2" <?=($car_status == 2 ? " selected" : "");?>> Акционный </option>
                	<option value="3" <?=($car_status == 3 ? " selected" : "");?>> Спеццена </option>
                	<option value="4" <?=($car_status == 4 ? " selected" : "");?>> Скоро в продаже </option>
                </select>
			</td>
		</tr>
		<tr>
			<td class="ff">Цена:</td>
			<td class="fr">
                <input type="text" name="car_price" value="<?=$car_price;?>" />
			</td>
		</tr>
		<tr><td class="ff">Title:</td><td class="fr"><input type="text" size="70" name="page_title" value="<?=$page_title;?>" /></td></tr>
		<tr><td class="ff">Keywords:</td><td class="fr"><textarea rows="2" cols="70" name="page_key"><?=$page_key;?></textarea></td></tr>
		<tr><td class="ff">Description:</td><td class="fr"><textarea rows="4" cols="70" name="page_descr"><?=$page_descr;?></textarea></td></tr>
		<tr>
			<td class="ff">Краткое описание (для списка товаров):</td>
			<td class="fr">
				<textarea name="car_descr0" cols="70" rows="4"><?=$car_descr0;?></textarea>
				<script language="javascript1.2">
				editor_generate('car_descr0'); // field, width, height
				</script>
			</td>
		</tr>
		<tr>
			<td class="ff">Основное описание:</td>
			<td class="fr">
				<textarea name="car_descr" cols="70" rows="14"><?=$car_descr;?></textarea>
				<script language="javascript1.2">
				editor_generate('car_descr'); // field, width, height
				</script>
			</td>
		</tr>
<?php
		////////////////////////////////////////////////////////////////////////
		// SHOW PARAMETERS
		//$file_param_ind = 0;
		$query = "SELECT p1.*, p3.name, p3.izm, p3.sample,p2.group_id as groupid, p4.sort_num as sort_group, p5.name as group_name
        	FROM $TABLE_CAT_PROFILE_PARAMS p2
        	INNER JOIN $TABLE_CAT_PARAMS p1 ON p2.param_id=p1.id
        	INNER JOIN $TABLE_CAT_PARAMS_LANGS p3 ON p1.id=p3.param_id AND p3.lang_id='$LangId'
        	INNER JOIN $TABLE_CAT_GROUP_PARAM p4 ON p2.group_id=p4.id
        	INNER JOIN $TABLE_CAT_GROUP_PARAM_LANGS p5 ON p4.id=p5.item_id AND p5.lang_id='$LangId'
        	WHERE p2.profile_id='$catid'
        	ORDER BY p4.sort_num, p2.sort_ind, p3.name";

		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			$gr_id=0;
			while( $row = mysqli_fetch_object($res) )
			{
				if( $gr_id != $row->groupid )
				{
					echo '<tr><td colspan="2" class="fh">'.stripslashes($row->group_name).'</td></tr>';
					$gr_id = $row->groupid;
				}

				$class_str = ( $row->isbasic == 1 || $row->isbasic == 3 ? "basic" : "sec" );
				$param_izm = ($row->izm == "" ? "" : "(".stripslashes($row->izm).")");

				if( $row->sample != "" )
					$sample_str = "<span class=\"smalltext\">Например: ".stripslashes($row->sample)." </span>";
				else
					$sample_str = "";

            	echo "<tr>
					<td class=\"td".$class_str."_l\">".stripslashes($row->name)." $param_izm:</td>
					<td class=\"td".$class_str."_r\">";
				if( $row->param_display_type_id == $FIELD_TYPE_OPTIONS )
				{
					echo "<input type=\"hidden\" name=\"paramopt_ids[]\" value=\"".$row->id."\" />";
				}
				else
				{
					echo "<input type=\"hidden\" name=\"param_ids[]\" value=\"".$row->id."\" />";
					echo "<input type=\"hidden\" name=\"param_types[]\" value=\"".$row->param_display_type_id."\" />";
				}

				//////////////////////////////////////////////////////////////////////////////////
				// If we open the form in template mode then we should init values from template
				if( ($mode == "addformtpl") || ($mode == "editform") )
				{
					$param_tpl_value = "";

					$query1 = "SELECT * FROM $TABLE_CAT_PARAM_VALUES WHERE item_id='$iid' AND param_id='".$row->id."' AND lang_id='$LangId'";
					if( $res1 = mysqli_query($upd_link_db, $query1 ) )
					{
					    if( $row1 = mysqli_fetch_object($res1) )
					    {
					       	$param_tpl_value = stripslashes($row1->value);
					    }
					    mysqli_free_result($res1);
					}

					//echo $param_tpl_value;
				}
				//////////////////////////////////////////////////////////////////////////////////

				switch( $row->param_display_type_id )
				{
					case $FIELD_TYPE_EDIT:	// 1
						echo "<input type=\"text\" name=\"param".$row->id."\" ".( ( ($mode == "addformtpl") || ($mode == "editform") ) ? "value=\"$param_tpl_value\"" : "" )." /> ".$sample_str;
						break;

                    case  $FIELD_TYPE_SELECT:	// 2
						echo "<select name=\"param".$row->id."\">";

                        // Extract all option values for this parameter and print
						$query1 = "SELECT o1.*, o2.option_text
							FROM $TABLE_CAT_PARAM_OPTIONS o1, $TABLE_CAT_PARAM_OPTIONS_LANGS o2
							WHERE o1.param_id='".$row->id."' AND o1.id=o2.option_id AND o2.lang_id='$LangId'
							ORDER BY o1.sort_ind";
						if( $res1 = mysqli_query($upd_link_db, $query1 ) )
						{
							while( $row1 = mysqli_fetch_object($res1) )
							{
								echo "<option value=\"".$row1->id."\"".( ( (($mode == "editform") || ($mode == "addformtpl")) && ($row1->id==$param_tpl_value)) ? " selected " : "" ).">".stripslashes($row1->option_text)."</option>";
						    }
						    mysqli_free_result($res1);
						}

						echo "</select>";
						break;

					case $FIELD_TYPE_OPTIONS:	// 3
						//$item_id=GetParameter("item_id", 0);
						if( ($mode == "editform") || ($mode == "addformtpl") )
						{
							$query1 = "SELECT o.option_id FROM $TABLE_CAT_PARAM_VALUES v
								INNER JOIN $TABLE_CAT_PARAM_VALUES_OPTS o ON v.id=o.param_value_id
								WHERE v.param_id='".$row->id."' AND v.lang_id='0' AND v.item_id='$iid'";
							if( $res1 = mysqli_query($upd_link_db,$query1) )
							{
								$optval = Array();
								while( $row1 = mysqli_fetch_object($res1) )
								{
									$optval[] = $row1->option_id;
								}
								mysqli_free_result($res1);
							}
							else
								echo mysqli_error($upd_link_db);
						}

						//var_dump( $optval );
						//echo "<select multiple=true  name='param".$row->id."_opts[]' style=\"height: 200px;\">";
						$query1 = "SELECT o1.*, o2.option_text
								FROM $TABLE_CAT_PARAM_OPTIONS o1, $TABLE_CAT_PARAM_OPTIONS_LANGS o2
								WHERE o1.param_id='".$row->id."' AND o1.id=o2.option_id AND o2.lang_id='$LangId'
								ORDER BY o1.sort_ind";
						if( $res1 = mysqli_query($upd_link_db, $query1 ) )
						{
						    while( $row1 = mysqli_fetch_object($res1) )
						    {
								//echo "<option value=\"".$row1->id."\"".( ( (($mode == "editform") || ($mode == "addformtpl")) && (in_array($row1->id, $optval))) ? " selected " : "" ).">".$row1->sort_ind." ".stripslashes($row1->option_text)."</option>";
								echo '<input type="checkbox" name="param'.$row->id.'_opts[]" value="'.$row1->id.'" '.( ( (($mode == "editform") || ($mode == "addformtpl")) && (in_array($row1->id, $optval))) ? ' checked="checked" ' : '' ).' /> '.stripslashes($row1->option_text).'<br />';
						    }
						    mysqli_free_result($res1);
						}

						//echo "</select>   Зажмите ctrl для множественного выбора";
						break;

					case $FIELD_TYPE_FLAG:		// 4
						echo "<input type=\"checkbox\" name=\"param".$row->id."\" value=\"1\" ".( ( (($mode == "editform") || ($mode == "addformtpl")) && ($param_tpl_value == 1)) ? " checked " : "" )." /> <span class=\"smalltext\">Да/Нет</span>";
						break;

					case $FIELD_TYPE_TEXTAREA:	// 5
						echo "<textarea cols=\"50\" rows=\"6\" name=\"param".$row->id."\">".( (($mode == "editform") || ($mode == "addformtpl")) ? $param_tpl_value : "" )."</textarea>";//".$sample_str;
						break;

					case $FIELD_TYPE_HTML:		// 6
						echo "<textarea cols=\"60\" rows=\"10\" name=\"param".$row->id."\">".( (($mode == "editform") || ($mode == "addformtpl")) ? $param_tpl_value : "" )."</textarea>";//".$sample_str;
						echo "<script language=\"javascript1.2\">
						  	editor_generate('"."param".$row->id."'); // field, width, height
						</script>";
						break;

					case $FIELD_TYPE_RADIO:		// 7
						// Extract all option values for this parameter and print
						$query1 = "SELECT o1.*, o2.option_text
							FROM $TABLE_CAT_PARAM_OPTIONS o1, $TABLE_CAT_PARAM_OPTIONS_LANGS o2
							WHERE o1.param_id='".$row->id."' AND o1.id=o2.option_id AND o2.lang_id='$LangId'
							ORDER BY o1.sort_ind";
						if( $res1 = mysqli_query($upd_link_db, $query1 ) )
						{
							while( $row1 = mysqli_fetch_object($res1) )
							{
								echo "<input type=\"radio\" name=\"param".$row->id."\" value=\"".$row1->id."\"".( ((($mode == "editform") || ($mode == "addformtpl")) && ($row1->id==$param_tpl_value)) ? " checked " : "" )." />".stripslashes($row1->option_text)."<br />";
							}
							mysqli_free_result($res1);
						}
						break;

					case $FIELD_TYPE_FILE:	// 8
						echo "<input type=\"text\" size=\"30\" name=\"param".$row->id."\" value=\"".( (($mode == "editform") || ($mode == "addformtpl")) ? $param_tpl_value : "" )."\" /><input type=\"button\" value=\" Выбрать файл \" onclick=\"javascript:MM_openBrWindow('cat_files.php?hide=1&lang=".$lang."&target=self.opener.document.addfrm."."param".$row->id."','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');\" />";
						break;
				}

				echo "</td>
				</tr>";
			}
			mysqli_free_result($res);
		}
		else
			mysqli_error($upd_link_db);


		////////////////////////////////////////////////////////////////////////
		// SHOW FILTERS
		$query = "SELECT p1.*, p3.name
			FROM $TABLE_CAT_PROFILE_FILTERS p2
			INNER JOIN $TABLE_CAT_FILTERS p1 ON p2.param_id=p1.id
			INNER JOIN $TABLE_CAT_FILTERS_LANGS p3 ON p1.id=p3.param_id AND p3.lang_id='$LangId'
			WHERE p2.profile_id='$catid'
			ORDER BY p2.sort_ind";

		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			echo '<tr><td colspan="2" class="fh">Фильтры товара</td></tr>';
			while( $row = mysqli_fetch_object($res) )
			{
				$class_str = ( $row->isbasic == 2 ? "basic" : "sec" );

				echo "<tr>
				<td class=\"td".$class_str."_l\">".stripslashes($row->name)."</td>
				<td  class=\"td".$class_str."_r\">";
				if( $row->param_display_type_id == $FIELD_TYPE_OPTIONS )
				{
					echo "<input type=\"hidden\" name=\"filteropt_ids[]\" value=\"".$row->id."\" />";
				}
				else
				{
					echo "<input type=\"hidden\" name=\"filter_ids[]\" value=\"".$row->id."\" />
					<input type=\"hidden\" name=\"filter_types[]\" value=\"".$row->param_display_type_id."\" />";
				}

				// If we open the form in template mode then we should init values from template
				if( ($mode == "addformtpl") || ($mode == "editform") )
				{
					$filter_tpl_value = "";

					$query1 = "SELECT * FROM $TABLE_CAT_FILTER_VALUES WHERE item_id='$iid' AND param_id='".$row->id."'";
					//echo
					if( $res1 = mysqli_query($upd_link_db, $query1 ) )
					{
						if( $row1 = mysqli_fetch_object($res1) )
						{
							$filter_tpl_value = stripslashes($row1->value);
						}
						mysqli_free_result($res1);
					}
				}

                switch( $row->param_display_type_id )
                {
                	case $FIELD_TYPE_SELECT:	// 2
                		echo "<select name=\"filt".$row->id."\">";

						$query1 = "SELECT o1.*, o2.option_text
							FROM $TABLE_CAT_PROFILE_FILT_OPTIONS o1, $TABLE_CAT_PROFILE_FILT_OPTIONS_LANGS o2
							WHERE o1.param_id='".$row->id."' AND o1.id=o2.option_id AND o2.lang_id='$LangId'
							ORDER BY o1.sort_ind";
						if( $res1 = mysqli_query($upd_link_db, $query1 ) )
						{
							while( $row1 = mysqli_fetch_object($res1) )
							{
								echo "<option value=\"".$row1->id."\"".( ( (($mode == "editform") || ($mode == "addformtpl")) && ($row1->id==$filter_tpl_value)) ? " selected " : "" ).">".stripslashes($row1->option_text)."</option>";
							}
							mysqli_free_result($res1);
						}

						echo "</select>";
						break;

					case $FIELD_TYPE_OPTIONS:	// 3
						if( ($mode == "editform") || ($mode == "addformtpl") )
						{
							$query1 = "SELECT o.option_id FROM $TABLE_CAT_FILTER_VALUES v
								INNER JOIN $TABLE_CAT_FILTER_VALUES_OPTS o ON v.id=o.param_value_id
								WHERE v.param_id='".$row->id."' AND v.item_id='$iid'";
							if( $res1 = mysqli_query($upd_link_db,$query1) )
							{
								$optval = Array();
								while( $row1 = mysqli_fetch_object($res1) )
								{
									$optval[] = $row1->option_id;
								}
								mysqli_free_result($res1);
							}
							else
								echo mysqli_error($upd_link_db);
						}

						$query1 = "SELECT o1.*, o2.option_text
								FROM $TABLE_CAT_PROFILE_FILT_OPTIONS o1, $TABLE_CAT_PROFILE_FILT_OPTIONS_LANGS o2
								WHERE o1.param_id='".$row->id."' AND o1.id=o2.option_id AND o2.lang_id='$LangId'
								ORDER BY o1.sort_ind";
						if( $res1 = mysqli_query($upd_link_db, $query1 ) )
						{
						    while( $row1 = mysqli_fetch_object($res1) )
						    {
								echo '<input type="checkbox" name="filt'.$row->id.'_opts[]" value="'.$row1->id.'" '.( ( (($mode == "editform") || ($mode == "addformtpl")) && (in_array($row1->id, $optval))) ? ' checked="checked" ' : '' ).' /> '.stripslashes($row1->option_text).'<br />';
						    }
						    mysqli_free_result($res1);
						}
						break;

					case $FIELD_TYPE_FLAG:		// 4
						echo "<input type=\"checkbox\" name=\"filt".$row->id."\" value=\"1\" ".( ( (($mode == "editform") || ($mode == "addformtpl")) && ($param_tpl_value == 1)) ? " checked " : "" )." /> <span class=\"smalltext\">Да/Нет</span>";
						/*
						$query1 = "SELECT o1.*, o2.option_text
							FROM $TABLE_CAT_PROFILE_FILT_OPTIONS o1, $TABLE_CAT_PROFILE_FILT_OPTIONS_LANGS o2
							WHERE o1.param_id='".$row->id."' AND o1.id=o2.option_id AND o2.lang_id='$LangId'
							ORDER BY o1.sort_ind";
						if( $res1 = mysqli_query($upd_link_db, $query1 ) )
						{
							while( $row1 = mysqli_fetch_object($res1) )
							{
								$queryff = mysqli_query($upd_link_db,"SELECT * FROM $TABLE_CAT_FILTER_VALUES WHERE item_id='$iid' AND param_id='".$row->id."' AND value='".$row1->id."'");
								if(mysqli_num_rows($queryff)>0)
								{
									echo "<input type=\"checkbox\" name=\"filt".$row->id."[]\" value=\"".$row1->id."\" checked /> <span class=\"smalltext\">".stripslashes($row1->option_text)."</span>";
								}
								else
								{
									echo "<input type=\"checkbox\" name=\"filt".$row->id."[]\" value=\"".$row1->id."\"  /> <span class=\"smalltext\">".stripslashes($row1->option_text)."</span>";
								}
								mysqli_free_result($queryff);
							}
							mysqli_free_result($res1);
						}
						*/
						break;
				}

				echo "</td>
				</tr>";
			}
		}

		////////////////////////////////////////////////////////////////////////////////////
		/*
?>
			<tr><td colspan="2" class="fh">Для каких моделей авто:</td></tr>
			<tr>
				<td class="ff">Модели:</td>
				<td class="fr">
					<select name="it2car[]" multiple="multiple" style="width: 300px; height: 340px;">
						<option value="-1">---- Подходит для всех ----</option>
		<?php
			$prev_brand_id = 0;
			if( $res = mysqli_query($upd_link_db,"SELECT m1.*, b1.carmake, i1.id as assignid
				FROM $TABLE_CAR_BRAND b1
				INNER JOIN $TABLE_CAR_MODEL m1 ON b1.id=m1.brand_id
				LEFT JOIN $TABLE_CAR_MODELITEMS i1 ON m1.id=i1.model_id AND i1.item_id='$iid'
				ORDER BY b1.carmake,m1.carmodel") )
			{
				while($row=mysqli_fetch_object($res))
				{
					if( $prev_brand_id != $row->brand_id )
					{
						echo '<option value="0" style="font-weight: bold; background: #e0e0e0">'.stripslashes($row->carmake).'</option>';
						$prev_brand_id = $row->brand_id;
					}
					echo '<option value="'.$row->id.'"'.($row->assignid != null ? ' selected' : '').'>&nbsp;&nbsp;&nbsp;'.stripslashes($row->carmodel).'</option>';
				}
				mysqli_free_result($res);
			}
			else
				$mysqlerr = mysqli_error($upd_link_db);
		?>
					</select>
					<?=$mysqlerr;?>
				</td>
			</tr>
<?php
		*/
?>
			</table>
		</td></tr>
		</table>
<?php
		if( $mode == "addform" )
		{
?>
			<h3>Фото Товара</h3>
			<table align="center" width="550" cellspacing="0" cellpadding="1" border="0" class="tableborder">
			<tr><td>
				<table width="100%" cellspacing="1" cellpadding="1" border="0">
				<tr>
					<td colspan="2" class="fh">Добавить фото к объявлению</td>
				</tr>
				<tr>
					<td class="ff">Заголовок для фото:</td>
					<td class="fr">
						<input type="text" name="phototitle" size="40" />
					</td>
				</tr>
				<tr>
					<td class="ff">Фото файл (*.jpg, *.png, *.gif):</td>
					<td class="fr">
						<input type="file" name="photofile" />
					</td>
				</tr>
				</table>
			</td></tr>
			</table>
			<br />

			<h3>Видео Товара</h3>
			<table align="center" width="550" cellspacing="0" cellpadding="1" border="0" class="tableborder">
			<tr><td>
				<table width="100%" cellspacing="1" cellpadding="1" border="0">
				<tr>
					<td colspan="2" class="fh">Добавить видео</td>
				</tr>
				<tr>
					<td class="ff">Заголовок видео:</td>
					<td class="fr">
						<input type="text" name="phototitle" size="40" />
					</td>
				</tr>
				<tr>
					<td class="ff">Описание видео:</td>
					<td class="fr">
						<textarea name="photodescr" cols="50" rows="8"></textarea>
					</td>
				</tr>
				<tr>
					<td class="ff">Видео файл (*.flv):</td>
					<td class="fr">
						<input type="text" size="30" name="photofile2" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.addfrm.photofile2','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" />
					</td>
				</tr>
				<tr>
					<td class="ff">Или youtube код:</td>
					<td class="fr">
						<textarea cols="60" rows="6" name="photoyoutube"></textarea>
					</td>
				</tr>
				<tr>
					<td class="ff">Порядковый номер:</td>
					<td class="fr">
						<input type="text" name="photoind" size="2" />
					</td>
				</tr>
				</table>
			</td></tr>
			</table>
<?php
		}
?>
		<table width="100%" border="0">
		<tr>
			<td colspan="2" class="fr" align="center"><input type="submit" name="addnewbut" value=" <?=($mode != "editform" ? "Добавить" : "Применить");?> " /></td>
		</tr>
		</table>
		</form>
<?php
	}

   	//if( ($mode == "addpicture") || ($mode == "editpicture") )
	if( $mode == "editform" )
	{
		$thismakeid = 0;
		$catid = 0;
		$query = "SELECT * FROM $TABLE_CAT_ITEMS WHERE id='$newitemid'";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
		 	{
		 		$thismakeid = $row->make_id;
		 		$catid = $row->profile_id;
		  	}
		  	mysqli_free_result( $res );
		}

		////////////////////////////////////////////////////////////////////////
		// Now we should show all added photos
		$photos = Array();
		$query = "SELECT * FROM $TABLE_CAT_ITEMS_PICS WHERE item_id='$newitemid' ORDER BY sort_num";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object($res) )
			{
				$item['filename'] = stripslashes($row->filename);
				$item['thumb'] = "../".stripslashes($row->filename_thumb); //"../".$NEWADV_THUMB_DIR.$newitemid."_".$row->file_id.".jpg";
				$item['ico'] = "../".stripslashes($row->filename_ico);
				$item['title'] = stripslashes($row->title);
				$item['id'] = $row->file_id;

				$photos[] = $item;
			}
			mysqli_free_result($res);
		}
?>
		<h3>Фото Товара</h3>
		<table align="center" width="550" cellspacing="0" cellpadding="1" border="0" class="tableborder">
		<tr><td>
			<table width="100%" cellspacing="1" cellpadding="1" border="0">
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm4" enctype="multipart/form-data">
		<input type="hidden" name="action" value="addphoto" />
		<input type="hidden" name="catid" value="<?=$catid;?>" />
		<input type="hidden" name="car_make" value="<?=$thismakeid;?>" />
		<input type="hidden" name="newitemid" value="<?=$newitemid;?>" />
		<input type="hidden" name="pi" value="<?=$pi;?>" />
		<input type="hidden" name="pn" value="<?=$pn;?>" />
<?php
		if( $mode == "editpicture" )
		{
			//echo '<input type="hidden" name="item_id" value="'.$item_id.'" />';
		}

		if( count($photos) > 0 )
		{
			echo "<tr><td colspan=\"2\" class=\"fh\">Фото товара</td></tr>";

			for($i=0; $i<count($photos); $i++)
			{
				echo "<tr>
				<td colspan=\"2\" class=\"fr\" style=\"padding: 3px 3px 3px 3px;\">
					<table border=\"0\" align=\"center\">
					<tr>
						<td><img src=\"".$photos[$i]['thumb']."\" alt=\"".$photos[$i]['title']."\" /></td>
						<td><a href=\"$PHP_SELF?action=delphoto&catid=$catid&newitemid=$newitemid&pi=$pi&pn=$pn&photoid=".$photos[$i]['id']."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить фотографию\" /></a></td>
					</tr>
					</table>
				</td>
				</tr>";
			}
		}
?>
		<tr>
			<td colspan="2" class="fh">Добавить фото к объявлению</td>
		</tr>
		<tr>
			<td class="ff">Заголовок для фото:</td>
			<td class="fr">
				<input type="text" name="phototitle" size="40" />
			</td>
		</tr>
		<tr>
			<td class="ff">Фото файл (*.jpg, *.png, *.gif):</td>
			<td class="fr">
				<input type="file" name="photofile" />
			</td>
		</tr>
		<tr>
			<td class="ff">Порядковый номер:</td>
			<td class="fr">
				<input type="text" name="photoind" size="2" maxlength="2" />
			</td>
		</tr>
		<tr>
			<td class="fr" colspan="2" align="center">
				<input type="submit" name="addphotobut" value=" Добавить фото " /> &nbsp; <input type="submit" name="finishbut" value=" Сохранить объявление " />
			</td>
		</tr>
		</form>
			</table>
		</td></tr>
		</table>
<?php
		$video = Array();

		$query = "SELECT p1.*, p2.title, p2.descr, YEAR(p1.add_date) as dy, MONTH (p1.add_date) as dm, DAYOFMONTH(p1.add_date) as dd
			FROM $TABLE_CAT_ITEMS_VIDEO p1
			INNER JOIN $TABLE_CAT_ITEMS_VIDEO_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			WHERE p1.prod_id=$newitemid
			ORDER BY p1.sort_num,p1.add_date";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$piv = Array();

				$piv['id'] = $row->id;
				$piv['alt'] = stripslashes($row->title);
				$piv['snum'] = $row->sort_num;

				$piv['clip'] = stripslashes($row->filename);
				$piv['clip_w'] = $row->src_w;
				$piv['clip_h'] = $row->src_h;

				$piv['ico'] = stripslashes($row->filename_ico);
				$piv['ico_w'] = $row->ico_w;
				$piv['ico_h'] = $row->ico_h;

				$piv['tubecode'] = stripslashes($row->tube_code);

				$piv['date'] = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);

				$video[] = $piv;
			}
			mysqli_free_result( $res );
		}
?>
		<h3>Видео-ролики товара</h3>
		<table cellspacing="10" cellpadding="0" width="100%" border="0">
<?php
		if( count($video) > 0 )
		{
			for($i=0; $i<count($video); $i++)
			{
				echo "<tr>
				<td align=\"center\">";

				if( trim($video[$i]['tubecode']) != "" )
				{
					echo '<div style="padding: 0px 0px 0px 0px; text-align: center;">'.html_entity_decode(trim($video[$i]['tubecode']), ENT_COMPAT).'</div>';
				}
				else
				{
					//echo '<embed src="'.$FILE_DIR.$orglogo.'" style="width: 300px;" loop="false" autostart="false" volume="25" hidden="false"></embed>';
?>
					<div id='mediaspace<?=$i;?>'>This text will be replaced</div>

					<script type='text/javascript'>
					  var so<?=$i;?> = new SWFObject('../player.swf','ply','310','270','9','#ffffff');
					  so<?=$i;?>.addParam('allowfullscreen','true');
					  so<?=$i;?>.addParam('allowscriptaccess','always');
					  so<?=$i;?>.addParam('wmode','opaque');
					  so<?=$i;?>.addVariable('file','<?=($WWWHOST.'files/'.$video[$i]['clip']);?>');
					  so<?=$i;?>.write('mediaspace<?=$i;?>');
					</script>
					<br />
<?php
				}

				//echo "<a href=\"$PHP_SELF?item_id=$item_id&action=photodel&photoid=".$photos[$i]['id']."\">Удалить</a><br />";
				echo "</td>
				<td><img src=\"".$video[$i]['ico']."\" width=\"".$video[$i]['ico_w']."\" height=\"".$video[$i]['ico_h']."\" style=\"border: 1px solid #b0b0b0;\" alt=\"".$video[$i]['alt']."\" /></td>
				<td style=\"padding: 3px 0px 5px 0px\">№ сорт. ".$video[$i]['snum']."</td>
				<td>
					<a href=\"$PHP_SELF?car_make=$thismakeid&action=delphoto&catid=$catid&newitemid=$newitemid&pi=$pi&pn=$pn&videoid=".$video[$i]['id']."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить видео\" /></a>&nbsp;
					<a href=\"$PHP_SELF?car_make=$thismakeid&newitemid=$newitemid&catid=$catid&action=videoed&pi=$pi&pn=$pn&videoid=".$video[$i]['id']."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать видео\" /></a>&nbsp;
				</td>
				</tr>";
			}
		}
		else
		{
			echo "<tr><td colspan=\"4\" align=\"center\">Нет видеоклипов у данной страницы</td></tr>";
		}
?>
		</table>
		<br />
		<h3>Добавить видеоклип</h3>
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm3" enctype="multipart/form-data">
		<input type="hidden" name="action" value="addphoto" />
		<input type="hidden" name="catid" value="<?=$catid;?>" />
		<input type="hidden" name="car_make" value="<?=$thismakeid;?>" />
		<input type="hidden" name="newitemid" value="<?=$newitemid;?>" />
		<input type="hidden" name="pi" value="<?=$pi;?>" />
		<input type="hidden" name="pn" value="<?=$pn;?>" />
		<table align="center" width="550" cellspacing="0" cellpadding="1" border="0" class="tableborder">
		<tr><td>
			<table width="100%" cellspacing="1" cellpadding="1" border="0">
			<tr>
				<td colspan="2" class="fh">Добавить видео</td>
			</tr>
			<tr>
				<td class="ff">Заголовок видео:</td>
				<td class="fr">
					<input type="text" name="phototitle" size="40" />
				</td>
			</tr>
			<tr>
				<td class="ff">Описание видео:</td>
				<td class="fr">
					<textarea name="photodescr" cols="50" rows="8"></textarea>
				</td>
			</tr>
			<tr>
				<td class="ff">Видео файл (*.flv):</td>
				<td class="fr">
					<input type="text" size="30" name="photofile" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.addfrm3.photofile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" />
				</td>
			</tr>
			<tr>
				<td class="ff">Или youtube код:</td>
				<td class="fr">
					<textarea cols="60" rows="6" name="photoyoutube"></textarea>
				</td>
			</tr>
			<tr>
				<td class="ff">Порядковый номер:</td>
				<td class="fr">
					<input type="text" name="photoind" size="2" />
				</td>
			</tr>
			<tr>
				<td colspan="2" class="fr" align="center"><input type="submit" name="addphotobut" value=" Добавить" /> </td>
			</tr>
			</table>
		</td></tr>
		</table>
		</form>

		<br />
		<h3>Модификации товара (цветовые, по характеристикам)</h3>
		<?php
			$relits = Array();
			$query = "SELECT i1.id, m2.make_name, i1.model, i1.archive, ir1.id as relid
				FROM $TABLE_CAT_ITEMS_RELATED ir1
				INNER JOIN $TABLE_CAT_ITEMS i1 ON ir1.rel_id=i1.id AND ir1.reltype=0
				INNER JOIN $TABLE_CAT_MAKE_LANGS m2 ON i1.make_id=m2.make_id AND m2.lang_id='$LangId'
				WHERE ir1.item_id='".$newitemid."'
				ORDER BY m2.make_name,i1.model";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object( $res ) )
				{
					$ri = Array();
					$ri['id'] = $row->id;
					$ri['make'] = stripslashes($row->make_name);
					$ri['model'] = stripslashes($row->model);
					$ri['arc'] = ( $row->archive == 1 );
					$ri['rel'] = ( $row->relid != null ? 1 : 0 );
					$relits[] = $ri;
				}
				mysqli_free_result( $res );
			}

			echo '<table align="center" cellspacing="3" cellpadding="0">';
			for( $i=0; $i<count($relits); $i++ )
			{
				echo '<tr>
					<td>'.$relits[$i]['make'].' '.$relits[$i]['model'].'</td>
					<td>'.($relits[$i]['arc'] ? 'архив' : ' &nbsp;').'</td>
				</tr>';
			}
			if( count($relits) == 0 )
			{
				echo '<tr><td>Для данного товара не привязано ни одной модификации</td></tr>';
			}
			echo '</table>';
		?>


		<br />
		<h3>Добавить модификации</h3>
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm4">
		<input type="hidden" name="action" value="addmodif" />
		<input type="hidden" name="catid" value="<?=$catid;?>" />
		<input type="hidden" name="car_make" value="<?=$thismakeid;?>" />
		<input type="hidden" name="newitemid" value="<?=$newitemid;?>" />
		<input type="hidden" name="pi" value="<?=$pi;?>" />
		<input type="hidden" name="pn" value="<?=$pn;?>" />
		<table align="center" cellspacing="3" cellpadding="0">
		<?php
			$relits = Array();
			$query = "SELECT i1.id, m2.make_name, i1.model, i1.archive, ir1.id as relid
				FROM $TABLE_CAT_ITEMS i1
				INNER JOIN $TABLE_CAT_MAKE_LANGS m2 ON i1.make_id=m2.make_id AND m2.lang_id='$LangId'
				LEFT JOIN $TABLE_CAT_ITEMS_RELATED ir1 ON i1.id=ir1.rel_id AND ir1.item_id='".$newitemid."' AND ir1.reltype=0
				WHERE i1.profile_id='".$catid."' AND i1.make_id='".$thismakeid."' AND i1.id<>'".$newitemid."'
				ORDER BY m2.make_name,i1.model";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object( $res ) )
				{
					$ri = Array();
					$ri['id'] = $row->id;
					$ri['make'] = stripslashes($row->make_name);
					$ri['model'] = stripslashes($row->model);
					$ri['arc'] = ( $row->archive == 1 );
					$ri['rel'] = ( $row->relid != null ? 1 : 0 );
					$relits[] = $ri;
				}
				mysqli_free_result( $res );
			}

			for( $i=0; $i<count($relits); $i++ )
			{
				echo '<tr>
					<td><input type="checkbox" name="relids[]" value="'.$relits[$i]['id'].'" '.($relits[$i]['rel'] ? ' checked' : '').' /></td>
					<td>'.$relits[$i]['make'].' '.$relits[$i]['model'].'</td>
					<td>'.($relits[$i]['arc'] ? 'архив' : ' &nbsp;').'</td>
				</tr>';
			}
			if( count($relits) > 0 )
			{
				echo '<tr><td colspan="3" align="center"><input type="submit" value=" Применить " /></td></tr>';
			}
		?>
		</table>
		</form>

		<center><br /><br /><a href="<?=$PHP_SELF;?>?catid=<?=$catid;?>&car_make=<?=$thismakeid;?>">Добавить еще один товар этого бренда</a>
		<br /><a href="<?=$PHP_SELF;?>">Добавить товар другого типа</a></center>
<?php
	}

	if( $mode == "catalogplace" )
	{
		$THIS_TABLE = $TABLE_CAT_CATALOG;
		$THIS_TABLE_LANG = $TABLE_CAT_CATALOG_LANGS;
		$THIS_TABLE_P2P = $TABLE_CAT_CATITEMS;
?>
		<h3>Разместить товар в каталоге</h3>
		<table align="center" width="600" cellspacing="0" cellpadding="1" border="0" class="tableborder">
		<tr><td>
			<table width="100%" cellspacing="1" cellpadding="1" border="0">
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm" id="addfrm">
		<input type="hidden" name="action" value="<?=($mode == "editcatplace" ? "editplace" : "addplace");?>" />
		<input type="hidden" name="catid" value="<?=$catid;?>" />
		<input type="hidden" name="item_id" value="<?=$item_id;?>" />
<?php
		PrintWorkCatalog(0, $LangId, 0, "checklist", $item_id);
?>
		<tr>
			<td class="fr" colspan="2" align="center">
				<input type="submit" name="doplacebut" value=" Применить " />
			</td>
		</tr>
		</form>
		</table>
<?php
	}

	if( $mode == "notifyok" )
	{
		echo "Вы добавили информацию о товаре в базу";
?>
		<center><br /><br /><a href="<?=$PHP_SELF;?>?catid=<?=$catid;?>&car_make=<?=$car_make;?>">Добавить еще один товар этого бренда</a>
		<br /><a href="<?=$PHP_SELF;?>">Добавить товар другого типа</a></center>
<?php
	}
	else if( $mode == "notifydone" )
	{
		echo "Вы обновили информацию о товаре в базе.";
	}
	else
	{
		// Show empty page in case of hack attack
	}

	////////////////////////////////////////////////////////////////////////////
	include "inc/footer-inc.php";
	include "../inc/close-inc.php";
?>
