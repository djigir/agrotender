<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////

	////////////////////////////////////////////////////////////////////////////
	//   Website Start page module                                            //
	////////////////////////////////////////////////////////////////////////////
	include "inc/db-inc.php";
	include "inc/connect-inc.php";

	include "inc/utils-inc.php";
	include "inc/torgutils-inc.php";
	include "inc/newsutils-inc.php";

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
	$ttypes = Trader_GetTypes(1);
	$result = mysqli_query($upd_link_db, "select * from agt_regions");
	$regions = [
      ['translit' => 'ukraine']
	];
    while($row = mysqli_fetch_assoc($result)){
      array_push($regions, $row);
    }


	////////////////////////////////////////////////////////////////////////////


	////////////////////////////////////////////////////////////////////////////
?>
<?php
	if( $oblurl != "" )
	{
		$domen = 'http://'.$oblurl.'.agrotender.com.ua/';
		$xml = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
	<loc>'.$domen.'</loc>
	<changefreq>daily</changefreq>
	<priority>1</priority>
</url>';

		$cult_list = Torg_CultList($LangId);

		$TURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $TORG_SELL);
		$xml .= '<url>
	<loc>'.$TURL.'</loc>
	<changefreq>always</changefreq>
	<priority>0.8</priority>
</url>';

		$TURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $TORG_BUY);
		$xml .= '<url>
	<loc>'.$TURL.'</loc>
	<changefreq>always</changefreq>
	<priority>0.8</priority>
</url>';

		for( $i=0; $i<count($cult_list); $i++ )
		{
			$TURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $TORG_SELL, $cult_list[$i]['url'], $cult_list[$i]['id']);
			$xml .= '<url>
	<loc>'.$TURL.'</loc>
	<changefreq>always</changefreq>
	<priority>0.7</priority>
</url>';
		}

		for( $i=0; $i<count($cult_list); $i++ )
		{
			$TURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$obl], $obl, "", $TORG_BUY, $cult_list[$i]['url'], $cult_list[$i]['id']);
			$xml .= '<url>
	<loc>'.$TURL.'</loc>
	<changefreq>always</changefreq>
	<priority>0.7</priority>
</url>';
		}

		$ELEVURL = TorgElev_BuildUrl($LangId, 0, "", $REGIONS_URL[$obl]);
		$xml .= '<url>
	<loc>'.$ELEVURL.'</loc>
	<changefreq>always</changefreq>
	<priority>0.8</priority>
</url>';

		$elev = Torg_ElevList( $LangId, $obl );
		for( $i=0; $i<count($elev); $i++ )
		{
			// Check if it is selected
			$ELEVURL = TorgElev_BuildUrl($LangId, $elev[$i]['id'], $elev[$i]['url'], $REGIONS_URL[$elev[$i]['obl_id']]);
			$xml .= '<url>
	<loc>'.$ELEVURL.'</loc>
	<changefreq>always</changefreq>
	<priority>0.7</priority>
</url>';
		}

		$xml .= '
