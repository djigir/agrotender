<?php
	///////////////////////////////////////////////////////////////////////////////
	// Left news col
	
	if( empty($SHOW_LENTA_LEFT) )
		$SHOW_LENTA_LEFT = false;
	
	
	if( isset($SHOW_LENTA_LEFT) && $SHOW_LENTA_LEFT )
	{
		echo '<a href="'.Page_BuildUrl($LangId, "info", "lenta").'"><div class="lentabtn" alt="Как попасть в ленту"></div></a>';

		//echo $seltype_id." - ".$adtype." - ".$submode."<br />";
		$seltype_id = ( isset($adtype) ? $adtype : 0 );
		$lentahtml = Lenta_BuildHtml($LangId, $LENTA_SIMPLE, $seltype_id, (isset($submode_topic) ? $submode_topic : 0), 40, 15);
		
		echo '<div class="right-lenta">
			<div class="lbl-hdr">Лента обновлений</div>
			<div class="lenta-adv">
				'.$lentahtml.'			
			</div>
		</div>';
	}
?>