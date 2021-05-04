<?php
	$FILE_DIR = "/files/";
	$arrMonths =  Array("January","February","March","April","May","June","July","August","September","October","November","December");
	include "../inc/ses-inc.php";

	////////////////////////////////////////////////////////////////////////////
	//		Interface Language
    $lang = "en";

    $is_UTF8 = true;
    if( empty($_ENV) || empty($_ENV['LANG']) )
    {
		$is_UTF8 = false;
    }
    else
    {
    	if( strpos($_ENV['LANG'], "UTF-8") === false )
    	{
    		$is_UTF8 = false;
    	}
    }

    $is_UTF8 = false;

	////////////////////////////////////////////////////////////////////////////
	//		Build menu from xml file
	switch( $UserGroup )
	{
    	case $GROUP_ADMIN:
    		$file = "../admin/inc/config.xml";
    		break;

    	case $GROUP_OPERATOR:
    		$file = "../admin/inc/config_operator.xml";
    		break;

    	default:
    		$file = "../admin/inc/config_empty.xml";
    }
    $tag_name = "";

    $menu_sections = array();
    $menu_sections_num = 0;

    $menu_items = array();
    $menu_items_num = 0;

    function startElement($parser, $name, $attrs)
    {
    	global $tag_name, $menu_items, $menu_sections_num, $menu_items_num;

    	$tag_name = $name;

        if( $tag_name == "MENUITEM" )
    		$menu_items[$menu_sections_num][$menu_items_num]["link"] = $attrs["LINKURL"];
	}

    function endElement($parser, $name)
    {
    	global $tag_name, $menu_sections_num, $menu_items_num;

        if( $name == "MENUSECTION" )
    	{
        	$menu_sections_num++;
        	$menu_items_num = 0;
        }

		$tag_name = "";
	}

    function dataElement($parser, $data)
    {
    	global $is_UTF8;
    	global	$lang, $tag_name, $menu_sections, $menu_sections_num, $menu_items, $menu_items_num;

        switch( $tag_name )
        {
        	case "MENUSECTION":
        		break;

        	case "MENUTITLE":
        		$menu_sections[$menu_sections_num] = ( $is_UTF8 ? iconv("UTF-8", "cp1251", $data) : $data ); //iconv("utf-8", "CP1251", $data);//$data;	 //mb_convert_encoding($data, "CP1251", "UTF-8");//$data; //mb_convert_encoding($data, "CP1251", "UTF-16"); //$data
        		break;

        	case "MENUITEM":
                $menu_items[$menu_sections_num][$menu_items_num]["name"] = ( $is_UTF8 ? iconv("UTF-8", "cp1251", $data) : $data ); //iconv("utf-8", "CP1251", $data);//$data; //mb_convert_encoding($data, "CP1251", "UTF-8");//$data; //mb_convert_encoding($data, "CP1251", "UTF-16");//iconv("UTF-16", "CP1251", $data);//$data;
                $menu_items_num++;
        		break;

        	case "LANGUAGE":
        		$lang = $data; //iconv("utf-8", "CP1251", $data);//$data; //mb_convert_encoding($data, "CP1251", "UTF-8");//$data; //mb_convert_encoding($data, "CP1251", "UTF-16");//iconv("UTF-16", "CP1251", $data);//$data;
        		break;
        }
    }

	$xml_parser = xml_parser_create();
	xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
	//xml_parser_set_option($xml_parser, XML_OPTION_TARGET_ENCODING, "1251");
	xml_set_element_handler($xml_parser, "startElement", "endElement");
	xml_set_character_data_handler($xml_parser, "dataElement");
	if (!($fp = fopen($file, "r"))) {
    	die("could not open XML input");
	}

	//echo "start";
	while ($data = fread($fp, 4096))
	{
		//echo "<pre>".$data."</pre>";
		if (!xml_parse($xml_parser, $data, feof($fp)))
		{
        	die(sprintf("XML error: %s at line %d",
                    xml_error_string(xml_get_error_code($xml_parser)),
                    xml_get_current_line_number($xml_parser)));
    	}
	}
	//echo "end";
	xml_parser_free($xml_parser);

/*
    $LangId = $_COOKIE['LangId'];

    // Now we should check which layout language was selected as default
    $newlangid = GetParameter("newlangid", 0);
    if( $newlangid != 0 )
    {
		// The user select the other layout language
		$LangId = $newlangid;
		setcookie("LangId", $LangId);
    }

    $langs = Array();
    $query = "SELECT * FROM $TABLE_LANGS ORDER BY id";
    if( $res = mysql_query( $query ) )
    {
        while( $row = mysql_fetch_object($res) )
        {
        	$langs[] = $row->id;
        }
        mysql_free_result($res);
    }
*/
?>
<html>
<head>
	<title><?=( $lang == "en" ? "Site Managment - Admin Panel" : "Управление Сайтом - Админ Панель" );?></title>
	<?php
		if( $lang == "ru" )
			echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\" />";
	?>
	<link type="text/css" rel="stylesheet" href="css/style.css" />

	<?php
	/*
	<script type="text/javascript" language="javascript" charset="windows-1251" src="../js/jquery-1.4.4.min.js"></script>
	*/
	?>
	<script type="text/javascript" language="javascript" charset="windows-1251" src="../js5/jquery-1.11.2.min.js"></script>
	
	<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>

	<script language="javascript" src="js/utils.js"></script>
	<script language="javascript" src="js/script_cat.js"></script>
	<script language="javascript" src="js/script_html.js"></script>

	<script type="text/javascript" language="javascript" charset="windows-1251" src="js/basic.js"></script>
	<script
  src="https://code.jquery.com/jquery-1.12.4.min.js"
  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
  crossorigin="anonymous"></script>
	<?php
	/*
	<script type="text/javascript" language="javascript" charset="windows-1251" src="../js/myajax.js"></script>
	<script type="text/javascript" language="javascript" charset="windows-1251" src="js/config.js"></script>
	*/
	?>
