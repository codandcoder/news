<?php

//
// +---------------------------------------------------------------------------+
// | NizipRehber Haber Portalý v1.0 [ nrnews_v1.0 ]                            |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Gereksininimleri   : PHP 4 veya üzeri, GD2+ kütüphanesi                   |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Geliþtirici    	: Mahmut ÖZDEMÝR                                       |
// | E-posta        	: mahmuttt88 {at} yahoo {dot} com                      |
// | Web adresi     	: http://www.mahmutozdemir.org/       	               |
// | Tel		     	: +90 5373622826 / +90 5457604888 / +90 5543184701     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Copyright (C) 2007                                                        |
// |                                                                           |
// | Bu Yazýlým ÜCRETSÝZ DEÐÝLDÝR. Yazýlýmýn Tüm Haklarý Mahmut ÖZDEMÝR'e      |
// | aittir.															       |
// |                                                                           |
// +---------------------------------------------------------------------------+
//

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ Ýncler Yapýlýyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
	
	include("config.php");	
	include("includes/includes.php");


			$id = intval($_GET['id']);
	
	
			$query = $db->read_query("
									SELECT news.title, news.spot, news.image,
									news.detail, news.date, news.hits, cats.category
									FROM news, cats
									WHERE news.cid = cats.cid AND news.active = 'Y' AND news.id = $id
									") or die($db->sql_error());
									
			$newsDetail = $db->sql_fetcharray($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>Haber Yazdýr : <?=stripslashes(strip_tags($newsDetail[title]))?> | <?=$settings['site_title']?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="javascripts/function.js" type=text/javascript></script>
<script>
function printPage()
{
	document.all["hidden_01"].style.display = "none";
	window.print();
	document.all["hidden_01"].style.display = "block";
	return false;
}

</script><style>
BODY{
background:#FFFFFF;
}
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
					<tr>
					  <td>
					  <div id="article_detail">
					  	<div class="newsImage">
							<div><img src="images/news/<?=$newsDetail[image]?>" width="260" height="180" /></div>
						</div>
						<div class="title"><?=stripslashes($newsDetail[title])?></div>
						<div class="br1pxdot"><img src="images/spacer.gif" /></div>
						<div class="date"><?php echo time_to_now($newsDetail[date]);?></div>
						<div class="br1pxdot"><img src="images/spacer.gif" /></div>
						<div class="detail content_12" id="text_detail">
						<b><?=stripslashes($newsDetail[spot])?></b><br /><br />
						<?=stripslashes($newsDetail[detail])?>
						</div>
					  </div>
					  </td>
					</tr>
						<tr id="hidden_01">
		<td align="center" style="padding: 10 0 10 0;"><input name="print" type="button" class="mainButton" style="height: 22px;  font: 11px tahoma, verdana; font-weight: bold;" onClick="return printPage();" value="   Yazdýr   ">
	  </td>
	</tr>
</table>		
</body>
</html>
<?php
ob_end_flush();
?>