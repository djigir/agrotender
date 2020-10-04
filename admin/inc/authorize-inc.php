<?php
	$UserId = 0;
    $UserName = "";
    $UserGroup = 0;
			
	// The record in the authorization table exists for current session,
    // so user is already logged in
    $query = "SELECT u1.login, u1.group_id, u1.id
        	FROM $TABLE_USER_AUTH a1, $TABLE_USERS u1
        	WHERE a1.ses_id='".session_id()."' AND a1.user_login=u1.login AND a1.user_passwd=u1.passwd";
    if( $res = mysqli_query($upd_link_db, $query ) )
    {
    	if( $row = mysqli_fetch_object($res) )
        {
        	$UserId = $row->id;
            $UserName = stripslashes($row->login);
            $UserGroup = $row->group_id;
        }
        else
        {
        	$UserId = 0;
    		$UserName = "";
    		$UserGroup = 0;
        }
        mysqli_free_result($res);
    }
    echo mysqli_error($upd_link_db);
?>
