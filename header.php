<?php
//
// +---------------------------------------------------------------------------+
// | NizipRehber Haber Portal� v1.0 [ nrnews_v1.0 ]                            |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Gereksininimleri   : PHP 4 veya �zeri, GD2+ k�t�phanesi                   |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Geli�tirici    	: Mahmut �ZDEM�R                                       |
// | E-posta        	: mahmuttt88 {at} yahoo {dot} com                      |
// | Web adresi     	: http://www.mahmutozdemir.org/       	               |
// | Tel		     	: +90 5373622826 / +90 5457604888 / +90 5543184701     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Copyright (C) 2007                                                        |
// |                                                                           |
// | Bu Yaz�l�m �CRETS�Z DE��LD�R. Yaz�l�m�n T�m Haklar� Mahmut �ZDEM�R'e      |
// | aittir.															       |
// |                                                                           |
// +---------------------------------------------------------------------------+
//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ �ncler Yap�l�yor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
	
	include("config.php");	
	include("includes/includes.php");
	
	$reklam = new nrReklam;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="haber, antep, nizip, zeugma, f�rat, okul, e�itim, egitim, �niversite, universite, osym, mezun, defter, haber, gazete, haberciler, turkiye, turkey, haberler, gazete, daily news, news , sports news, daily newspaper, newspaper, basin, press, journal, international, journalist, muhabir,  yazar, sayfa , spor, sports, soccer, futbol, basketball, basketbol, volleyball, voleybol, at yarisi, horse racing, fenerbahce,  galatasaray, besiktas, trabzonspor, cimbom, fener, karakartal, mahmutozdemir, mahmut �zdemir" 
name=keywords>
<meta content="nizip haber sitesi" name=description>
<meta content="nizip, nizip medya, mahmut" name=Author>
<meta content=index,follow name=robots>
<meta content="1 DAYS" name=revisit-after>
<meta content=all name=audience>
<meta content="haber, news, portal, yorum, blog" name=category>
<meta content="� 2007 yirmiyedi.net. T�m hakk� sakl�d�r." name=copyright>
<meta content="Mahmut �ZDEM�R" name=publisher>
<meta content="niziprehber.com" name=identifier-url>
<meta content="NizipRehber" name=organization>
<meta content=information name=page-type>
<meta http-equiv=Content-Type content="text/html; charset=iso-8859-9">
<meta http-equiv=Content-Language content=tr>
<meta http-equiv=Cache-Control content=no-cache>
<meta content=no-cache name=Pragma>
<link href="css/style.css" type="text/css" rel="stylesheet" />
<LINK title=RSS href="./rss/index.php" type=application/rss+xml rel=alternate>
<script src="css/function.js" type="text/javascript"></script>
<title><?=$settings['site_title']?> | <?=$settings['site_slogan']?> </title>
</head>

<body>
<table class="body" width="770" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td class="leftright" height="70" valign="top">
	<div id="header_author">
	<!-- Yazarlar -->
				<?php
				$query = $db->write_query("
											SELECT author_id, name, image
											FROM authors
											ORDER BY author_order ASC
											LIMIT 5
											");
											
				while($row = $db->sql_fetcharray($query)){
				
					$qquery = $db->read_query("
												SELECT article_id, title
												FROM articles
												WHERE author_id = $row[author_id]
												AND active = 'Y'
												ORDER BY date DESC
												LIMIT 1
												");
												
					$rrow = $db->sql_fetcharray($qquery);
					
					if($rrow[title]){
					$article = "<a href=\"author_article_detail.php?article_id=".$rrow[article_id]."\">".stripslashes($rrow[title])."</a>";
					}else{
					$article = "Hen�z Yaz� Eklenmemi�";
					}
				?>
				<div class="author_box">
					<div class="image"><img src="images/authors/th_<?=$row[image]?>" width="38" height="46" /></div>
					<div class="text"><b class="authorName"><?php echo stripslashes($row[name]);?></b><br /><?=$article?></div>
				</div>
				<?php
				}
				?>
	
	</div>
	</td>
  </tr>
  <tr>
    <td class="leftright">
	<div id="header">
		<div class="logo"><a href="index.php"><img src="images/spacer.gif" height="85" width="240" /></a></div>
		<div class="banner"><?php echo $reklam->reklamGoster('ust');?></div>
	</div></td>
  </tr>
  <tr>
    <td height="20" class="leftright" valign="top">
	<div class="header_menu">
		<div class="date"><?php echo time_to_now(time());?></div>
		<div class="item"><a href="add_lastmin.php">Sitene Sondakika Ekle</a> </div>
		<div class="item"><a href="page_detail.php?page_id=2">K�nye</a></div>
		<div class="item"><a href="page_detail.php?page_id=3">Reklam</a></div>
		<div class="item"><a href="contact.php">�leti�im</a></div>
		<div class="item"><b><a href="rss/index.php" target="_blank">RSS</a></b></div>
	</div>
	</td>
  </tr>
</table>
