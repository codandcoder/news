
<!--

function Popup(href, target, width, height)
{
	var winl = (screen.width - width) / 2;
	var wint = (screen.height - height) / 2;
	window.open(href, target, 'width = '+width+', height=' + height +', top=' + wint + ',left=' + winl + ', toolbar=0, location=0, directories=0, status=1, menuBar=0, scrollBars=1, resizable=0');
	return false;
}
//-->

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


function deleteConfirm()
{
	var restart = confirm("Bu Kay�t� Silmek �stedi�inizden Emin misiniz?");
	if(restart)
		return true;
	else
		return false;
}
function deleteConfirm_1()
{
	var restart = confirm("Bu Kay�t� ve Bu Kay�ta ait Linkleri Silmek �stedi�inizden Emin misiniz?");
	if(restart)
		return true;
	else
		return false;
}
function deleteConfirm_2()
{
	var restart = confirm("Bu Kay�t� ve Bu Kay�ta ait Haberleri Silmek �stedi�inizden Emin misiniz?");
	if(restart)
		return true;
	else
		return false;
}
function deleteConfirm_3()
{
	var restart = confirm("Bu Yazar� ve Bu Yazar� ait Yaz�lar� Silmek �stedi�inizden Emin misiniz?");
	if(restart)
		return true;
	else
		return false;
}
function deleteConfirm_4()
{
	var restart = confirm("Bu Gazeteyi ve Gazeteye ait Resimleri Silmek �stedi�inizden Emin misiniz?");
	if(restart)
		return true;
	else
		return false;
}

function deleteAllConfirm()
{
	var restart = confirm("T�m Kay�tlar� Silmek �stedi�inizden Emin misiniz?");
	if(restart)
		return true;
	else
		return false;
}
function valButton(btn)
{
	var cnt = -1;
	for (var i=0; i < btn.length; i++)
	{
		if (btn[i].checked)
		{
			cnt = i;
			i = btn.length;
		}
	}
	if (cnt > -1)
		return btn[cnt].value;
	else
		return null;
}

function validateMultipleSelect(SS)
{
    
    for (var iCount=0; SS.options[iCount]; iCount++)
	{
        if (SS.options[iCount].selected)
		{
            return false;
        }
    }
    return true;
}

function clearMultipleSelect(SS)
{
	sOptions = document.getElementById(SS);
	for (var iCount=0; sOptions.options[iCount]; iCount++)
	{
        sOptions.options[iCount].selected = false;
    }
}
function OpenWindow(windowURL, windowName, windowFeatures)
{
	//alert("asd");
	window.open(windowURL, windowName, windowFeatures);
}
function InvalidPassword(elm)
{
	if (elm.value.length < 6)
		return true;
	else
		return false;
}
function InvalidEmail(elm)
{
	if (elm.value.indexOf("@") <= 0 || elm.value.indexOf(".") <= 0 || elm.value.indexOf("@.") > 0 || elm.value.indexOf(".@") > 0)
		return true;
	else
		return false;
}