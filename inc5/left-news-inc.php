<?php
	///////////////////////////////////////////////////////////////////////////////
	// Left news col
	
	if( empty($SHOW_NEW_LEFT) )
		$SHOW_NEW_LEFT = false;
	
	
	if( isset($SHOW_NEW_LEFT) && $SHOW_NEW_LEFT )
	{
		//$news = News_Items($LangId, $NEWS_WORLD, "anons", 130, 0, 4);
		$news = News_Items($LangId, $NEWS_ALL, "add", 130, 0, 4);
?>
	<div class="blk_news" style="margin-top: 24px;">
<?php
		for( $i=0; $i<count($news); $i++ )
		{
			$NEWS_LINK = News_BuildUrl($LangId, 0, 0, ($WWW_LINK_MODE == "html" ? $news[$i]['url'] : $news[$i]['id']), "", $news[$i]['date_y'], $news[$i]['date_m']);

			$month_names = Array("", "января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
			$dt_str = sprintf("%02d %s %04d г.", $news[$i]['date_d'], $month_names[$news[$i]['date_m']], $news[$i]['date_y']);
			
			echo '<div class="rcol-news">
				<div class="rnew-dt">'.$dt_str.'</div>
				<div class="rnew-tit"><a href="'.$NEWS_LINK.'">'.$news[$i]['title'].'</a></div>
			</div>';

			echo '<div class="news-itrc">
				<div class="news-itrc-p"><a href="'.$NEWS_LINK.'">'.($news[$i]['img_src'] != "" ? '<a href="'.$NEWS_LINK.'"><img src="'.$news[$i]['img_src'].'" alt="" width="160" /></a>' : '').'</a></div>
				<div class="news-itrc-d">'.$dt_str.'</div>
				<div class="news-itrc-t"><a href="'.$NEWS_LINK.'">'.$news[$i]['title'].'</a></div>
			</div>';
		}
?>
	</div>
<?php
	}
?>