</head>
<body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0">
	<table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
	<tr height="70"><td colspan="2" valign="top" class="panel">
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td width="1"><img src="img/spacer.gif" width="1" height="70" alt="" /></td>
			<td width="180" align="right"><img src="<?=( $lang == "en" ? "img/adminpanel.gif" : "img/adminpanel_ru.gif");?>" width="150" height="38" alt="<?=( $lang == "en" ? "Admin Panel" : "Админ Панель");?>" border="0" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
	</td></tr>
	<tr>
		<!-- MENU -->
		<td width="215" valign="top"><br /><br />
			<table cellspacing="0" cellpadding="0" border="0" width="215">
			<tr><td bgcolor="#067138"><img src="<?=( $lang == "en" ? "img/menu_hdr.gif" : "img/menu_hdr_ru.gif");?>" width="215" height="41" alt="<?=( $lang == "en" ? "Management Menu" : "Меню Управления" );?>" border="0" /></td></tr>
			<tr><td><img src="img/spacer.gif" width="1" height="10" alt="" border="0" /></td></tr>
			<tr><td>
				<table cellspacing="0" cellpadding="0" border="0" width="205">
				<tr>
					<td rowspan="2" bgcolor="#3380AF"><img src="img/spacer.gif" width="5" height="1" alt="" /></td>
					<td rowspan="2"><img src="img/spacer.gif" width="5" height="1" alt="" /></td>
					<td class="menuitem"><a href="../" target="_new" class="menulink"><?=( $lang == "en" ? "View Site" : "Посмотреть Сайт" );?></a></td>
				</tr>
				<tr><td><img src="img/menu_dots.gif" width="195" height="1" alt="" /></td></tr>
                <tr>
					<td rowspan="2" bgcolor="#3380AF"><img src="img/spacer.gif" width="5" height="1" alt="" /></td>
					<td rowspan="2"><img src="img/spacer.gif" width="5" height="1" alt="" /></td>
					<td class="menuitem"><a href="main.php" class="menulink"><?=( $lang == "en" ? "Main" : "Главная" );?></a></td>
				</tr>
				<tr><td><img src="img/menu_dots.gif" width="195" height="1" alt="" /></td></tr>
                <tr>
					<td rowspan="2" bgcolor="#3380AF"><img src="img/spacer.gif" width="5" height="1" alt="" /></td>
					<td rowspan="2"><img src="img/spacer.gif" width="5" height="1" alt="" /></td>
					<td class="menuitem"><a href="index.php?action=logout" class="menulink"><?=( $lang == "en" ? "Logout" : "Выйти" );?></a></td>
				</tr>
				<tr><td><img src="img/menu_dots.gif" width="195" height="1" alt="" /></td></tr>
				</table>
			</td></tr>
		<?php
			for($i = 0; $i < count($menu_sections); $i++)
			{
            	$section_name = $menu_sections[$i];
                $section_items = $menu_items[$i];

                echo '<tr><td><img src="img/spacer.gif" width="1" height="15" alt="" border="0" /></td></tr>
            	     <tr><td>
						<table cellspacing="0" cellpadding="0" border="0" width="205">
						<tr><td colspan="3" bgcolor="#FC4006" class="menusect">'.$section_name.'</td></tr>
						<tr><td colspan="3"><img src="img/spacer.gif" width="1" height="5" alt="" border="0" /></td></tr>';

                for($j = 0; $j < count($section_items); $j++)
                {
                	$item_name = $section_items[$j]["name"];
                	$item_link = $section_items[$j]["link"];

                    echo '<tr>
						<td rowspan="2" bgcolor="#3380AF"><img src="img/spacer.gif" width="5" height="1" alt="" /></td>
						<td rowspan="2"><img src="img/spacer.gif" width="5" height="1" alt="" /></td>
						<td class="menuitem"><a href="'.$item_link.'" class="menulink">'.$item_name.'</a></td>
					</tr>
					<tr><td><img src="img/menu_dots.gif" width="195" height="1" alt="" /></td></tr>';
                }

                echo '</table>
                    </td></tr>';
            }
		?>
			</table>
			<br />
		</td>
		<!-- CENTRAL PART -->
		<td valign="top">
			<table align="center" cellspacing="0" cellpadding="0" border="0" width="98%">
			<tr>
				<td class="mainhdr"><?=$PAGE_HEADER[$lang];?></td>
				<td align="right">



				</td>
			</tr>
			<tr><td colspan="2">
				<div class="maindiv">
