var AJAX_CLIENT_HOST = "";
var AJAX_CLIENT_PATH = "/admin/";
var AJAX_CLENT_FULLURL = AJAX_CLIENT_HOST + AJAX_CLIENT_PATH;

//var AJAX = new myAjax(AJAX_CLIENT_HOST + AJAX_CLIENT_PATH + 'galery_data.ashx');
var AJAX = new myAjax(AJAX_CLIENT_HOST + AJAX_CLIENT_PATH + 'ajx/ajx_proxy.php');
var AJAX_REQUEST_CHAR_CODE = 1;	// 1 should be used for PHP, 2 - for ASP.NET;
