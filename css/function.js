
/* Manþet Göster */

function getCuff(index)
	{
		var n = 10;
		for(i=0 ; i<n ; i++)
		{
			
			if(i == index)
			{
				menuid="title"+i;
				document.getElementById(menuid).style.display = "block";
				menuid="image"+i;
				document.getElementById(menuid).style.display = "block";
				menuid="spot"+i;
				document.getElementById(menuid).style.display = "block";
			}
			else
			{
				menuid="title"+i;
				document.getElementById(menuid).style.display = "none";
				menuid="image"+i;
				document.getElementById(menuid).style.display = "none";
				menuid="spot"+i;
				document.getElementById(menuid).style.display = "none";
			}
		}
}

function textareaCounter(t, counterField, textLimit){ 
var textLength = t.value.length; 
var counterInput = document.getElementById(counterField); 
if(textLength > textLimit){ 
alert("En Fazla " + textLimit + " karakter girebilirsiniz."); 
t.value=t.value.substring(0,textLimit); 
} 
counterInput.value = (textLimit-parseInt(t.value.length)); 
}

/* Textarea Yazý Limiti */

function validateLength(el, word_left_field, len)
{
	document.all[word_left_field].value = len - el.value.length;
	if(document.all[word_left_field].value < 1)
	{
		alert("En Fazla " + len + " karakter girebilirsiniz.");
		el.value = el.value.substr(0, len);
		document.all[word_left_field].value = 0;
		return false;
	}
	return true;
}

/* Yazý Boyutu Deðiþtir */

function changeSize(elm, _size, class_name)
{
	document.getElementById(elm).className = class_name + ' ' + class_name + '_' + _size;
}

/**/

function changeTarget(elm)
{
	tmp = elm.getElementsByTagName("a");
	for(i=0; i<tmp.length; i++)
		tmp[i].target = "_blank";
}

/**/

function openPopUp_520x390(href, target)
{
	var winl = (screen.width - 520) / 2;
	var wint = (screen.height - 390) / 2;
	window.open(href, target, 'width=520, height=390, top=' + wint + ', left=' + winl + ', toolbar=0, location=0, directories=0, status=1, menuBar=0, scrollBars=1, resizable=0');
	return false;
}

/**/

function openPopUp(href, target)
{
	var winl = (screen.width - 600) / 2;
	var wint = (screen.height - 450) / 2;
	window.open(href, target, 'width=600, height=450, top=' + wint + ', left=' + winl + ', toolbar=0, location=0, directories=0, status=1, menuBar=0, scrollBars=1, resizable=0');
	return false;
}

/**/

function userPopup(href, target, width, height)
{
	var winl = (screen.width - width) / 2;
	var wint = (screen.height - height) / 2;
	window.open(href, target, 'width = '+width+', height=' + height +', top=' + wint + ',left=' + winl + ', toolbar=0, location=0, directories=0, status=1, menuBar=0, scrollBars=1, resizable=0');
	return false;
}

/**/

function goNews(idx)
{
	return openPopUp('./news_detail.php?id=' + idx, '');
}

/**/

function goInterviews(idx)
{
	return openPopUp('./interview_detail.php?interview_id=' + idx, '');
}

/**/

function goAuthor(idx)
{
	return openPopUp('./author_article_detail.php?article_id=' + idx, '');
}

/**/

function changeArticle(idx)
{
	return window.location = "./author_article_detail.php?article_id=" + idx;
}

/**/

function blinkIt()
{
	if(!document.all)
		return;
	else
	{
		for(i=0; i<document.all.tags('blink').length; i++)
		{
			s=document.all.tags('blink')[i];
			s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';
		}
	}
}


