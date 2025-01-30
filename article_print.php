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


			$article_id = intval($_GET['article_id']);
			
			$query = $db->read_query("
									SELECT article.title, article.article, article.date, article.author_id,
									article.hits, author.name, author.image, author.email
									FROM articles as article, authors as author
									WHERE article.author_id = author.author_id
									AND article.active = 'Y'
									AND article.article_id = $article_id
									") or die($db->sql_error());
									
			$articleDetail = $db->sql_fetcharray($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>Köþe Yazýsý Yazdýr : <?=stripslashes(strip_tags($articleDetail[title]))?> | <?=$settings['site_title']?></title>
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
					  	<div class="author_image">
							<div><img src="images/authors/<?=$articleDetail[image]?>" width="150" height="170" /></div>
							<div class="about"><b><?=stripslashes($articleDetail[name])?></b></div>
							<div class="about"><?=stripslashes($articleDetail[email])?></div>
						</div>
						<div class="title"><?=stripslashes($articleDetail[title])?></div>
						<div class="br1pxdot"><img src="images/spacer.gif" /></div>
						<div class="date"><?php echo time_to_now($articleDetail[date]);?></div>
						<div class="br1pxdot"><img src="images/spacer.gif" /></div>
						<div class="detail content_12" id="text_detail"><?=stripslashes($articleDetail[article])?></div>
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