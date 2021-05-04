function Disable(own,el,el2){
  el2.disabled=true;
  el2.style.backgroundColor='#EEEEEE';
  el.disabled=false;
  el.style.backgroundColor='#FFFFFF';
  return true;
}

function Delete(){
  if ( confirm( unescape("Вы действительно хотите продолжить?") ) ) {
    return true;
  }else{
    return false;
  }
}

function Delet(url){
  if ( confirm( unescape("Вы действительно хотите продолжить?") ) ) {
    location.href=url;
  }
}

function DeletS(url, spisok){
  if ( confirm( unescape("Вы действительно хотите продолжить удаление?\nПопутно будут удалены: ")+unescape(spisok) ) ) {
    location.href=url;
  }
}

function GoTo(url){
 location.href=url;
}

function OpenWin(url){
  newwindow = window.open(url,"EmailWindow","toolbar=no,status=no,resizable=yes,location=no,toolbar=no,menubar=no,width=400,height=400");
  newwindow.focus();
}

function ViewImage(url){
  newwindow = window.open(url,"ChangeWindow","toolbar=no,status=no,resizable=yes,location=no,toolbar=no,menubar=no,width=700,height=600");
  newwindow.focus();
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  mywin = window.open(theURL,winName,features);
  mywin.focus();
}

function FileCh(filename,target){
  target.value=filename;
  self.opener.focus();
  window.close();
}

function fillProductList(obj_id, ind, type_id_tpl, type_id_str, progress_id, maxcombo)
{
	var list_obj = uh_get_object( obj_id );

	//var type_parts = type_id_str.split(":");
	//if( type_parts.length != 2 )
	//{
	//	alert('parameter error');
	//	return;
	//}

	//var type1_id = type_parts[0];
	//var type2_id = type_parts[1];
	var type_id = type_id_str;

  	if( AJAX != null )
	{
		//alert( 'AJAX is ok' );
		hideItem( obj_id );
		showItem( progress_id );

		// Disable all combos for select
        for(var ic=1; ic<=maxcombo; ic++)
        {
        	var objcombo = uh_get_object(type_id_tpl + ic);
        	objcombo.disabled = true;
        }

        //alert( 'Drop downs is hide' );

		var process_fn = function(res)
		{
			//alert(' RESPONSE IN CALLBACK: ' + res);

			res = (res.split("\r\n")).join(" ");

			//alert(' NEW: ' + list_obj.SelectedIndex );
			eval( 'var responce_data = ' + res );

			var prods = responce_data.prodlist;

			var costarr = new Array(prods.length);

			list_obj.options.length = 0;
			for( var i=0; i<prods.length; i++ )
			{
				try
				{
					var newopt = new Option( prods[i].name, prods[i].id );
					list_obj.options[i] = newopt;
					costarr[i] = prods[i].cost;
				}
				catch(err)
				{
					alert( "item: " + i + "; error: " + err.description );
				}
			}

			prodcostarr[ind-1] = costarr;

   			hideItem( progress_id );
			showItemEx( obj_id, "inline" );

			// Enable all combos for select
	        for(var ic=1; ic<=maxcombo; ic++)
	        {
	        	var objcombo = uh_get_object(type_id_tpl + ic);
	        	objcombo.disabled = false;
	        }
		};

		//showProgress();
		//hideItem(obj_id);

		//alert('rcom=uh_com_prodlist&tid=' + type_id + '&lngid=1');

		AJAX.SendRequest('GET', 'rcom=uh_com_prodlist&tid=' + type_id + '&lngid=1', process_fn, null);
	}
}

function fillProductCost(cost_obj_id, ind, selind, selval)
{
	var cost_obj = uh_get_object( cost_obj_id );
	if( cost_obj == null )
		return;

	if( selval == 0 )
		cost_obj.value = "0.00";
	else
		cost_obj.value = prodcostarr[ind-1][selind];
}
