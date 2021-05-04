var this_domain_name = "http://avtorad.ukrdomen.com/";
function voidfn(val)
{
	var i = val;
}

function dovoid()
{
	return false;
}

function sendMail(link, l1, h1, h2)
{
	mailto = l1;
	mailto +="@";
	mailto += h1;
	mailto += '.';
	mailto += h2;

    link.href = "mailto:"+mailto;
    return true;
}

// Basic utils
function uh_get_object(obj_id)
{
	var obj_var = null;

	if( document.all )
		obj_var = document.all(obj_id);
    else if (document.getElementById)
		obj_var = document.getElementById(obj_id);
	else if(document.layers)
		obj_var = document.layers[obj_id];

    if( obj_var )
    	return obj_var;

    alert('Error retrieve object handle by id: ' + obj_id);
}


////////////////////////////////////////////////////////////////////////////////
// Encoding Utils
function escapeEx(str)
{
    var ret = '';

	var i = 0;
    for (var i=0; i<str.length; i++)
    {
        var n = str.charCodeAt(i);
        if (n >= 0x410 && n <= 0x44F)
            n -= 0x350;
        else if (n == 0x451)
            n = 0xB8;
        else if (n == 0x401)
            n = 0xA8;
        if ((n < 65 || n > 90) && (n < 97 || n > 122) && n < 256)
        {
            if (n < 16)
                ret += '%0'+n.toString(16);
            else
                ret += '%'+n.toString(16);
        }
        else
            ret += String.fromCharCode(n);
    }

    return ret;
}

///////////////////////////////////////////////////////////////////////////////
// Base 64 utils

// This code was written by Tyler Akins and has been placed in the
// public domain.  It would be nice if you left this header intact.
// Base64 code from Tyler Akins -- http://rumkin.com

var keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

function encode64(input) {
   var output = "";
   var chr1, chr2, chr3;
   var enc1, enc2, enc3, enc4;
   var i = 0;

   var line_len = 0;

   do {
      chr1 = input.charCodeAt(i++);
      chr2 = input.charCodeAt(i++);
      chr3 = input.charCodeAt(i++);

      enc1 = chr1 >>> 2;
      if( !isNaN(chr2) )
      	enc2 = ((chr1 & 3) << 4) | (chr2 >>> 4);
      else
      	enc2 = ((chr1 & 3) << 4);

      if( !isNaN(chr3) )
      	enc3 = ((chr2 & 15) << 2) | (chr3 >>> 6);
      else
      	enc3 = ((chr2 & 15) << 2);
      enc4 = chr3 & 63;

      if (isNaN(chr2)) {
         enc3 = enc4 = 64;
      } else if (isNaN(chr3)) {
         enc4 = 64;
      }

      output = output + keyStr.charAt(enc1);
      output = output + keyStr.charAt(enc2);
      output = output + keyStr.charAt(enc3);
      output = output + keyStr.charAt(enc4);

	/*
      line_len += 4;
      if(line_len >= 72)
      {
      	line_len = 0;
      	output = output + '\r\n';
      }
 	*/

   } while (i < input.length);

   //alert("len: " + output.length + "; " + output);

   return output;
}

function decode64(input) {
   var output = "";
   var chr1, chr2, chr3;
   var enc1, enc2, enc3, enc4;
   var i = 0;

   // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
   input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

   do {
      enc1 = keyStr.indexOf(input.charAt(i++));
      enc2 = keyStr.indexOf(input.charAt(i++));
      enc3 = keyStr.indexOf(input.charAt(i++));
      enc4 = keyStr.indexOf(input.charAt(i++));

      chr1 = (enc1 << 2) | (enc2 >> 4);
      chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
      chr3 = ((enc3 & 3) << 6) | enc4;

      output = output + String.fromCharCode(chr1);

      if (enc3 != 64) {
         output = output + String.fromCharCode(chr2);
      }
      if (enc4 != 64) {
         output = output + String.fromCharCode(chr3);
      }
   } while (i < input.length);

   return output;
}

// other
function generateSessionID()
{
	charStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	var sessionId = "";

	for(i=0; i<12; i++)
	{
		sessionId += charStr.charAt( Math.floor(Math.random()*charStr.length) );
	}

	return sessionId;
}

// UI utils

function hideItem(itid)
{
	var obj_it = uh_get_object(itid);
	obj_it.style.visibility = "hidden";
	obj_it.style.display = "none";
}

function showItem(itid)
{
	var obj_it = uh_get_object(itid);
	obj_it.style.visibility = "visible";
	obj_it.style.display = "block";
}

function showItemEx(itid, mod)
{
	var obj_it = uh_get_object(itid);
	obj_it.style.visibility = "visible";
	obj_it.style.display = mod;
}
