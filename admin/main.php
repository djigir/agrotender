<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";
    include "inc/authorize-inc.php";

    $PAGE_HEADER['ru'] = "Добро пожаловать";
  	$PAGE_HEADER['en'] = "Welcome";

	include "inc/header-inc.php";

    //$lines = file("txt/intro_".$lang.".txt");
    //$intro_txt = join("<br />",$lines);


echo "Вы вошли на административную панель сайта.";
    //echo $intro_txt;

	include "inc/footer-inc.php";

	include "../inc/close-inc.php";
?>
