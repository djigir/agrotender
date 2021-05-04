<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////

	$META_SHOW_SITEMAP = true;

	////////////////////////////////////////////////////////////////////////////
	//   Website Start page module                                            //
	////////////////////////////////////////////////////////////////////////////
	include "inc/db-inc.php";
	include "inc/connect-inc.php";

	include "inc/utils-inc.php";
	include "inc/torgutils-inc.php";
	include "inc/newsutils-inc.php";

	include("inc/ses-inc.php");
	include "inc/buyerauth-inc.php";

	////////////////////////////////////////////////////////////////////////////
	//                          Page Options                                  //
	////////////////////////////////////////////////////////////////////////////


	////////////////////////////////////////////////////////////////////////////
	// Request parameters

	$oblurl = GetParameter("oblurl", "");
	$obl = 0;
    if( $oblurl != "" )
	{
		for( $i=1; $i<count($REGIONS_URL); $i++ )
		{
			if( $oblurl == $REGIONS_URL[$i] )
			{
				$obl = $i;
				break;
			}
		}
	}

	////////////////////////////////////////////////////////////////////////////

	$PAGE_PATH = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" style="display: inline;">
		<a itemprop="url" href="'.$WWWHOST.'"><span itemprop="title">Главная</span></a> ›
	</div>';

	////////////////////////////////////////////////////////////////////////////
	//
	include "inc5/header-inc.php";
	//
	////////////////////////////////////////////////////////////////////////////
?>
<main>
	<div class="cbreadcrumbs">
		<?=$PAGE_PATH;?>
	</div>
	<h1><?=($page['title'] != "" ? $page['title'] : "");?></h1>
	<section id="page_content">
		<div class="prod_descr">
<?php
	if( $oblurl != "" )
	{

		$cult_list = Torg_CultList($LangId);

		$TURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $TORG_SELL);
		echo '<div class="smap0"><a href="'.$TURL.'">Продать</a></div>';
		for( $i=0; $i<count($cult_list); $i++ )
		{
			$TURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $TORG_SELL, $cult_list[$i]['url'], $cult_list[$i]['id']);			echo '<div class="smap1"><a href="'.$TURL.'">'.$cult_list[$i]['name'].'</a></div>';		}

		$TURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $TORG_BUY);
		echo '<div class="smap0"><a href="'.$TURL.'">Купить</a></div>';
		for( $i=0; $i<count($cult_list); $i++ )
		{
			$TURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $TORG_BUY, $cult_list[$i]['url'], $cult_list[$i]['id']);
			echo '<div class="smap1"><a href="'.$TURL.'">'.$cult_list[$i]['name'].'</a></div>';
		}
?>
			</td><td style="vertical-align: top;">
