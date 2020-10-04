function NewWindow(winname)
{
	var comwin = window.open(winname,'Memo','width=500,height=400,scrollbars=yes,resize=no,toolbar=no,status=no,menubar=no,location=no,directories=no');
    comwin.focus();
}

function checkDateInp( frm )
{
	var dst = frm.datest.value;
	var den = frm.dateen.value;

	if( (dst.charAt(2) != '.') || (dst.charAt(5) != '.') )
	{
		alert('Начальная дата указана с ошибками.');
		return false;
	}

	if( (den.charAt(2) != '.') || (den.charAt(5) != '.') )
	{
		alert('Конечная дата указана с ошибками.');
		return false;
	}

	// check if dates is in possible diapasone
	dst_d = dst.substring(0,2);
	dst_m = dst.substring(3,5);
	dst_y = dst.substring(6,10);

	dst_dn = parseInt(dst_d, 10);
	dst_mn = parseInt(dst_m, 10);
	dst_yn = parseInt(dst_y, 10);

	if( isNaN(dst_dn) )
	{
		alert('Начальная дата указана с ошибками. День не является числовым значением.');
		return false;
	}

	if( isNaN(dst_mn) )
	{
		alert('Начальная дата указана с ошибками. Месяц не является числовым значением.');
		return false;
	}

	if( isNaN(dst_yn) )
	{
		alert('Начальная дата указана с ошибками. Год не является числовым значением.');
		return false;
	}

	if( (dst_dn <= 0) || (dst_dn > 31) )
	{
		alert('Начальная дата указана с ошибками. День не может иметь указанное значение.');
		return false;
	}

	if( (dst_mn <= 0) || (dst_mn > 12) )
	{
		alert('Начальная дата указана с ошибками. Месяц не может иметь указанное значение.');
		return false;
	}

	if( (dst_yn <= 1995) || (dst_yn > 2015) )
	{
		alert('Начальная дата указана с ошибками. Год не может иметь указанное значение.');
		return false;
	}

	// check if dates is in possible diapasone
	den_d = den.substring(0,2);
	den_m = den.substring(3,5);
	den_y = den.substring(6,10);

	den_dn = parseInt(den_d, 10);
	den_mn = parseInt(den_m, 10);
	den_yn = parseInt(den_y, 10);

	//alert( den_d + " : " + den_dn + " - " + den_m + " : " + den_mn + " - ");

	if( isNaN(den_dn) )
	{
		alert('Конечная дата указана с ошибками. День не является числовым значением.');
		return false;
	}

	if( isNaN(den_mn) )
	{
		alert('Конечная дата указана с ошибками. Месяц не является числовым значением.');
		return false;
	}

	if( isNaN(den_yn) )
	{
		alert('Конечная дата указана с ошибками. Год не является числовым значением.');
		return false;
	}

	if( (den_dn <= 0) || (den_dn > 31) )
	{
		alert('Конечная дата указана с ошибками. День не может иметь указанное значение.');
		return false;
	}

	if( (den_mn <= 0) || (den_mn > 12) )
	{
		alert('Конечная дата указана с ошибками. Месяц не может иметь указанное значение.' + den_mn);
		return false;
	}

	if( (den_yn <= 1995) || (den_yn > 2015) )
	{
		alert('Конечная дата указана с ошибками. Год не может иметь указанное значение.');
		return false;
	}

	return true;
}

function OpenPopup(url, width, height){
  newwindow = window.open(url,"calendarwnd","toolbar=no,status=no,resizable=no,location=no,toolbar=no,menubar=no,width=" + width + ",height=" + height);
  newwindow.focus();
}

function DateChoose(filename,target){
  var self = window.opener.document;
  var inputId = target.split('.');
  var input = self.getElementById(inputId[inputId.length - 1]);
  input.value=filename;
  window.opener.focus();
  window.close();
}