function getSWF(swWidth, swHeight, swFile, swWmode)
{
	var str = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width='+swWidth+'  height='+swHeight+'>';
	str += ' <param name="movie" value="'+swFile+'" /> ';
	str += ' <param name="quality" value="high" /> ';
	str += ' <param name="wmode" value="'+swWmode+'" /> ';
	str += ' <embed src='+swFile+' width='+swWidth+' height='+swHeight+' quality="high" pluginspage="http://www .macromedia.com/go/getflashplayer" type="application/x-shoc kwave-flash" wmode="transparent"></embed> ';
	str += ' </object> ';
	document.write(str);
}
function SymError()
{
	return true;
}
function whichBrowser()
{
	var agt = navigator.userAgent.toLowerCase();
	if (agt.indexOf("opera") != -1)
		return 'Opera';
	if (agt.indexOf("staroffice") != -1)
		return 'Star Office';
	if (agt.indexOf("webtv") != -1) 
		return 'WebTV';
	if (agt.indexOf("beonex") != -1)
		return 'Beonex';
	if (agt.indexOf("chimera") != -1)
		return 'Chimera';
	if (agt.indexOf("netpositive") != -1)
		return 'NetPositive';
	if (agt.indexOf("phoenix") != -1)
		return 'Phoenix';
	if (agt.indexOf("firefox") != -1)
		return 'Firefox';
	if (agt.indexOf("safari") != -1)
		return 'Safari';
	if (agt.indexOf("skipstone") != -1)
		return 'SkipStone';
	if (agt.indexOf("msie") != -1)
		return 'MSIE';
	if (agt.indexOf("netscape") != -1)
		return 'Netscape';
	if (agt.indexOf("mozilla/5.0") != -1)
		return 'Mozilla';
	if (agt.indexOf('\/') != -1)
	{
		if (agt.substr(0,agt.indexOf('\/')) != 'mozilla') 
		{
			return navigator.userAgent.substr(0,agt.indexOf('\/'));
		}
		else
			return 'Netscape';
	}
	else if (agt.indexOf(' ') != -1)
		return navigator.userAgent.substr(0,agt.indexOf(' '));
	else
		return navigator.userAgent;
}
function Set_Cookie( name, value, expires, path, domain, secure ) 
{
	var today = new Date();
	today.setTime( today.getTime() );

	if ( expires )
	{
		expires = expires * 1000 * 60 * 60 * 24;
	}
	var expires_date = new Date( today.getTime() + (expires) );

	document.cookie = name + "=" + escape( value ) +
		( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
		( ( path ) ? ";path=" + path : "" ) + 
		( ( domain ) ? ";domain=" + domain : "" ) +
		( ( secure ) ? ";secure" : "" );
}
function Get_Cookie( name )
{
	var start = document.cookie.indexOf( name + "=" );
	var len = start + name.length + 1;
	if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) )
	{
		return null;
	}
	if ( start == -1 )
		return null;
	var end = document.cookie.indexOf( ";", len );
	if ( end == -1 )
		end = document.cookie.length;
	return unescape( document.cookie.substring( len, end ) );
}
function Delete_Cookie( name, path, domain )
{
	if ( Get_Cookie( name ) )
		document.cookie = name + "=" +
			( ( path ) ? ";path=" + path : "") +
			( ( domain ) ? ";domain=" + domain : "" ) +";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}


function changeMostlyTab(idx)
{
	if(idx == 1)
	{
		document.getElementById("mostly_readed").style.display = 'block';
		document.getElementById("mostly_commented").style.display = 'none';
	}
	else
	{
		document.getElementById("mostly_readed").style.display = 'none';
		document.getElementById("mostly_commented").style.display = 'block';
	}
}
function heightOptimizer()
{
	var _height = document.getElementById('base_middle').offsetHeight;
	
	if(_height < document.getElementById('base_right').offsetHeight)
		_height = document.getElementById('base_right').offsetHeight;
	
	document.getElementById('base').style.height = _height + "px";
	document.getElementById('base_middle').style.height = _height + "px";
	document.getElementById('base_right').style.height = _height + "px";
}
function changeTarget(elm)
{
	tmp = elm.getElementsByTagName("a");
	for(i=0; i<tmp.length; i++)
		tmp[i].target = "_blank";
}
function changeSize(elm, _size, class_name)
{
	document.getElementById(elm).className = class_name + ' ' + class_name + '_' + _size;
	Set_Cookie('text_size', _size, 30, '', '', '');
}
function drawTopMenu(menuitem, active_page)
{
	i = 0;
	str = '';
	sep_class = "sep";
	item_class = "item";
	
	var	total_menu = menuitem.length;
		
	for (i=0; i < total_menu; i++)
	{
		if(active_page == i)
		{
			sep_class = "active_sep_1";
			item_class = "active_item";
		}
		
		if(i == 0 && sep_class != "active_sep_1")
			str += '<div class="sep_first"></div>';
		
		if( !(i == 0 && sep_class == "sep"))
			str += '<div class="' + sep_class + '"></div>';
		
		str += '<div id="headline_nav_page_' + i + '" class="' + item_class + '"><a href="javascript:;" onclick="changeHeadlineTab(' + i + ')">' + menuitem[i] + '</a></div>';
		
		if( i == total_menu - 1 && sep_class == "active_sep_1" )
			str += '<div class="active_sep_2"></div>';
		
		if(active_page == i)
			sep_class = "active_sep_2";
		else
			sep_class = "sep";
		
		item_class = "item";
	}
	i = null;
	sep_class = null;
	item_class = null;
	
	return str;	
}
function changeHeadlineTab(idx)
{
	if(prevHeadlineTab == idx)
		return;
	
	document.getElementById('headline_nav').innerHTML = drawTopMenu(menuitem, idx);
	document.getElementById('headline_item_' + idx).style.display = 'block';
	if(prevHeadlineTab != "-1")
	{
		document.getElementById('headline_item_' + prevHeadlineTab).style.display = 'none';
	}
	prevHeadlineTab = idx;
}
function SymError()
{
	return true;
}


function changeStyle(elm, style_name)
{
	document.getElementById(elm).href = 'css/'+style_name+'/style.css';
	Set_Cookie('css',style_name);
}