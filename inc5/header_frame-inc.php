<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      РЈРєСЂР°РёРЅСЃРєРёР№ РҐРѕСЃС‚РёРЅРі                                                    //
//      Р“РѕРґСѓРЅРѕРІ РђР»РµРєСЃР°РЅРґСЂ                                                     //
//   Р”Р°РЅРЅС‹Р№ РєРѕРґ Р·Р°РїСЂРµС‰РµРЅ РґР»СЏ РёСЃРїРѕР»СЊР·РѕРІР°РЅРёСЏ РЅР° РґСЂСѓРіРёС… СЃР°Р№С‚Р°С…, РєРѕС‚РѕСЂС‹Рµ          //
//   СЂР°Р·СЂР°Р±Р°С‚С‹РІР°СЋС‚СЃСЏ Р±РµР· СѓС‡Р°СЃС‚РёСЏ РєРѕРјРїР°РЅРёРё "РЈРєСЂР°РёРЅСЃРєРёР№ РҐРѕСЃС‚РёРЅРі"                //
////////////////////////////////////////////////////////////////////////////////

	//------------------- Extract contacts from database -----------------------
	$continfo = Contacts_Get( $LangId );

	//------------------------ GET TEXT BLOCKS ---------------------------------
	$txt_res = Resources_Get($LangId);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title>РћРїР»Р°С‚Р° СЃС‡РµС‚Р° - <?=$WWWNAMERU;?></title>
	<link rel="stylesheet" type="text/css" href="<?=$WWWHOST;?>css5/all3.css" />
	
	<script type="text/javascript" src="<?=$WWWHOST;?>js5/jquery-1.11.2.min.js"></script>
	<script type="text/javascript">
	var reqajxhost = '<?=$WWWHOST;?>';

	$(document).ready(function()
	{
		//
	});
	</script>
</head>
<body class="framebody">
