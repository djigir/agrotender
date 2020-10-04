// MyCalendar Library for popup calendar window
// Written by Alex Godunov
//

// Constructor
function myCalend(container_id, field_id, dt)
{
	this.today = dt;//new Date();
	this.sel_year = this.getYearValue(this.today);
	this.sel_month = this.today.getMonth();
	this.container_id = container_id;
	this.field_id = field_id;

	//alert('sss');}

// Return Year as 4 digit value
myCalend.prototype.getYearValue = function (dt)
{	var year_value = dt.getYear();

	if( year_value < 2000 )
		year_value = 1900 + year_value;

	return year_value;}

myCalend.prototype.drawMonthView = function ()
{	var div_obj = document.getElementById( this.container_id + 'cont' );
	if( !div_obj )
	{		alert('can not find calendar panel');
		return;
	}

	//alert( this.container_id );

	var cal_html = '';

	// Draw calendar head
	cal_html += '<table cellpadding="0" cellspacing="1" border="0" class="caltbl">\r\n';
	cal_html += '<tr>\r\n';
	cal_html += 	'<th class="calth" colspan="7">\r\n';
	cal_html += 		'<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr><td width="170" class="calth"><a class="callink1" href="javascript:showPrevMonth(' + this.sel_month + ', ' + this.sel_year + ', \'' + this.container_id + '\', \'' + this.field_id + '\');">&lt;&lt;</a> ';
	cal_html += 		' ' + this.getMonthName(this.sel_month) + ' ' + this.sel_year + ' ';
	cal_html += 		' <a class="callink1" href="javascript:showNextMonth(' + this.sel_month + ', ' + this.sel_year + ', \'' + this.container_id + '\', \'' + this.field_id + '\');">&gt;&gt;</a></td><td><a href="javascript:closeCalendarPopup(\'' + this.container_id + '\')" class="callink1">X</a></td></tr></table>\r\n';
	cal_html += 	'</th>\r\n';
	cal_html += '</tr><tr>\r\n';
	cal_html += 	'<th width="15%" class="calth">Пн</th>\r\n';
	cal_html += 	'<th width="14%" class="calth">Вт</th>\r\n';
	cal_html += 	'<th width="14%" class="calth">Ср</th>\r\n';
	cal_html += 	'<th width="14%" class="calth">Чт</th>\r\n';
	cal_html += 	'<th width="14%" class="calth">Пт</th>\r\n';
	cal_html += 	'<th width="14%" class="calth">Сб</th>\r\n';
	cal_html += 	'<th width="15%" class="calth">Вс</th>\r\n';
	cal_html += '</th>\r\n';

	// Draw week lines
 	var cur_day = new Date(this.sel_year, this.sel_month, 1);

 	cal_html += '<tr>\r\n';
 	for(i=1; i<this.getDayOfWeek(cur_day); i++)
 	{
 		cal_html += '<td>&nbsp;</td>'; 	}

 	var days_in_month = this.getDaysInMonth(cur_day);
 	var last_month_day_week_value = 0;

 	for(i=1; i<=days_in_month; i++)
 	{		var this_day = new Date(this.sel_year, this.sel_month, i);
		var this_day_str = this.makeDateStr(this_day);
		var this_day_ru = this.makeDateStrRu(this_day);

		cal_html += '<td class="caltd"><a href="javascript:chooseDate(\'' + this_day_str + '\', \'' + this_day_ru + '\', \'' + this.container_id + '\', \'' + this.field_id + '\');" class="callink">' + i + '</a></td>\r\n';

		if( this.getDayOfWeek(this_day) == 7 )
		{			cal_html += '</tr>';
			if( i != days_in_month )
				cal_html += '<tr>';		}

		if( i == days_in_month )
			last_month_day_week_value = this.getDayOfWeek(this_day); 	}

 	// Now we should fill the last line to the end
 	for(i=last_month_day_week_value; i<7; i++)
 	{
 		cal_html += '<td>&nbsp;</td>'; 	}

 	if( last_month_day_week_value != 7 )
 		cal_html += '</tr>';

	// Draw calendar foot
	cal_html += '</table>\r\n';

	div_obj.innerHTML = cal_html;}

// Return TRUE or FALSE if year leap
myCalend.prototype.isLeapYear = function (dt)
{
	// this such type of constant	var leap_etalon = 2000;

	var dt_year = parseInt(this.getYearValue(dt));

	if( dt_year % 4 == 0 )
		return true;

	return false;}

// Return number of days in current month
myCalend.prototype.getDaysInMonth = function (dt)
{
	var days_in_months = new Array(31,28,31,30,31,30,31,31,30,31,30,31);	var current_month = dt.getMonth();

	// Check if it is february in leap year
	if( (current_month == 1) && this.isLeapYear(dt) )
		return 29;

	return days_in_months[current_month];}

// Return day of week as value 1..7 starting from monday
myCalend.prototype.getDayOfWeek = function (dt)
{	var day_of_week = dt.getDay();
	return (day_of_week == 0 ? 7 : day_of_week);}

// Get month name
myCalend.prototype.getMonthName = function (month_ind)
{	var month_names = new Array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");

	return month_names[month_ind];}

// Make date in format of DD.MM.YYYY
myCalend.prototype.makeDateStr = function (dt)
{	var dt_str = "";

	var dd = dt.getDate();
	var dm = dt.getMonth()+1;
	var dy = this.getYearValue(dt);

	dt_str = (dd < 10 ? "0" + dd : dd) + "." + (dm < 10 ? "0" + dm : dm) + "." + dy;

	return dt_str;}

myCalend.prototype.makeDateStrRu = function (dt)
{
	var montharr = new Array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
	var dt_str = "";

	var dd = dt.getDate();
	var dy = this.getYearValue(dt);

	dt_str = (dd < 10 ? "0" + dd : dd) + " " + montharr[dt.getMonth()] + " " + dy;

	return dt_str;
}

function showCalendarPopup( cal_id, inp_id, link_obj, picbtn_id )
{
	var div_cal = document.getElementById( cal_id );
	var inp_cal = document.getElementById( inp_id );
	//var pic_cal = uh_get_object( picbtn_id );

	if( !div_cal || !inp_cal )
	{
		alert('Невозможно отобразить календарь, выполните ввод даты вручную в формате ДД.ММ.ГГГГ');
		return;
	}

	//div_cal.style.position = "absolute";
	div_cal.style.visibility = "visible";
	div_cal.style.display = "block";
	div_cal.style.clientWidth = "200px";
	div_cal.style.clientHeight = "200px";
	//div_cal.style.zIndex = "21";
	//div_cal.screenTop = link_obj.screenTop + 20;
	//div_cal.style.leftPixel = link_obj.leftPixel

	/*
	var s = "";
  	for( par in pic_cal )
  	{  		s += par + ": " + pic_cal[par] + " --- ";  	}
  	alert( s );
  	*/

	var dt_today = new Date();
	var cur_dt = new myCalend( cal_id, inp_id, dt_today );
	cur_dt.drawMonthView();}

function closeCalendarPopup( cal_id )
{
	var div_cal = document.getElementById( cal_id );

	if( !div_cal )
		return;

	//alert('Close calendar');

	//div_cal.style.position = "absolute";
	div_cal.style.visibility = "hidden";
	div_cal.style.display = "none";
}

function chooseDate(dt_value,dt_value_ru,cal_id,txt_id)
{
	//var div_cal = document.getElementById( cal_id );
	var txt_cal = document.getElementById( txt_id );
	var link_cal = document.getElementById( txt_id+'link' );
	if( link_cal )
		link_cal.innerHTML = '<span>'+dt_value_ru+'</span>';

	txt_cal.value=dt_value;
	closeCalendarPopup( cal_id );

	// add for agrotorg
	showCalcTimeDiap();
}

function showNextMonth(dm, dy, cal_id, inp_id)
{
	moveMonth(dm, dy, 1, cal_id, inp_id);
}

function showPrevMonth(dm, dy, cal_id, inp_id)
{
	moveMonth(dm, dy, -1, cal_id, inp_id);
}

function moveMonth(dm, dy, off, cal_id, inp_id)
{
	var new_mon = dm + off;
	if( new_mon < 0 )
	{
		new_mon = 11;
		dy -= 1;
	}
	else if( new_mon > 11 )
	{		new_mon = 0;
		dy += 1;	}
	var dt_today = new Date( dy, new_mon, 1 );
	var cur_dt = new myCalend( cal_id, inp_id, dt_today );
	cur_dt.drawMonthView();}

/*
function checkDateInp( frm )
{
	var dst = null; //frm.datest.value;
	var den = null;	//frm.dateen.value;

	if( !dst || !den )
		return false;

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
*/
