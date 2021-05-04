<?php
	$UserId = 0;
   	$UserLogin = "";
   	$UserName = "";
   	$UserDiscountLevel = 0;
	$UserModerator = 0;
	$UserModerateId = 0;
	$UserModerateRules = Array("pbuy" => 0, "psell" => 0, "pserv" => 0, "msngr" => 0, "elev" => 0, "cont" => 0, "price" => 0, "priceobls" => Array());
	$UserSmsChecked = false;
	$UserCfg = Buyer_LoadLimits_Def();
	

if( !function_exists("Torg_BuyerIsBan") )
{
	//echo "!3!3!";
	//if( file_exists("../inc/torgutils-inc.php") )
	//	include_once "../inc/torgutils-inc.php";
	//else
	if( isset($IS_SUBDIR) && $IS_SUBDIR )
		include_once "../inc/torgutils-inc.php";	
	else
		include_once "inc/torgutils-inc.php";	
}

function checkBanLoginAuth($uid, $ip, $sesid)
{
	global $LangId;
	
	if( $uid != 0 )
	{
		$baninf = Torg_BuyerIsBan( $LangId, $uid);
		if( $baninf['id'] != 0 )
		{
			return true;
		}
	}

	$baninf = Torg_BuyerIsBan( $LangId, 0, "", "", $ip );
	if( $baninf['id'] != 0 )
	{
		return true;
	}
	
	$baninf = Torg_BuyerIsBan( $LangId, 0, "", "", "", $sesid );
	if( $baninf['id'] != 0 )
	{
		return true;
	}	

	return false;
}

	// The record in the authorization table exists for current session,
    // so user is already logged in
    if( isset($_COOKIE[$AUTHMEMNAME]) && ($_COOKIE[$AUTHMEMNAME] != "") )
    {
    	// try auth for remembered user
    	$query = "SELECT u1.login, u1.id, u1.name, u1.discount_level_id, u1.smschecked, u1.last_ip  
        	FROM $TABLE_TORG_BUYER_AUTH a1, $TABLE_TORG_BUYERS u1
        	WHERE a1.auth_guid='".addslashes($_COOKIE[$AUTHMEMNAME])."' AND a1.user_login=u1.login AND a1.user_passwd=u1.passwd";
	    if( $res = @mysqli_query($upd_link_db, $query ) )
	    {
	    	if( $row = mysqli_fetch_object($res) )
	        {							
	        	$UserId = $row->id;
	        	$UserLogin = stripslashes($row->login);
	            $UserName = stripslashes($row->name);
	            $UserDiscountLevel = $row->discount_level_id;
				$UserSmsChecked = ( $row->smschecked == 1 );
	            //$UserGroup = $row->group_id;
				
				// check if this user is moderator
				if( isset($_COOKIE[$MODERMEMID]) && ($_COOKIE[$MODERMEMID] != "") )
				{
					$query1 = "SELECT * FROM $TABLE_TORG_BUYERS_MODERATORS WHERE moder_user_id='$UserId' AND id='".addslashes($_COOKIE[$MODERMEMID])."'";
					if( $res1 = @mysqli_query($upd_link_db, $query1 ) )
					{
						if( $row1 = mysqli_fetch_object($res1) )
						{
							$UserModerator = 1;
							$UserModerateId = $row1->owner_id;
							$UserModerateRules["pbuy"] = $row1->allow_pbuy;
							$UserModerateRules["psell"] = $row1->allow_psell;
							$UserModerateRules["pserv"] = $row1->allow_pserv;
							$UserModerateRules["msngr"] = $row1->allow_msngr;
							$UserModerateRules["elev"] = $row1->allow_elev;
							$UserModerateRules["cont"] = $row1->allow_contact;
							$UserModerateRules["price"] = $row1->allow_price;
							
							if( $row1->allow_price != 0 )
							{
								// Get obls
								$query2 = "SELECT * FROM $TABLE_TORG_BUYERS_MODERATORS_OBL WHERE moder_id='".$row1->id."' ";
								if( $res2 = mysqli_query($upd_link_db, $query2 ) )
								{
									while( $row2 = mysqli_fetch_object( $res2 ) )
									{
										$UserModerateRules["priceobls"][] = $row2->moder_obl_id;
									}
									mysqli_free_result( $res2 );
								}
							}
						}
						mysqli_free_result($res1);
					}
				}
				
				$UserCfg = Buyer_LoadLimits($UserId);
				
				if( stripslashes($row->last_ip) != $_SERVER['REMOTE_ADDR'] )
				{
					$query1 = "UPDATE $TABLE_TORG_BUYERS SET last_ip='".addslashes($_SERVER['REMOTE_ADDR'])."' WHERE id='".$row->id."'";
					if( !mysqli_query($upd_link_db,$query1) )
					{
						mysqlDebug();
					}
				}
	        }
	        mysqli_free_result($res);
	    }
    }


	if( $UserId == 0 )
	{
	    $query = "SELECT u1.login, u1.id, u1.name, u1.discount_level_id, u1.smschecked, u1.last_ip  
	        	FROM $TABLE_TORG_BUYER_AUTH a1, $TABLE_TORG_BUYERS u1
	        	WHERE a1.ip='".$_SERVER['REMOTE_ADDR']."' AND a1.ses_id='".session_id()."' AND a1.user_login=u1.login AND a1.user_passwd=u1.passwd";
	    if( $res = @mysqli_query($upd_link_db, $query ) )
	    {
	    	if( $row = mysqli_fetch_object($res) )
	        {
	        	$UserId = $row->id;
	        	$UserLogin = stripslashes($row->login);
	            $UserName = stripslashes($row->name);
	            $UserDiscountLevel = $row->discount_level_id;
				$UserSmsChecked = ( $row->smschecked == 1 );
	            //$UserGroup = $row->group_id;
				
				// check if this user is moderator
				if( isset($_COOKIE[$MODERMEMID]) && ($_COOKIE[$MODERMEMID] != "") )
				{
					$query1 = "SELECT * FROM $TABLE_TORG_BUYERS_MODERATORS WHERE moder_user_id='$UserId' AND id='".addslashes($_COOKIE[$MODERMEMID])."'";
					if( $res1 = @mysqli_query($upd_link_db, $query1 ) )
					{
						if( $row1 = mysqli_fetch_object($res1) )
						{
							$UserModerator = 1;
							$UserModerateId = $row1->owner_id;
							$UserModerateRules["pbuy"] = $row1->allow_pbuy;
							$UserModerateRules["psell"] = $row1->allow_psell;
							$UserModerateRules["pserv"] = $row1->allow_pserv;
							$UserModerateRules["msngr"] = $row1->allow_msngr;
							$UserModerateRules["elev"] = $row1->allow_elev;
							$UserModerateRules["cont"] = $row1->allow_contact;
							$UserModerateRules["price"] = $row1->allow_price;
							
							if( $row1->allow_price != 0 )
							{
								// Get obls
								$query2 = "SELECT * FROM $TABLE_TORG_BUYERS_MODERATORS_OBL WHERE moder_id='".$row1->id."' ";
								if( $res2 = mysqli_query($upd_link_db, $query2 ) )
								{
									while( $row2 = mysqli_fetch_object( $res2 ) )
									{
										$UserModerateRules["priceobls"][] = $row2->moder_obl_id;
									}
									mysqli_free_result( $res2 );
								}
							}
						}
						mysqli_free_result($res1);
					}
				}
				
				$UserCfg = Buyer_LoadLimits($UserId);
				
				if( stripslashes($row->last_ip) != $_SERVER['REMOTE_ADDR'] )
				{
					$query1 = "UPDATE $TABLE_TORG_BUYERS SET last_ip='".addslashes($_SERVER['REMOTE_ADDR'])."' WHERE id='".$row->id."'";
					if( !mysqli_query($upd_link_db,$query1) )
					{
						mysqlDebug();
					}
				}
	        }
	        mysqli_free_result($res);
	    }
	    else
	    {
	    	mysqlDebug();
	    }
	}
	
	
	if( checkBanLoginAuth($UserId, $_SERVER['REMOTE_ADDR'], $SESID) )
	{
		$UserId = 0;
		$UserLogin = "";
	    $UserName = "";
	    $UserDiscountLevel = 0;
		
		$query = "DELETE FROM $TABLE_TORG_BUYER_AUTH WHERE ses_id='".addslashes(session_id())."'";
		if( !@mysqli_query($upd_link_db, $query ) )
		{
			mysqlDebug();
		}

		setcookie($AUTHMEMNAME, '', time());
		
		//header("Location: ".$WWWHOST."info/youareblocked.html");
		//header("Location: ".$WWWHOST);
		//echo "Location: ".$WWWHOST."info/youareblocked.html";
		//exit();
	}	
?>
