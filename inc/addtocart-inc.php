<?php
	//$new_cart_model_name = "";

	$new_oborud_id = GetParameter("addtocart", 0);
	//if( isset($_POST['addtocart']) )			$new_oborud_id = $_POST['addtocart'];
	//else if( isset($_GET['addtocart']) )		$new_oborud_id = $_GET['addtocart'];
	//else										$new_oborud_id = 0;
	if( $new_oborud_id != 0 )
	{
		// Try to add new product to cart
		$cur_ses_id = session_id();

		if( $cur_ses_id != "" )
		{
			if( $res = mysqli_query($upd_link_db, "SELECT * FROM $TABLE_SHOP_CART WHERE ses_id='".addslashes($cur_ses_id)."' AND oborud_id=$new_oborud_id") )
			{
				if( $row = mysqli_fetch_object($res) )
    			{
    				if( !mysqli_query($upd_link_db, "UPDATE $TABLE_SHOP_CART SET oborud_num=oborud_num+1 WHERE ses_id='".addslashes($cur_ses_id)."' AND oborud_id=$new_oborud_id") )
    				{
    					// Error
    					echo mysqli_error();
					}
				}
				else
    			{
					if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_SHOP_CART (ses_id, oborud_id, add_date) VALUES ('".addslashes($cur_ses_id)."', '".$new_oborud_id."', NOW())") )
    				{
	    				// Error adding product to cart
	    				echo mysqli_error($upd_link_db);
					}
    			}
				mysqli_free_result($res);
			}
		}

        //$query = "SELECT p.name, m.model FROM ".$PREFIX."_mob_prod p, ".$PREFIX."_mob_models m
        //   WHERE m.id='".$new_oborud_id."' AND p.id=m.mob_prod_id";
        /*
        $query = "SELECT i1.model, m1.make_name as name FROM $TABLE_CAT_ITEMS i1
        	INNER JOIN $TABLE_CAT_MAKE_LANGS m1 ON i1.make_id=m1.make_id AND m1.lang_id='$LangId'
        	WHERE i1.id='$new_oborud_id'";
  	    if( $res = mysqli_query($upd_link_db, $query ) )
	    {
	    	if( $row = mysqli_fetch_object($res) )
	        {
	        	$new_cart_model_name = stripslashes($row->name)." ".stripslashes($row->model);
	        }
	        mysqli_free_result($res);
	    }
	    */
		//header("Location: cart.php?refurl=".urlencode($_SERVER["HTTP_REFERER"]));
	}
?>