<?php

		$ELEVURL = TorgElev_BuildUrl($LangId, 0, "", $REGIONS_URL[$obl]);
		echo '<div class="smap0"><a href="'.$ELEVURL.'">Элеваторы, '.$REGIONS[$obl].'</a></div>';

		$elev = Torg_ElevList( $LangId, $obl );
		for( $i=0; $i<count($elev); $i++ )
		{
			// Check if it is selected
			$ELEVURL = TorgElev_BuildUrl($LangId, $elev[$i]['id'], $elev[$i]['url'], $REGIONS_URL[$elev[$i]['obl_id']]);

			echo '<div class="smap1"><a href="'.$ELEVURL.'">'.$elev[$i]['name'].'</a></div>
			';
		}

	}
	else
	{
		/*		echo '<div class="smap0"><a href="'.$WWWHOST.'">Торги Агротендер</a></div>';

		for( $i=1; $i<count($REGIONS); $i++ )
		{			$TURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$i], $i);
			echo '<div class="smap1"><a href="'.$TURL.'">'.$REGIONS[$i].'</a></div>';		}
		*/


		// Links for board
		echo '<div class="smcol">';
		
		$topics = Board_TopicLevel($LangId, 0, "bygroups");

		$adobl = 0;
		$adtype = 0;

		$topic_drop = "";

		//$TURL = Board_BuildUrl($LangId, "list", $REGIONS_URL[$adobl], $adtype, 0);
		$TURL = Page_BuildUrl($LangId, "board", "");
		$topic_drop .= '<div class="smap0"><a href="'.$TURL.'">Объявления</a></div>';

		$grcurname = "";

	    for( $i=0; $i<count($topics); $i++ )
	    {
    		if( $grcurname != $topics[$i]['group'] )
    		{
   				$topic_drop .= '<div class="smap0">'.( $topics[$i]['group'] != "" ? $topics[$i]['group'] : 'Разное').'</div>';
   				$grcurname = $topics[$i]['group'];
    		}
    		$TURL = Board_BuildUrl($LangId, "list", $REGIONS_URL[$adobl], $adtype, $topics[$i]['id']);
			$topic_drop .= '<div class="smap1"><a href="'.$TURL.'">'.$topics[$i]['name'].'</a></div>';
	    }

	    echo $topic_drop;
		
		echo '</div>';
		
		// Links to traders prices
		echo '<div class="smcol">';				
		///////////////////////////////////////////////////////////////////////
		// Цены трейдеров
		$OBLS_SEL = Array();
		$TYPES_SEL = Array();
		$CULTS_SEL = Array();
		
		$OBLS_SELIDS = Array();
		$TYPES_SELIDS = Array();
		$CULTS_SELIDS = Array();
		
		$showportonly = "no";
		
		$tadobl = 0;
	
		for($acttype=0; $acttype<=1; $acttype++)
		{
			if( $acttype == 1 )
			{				
				echo '</div>
				<div class="smcol">
					<div class="smap0"><a href="'.Trader_Prices_BuildUrl($acttype, 0, "", "", "", "", "").'">Цены трейдеров продажи</a></div>';
			}
			else
			{
				echo '<div class="smap0"><a href="'.Trader_Prices_BuildUrl($acttype, 0, "", "", "", "", "").'">Цены трейдеров закупки</a></div>';
			}
			
			if( $acttype == 0 )
			{
				echo '<div class="smap0">Типы трейдеров</div>';
				for( $i=0; $i<count($ttypes); $i++ )
				{
					$ttypes_sel = $TYPES_SEL;					
					$ttypes_sel[] = $ttypes[$i]['url'];
										
					$URL = Trader_Prices_BuildUrl($acttype, 0, "", implode(",", $OBLS_SEL), implode(",", $CULTS_SEL), implode(",", $ttypes_sel), ($showportonly == "yes" ? "yes" : "") );									
					//echo '<li><input id="topt'.$ttypes[$i]['id'].'" type="checkbox" name="ttypes[]" value="'.$ttypes[$i]['id'].'" '.($type_checked ? ' checked' : '').'><label for="topt'.$ttypes[$i]['id'].'"><a href="'.$URL.'">'.$ttypes[$i]['name'].'</a> ('.$prnum.')</label></li>';
					echo '<div class="smap1"><a href="'.$URL.'">'.$ttypes[$i]['name'].'</a></div>';
				}			

				$URL = Trader_Prices_BuildUrl($acttype, 0, "", implode(",", $OBLS_SEL), implode(",", $CULTS_SEL), implode(",", $TYPES_SEL), ( $showportonly == "yes" ? '' : 'yes'));				
				//echo '<li><input id="tport" type="checkbox" name="tport" value="yes" '.( $showportonly == "yes" ? ' checked' : '').'><label for="tport"><a href="'.Trader_BuildUrl(0, "", implode(",", $OBLS_SEL), implode(",", $CULTS_SEL), implode(",", $TYPES_SEL), ( $showportonly == "yes" ? '' : 'yes')).'#trtopa">Только портовые</a> ('.$prnum.')</label></li>';
				echo '<div class="smap1"><a href="'.$URL.'">Портовые</a></div>';
			}
	
			$cultgroups = Trader_GetCultGroups($LangId, "", $acttype);

			echo '<div class="smap0">Культуры</div>';
			for( $i=0; $i<count($cultgroups); $i++ )
			{									
				$cults = Trader_GetCults($LangId, 0, "", false, $cultgroups[$i]['id']);
				if( count($cults) > 0 )
				{
					for( $j=0; $j<count($cults); $j++ )
					{
						
						$cult_checked = false;
						$cult_sel = $CULTS_SEL;						
						$cult_sel[] = $cults[$j]['url'];
						
						$URL = Trader_Prices_BuildUrl($acttype, 0, "", implode(",", $OBLS_SEL), implode(",", $cult_sel), implode(",", $TYPES_SEL), ($showportonly == "yes" ? "yes" : "") );						
						//echo '<li><input id="culto'.$cults[$j]['id'].'" type="checkbox" name="cultlist[]" value="'.$cults[$j]['id'].'" '.($cult_checked ? ' checked' : '').'><label for="culto'.$cults[$j]['id'].'"><a href="'.$URL.'">'.$cults[$j]['name'].'</a> ('.$prnum.')</label></li>';						
						echo '<div class="smap1"><a href="'.$URL.'">'.$cults[$j]['name'].'</a></div>';
					}
				}
			}
			
			echo '<div class="smap0">Регионы</div>';
			for( $i=1; $i<count($REGIONS_SHORT); $i++ )
			{
				$obl_checked = false;
				$obls_sel = $OBLS_SEL;
				$obls_sel[] = $REGIONS_URL[$i];
				
				$URL = Trader_Prices_BuildUrl($acttype, 0, "", implode(",", $obls_sel), implode(",", $CULTS_SEL), implode(",", $TYPES_SEL), ($showportonly == "yes" ? "yes" : "") );				
				//echo '<li><input type="checkbox" id="optr'.$i.'" value="'.$i.'" '.($obl_checked ? ' checked' : '').'><label for="optr'.$i.'"><a href="'.$URL.'">'.$REGIONS_SHORT[$i].'</a> ('.$prnum.')</label></li>';
				echo '<div class="smap1"><a href="'.$URL.'">'.$REGIONS_SHORT[$i].'</a></div>';
			}

		}
		
		echo '</div>';
	}
?>
	</div>
	
	</section>

<?php
	$ban_html = Banners_Place_Show( 3, 12, $ALLBANS );
	if( $ban_html != "" )
	{
		echo '<div class="botreklama">'.$ban_html.'</div>';
	}
?>		
	<div class="both"></div>
	
</main>
<?php
	////////////////////////////////////////////////////////////////////////////
	include "inc5/footer-inc.php";
	include "inc/close-inc.php";
?>