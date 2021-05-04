<?php
	@session_set_cookie_params(3600*6, "/", ".agt.weehub.io", false);
	@session_save_path( (isset($IS_SUBDIR) && $IS_SUBDIR ? "../" : "" ).$SESSION_PATH );
	$SESID = @session_id();
	if( $SESID == '' )
	{
		@session_start();
		$SESID = @session_id();
	}

	//echo "dm = ".ini_get('session.cookie_domain');

	/*
	//session_name("itm_admin");

	if (!session_is_registered('itmsesid'))
	{
		session_register("itmsesid");
		$SESID = session_id();
		$itmsesid = $SESID;
	}
	else
	{
		$SESID = $itmsesid;
	}

	//echo session_id();
	*/

	/*
	if( isset($_SESSION["itmsesid"]) )
	{
		$SESID = $_SESSION["itmsesid"];
	}
	else
	{
		session_register("itmsesid");
		$SESID = session_id();
		//setcookie("itmsesid", $SESID, time()+3600);

	}
	*/
?>