</urlset>';
	}
	else
	{
		$domen = $WWWHOST;
		$xml = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
	<loc>'.$domen.'</loc>
	<changefreq>daily</changefreq>
	<priority>1</priority>
</url>';

		//echo '<div class="smap0"><a href="'.$WWWHOST.'">Торги Агротендер</a></div>';

		//for( $i=1; $i<count($REGIONS); $i++ )
		//{
		//	$TURL = Torg_BuildUrl($LangId, "list", $REGIONS_URL[$i], $i);
		//	echo '<div class="smap1"><a href="'.$TURL.'">'.$REGIONS[$i].'</a></div>';
		//}

		$adobl = 0;
		$adtype = 0;

		$topgr = Board_TopicGroups( $LangId, 0 );
		if(count($topgr) > 0)
		{
			for( $adobl=0; $adobl<count($REGIONS_URL); $adobl++ )
			{
				for($i1=0;$i1<count($topgr);$i1++)
				{
					$catname	= $topgr[$i1]['name']; //$sect0[$i1]['name'];

					$sect1 = Board_TopicLevel( $LangId, 0, "", $topgr[$i1]['id'] );
					if( count($sect1) > 0 )
					{
						$group_id = -1;
						$group_num = 0;
						for( $j=0; $j<count($sect1); $j++ )
						{
							$TURL = Board_BuildUrl($LangId, "list", $REGIONS_URL[$adobl], $adtype, $sect1[$j]['id']);

							$xml .= '<url>
	<loc>'.$TURL.'</loc>
	<changefreq>daily</changefreq>
	<priority>'.($adobl == 0 ? '0.9' : '0.8').'</priority>
</url>';

							$sect2 = Board_TopicLevel( $LangId, $sect1[$j]['id'], "withpostnum", 0, $adobl );

							for( $i2=0; $i2<count($sect2); $i2++ )
							{
								$CATLINK = Board_BuildUrl($LangId, "list", $REGIONS_URL[$adobl], $adtype, $sect2[$i2]['id']);

								$xml .= '<url>
	<loc>'.$CATLINK.'</loc>
	<changefreq>daily</changefreq>
	<priority>'.($adobl == 0 ? '0.9' : '0.8').'</priority>
</url>';
							}
						}
					}
				}
			}
		}

		
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
	
		for($acttype=0; $acttype<1; $acttype++)
		{
			if( $acttype == 0 )
			{
				for( $i=0; $i<count($ttypes); $i++ )
				{
					$ttypes_sel = $TYPES_SEL;					
					$ttypes_sel[] = $ttypes[$i]['url'];
										
					$URL = Trader_Prices_BuildUrl($acttype, 0, "", implode(",", $OBLS_SEL), implode(",", $CULTS_SEL), implode(",", $ttypes_sel), ($showportonly == "yes" ? "yes" : "") );
					
					$xml .= '<url>
	<loc>'.$URL.'</loc>
	<changefreq>daily</changefreq>
	<priority>'.($tadobl == 0 ? '0.9' : '0.8').'</priority>
</url>';
					//echo '<li><input id="topt'.$ttypes[$i]['id'].'" type="checkbox" name="ttypes[]" value="'.$ttypes[$i]['id'].'" '.($type_checked ? ' checked' : '').'><label for="topt'.$ttypes[$i]['id'].'"><a href="'.$URL.'">'.$ttypes[$i]['name'].'</a> ('.$prnum.')</label></li>';
				}			

				$URL = Trader_Prices_BuildUrl($acttype, 0, "", implode(",", $OBLS_SEL), implode(",", $CULTS_SEL), implode(",", $TYPES_SEL), ( $showportonly == "yes" ? '' : 'yes'));
				$xml .= '<url>
	<loc>'.$URL.'</loc>
	<changefreq>daily</changefreq>
	<priority>'.($tadobl == 0 ? '0.9' : '0.8').'</priority>
</url>';
				//echo '<li><input id="tport" type="checkbox" name="tport" value="yes" '.( $showportonly == "yes" ? ' checked' : '').'><label for="tport"><a href="'.Trader_BuildUrl(0, "", implode(",", $OBLS_SEL), implode(",", $CULTS_SEL), implode(",", $TYPES_SEL), ( $showportonly == "yes" ? '' : 'yes')).'#trtopa">Только портовые</a> ('.$prnum.')</label></li>';
			}
	
			$cultgroups = Trader_GetCultGroups($LangId, "", $acttype);

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
						
						$xml .= '<url>
	<loc>'.$URL.'</loc>
	<changefreq>daily</changefreq>
	<priority>'.($tadobl == 0 ? '0.9' : '0.8').'</priority>
</url>';

						//echo '<li><input id="culto'.$cults[$j]['id'].'" type="checkbox" name="cultlist[]" value="'.$cults[$j]['id'].'" '.($cult_checked ? ' checked' : '').'><label for="culto'.$cults[$j]['id'].'"><a href="'.$URL.'">'.$cults[$j]['name'].'</a> ('.$prnum.')</label></li>';						
					}
				}
			}
			for( $i=0; $i<count($regions); $i++ )
			{
				$obl_checked = false;
				$obls_sel = $OBLS_SEL;
				$obls_sel[] = $REGIONS_URL[$i];

				$cults = Trader_GetCults($LangId, 0, "", false, $cultgroups[$i]['id'], 1, 0, 1);
				if( count($cults) > 0 )
				{
					for( $j=0; $j<count($cults); $j++ )
					{
						
						$cult_checked = false;
						$cult_sel = $CULTS_SEL;						
						$cult_sel[] = $cults[$j]['url'];
						
						$URL = Trader_Prices_BuildUrl($acttype, 0, "", $regions[$i]['translit'], implode(",", $cult_sel), implode(",", $TYPES_SEL), ($showportonly == "yes" ? "yes" : "") );
						
						$xml .= '<url>
	<loc>'.$URL.'</loc>
	<changefreq>daily</changefreq>
	<priority>'.($tadobl == 0 ? '0.9' : '0.8').'</priority>
</url>';

						//echo '<li><input id="culto'.$cults[$j]['id'].'" type="checkbox" name="cultlist[]" value="'.$cults[$j]['id'].'" '.($cult_checked ? ' checked' : '').'><label for="culto'.$cults[$j]['id'].'"><a href="'.$URL.'">'.$cults[$j]['name'].'</a> ('.$prnum.')</label></li>';						
					}
				}
				
				//echo '<li><input type="checkbox" id="optr'.$i.'" value="'.$i.'" '.($obl_checked ? ' checked' : '').'><label for="optr'.$i.'"><a href="'.$URL.'">'.$REGIONS_SHORT[$i].'</a> ('.$prnum.')</label></li>';
			}

		}


		///////////////////////////////////////////////////////////////////////
		/*
		$news = News_Items($LangId, -1, "add", 100, 0, 1000);

		for( $i=0; $i<count($news); $i++ )
		{
			$NLINK = News_BuildUrl( $LangId, 0, 0, ($WWW_LINK_MODE == "html" ? $news[$i]['url'] : $news[$i]['id']), "", $news[$i]['date_y'], $news[$i]['date_m'] );

			$xml .= '<url>
	<loc>'.$NLINK.'</loc>
	<changefreq>daily</changefreq>
	<priority>0.7</priority>
</url>';
		}
		*/

		$xml .= '
</urlset>';

	}

	header("Content-Type: text/xml; name=\"sitemap.xml\";");
	//header("Content-Disposition: attachment; filename=\"report_".$datest.".csv\";");

	echo iconv("CP1251", "UTF-8", $xml);

	////////////////////////////////////////////////////////////////////////////
	include "inc/close-inc.php";
?>